<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function all_count()
    {
        $sql = 'SELECT pCode FROM tbl_shop_product';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT *,(select cName from tbl_shop_Acategory where aCode=a.agCode) as agName,";
        $sql .= "(select cName from tbl_shop_Bcategory where bCode=a.bgCode) as bgName,";
        $sql .= "(select cName from tbl_shop_Ccategory where cCode=a.cgCode) as cgName,";
        $sql .= "(select img from tbl_shop_product_image where pCode=a.pCode order by typ asc limit 1) as fname,";
        $sql .= "(select cTitle from tbl_shop_company where cCode=a.cCode) as cName FROM tbl_shop_product a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function MaxProductCode(){
        $sql = 'SELECT * FROM tbl_shop_product order by sn desc limit 1 ';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function Data_Reg($param){

        $this->db->trans_start();
        $this->db->insert('tbl_shop_product',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product Insert]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Data_Update($pCode,$param){

        $this->db->trans_start();
        $this->db->where('pCode',$pCode);
        $this->db->update('tbl_shop_product',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product Update]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Img_Reg($param){

        $this->db->trans_start();
        $this->db->insert('tbl_shop_product_image',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product_image Insert]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Option_Reg($param){

        $this->db->trans_start();
        $this->db->insert('tbl_shop_product_option',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product_option Insert]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Option_Update($pCode,$param){

        $this->db->trans_start();
        $this->db->where('pCode',$pCode);
        $this->db->update('tbl_shop_product_option',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product_option Update]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Load_Product($Code){
        $this->db->select('*');
        $this->db->where('pCode',$Code);
        $query = $this->db->get('tbl_shop_product');
        return $query->result_array();
    }

    public function Load_Product_Option($Code){
        $this->db->select('*');
        $this->db->where('pCode',$Code);
        $query = $this->db->get('tbl_shop_product_option');
        return $query->result_array();
    }

    public function Load_Product_Img($Code){
        $this->db->select('*');
        $this->db->where('pCode',$Code);
        $this->db->order_by('typ','ASC');
        $query = $this->db->get('tbl_shop_product_image');
        return $query->result_array();
    }


    function Delete_Product_Image($pCode,$typ)
    {
        $this->db->trans_start();
        $this->db->where('pCode',$pCode);
        $this->db->where('typ',$typ);
        $this->db->delete('tbl_shop_product_image');
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_product_ZZim Delete]');
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }





}