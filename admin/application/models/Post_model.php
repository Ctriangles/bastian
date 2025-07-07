<?php
class post_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function viewPages() {
        $condition = "status ='1' and post_type='pages'"; 
        $this->db->select('*');
        $this->db->from("tbl_post");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashPages() {
        $condition = "status ='2' and post_type='pages'"; 
        $this->db->select('*');
        $this->db->from("tbl_post");
        $this->db->order_by("id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function CheckPage($post_slug) {
        $condition = "post_slug ='".$post_slug."' and post_type='pages' and status = '1'";
        $this->db->select('*');
        $this->db->from("tbl_post");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddPages($data) {
        $condition = "id ='".$data['id']."'";
        $this->db->select('*');
        $this->db->from('tbl_post');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "id ='".$data['id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_post',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_post',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function AddPostDetails($data){
        $condition = "post_id ='".$data['post_id']."'";
        $this->db->select('*');
        $this->db->from('tbl_post_details');
        $this->db->where($condition);
        $prevQuery = $this->db->get(); 
        $prevCheck = $prevQuery->num_rows();
        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $condition = "post_id ='".$data['post_id']."'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_post_details',$data);
            $catId = $prevResult['id'];
        } else{
            unset($data['id']);
            $insert = $this->db->insert('tbl_post_details',$data);
            $catId = $this->db->insert_id();
        }
        return $catId?$catId:FALSE;
    }
    public function viewPagedata($id) {
        $condition = "a.status = '1' and a.id = '".$id."'"; 
        $this->db->select('a.*, b.post_content,b.meta_title,b.meta_keywords,b.meta_description');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function viewPagedataBySlug($slug) {
        $condition = "a.status = '1' and a.post_slug = '".$slug."' and a.post_type='pages'"; 
        $this->db->select('a.*, b.post_content,b.meta_title,b.meta_keywords,b.meta_description');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function PageDel($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_post');
        return $query;
    }
    public function PageDetailsDel($id) {
        $this->db->where('post_id', $id);
        $query = $this->db->delete('tbl_post_details');
        return $query;
    }
    public function PageDataBySlug($slug) {
        $condition = "a.status = '1' and a.post_slug = '".$slug."'"; 
        $this->db->select('a.*, b.post_content,b.meta_title,b.meta_keywords,b.meta_description');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function GetParentPages() {
        $condition = "status ='1' and post_type='pages' and parent_post = '0'"; 
        $this->db->select('post_title,post_slug,id');
        $this->db->from("tbl_post");
        $this->db->order_by("priority","ASC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function GetParentChildPages($id) {
        $condition = "status ='1' and post_type='pages' and parent_post = '".$id."'"; 
        $this->db->select('post_title,post_slug,id,featured_img');
        $this->db->from("tbl_post");
        $this->db->order_by("id","ASC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AllBlogs() {
        $condition = "a.status ='1' and a.post_type='article'"; 
        $this->db->select('a.*,b.post_content,c.cat_title');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->join("tbl_category c", "a.post_cat = c.id", "left");
        $this->db->order_by("a.id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashBlogs() {
        $condition = "a.status ='2' and a.post_type='article'"; 
        $this->db->select('a.*,b.post_content,c.cat_title');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->join("tbl_category c", "a.post_cat = c.id", "left");
        $this->db->order_by("a.id","DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function CheckBlog($post_slug) {
        $condition = "post_slug ='".$post_slug."' and post_type='article' and status = '1'";
        $this->db->select('*');
        $this->db->from("tbl_post");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function viewBlogdataBySlug($slug) {
        $condition = "a.status = '1' and a.post_slug = '".$slug."' and a.post_type='article'"; 
        $this->db->select('a.*, b.post_content,b.meta_title,b.meta_keywords,b.meta_description');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function LimitBlogs($limit) {
        $condition = "a.status ='1' and a.post_type='article'"; 
        $this->db->select('a.*,b.post_content,c.cat_title');
        $this->db->from("tbl_post a");
        $this->db->join("tbl_post_details b", "a.id = b.post_id", "left");
        $this->db->join("tbl_category c", "a.post_cat = c.id", "left");
        $this->db->order_by("a.id","DESC");
        $this->db->limit($limit);
        $this->db->where($condition);
        return $this->db->get()->result();
    }
}