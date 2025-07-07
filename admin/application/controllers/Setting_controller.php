<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting_controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date( 'Y-m-d H:i:s', time () );
		$user_id = @$_SESSION['admin_logged_in']['id'];
		$this->getUserData = $this->user_model->Userdatad($user_id);
		$user_role = @$this->getUserData->user_type;
		$get_roles = $this->user_model->viewRoledata($user_role);
		if(!empty($get_roles)) {
			$this->role_list = explode(",",@$get_roles->roles);
		} else {
			$this->role_list = '';
		}
        $config['upload_path']   = './uploads/images/';
		$config['allowed_types'] = 'jpg|png|jpeg|svg|webp|ico'; 
		$config['max_size']      = 3000;
        $this->load->library('upload', $config);
	}
    public function addSettings() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $id = $this->input->post('id');
            $checkSetting = $this->setting_model->CheckSetting($this->input->post('setting_name'));
            if(!empty($checkSetting) && empty($id)) {
                $result['status'] = 'already';
                echo json_encode($result);
            } else {
                if(@$_FILES['filelogo']['name']){
                    if(!$this->upload->do_upload('filelogo')){
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error); die;
                    }
                    $m_data = $this->upload->data();
                    $logo_image = 'uploads/images/'.$m_data['file_name'];
                    if(empty($id)) {
                        $data = array(
                            'id' =>  $this->input->post('id'),
                            'setting_name' => $this->input->post('setting_name'),
                            'setting_value' =>  $logo_image,
                            'insert_date' => $this->currentTime,
                            'edit_date' => $this->currentTime
                        );
                    } else {
                        $data = array(
                            'id' =>  $this->input->post('id'),
                            'setting_name' => $this->input->post('setting_name'),
                            'setting_value' =>  $logo_image,
                            'edit_date' => $this->currentTime
                        );
                    }
                } else {
                    if(empty($id)) {
                        $data = array(
                            'id' =>  $this->input->post('id'),
                            'setting_name' => $this->input->post('setting_name'),
                            'setting_value' =>  $this->input->post('setting_value'),
                            'insert_date' => $this->currentTime,
                            'edit_date' => $this->currentTime
                        );
                    } else {
                        $data = array(
                            'id' =>  $this->input->post('id'),
                            'setting_name' => $this->input->post('setting_name'),
                            'setting_value' =>  $this->input->post('setting_value'),
                            'edit_date' => $this->currentTime
                        );
                    }
                }
                $AddData = $this->setting_model->AddSettings($data);
                if($AddData == TRUE) {
                    $result['status'] = 'true';
                    $result['values'] = $AddData;
					echo json_encode($result);
                } else {
                    $result['status'] = 'true';
					echo json_encode($result);
                }
            }
        }
    }
    public function SettingTrash() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $data = array (
                'id' =>  $this->input->post('id'),
                'status' => '2',
                'edit_date' => $this->currentTime
            );	
            $result['del'] = $this->setting_model->AddSettings($data);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    public function SettingTrashReverse() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $data = array (
                'id' =>  $this->input->post('id'),
                'status' => '1',
                'edit_date' => $this->currentTime
            );	
            $result['del'] = $this->setting_model->AddSettings($data);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
	public function SettingTrashPerma() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $id = $this->input->post('id');	
            $result['del']=$this->setting_model->SettingDel($id);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
	}
    public function UpdateSMTP() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('smtp_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $data  = array(
				'id' => $this->input->post('id'),
				'smtp_service' => $this->input->post('smtp_service'),
				'smtp_crypto' => $this->input->post('smtp_crypto'),
				'mail_type' => $this->input->post('mail_type'),
				'mail_host' => $this->input->post('mail_host'),
				'mail_username' => $this->input->post('mail_username'),
				'mail_port' => $this->input->post('mail_port'),
				'mail_password' => $this->input->post('mail_password'),
				'update_date' => $this->currentTime
			);
			$AddData = $this->setting_model->UpdateSMTP($data);
            if($AddData == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
}