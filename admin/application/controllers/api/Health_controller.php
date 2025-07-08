<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Health Check Controller for Production Monitoring
 * Provides endpoints for monitoring system health and status
 */
class Health_controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->currentTime = date('Y-m-d H:i:s', time());
        $this->apikey = getenv('BASTIAN_API_KEY') ?: '123456789';
        
        // Load required models
        $this->load->model('form_model');
        $this->load->database();
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
    }
    
    /**
     * Basic health check endpoint
     * Returns system status and basic information
     */
    public function index() {
        $health = array(
            'status' => 'healthy',
            'timestamp' => $this->currentTime,
            'version' => '1.0.0',
            'environment' => ENVIRONMENT,
            'php_version' => PHP_VERSION,
            'memory_usage' => $this->formatBytes(memory_get_usage(true)),
            'uptime' => $this->getSystemUptime()
        );
        
        http_response_code(200);
        $this->output->set_content_type('application/json')->set_output(json_encode($health));
    }
    
    /**
     * Detailed health check with database and external service status
     */
    public function detailed() {
        $token = $this->input->get_request_header('Authorization');
        if ($this->apikey !== $token) {
            http_response_code(401);
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status' => 'unauthorized',
                'message' => 'Invalid API key'
            )));
            return;
        }
        
        $health = array(
            'status' => 'healthy',
            'timestamp' => $this->currentTime,
            'checks' => array(
                'database' => $this->checkDatabase(),
                'eatapp_api' => $this->checkEatAppAPI(),
                'production_backend' => $this->checkProductionBackend(),
                'disk_space' => $this->checkDiskSpace(),
                'memory' => $this->checkMemoryUsage(),
                'recent_reservations' => $this->checkRecentReservations()
            )
        );
        
        // Determine overall status
        $allHealthy = true;
        foreach ($health['checks'] as $check) {
            if ($check['status'] !== 'healthy') {
                $allHealthy = false;
                break;
            }
        }
        
        $health['status'] = $allHealthy ? 'healthy' : 'degraded';
        
        http_response_code($allHealthy ? 200 : 503);
        $this->output->set_content_type('application/json')->set_output(json_encode($health));
    }
    
    /**
     * Check database connectivity and performance
     */
    private function checkDatabase() {
        try {
            $start = microtime(true);
            $query = $this->db->query("SELECT 1 as test");
            $end = microtime(true);
            
            if ($query && $query->num_rows() > 0) {
                return array(
                    'status' => 'healthy',
                    'response_time_ms' => round(($end - $start) * 1000, 2),
                    'message' => 'Database connection successful'
                );
            } else {
                return array(
                    'status' => 'unhealthy',
                    'message' => 'Database query failed'
                );
            }
        } catch (Exception $e) {
            return array(
                'status' => 'unhealthy',
                'message' => 'Database connection failed: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Check EatApp API connectivity
     */
    private function checkEatAppAPI() {
        try {
            $url = 'https://api.eat-sandbox.co/concierge/v2/restaurants';
            $headers = array(
                'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0',
                'X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910',
                'Accept: application/json'
            );
            
            $start = microtime(true);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $end = microtime(true);
            curl_close($ch);
            
            if ($httpCode === 200) {
                return array(
                    'status' => 'healthy',
                    'response_time_ms' => round(($end - $start) * 1000, 2),
                    'message' => 'EatApp API accessible'
                );
            } else {
                return array(
                    'status' => 'unhealthy',
                    'message' => 'EatApp API returned status: ' . $httpCode
                );
            }
        } catch (Exception $e) {
            return array(
                'status' => 'unhealthy',
                'message' => 'EatApp API check failed: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Check production backend connectivity
     */
    private function checkProductionBackend() {
        try {
            $url = 'https://bastian.ninetriangles.com/admin/api/test-reservation';
            
            $start = microtime(true);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: ' . $this->apikey
            ));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $end = microtime(true);
            curl_close($ch);
            
            if ($httpCode === 200) {
                return array(
                    'status' => 'healthy',
                    'response_time_ms' => round(($end - $start) * 1000, 2),
                    'message' => 'Production backend accessible'
                );
            } else {
                return array(
                    'status' => 'degraded',
                    'message' => 'Production backend returned status: ' . $httpCode
                );
            }
        } catch (Exception $e) {
            return array(
                'status' => 'degraded',
                'message' => 'Production backend check failed: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Check disk space
     */
    private function checkDiskSpace() {
        $freeBytes = disk_free_space('.');
        $totalBytes = disk_total_space('.');
        $usedPercent = (($totalBytes - $freeBytes) / $totalBytes) * 100;
        
        $status = 'healthy';
        if ($usedPercent > 90) {
            $status = 'unhealthy';
        } elseif ($usedPercent > 80) {
            $status = 'degraded';
        }
        
        return array(
            'status' => $status,
            'used_percent' => round($usedPercent, 2),
            'free_space' => $this->formatBytes($freeBytes),
            'total_space' => $this->formatBytes($totalBytes)
        );
    }
    
    /**
     * Check memory usage
     */
    private function checkMemoryUsage() {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = $this->parseBytes(ini_get('memory_limit'));
        $usedPercent = ($memoryUsage / $memoryLimit) * 100;
        
        $status = 'healthy';
        if ($usedPercent > 90) {
            $status = 'unhealthy';
        } elseif ($usedPercent > 80) {
            $status = 'degraded';
        }
        
        return array(
            'status' => $status,
            'used_percent' => round($usedPercent, 2),
            'current_usage' => $this->formatBytes($memoryUsage),
            'memory_limit' => $this->formatBytes($memoryLimit)
        );
    }
    
    /**
     * Check recent reservations
     */
    private function checkRecentReservations() {
        try {
            $reservations = $this->form_model->GetRecentReservations(10);
            $count = count($reservations);
            
            return array(
                'status' => 'healthy',
                'recent_count' => $count,
                'message' => "Found {$count} recent reservations"
            );
        } catch (Exception $e) {
            return array(
                'status' => 'unhealthy',
                'message' => 'Failed to check recent reservations: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Get system uptime (Linux only)
     */
    private function getSystemUptime() {
        if (file_exists('/proc/uptime')) {
            $uptime = file_get_contents('/proc/uptime');
            $uptime = explode(' ', $uptime);
            $seconds = (int)$uptime[0];
            
            $days = floor($seconds / 86400);
            $hours = floor(($seconds % 86400) / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            
            return "{$days}d {$hours}h {$minutes}m";
        }
        return 'Unknown';
    }
    
    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Parse bytes from string (e.g., "256M" to bytes)
     */
    private function parseBytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = (int)$val;
        
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        
        return $val;
    }
}
?>
