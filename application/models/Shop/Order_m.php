<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function all_count($sdate,$edate){
        $this->db->where("DATE_FORMAT(regidate,'%Y-%m-%d') >=",$sdate);
        $this->db->where("DATE_FORMAT(regidate,'%Y-%m-%d') <=",$edate);
        $this->db->from('tbl_shop_order');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }

    public function Data_Load($sdate,$edate,$start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM EBS_Shop.tbl_shop_order a,tbl_shop_order_send b where a.oCode=b.oCode and DATE_FORMAT(a.regidate,'%Y-%m-%d') >=? and DATE_FORMAT(a.regidate,'%Y-%m-%d')<=?  ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,array($sdate,$edate));
        return $query;
    }

    public function Load_Info_Order_Delivery($oCode){
        $sql = "SELECT * FROM tbl_shop_order_send a,tbl_shop_order_receive b where a.oCode=b.oCode and a.oCode=?";
        $query = $this->db->query($sql,$oCode);
        return $query->result_array();
    }

    public function Load_Info_Order_Product($oCode){
        $sql = "select *,(select dTitle from tbl_shop_delivery where dCode=a.delivery_code) as dName from tbl_shop_order_product a Where a.oCode=?";
        $query = $this->db->query($sql,$oCode);
        return $query->result_array();
    }


    public function Load_Info_Order($oCode){
        $sql = "SELECT * FROM tbl_shop_order where oCode=?";
        $query = $this->db->query($sql,$oCode);
        return $query->result_array();
    }

    public function Update_Order_Make_Product_Lv2($snstr){
        $this->db->trans_start();
        $this->db->set('status',2);
        $this->db->where_in('sn',$snstr);
        $this->db->update('tbl_shop_order_product');
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }



    public function Update_Order_Product($sn,$param){
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_shop_order_product',$param);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }


}
