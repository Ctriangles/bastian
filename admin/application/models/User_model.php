<?php
class user_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function Backendlogin($data) {
        $condition = "username ='".$data['user_name']."' and password='".$data['password']."' and user_for = 'backend' and status='1'";
        $this->db->select('id');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function Userdatad($user_id) {
        $condition = "status ='1' and id ='".$user_id."'"; 
        $this->db->select('*');
        $this->db->from("tbl_users");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function viewRoledata($id) {
        $condition = "status ='1' and id ='".$id."'"; 
        $this->db->select('*');
        $this->db->from("tbl_roles");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function AddLoginData($login) {
        $insert = $this->db->insert('tbl_login',$login);
        $catId = $this->db->insert_id();
        return $catId?$catId:FALSE;
    }
    public function AddUser($data){
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_users',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_users',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function UserInfoByAuth($auth) {
        $condition = "status ='1' and auth_token ='".$auth."'"; 
        $this->db->select('username,password');
        $this->db->from("tbl_users");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function viewRoles() {
        $condition = "status ='1'"; 
        $this->db->select('*');
        $this->db->from("tbl_roles");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashRoles() {
        $condition = "status ='2'";
        $this->db->select('*');
        $this->db->from("tbl_roles");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddRole($data){
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_roles');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_roles',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_roles',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function CheckRoles($role_name) {
        $condition = "role_name ='".$role_name."'";
        $this->db->select('*');
        $this->db->from("tbl_roles");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function viewRolesdata($id) {
        $condition = "status = '1' and id = '".$id."'"; 
        $this->db->select('*');
        $this->db->from("tbl_roles");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function RolesDel($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_roles');
        return $query;
    }
    public function viewUsers() {
        $condition = "a.status ='1'"; 
        $this->db->select('a.*,b.role_name');
        $this->db->from("tbl_users a");
        $this->db->join("tbl_roles b", "a.user_type = b.id", "left");
        $this->db->order_by("a.id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashUsers() {
        $condition = "a.status ='2'"; 
        $this->db->select('a.*,b.role_name');
        $this->db->from("tbl_users a");
        $this->db->join("tbl_roles b", "a.user_type = b.id", "left");
        $this->db->order_by("a.id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function CheckUserByEmail($username) {
        $condition = "username ='".$username."'";
        $this->db->select('*');
        $this->db->from("tbl_users");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddUsers($data){
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_users',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_users',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function AddUserDetails($data){
        $condition = "user_id ='".$data['user_id']."'";
        $this->db->select('*');
        $this->db->from('tbl_usermeta');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "user_id ='".$data['user_id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_usermeta',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_usermeta',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function viewUsersdata($id) {
        $condition = "a.status = '1' and a.id = '".$id."'"; 
        $this->db->select('a.*,b.biography,b.address,b.city,b.state,b.poster_code,b.country');
        $this->db->from("tbl_users a");
        $this->db->join("tbl_usermeta b", "a.id = b.user_id", "left");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function LoginHistory($id) {
        $condition = "user_id ='".$id."'"; 
        $this->db->select('*');
        $this->db->from("tbl_login");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    public function UsersDel($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_users');
        return $query;
    }
    public function UsersDetailsDel($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->delete('tbl_usermeta');
        return $query;
    }
}