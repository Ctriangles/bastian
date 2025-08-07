<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Test_controller extends CI_Controller { 
    
    public function __construct() {  
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
        
        // CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
    }
    
    /**
     * Simple test endpoint to check if the API is working
     */
    public function test() {
        $result = array(
            'status' => true,
            'message' => 'API is working',
            'timestamp' => date('Y-m-d H:i:s'),
            'server' => $_SERVER['SERVER_NAME']
        );
        
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    
    /**
     * Test endpoint to check what data is being sent
     */
    public function test_reservation_data() {
        $rawData = $this->input->raw_input_stream;
        $jsonData = json_decode($rawData, true);
        
        $result = array(
            'status' => true,
            'message' => 'Data received successfully',
            'received_data' => $jsonData,
            'raw_data' => $rawData,
            'timestamp' => date('Y-m-d H:i:s')
        );
        
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
} 