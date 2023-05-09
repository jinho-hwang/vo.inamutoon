<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_m extends CI_Model {
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    
    public function Load_Ad($type,$Cnt){
         $sql = 'SELECT * FROM tbl_ad_info where mtype=? and isOpen=1 order by isNum DESC,sn DESC limit ?';
         $Query = $this->db->query($sql,array($type,$Cnt));
         return $Query->result_array();
    }
    
    public function Load_Writer(){
        $Query = $this->db->get('tbl_writer');
        return $Query->result_array();
    }
    
    public function Load_Category(){
        $Query = $this->db->get('tbl_category');
        return $Query->result_array();
     }
    
    public function wrtier_selectbox(){
        $select_box = "'':'없음',";
        

        $sql = "SELECT * FROM tbl_writer where isActive=1 order by wname asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->code . "':'" . $row->wname . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }

    public function counsel_selectbox(){
        $select_box = "'':'없음',";

        $sql = "SELECT * FROM tbl_counsel_member where isActive=1 order by code asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->code . "':'" . $row->wname . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }

      
     public function category_selectbox(){
        $select_box = "'':'없음',";

        $sql = "SELECT * FROM tbl_category where isActive=1  order by sn asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->code . "':'" . $row->cname . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }  
     
     public function cartoon_selectbox(){
        $select_box = "'':'없음',";

        $sql = "SELECT * FROM tbl_cartoon where isOpen=1  order by code asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->code . "':'" . $row->title . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }  
    
	public function cartoon_selectbox_All(){
        $select_box = "'':'없음',";

        $sql = "SELECT * FROM tbl_cartoon  order by title asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->code . "':'" . $row->title . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }

    public function diff_Date_DB($sdate,$edate){
        $sql = "SELECT dateDIFF(?,?) as dateCnt";
        $Query = $this->db->query($sql,array($sdate,$edate));
        return $Query->result_array();
    }
    
}

?>
