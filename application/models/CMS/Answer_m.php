<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
   public function all_count(){
        $sql = 'SELECT uid FROM tbl_online_question';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
     public function Data_Load($start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
         if($searchString!=''){
             if($searchOper=='eq'){
                 $sql = "SELECT *,(select userid from tbl_member where uid=a.uid) as userid FROM tbl_online_question a where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                 $query = $this->db->query($sql,$searchString);
             }else if($searchOper=='cn'){
                 $term = '%'.$searchString."%";
                 $sql = "SELECT *,(select userid from tbl_member where uid=a.uid) as userid FROM tbl_online_question a where ".$searchField." LIKE ? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                 $query = $this->db->query($sql,$term);
             }
         }else{
             $sql = "SELECT *,(select userid from tbl_member where uid=a.uid) as userid FROM tbl_online_question a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
             $query = $this->db->query($sql);
         }
         return $query;
    }
     
     public function Data_Del($Bnum){
          $data = array(
                'Bnum' => $Bnum
          );
        $this->db->trans_start();
        $this->db->delete('tbl_online_question',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [online_question Delete]');
        }
        return $affected_rows;
    }
  
    public function Load_Reply($Bnum){
        $sql = "SELECT * FROM tbl_online_answer where Bnum=? order by sn asc";
        $Query = $this->db->query($sql,$Bnum);
        return $Query->result_array();
    }
    
    public function Insert_Reply($param){
        $data = array(
            'Bnum' => $param['Bnum'],
            'content' => $param['content']
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_online_answer',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [online_answer Insert]');
        }

        return $insert_id;   
   }
    
   public function Update_Answer($Bnum){
        $data = array(
            'isAnswer' => 1
        );
        
        $this->db->trans_start();
        $this->db->set('reply', 'reply+1', FALSE);
        $this->db->where('Bnum',$Bnum);
        $this->db->update('tbl_online_question',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [replay Update]');
        }
        return $affected_rows;
   } 
    
    
    
}