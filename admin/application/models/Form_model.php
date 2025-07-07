<?php
class form_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function AllEnquiry()
    {
        $condition = "status ='1'";
        $this->db->select('*');
        $this->db->from("tbl_forms_data");
        $this->db->order_by("id", "DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function TrashEnquiry()
    {
        $condition = "status ='2'";
        $this->db->select('*');
        $this->db->from("tbl_forms_data");
        $this->db->order_by("id", "DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function AddFormData($data)
    {
        $condition = "id ='" . $data['id'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_forms');
        $this->db->where($condition);
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();
        if ($prevCheck > 0) {
            $prevResult = $prevQuery->row_array();
            $condition = "id ='" . $data['id'] . "'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_forms', $data);
            $catId = $prevResult['id'];
        } else {
            unset($data['id']);
            $insert = $this->db->insert('tbl_forms', $data);
            $catId = $this->db->insert_id();
        }
        return $catId ? $catId : FALSE;
    }
    public function AddFormDetailsData($data)
    {
        $condition = "id ='" . $data['id'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_forms_data');
        $this->db->where($condition);
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();
        if ($prevCheck > 0) {
            $prevResult = $prevQuery->row_array();
            $condition = "id ='" . $data['id'] . "'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_forms_data', $data);
            $catId = $prevResult['id'];
        } else {
            unset($data['id']);
            $insert = $this->db->insert('tbl_forms_data', $data);
            $catId = $this->db->insert_id();
        }
        return $catId ? $catId : FALSE;
    }

    public function GetRecentReservations($limit = 10)
    {
        $this->db->select('*');
        $this->db->from('tbl_forms_data');
        $this->db->order_by('insert_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function CheckTableStructure()
    {
        // Check if table exists and get structure
        $query = $this->db->query("SHOW TABLES LIKE 'tbl_forms_data'");
        $table_exists = $query->num_rows() > 0;

        $structure = array();
        if ($table_exists) {
            $query = $this->db->query("DESCRIBE tbl_forms_data");
            $structure = $query->result_array();
        }

        return array(
            'table_exists' => $table_exists,
            'structure' => $structure
        );
    }
    public function AddCareerData($data)
    {
        $condition = "id ='" . $data['id'] . "'";
        $this->db->select('*');
        $this->db->from('tbl_career');
        $this->db->where($condition);
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();
        if ($prevCheck > 0) {
            $prevResult = $prevQuery->row_array();
            $condition = "id ='" . $data['id'] . "'";
            $this->db->where($condition);
            unset($data['id']);
            $update = $this->db->update('tbl_career', $data);
            $catId = $prevResult['id'];
        } else {
            unset($data['id']);
            $insert = $this->db->insert('tbl_career', $data);
            $catId = $this->db->insert_id();
        }
        return $catId ? $catId : FALSE;
    }
    public function AllCareer()
    {
        $condition = "status ='1'";
        $this->db->select('*');
        $this->db->from("tbl_career");
        $this->db->order_by("id", "DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }

    public function AllCareerByDateRange($start_date = null, $end_date = null)
    {
        $condition = "status ='1'";
        $this->db->select('*');
        $this->db->from("tbl_career");
        $this->db->where($condition);
        $this->db->order_by("id", "DESC");

        if (!empty($start_date)) {
            if (!empty($end_date) && $start_date === $end_date) {
                $this->db->where('insert_date >=', $start_date . ' 00:00:00');
                $this->db->where('insert_date <=', $end_date . ' 23:59:59');
            } else {
                $this->db->where('insert_date >=', $start_date);
                if (!empty($end_date)) {
                    $this->db->where('insert_date <=', $end_date);
                }
            }
        }

        return $this->db->get()->result();
    }

    public function TrashCareer()
    {
        $condition = "status ='2'";
        $this->db->select('*');
        $this->db->from("tbl_career");
        $this->db->order_by("id", "DESC");
        $this->db->where($condition);
        return $this->db->get()->result();
    }
    public function FormDel($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_forms_data');
        return $query;
    }
    public function CareerDel($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('tbl_career');
        return $query;
    }
    public function ReservationdataById($id)
    {
        $condition = "status = '1' and id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from("tbl_forms_data");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function CareerdataById($id)
    {
        $condition = "status = '1' and id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from("tbl_career");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function ShortFormData($id)
    {
        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from("tbl_forms");
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->row();
    }
    public function AllEnquiryByDateRange($start_date = null, $end_date = null)
    {
        $condition = "status ='1'";
        $this->db->select('*');
        $this->db->from("tbl_forms_data");
        $this->db->where($condition);
        $this->db->order_by("id", "DESC");

        if (!empty($start_date)) {
            if (!empty($end_date) && $start_date === $end_date) {
                $this->db->where('insert_date >=', $start_date . ' 00:00:00');
                $this->db->where('insert_date <=', $end_date . ' 23:59:59');
            } else {
                $this->db->where('insert_date >=', $start_date);
                if (!empty($end_date)) {
                    $this->db->where('insert_date <=', $end_date);
                }
            }
        }

        return $this->db->get()->result();
    }
}
