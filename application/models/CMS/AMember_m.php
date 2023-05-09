<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AMember_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function Insert_Log($uid,$Log){
        $data = array(
            'uid' => $uid,
            'Log' => $Log
        );

        $this->db->trans_start();
        $this->db->insert('tbl_admin_Log',$data);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    function Load_AMember($Tuid){
        $sql = 'SELECT * FROM tbl_admin_member where sn=?';
        $query = $this->db->query($sql,$Tuid);
        return $query->result_array();
    }

    function Load_All(){
        $Query = $this->db->get('tbl_admin_member');
        return $Query->result_array();
    }

    public function all_count(){
        $sql = 'SELECT userid FROM tbl_admin_member';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function all_count2($wid){
        $sql = 'SELECT uid FROM tbl_admin_cartoon where uid=?';
        $query = $this->db->query($sql,$wid);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }



    public function Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_admin_member ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }


    public function Data_Load2($wid,$start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,c.code FROM tbl_admin_cartoon a,tbl_admin_member b,tbl_cartoon c where a.uid=b.sn and a.pCode=c.code and a.uid=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,$wid);
        return $query;
    }


    function Data_Add($param){
        $data = array(
            'userid' => $param['userid'],
            'passwd' => $param['passwd'],
            'grade' => 1
        );

        $this->db->trans_start();
        $this->db->insert('tbl_admin_member',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Insert]');
        }

        return $insert_id;
    }

    function Data_Add2($wid,$pcode){
        $data = array(
            'uid' => $wid,
            'pCode' => $pcode
        );

        $this->db->trans_start();
        $this->db->insert('tbl_admin_cartoon',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $sn =  $param['id'];
        $data = array(
            'userid' =>$param['userid'],
            'passwd' => $param['passwd'],
            'grade' => 1
        );


        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_admin_member',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Update]');
        }
        return $affected_rows;

    }

    function Data_Update2($wid,$param){

        $this->db->trans_start();
        $this->db->where('sn',$wid);
        $this->db->update('tbl_admin_member',$param);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Update]');
        }
        return $affected_rows;

    }

    function Data_Del($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_admin_member',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Delete]');
        }
        return $affected_rows;
    }

    function Data_Del2($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_admin_cartoon',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [admin_Member Delete]');
        }
        return $affected_rows;
    }

    public function AMember_Data($param)
    {
        $sql = 'SELECT * from tbl_admin_member where userid= ? and passwd =?';
        $Query = $this->db->query($sql,array($param['uid'],$param['pwd']));
        return $Query->result_array();
    }


}

