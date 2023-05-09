<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Counsel_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count1(){
        $sql = 'SELECT cid FROM tbl_counsel';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    function Data_List_Load($tstr,$start,$readNum){
        if(empty($tstr)) {
            $sql = 'SELECT a.*,b.title FROM tbl_counsel a,tbl_cartoon b where a.pCode=b.code order by cid desc limit ?,?';
        }else{
            $sql = "SELECT a.*,b.title FROM tbl_counsel a,tbl_cartoon b where a.pCode=b.code and b.title like '%".$tstr."%' order by cid desc limit ?,?";
        }
        $query = $this->db->query($sql,array($start,$readNum));
        return $query->result_array();
    }


    public function Load_Counsel_memberType($cid,$mtyp){
        $sql = 'SELECT a.*,b.wname,b.mtyp FROM tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid =? and b.mtyp=?';
        $query = $this->db->query($sql,array($cid,$mtyp));
        return $query->result_array();
    }

    function Cartoon_Load(){
        $this->db->select('*');
        $this->db->where('isOpen',1);
        $this->db->order_by('code','ASC');
        $query = $this->db->get('tbl_cartoon');
        return $query->result_array();
    }

    function Cartoon_Load2(){
        $this->db->select('*');
        $this->db->order_by('code','ASC');
        $query = $this->db->get('tbl_cartoon');
        return $query->result_array();
    }

    function Load_Excel_List($mtyp,$sdate,$edate){
        $sql = "select a.pCode,pNum,(select title from tbl_cartoon where code=a.pCode) as title,c.wname,b.* ";
        $sql .= "from tbl_counsel a,tbl_counsel_list b,tbl_counsel_member c where a.cid=b.cid and b.wid=c.code and c.mtyp=? and DATE_FORMAT(a.startdate,'%Y-%m-%d') >=? and DATE_FORMAT(a.startdate,'%Y-%m-%d') <=? order by title ASC,pNum ASC;";
        $Query = $this->db->query($sql,array($mtyp,$sdate,$edate));
        return $Query;
    }


    function Load_Counsel_Recom($cid){

        $sql = 'select a.*,b.wname,b.mtyp from tbl_counsel_recom a,tbl_counsel_member b where a.wid=b.code and a.cid=? order by a.sn DESC';
        $Query = $this->db->query($sql,array($cid));
        return $Query->result_array();
    }

    function Load_Counsel_Member($cid,$typ){

        $sql = 'select * from tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid=? and b.mtyp=?  order by a.sn DESC';
        $Query = $this->db->query($sql,array($cid,$typ));
        return $Query->result_array();
    }

    function Cnt_Counsel_Member($cid,$typ){

        $sql = 'select Count(*) as Cnt from tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid=? and b.mtyp=?  order by a.sn DESC';
        $Query = $this->db->query($sql,array($cid,$typ));
        return $Query->result_array();
    }

    function Cnt_Counsel_Member_Answer($cid,$typ){

        $sql = 'select Count(*) as Cnt from tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid=? and b.mtyp=? and a.isStatus=3  order by a.sn DESC';
        $Query = $this->db->query($sql,array($cid,$typ));
        return $Query->result_array();
    }

    function Load_Counsel_Member_Date($cid,$typ){

        $sql = 'select a.* from tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid=? and b.mtyp=? and  date(a.reqenddate) < date(now());';
        $Query = $this->db->query($sql,array($cid,$typ));
        return $Query->result_array();
    }

    function Load_Counsel($cid){
        $sql = 'select *,(select title from tbl_cartoon where code =a.pCode) as cname from tbl_counsel a where cid=?  order by cid DESC';
        $Query = $this->db->query($sql,$cid);
        return $Query->result_array();
    }

    function Load_Complete($cid,$mtyp){
        $sql = 'select a.* from tbl_counsel_list a,tbl_counsel_member b where a.cid=? and a.wid=b.code and isStatus<=3 and b.mtyp=?;';
        $Query = $this->db->query($sql,array($cid,$mtyp));
        return $Query->result_array();
    }


    function Complete_Update($sn,$param){
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_counsel_list',$param);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Update]');
        }
        return $affected_rows;

    }



    public function all_count($cid,$typ,$tstr){
        if($typ==0) {
            $sql = 'SELECT a.sn FROM tbl_counsel_list a where cid=?';
        }else if($typ==1) {
            $sql = "SELECT a.sn FROM tbl_counsel_list a,tbl_counsel_member b,tbl_cartoon c where a.cid=? and a.pCode=c.code and a.wid=b.code and c.title like '%".$tstr."%'";
        }else if($typ==2) {
            $sql = "SELECT a.sn FROM tbl_counsel_list a,tbl_counsel_member b where a,cid=? and a.wid=b.code and b.wname like '%".$tstr."%'";
        }
        $query = $this->db->query($sql,$cid);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load1($start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){
        $sql = "SELECT * FROM tbl_counsel a  ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    public function Data_Load($cid,$typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper){

        if($typ==0) {
            $sql = "SELECT *,(select mtyp from tbl_counsel_member where code=a.wid) as mtyp,(select wname from tbl_counsel_member where code=a.wid ) as wname FROM tbl_counsel_list a where cid=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        }else if($typ==1) {
            $sql = "SELECT a.* FROM tbl_counsel_list a,tbl_counsel_member b,tbl_cartoon c where a.pCode=c.code and a.cid=? and a.wid=b.code and c.title like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        }else if($typ==2) {
            $sql = "SELECT * FROM tbl_counsel_list a,tbl_counsel_member b where a.wid=b.code and a.cid=? and b.wname like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        }

        $query = $this->db->query($sql,$cid);
        return $query;
    }

    public function Cnt_Counsel($pCode,$pNum){
        $this->db->where('pCode',$pCode);
        $this->db->where('pNum',$pNum);
        $this->db->from('tbl_counsel');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }



    function Insert_Counsel($param){
        $this->db->insert('tbl_counsel', $param);
        $insert_id = $this->db->insert_id();


        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    function Insert_Counsel_Recom($param){
        $this->db->insert('tbl_counsel_recom', $param);
        $insert_id = $this->db->insert_id();


        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    function Update_Counsel_Cnt($typ,$cid,$Cnt)
    {
        if ($typ == 1){
            $data = array(
                'gCnt' => $Cnt
            );
        }else{
            $data = array(
                'eCnt' => $Cnt
            );
        }

        $this->db->trans_start();
        $this->db->where('cid',$cid);
        $this->db->update('tbl_counsel',$data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;

    }

    function Insert_Counsel_GMember($param){
        $this->db->trans_start();
        $this->db->insert('tbl_counsel_list', $param);
        $insert_id = $this->db->insert_id();


        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $insert_id;
    }



    function Data_Add($param){
        $this->db->trans_start();
        $this->db->insert('tbl_counsel_list',$param);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'wid' => $param['wid'],
            'pCode' => $param['pCode'],
            'pNum' => $param['pNum'],
            'isActive' => $param['isActive']
        );

        $this->db->trans_start();
        $this->db->where('sn',$code);
        $this->db->update('tbl_counsel_list',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Update]');
        }
        return $affected_rows;

    }

    function Data_Del($code){
        $data = array(
            'cid' => $code
        );
        $this->db->trans_start();
        $this->db->delete('tbl_counsel',$data);
        $this->db->delete('tbl_counsel_list',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Delete]');
        }
        return $affected_rows;
    }

    function Data_Update2($sn,$isActive){

        $data = array(
            'c_result' => 1,
            'isActive' => $isActive,
            'reqdate' =>date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_counsel_list',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Writer Update]');
        }
        return $affected_rows;

    }

    public function Update_Counsel_Status($cid,$isStatus){
        $data = array(
            'isStatus' => $isStatus
        );

        $this->db->trans_start();
        $this->db->where('cid',$cid);
        $this->db->update('tbl_counsel',$data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }

    public function Update_Counsel_Recom($cid,$ein,$param){
        $this->db->trans_start();
        $this->db->where('cid',$cid);
        $this->db->where_in('wid',$ein);
        $this->db->update('tbl_counsel_list',$param);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }


    public function Update_Counsel_list($sn,$data){
        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->update('tbl_counsel_list',$data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }

    public function Update_Counsel_list2($cid,$data){
        $this->db->trans_start();
        $this->db->where('cid',$cid);
        $this->db->update('tbl_counsel',$data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }

    public function Update_Counsel_list3($cid,$data){
        $this->db->trans_start();
        $this->db->where_in('cid',$cid);
        $this->db->update('tbl_counsel',$data);
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }

        return $affected_rows;
    }

    function Load_Counsel_Schedule($mtyp){

        $sql = 'select * from tbl_counsel_list a,tbl_counsel_member b WHERE a.wid=b.code and b.mtyp=? and DATE_FORMAT(reqenddate, "%Y-%m-%d") = CURDATE()  and a.isStatus<3;';
        $Query = $this->db->query($sql,$mtyp);
        return $Query->result_array();
    }

    function Load_Counsel_Schedule_distict($mtyp,$step){

        $sql = 'select DISTINCT(a.cid) as Cid from tbl_counsel_list a,tbl_counsel_member b,tbl_counsel c WHERE a.wid=b.code and a.cid=c.cid and b.mtyp=? and DATE_FORMAT(reqenddate, "%Y-%m-%d") = CURDATE() and c.isStatus=?';
        $Query = $this->db->query($sql,array($mtyp,$step));
        return $Query->result_array();
    }


    public function Cnt_End_Counsel($cid,$mtyhp){
        $sql = 'SELECT Count(a.sn) as Cnt FROM tbl_counsel_list a,tbl_counsel b,tbl_counsel_member c where a.cid=b.cid and a.wid =c.code and a.cid=? and c.mtyp=? and a.isStatus=3;';
        $query = $this->db->query($sql,array($cid,$mtyhp));
        return $query->result_array();
    }

    public function Load_Counsel_SN($cid){
        $this->db->select('*');
        $this->db->where('cid',$cid);
        $query = $this->db->get('tbl_counsel');
        return $query->result_array();
    }



}