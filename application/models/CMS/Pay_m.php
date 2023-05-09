<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function all_count_balanse(){
        $sql = "SELECT * FROM  tbl_member where cash > 0";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function balance_Sum_Load(){
        $sql = "SELECT Sum(cash) as cash_sum FROM tbl_member where cash > 0 ";
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }


    public function balance_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_member where cash > 0 ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $Query = $this->db->query($sql);
        return $Query;
    }

    public function pay_count($sdate,$edate){
        $sql = "SELECT * FROM  `tbl_Cash_Log`WHERE price >0 AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) >= ? AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) <=  ?";
        $query = $this->db->query($sql,array($sdate,$edate));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function priod_price_Sum($sdate,$edate){
        $sql = "SELECT sum(price) as sum,count(*) as Cnt FROM  `tbl_Cash_Log`WHERE price >0 AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) >= ? AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) <=  ?";
        $Query = $this->db->query($sql,array($sdate,$edate));
        return $Query->result_array();

    }


    public function Data_Load($sdate,$edate,$start, $limit, $sidx, $sord){
        $sql = "SELECT *,(select userid from tbl_member where uid=a.uid) as userid FROM tbl_Cash_Log a WHERE price >0 AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) >= ? AND DATE_FORMAT( regidate,  '%Y-%m-%d' ) <=  ? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,array($sdate,$edate));
        return $query;
    }


    public function Month_Charge_List($sdate,$edate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) as chk,DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, sum(price) as sum,count(*) as Cnt FROM `tbl_Cash_Log` WHERE price >0 and DATE_FORMAT( regidate,  '%Y-%m-%d' ) >=? and DATE_FORMAT( regidate,  '%Y-%m-%d' ) <=? group by DATE_FORMAT( regidate,  '%Y-%m-%d' ) order by 1 asc";
        $Query = $this->db->query($sql,array($sdate,$edate));
        return $Query->result_array();
    }


    public function Member_Buy_List_Sum($uid,$sdate)	{
        $sql = "SELECT IFNULL(SUM( cash ),0) AS cash,IFNULL(SUM( free ),0) AS free FROM tbl_Cash_Log WHERE uid=?";
        $sql .= " and DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0";
        $Query = $this->db->query($sql,array($uid,$sdate));
        return $Query->result_array();
    }

    public function Writer_Buy_List_Sum($wid,$sdate){
        $sql = "SELECT *";
        $sql .= ",(select cartoon_fee from tbl_cartoon where code=a.pcode) as Fee ";
        $sql .= " FROM tbl_Buy_Log a WHERE writer=?";
        $sql .= " and DATE_FORMAT( regidate,  '%Y-%m' ) =  ?";
        $Query = $this->db->query($sql,array($wid,$sdate));
        return $Query->result_array();
    }

    public function all_count_uid($uid,$sdate){
        $sql = 'SELECT * FROM tbl_Cash_Log where uid=?';
        $sql .= " and DATE_FORMAT( regidate,  '%Y-%m' ) =  ?";
        $query = $this->db->query($sql,array($uid,$sdate));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function all_count_wid($wid,$sdate,$pcode){
        $sql = 'SELECT * FROM tbl_Cash_Log where writer=?';
        if($pcode > 0){
            $sql .=' and pcode='. $pcode;
        }
        $sql .= " and DATE_FORMAT( regidate,  '%Y-%m' ) =  ?";
        $query = $this->db->query($sql,array($wid,$sdate));
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function Writer_Load($wid,$sdate,$pcode,$start, $limit, $sidx, $sord){
        $sql = "SELECT *";
        $sql .=",(select userid from tbl_member where uid=a.uid) as userid";
        $sql .=",(select wname from tbl_writer where code=a.writer) as wname";
        $sql .= " FROM tbl_Cash_Log a WHERE a.writer=?";
        if($pcode > 0){
            $sql .= " and pcode=".$pcode;
        }
        $sql .= " and DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ";
        $sql .= "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $Query = $this->db->query($sql,array($wid,$sdate));
        return $Query;
    }


    public function Member_Load($uid,$sdate,$start, $limit, $sidx, $sord){
        $sql = "SELECT *";
        $sql .=",(select userid from tbl_member where uid=a.uid) as userid";
        $sql .=",(select wname from tbl_writer where code=a.writer) as wname";
        $sql .= " FROM tbl_Cash_Log a WHERE a.uid=? and DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ";
        $sql .= "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $Query = $this->db->query($sql,array($uid,$sdate));
        return $Query;
    }

    public function Data_Load_All($uid,$sdate){
        $sql = "SELECT *";
        $sql .=",(select userid from tbl_member where uid=a.uid) as userid";
        $sql .=",(select wname from tbl_writer where code=a.writer) as wname";
        $sql .= " FROM tbl_Cash_Log a WHERE uid=? and DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ";
        $sql .= "ORDER BY sn desc";
        $Query = $this->db->query($sql,array($uid,$sdate));
        return $Query;
    }

    public function Load_buy_Log_Writer($wid,$sdate,$pcode){
        $sql = 'SELECT *,(select cartoon_fee from tbl_cartoon where code=a.pcode) as fee FROM tbl_Cash_Log a WHERE writer=?';
        if($pcode > 0){
            $sql .= ' and pcode='.$pcode;
        }
        $sql .= ' and DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0';
        $sql .= " order by sn desc";
        $Query = $this->db->query($sql,array($wid,$sdate));
        return $Query->result_array();
    }

    public function WriterData_Load_All($wid,$sdate,$pcode){
        $sql = "SELECT *";
        $sql .=",(select userid from tbl_member where uid=a.uid) as userid";
        $sql .=",(select wname from tbl_writer where code=a.writer) as wname";
        $sql .= " FROM tbl_Cash_Log a WHERE writer=?";
        if($pcode > 0){
            $sql .=" AND pcode=".$pcode;
        }
        $sql .= " AND DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ORDER BY sn desc";
        $Query = $this->db->query($sql,array($wid,$sdate));
        return $Query;
    }

    public function Cnt_Buy_Log($sdate,$wid,$pcode,$typ){
        if($typ==1) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Buy_Log WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and writer=?';
        }else if($typ==2) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0 and LEFT( log, 14 ) =  \'UseAllFreeCoin\' and writer=?';
        }else if($typ==3) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0 and free>0 and LEFT( log, 9 ) =  \'SplitCash\' and writer=?';
        }

        if($pcode > 0){
            $sql .= ' and pcode='.$pcode;
        }
        $Query = $this->db->query($sql,array($sdate,$wid));
        return $Query->result_array();
    }

    public function Cnt_View_Log($sdate,$wid,$pcode){
        $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_View_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and (select writer1 from tbl_cartoon where code=a.pcode)=?';
        if($pcode > 0){
            $sql .= ' and pcode='.$pcode;
        }
        $Query = $this->db->query($sql,array($sdate,$wid));
        return $Query->result_array();
    }




}