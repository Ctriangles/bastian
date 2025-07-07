<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category_controller extends CI_Controller {

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
		$config['allowed_types'] = 'jpg|png|jpeg|svg|webp'; 
		$config['max_size']      = 3000;
        $this->load->library('upload', $config);
	}
	public function AddCategory() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$checkPage = $this->category_model->CheckCategory($this->input->post('cat_slug'),'blog');
			if(empty($id) && !empty($checkPage)) {
				$result['status'] = 'already';
				echo json_encode($result);
			} else {
				if(empty($id)) {
					$data = array(
						'id' => $this->input->post('id'),
						'parent_cat' => $this->input->post('parent_cat'),
						'cat_title' => $this->input->post('cat_title'),
						'cat_slug' => $this->input->post('cat_slug'),
						'cat_disc' => $this->input->post('cat_disc'),
						'cat_image' => $this->input->post('cat_image'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_keywords' => $this->input->post('meta_keywords'),
						'meta_description' => $this->input->post('meta_description'),
						'cat_type' => 'blog',
						'insert_date' => $this->currentTime,
						'edit_date' => $this->currentTime
					);
				} else {
					$data = array(
						'id' => $this->input->post('id'),
						'parent_cat' => $this->input->post('parent_cat'),
						'cat_title' => $this->input->post('cat_title'),
						'cat_slug' => $this->input->post('cat_slug'),
						'cat_disc' => $this->input->post('cat_disc'),
						'cat_image' => $this->input->post('cat_image'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_keywords' => $this->input->post('meta_keywords'),
						'meta_description' => $this->input->post('meta_description'),
						'cat_type' => 'blog',
						'edit_date' => $this->currentTime
					);
				}
				$AddData = $this->category_model->AddCategory($data);
				if($AddData == TRUE) {
					$result['status'] = 'true';
					$result['values'] = $AddData;
					echo json_encode($result);
				} else {
					$result['status'] = 'false';
					echo json_encode($result);
				}
			}
		}
	}
    public function CategoryTrash() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $data = array (
                'id' =>  $this->input->post('id'),
                'status' => '2',
                'edit_date' => $this->currentTime
            );	
            $result['del'] = $this->category_model->AddCategory($data);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    public function CategoryTrashReverse() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $data = array (
                'id' =>  $this->input->post('id'),
                'status' => '1',
                'edit_date' => $this->currentTime
            );	
            $result['del'] = $this->category_model->AddCategory($data);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
	public function CategoryTrashPerma() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
            $id = $this->input->post('id');	
            $result['del']=$this->category_model->CategoryDel($id);
            if($result['del'] == TRUE) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
	}
}