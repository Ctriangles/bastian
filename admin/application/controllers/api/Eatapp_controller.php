<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Eatapp_controller extends CI_Controller { 
    
    private $eatapp_api_url;
    private $eatapp_auth_key;
    private $eatapp_group_id;
    private $api_headers;
    
    public function __construct() {  
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
        $this->currentTime = date( 'Y-m-d H:i:s', time () );
        $this->apikey = '123456789';
        
        // CORS headers - Updated to allow obfuscated headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
        
        // EatApp API Configuration - SECURE (not exposed to frontend)
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
     * Get list of restaurants from EatApp API (real-time)
     * Secure proxy endpoint - credentials hidden from frontend
     */
    public function restaurants() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            try {
                // Fetch restaurants directly from EatApp API
                $url = $this->eatapp_api_url . '/restaurants';
                $response = $this->make_curl_request($url, 'GET');

                if($response['success']) {
                    $eatapp_data = json_decode($response['data'], true);
                    
                    if($eatapp_data && isset($eatapp_data['data'])) {
                        $result['status'] = true;
                        $result['data'] = $eatapp_data;
                        http_response_code(200);
                    } else {
                        $result['status'] = false;
                        $result['message'] = 'Invalid response from EatApp API';
                        http_response_code(500);
                    }
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Failed to fetch restaurants from EatApp';
                    $result['error'] = $response['error'];
                    $result['http_code'] = $response['http_code'];
                    http_response_code($response['http_code'] ?: 500);
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error fetching restaurants';
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
     * ADMIN ONLY: Sync restaurants from EatApp to our database
     * DEPRECATED: Now fetching directly from EatApp API
     */
    /*
    public function sync_restaurants() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            try {
                $url = $this->eatapp_api_url . '/restaurants';
                $response = $this->make_curl_request($url, 'GET');

                if($response['success']) {
                    $eatapp_data = json_decode($response['data'], true);
                    $this->store_restaurants_in_db($eatapp_data);

                    $result['status'] = true;
                    $result['message'] = 'Restaurants synced successfully';
                    $result['count'] = count($eatapp_data['data']);
                    http_response_code(200);
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Failed to sync restaurants';
                    $result['error'] = $response['error'];
                    http_response_code(500);
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error syncing restaurants';
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
    */
    
    /**
     * Check availability from CACHE first, then EatApp if needed
     * This prevents real-time API calls visible in frontend
     */
    public function availability() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            // Validate required fields
            if(!isset($jsonData['restaurant_id']) || !isset($jsonData['earliest_start_time']) ||
               !isset($jsonData['latest_start_time']) || !isset($jsonData['covers'])) {
                $result['status'] = false;
                $result['message'] = 'Missing required fields';
                http_response_code(400);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return;
            }

            try {
                $restaurant_id = $jsonData['restaurant_id'];
                $date = date('Y-m-d', strtotime($jsonData['earliest_start_time']));
                $covers = intval($jsonData['covers']);

                // Check cache first
                $cached_availability = $this->get_cached_availability($restaurant_id, $date, $covers);

                if($cached_availability) {
                    $result['status'] = true;
                    $result['data'] = $cached_availability;
                    $result['cached'] = true;
                    http_response_code(200);
                } else {
                    // Cache miss - fetch from EatApp and cache it
                    $url = $this->eatapp_api_url . '/availability';
                    $postData = array(
                        'restaurant_id' => $restaurant_id,
                        'earliest_start_time' => $jsonData['earliest_start_time'],
                        'latest_start_time' => $jsonData['latest_start_time'],
                        'covers' => $covers
                    );

                    $response = $this->make_curl_request($url, 'POST', $postData);

                    if($response['success']) {
                        $availability_data = json_decode($response['data'], true);

                        // Cache the result for 15 minutes
                        $this->cache_availability($restaurant_id, $date, $covers, $availability_data);

                        $result['status'] = true;
                        $result['data'] = $availability_data;
                        $result['cached'] = false;
                        http_response_code(200);
                    } else {
                        $result['status'] = false;
                        $result['message'] = 'Failed to fetch availability';
                        $result['error'] = $response['error'];
                        $result['http_code'] = $response['http_code'];
                        http_response_code($response['http_code'] ?: 500);
                    }
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error checking availability';
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
     * Create a reservation - SECURE DATABASE-FIRST approach
     * 1. Store in our database immediately
     * 2. Send to EatApp in background
     * 3. Update database with EatApp response
     */
    public function create_reservation() {
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
                // Debug: Log the incoming request data
                error_log("Incoming reservation request: " . json_encode($jsonData));
                
                // STEP 1: Store in our database FIRST (ensures data is never lost)
                $local_reservation_id = $this->store_reservation_locally($jsonData);

                if(!$local_reservation_id) {
                    $result['status'] = false;
                    $result['message'] = 'Failed to save reservation locally';
                    http_response_code(500);
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                    return;
                }

                // STEP 2: Try to send to EatApp with full relationships
                $url = $this->eatapp_api_url . '/reservations';

                // Create payment object first (if needed) - but don't fail if it doesn't work
                $payment_id = null;
                try {
                    $payment_id = $this->create_payment_object(20.00, 'USD');
                } catch (Exception $e) {
                    error_log("Payment object creation failed: " . $e->getMessage());
                }

                // Prepare reservation data - start with basic format
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
                
                // Debug: Log the request and response
                error_log("EatApp API Request: " . json_encode($postData));
                error_log("EatApp API Response: " . json_encode($response));
                
                if($response['success']) {
                    $responseData = json_decode($response['data'], true);
                    
                    if($response['http_code'] == 201 && isset($responseData['data']['attributes']['key'])) {
                        // STEP 3: Update our database with EatApp response
                        $this->update_reservation_with_eatapp_response($local_reservation_id, $responseData, 'confirmed');

                        // Extract payment URL from response if available
                        $payment_url = $this->extract_payment_url($responseData);
                        
                        $result['status'] = true;
                        $result['data'] = $responseData;
                        $result['message'] = 'Reservation created successfully';
                        $result['local_id'] = $local_reservation_id;
                        
                        // Add payment URL to response if found
                        if($payment_url) {
                            $result['payment_url'] = $payment_url;
                            $result['payment_required'] = true;
                            $result['payment_amount'] = 20.00; // Default amount from email
                        }
                        
                        http_response_code(201);
                    } else {
                        // EatApp returned error - mark as failed but keep local reservation
                        $this->update_reservation_with_eatapp_response($local_reservation_id, $responseData, 'failed');

                        $result['status'] = false;
                        $result['message'] = 'Failed to create reservation in EatApp';
                        $result['data'] = $responseData;
                        $result['local_id'] = $local_reservation_id;
                        http_response_code($response['http_code'] ?: 500);
                    }
                } else {
                    // EatApp API call failed - mark as failed but keep local reservation
                    $this->update_reservation_with_eatapp_response($local_reservation_id, null, 'failed');

                    $result['status'] = false;
                    $result['message'] = 'Failed to send reservation to EatApp';
                    $result['error'] = $response['error'];
                    $result['local_id'] = $local_reservation_id;
                    $result['note'] = 'Reservation saved locally for manual processing';

                    // Handle specific error codes
                    if($response['http_code'] == 400) {
                        $result['message'] = 'Invalid reservation data';
                    } elseif($response['http_code'] == 422) {
                        $errorData = json_decode($response['data'], true);
                        if(isset($errorData['validations'])) {
                            $result['validations'] = $errorData['validations'];
                            $result['message'] = 'Validation errors occurred';
                        }
                    }

                    http_response_code($response['http_code'] ?: 500);
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error creating reservation';
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
     * Get restaurants from our database
     * DEPRECATED: Now fetching directly from EatApp API
     */
    /*
    private function get_restaurants_from_db() {
        $this->db->select('*');
        $this->db->from('eatapp_restaurants');
        $this->db->where('status', 'active');
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $restaurants = $query->result_array();

            // Format to match EatApp API structure
            $formatted_data = array(
                'data' => array(),
                'meta' => array(
                    'total_count' => count($restaurants),
                    'current_page' => 1,
                    'total_pages' => 1
                )
            );

            foreach($restaurants as $restaurant) {
                $formatted_data['data'][] = array(
                    'id' => $restaurant['eatapp_id'],
                    'type' => 'restaurant',
                    'attributes' => array(
                        'name' => $restaurant['name'],
                        'available_online' => true,
                        'address_line_1' => $restaurant['address'],
                        'created_at' => $restaurant['created_at'],
                        'updated_at' => $restaurant['updated_at']
                    )
                );
            }

            return $formatted_data;
        }

        return false;
    }
    */

    /**
     * Store restaurants from EatApp into our database
     * DEPRECATED: Now fetching directly from EatApp API
     */
    /*
    private function store_restaurants_in_db($eatapp_data) {
        if(!isset($eatapp_data['data'])) return false;

        foreach($eatapp_data['data'] as $restaurant) {
            $data = array(
                'eatapp_id' => $restaurant['id'],
                'name' => $restaurant['attributes']['name'],
                'address' => $restaurant['attributes']['address_line_1'] ?? '',
                'status' => 'active',
                'eatapp_data' => json_encode($restaurant),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Check if restaurant already exists
            $this->db->where('eatapp_id', $restaurant['id']);
            $existing = $this->db->get('eatapp_restaurants');

            if($existing->num_rows() > 0) {
                // Update existing
                $this->db->where('eatapp_id', $restaurant['id']);
                $this->db->update('eatapp_restaurants', $data);
            } else {
                // Insert new
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('eatapp_restaurants', $data);
            }
        }

        return true;
    }
    */

    /**
     * Get cached availability from database
     */
    private function get_cached_availability($restaurant_id, $date, $covers) {
        $this->db->select('available_slots');
        $this->db->from('eatapp_availability');
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('date', $date);
        $this->db->where('covers', $covers);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $row = $query->row();
            return json_decode($row->available_slots, true);
        }

        return false;
    }

    /**
     * Cache availability data in database
     */
    private function cache_availability($restaurant_id, $date, $covers, $availability_data) {
        $data = array(
            'restaurant_id' => $restaurant_id,
            'date' => $date,
            'covers' => $covers,
            'available_slots' => json_encode($availability_data),
            'cached_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        );

        // Delete existing cache for this combination
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('date', $date);
        $this->db->where('covers', $covers);
        $this->db->delete('eatapp_availability');

        // Insert new cache
        $this->db->insert('eatapp_availability', $data);

        return true;
    }

    /**
     * Store reservation in our database first (before EatApp)
     */
    private function store_reservation_locally($jsonData) {
        $data = array(
            'restaurant_id' => $jsonData['restaurant_id'],
            'covers' => intval($jsonData['covers']),
            'start_time' => $jsonData['start_time'],
            'first_name' => $jsonData['first_name'],
            'last_name' => $jsonData['last_name'],
            'email' => $jsonData['email'],
            'phone' => $jsonData['phone'],
            'notes' => isset($jsonData['notes']) ? $jsonData['notes'] : '',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        );

        // Debug: Log the data being inserted
        error_log("Storing reservation locally: " . json_encode($data));

        $this->db->insert('eatapp_reservations', $data);
        
        // Check for database errors
        if ($this->db->affected_rows() > 0) {
            $insert_id = $this->db->insert_id();
            error_log("Reservation stored successfully with ID: " . $insert_id);
            return $insert_id;
        } else {
            error_log("Failed to store reservation. DB Error: " . $this->db->error()['message']);
            return false;
        }
    }

    /**
     * Update reservation with EatApp response
     */
    private function update_reservation_with_eatapp_response($local_id, $eatapp_response, $status) {
        $data = array(
            'status' => $status,
            'eatapp_response' => $eatapp_response ? json_encode($eatapp_response) : null,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if($eatapp_response && isset($eatapp_response['data']['attributes']['key'])) {
            $data['eatapp_reservation_key'] = $eatapp_response['data']['attributes']['key'];
        }

        // Debug: Log the update data
        error_log("Updating reservation ID {$local_id} with status: {$status}");

        $this->db->where('id', $local_id);
        $this->db->update('eatapp_reservations', $data);
        
        // Check for database errors
        if ($this->db->affected_rows() >= 0) {
            error_log("Reservation updated successfully. Affected rows: " . $this->db->affected_rows());
            return true;
        } else {
            error_log("Failed to update reservation. DB Error: " . $this->db->error()['message']);
            return false;
        }
    }

    /**
     * Extract payment widget URL from EatApp response
     * This method searches for the payment_widget_url in the response
     */
    private function extract_payment_url($responseData) {
        $payment_url = null;
        
        // Look for payment_widget_url in included payments array (the real location)
        if(isset($responseData['included'])) {
            foreach($responseData['included'] as $included) {
                if($included['type'] === 'payment' && isset($included['attributes']['payment_widget_url'])) {
                    $payment_url = $included['attributes']['payment_widget_url'];
                    break;
                }
            }
        }
        // Look for payment_widget_url in relationships (fallback)
        elseif(isset($responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'])) {
            $payment_url = $responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'];
        }
        // Fallback to other possible locations
        elseif(isset($responseData['data']['attributes']['payment_widget_url'])) {
            $payment_url = $responseData['data']['attributes']['payment_widget_url'];
        }
        elseif(isset($responseData['data']['attributes']['payment_url'])) {
            $payment_url = $responseData['data']['attributes']['payment_url'];
        }
        elseif(isset($responseData['data']['attributes']['payment_link'])) {
            $payment_url = $responseData['data']['attributes']['payment_link'];
        }
        elseif(isset($responseData['payment_url'])) {
            $payment_url = $responseData['payment_url'];
        }
        else {
            // Search recursively through the entire response
            $payment_url = $this->search_recursive_for_payment_url($responseData);
        }
        
        return $payment_url;
    }
    
    /**
     * Recursively search for payment URL in nested arrays
     */
    private function search_recursive_for_payment_url($data, $path = '') {
        if(is_array($data)) {
            foreach($data as $key => $value) {
                $current_path = $path ? $path . '.' . $key : $key;
                
                // Check if this key contains payment-related terms
                if(strpos(strtolower($key), 'payment') !== false && is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    return $value;
                }
                
                // Check if this key contains URL-related terms
                if((strpos(strtolower($key), 'url') !== false || strpos(strtolower($key), 'link') !== false) && 
                   is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    // Check if it looks like a payment URL
                    if(strpos($value, 'payment') !== false || strpos($value, 'pay') !== false || strpos($value, 'e-link') !== false) {
                        return $value;
                    }
                }
                
                // Check for e-link URLs specifically (like in the email)
                if(is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    if(strpos($value, 'e-link1.eatapp.co') !== false || strpos($value, 'e-link') !== false) {
                        return $value;
                    }
                }
                
                // Check for any URL that might be a payment URL
                if(is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                    $lowerValue = strtolower($value);
                    if(strpos($lowerValue, 'ls/click') !== false || strpos($lowerValue, 'upn=') !== false) {
                        return $value;
                    }
                }
                
                // Recursively search nested arrays
                if(is_array($value)) {
                    $result = $this->search_recursive_for_payment_url($value, $current_path);
                    if($result) {
                        return $result;
                    }
                }
            }
        }
        
        return null;
    }
    
    /**
     * Create a payment object for the reservation
     */
    private function create_payment_object($amount = 20.00, $currency = 'USD') {
        try {
            $url = $this->eatapp_api_url . '/payments';
            
            $postData = array(
                'amount' => $amount,
                'currency' => $currency,
                'description' => "A pre-payment for $amount $currency is required",
                'gateway' => 'stripe'
            );
            
            $response = $this->make_curl_request($url, 'POST', $postData);
            
            if($response['success']) {
                $paymentData = json_decode($response['data'], true);
                
                if(isset($paymentData['data']['id'])) {
                    return $paymentData['data']['id'];
                }
            }
            
        } catch (Exception $e) {
            // Log error but don't fail the reservation
        }
        
        return null;
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

    /**
     * ADMIN ONLY: Get all reservations from our database for debugging
     */
    public function get_reservations() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            try {
                $this->db->select('*');
                $this->db->from('eatapp_reservations');
                $this->db->order_by('created_at', 'DESC');
                $this->db->limit(10); // Get last 10 reservations
                $query = $this->db->get();

                if($query->num_rows() > 0) {
                    $result['status'] = true;
                    $result['data'] = $query->result_array();
                    $result['count'] = $query->num_rows();
                    http_response_code(200);
                } else {
                    $result['status'] = false;
                    $result['message'] = 'No reservations found';
                    http_response_code(404);
                }
            } catch (Exception $e) {
                $result['status'] = false;
                $result['message'] = 'Error fetching reservations';
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
}
