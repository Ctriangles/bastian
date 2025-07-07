<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class backend extends CI_Controller {

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
		$this->getUserData = $this->user_model->Userdatad($user_id);
		$user_role = @$this->getUserData->user_type;
		$get_roles = $this->user_model->viewRoledata($user_role);
		if(!empty($get_roles)) {
			$this->role_list = explode(",",@$get_roles->roles);
		} else {
			$this->role_list = '';
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
			}
		}
	}
	public function dashboard() {
		if(!isset($this->session->userdata['admin_logged_in'])) {
			$this->load->view('backend/index');
		} else {
			$result['title'] = 'Dashboard';
			$result['totalpages'] = $this->post_model->viewPages();
			$result['totalblog'] = $this->post_model->AllBlogs();
			$result['totalusers'] = $this->user_model->viewUsers();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/dashboard', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function settings() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Settings';
			$result['mtitle'] = 'Settings';
			$result['viewurl'] = 'settings';
			$result['trashurl'] = 'trash_settings';
			$result['addurl'] = 'add_settings';
			$result['addrole'] = 'website_settings_add';
			$result['delrole'] = 'website_settings_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->setting_model->GetAllSettings();
			$result['TrashDatas'] = $this->setting_model->GetTrashSettings();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/settings', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_settings() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Settings';
			$result['mtitle'] = 'Settings';
			$result['viewurl'] = 'settings';
			$result['trashurl'] = 'trash_settings';
			$result['addurl'] = 'add_settings';
			$result['addrole'] = 'website_settings_add';
			$result['delrole'] = 'website_settings_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->setting_model->GetAllSettings();
			$result['TrashDatas'] = $this->setting_model->GetTrashSettings();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/settings', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_settings() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Settings';
			$result['mtitle'] = 'Settings';
			$result['viewurl'] = 'settings';
			$result['trashurl'] = 'trash_settings';
			$result['addurl'] = 'add_settings';
			$result['addrole'] = 'website_settings_add';
			$result['delrole'] = 'website_settings_delete';
			$result['current_url'] = $this->uri->segment(2);
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_settings');
			$this->load->view('backend/common/footer');
		}
	}
	public function roles() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Roles';
			$result['mtitle'] = 'Roles';
			$result['viewurl'] = 'roles';
			$result['trashurl'] = 'trash_roles';
			$result['addurl'] = 'add_roles';
			$result['addrole'] = 'manage_roles_add';
			$result['delrole'] = 'manage_roles_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->user_model->viewRoles();
			$result['TrashDatas'] = $this->user_model->TrashRoles();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/roles', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_roles() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Roles';
			$result['mtitle'] = 'Roles';
			$result['viewurl'] = 'roles';
			$result['trashurl'] = 'trash_roles';
			$result['addurl'] = 'add_roles';
			$result['addrole'] = 'manage_roles_add';
			$result['delrole'] = 'manage_roles_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->user_model->viewRoles();
			$result['TrashDatas'] = $this->user_model->TrashRoles();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/roles', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_roles() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Roles';
			$result['mtitle'] = 'Roles';
			$result['viewurl'] = 'roles';
			$result['trashurl'] = 'trash_roles';
			$result['addurl'] = 'add_roles';
			$result['addrole'] = 'manage_roles_add';
			$result['delrole'] = 'manage_roles_delete';
			$result['current_url'] = $this->uri->segment(2);
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_roles');
			$this->load->view('backend/common/footer');
		}
	}
	public function smtp() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('smtp',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'SMTP';
			$result['mtitle'] = 'SMTP';
			$result['viewurl'] = 'smtp';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = '';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->setting_model->viewSMTPdata();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/smtp', $results);
			$this->load->view('backend/common/footer', $result);
		}
	}
	public function pages() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('pages',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Pages';
			$result['mtitle'] = 'Pages';
			$result['viewurl'] = 'pages';
			$result['trashurl'] = 'trash_pages';
			$result['addurl'] = 'add_pages';
			$result['addrole'] = 'pages_add';
			$result['delrole'] = 'pages_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->post_model->viewPages();
			$result['TrashDatas'] = $this->post_model->TrashPages();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/pages', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_pages() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('pages_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Pages';
			$result['mtitle'] = 'Pages';
			$result['viewurl'] = 'pages';
			$result['trashurl'] = 'trash_pages';
			$result['addurl'] = 'add_pages';
			$result['addrole'] = 'pages_add';
			$result['delrole'] = 'pages_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->post_model->viewPages();
			$result['TrashDatas'] = $this->post_model->TrashPages();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/pages', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_pages() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('pages_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Pages';
			$result['mtitle'] = 'Pages';
			$result['viewurl'] = 'pages';
			$result['trashurl'] = 'trash_pages';
			$result['addurl'] = 'add_pages';
			$result['addrole'] = 'pages_add';
			$result['delrole'] = 'pages_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['pages'] = $this->post_model->viewPages();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_pages');
			$this->load->view('backend/common/footer');
		}
	}
	public function users() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Users';
			$result['mtitle'] = 'Users';
			$result['viewurl'] = 'users';
			$result['trashurl'] = 'trash_users';
			$result['addurl'] = 'add_users';
			$result['addrole'] = 'users_add';
			$result['delrole'] = 'users_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->user_model->viewUsers();
			$result['TrashDatas'] = $this->user_model->TrashUsers();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/users', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_users() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Users';
			$result['mtitle'] = 'Users';
			$result['viewurl'] = 'users';
			$result['trashurl'] = 'trash_users';
			$result['addurl'] = 'add_users';
			$result['addrole'] = 'users_add';
			$result['delrole'] = 'users_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->user_model->viewUsers();
			$result['TrashDatas'] = $this->user_model->TrashUsers();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/users', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_users() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Users';
			$result['mtitle'] = 'Users';
			$result['viewurl'] = 'users';
			$result['trashurl'] = 'trash_users';
			$result['addurl'] = 'add_users';
			$result['addrole'] = 'users_add';
			$result['delrole'] = 'users_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['userroles'] = $this->user_model->viewRoles();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_users');
			$this->load->view('backend/common/footer');
		}
	}
	public function profile() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('profile',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Profile';
			$result['mtitle'] = 'Profile';
			$result['viewurl'] = 'profile';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = '';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->user_model->viewUsersdata(@$_SESSION['admin_logged_in']['id']);
			$results['loginhistory']= $this->user_model->LoginHistory(@$_SESSION['admin_logged_in']['id']);
			$result['userroles'] = $this->user_model->viewRoles();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/profile', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function blog() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('blog',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Blog';
			$result['mtitle'] = 'Blog';
			$result['viewurl'] = 'blog';
			$result['trashurl'] = 'trash_blog';
			$result['addurl'] = 'add_blog';
			$result['addrole'] = 'blog_add';
			$result['delrole'] = 'blog_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->post_model->AllBlogs();
			$result['TrashDatas'] = $this->post_model->TrashBlogs();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/blog', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_blog() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('blog_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Blog';
			$result['mtitle'] = 'Blog';
			$result['viewurl'] = 'blog';
			$result['trashurl'] = 'trash_blog';
			$result['addurl'] = 'add_blog';
			$result['addrole'] = 'blog_add';
			$result['delrole'] = 'blog_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->post_model->AllBlogs();
			$result['TrashDatas'] = $this->post_model->TrashBlogs();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/blog', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_blog() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('blog_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Blog';
			$result['mtitle'] = 'Blog';
			$result['viewurl'] = 'blog';
			$result['trashurl'] = 'trash_blog';
			$result['addurl'] = 'add_blog';
			$result['addrole'] = 'blog_add';
			$result['delrole'] = 'blog_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['pages'] = $this->category_model->viewCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_blog');
			$this->load->view('backend/common/footer');
		}
	}
	public function category() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Category';
			$result['mtitle'] = 'Category';
			$result['viewurl'] = 'category';
			$result['trashurl'] = 'trash_category';
			$result['addurl'] = 'add_category';
			$result['addrole'] = 'category_add';
			$result['delrole'] = 'category_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->category_model->viewCategory('blog');
			$result['TrashDatas'] = $this->category_model->TrashCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/category', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_category() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Trash Category';
			$result['mtitle'] = 'Category';
			$result['viewurl'] = 'category';
			$result['trashurl'] = 'trash_category';
			$result['addurl'] = 'add_category';
			$result['addrole'] = 'category_add';
			$result['delrole'] = 'category_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->category_model->viewCategory('blog');
			$result['TrashDatas'] = $this->category_model->TrashCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/category', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function add_category() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_add',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Category';
			$result['mtitle'] = 'Category';
			$result['viewurl'] = 'category';
			$result['trashurl'] = 'trash_category';
			$result['addurl'] = 'add_category';
			$result['addrole'] = 'category_add';
			$result['delrole'] = 'category_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['pages'] = $this->category_model->viewCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_category');
			$this->load->view('backend/common/footer');
		}
	}
	// public function enquiries() {
	// 	if(!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry',$this->role_list) == false) {
	// 		redirect(site_url('backend/'));
	// 	} else {
	// 		$result['title'] = 'Enquiries';
	// 		$result['mtitle'] = 'Enquiries';
	// 		$result['viewurl'] = 'enquiries';
	// 		$result['trashurl'] = 'trash_enquiries';
	// 		$result['addurl'] = '';
	// 		$result['addrole'] = '';
	// 		$result['delrole'] = 'enquiry_delete';
	// 		$result['current_url'] = $this->uri->segment(2);
	// 		$result['AllDatas'] = $this->form_model->AllEnquiry();
	// 		$result['TrashDatas'] = $this->form_model->TrashEnquiry();
	// 		$this->load->view('backend/common/header', $result);
	// 		$this->load->view('backend/enquiries', $result);
	// 		$this->load->view('backend/common/footer');
	// 	}
	// }

	public function enquiries() {
		if (!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry', $this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Enquiries';
			$result['mtitle'] = 'Enquiries';
			$result['viewurl'] = 'enquiries';
			$result['trashurl'] = 'trash_enquiries';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = 'enquiry_delete';
			$result['current_url'] = $this->uri->segment(2);
				
			$start_date = $this->input->get('start_date');
    		$end_date = $this->input->get('end_date');
							
			$result['AllDatas'] = $this->form_model->AllEnquiryByDateRange($start_date, $end_date);
			$result['TrashDatas'] = $this->form_model->TrashEnquiry();
				
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/enquiries', $result);
			$this->load->view('backend/common/footer');
		}
	}
		
	public function trash_enquiries() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('enquiry_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Enquiries';
			$result['mtitle'] = 'Enquiries';
			$result['viewurl'] = 'enquiries';
			$result['trashurl'] = 'trash_enquiries';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = 'enquiry_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->form_model->AllEnquiry();
			$result['TrashDatas'] = $this->form_model->TrashEnquiry();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/enquiries', $result);
			$this->load->view('backend/common/footer');
		}
	}

	public function EditSettings($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('website_settings_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Edit Settings';
			$result['mtitle'] = 'Settings';
			$result['viewurl'] = 'settings';
			$result['addurl'] = 'add_settings';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->setting_model->viewSettingdata($id);
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_settings', $results);
			$this->load->view('backend/common/footer', $results);
		}
	}
	public function EditRoles($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('manage_roles_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Add Roles';
			$result['mtitle'] = 'Roles';
			$result['viewurl'] = 'roles';
			$result['addurl'] = 'add_roles';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->user_model->viewRolesdata($id);
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_roles', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function EditPage($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('pages_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Edit Pages';
			$result['mtitle'] = 'Pages';
			$result['viewurl'] = 'pages';
			$result['addurl'] = 'add_pages';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->post_model->viewPagedata($id);
			$result['pages'] = $this->post_model->viewPages();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_pages', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function EditUsers($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('users_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Edit Users';
			$result['mtitle'] = 'Users';
			$result['viewurl'] = 'users';
			$result['addurl'] = 'add_users';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->user_model->viewUsersdata($id);
			$results['loginhistory']= $this->user_model->LoginHistory($id);
			$result['userroles'] = $this->user_model->viewRoles();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_users', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function EditCategory($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('category_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Edit Category';
			$result['mtitle'] = 'Category';
			$result['viewurl'] = 'category';
			$result['addurl'] = 'add_category';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->category_model->viewCategorydata($id);
			$result['pages'] = $this->category_model->viewCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_category', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function EditBlog($id) {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('blog_edit',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Edit Blog';
			$result['mtitle'] = 'Blog';
			$result['viewurl'] = 'blog';
			$result['addurl'] = 'add_blog';
			$result['current_url'] = $this->uri->segment(2);
			$results['editdata']= $this->post_model->viewPagedata($id);
			$results['pages'] = $this->category_model->viewCategory('blog');
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/add_blog', $results);
			$this->load->view('backend/common/footer');
		}
	}
	public function career() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('career',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Career';
			$result['mtitle'] = 'Career';
			$result['viewurl'] = 'career';
			$result['trashurl'] = 'trash_career';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = 'career_delete';
			$result['current_url'] = $this->uri->segment(2);

			$start_date = $this->input->get('start_date');
    		$end_date = $this->input->get('end_date');

			$result['AllDatas'] = $this->form_model->AllCareerByDateRange($start_date, $end_date);
			$result['TrashDatas'] = $this->form_model->TrashCareer();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/career', $result);
			$this->load->view('backend/common/footer');
		}
	}
	public function trash_career() {
		if(!isset($this->session->userdata['admin_logged_in']) || in_array('career_delete',$this->role_list) == false) {
			redirect(site_url('backend/'));
		} else {
			$result['title'] = 'Career';
			$result['mtitle'] = 'Career';
			$result['viewurl'] = 'career';
			$result['trashurl'] = 'trash_career';
			$result['addurl'] = '';
			$result['addrole'] = '';
			$result['delrole'] = 'career_delete';
			$result['current_url'] = $this->uri->segment(2);
			$result['AllDatas'] = $this->form_model->AllCareer();
			$result['TrashDatas'] = $this->form_model->TrashCareer();
			$this->load->view('backend/common/header', $result);
			$this->load->view('backend/career', $result);
			$this->load->view('backend/common/footer');
		}
	}
}