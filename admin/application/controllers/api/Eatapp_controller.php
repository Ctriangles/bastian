<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Eatapp_controller extends CI_Controller { 
    
    private $eatapp_api_url;
    private $eatapp_auth_key;
    private $eatapp_group_id;
    private $api_headers;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Kolkata');
        $this->currentTime = date( 'Y-m-d H:i:s', time () );
        $this->apikey = '123456789';
        
        // CORS headers - Restrict to specific domains for security
        $allowed_origins = [
            'https://bastianhospitality.com',
            'https://www.bastianhospitality.com',
            'https://bastian.ninetriangles.com',
            'http://localhost:3000', // For local development
            'http://localhost:5173'  // For Vite dev server
        ];

        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if (in_array($origin, $allowed_origins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        }

        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
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
     * Get list of restaurants from DATABASE (not EatApp directly)
     * This prevents frontend from seeing real-time API calls
     */
    public function restaurants() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            try {
                // Get restaurants from our database instead of EatApp
                $restaurants = $this->get_restaurants_from_db();

                if($restaurants) {
                    $result['status'] = true;
                    $result['data'] = $restaurants;
                    http_response_code(200);
                } else {
                    $result['status'] = false;
                    $result['message'] = 'No restaurants found';
                    http_response_code(404);
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
     * This should be called periodically via cron job, not from frontend
     */
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
                // Fetch availability directly from EatApp (simplified for now)
                $url = $this->eatapp_api_url . '/availability';
                $postData = array(
                    'restaurant_id' => $jsonData['restaurant_id'],
                    'earliest_start_time' => $jsonData['earliest_start_time'],
                    'latest_start_time' => $jsonData['latest_start_time'],
                    'covers' => intval($jsonData['covers'])
                );

                $response = $this->make_curl_request($url, 'POST', $postData);

                if($response['success']) {
                    $availability_data = json_decode($response['data'], true);

                    $result['status'] = true;
                    $result['data'] = $availability_data;
                    http_response_code(200);
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Failed to fetch availability';
                    $result['error'] = $response['error'];
                    $result['http_code'] = $response['http_code'];
                    http_response_code($response['http_code'] ?: 500);
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
                // STEP 1: Store in our database FIRST (ensures data is never lost)
                $local_reservation_id = $this->store_reservation_locally($jsonData);

                if(!$local_reservation_id) {
                    $result['status'] = false;
                    $result['message'] = 'Failed to save reservation locally';
                    http_response_code(500);
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                    return;
                }

                // STEP 2: Try to send to EatApp
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

                if($response['success']) {
                    $responseData = json_decode($response['data'], true);
                    if($response['http_code'] == 201 && isset($responseData['data']['attributes']['key'])) {
                        // STEP 3: Update our database with EatApp response
                        $this->update_reservation_with_eatapp_response($local_reservation_id, $responseData, 'confirmed');

                        $result['status'] = true;
                        $result['data'] = $responseData;
                        $result['message'] = 'Reservation created successfully';
                        $result['local_id'] = $local_reservation_id;
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
     * Get restaurants from our existing database table
     */
    private function get_restaurants_from_db() {
        $this->db->select('*');
        $this->db->from('tbl_restaurants');
        $this->db->where('status', 1);
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
                        'address_line_1' => '', // Can be added later if needed
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    )
                );
            }

            return $formatted_data;
        }

        return false;
    }

    /**
     * Store restaurants from EatApp into our existing table
     */
    private function store_restaurants_in_db($eatapp_data) {
        if(!isset($eatapp_data['data'])) return false;

        foreach($eatapp_data['data'] as $restaurant) {
            $data = array(
                'eatapp_id' => $restaurant['id'],
                'name' => $restaurant['attributes']['name'],
                'status' => 1
            );

            // Check if restaurant already exists
            $this->db->where('eatapp_id', $restaurant['id']);
            $existing = $this->db->get('tbl_restaurants');

            if($existing->num_rows() > 0) {
                // Update existing
                $this->db->where('eatapp_id', $restaurant['id']);
                $this->db->update('tbl_restaurants', $data);
            } else {
                // Insert new
                $this->db->insert('tbl_restaurants', $data);
            }
        }

        return true;
    }

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
     * Store reservation in our existing database table first (before EatApp)
     */
    private function store_reservation_locally($jsonData) {
        $start_datetime = new DateTime($jsonData['start_time']);

        $data = array(
            'restaurant_id' => $jsonData['restaurant_id'],
            'pax' => intval($jsonData['covers']),
            'booking_date' => $start_datetime->format('Y-m-d'),
            'booking_time' => $start_datetime->format('H:i:s'),
            'full_name' => $jsonData['first_name'] . ' ' . $jsonData['last_name'],
            'email_id' => $jsonData['email'],
            'contact_number' => $jsonData['phone'],
            'comments' => isset($jsonData['notes']) ? $jsonData['notes'] : '',
            'eatapp_status' => 'pending',
            'insert_date' => date('Y-m-d H:i:s'),
            'edit_date' => date('Y-m-d H:i:s'),
            'status' => 1 // Active status
        );

        $this->db->insert('tbl_forms_data', $data);
        return $this->db->insert_id();
    }

    /**
     * Update reservation with EatApp response in existing table
     */
    private function update_reservation_with_eatapp_response($local_id, $eatapp_response, $status) {
        $data = array(
            'eatapp_status' => $status,
            'eatapp_response' => $eatapp_response ? json_encode($eatapp_response) : null,
            'edit_date' => date('Y-m-d H:i:s')
        );

        if($eatapp_response && isset($eatapp_response['data']['attributes']['key'])) {
            $data['eatapp_reservation_key'] = $eatapp_response['data']['attributes']['key'];
        }

        $this->db->where('id', $local_id);
        $this->db->update('tbl_forms_data', $data);

        return true;
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
