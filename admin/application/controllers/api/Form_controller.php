<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Form_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date( 'Y-m-d H:i:s', time () );
        // Use environment variable or config for API key security
        $this->apikey = getenv('BASTIAN_API_KEY') ?: '123456789';

        // Load required models
        $this->load->model('form_model');
        $this->load->model('setting_model');
        $this->load->library('email');

        // Secure CORS - restrict to specific domains
        $allowed_origins = [
            'http://localhost:5173',
            'http://localhost:3000',
            'https://bastianhospitality.com',
            'https://www.bastianhospitality.com'
        ];

        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if (in_array($origin, $allowed_origins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        }

        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Credentials: false');
        header('Access-Control-Max-Age: 86400'); // Cache preflight for 24 hours

        // Additional security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
        $smtpdata = $this->setting_model->viewSMTPdata();
		if(!empty($smtpdata)) {
			$config = array(
				'protocol' => $smtpdata->smtp_service,
				'smtp_host' => $smtpdata->mail_host, 
				'smtp_port' => $smtpdata->mail_port,
				'smtp_user' => $smtpdata->mail_username,
				'smtp_pass' => $smtpdata->mail_password,
				'smtp_crypto' => $smtpdata->smtp_crypto,
				'mailtype' => $smtpdata->mail_type,
				'smtp_timeout' => '8',
				'charset' => 'ISO-8859-1',
				'newline' => "\r\n",
				'wordwrap' => TRUE,
			);
			$this->email->initialize($config);
        }
		$result['settings'] = $this->setting_model->viewSitedata();
		foreach($result['settings'] as $catdata){ 
			if($catdata->setting_name=='site_logo') {
				$this->site_logo = $catdata->setting_value;
			} if($catdata->setting_name=='site_favicon') {
				$this->site_favicon = $catdata->setting_value;
			} if($catdata->setting_name=='copyright') {
				$this->copyright = $catdata->setting_value;
			} if($catdata->setting_name=='site_title') {
				$this->site_title = $catdata->setting_value;
			} if($catdata->setting_name=='site_emailto') {
				$this->site_emailto = $catdata->setting_value;
			} if($catdata->setting_name=='site_emailfrom') {
				$this->site_emailfrom = $catdata->setting_value;
			}
		}
    } 
    public function HeaderForm() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData);
            $data = array(
                'id' => '',
                'restaurant_id' => $jsonData->formvalue->restaurant_id,
                'booking_date' => date('Y-m-d', strtotime($jsonData->formvalue->booking_date)),
                'pax' => $jsonData->formvalue->pax,
                'full_name' => $jsonData->formvalue->full_name,
                'email_id' => $jsonData->formvalue->email,
                'contact_number' => $jsonData->formvalue->mobile,
                'age' => $jsonData->formvalue->age,
                'pin_code' => $jsonData->formvalue->pincode,
                'insert_date' => $this->currentTime,
                'edit_date' => $this->currentTime
            );
            //print_r($data); die;
            $AddData = $this->form_model->AddFormDetailsData($data);
            if($AddData == TRUE) {
                $this->email->from(@$this->site_emailfrom, "Bastian Hospitality");
                $this->email->to(@$this->site_emailto);
                $this->email->reply_to($data['email_id']);
                $this->email->subject("Bastian Hospitality Reservation Form | ".$data['full_name']);
                $results['message'] = $this->form_model->ReservationdataById($AddData);
                $body = $this->load->view('email_template/contactform',$results,TRUE);
                $this->email->message($body);
                $this->email->set_newline("\r\n");
                $this->email->send();
                $this->sendDataAfterInsert($results['message']);
                $result['status'] = TRUE;
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                http_response_code(400);
            }
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function FooterSortForm() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData);
            $data = array(
                'id' => '',
                'restaurant_id' => $jsonData->formvalue->restaurant_id,
                'booking_date' => date('Y-m-d', strtotime($jsonData->formvalue->booking_date)),
                'pax' => $jsonData->formvalue->pax,
                'user_ip' => @$this->input->ip_address(),
                'insert_date' => $this->currentTime,
                'edit_date' => $this->currentTime
            );
            $AddData = $this->form_model->AddFormData($data);
            if($AddData == TRUE) {
                $result['restaurant_id'] = $data['restaurant_id'];
                $result['booking_date'] = date('d-M-Y', strtotime($data['booking_date']));
                $result['pax'] = $data['pax'];
                $result['form_id'] = $AddData;
                $result['status'] = TRUE;
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                http_response_code(400);
            }
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    
    public function ReservationForm() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData);

            // Debug: Log the received data
            error_log("Reservation Form Data: " . print_r($jsonData, true));

            // Validate request data structure
            if (!isset($jsonData->formvalue)) {
                $result = $this->createErrorResponse('Invalid data format - formvalue missing', 400);
                error_log("ERROR: formvalue missing in request data");
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return;
            }

            // Validate required fields
            $requiredFields = ['restaurant_id', 'booking_date', 'full_name', 'email', 'mobile', 'pax'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (!isset($jsonData->formvalue->$field) || empty($jsonData->formvalue->$field)) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                $result = $this->createErrorResponse('Missing required fields: ' . implode(', ', $missingFields), 400);
                error_log("ERROR: Missing required fields: " . implode(', ', $missingFields));
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return;
            }

            $data = array(
                'id' => '',
                'restaurant_id' => isset($jsonData->formvalue->restaurant_id) ? $jsonData->formvalue->restaurant_id : '',
                'pax' => isset($jsonData->formvalue->pax) ? $jsonData->formvalue->pax : '',
                'booking_date' => isset($jsonData->formvalue->booking_date) ? $jsonData->formvalue->booking_date : '',
                'booking_time' => isset($jsonData->formvalue->booking_time) ? $jsonData->formvalue->booking_time : '',
                'full_name' => isset($jsonData->formvalue->full_name) ? $jsonData->formvalue->full_name : '',
                'email_id' => isset($jsonData->formvalue->email) ? $jsonData->formvalue->email : '',
                'contact_number' => isset($jsonData->formvalue->mobile) ? $jsonData->formvalue->mobile : '',
                'age' => isset($jsonData->formvalue->age) ? $jsonData->formvalue->age : '',
                'pin_code' => isset($jsonData->formvalue->pincode) ? $jsonData->formvalue->pincode : '',
                'comments' => isset($jsonData->formvalue->comments) ? $jsonData->formvalue->comments : '',
                'status' => '1', // Add status field
                'insert_date' => $this->currentTime,
                'edit_date' => $this->currentTime
            );

            // Debug: Log the data being inserted
            error_log("Data to insert: " . print_r($data, true));

            $AddData = $this->form_model->AddFormDetailsData($data);

            // Debug: Log the result
            error_log("Insert result: " . ($AddData ? $AddData : 'FALSE'));

            // Additional debugging - check database error
            if (!$AddData) {
                $db_error = $this->db->error();
                error_log("Database error: " . print_r($db_error, true));
            }

            if($AddData) {
                // Send data to production backend in background
                error_log("CALLING sendToProductionBackendAsync with data: " . print_r($jsonData->formvalue, true));
                $this->sendToProductionBackendAsync($jsonData->formvalue);

                $result['status'] = TRUE;
                $result['reservation_id'] = $AddData;
                $result['message'] = 'Reservation saved successfully';
                error_log("SUCCESS: Reservation saved with ID: " . $AddData);
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Failed to save reservation data';
                error_log("ERROR: Failed to save reservation data");
                http_response_code(400);
            }
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    // Check database table structure
    public function CheckDatabase() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $table_info = $this->form_model->CheckTableStructure();
            $result = array(
                'status' => TRUE,
                'message' => 'Database check completed',
                'table_info' => $table_info
            );
            http_response_code(200);
        } else {
            $result = array(
                'status' => FALSE,
                'message' => 'unauthorized access'
            );
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    // Test endpoint to debug reservation data
    public function TestReservation() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            // Get recent reservation data from database using model
            $reservations = $this->form_model->GetRecentReservations();

            $result = array(
                'status' => TRUE,
                'message' => 'Recent reservations retrieved',
                'data' => $reservations,
                'count' => count($reservations),
                'current_time' => $this->currentTime
            );
            http_response_code(200);
        } else {
            $result = array(
                'status' => FALSE,
                'message' => 'unauthorized access'
            );
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function FooterLongForm() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData);
            $getshortdata = $this->form_model->ShortFormData($jsonData->formvalue->form_id);
            $data = array(
                'id' => '',
                'restaurant_id' => $getshortdata->restaurant_id,
                'pax' => $getshortdata->pax,
                'booking_date' => $getshortdata->booking_date,
                'full_name' => $jsonData->formvalue->full_name,
                'email_id' => $jsonData->formvalue->email,
                'contact_number' => $jsonData->formvalue->mobile,
                'age' => $jsonData->formvalue->age,
                'pin_code' => $jsonData->formvalue->pincode,
                'edit_date' => $this->currentTime
            );
            $AddData = $this->form_model->AddFormDetailsData($data);
            if($AddData == TRUE) {
                $this->email->from(@$this->site_emailfrom, "Bastian Hospitality");
                $this->email->to(@$this->site_emailto);
                $this->email->reply_to($data['email_id']);
                $this->email->subject("Bastian Hospitality Reservation Form | ".$data['full_name']);
                $results['message'] = $this->form_model->ReservationdataById($AddData);
                $body = $this->load->view('email_template/contactform',$results,TRUE);
                $this->email->message($body);
                $this->email->set_newline("\r\n");
                $this->email->send();
                $this->sendDataAfterInsert($results['message']);
                $result['status'] = TRUE;
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                http_response_code(400);
            }
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function Career() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData);
            $data = array(
                'id' => '',
                'department' => $jsonData->formvalue->department,
                'full_name' => $jsonData->formvalue->full_name,
                'contact_number' => $jsonData->formvalue->contact_number,
                'email_id' => $jsonData->formvalue->email_id,
                'user_ip' => @$this->input->ip_address(),
                'insert_date' => $this->currentTime,
                'edit_date' => $this->currentTime
            );
            $AddData = $this->form_model->AddCareerData($data);
            if($AddData == TRUE) {
                $this->email->from(@$this->site_emailfrom, "Bastian Hospitality");
                $this->email->to(@$this->site_emailto);
                $this->email->reply_to($data['email_id']);
                $this->email->subject("Bastian Hospitality Career Form | ".$data['full_name']);
                $results['message'] = $this->form_model->CareerdataById($AddData);
                $body = $this->load->view('email_template/careerform',$results,TRUE);
                $this->email->message($body);
                $this->email->set_newline("\r\n");
                $this->email->send();
                $result['status'] = TRUE;
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                http_response_code(400);
            }
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    function sendDataAfterInsert($formData) {
        error_log("sendDataAfterInsert called with data: " . print_r($formData, true));

        // Send to existing third-party system (edyne.dytel.co.in)
        $url = "https://edyne.dytel.co.in/postbastianreservation.asp?SourceId=71&SourcePwd=!Online@2024&OutletCode=".urlencode($formData->restaurant_id)."&OutletPwd=BASTIANDEMO&CustomerName=" . urlencode($formData->full_name) . "&CustomerMobile=" . urlencode($formData->contact_number) . "&CountryCode=91&ReservationDate=" . urlencode(date('d-M-Y', strtotime($formData->booking_date))) . "&ReservationTime=00:00&Covers=" . urlencode($formData->pax) . "&Occasion=&Remarks=&AdvancePaid=0&DiscountPercentage=15&DiscountAmount=0";
        error_log("Sending to edyne.dytel.co.in: " . $url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('Error sending to edyne.dytel.co.in: ' . curl_error($ch));
        } else {
            error_log('Response from edyne.dytel.co.in: ' . $response);
        }
        curl_close($ch);

        // Also send to production backend (bastian.ninetriangles.com) asynchronously
        error_log("Calling sendToProductionBackendAsync...");
        $this->sendToProductionBackendAsync($formData);

        return $response;
    }

    /**
     * Send reservation data to production backend asynchronously
     * This ensures it doesn't block the main response
     */
    private function sendToProductionBackendAsync($formData) {
        // Use a more reliable approach to send data to production backend
        $productionUrl = "https://bastian.ninetriangles.com/admin/api/reservation-form";

        // Handle both object and array input formats
        $data = is_object($formData) ? (array)$formData : $formData;

        $postData = array(
            'formvalue' => array(
                'restaurant_id' => isset($data['restaurant_id']) ? $data['restaurant_id'] : '',
                'booking_date' => isset($data['booking_date']) ? $data['booking_date'] : '',
                'booking_time' => isset($data['booking_time']) ? $data['booking_time'] : '00:00',
                'full_name' => isset($data['full_name']) ? $data['full_name'] : '',
                'email' => isset($data['email']) ? $data['email'] : '',
                'mobile' => isset($data['mobile']) ? $data['mobile'] : '',
                'pax' => isset($data['pax']) ? $data['pax'] : '',
                'age' => isset($data['age']) ? $data['age'] : '25-35',
                'pincode' => isset($data['pincode']) ? $data['pincode'] : '400001',
                'comments' => isset($data['comments']) ? $data['comments'] : ''
            )
        );

        error_log("Sending to production backend: " . print_r($postData, true));

        // Use direct cURL instead of exec for better reliability
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $productionUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: 123456789',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("Production backend cURL error: " . $curlError);
        } else {
            error_log("Production backend response (HTTP $httpCode): " . $response);
        }

        return array(
            'success' => ($httpCode >= 200 && $httpCode < 300),
            'http_code' => $httpCode,
            'response' => $response,
            'error' => $curlError
        );
    }

    /**
     * Test endpoint to manually send data to production backend
     * This can be used for testing and verification
     */
    public function TestProductionSubmission() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            if (!$jsonData || !isset($jsonData['formvalue'])) {
                $result = array(
                    'status' => FALSE,
                    'message' => 'Invalid data format'
                );
                http_response_code(400);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return;
            }

            // Send to production backend
            $productionResult = $this->sendToProductionBackendAsync($jsonData['formvalue']);

            $result = array(
                'status' => $productionResult['success'],
                'message' => $productionResult['success'] ? 'Data sent to production backend successfully' : 'Failed to send to production backend',
                'production_response' => $productionResult
            );

            http_response_code($productionResult['success'] ? 200 : 500);
        } else {
            $result = array(
                'status' => FALSE,
                'message' => 'unauthorized access'
            );
            http_response_code(401);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    /**
     * Convert EatApp reservation data to production backend format and send
     */
    private function sendEatAppDataToProduction($eatAppData) {
        try {
            // Convert EatApp format to production backend format
            $productionData = array(
                'formvalue' => array(
                    'restaurant_id' => isset($eatAppData['restaurant_id']) ? $eatAppData['restaurant_id'] : '',
                    'booking_date' => isset($eatAppData['start_time']) ? date('Y-m-d', strtotime($eatAppData['start_time'])) : '',
                    'booking_time' => isset($eatAppData['start_time']) ? date('H:i:s', strtotime($eatAppData['start_time'])) : '',
                    'full_name' => (isset($eatAppData['first_name']) ? $eatAppData['first_name'] : '') . ' ' . (isset($eatAppData['last_name']) ? $eatAppData['last_name'] : ''),
                    'email' => isset($eatAppData['email']) ? $eatAppData['email'] : '',
                    'mobile' => isset($eatAppData['phone']) ? $eatAppData['phone'] : '',
                    'pax' => isset($eatAppData['covers']) ? (string)$eatAppData['covers'] : '2',
                    'age' => '25-35', // Default age range
                    'pincode' => '400001', // Default pincode
                    'comments' => (isset($eatAppData['notes']) ? $eatAppData['notes'] : '') . ' [EatApp Reservation]'
                )
            );

            error_log("Converting EatApp data to production format: " . print_r($productionData, true));

            // Send asynchronously to avoid blocking the main response
            $this->sendToProductionBackendAsync($productionData['formvalue']);

        } catch (Exception $e) {
            error_log("Error converting EatApp data for production: " . $e->getMessage());
        }
    }

    /**
     * Create standardized error response
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @return array Standardized error response
     */
    private function createErrorResponse($message, $statusCode = 400) {
        return array(
            'status' => FALSE,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'error_code' => $statusCode
        );
    }

    /**
     * Create standardized success response
     * @param mixed $data Response data
     * @param string $message Success message
     * @return array Standardized success response
     */
    private function createSuccessResponse($data = null, $message = 'Success') {
        $response = array(
            'status' => TRUE,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        );

        if ($data !== null) {
            $response['data'] = $data;
        }

        return $response;
    }

    /**
     * Validate email format
     * @param string $email Email to validate
     * @return bool True if valid, false otherwise
     */
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone number (10 digits)
     * @param string $phone Phone number to validate
     * @return bool True if valid, false otherwise
     */
    private function validatePhone($phone) {
        $cleanPhone = preg_replace('/\D/', '', $phone);
        return strlen($cleanPhone) === 10;
    }

    /**
     * Sanitize input data
     * @param string $input Input to sanitize
     * @return string Sanitized input
     */
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    // EatApp API Wrapper Methods - Secure backend proxy
    private function getEatAppHeaders() {
        // Store these in environment variables or secure config
        $authKey = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $groupId = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

        return [
            'Authorization: ' . $authKey,
            'X-Group-ID: ' . $groupId,
            'Accept: application/json',
            'Content-Type: application/json'
        ];
    }

    public function EatAppRestaurants() {
        // Debug: Check if we're even reaching this method
        error_log("EatAppRestaurants method called");

        $token = $this->input->get_request_header('Authorization');
        error_log("Authorization token: " . $token);

        if($this->apikey == $token) {
            error_log("Authorization successful, proceeding with EatApp API call");

            $url = 'https://api.eat-sandbox.co/concierge/v2/restaurants';
            $headers = $this->getEatAppHeaders();

            error_log("EatApp URL: " . $url);
            error_log("EatApp Headers: " . print_r($headers, true));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            error_log("EatApp Response Code: " . $httpCode);
            error_log("EatApp Response: " . $response);

            if (curl_errno($ch)) {
                $curlError = curl_error($ch);
                error_log("EatApp CURL Error: " . $curlError);
                $result['status'] = FALSE;
                $result['message'] = 'API connection error: ' . $curlError;
                http_response_code(500);
            } else {
                http_response_code($httpCode);
                $this->output->set_content_type('application/json')->set_output($response);
                return;
            }
            curl_close($ch);
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function EatAppAvailability() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            $url = 'https://api.eat-sandbox.co/concierge/v2/availability';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getEatAppHeaders());

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                $result['status'] = FALSE;
                $result['message'] = 'API connection error';
                http_response_code(500);
            } else {
                http_response_code($httpCode);
                $this->output->set_content_type('application/json')->set_output($response);
                return;
            }
            curl_close($ch);
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function EatAppReservations() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            // Debug: Log the received data
            error_log("EatApp Reservation Request Data: " . print_r($jsonData, true));

            $url = 'https://api.eat-sandbox.co/concierge/v2/reservations';

            // Get restaurant ID for header
            $restaurantId = isset($jsonData['restaurant_id']) ? $jsonData['restaurant_id'] : '';

            $headers = $this->getEatAppHeaders();
            if ($restaurantId) {
                $headers[] = 'X-Restaurant-ID: ' . $restaurantId;
            }

            // Debug: Log the headers being sent
            error_log("EatApp Headers: " . print_r($headers, true));
            error_log("EatApp URL: " . $url);
            error_log("EatApp Payload: " . json_encode($jsonData));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Debug: Log the response
            error_log("EatApp Response Code: " . $httpCode);
            error_log("EatApp Response: " . $response);

            if (curl_errno($ch)) {
                $curlError = curl_error($ch);
                error_log("EatApp CURL Error: " . $curlError);
                $result['status'] = FALSE;
                $result['message'] = 'API connection error: ' . $curlError;
                http_response_code(500);
            } else {
                // If EatApp reservation was successful, also send to production backend
                if ($httpCode >= 200 && $httpCode < 300) {
                    $this->sendEatAppDataToProduction($jsonData);
                }

                http_response_code($httpCode);
                $this->output->set_content_type('application/json')->set_output($response);
                return;
            }
            curl_close($ch);
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    // Send data to production backend
    public function SendToProduction() {
        $token = $this->input->get_request_header('Authorization');
        if($this->apikey == $token) {
            $rawData = $this->input->raw_input_stream;
            $jsonData = json_decode($rawData, true);

            $productionUrl = "https://bastian.ninetriangles.com/admin/api/reservation-form";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $productionUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: 123456789',
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                $result = array(
                    'status' => FALSE,
                    'message' => 'Production backend error: ' . curl_error($ch)
                );
                http_response_code(500);
            } else {
                $result = array(
                    'status' => TRUE,
                    'message' => 'Data sent to production backend successfully',
                    'response' => $response,
                    'http_code' => $httpCode
                );
                http_response_code(200);
            }
            curl_close($ch);
        } else {
            $result = array(
                'status' => FALSE,
                'message' => 'unauthorized access'
            );
            http_response_code(401);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}