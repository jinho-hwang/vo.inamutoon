<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function Load_All(){
      
            $sql = 'SELECT a.*,b.* FROM tbl_a_category a,tbl_category b where a.1st = b.1st order by b.sn desc';
            $Query = $this->db->query($sql);
            return $Query->result_array();
    }
    
    public function all_count(){
        $sql = 'SELECT code FROM tbl_category';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
    public function Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_category ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }
    
    
    
    function Data_Add($param){
        $data = array(
            'code' => $param['code'],
            'cname' => $param['cname'],
            'isActive' => $param['isActive'],
            'seq'=>$param['seq']
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_category',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Category Insert]');
        }

        return $insert_id;   
   }
  
   function Data_Update($param){
        $sn =  $param['id'];
        $data = array(
            'code' => $param['code'],
            'cname' => $param['cname'],
            'isActive' => $param['isActive'],
            'seq'=>$param['seq']
        );
        
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_category',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Category Update]');
        }
        return $affected_rows;
        
    }
  
     function Data_Del($sn){
          $data = array(
                'sn' => $sn
          );
        $this->db->trans_start();
        $this->db->delete('tbl_category',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Category Delete]');
        }
        return $affected_rows;
    }

    public function Eduall_count(){
        $sql = 'SELECT code FROM tbl_category';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function EduData_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_cartoon_edu ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }



    function EduData_Add($param){
        $data = array(
            'code' => $param['code'],
            'mtype' => $param['mtype'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_cartoon_edu',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_edu Insert]');
        }

        return $insert_id;
    }

    function EduData_Update($param){
        $sn =  $param['id'];
        $data = array(
            'mtype' => $param['mtype'],
            'isUse' => $param['isUse']
        );

        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_cartoon_edu',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_edu Update]');
        }
        return $affected_rows;

    }

    function EduData_Del($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_cartoon_edu',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_edu Delete]');
        }
        return $affected_rows;
    }
    
}