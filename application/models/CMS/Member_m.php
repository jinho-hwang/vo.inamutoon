<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function Load_All(){
        $Query = $this->db->get('tbl_member');
        return $Query->result_array();
    }
    
    public function all_count($typ,$tstr){
        if($typ==0) {
            $sql = 'SELECT uid FROM tbl_member';
        }else if($typ==1){
            $sql = "SELECT uid FROM tbl_member where userid like '%".$tstr."%'";
        }else if($typ==2){
            $sql = "SELECT uid FROM tbl_member where uname like '%".$tstr."%'";
        }else if($typ==3){
            $sql = "SELECT uid FROM tbl_member where auth like '%".$tstr."%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
     public function Data_Load($typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_member where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }else if($searchOper=='cn'){
                $sql = "SELECT * FROM tbl_member where ".$searchField." like '%".$searchString."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql);
            }
        }else{
            if($typ==0) {
                $sql = "SELECT * FROM tbl_member ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==1){
                $sql = "SELECT * FROM tbl_member where userid like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==2){
                $sql = "SELECT * FROM tbl_member where uname like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==3){
                $sql = "SELECT * FROM tbl_member where auth like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
        }
        return $query;
    }
    
    
     public function Data_Add($param){
        $data = array(
            'userid' => $param['userid'],
            'uname' => $param['uname'],
            'cash' => $param['cash'],
            'point' => 0,
            'f_Type' => 0,
            'superID' => $param['superID']
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_member',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Member Insert]');
        }

        return $insert_id;   
   }
  
   public function Data_Update($param){
        $uid =  $param['id'];
        $data = array(
            'userid' =>$param['userid'],
            'uname' => $param['uname'],
            'cash' => $param['cash'],
            'point' => $param['point'],
            'f_Type' => $param['f_Type'],
            'superID' => $param['superID']
        );
        
        
        $this->db->trans_start();
        $this->db->where('uid',$uid);
        $this->db->update('tbl_member',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Member Update]');
        }
        return $affected_rows;
        
    }
   
   public function Data_Del($uid){
          $data = array(
                'uid' => $uid
          );
        $this->db->trans_start();
        $this->db->delete('tbl_member',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Member Delete]');
        }
        return $affected_rows;
    }
   
   	public function Load_member_userid($userid){
   		$sql = "SELECT * FROM tbl_member WHERE userid=?";
		$Query = $this->db->query($sql,$userid);
        return $Query->result_array();
    }

    public function Load_member_uid($uid){
        $sql = "SELECT * FROM tbl_member WHERE uid=?";
        $Query = $this->db->query($sql,$uid);
        return $Query->result_array();
    }

    public function Load_member_Parent($p_Uid){
        $sql = "SELECT * FROM tbl_family_parent WHERE p_uid=?";
        $Query = $this->db->query($sql,$p_Uid);
        return $Query->result_array();
    }

    public function Load_member_Family($f_sn){
        $sql = "SELECT * FROM tbl_family_member a,tbl_member b WHERE b.uid=a.uid and a.f_sn=?";
        $Query = $this->db->query($sql,$f_sn);
        return $Query->result_array();
    }

    public function Group_Auth_Cnt(){
        $sql = "SELECT auth, COUNT( * ) as Cnt FROM  `tbl_member` GROUP BY auth";
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    
}