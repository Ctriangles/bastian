<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Secure_controller extends CI_Controller { 
    
    public function __construct() {  
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
        $this->currentTime = date( 'Y-m-d H:i:s', time () );
        $this->apikey = '123456789';
        
        // CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
    }
    
    /**
     * Single secure endpoint that routes all requests internally
     * This makes API structure invisible to frontend inspection
     */
    public function data() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey != $token) {
            $result['status'] = false;
            $result['message'] = 'Unauthorized access';
            http_response_code(401);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return;
        }

        // Get request method and content to determine operation
        $method = $_SERVER['REQUEST_METHOD'];
        $rawData = $this->input->raw_input_stream;
        $jsonData = json_decode($rawData, true);
        
        // Determine operation based on request content and method
        $operation = $this->determine_operation($method, $jsonData);
        
        // Route to appropriate handler
        switch($operation) {
            case 'restaurants':
                $this->handle_restaurants();
                break;
            case 'availability':
                $this->handle_availability($jsonData);
                break;
            case 'reservations':
                $this->handle_reservations($jsonData);
                break;
            case 'form_submit':
                $this->handle_form_submit($jsonData);
                break;
            default:
                $result['status'] = false;
                $result['message'] = 'Invalid operation';
                http_response_code(400);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
    
    /**
     * Determine operation based on request method and content
     */
    private function determine_operation($method, $jsonData) {
        // GET request = restaurants
        if($method === 'GET') {
            return 'restaurants';
        }
        
        // POST request - determine by content
        if($method === 'POST' && $jsonData) {
            // Check for restaurant_id and covers = availability
            if(isset($jsonData['restaurant_id']) && isset($jsonData['covers']) && 
               isset($jsonData['earliest_start_time']) && isset($jsonData['latest_start_time'])) {
                return 'availability';
            }
            
            // Check for reservation fields
            if(isset($jsonData['restaurant_id']) && isset($jsonData['covers']) && 
               isset($jsonData['start_time']) && isset($jsonData['first_name']) && 
               isset($jsonData['last_name']) && isset($jsonData['email']) && 
               isset($jsonData['phone'])) {
                return 'reservations';
            }
            
            // Check for form submission fields
            if(isset($jsonData['form_type']) || isset($jsonData['name']) || 
               isset($jsonData['email']) || isset($jsonData['phone'])) {
                return 'form_submit';
            }
        }
        
        return 'unknown';
    }
    
    /**
     * Handle restaurants request
     */
    private function handle_restaurants() {
        // Load the Eatapp controller and call its restaurants method
        $eatapp_controller = new Eatapp_controller();
        $eatapp_controller->restaurants();
    }
    
    /**
     * Handle availability request
     */
    private function handle_availability($jsonData) {
        // Load the Eatapp controller and call its availability method
        $eatapp_controller = new Eatapp_controller();
        
        // Set the raw input stream for the availability method
        $this->input->raw_input_stream = json_encode($jsonData);
        $eatapp_controller->availability();
    }
    
    /**
     * Handle reservations request
     */
    private function handle_reservations($jsonData) {
        // Load the Eatapp controller and call its create_reservation method
        $eatapp_controller = new Eatapp_controller();
        
        // Set the raw input stream for the create_reservation method
        $this->input->raw_input_stream = json_encode($jsonData);
        $eatapp_controller->create_reservation();
    }
    
    /**
     * Handle form submission request
     */
    private function handle_form_submit($jsonData) {
        // Load the Form controller
        $form_controller = new Form_controller();
        
        // Set the raw input stream for the form methods
        $this->input->raw_input_stream = json_encode($jsonData);
        
        // Route to the correct method based on form_type
        if(isset($jsonData['form_type'])) {
            switch($jsonData['form_type']) {
                case 'header-form':
                    $form_controller->HeaderForm();
                    break;
                case 'footer-sort-form':
                    $form_controller->FooterSortForm();
                    break;
                case 'footer-long-form':
                    $form_controller->FooterLongForm();
                    break;
                case 'reservation-form':
                    $form_controller->ReservationForm();
                    break;
                case 'career':
                    $form_controller->Career();
                    break;
                default:
                    // Default to reservation form for backward compatibility
                    $form_controller->ReservationForm();
                    break;
            }
        } else {
            // Default to reservation form if no form_type specified
            $form_controller->ReservationForm();
        }
    }
} 