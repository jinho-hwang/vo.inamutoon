<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sub_cartoon_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function Load_Scene_date($sdate){
        $sql = "select * from tbl_Scene where date_format(regidate, '%Y-%m-%d')  >=? order by sn desc";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }


    function Load_All(){
        $Query = $this->db->get('tbl_Sub_Cartoon');
        return $Query->result_array();
    }
    
    public function all_count($pcode)
    {
        $sql = 'SELECT sn FROM tbl_Sub_Cartoon where pcode=?';
        $query = $this->db->query($sql,$pcode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
    public function Scene_Cnt($pcode,$cnum){
    	$sql = 'select count(*) as Cnt from tbl_Scene where pcode=? and cnum=?';
		$Query = $this->db->query($sql,array($pcode,$cnum));
        return $Query->result_array();
    }

    public function Scene_Load_All($snum,$val){
        $sql = 'select * from tbl_Scene where sn > ? order by sn asc limit ?;';
        $Query = $this->db->query($sql,array($snum,$val));
        return $Query->result_array();
    }

    public function Scene_Load_All2(){
        $sql = 'select * from tbl_Scene where pcode=174 and cnum=1;';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function Scene_Load_All3($pcode,$cnum){
        $sql = 'select * from tbl_Scene where pcode=? and cnum=? order by sn asc;';
        $Query = $this->db->query($sql,array($pcode,$cnum));
        return $Query->result_array();
    }

    public function Scene_Load_All4($pcode){
        $sql = 'select * from tbl_Scene where pcode=? order by sn asc;';
        $Query = $this->db->query($sql,array($pcode));
        return $Query->result_array();
    }

    	
    
    public function Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper)
    {
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_Sub_Cartoon where pcode=? and ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,array($pcode,$searchString));
            }    
        }else{
            $sql = "SELECT * FROM tbl_Sub_Cartoon a where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql,$pcode);
        }
        return $query;
    }
    
    
    
     function Data_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'cnum' => $param['cnum'],
            'imgname' => '',
            'star' => $param['star'],
            'isLogin' => $param['isLogin'],
            'cartoon_price' => $param['cartoon_price'],
            'cartoon_sale' => $param['cartoon_sale'],
            'cartoon_price2' => $param['cartoon_price2'],
            'cartoon_sale2' => $param['cartoon_sale2'],
            //'sale_date' => $param['sale_date'],
            'sale_date' => '',
            'sType' => $param['sType'],
            'sub_Title' =>$param['sub_Title'],
            'update_date' => date('Y-m-d H:i:s'),
            'Supervisor' =>$param['Supervisor']
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_Sub_Cartoon',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon Insert]');
        }

        return $insert_id;   
   }

  
   function Data_Update($param){
        $sn =  $param['id'];
        $data = array(
            'pcode' => $param['pcode'],
            'cnum' => $param['cnum'],
            'star' => $param['star'],
            'isActive' => $param['isActive'],
            'isLogin' => $param['isLogin'],
            'cartoon_price' => $param['cartoon_price'],
            'cartoon_sale' => $param['cartoon_sale'],
            'cartoon_price2' => $param['cartoon_price2'],
            'cartoon_sale2' => $param['cartoon_sale2'],
            'sType' => $param['sType'],
            'sub_Title' =>$param['sub_Title'],
            'Supervisor' =>$param['Supervisor'],
            'update_date' => $param['update_date']
        );
        
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Sub_Cartoon',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Sub_Cartoon Update]');
        }
        return $affected_rows;
        
    }

   function Load_Sub_Cartoon($sn){
       $sql = 'select * from tbl_Sub_Cartoon where sn=?';
       $Query = $this->db->query($sql,$sn);
       return $Query->result_array();
   }

   function Data_Del($sn){
          $data = array(
                'sn' => $sn
          );
        $this->db->trans_start();
        $this->db->delete('tbl_Sub_Cartoon',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Sub_Cartoon Delete]');
        }
        return $affected_rows;
    }
   
    function Update_Main_Filename($sn,$filename){
        $data = array(
           'imgname' => $filename
        );
        
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Sub_Cartoon',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Sub_Cartoon filename Update]');
        }
        return $affected_rows;
    }

    function Update_content_Filename($sn,$filename){
        $data = array(
           'imgname' => $filename
        );
        
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Scene',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Sub_Cartoon filename Update]');
        }
        return $affected_rows;
    }

    function all_Scene_count(){
         $sql = 'SELECT sn FROM tbl_Scene';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    function all_Scene_count_pcode($pcode,$cnum){
        $sql = 'SELECT sn FROM tbl_Scene where pcode=? and cnum=?';
        $query = $this->db->query($sql,array($pcode,$cnum));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }



    function Scene_Load($start, $limit, $sidx, $sord,$pcode,$cnum){
        $sql = "SELECT *,(select title from tbl_cartoon where code=a.pcode) as title FROM tbl_Scene a where pcode=? and cnum=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,array($pcode,$cnum));
        return $query;
    }
    
    function Scean_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'cnum' => $param['cnum'],
            'scene' =>$param['scene'],
            'imgname' => ''
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_Scene',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Scene Insert]');
        }

        return $insert_id;   
    }
	
	 function Insert_Scean($param){
        $data = array(
            'pcode' => $param['pcode'],
            'cnum' => $param['cnum'],
            'scene' =>$param['scene'],
            'imgname' => $param['img']
         );
            
        $this->db->trans_start();    
        $this->db->insert('tbl_Scene',$data);   
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Scene Insert]');
        }

        return $insert_id;   
    }
	
    
    function Scene_Del($sn){
        $data = array(
                'sn' => $sn
          );
          
        $this->db->trans_start();
        $this->db->delete('tbl_Scene',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Scene Delete]');
        }
        return $affected_rows;
        
    }

    function Scene_Del_All($pcode,$scode){
        $data = array(
            'pcode' => $pcode,
            'scode' =>$scode
        );

        $this->db->trans_start();
        $this->db->delete('tbl_temp_imgname',$data);
        $affected_rows = $this->db->affected_rows();

        $data = array(
            'pcode' => $pcode,
            'cnum' =>$scode
        );

        $this->db->delete('tbl_Scene',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Scene Delete]');
        }
        return $affected_rows;

    }




    
    function Scean_Update($param){
        $sn =  $param['id'];
        $data = array(
            'scene' => $param['scene']
        );
        
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_Scene',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Scene Update]');
        }
        return $affected_rows;
    }

}