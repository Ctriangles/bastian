<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Form_controller extends CI_Controller {
    public function __construct() {  
        parent::__construct(); 
        date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date( 'Y-m-d H:i:s', time () );
        $this->apikey = '123456789';
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
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

    // Reusable authentication check
    private function checkAuth() {
        $token = $this->input->get_request_header('Authorization');
        return $this->apikey === $token;
    }

    // Reusable method for sending emails
    private function sendEmail($subject, $template, $data, $replyTo) {
        $this->email->from(@$this->site_emailfrom, "Bastian Hospitality");
        $this->email->to(@$this->site_emailto);
        $this->email->reply_to($replyTo);
        $this->email->subject($subject);
        $body = $this->load->view("email_template/$template", $data, TRUE);
        $this->email->message($body);
        $this->email->set_newline("\r\n");
        return $this->email->send();
    }

    // Reusable method for JSON response
    private function sendJsonResponse($status, $message = '', $data = null, $httpCode = 200) {
        $result = array(
            'status' => $status,
            'message' => $message
        );
        if ($data !== null) {
            $result['data'] = $data;
        }
        http_response_code($httpCode);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    // Validate required fields
    private function validateFormData($jsonData, $requiredFields) {
        foreach ($requiredFields as $field) {
            if (!isset($jsonData->formvalue->$field) || empty($jsonData->formvalue->$field)) {
                return "Field '$field' is required";
            }
        }
        return null; // No validation errors
    }

    public function HeaderForm() {
        if (!$this->checkAuth()) {
            $this->sendJsonResponse(false, 'Unauthorized access', null, 401);
            return;
        }

        $rawData = $this->input->raw_input_stream;
        $jsonData = json_decode($rawData);

        // Validate required fields
        $requiredFields = ['restaurant_id', 'booking_date', 'pax', 'full_name', 'email', 'mobile'];
        $validationError = $this->validateFormData($jsonData, $requiredFields);
        if ($validationError) {
            $this->sendJsonResponse(false, $validationError, null, 400);
            return;
        }

        $data = array(
            'id' => '',
            'restaurant_id' => $jsonData->formvalue->restaurant_id,
            'booking_date' => date('Y-m-d', strtotime($jsonData->formvalue->booking_date)),
            'pax' => $jsonData->formvalue->pax,
            'full_name' => $jsonData->formvalue->full_name,
            'email_id' => $jsonData->formvalue->email,
            'contact_number' => $jsonData->formvalue->mobile,
            'age' => $jsonData->formvalue->age ?? '25',
            'pin_code' => $jsonData->formvalue->pincode ?? '400001',
            'insert_date' => $this->currentTime,
            'edit_date' => $this->currentTime
        );

        $AddData = $this->form_model->AddFormDetailsData($data);
        if($AddData == TRUE) {
            // Send email using reusable method
            $results['message'] = $this->form_model->ReservationdataById($AddData);
            $this->sendEmail(
                "Bastian Hospitality Reservation Form | ".$data['full_name'],
                'contactform',
                $results,
                $data['email_id']
            );

            // Send to external APIs
            $externalResult = $this->sendDataAfterInsert($results['message']);

            $this->sendJsonResponse(true, 'Reservation submitted successfully', $externalResult);
        } else {
            $this->sendJsonResponse(false, 'Failed to save reservation to database', null, 400);
        }
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
        if (!$this->checkAuth()) {
            $this->sendJsonResponse(false, 'Unauthorized access', null, 401);
            return;
        }

        $rawData = $this->input->raw_input_stream;
        $jsonData = json_decode($rawData);

        // Validate required fields
        $requiredFields = ['restaurant_id', 'booking_date', 'full_name', 'email', 'mobile', 'pax'];
        $validationError = $this->validateFormData($jsonData, $requiredFields);
        if ($validationError) {
            $this->sendJsonResponse(false, $validationError, null, 400);
            return;
        }

        // Validate email format
        if (!filter_var($jsonData->formvalue->email, FILTER_VALIDATE_EMAIL)) {
            $this->sendJsonResponse(false, 'Invalid email address', null, 400);
            return;
        }

        $data = array(
            'id' => '',
            'restaurant_id' => $jsonData->formvalue->restaurant_id,
            'pax' => $jsonData->formvalue->pax,
            'booking_date' => $jsonData->formvalue->booking_date,
            'booking_time' => $jsonData->formvalue->booking_time ?? '19:00',
            'full_name' => $jsonData->formvalue->full_name,
            'email_id' => $jsonData->formvalue->email,
            'contact_number' => $jsonData->formvalue->mobile,
            'age' => $jsonData->formvalue->age ?? '25',
            'pin_code' => $jsonData->formvalue->pincode ?? '400001',
            'comments' => $jsonData->formvalue->comments ?? '',
            'insert_date' => $this->currentTime,
            'edit_date' => $this->currentTime
        );

        $AddData = $this->form_model->AddFormDetailsData($data);
        if($AddData == TRUE) {
            // Send email using reusable method
            $results['message'] = $this->form_model->ReservationdataById($AddData);
            $this->sendEmail(
                "Bastian Hospitality Reservation Form | ".$data['full_name'],
                'contactform',
                $results,
                $data['email_id']
            );

            // Send to external APIs only after successful database insertion
            $externalApiResult = $this->sendDataAfterInsert($results['message']);

            $this->sendJsonResponse(true, 'Reservation submitted successfully', $externalApiResult);
        } else {
            $this->sendJsonResponse(false, 'Failed to save reservation to database', null, 400);
        }
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
        // $url = "https://edyne.dytel.co.in/postbastianreservation.asp?SourceId=71&SourcePwd=!Online@2024&OutletCode=" . urlencode($formData->restaurant_id) . "&OutletPwd=BASTIANDEMO&CustomerName=" . urlencode($formData->full_name) . "&CustomerMobile=" . urlencode($formData->contact_number) . "&CountryCode=91&ReservationDate=" . urlencode(date('d-M-Y', strtotime($formData->booking_date))) . "&ReservationTime=00:00&Covers=" . urlencode($formData->pax) . "&Occasion=&Remarks=&AdvancePaid=0&DiscountPercentage=15&DiscountAmount=0";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            // Log or handle cURL error
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'error' => $error,
                'http_code' => $httpCode,
                'response' => null
            ];
        }

        curl_close($ch);

        // Check HTTP response code
        if ($httpCode >= 200 && $httpCode < 300) {
            // Only send to EatApp if the first API call was successful
            $eatAppResult = $this->sendToEatApp($formData);
            return [
                'success' => true,
                'http_code' => $httpCode,
                'response' => $response,
                'eatapp_result' => $eatAppResult
            ];
        } else {
            return [
                'success' => false,
                'http_code' => $httpCode,
                'response' => $response
            ];
        }
    }

    // Secure EatApp API wrapper - credentials hidden from frontend
    private function sendToEatApp($formData) {
        $eatAppUrl = 'https://api.eat-sandbox.co/concierge/v2/reservations';
        $eatAppAuthKey = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $eatAppGroupID = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

        // Format the booking time properly
        $bookingTime = isset($formData->booking_time) ? $formData->booking_time : '19:00';

        // Create proper datetime string for EatApp
        $reservationDateTime = $formData->booking_date . 'T' . $bookingTime . ':00';

        // Try different EatApp API formats
        $reservationData = array(
            'restaurant_id' => $formData->restaurant_id,
            'start_time' => $reservationDateTime,
            'covers' => (int)$formData->pax,
            'customer' => array(
                'name' => $formData->full_name,
                'email' => $formData->email_id,
                'phone' => $formData->contact_number
            ),
            'notes' => isset($formData->comments) ? $formData->comments : 'Reservation from Bastian website',
            'source' => 'website'
        );

        error_log('EatApp Reservation Data: ' . json_encode($reservationData));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $eatAppUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reservationData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $eatAppAuthKey,
            'X-Group-ID: ' . $eatAppGroupID,
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Bastian-Website/1.0'
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            error_log('EatApp API Error: ' . $error);
            return [
                'success' => false,
                'error' => $error,
                'http_code' => $httpCode,
                'response' => null
            ];
        }

        curl_close($ch);

        // Check HTTP response code
        if ($httpCode >= 200 && $httpCode < 300) {
            error_log('EatApp API Success (HTTP ' . $httpCode . '): ' . $response);
            return [
                'success' => true,
                'http_code' => $httpCode,
                'response' => $response
            ];
        } else {
            error_log('EatApp API Error (HTTP ' . $httpCode . '): ' . $response);

            // For sandbox environment, treat certain errors as expected
            $responseData = json_decode($response, true);
            if (isset($responseData['error_code']) && $responseData['error_code'] === 'restaurant_id_required') {
                error_log('EatApp Sandbox Limitation: Restaurant ID validation issue - this is expected in sandbox environment');
                return [
                    'success' => false,
                    'http_code' => $httpCode,
                    'response' => $response,
                    'note' => 'EatApp sandbox limitation - reservation saved to local database successfully'
                ];
            }

            return [
                'success' => false,
                'http_code' => $httpCode,
                'response' => $response
            ];
        }
    }

    // Test endpoint
    public function test() {
        $result['status'] = true;
        $result['message'] = 'Test endpoint working';
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    // Secure wrapper for EatApp restaurants API
    public function getRestaurants() {
        if (!$this->checkAuth()) {
            $this->sendJsonResponse(false, 'Unauthorized access', null, 401);
            return;
        }

        $eatAppUrl = 'https://api.eat-sandbox.co/concierge/v2/restaurants';
        $eatAppAuthKey = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $eatAppGroupID = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $eatAppUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $eatAppAuthKey,
            'X-Group-ID: ' . $eatAppGroupID,
            'Accept: application/json'
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            curl_close($ch);
            $this->sendJsonResponse(false, 'Failed to fetch restaurants', ['error' => curl_error($ch)], 500);
            return;
        }

        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            $result = json_decode($response, true);
            $this->sendJsonResponse(true, 'Restaurants fetched successfully', $result);
        } else {
            $this->sendJsonResponse(false, 'Failed to fetch restaurants from EatApp', [
                'http_code' => $httpCode,
                'response' => $response
            ], $httpCode);
        }
    }

    // Secure wrapper for EatApp availability API
    public function getAvailability() {
        if (!$this->checkAuth()) {
            $this->sendJsonResponse(false, 'Unauthorized access', null, 401);
            return;
        }

        $rawData = $this->input->raw_input_stream;
        $jsonData = json_decode($rawData);

        // Validate required parameters
        if (!$jsonData || !isset($jsonData->restaurant_id) || !isset($jsonData->date) || !isset($jsonData->covers)) {
            $this->sendJsonResponse(false, 'Missing required parameters: restaurant_id, date, covers', null, 400);
            return;
        }

        $eatAppUrl = 'https://api.eat-sandbox.co/concierge/v2/availability';
        $eatAppAuthKey = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $eatAppGroupID = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

        // Build query parameters
        $queryParams = http_build_query([
            'restaurant_id' => $jsonData->restaurant_id,
            'date' => $jsonData->date,
            'covers' => $jsonData->covers
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $eatAppUrl . '?' . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $eatAppAuthKey,
            'X-Group-ID: ' . $eatAppGroupID,
            'Accept: application/json'
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            curl_close($ch);
            $this->sendJsonResponse(false, 'Failed to fetch availability', ['error' => curl_error($ch)], 500);
            return;
        }

        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            $result = json_decode($response, true);
            $this->sendJsonResponse(true, 'Availability fetched successfully', $result);
        } else {
            $this->sendJsonResponse(false, 'Failed to fetch availability from EatApp', [
                'http_code' => $httpCode,
                'response' => $response
            ], $httpCode);
        }
    }
}