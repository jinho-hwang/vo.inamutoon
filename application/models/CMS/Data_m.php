<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count($tstr)
    {
        if(empty($tstr)){
            $sql = "SELECT pcode FROM tbl_View_Log ";
        }else {
            $sql = "SELECT pcode FROM tbl_View_Log a,tbl_member b where a.uid=b.uid and b.userid like '%" . $tstr . "%'";
        }
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper)
    {
        if($searchString!=''){
            if($searchOper=='eq'){
                $sql = "SELECT a.Userid,b.*,c.title FROM `tbl_member` a, `tbl_View_Log` b,  `tbl_cartoon` c WHERE a.uid=b.uid and b.pcode = c.code and ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{

            if(empty($tstr)) {
                $sql = "SELECT a.Userid,b.*,c.title FROM `tbl_member` a, `tbl_View_Log` b,  `tbl_cartoon` c WHERE a.uid=b.uid and b.pcode = c.code ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT a.Userid,b.*,c.title FROM `tbl_member` a, `tbl_View_Log` b,  `tbl_cartoon` c WHERE a.uid=b.uid and b.pcode = c.code and a.userid like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }

            $query = $this->db->query($sql);
        }
        return $query;
    }

    public function gender_Data($sex){
        if($sex==1) {
            $sql = 'SELECT pcode,(select title from tbl_cartoon where code=a.pcode) as title , count(*) as Cnt FROM `tbl_View_Log` a where (select gender from tbl_member where uid=a.uid) in (1)  group by pcode order by 3 desc';
        }else{
            $sql = 'SELECT pcode,(select title from tbl_cartoon where code=a.pcode) as title , count(*) as Cnt FROM `tbl_View_Log` a where (select gender from tbl_member where uid=a.uid) in (0)  group by pcode order by 3 desc';
        }
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function part_Data($part){
        $sql = 'SELECT pcode,(select title from tbl_cartoon where code=a.pcode) as title , count(*) as Cnt FROM `tbl_View_Log` a where (select TField'.$part.' from tbl_Cartoon_Tendency where pcode=a.pcode) = 1  group by pcode order by 3 desc';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function member_Birth(){
        $sql = 'SELECT distinct(left(Birth,4)) as cbirth FROM `tbl_member` order by 1 desc';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function age_Data($syear,$eyear){
        $sql = 'SELECT pcode,(select title from tbl_cartoon where code=a.pcode) as title , count(*) as Cnt FROM `tbl_View_Log` a,`tbl_member` b where a.uid=b.uid and b.Birth >= ? and b.Birth<=?  group by pcode order by 3 desc';
        $Query = $this->db->query($sql,array($syear,$eyear));
        return $Query->result_array();
    }


    public function part_Data_All($part){
        $sql = 'SELECT count(*) as Cnt FROM `tbl_View_Log` a where (select TField'.$part.' from tbl_Cartoon_Tendency where pcode=a.pcode) = 1';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }


    public function all_count_Book111($pcode,$sdate,$edate)
    {
        $sql = "select count(c.ccode) as Cnt from (select ccode from tbl_View_Log where pcode=? and regidate >=? and regidate<=? group by ccode) as c";
        $query = $this->db->query($sql,array($pcode,$sdate,$edate));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Book111_Data_Load($pcode,$sdate,$edate){
        $sql = 'select ccode,Count(*) as Cnt from tbl_View_Log where pcode=? and regidate >=? and regidate<=? group by ccode order by 1 asc';
        $query = $this->db->query($sql,array($pcode,$sdate,$edate));
        return $query;
    }




}