<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartoon_m extends CI_Model {

     public function __construct(){
        parent::__construct();
        $this->load->database();
     }

     function Load_All(){
        $Query = $this->db->get('tbl_cartoon');
        return $Query->result_array();
     }

    function Admin_Load($wid,$pcode){
        $sql = 'select Count(*) as Cnt from tbl_admin_cartoon where uid=? and pCode=?'  ;
        $Query = $this->db->query($sql,array($wid,$pcode));
        return $Query->result_array();
    }


    function Load_CartoonList_type($typ){
        $sql = 'select * from tbl_cartoon where cartoon_typ1=? and isOpen=1;'  ;
        $Query = $this->db->query($sql,$typ);
        return $Query->result_array();
    }

    function Load_Cartoon_like($tstr){
        $this->db->select('*');
        $this->db->like('title',$tstr);
        $this->db->order_by('code','DESC');
        $query = $this->db->get('tbl_cartoon');

        return $query->result_array();
    }


     public function all_count($typ,$tstr){
        if($typ==0) {
            $sql = 'SELECT a.code FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code';
        }else if($typ==1) {
            $sql = "SELECT a.code FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and a.title like '%".$tstr."%'";
        }else if($typ==2) {
            $sql = "SELECT a.code FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and b.wname like '%".$tstr."%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
     }

    public function week_all_count($pcode){
        $sql = 'SELECT sn FROM tbl_Cartoon_week where pcode=?';
        $query = $this->db->query($sql,$pcode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Cnt_Sub_Cartoon($pcode)
    {
        $this->db->where('pcode', $pcode);
        $this->db->from('tbl_Sub_Cartoon');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }



    public function all_count2($wid,$typ,$tstr){
        if($typ==0) {
            $sql = 'SELECT a.code FROM tbl_admin_cartoon c,tbl_cartoon a,tbl_writer b where c.pCode=a.code and a.writer1=b.code and uid=?';
        }else if($typ==1) {
            $sql = "SELECT a.code FROM tbl_admin_cartoon c,tbl_cartoon a,tbl_writer b where c.pCode=a.code and a.writer1=b.code and uid=? and a.title like '%".$tstr."%'";
        }else if($typ==2) {
            $sql = "SELECT a.code FROM tbl_admin_cartoon c,tbl_cartoon a,tbl_writer b where c.pCode=a.code and a.writer1=b.code and uid=? and b.wname like '%".$tstr."%'";
        }
        $query = $this->db->query($sql,$wid);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function Load_Sub_Title_Down($pcode,$scode){
        $sql = 'select *,(select count(*) as Cnt from tbl_Sub_Cartoon  where pcode=? and cnum<=a.cnum and sType=0) as Cnt from tbl_Sub_Cartoon a where pcode=? and cnum=?;';
        $Query = $this->db->query($sql,array($pcode,$pcode,$scode));
        return $Query->result_array();
    }

     public function Load_Cartoon_Wid($wid){
        $sql = 'select * from tbl_cartoon where writer1=? order by code desc'  ;
        $Query = $this->db->query($sql,$wid);
        return $Query->result_array();
     }

    public function Load_Cartoon_All(){
        $sql = 'select * from tbl_cartoon  order by title asc'  ;
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function Load_Cartoon_Code($code){
        $sql = 'select * from tbl_cartoon where code=?'  ;
        $Query = $this->db->query($sql,$code);
        return $Query->result_array();
    }

    public function Load_Cartoon_Type($typ){
        $sql = 'select * from tbl_cartoon where cartoon_typ1=?'  ;
        $Query = $this->db->query($sql,$typ);
        return $Query->result_array();
    }

    public function Load_Cartoon_Goyang($typ){
        $sql = 'SELECT *,(select count(*) from tbl_goyang_competiton where pcode=a.code) as Tcnt FROM EBS_Toon.tbl_cartoon a where cartoon_typ1=?'  ;
        $Query = $this->db->query($sql,$typ);
        return $Query->result_array();
    }

     public function Data_Load($typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_cartoon where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{
            if($typ==0) {
                $sql = "SELECT * FROM tbl_cartoon a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==1) {
                $sql = "SELECT a.* FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and a.title like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==2) {
                $sql = "SELECT a.* FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and b.wname like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }

            $query = $this->db->query($sql);
        }
        return $query;
     }

    public function Data_Load2($wid,$typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_admin_cartoon a,tbl_cartoon b where a.pCode=b.code and a.uid=?  ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{
            if($typ==0) {
                $sql = "SELECT * FROM tbl_admin_cartoon c, tbl_cartoon a where a.code=c.pCode and c.uid=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==1) {
                $sql = "SELECT * FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and a.title like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else if($typ==2) {
                $sql = "SELECT * FROM tbl_cartoon a,tbl_writer b where a.writer1=b.code and b.wname like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql,$wid);
        }
        return $query;
    }

    public function week_Data_Load($pcode,$start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_Cartoon_week where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,$pcode);
        return $query;
    }

     function temp_imgname_Load($pcode,$scode){
        $sql = 'SELECT * FROM tbl_temp_imgname where pcode=? and scode=? order by sn desc limit 1';
        $query = $this->db->query($sql,array($pcode,$scode));
        return $query->result_array();;
     }

     function Data_Add($param){
        $data = array(
            'title' => $param['title'],
            'sub_title' => $param['sub_title'],
            'category' => $param['category'],
            'cat_month' =>$param['cat_month'],
            //'cat_week' =>$param['cat_week'],
            'writer1' => $param['writer1'],
            'imgname' => '',
            'view_type' => $param['view_type'],
            'view_dir' => $param['view_dir'],
            //'cartoon_price' => $param['cartoon_price'],
            'cartoon_price' => 0,
            'cartoon_fee' => $param['cartoon_fee'],
            'cash' => $param['cash'],
            'p_cash' => $param['p_cash'],
            //'sale' => $param['sale'],
            'sale' => 0,
            'Supervisor' => $param['Supervisor'],
            //'sale_date' => $param['sale_date'],
            'sale_date' => '',
            'point' => 0,
            'isStatus' => $param['isStatus'],
            'cartoon_typ1' =>$param['cartoon_typ1'],
            'cartoon_typ2' =>$param['cartoon_typ2'],
            'isNotList' =>$param['isNotList'],
            'isLike' =>$param['isLike'],
            'isSample' => '',
            'isOpen' => $param['isOpen'],
            'isPwd' => $param['isPwd'],
            'isProlog' => 0,
            'isFree' => $param['isFree'],
            'isMonth' => $param['isMonth'],
            'isRecom' => $param['isRecom'],
            'recom_fix' => $param['recom_fix'],
            'hit' => $param['hit'],
            //'isWeek' => $param['isWeek'],
            'isWeek' => 0,
            'explan' => $param['explan']
         );

        $this->db->trans_start();
        $this->db->insert('tbl_cartoon',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'title' => $param['title'],
            'sub_title' => $param['sub_title'],
            'category' => $param['category'],
            //'cat_week' =>$param['cat_week'],
            'cat_month' =>$param['cat_month'],
            'writer1' => $param['writer1'],
            //'cartoon_price' => $param['cartoon_price'],
            'cartoon_price' => 0,
            'view_type' => $param['view_type'],
            'view_dir' => $param['view_dir'],
            'cartoon_fee' => $param['cartoon_fee'],
            'cash' => $param['cash'],
            'p_cash' => $param['p_cash'],
            //'sale' => $param['sale'],
            'Supervisor' => $param['Supervisor'],
            //'sale_date' => $param['sale_date'],
            'point' => 0,
            'isStatus' => $param['isStatus'],
            'isSale' => $param['isSale'],
            'cartoon_typ1' =>$param['cartoon_typ1'],
            'cartoon_typ2' =>$param['cartoon_typ2'],
            'isNotList' =>$param['isNotList'],
            'isLike' =>$param['isLike'],
            'isSample' => '',
            'isOpen' => $param['isOpen'],
            'isPwd' => $param['isPwd'],
            'isProlog' => 0,
            'isFree' => $param['isFree'],
            'isMonth' => $param['isMonth'],
            'isRecom' => $param['isRecom'],
            'recom_fix' => $param['recom_fix'],
            'hit' => $param['hit'],
            //'isWeek' => $param['isWeek'],
            'isWeek' => 0,
            'explan' => $param['explan']
        );

        $this->db->trans_start();
        $this->db->where('code',$code);
        $this->db->update('tbl_cartoon',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon Update]');
        }
        return $affected_rows;

    }

    function Sub_Cartoon_Update($param){
       $code =  $param['pcode'];
       $data = array(
          'cartoon_price' => $param['price'],
          'cartoon_price2' => $param['price2'],
       );

       $this->db->trans_start();
       $this->db->where('pcode',$code);
       $this->db->update('tbl_Sub_Cartoon',$data);
       $affected_rows = $this->db->affected_rows();

       if ( ! $this->db->trans_complete()) {
           throw new exception('transaction > [tbl_Sub_Cartoon Update]');
       }
       return $affected_rows;


    }


    function Data_Del($code){
          $data = array(
                'code' => $code
          );
        $this->db->trans_start();
        $this->db->delete('tbl_cartoon',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon Delete]');
        }
        return $affected_rows;
    }

    function Update_Main_Filename($code,$filename){
        $data = array(
           'imgname' => $filename
        );

        $this->db->trans_start();
        $this->db->where('code',$code);
        $this->db->update('tbl_cartoon',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon filename Update]');
        }
        return $affected_rows;
    }

    function Load_Cartoon($pcode){
        $data = array(
            'code' => $pcode
        );
        $Query = $this->db->get_where('tbl_cartoon',$data);
        return $Query->result_array();
    }


    public function Load_Scean($pcode,$cnum){
        $sql = 'select * from tbl_Scene where pcode=? and cnum=? order by scene asc'  ;
        $Query = $this->db->query($sql,array($pcode,$cnum));
        return $Query->result_array();
    }

    public function Img_all_count($pcode)
    {
        $sql = 'SELECT sn FROM tbl_cartoon_Image where pcode=?';
        $query = $this->db->query($sql, $pcode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Img_Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_cartoon_Image a where pcode='.$pcode.' and ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }else if($searchOper=='cn'){
                $term = '%'.$searchString."%";
                $sql = "SELECT * FROM tbl_cartoon_Image a where pcode='.$pcode.' and ".$searchField." LIKE ? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$term);
            }
        }else{
            $sql = "SELECT * FROM tbl_cartoon_Image a where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql,$pcode);
        }
        return $query;
    }

    function Img_Data_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'location' => $param['location'],
            'isUse' => $param['isUse'],
            'fname' => '',
            'bg_img' => '',
            'fcolor' => $param['fcolor'],
            'font_color' => $param['font_color']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_cartoon_Image',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon_Image Insert]');
        }

        return $insert_id;
    }

    function Img_Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'location' => $param['location'],
            'fcolor' => $param['fcolor'],
            'isUse' => $param['isUse'],
            'font_color' => $param['font_color']
        );

        $this->db->trans_start();
        $this->db->where('sn',$code);
        $this->db->update('tbl_cartoon_Image',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon_Image Update]');
        }
        return $affected_rows;

    }

    function Img_Data_Del($code){
        $data = array(
            'sn' => $code
        );
        $this->db->trans_start();
        $this->db->delete('tbl_cartoon_Image',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon_Image Delete]');
        }
        return $affected_rows;
    }


    public function Notice_all_count($pcode)
    {
        $sql = 'SELECT sn FROM tbl_cartoon_notice where pcode=?';
        $query = $this->db->query($sql, $pcode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Notice_Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT * FROM tbl_cartoon_notice a where pcode='.$pcode.' and ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }else if($searchOper=='cn'){
                $term = '%'.$searchString."%";
                $sql = "SELECT * FROM tbl_cartoon_notice a where pcode='.$pcode.' and ".$searchField." LIKE ? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$term);
            }
        }else{
            $sql = "SELECT * FROM tbl_cartoon_notice a where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql,$pcode);
        }
        return $query;
    }

    function Notice_Data_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'title' => $param['title'],
            'isOpen' => $param['isOpen'],
        );

        $this->db->trans_start();
        $this->db->insert('tbl_cartoon_notice',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_notice Insert]');
        }

        return $insert_id;
    }

    function Notice_Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'title' => $param['title'],
            'isOpen' => $param['isOpen']
        );

        $this->db->trans_start();
        $this->db->where('sn',$code);
        $this->db->update('tbl_cartoon_notice',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_notice Update]');
        }
        return $affected_rows;

    }

    function Notice_Data_Del($code){
        $data = array(
            'sn' => $code
        );
        $this->db->trans_start();
        $this->db->delete('tbl_cartoon_notice',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_notice Delete]');
        }
        return $affected_rows;
    }


    function Week_Del($sn){
        $data = array(
            'sn' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_Cartoon_week',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Cartoon Delete]');
        }
        return $affected_rows;
    }

    function Week_Add($pcode,$param){
        $data = array(
            'pcode' => $pcode,
            'week' => $param['week']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_Cartoon_week',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_cartoon_notice Insert]');
        }

        return $insert_id;
    }
}