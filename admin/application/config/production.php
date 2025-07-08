<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Production Environment Configuration for Bastian Reservation System
 * This file contains production-specific settings
 */

// Production API Configuration
$config['bastian_api_key'] = getenv('BASTIAN_API_KEY') ?: 'your_production_api_key_here';
$config['eatapp_bearer_token'] = getenv('EATAPP_BEARER_TOKEN') ?: 'your_production_eatapp_token';
$config['eatapp_group_id'] = getenv('EATAPP_GROUP_ID') ?: 'your_production_group_id';

// Production URLs
$config['production_backend_url'] = 'https://bastian.ninetriangles.com/admin/api/reservation-form';
$config['eatapp_api_base'] = 'https://api.eat-sandbox.co/concierge/v2';

// Allowed Origins for CORS (Production domains only)
$config['allowed_origins'] = [
    'https://bastianhospitality.com',
    'https://www.bastianhospitality.com',
    'https://bastian.ninetriangles.com'
];

// Security Settings
$config['enable_debug_logs'] = FALSE;
$config['log_level'] = 'ERROR'; // Only log errors in production
$config['enable_detailed_errors'] = FALSE;

// Rate Limiting (requests per minute per IP)
$config['rate_limit_enabled'] = TRUE;
$config['rate_limit_requests'] = 60;
$config['rate_limit_window'] = 60; // seconds

// Database Settings (should be in database.php, but included here for reference)
$config['database_backup_enabled'] = TRUE;
$config['database_backup_frequency'] = 'daily';

// Email Settings
$config['email_notifications_enabled'] = TRUE;
$config['admin_email'] = getenv('ADMIN_EMAIL') ?: 'admin@bastianhospitality.com';

// Monitoring and Logging
$config['error_reporting_enabled'] = TRUE;
$config['performance_monitoring'] = TRUE;
$config['log_retention_days'] = 30;

// Cache Settings
$config['cache_enabled'] = TRUE;
$config['cache_ttl'] = 3600; // 1 hour

// SSL/HTTPS Settings
$config['force_https'] = TRUE;
$config['ssl_verify_peer'] = TRUE;

// API Timeouts
$config['api_timeout'] = 30; // seconds
$config['api_retry_attempts'] = 3;
$config['api_retry_delay'] = 1000; // milliseconds

// Validation Settings
$config['strict_validation'] = TRUE;
$config['sanitize_inputs'] = TRUE;
$config['max_reservation_days_ahead'] = 90;
$config['min_reservation_hours_ahead'] = 2;

// Feature Flags
$config['dual_submission_enabled'] = TRUE;
$config['async_submission_enabled'] = TRUE;
$config['backup_submission_enabled'] = TRUE;

// Third-party Integration Settings
$config['edyne_integration_enabled'] = TRUE;
$config['edyne_api_url'] = 'https://edyne.dytel.co.in/postbastianreservation.asp';

// Maintenance Mode
$config['maintenance_mode'] = FALSE;
$config['maintenance_message'] = 'System is under maintenance. Please try again later.';

// Performance Settings
$config['enable_gzip'] = TRUE;
$config['enable_etag'] = TRUE;
$config['max_execution_time'] = 30;
$config['memory_limit'] = '256M';

// Security Headers
$config['security_headers'] = [
    'X-Content-Type-Options' => 'nosniff',
    'X-Frame-Options' => 'DENY',
    'X-XSS-Protection' => '1; mode=block',
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
    'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"
];

// API Response Settings
$config['api_response_format'] = 'json';
$config['api_include_timestamp'] = TRUE;
$config['api_include_request_id'] = TRUE;

// Backup and Recovery
$config['backup_enabled'] = TRUE;
$config['backup_location'] = '/var/backups/bastian/';
$config['backup_retention_days'] = 30;

// Monitoring Endpoints
$config['health_check_enabled'] = TRUE;
$config['metrics_enabled'] = TRUE;
$config['status_page_enabled'] = FALSE; // Disable for security

?>
