<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Writer_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count($tstr){
        if(empty($tstr)) {
            $sql = 'SELECT code FROM tbl_writer';
        }else{
            $sql = "SELECT code FROM tbl_writer where email like '%".$tstr."%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_writer where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }    
        }else{
            if(empty($tstr)) {
                $sql = "SELECT * FROM tbl_writer ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT * FROM tbl_writer where email like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
        }
        return $query;
    }

    function Load_All(){
            $Query = $this->db->get('tbl_writer');
            return $Query->result_array();
    }
    
    function Data_Add($param,$encrypt){
        $data = array(
            'wname' => $param['wname'],
            'email' => $param['email'],
            'tel' => $param['tel'],
            'mobile' => $param['mobile'],
            'address' => $param['address'],
            'SKey' => $encrypt
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_writer',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Insert]');
        }

        return $insert_id;   
    }
    
    function Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'wname' => $param['wname'],
            'email' => $param['email'],
            'tel' => $param['tel'],
            'mobile' => $param['mobile'],
            'address' => $param['address'],
            'isActive' => $param['isActive']
        );
        
        $this->db->trans_start();
        $this->db->where('code',$code);
        $this->db->update('tbl_writer',$data);
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
        $this->db->delete('tbl_writer',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Delete]');
        }
        return $affected_rows;
    }
    
    
}