<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function Push_Event_all()
    {
        $this->db->from('tbl_Push_Event');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }

    public function Push_Event_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT *,(select count(*) from tbl_Push_Event_Log where pid=a.sn) as tCnt FROM tbl_Push_Event a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    function PushEvent_Add($param){
        $data = array(
            'title' => $param['title'],
            'cash' => $param['cash'],
            'adddate' => $param['adddate'],
            'isUse'=>$param['isUse'],
            's_date'=>$param['s_date'],
            'e_date'=>$param['e_date']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_Push_Event',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Push_Event Insert]');
        }

        return $insert_id;
    }


    function PushEvent_Del($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_Push_Event',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Push_Event Delete]');
        }
        return $affected_rows;
    }


    function PushEvent_Update($param){
        $sn =  $param['id'];
        $data = array(
            'title' => $param['title'],
            'cash' => $param['cash'],
            'adddate' => $param['adddate'],
            'isUse'=>$param['isUse'],
            's_date'=>$param['s_date'],
            'e_date'=>$param['e_date']
        );

        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Push_Event',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Push_Event Update]');
        }
        return $affected_rows;

    }


    public function open1_all_count()
    {
        $this->db->from('Open_Event1');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }


    public function open1_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM Open_Event1 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function open2_all_count()
    {
        $this->db->from('Open_Event2');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }


    public function open2_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM Open_Event2 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function open3_all_count()
    {
        $this->db->from('Open_Event3');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }

    public function e20210506_all_count()
    {
        $this->db->from('tbl_e20210506');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }


    public function open3_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM Open_Event3 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function e20210506_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM tbl_e20210506 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }


    public function m20200901_all_count()
    {
        $this->db->from('Event_20200901_2');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }


    public function m20200901_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM Event_20200901_2 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function e20200901_all_count()
    {
        $this->db->from('Event_20200901_1');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }


    public function e20200901_Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT a.*,b.userid,b.uname FROM Event_20200901_1 a,tbl_member b where a.uid=b.uid ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

}