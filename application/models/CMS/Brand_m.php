<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count()
    {
        $sql = 'SELECT sn FROM tbl_cartoon_Brand';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function all_count2()
    {
        $sql = 'SELECT bcode FROM tbl_Brand';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function all_count3($typ,$code)
    {
        $sql = 'SELECT bcode FROM tbl_Brand_Sub where typ=? and bcode=?';
        $query = $this->db->query($sql,array($typ,$code));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Cnt_MyFriend($uid,$fuid){
        $this->db->where('uid',$uid);
        $this->db->where('f_uid',$fuid);
        $this->db->from('tbl_Game_Friend');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }

    public function Load_Brand_Info($bcode){
        $this->db->select('*');
        $this->db->where('bcode',$bcode);
        $query = $this->db->get('tbl_Brand');
        return $query->result_array();
    }


    public function Data_Load($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_cartoon_Brand a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function Data_Load2($start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_Brand a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function Data_Load3($typ,$bcode,$start, $limit, $sidx, $sord)
    {
        $sql = "SELECT * FROM tbl_Brand_Sub a where typ=".$typ." and bcode=".$bcode." ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    function Data_Add($param)
    {
        $data = array(
            'wcode' => $param['wcode'],
            'imgname' => '',
            'content' => $param['content'],
            'company' =>$param['company']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_cartoon_Brand', $data);
        $insert_id = $this->db->insert_id();

        if (!$this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_Brand Insert]');
        }

        return $insert_id;
    }

    function Data_Member_Add($param)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_Brand_Sub', $param);
        $insert_id = $this->db->insert_id();

        if (!$this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Brand_Sub Insert]');
        }

        return $insert_id;
    }

    public function Brand_Add($param){
        $this->db->trans_start();
        $this->db->insert('tbl_Brand',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Brand_Member_Add($param){
        $this->db->trans_start();
        $this->db->insert('tbl_Brand_Sub',$param);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }


    function Data_Update($param)
    {
        $id = $param['id'];
        $data = array(
            'b_title' => $param['b_title'],
            'b_content' => $param['b_content'],
            'isUse' => $param['isUse'],
            'forder' =>$param['forder']
        );


        $this->db->trans_start();
        $this->db->where('bcode', $id);
        $this->db->update('tbl_Brand', $data);
        $affected_rows = $this->db->affected_rows();

        if (!$this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Brand Update]');
        }
        return $affected_rows;

    }

    function Data_Del($id)
    {
        $data = array(
            'bcode' => $id
        );

        $this->db->trans_start();
        $this->db->delete('tbl_Brand_Sub', $data);
        $affected_rows = $this->db->affected_rows();

        $this->db->delete('tbl_Brand', $data);
        $affected_rows = $this->db->affected_rows();

        if (!$this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_Brand Delete]');
        }
        return $affected_rows;
    }

    function Data_Member_Del($id)
    {
        $data = array(
            'sn' => $id
        );

        $this->db->trans_start();
        $this->db->delete('tbl_Brand_Sub',$data);
        $affected_rows = $this->db->affected_rows();

        if (!$this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_Brand Delete]');
        }
        return $affected_rows;
    }
}