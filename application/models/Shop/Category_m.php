<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function Load_ACategory_All(){
        $sql = 'SELECT * FROM tbl_shop_Acategory where isUse=1  order by aCode desc';
        $query = $this->db->query($sql);
        return $query->result_array();;
    }

    public function Load_BCategory_All(){
        $sql = 'SELECT * FROM tbl_shop_Bcategory where isUse=1  order by bCode desc';
        $query = $this->db->query($sql);
        return $query->result_array();;
    }

    public function Load_CCategory_All(){
        $sql = 'SELECT * FROM tbl_shop_Ccategory where isUse=1  order by cCode desc';
        $query = $this->db->query($sql);
        return $query->result_array();;
    }

    public function Load_BCategory_Code($acode){
        $sql = 'SELECT * FROM tbl_shop_Bcategory where isUse=1 and aCode=?  order by bCode desc';
        $query = $this->db->query($sql,$acode);
        return $query->result_array();;
    }

    public function Load_CCategory_Code($acode){
        $sql = 'SELECT * FROM tbl_shop_Ccategory where isUse=1 and bCode=?  order by bCode desc';
        $query = $this->db->query($sql,$acode);
        return $query->result_array();;
    }


    public function ACaregory_all_count()
    {
        $sql = 'SELECT aCode FROM tbl_shop_Acategory';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function BCaregory_all_count()
    {
        $sql = 'SELECT bCode FROM tbl_shop_Bcategory';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function CCaregory_all_count()
    {
        $sql = 'SELECT cCode FROM tbl_shop_Ccategory';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function AData_Load($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_shop_Acategory a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function BData_Load($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_shop_Bcategory a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function CData_Load($start, $limit, $sidx, $sord)
    {
        $sql = 'SELECT *,';
        $sql .= '(select cName from tbl_shop_Acategory where aCode=a.aCode) as aName,';
        $sql .= "(select cName from tbl_shop_Bcategory where bCode=a.bCode) as bName FROM tbl_shop_Ccategory a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function AData_Add($param){
        $data = array(
            'cName' => $param['cName'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_Acategory',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Acategory Insert]');
        }

        return $insert_id;
    }

    public function BData_Add($param){
        $data = array(
            'aCode' => $param['aCode'],
            'cName' => $param['cName'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_Bcategory',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Bcategory Insert]');
        }

        return $insert_id;
    }

    public function CData_Add($param){
        $data = array(
            'aCode' => $param['aCode'],
            'bCode' => $param['bCode'],
            'cName' => $param['cName'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_Ccategory',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Ccategory Insert]');
        }

        return $insert_id;
    }

    public function AData_Update($param){
        $sn =  $param['id'];
        $data = array(
            'cName' =>$param['cName'],
            'isUse' => $param['isUse']
        );


        $this->db->trans_start();
        $this->db->where('aCode',$sn);
        $this->db->update('tbl_shop_Acategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Acategory Update]');
        }
        return $affected_rows;

    }

    public function BData_Update($param){
        $sn =  $param['id'];
        $data = array(
            'aCode' => $param['aCode'],
            'cName' =>$param['cName'],
            'isUse' => $param['isUse']
        );


        $this->db->trans_start();
        $this->db->where('aCode',$sn);
        $this->db->update('tbl_shop_Bcategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Bcategory Update]');
        }
        return $affected_rows;

    }

    public function CData_Update($param){
        $sn =  $param['id'];
        $data = array(
            'cName' =>$param['cName'],
            'isUse' => $param['isUse']
        );


        $this->db->trans_start();
        $this->db->where('cCode',$sn);
        $this->db->update('tbl_shop_Ccategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Ccategory Update]');
        }
        return $affected_rows;

    }

    public function AData_Del($sn){
        $data = array(
            'aCode' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_shop_Acategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Acategory Delete]');
        }
        return $affected_rows;
    }

    public function BData_Del($sn){
        $data = array(
            'bCode' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_shop_Bcategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Bcategory Delete]');
        }
        return $affected_rows;
    }


    public function CData_Del($sn){
        $data = array(
            'cCode' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_shop_Ccategory',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_Ccategory Delete]');
        }
        return $affected_rows;
    }


}