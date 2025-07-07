<?php
class setting_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function GetAllSettings() {
        $condition = "status ='1'"; 
        $this->db->select('*');
        $this->db->from("tbl_settings");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function GetTrashSettings() {
        $condition = "status ='2'"; 
        $this->db->select('*');
        $this->db->from("tbl_settings");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function CheckSetting($setting_name) {
        $condition = "setting_name ='".$setting_name."'";
        $this->db->select('*');
        $this->db->from("tbl_settings");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddSettings($data) {
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_settings');
        $this->db->where($condition);
        $prevQuery = $this->db->get();       
        $prevCheck = $prevQuery->num_rows();       
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_settings',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_settings',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function viewSitedata() {
        $condition = "status ='1'"; 
        $this->db->select('*');
        $this->db->from("tbl_settings");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function viewSettingdata($id) {
        $condition = "status = '1' and id = '".$id."'"; 
        $this->db->select('*');
        $this->db->from("tbl_settings");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function SettingDel($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_settings');
        return $query;
    }
    public function viewSMTPdata() {
        $this->db->select('*');
        $this->db->from("tbl_smtp");
        $query = $this->db->get();
        return $query->row();
    }
    public function UpdateSMTP($data){
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_smtp');
        $this->db->where($condition);
        $prevQuery = $this->db->get();       
        $prevCheck = $prevQuery->num_rows();       
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['setting_id']);
            $update = $this->db->update('tbl_smtp',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_smtp',$data);
            $catId = $this->db->insert_id();
        }
            return $catId?$catId:FALSE;
    }
}