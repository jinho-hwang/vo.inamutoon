<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Re_cartoon_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function Load_All(){
        $Query = $this->db->get('tbl_Cartoon_reserve');
        return $Query->result_array();
    }

    public function all_count($tstr)
    {
        if(empty($tstr)) {
            $sql = 'SELECT sn FROM tbl_Cartoon_reserve';
        }else{
            $sql = "SELECT sn FROM tbl_Cartoon_reserve a,tbl_cartoon b where a.pcode=b.code and b.title like '%".$tstr."%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper)
    {
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_Cartoon_reserve a where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{
            if(empty($tstr)) {
                $sql = "SELECT * FROM tbl_Cartoon_reserve a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT a.* FROM tbl_Cartoon_reserve a,tbl_cartoon b where a.pcode=b.code and b.title like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
        }
        return $query;
    }



    function Data_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'scode' => $param['scode'],
            'isReserve' => $param['isReserve'],
            'opendate' => $param['opendate'].' 10:00'
        );

        $this->db->trans_start();
        $this->db->insert('tbl_Cartoon_reserve',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_reserve Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $sn =  $param['id'];
        $data = array(
            'pcode' => $param['pcode'],
            'scode' => $param['scode'],
            'isReserve' => $param['isReserve'],
            'opendate' => $param['opendate'].' 10:00'
        );

        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Cartoon_reserve',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_reserve Update]');
        }
        return $affected_rows;

    }

    function Data_Del($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_Cartoon_reserve',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_reserve Delete]');
        }
        return $affected_rows;
    }
}