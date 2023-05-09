<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function company_selectbox(){
        $select_box = "'':'없음',";

        $sql = "SELECT * FROM tbl_shop_company where isUse=1 order by cCode asc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $select_box .= "'" . $row->cCode . "':'" . $row->cTitle . "',";
            }

            return $select_box;
        } else {
            return false;
        }
    }



    public function all_count($tstr){
        if(!empty($tstr)) {
            $this->db->like('cTitle',$tstr,'both');
        }
        $this->db->from('tbl_shop_company');
        $Cnt= $this->db->count_all_results();

        return $Cnt;
    }

    public function Load_Info_Delivery(){
        $this->db->select('*');
        $this->db->where('isUse',1);
        $query = $this->db->get('tbl_shop_delivery');
        return $query->result_array();
    }

    public function Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_shop_company where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{
            if(empty($tstr)) {
                $sql = "SELECT * FROM tbl_shop_company ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT * FROM tbl_shop_company where cTitle like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function Data_Add($param)
    {
        $data = array(
            'cTitle' => $param['cTitle'],
            'cName' => $param['cName'],
            'cTel' => $param['cTel'],
            'cAddress' => $param['cAddress'],
            'delivery_com' => $param['delivery_com'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_company', $data);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_company Insert]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    function Data_Update($param)
    {
        $id = $param['id'];
        $data = array(
            'cTitle' => $param['cTitle'],
            'cName' => $param['cName'],
            'cTel' => $param['cTel'],
            'cAddress' => $param['cAddress'],
            'delivery_com' => $param['delivery_com'],
            'isUse' => $param['isUse']
        );


        $this->db->trans_start();
        $this->db->where('cCode', $id);
        $this->db->update('tbl_shop_company', $data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_company Update]');
            $this->db->trans_rollback();
        }

        return $affected_rows;

    }

    function Data_Del($id)
    {
        $data = array(
            'cCode' => $id
        );
        $this->db->trans_start();
        $this->db->delete('tbl_shop_company', $data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_company Delete]');
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }

    public function delivery_all_count()
    {
        $sql = 'SELECT dCode FROM tbl_shop_delivery';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function delivery_Data_Load($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_shop_delivery a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function Delivery_Add($param){
        $data = array(
            'dTitle' => $param['dTitle'],
            'dPrice' => $param['dPrice'],
            'dTel' => $param['dTel'],
            'delivery_url' => $param['delivery_url']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_delivery',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_delivery Insert]');
        }

        return $insert_id;
    }

    public function Delivery_Update($param){
        $dCode =  $param['id'];
        $data = array(
            'dTitle' => $param['dTitle'],
            'dPrice' => $param['dPrice'],
            'dTel' => $param['dTel'],
            'delivery_url' => $param['delivery_url']
        );

        $this->db->trans_start();
        $this->db->where('dCode',$dCode);
        $this->db->update('tbl_shop_delivery',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_delivery Update]');
        }
        return $affected_rows;

    }


    public function Delivery_Del($sn){
        $data = array(
            'dCode' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_shop_delivery',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_shop_delivery Delete]');
        }
        return $affected_rows;
    }

    public function Load_Company_All(){
        $sql = 'SELECT * FROM tbl_shop_company  order by cCode desc';
        $query = $this->db->query($sql);
        return $query->result_array();;
    }
}
