<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function Sum_Order_Total($sdate){
        $sql = 'select IFNULL(sum(totalprice),0) as total1,IFNULL(sum(totaldelivery),0) as total2,IFNULL(sum(totalsale),0) as total3,IFNULL(sum(totalpoint),0) as total4,COUNT(*) AS cnt FROM tbl_shop_order ';
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and payComplete=109";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Data_Load($sdate,$start, $limit, $sidx, $sord){
        $sql = "SELECT *,(select userid from EBS_Toon.tbl_member where uid=a.uid) as userid";
        $sql .= " FROM tbl_shop_order a WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and payComplete=109 ";
        $sql .= "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $Query = $this->db->query($sql,$sdate);
        return $Query;
    }

    public function all_count($sdate){
        $sql = 'SELECT uid FROM tbl_shop_order';
        $sql .= " WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ?";
        $query = $this->db->query($sql,$sdate);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Sum_Order_Total1($sdate){
        $sql = 'select *,(select userid from EBS_Toon.tbl_member where uid=a.uid) as userid FROM tbl_shop_order a ';
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and payComplete=109";
        $Query = $this->db->query($sql,$sdate);
        return $Query;
    }

}