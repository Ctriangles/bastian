<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Form_controller extends CI_Controller { 
    /**
     * Site email configuration 
     */
    protected $site_emailfrom;
    protected $site_emailto;
    protected $currentTime;
    protected $apikey;
    protected $result;
    protected $form_model;
    protected $setting_model;
    protected $email;
    protected $input;
    protected $output;
    protected $db;
    protected $url;

    /**
     * Class constructor
     */
    public function __construct() {  
        parent::__construct(); 
        
        // Set timezone and current time
        date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date('Y-m-d H:i:s', time());
        $this->apikey = '123456789';
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 204 No Content');
            exit;
        }
        
        // Load settings from model
        $settings = $this->setting_model->viewSitedata();
        foreach ($settings as $setting) {
            if ($setting->setting_name == 'site_emailfrom') {
                $this->site_emailfrom = $setting->setting_value;
            } else if ($setting->setting_name == 'site_emailto') {
                $this->site_emailto = $setting->setting_value;
            }
        }

        // Configure email settings
        $smtpdata = $this->setting_model->viewSMTPdata();
        if ($smtpdata) {
            $config = array(
                'protocol' => $smtpdata->smtp_service,
                'smtp_host' => $smtpdata->mail_host,
                'smtp_port' => $smtpdata->mail_port,
                'smtp_user' => $smtpdata->mail_username,
                'smtp_pass' => $smtpdata->mail_password,
                'smtp_crypto' => $smtpdata->smtp_crypto,
                'mailtype' => $smtpdata->mail_type,
                'smtp_timeout' => '30',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'wordwrap' => TRUE
            );
            $this->email->initialize($config);
        }
        
        // Initialize response variable
        $this->result = array();
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
                // Now create reservation in EatApp
                try {
                    $eatapp_data = array(
                        'restaurant_id' => $jsonData->formvalue->restaurant_id,
                        'covers' => intval($jsonData->formvalue->pax),
                        'start_time' => $jsonData->formvalue->booking_date . 'T13:00:00Z', // Use lunch time which should be available
                        'first_name' => explode(' ', $jsonData->formvalue->full_name)[0],
                        'last_name' => count(explode(' ', $jsonData->formvalue->full_name)) > 1 ? implode(' ', array_slice(explode(' ', $jsonData->formvalue->full_name), 1)) : '',
                        'email' => $jsonData->formvalue->email,
                        'phone' => $jsonData->formvalue->mobile,
                        'notes' => ''
                    );
                    
                    // Call the secure Eatapp_controller method that saves to database first
                    $eatapp_response = $this->create_secure_eatapp_reservation($eatapp_data);
                    
                    if($eatapp_response['success']) {
                        // Send email notification
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
                        $result['message'] = 'Reservation created successfully';
                        $result['eatapp_data'] = $eatapp_response['data'];
                        $result['payment_url'] = $eatapp_response['payment_url'];
                        $result['payment_required'] = $eatapp_response['payment_required'];
                        $result['local_id'] = $eatapp_response['local_id'];
                        http_response_code(200);
                    } else {
                        $result['status'] = FALSE;
                        $result['message'] = 'Failed to create reservation in EatApp';
                        $result['error'] = $eatapp_response['error'];
                        $result['local_id'] = $eatapp_response['local_id'] ?? null;
                        http_response_code(500);
                    }
                } catch (Exception $e) {
                    $result['status'] = FALSE;
                    $result['message'] = 'Error creating reservation in EatApp';
                    $result['error'] = $e->getMessage();
                    http_response_code(500);
                }
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Failed to save reservation locally';
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
        error_log("🔵 BACKEND DEBUG: ReservationForm method called");
        
        $token = $this->input->get_request_header('Authorization');
        error_log("🔑 BACKEND DEBUG: Authorization token: " . $token);
        error_log("🔑 BACKEND DEBUG: Expected API key: " . $this->apikey);
        
        if($this->apikey == $token) {
            error_log("✅ BACKEND DEBUG: Authorization successful");
            
            $rawData = $this->input->raw_input_stream;
            error_log("📥 BACKEND DEBUG: Raw input data: " . $rawData);
            
            $jsonData = json_decode($rawData);
            error_log("📦 BACKEND DEBUG: Decoded JSON data: " . json_encode($jsonData));
            
            // Save to local database first
            $data = array(
                'id' => '',
                'restaurant_id' => $jsonData->formvalue->restaurant_id,
                'pax' => $jsonData->formvalue->pax,
                'booking_date' => $jsonData->formvalue->booking_date,
                'booking_time' => $jsonData->formvalue->booking_time,
                'full_name' => $jsonData->formvalue->full_name,
                'email_id' => $jsonData->formvalue->email,
                'contact_number' => $jsonData->formvalue->mobile,
                'age' => $jsonData->formvalue->age,
                'pin_code' => $jsonData->formvalue->pincode,
                'comments' => $jsonData->formvalue->comments,
                'edit_date' => $this->currentTime
            );
            
            error_log("💾 BACKEND DEBUG: Local database data prepared: " . json_encode($data));
            
            $AddData = $this->form_model->AddFormDetailsData($data);
            error_log("💾 BACKEND DEBUG: Local database save result: " . ($AddData ? 'SUCCESS' : 'FAILED'));
            
            if($AddData == TRUE) {
                // Now create reservation in EatApp using the secure database-first approach
                try {
                    $eatapp_data = array(
                        'restaurant_id' => $jsonData->formvalue->restaurant_id,
                        'covers' => intval($jsonData->formvalue->pax),
                        'start_time' => $jsonData->formvalue->booking_date . 'T' . $jsonData->formvalue->booking_time,
                        'first_name' => explode(' ', $jsonData->formvalue->full_name)[0],
                        'last_name' => count(explode(' ', $jsonData->formvalue->full_name)) > 1 ? implode(' ', array_slice(explode(' ', $jsonData->formvalue->full_name), 1)) : '',
                        'email' => $jsonData->formvalue->email,
                        'phone' => $jsonData->formvalue->mobile,
                        'notes' => isset($jsonData->formvalue->comments) ? $jsonData->formvalue->comments : ''
                    );
                    
                    error_log("🍽️ BACKEND DEBUG: EatApp data prepared: " . json_encode($eatapp_data));
                    
                    // Call the secure Eatapp_controller method that saves to database first
                    $eatapp_response = $this->create_secure_eatapp_reservation($eatapp_data);
                    error_log("🍽️ BACKEND DEBUG: EatApp response received: " . json_encode($eatapp_response));
                    
                    if($eatapp_response['success']) {
                        error_log("✅ BACKEND DEBUG: EatApp reservation successful");
                        $result['status'] = TRUE;
                        $result['message'] = 'Reservation created successfully';
                        $result['eatapp_data'] = $eatapp_response['data'];
                        $result['payment_url'] = $eatapp_response['payment_url'];
                        $result['payment_required'] = $eatapp_response['payment_required'];
                        $result['local_id'] = $eatapp_response['local_id'];
                        http_response_code(200);
                    } else {
                        error_log("❌ BACKEND DEBUG: EatApp reservation failed");
                        error_log("❌ BACKEND DEBUG: EatApp error: " . json_encode($eatapp_response['error']));
                        $result['status'] = FALSE;
                        $result['message'] = 'Failed to create reservation in EatApp';
                        $result['error'] = $eatapp_response['error'];
                        $result['local_id'] = $eatapp_response['local_id'] ?? null;
                        http_response_code(500);
                    }
                } catch (Exception $e) {
                    error_log("💥 BACKEND DEBUG: Exception in EatApp reservation: " . $e->getMessage());
                    error_log("💥 BACKEND DEBUG: Exception trace: " . $e->getTraceAsString());
                    $result['status'] = FALSE;
                    $result['message'] = 'Error creating reservation in EatApp';
                    $result['error'] = $e->getMessage();
                    http_response_code(500);
                }
            } else {
                error_log("❌ BACKEND DEBUG: Local database save failed");
                $result['status'] = FALSE;
                $result['message'] = 'Failed to save reservation locally';
                http_response_code(400);
            }
        } else {
            error_log("❌ BACKEND DEBUG: Authorization failed");
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
            http_response_code(401);
        }
        
        error_log("📤 BACKEND DEBUG: Final response: " . json_encode($result));
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
                // Now create reservation in EatApp using the secure database-first approach
                try {
                    $eatapp_data = array(
                        'restaurant_id' => $getshortdata->restaurant_id,
                        'covers' => intval($getshortdata->pax),
                        'start_time' => $getshortdata->booking_date . 'T12:00:00Z', // Default time if not specified
                        'first_name' => explode(' ', $jsonData->formvalue->full_name)[0],
                        'last_name' => count(explode(' ', $jsonData->formvalue->full_name)) > 1 ? implode(' ', array_slice(explode(' ', $jsonData->formvalue->full_name), 1)) : '',
                        'email' => $jsonData->formvalue->email,
                        'phone' => $jsonData->formvalue->mobile,
                        'notes' => ''
                    );
                    
                    // Call the secure Eatapp_controller method that saves to database first
                    $eatapp_response = $this->create_secure_eatapp_reservation($eatapp_data);
                    
                    if($eatapp_response['success']) {
                        // Send email notification
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
                        $result['message'] = 'Reservation created successfully';
                        $result['eatapp_data'] = $eatapp_response['data'];
                        $result['payment_url'] = $eatapp_response['payment_url'];
                        $result['payment_required'] = $eatapp_response['payment_required'];
                        http_response_code(200);
                    } else {
                        $result['status'] = FALSE;
                        $result['message'] = 'Failed to create reservation in EatApp';
                        $result['error'] = $eatapp_response['error'];
                        http_response_code(500);
                    }
                } catch (Exception $e) {
                    $result['status'] = FALSE;
                    $result['message'] = 'Error creating reservation in EatApp';
                    $result['error'] = $e->getMessage();
                    http_response_code(500);
                }
            } else {
                $result['status'] = FALSE;
                $result['message'] = 'Failed to save reservation locally';
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
        $url = "https://edyne.dytel.co.in/postbastianreservation.asp?SourceId=71&SourcePwd=!Online@2024&OutletCode=".urlencode($formData->restaurant_id)."&OutletPwd=BASTIANDEMO&CustomerName=" . urlencode($formData->full_name) . "&CustomerMobile=" . urlencode($formData->contact_number) . "&CountryCode=91&ReservationDate=" . urlencode(date('d-M-Y', strtotime($formData->booking_date))) . "&ReservationTime=00:00&Covers=" . urlencode($formData->pax) . "&Occasion=&Remarks=&AdvancePaid=0&DiscountPercentage=15&DiscountAmount=0";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
    
    /**
     * Create a secure reservation using database-first approach
     */
    private function create_secure_eatapp_reservation($jsonData) {
        try {
            // STEP 1: Store in our database FIRST (ensures data is never lost)
            $local_reservation_id = $this->store_reservation_locally($jsonData);

            if(!$local_reservation_id) {
                return array(
                    'success' => false,
                    'error' => 'Failed to save reservation locally',
                    'local_id' => null
                );
            }

            // STEP 2: Try to send to EatApp
            $eatapp_response = $this->create_eatapp_reservation($jsonData);
            
            if($eatapp_response['success']) {
                // STEP 3: Update our database with EatApp response
                $this->update_reservation_with_eatapp_response($local_reservation_id, $eatapp_response['data'], 'confirmed');
                
                return array(
                    'success' => true,
                    'data' => $eatapp_response['data'],
                    'payment_url' => $eatapp_response['payment_url'],
                    'payment_required' => $eatapp_response['payment_required'],
                    'local_id' => $local_reservation_id
                );
            } else {
                // EatApp API call failed - mark as failed but keep local reservation
                $this->update_reservation_with_eatapp_response($local_reservation_id, null, 'failed');
                
                return array(
                    'success' => false,
                    'error' => $eatapp_response['error'],
                    'local_id' => $local_reservation_id
                );
            }
        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => 'Error creating reservation: ' . $e->getMessage(),
                'local_id' => null
            );
        }
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
     * Create reservation in EatApp API
     */
    private function create_eatapp_reservation($jsonData) {
        // EatApp API Configuration
        $eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
        $eatapp_auth_key = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
        $eatapp_group_id = '4bcc6bdd-765b-4486-83ab-17c175dc3910';
        
        $api_headers = array(
            'Authorization: ' . $eatapp_auth_key,
            'X-Group-ID: ' . $eatapp_group_id,
            'Accept: application/json',
            'Content-Type: application/json'
        );
        
        try {
            error_log("create_eatapp_reservation called with data: " . json_encode($jsonData));
            
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
            $headers = $api_headers;
            $headers[] = 'X-Restaurant-ID: ' . $jsonData['restaurant_id'];

            error_log("create_eatapp_reservation - POST data: " . json_encode($postData));
            $response = $this->make_curl_request($eatapp_api_url . '/reservations', 'POST', $postData, $headers);
            error_log("create_eatapp_reservation - response: " . json_encode($response));
            
            if($response['success']) {
                $responseData = json_decode($response['data'], true);
                
                if($response['http_code'] == 201 && isset($responseData['data']['attributes']['key'])) {
                    // Extract payment URL from response
                    $payment_url = $this->extract_payment_url($responseData);
                    
                    return array(
                        'success' => true,
                        'data' => $responseData,
                        'payment_url' => $payment_url,
                        'payment_required' => $payment_url ? true : false
                    );
                                    } else {
                        // Check for specific error codes from EatApp
                        $error_code = null;
                        $error_message = 'Failed to create reservation in EatApp';
                        
                        if(isset($responseData['error_code'])) {
                            $error_code = $responseData['error_code'];
                            $error_message = $responseData['error_message'] ?? $error_message;
                        }
                        
                        return array(
                            'success' => false,
                            'error' => $error_code ?: 'Failed to create reservation in EatApp',
                            'error_code' => $error_code,
                            'error_message' => $error_message,
                            'data' => $responseData
                        );
                    }
            } else {
                return array(
                    'success' => false,
                    'error' => $response['error'],
                    'http_code' => $response['http_code']
                );
            }
        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
    }
    
    /**
     * Extract payment widget URL from EatApp response
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
        elseif(isset($responseData['payment_url'])) {
            $payment_url = $responseData['payment_url'];
        }
        
        return $payment_url;
    }

    /**
     * Make CURL request to EatApp API
     */
    private function make_curl_request($url, $method = 'GET', $data = null, $custom_headers = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);

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