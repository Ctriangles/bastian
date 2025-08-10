<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class user_controller extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();	 
		date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date( 'Y-m-d H:i:s', time () );
		$user_id = @$_SESSION['admin_logged_in']['id'];
		$getUserData = $this->user_model->Userdatad($user_id);
		$user_role = @$getUserData->user_type;
		$get_roles = $this->user_model->viewRoledata($user_role);
		if(!empty($get_roles)) {
			$this->role_list = explode(",",@$get_roles->roles);
		} else {
			$this->role_list = '';
		}
	}
	public function backend_login() {
		$remember_me_token = get_cookie('remember_me_token');
		// Always hash the password for database comparison
		$password = md5($this->input->post('password'));
		$data = array(
			'user_name' =>  $this->input->post('username'),
			'password' => $password,
		);
		
		$result = $this->user_model->Backendlogin($data);
		
		if(!empty($result)) {
			$session_data = array(
				'id' => $result->id
			);
			$this->session->set_userdata('admin_logged_in', $session_data);
			
			echo 'true';
			exit; // Stop execution here to prevent any extra output
			$login = array(
				'id' => '',
				'user_id' => $result->id,
				'login_ip' => @$this->input->ip_address(),
				'login_browser' => $this->agent->browser(),
				'login_os' => $this->agent->platform(),
				'login_date' => $this->currentTime
			);
			$AddData = $this->user_model->AddLoginData($login);
			if($AddData == TRUE) {
				$remember_me = $this->input->post('remember_me');
				if ($remember_me) {
					$token = bin2hex(random_bytes(16));
					$cookie_config = array(
						'name'   => 'remember_me_token',
						'value'  => $token,
						'expire' => 86400 * 30,
						'path'   => '/',  
						'domain' => '', 
						'secure' => FALSE,
						'httponly' => FALSE
					);
					$this->input->set_cookie($cookie_config);
					$Auth = array(
						'id' => $result->id,
						'auth_token' => $token
					);
					$UpdateAuth = $this->user_model->AddUser($Auth);
				}
			}
		} else {
			echo 'emailexist';
			exit; // Stop execution here to prevent any extra output
		}
	}
	public function backend_logout() {
		$sess_array = array(
			'id' => ''
		);
		$this->session->unset_userdata('admin_logged_in', $sess_array);
		unset($_SESSION["end_time"]);
		$this->session->unset_userdata('userData');
		redirect(site_url('backend/'));
	}
	public function AddRoles() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$checkRoles = $this->user_model->CheckRoles($this->input->post('role_name'));
			if(!empty($checkRoles) && empty($id)) {
				$result['status'] = 'already';
				echo json_encode($result);
			} else {
				$role = $this->input->post('roles');
				if(!empty($role)) {
					$final_role = implode(',', $role);
				} else {
					$final_role = '';
				}
				if(empty($id)) {
					$data = array(
						'id' => $this->input->post('id'),
						'role_name' => $this->input->post('role_name'),
						'roles' => $final_role,
						'insert_date' => $this->currentTime,
						'edit_date' => $this->currentTime
					);
				} else {
					$data = array(
						'id' => $this->input->post('id'),
						'role_name' => $this->input->post('role_name'),
						'roles' => $final_role,
						'edit_date' => $this->currentTime
					);
				}
				$addData = $this->user_model->AddRole($data);
				if($addData == TRUE) {
                    $result['status'] = 'true';
                    $result['values'] = $addData;
					echo json_encode($result);
				} else {
                    $result['status'] = 'false';
					echo json_encode($result);
				}
			}
		}
	}
    public function RolesTrash() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array (
				'id' =>  $this->input->post('id'),
				'status' => '2',
				'edit_date' => $this->currentTime
			);	
			$result['del'] = $this->user_model->AddRole($data);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
    }
    public function RolesTrashReverse() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array (
				'id' =>  $this->input->post('id'),
				'status' => '1',
				'edit_date' => $this->currentTime
			);	
			$result['del'] = $this->user_model->AddRole($data);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
    }
	public function RolesTrashPerma() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');	
			$result['del']=$this->user_model->RolesDel($id);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function AddUsers() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$checkUsesr = $this->user_model->CheckUserByEmail($this->input->post('username'));
			if(empty($id) && !empty($checkUsesr)) {
				$result['status'] = 'already';
				echo json_encode($result);
			} else {
				$password = $this->input->post('password');
				if(!empty($id) && !empty($password)) {
					$data = array(
						'id' => $this->input->post('id'),
						'username' => $this->input->post('username'),
						'password' => md5($this->input->post('password')),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'user_email' => $this->input->post('user_email'),
						'country_code' => $this->input->post('country_code'),
						'phone' => $this->input->post('phone'),
						'user_img' => $this->input->post('user_img'),
						'user_for' => $this->input->post('user_for'),
						'user_type' => $this->input->post('user_type'),
						'edit_date' => $this->currentTime
					);
				} else if(!empty($id) && empty($password)){
					$data = array(
						'id' => $this->input->post('id'),
						'username' => $this->input->post('username'),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'user_email' => $this->input->post('user_email'),
						'country_code' => $this->input->post('country_code'),
						'phone' => $this->input->post('phone'),
						'user_img' => $this->input->post('user_img'),
						'user_for' => $this->input->post('user_for'),
						'user_type' => $this->input->post('user_type'),
						'edit_date' => $this->currentTime
					);
				} else {
					$data = array(
						'id' => $this->input->post('id'),
						'username' => $this->input->post('username'),
						'password' => md5($this->input->post('password')),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'user_email' => $this->input->post('user_email'),
						'country_code' => $this->input->post('country_code'),
						'phone' => $this->input->post('phone'),
						'user_img' => $this->input->post('user_img'),
						'user_for' => $this->input->post('user_for'),
						'user_type' => $this->input->post('user_type'),
						'insert_date' => $this->currentTime,
						'edit_date' => $this->currentTime
					);
				}
				$AddData = $this->user_model->AddUsers($data);
				if($AddData == TRUE) {
					$details = array(
						'user_id' => $AddData,
						'biography' => $this->input->post('biography'),
						'address' => $this->input->post('address'),
						'city' => $this->input->post('city'),
						'state' => $this->input->post('state'),
						'poster_code' => $this->input->post('poster_code'),
						'country' => $this->input->post('country')
					);
					$AddDetails = $this->user_model->AddUserDetails($details);
					if($AddDetails == TRUE) {
						$result['status'] = 'true';
						$result['values'] = $AddData;
						echo json_encode($result);
					} else {
						$result['status'] = 'false';
						echo json_encode($result);
					}
				} else {
					$result['status'] = 'false';
					echo json_encode($result);
				}
			}
		}
	}
    public function UsersTrash() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array (
				'id' =>  $this->input->post('id'),
				'status' => '2',
				'edit_date' => $this->currentTime
			);	
			$result['del'] = $this->user_model->AddUsers($data);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
    }
    public function UsersTrashReverse() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array (
				'id' =>  $this->input->post('id'),
				'status' => '1',
				'edit_date' => $this->currentTime
			);	
			$result['del'] = $this->user_model->AddUsers($data);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
    }
	public function UsersTrashPerma() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');	
			$result['del']=$this->user_model->UsersDel($id);
			$results['del']=$this->user_model->UsersDetailsDel($id);
			if($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
}