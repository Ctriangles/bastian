<?php
defined('BASEPATH') or exit('No direct script access allowed');

class post_controller extends CI_Controller
{

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
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->currentTime = date('Y-m-d H:i:s', time());
		$user_id = @$_SESSION['admin_logged_in']['id'];
		$this->getUserData = $this->user_model->Userdatad($user_id);
		$user_role = @$this->getUserData->user_type;
		$get_roles = $this->user_model->viewRoledata($user_role);
		if (!empty($get_roles)) {
			$this->role_list = explode(",", @$get_roles->roles);
		} else {
			$this->role_list = '';
		}

		$config['upload_path']   = './uploads/images/';
		$config['allowed_types'] = 'jpg|png|jpeg|svg|webp';
		$config['max_size']      = 3000;
		$this->load->library('upload', $config);

		$result['settings'] = $this->setting_model->viewSitedata();
		foreach ($result['settings'] as $catdata) {
			if ($catdata->setting_name == 'site_logo') {
				$this->site_logo = $catdata->setting_value;
			}
			if ($catdata->setting_name == 'site_favicon') {
				$this->site_favicon = $catdata->setting_value;
			}
			if ($catdata->setting_name == 'copyright') {
				$this->copyright = $catdata->setting_value;
			}
			if ($catdata->setting_name == 'site_title') {
				$this->site_title = $catdata->setting_value;
			}
		}
	}
	public function AddPages()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('pages_add', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$checkPage = $this->post_model->CheckPage($this->input->post('post_slug'));
			if (empty($id) && !empty($checkPage)) {
				$result['status'] = 'already';
				echo json_encode($result);
			} else {
				if (empty($id)) {
					$data = array(
						'id' => $this->input->post('id'),
						'post_title' => $this->input->post('post_title'),
						'post_slug' => $this->input->post('post_slug'),
						'parent_post' => $this->input->post('parent_post'),
						'featured_img' => $this->input->post('featured_img'),
						'post_type' => 'pages',
						'insert_date' => $this->currentTime,
						'edit_date' => $this->currentTime
					);
				} else {
					$data = array(
						'id' => $this->input->post('id'),
						'post_title' => $this->input->post('post_title'),
						'post_slug' => $this->input->post('post_slug'),
						'parent_post' => $this->input->post('parent_post'),
						'featured_img' => $this->input->post('featured_img'),
						'post_type' => 'pages',
						'edit_date' => $this->currentTime
					);
				}
				$AddData = $this->post_model->AddPages($data);
				if ($AddData == TRUE) {
					$details = array(
						'post_id' => $AddData,
						'post_content' => $this->input->post('post_content'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_keywords' => $this->input->post('meta_keywords'),
						'meta_description' => $this->input->post('meta_description')
					);
					$AddDetails = $this->post_model->AddPostDetails($details);
					if ($AddDetails == TRUE) {
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
	public function PostTrash()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || (in_array('pages_delete', $this->role_list) == false && in_array('blog_delete', $this->role_list) == false)) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '2',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->post_model->AddPages($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function PostTrashReverse()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || (in_array('pages_delete', $this->role_list) == false && in_array('blog_delete', $this->role_list) == false)) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '1',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->post_model->AddPages($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function PostTrashPerma()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || (in_array('pages_delete', $this->role_list) == false && in_array('blog_delete', $this->role_list) == false)) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$result['del'] = $this->post_model->PageDel($id);
			$results['del'] = $this->post_model->PageDetailsDel($id);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function AddBlog()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || (in_array('blog_add', $this->role_list) == false && in_array('blog_edit', $this->role_list) == false)) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$checkPage = $this->post_model->CheckBlog($this->input->post('post_slug'));
			if (empty($id) && !empty($checkPage)) {
				$result['status'] = 'already';
				echo json_encode($result);
			} else {
				if (empty($id)) {
					$data = array(
						'id' => $this->input->post('id'),
						'post_title' => $this->input->post('post_title'),
						'post_slug' => $this->input->post('post_slug'),
						'featured_img' => $this->input->post('featured_img'),
						'post_cat' => $this->input->post('post_cat'),
						'post_type' => 'article',
						'insert_date' => $this->currentTime,
						'edit_date' => $this->currentTime
					);
				} else {
					$data = array(
						'id' => $this->input->post('id'),
						'post_title' => $this->input->post('post_title'),
						'post_slug' => $this->input->post('post_slug'),
						'post_cat' => $this->input->post('post_cat'),
						'featured_img' => $this->input->post('featured_img'),
						'post_type' => 'article',
						'edit_date' => $this->currentTime
					);
				}
				$AddData = $this->post_model->AddPages($data);
				if ($AddData == TRUE) {
					$details = array(
						'post_id' => $AddData,
						'post_content' => $this->input->post('post_content'),
						'meta_title' => $this->input->post('meta_title'),
						'meta_keywords' => $this->input->post('meta_keywords'),
						'meta_description' => $this->input->post('meta_description')
					);
					$AddDetails = $this->post_model->AddPostDetails($details);
					if ($AddDetails == TRUE) {
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
	public function FormTrash()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '2',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->form_model->AddFormDetailsData($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function FormTrashReverse()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '1',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->form_model->AddFormDetailsData($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function FormTrashPerma()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$result['del'] = $this->form_model->FormDel($id);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function CareerTrash()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('career_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '2',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->form_model->AddCareerData($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function CareerTrashReverse()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('career_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$data = array(
				'id' =>  $this->input->post('id'),
				'status' => '1',
				'edit_date' => $this->currentTime
			);
			$result['del'] = $this->form_model->AddCareerData($data);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	public function CareerTrashPerma()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('career_delete', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$id = $this->input->post('id');
			$result['del'] = $this->form_model->CareerDel($id);
			if ($result['del'] == TRUE) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	}
	// public function EnquiriesExport() {
	// 	if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry', $this->role_list) == false) {
	// 		redirect(site_url('backend/'));
	// 	} else {
	// 		$propertydata = $this->form_model->AllEnquiry();
	// 		$filename = 'enquiries_data_' . date('Ymd') . '.csv';
	// 		header("Content-Description: File Transfer");
	// 		header("Content-Disposition: attachment; filename=$filename");
	// 		header("Content-Type: application/csv; ");

	// 		$file = fopen('php://output', 'w');
	// 		$customHeaderMapping = [
	// 			'id' => 'ID',
	// 			'restaurant_id' => 'Restaurant Name',
	// 			'booking_date' => 'Booking Date',
	// 			'booking_time' => 'Booking Time',
	// 			'full_name' => 'Name',
	// 			'email_id' => 'Email',
	// 			'contact_number' => 'Contact Number',
	// 			'pax' => 'Pax',
	// 			'age' => 'Age',
	// 			'pin_code' => 'Pin Code',
	// 			'insert_date' => 'Submit Date & Time',
	// 			'user_ip' => 'IP',
	// 		];
	// 		fputcsv($file, array_values($customHeaderMapping));
	// 		foreach ($propertydata as $row) {
	// 			$rowArray = (array) $row;
	// 			$customRow = [];
	// 			foreach ($customHeaderMapping as $originalField => $displayName) {
	// 				if ($originalField === 'restaurant_id') {
	// 					if($rowArray[$originalField] == '43383004') {
	// 						$customRow[] = 'Bastian At The Top';
	// 					} else if($rowArray[$originalField] == '98725763') {
	// 						$customRow[] = 'Bastian Bandra';
	// 					} else if($rowArray[$originalField] == '51191537') {
	// 						$customRow[] = 'Bastian Chinois';
	// 					} else if($rowArray[$originalField] == '10598428') {
	// 						$customRow[] = 'Bastian Empire';
	// 					} else if($rowArray[$originalField] == '92788130') {
	// 						$customRow[] = 'Bastian Garden City';
	// 					} 
	// 				} else {
	// 					$customRow[] = $rowArray[$originalField] ?? '';
	// 				}
	// 			}
	// 			fputcsv($file, $customRow);
	// 		}
	// 		fclose($file);
	// 		exit;
	// 	}
	// }

	public function EnquiriesExport()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {

			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			$propertydata = $this->form_model->AllEnquiryByDateRange($start_date, $end_date);

			$filename = 'enquiries_data_' . date('Ymd') . '.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$filename");
			header("Content-Type: application/csv; ");

			$file = fopen('php://output', 'w');
			$customHeaderMapping = [
				'id' => 'ID',
				'restaurant_id' => 'Restaurant Name',
				'booking_date' => 'Booking Date',
				'booking_time' => 'Booking Time',
				'full_name' => 'Name',
				'email_id' => 'Email',
				'contact_number' => 'Contact Number',
				'pax' => 'Pax',
				'age' => 'Age',
				'pin_code' => 'Pin Code',
				'insert_date' => 'Submit Date & Time',
				'user_ip' => 'IP',
			];
			fputcsv($file, array_values($customHeaderMapping));

			foreach ($propertydata as $row) {
				$rowArray = (array) $row;
				$customRow = [];
				foreach ($customHeaderMapping as $originalField => $displayName) {
					if ($originalField === 'restaurant_id') {
						if ($rowArray[$originalField] == '43383004') {
							$customRow[] = 'Bastian At The Top';
						} else if ($rowArray[$originalField] == '98725763') {
							$customRow[] = 'Bastian Bandra';
						} else if ($rowArray[$originalField] == '51191537') {
							$customRow[] = 'Inka By Bastian';
						} else if ($rowArray[$originalField] == '10598428') {
							$customRow[] = 'Bastian Empire (Pune)';
						} else if ($rowArray[$originalField] == '92788130') {
							$customRow[] = 'Bastian Garden City (Bengaluru)';
						}
					} else {
						$customRow[] = $rowArray[$originalField] ?? '';
					}
				}
				fputcsv($file, $customRow);
			}

			fclose($file);
			exit;
		}
	}


	public function CareerExport()
	{
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('career', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {

			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			$propertydata = $this->form_model->AllCareerByDateRange($start_date, $end_date);
			$filename = 'career_data_' . date('Ymd') . '.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$filename");
			header("Content-Type: application/csv; ");

			$file = fopen('php://output', 'w');
			$customHeaderMapping = [
				'id' => 'ID',
				'department' => 'Department',
				'full_name' => 'Name',
				'email_id' => 'Email',
				'contact_number' => 'Contact Number',
				'insert_date' => 'Submit Date & Time',
				'user_ip' => 'IP',
			];
			fputcsv($file, array_values($customHeaderMapping));
			foreach ($propertydata as $row) {
				$rowArray = (array) $row;
				$customRow = [];
				foreach ($customHeaderMapping as $originalField => $displayName) {
					$customRow[] = $rowArray[$originalField] ?? '';
				}
				fputcsv($file, $customRow);
			}
			fclose($file);
			exit;
		}
	}
}
