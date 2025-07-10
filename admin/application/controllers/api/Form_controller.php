<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
 
class form_controller extends CI_Controller { 
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

            // COMMENTED OUT: Database saving moved to new EatApp system to prevent duplicate entries
            // The new ReservationEatApp.jsx component now handles both database saving AND EatApp integration
            // This old system is kept for backward compatibility but database operations are disabled
            /*
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
            */

            // Return success response for backward compatibility
            // Frontend will continue to work, but data is now handled by EatApp system
            $result['status'] = TRUE;
            $result['message'] = 'Reservation request received. Please use the new reservation system for complete functionality.';
            http_response_code(200);
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

            // COMMENTED OUT: Database saving moved to new EatApp system to prevent duplicate entries
            // The new ReservationEatApp.jsx component now handles both database saving AND EatApp integration
            // This old system is kept for backward compatibility but database operations are disabled
            /*
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
            $AddData = $this->form_model->AddFormDetailsData($data);
            if($AddData == TRUE) {
                $result['status'] = TRUE;
                http_response_code(200);
            } else {
                $result['status'] = FALSE;
                http_response_code(400);
            }
            */

            // Return success without database operation to maintain API compatibility
            $result['status'] = TRUE;
            $result['message'] = 'Reservation handled by new EatApp system';
            http_response_code(200);
        } else {
            $result['status'] = FALSE;
            $result['message'] = 'unauthorized access';
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
    // function sendDataAfterInsert($formData) {
    //     $url = "https://edyne.dytel.co.in/postbastianreservation.asp?SourceId=71&SourcePwd=!Online@2024&OutletCode=".urlencode($formData->restaurant_id)."&OutletPwd=BASTIANDEMO&CustomerName=" . urlencode($formData->full_name) . "&CustomerMobile=" . urlencode($formData->contact_number) . "&CountryCode=91&ReservationDate=" . urlencode(date('d-M-Y', strtotime($formData->booking_date))) . "&ReservationTime=00:00&Covers=" . urlencode($formData->pax) . "&Occasion=&Remarks=&AdvancePaid=0&DiscountPercentage=15&DiscountAmount=0";
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo 'Error: ' . curl_error($ch);
    //     }
    //     curl_close($ch);
    //     return $response;
    // }
}