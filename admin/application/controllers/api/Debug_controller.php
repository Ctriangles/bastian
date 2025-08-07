<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Debug_controller extends CI_Controller { 
    
    private $eatapp_api_url;
    private $eatapp_auth_key;
    private $eatapp_group_id;
    private $api_headers;
    
    public function __construct() {  
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
        $this->currentTime = date( 'Y-m-d H:i:s', time () );
        $this->apikey = '123456789';
        
        // CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
        
        // EatApp API Configuration
        $this->eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
        $this->eatapp_auth_key = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $this->eatapp_group_id = '4bcc6bdd-765b-4486-83ab-17c175dc3910';
        
        $this->api_headers = array(
            'Authorization: ' . $this->eatapp_auth_key,
            'X-Group-ID: ' . $this->eatapp_group_id,
            'Accept: application/json',
            'Content-Type: application/json'
        );
    }
    
    /**
     * Debug endpoint to test reservation creation and payment URL extraction
     */
    public function test_reservation() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            // Validate required fields
            $required_fields = ['restaurant_id', 'covers', 'start_time', 'first_name', 'last_name', 'email', 'phone'];
            foreach($required_fields as $field) {
                if(!isset($jsonData[$field]) || empty($jsonData[$field])) {
                    $result['status'] = false;
                    $result['message'] = "Missing required field: $field";
                    http_response_code(400);
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                    return;
                }
            }

            try {
                // Send to EatApp
                $url = $this->eatapp_api_url . '/reservations';

                // Prepare reservation data
                $postData = array(
                    'restaurant_id' => $jsonData['restaurant_id'],
                    'covers' => intval($jsonData['covers']),
                    'start_time' => $jsonData['start_time'],
                    'first_name' => $jsonData['first_name'],
                    'last_name' => $jsonData['last_name'],
                    'email' => $jsonData['email'],
                    'phone' => $jsonData['phone'],
                    'notes' => isset($jsonData['notes']) ? $jsonData['notes'] : '',
                    'referrer_tag' => 'concierge',
                    'terms_and_conditions_accepted' => true,
                    'marketing_accepted' => true
                );

                // Add restaurant-specific header
                $headers = $this->api_headers;
                $headers[] = 'X-Restaurant-ID: ' . $jsonData['restaurant_id'];

                $response = $this->make_curl_request($url, 'POST', $postData, $headers);

                $result = array();
                
                if($response['success']) {
                    $responseData = json_decode($response['data'], true);
                    
                    $result['status'] = true;
                    $result['message'] = 'Debug test completed';
                    $result['http_code'] = $response['http_code'];
                    $result['raw_response'] = $response['data'];
                    $result['decoded_response'] = $responseData;
                    
                    // Test payment URL extraction
                    $payment_url = $this->extract_payment_url_debug($responseData);
                    $result['payment_url_found'] = $payment_url;
                    
                    if($response['http_code'] == 201 && isset($responseData['data']['attributes']['key'])) {
                        $result['reservation_created'] = true;
                        $result['reservation_key'] = $responseData['data']['attributes']['key'];
                    } else {
                        $result['reservation_created'] = false;
                    }
                    
                    http_response_code(200);
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Failed to call EatApp API';
                    $result['error'] = $response['error'];
                    $result['http_code'] = $response['http_code'];
                    http_response_code(500);
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error in debug test';
                $result['error'] = $e->getMessage();
                http_response_code(500);
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Unauthorized access';
            http_response_code(401);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    
    /**
     * Debug version of payment URL extraction with detailed logging
     */
    private function extract_payment_url_debug($responseData) {
        $payment_url = null;
        $debug_info = array();
        
        // Search in common locations where payment URLs might be found
        if(isset($responseData['data']['attributes']['payment_url'])) {
            $payment_url = $responseData['data']['attributes']['payment_url'];
            $debug_info[] = "Found in data.attributes.payment_url: $payment_url";
        }
        elseif(isset($responseData['data']['attributes']['payment_link'])) {
            $payment_url = $responseData['data']['attributes']['payment_link'];
            $debug_info[] = "Found in data.attributes.payment_link: $payment_url";
        }
        elseif(isset($responseData['data']['attributes']['links']['payment'])) {
            $payment_url = $responseData['data']['attributes']['links']['payment'];
            $debug_info[] = "Found in data.attributes.links.payment: $payment_url";
        }
        elseif(isset($responseData['data']['attributes']['payment_request_url'])) {
            $payment_url = $responseData['data']['attributes']['payment_request_url'];
            $debug_info[] = "Found in data.attributes.payment_request_url: $payment_url";
        }
        elseif(isset($responseData['payment_url'])) {
            $payment_url = $responseData['payment_url'];
            $debug_info[] = "Found in root payment_url: $payment_url";
        }
        elseif(isset($responseData['links']['payment'])) {
            $payment_url = $responseData['links']['payment'];
            $debug_info[] = "Found in root links.payment: $payment_url";
        }
        elseif(isset($responseData['data']['attributes']['email_payment_url'])) {
            $payment_url = $responseData['data']['attributes']['email_payment_url'];
            $debug_info[] = "Found in data.attributes.email_payment_url: $payment_url";
        }
        else {
            // Search recursively through the entire response
            $recursive_result = $this->search_recursive_for_payment_url_debug($responseData);
            if($recursive_result['found']) {
                $payment_url = $recursive_result['url'];
                $debug_info[] = "Found through recursive search: $payment_url";
                $debug_info[] = "Location: " . $recursive_result['path'];
            } else {
                $debug_info[] = "No payment URL found in response";
            }
        }
        
        return array(
            'url' => $payment_url,
            'debug_info' => $debug_info
        );
    }
    
    /**
     * Debug version of recursive search
     */
    private function search_recursive_for_payment_url_debug($data, $path = '') {
        if(is_array($data)) {
            foreach($data as $key => $value) {
                $current_path = $path ? $path . '.' . $key : $key;
                
                // Check if this key contains payment-related terms
                if(strpos(strtolower($key), 'payment') !== false && is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    return array('found' => true, 'url' => $value, 'path' => $current_path);
                }
                
                // Check if this key contains URL-related terms
                if((strpos(strtolower($key), 'url') !== false || strpos(strtolower($key), 'link') !== false) && 
                   is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    // Check if it looks like a payment URL
                    if(strpos($value, 'payment') !== false || strpos($value, 'pay') !== false || strpos($value, 'e-link') !== false) {
                        return array('found' => true, 'url' => $value, 'path' => $current_path);
                    }
                }
                
                // Check for e-link URLs specifically (like in the email)
                if(is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    if(strpos($value, 'e-link1.eatapp.co') !== false || strpos($value, 'e-link') !== false) {
                        return array('found' => true, 'url' => $value, 'path' => $current_path);
                    }
                }
                
                // Check for any URL that might be a payment URL
                if(is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    $lowerValue = strtolower($value);
                    if(strpos($lowerValue, 'ls/click') !== false || strpos($lowerValue, 'upn=') !== false) {
                        return array('found' => true, 'url' => $value, 'path' => $current_path);
                    }
                }
                
                // Recursively search nested arrays
                if(is_array($value)) {
                    $result = $this->search_recursive_for_payment_url_debug($value, $current_path);
                    if($result['found']) {
                        return $result;
                    }
                }
            }
        }
        
        return array('found' => false, 'url' => null, 'path' => null);
    }

    /**
     * Make CURL request to EatApp API
     */
    private function make_curl_request($url, $method = 'GET', $data = null, $custom_headers = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers ?: $this->api_headers);

        if($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if($error) {
            return array(
                'success' => false,
                'error' => $error,
                'http_code' => $http_code,
                'data' => null
            );
        }

        return array(
            'success' => true,
            'data' => $response,
            'http_code' => $http_code,
            'error' => null
        );
    }
} 