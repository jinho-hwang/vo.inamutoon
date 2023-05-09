<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count($tstr){
        if(empty($tstr)) {
            $sql = 'SELECT code FROM tbl_Company';
        }else{
            $sql = "SELECT code FROM tbl_Company where email like '%".$tstr."%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function all_count2($ccode){
        $sql = 'SELECT code FROM tbl_Company_Group where ccode=?';
        $query = $this->db->query($sql,$ccode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_Company where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }    
        }else{
            if(empty($tstr)) {
                $sql = "SELECT * FROM tbl_Company ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT * FROM tbl_Company where email like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
        }
        return $query;
    }

    public function Data_Load2($ccode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        $sql = "select a.sn,b.* from tbl_Company_Group a,tbl_writer b where a.wcode=b.code and a.ccode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,$ccode);
        return $query;
    }

    function Data_Add($param,$encrypt){
        $data = array(
            'cname' => $param['cname'],
            'email' => $param['email'],
            'tel' => $param['tel'],
            'mobile' => $param['mobile'],
            'address' => $param['address'],
            'SKey' => $encrypt
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_Company',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Insert]');
        }

        return $insert_id;   
    }

    function Data_Add2($ccode,$wcode){
        $data = array(
            'ccode' => $ccode,
            'wcode' => $wcode
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_Company_Group',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Insert]');
        }

        return $insert_id;   
    }


    
    function Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'cname' => $param['cname'],
            'email' => $param['email'],
            'tel' => $param['tel'],
            'mobile' => $param['mobile'],
            'address' => $param['address'],
            'isActive' => $param['isActive']
        );
        
        $this->db->trans_start();
        $this->db->where('code',$code);
        $this->db->update('tbl_Company',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Update]');
        }
        return $affected_rows;
        
    }
    
    function Data_Del($code){
          $data = array(
                'code' => $code
          );
        $this->db->trans_start();
        $this->db->delete('tbl_Company',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Delete]');
        }
        return $affected_rows;
    }

    function Data_Del2($sn){
      $this->db->trans_start();
      $this->db->where('sn',$sn);
      $this->db->delete('tbl_Company_Group');
      $affected_rows = $this->db->affected_rows();
      
      if ( ! $this->db->trans_complete()) {
          throw new exception('transaction > [Writer Delete]');
      }
      return $affected_rows;
  }

    public function Company_Data_Load_Code($uid){
		$sql = 'select * from tbl_Company where code=?';
		$Query = $this->db->query($sql,$uid);
        return $Query->result_array();
    }

}