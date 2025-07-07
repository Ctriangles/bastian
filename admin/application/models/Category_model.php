<?php
class category_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function viewCategory($cat_type) {
        $condition = "status ='1' and cat_type = '".$cat_type."'";
        $this->db->select('*');
        $this->db->from("tbl_category");
        $this->db->order_by("id","ASC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashCategory($cat_type) {
        $condition = "status ='2' and cat_type = '".$cat_type."'"; 
        $this->db->select('*');
        $this->db->from("tbl_category");
        $this->db->order_by("id","ASC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function CheckCategory($post_slug, $cat_type) {
        $condition = "cat_slug ='".$post_slug."' and status = '1' and cat_type = '".$cat_type."'";
        $this->db->select('*');
        $this->db->from("tbl_category");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddCategory($data) {
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_category');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_category',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_category',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function viewCategorydata($id) {
        $condition = "status = '1' and id = '".$id."'";
        $this->db->select('*');
        $this->db->from("tbl_category");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function CategoryDel($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_category');
        return $query;
    }
    public function CheckCategoryUrl($post_slug, $cat_type) {
        $condition = "cat_slug ='".$post_slug."' and status = '1' and cat_type = '".$cat_type."'";
        $this->db->select('*');
        $this->db->from("tbl_category");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
}