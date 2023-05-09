<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function all_count($sdate,$stype){
        $sql = 'SELECT uid FROM tbl_Cash_Log';
        $sql .= " WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ?";
        if($stype==2){
            $sql .= " and cash > 0 ";
        }else if($stype==3){
            $sql .= " and free > 0 ";
        }
        $query = $this->db->query($sql,$sdate);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
	
	public function Month_Buy_Load($sdate){
		$sql = "SELECT DATE_FORMAT( regidate,  '%d' ) as chk,DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt, SUM( price ) AS Sell FROM tbl_Buy_Log ";
		$sql .= " WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? GROUP BY m ORDER BY m ASC";
		$Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Month_MemberReg_Load($sdate,$type){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) as chk,DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt FROM tbl_member ";
        $sql .= " WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? ";
        if($type==1) {
            $sql .= "and auth = 'inamutoon'";
        }else if($type==2){
            $sql .= "and auth = 'naver'";
        }else if($type==3){
            $sql .= "and auth = 'google'";
        }else if($type==4){
            $sql .= "and auth = 'kakao'";
        }else if($type==5){
            $sql .= "and auth = 'facebook'";
        }else if($type==6){
            $sql .= "and auth = '조선일보'";
        }
        $sql .= " GROUP BY m ORDER BY m ASC";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Month_MemberReg_Load2($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) as chk,DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt FROM tbl_Kyowon_Evet ";
        $sql .= " WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? ";
        $sql .= " GROUP BY m ORDER BY m ASC";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }



    public function Year_MemberReg_Load($sdate,$type){
        $sql = "SELECT DATE_FORMAT( regidate,  '%m' ) as chk,DATE_FORMAT( regidate,  '%Y-%m' ) m, COUNT( * ) AS Cnt FROM tbl_member ";
        $sql .= " WHERE DATE_FORMAT( regidate,  '%Y' ) =  ? ";
        if($type==1){
            $sql .= "and isWhere <> 100";
        }else{
            $sql .= "and isWhere = 100";
        }
        $sql .= " GROUP BY m ORDER BY m ASC";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Today_memberReg_Cnt($today){
        $sql = "SELECT COUNT( * ) AS Cnt FROM  `tbl_member` where DATE_FORMAT( regidate,  '%Y-%m-%d' ) = ?";
        $Query = $this->db->query($sql,$today);
        return $Query->result_array();
    }



    public function Month_Charge_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt, SUM( price ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? AND logType =1 AND price >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Year_Charge_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%m' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m' ) m, COUNT( * ) AS Cnt, SUM( price ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y' ) =  ? AND logType =1 AND price >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }



    public function Month_Coin_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt, SUM( cash ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? AND logType =0 AND cash >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }


    public function Year_Coin_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%m' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m' ) m, COUNT( * ) AS Cnt, SUM( cash ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y' ) =  ? AND logType =0 AND cash >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Month_Free_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%d' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt, SUM( free ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? AND logType =0 AND free >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Year_Free_Load($sdate){
        $sql = "SELECT DATE_FORMAT( regidate,  '%m' ) AS chk, DATE_FORMAT( regidate,  '%Y-%m' ) m, COUNT( * ) AS Cnt, SUM( free ) AS Sell FROM  `tbl_Cash_Log`";
        $sql .= "WHERE DATE_FORMAT( regidate,  '%Y' ) =  ? AND logType =0 AND free >0 GROUP BY m ORDER BY m ASC ";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }


	public function Buy_Log_Load($sdate){
		$sql = "SELECT *";
		$sql .=",(select userid from tbl_member where uid=a.uid) as userid";
		$sql .=",(select wname from tbl_writer where code=a.writer) as wname";
		$sql .= " FROM tbl_Buy_Log a WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? ORDER BY sn ASC";
		$Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }
	
	public function Data_Load($sdate,$stype,$start, $limit, $sidx, $sord){
		$sql = "SELECT *";
		$sql .=",(select userid from tbl_member where uid=a.uid) as userid";
		$sql .=",(select wname from tbl_writer where code=a.writer) as wname";
		$sql .= " FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ";
        if($stype==2){
            $sql .= " and cash > 0 ";
        }else if($stype==3){
            $sql .= " and free > 0 ";
        }
        $sql .= "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
		$Query = $this->db->query($sql,$sdate);
        return $Query;
	}

    public function Member_Cnt(){
        $sql ='SELECT isWhere,count(*) as Cnt FROM `tbl_member` group by isWhere';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function Load_buy_Log($sdate){
        $sql = 'SELECT *,(select cartoon_fee from tbl_cartoon where code=a.pcode) as fee FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0';
        $sql .= " order by sn desc";
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Cnt_Buy_Log($sdate,$typ){
        if($typ==1) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Buy_Log WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ?';
        }else if($typ==2) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0 and LEFT( log, 14 ) =  \'UseAllFreeCoin\'';
        }else if($typ==3) {
            $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ? and logType=0 and free>0 and LEFT( log, 9 ) =  \'SplitCash\'';
        }
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }

    public function Cnt_View_Log($sdate){
        $sql = 'SELECT IFNULL(count(*),0) as Cnt FROM tbl_View_Log WHERE DATE_FORMAT( regidate,  \'%Y-%m\' ) =  ?';
        $Query = $this->db->query($sql,$sdate);
        return $Query->result_array();
    }


    public function Search_Cartoon($sword){
        $this->db->select('*');
        $this->db->from('tbl_cartoon');
        $this->db->like('title',$sword,'both');
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function Data_Load_All($sdate,$stype){
        $sql = "SELECT *";
        $sql .=",(select userid from tbl_member where uid=a.uid) as userid";
        $sql .=",(select wname from tbl_writer where code=a.writer) as wname";
        $sql .= " FROM tbl_Cash_Log a WHERE DATE_FORMAT( regidate,  '%Y-%m' ) =  ? and logType=0 ";
        if($stype==2){
            $sql .= " and cash > 0 ";
        }else if($stype==3){
            $sql .= " and free > 0 ";
        }
        $sql .= "ORDER BY sn desc";
        $Query = $this->db->query($sql,$sdate);
        return $Query;
    }


    public function View_data_Cnt(){
        $sql = 'select *,(select count(*) from tbl_View_data where pcode=a.code) as Total from tbl_cartoon a where code in (167,168,169,170,171,188,196,198,199);';
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }

    public function View_data_Cnt2($pcode,$sdate){
        $sql = "select (select title from tbl_cartoon where code=a.pcode) as title,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%Y-%m-%d' ) m from tbl_View_data a ";
        $sql .= " where a.pcode =? and DATE_FORMAT( a.regidate,  '%Y-%m' ) =  ? group by m,pcode order by m asc;";
        $Query = $this->db->query($sql,array($pcode,$sdate));
        return $Query->result_array();
    }

    public function View_data_Cnt3($pcode,$sdate){
        $sql = "select (select title from tbl_cartoon where code=a.pcode) as title,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%Y-%m-%d' ) m from tbl_View_data a ";
        $sql .= " where a.pcode =? and DATE_FORMAT( a.regidate,  '%Y-%m-%d' ) =  ?; ";
        $Query = $this->db->query($sql,array($pcode,$sdate));
        return $Query->result_array();
    }

    public function View_data_Cnt4($incode,$sdate){
        $sql = "select pcode,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%d' ) m from tbl_View_data a ";
        $sql .= " where a.pcode in (".$incode.") and DATE_FORMAT( a.regidate,  '%Y-%m' ) =  ? group by m,pcode order by m asc;";
        $Query = $this->db->query($sql,array($sdate));
        return $Query->result_array();
    }

    public function View_data_Cnt5($pcode,$sdate){
        $sql = "select pcode,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%d' ) m from tbl_View_data a ";
        $sql .= " where a.pcode =? and DATE_FORMAT( a.regidate,  '%Y-%m' ) =  ? group by m,pcode order by m asc;";
        $Query = $this->db->query($sql,array($pcode,$sdate));
        return $Query->result_array();
    }


    public function View_data_Cnt6($incode,$sdate){
        $sql = "select pcode,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%d' ) m from tbl_goyang_competiton a ";
        $sql .= " where a.pcode in (".$incode.") and DATE_FORMAT( a.regidate,  '%Y-%m' ) =  ? group by m,pcode order by m asc;";
        $Query = $this->db->query($sql,array($sdate));
        return $Query->result_array();
    }

    public function View_data_Cnt7($incode,$sdate){
        $sql = "select pcode,COUNT(*) as Cnt,DATE_FORMAT( a.regidate,  '%d' ) m from tbl_goyang_competiton_Event a ";
        $sql .= " where a.pcode in (".$incode.") and DATE_FORMAT( a.regidate,  '%Y-%m' ) =  ? group by m,pcode order by m asc;";
        $Query = $this->db->query($sql,array($sdate));
        return $Query->result_array();
    }

    public function View_data_Coupon($sdate){
        $sql = "SELECT DATE_FORMAT( opendate,  '%d' ) as chk,DATE_FORMAT( opendate,  '%Y-%m-%d' ) m, COUNT( * ) AS Cnt FROM tbl_coupon ";
        //$sql .= "WHERE sn >= 6001 and sn <=57000 and opendate is not null and DATE_FORMAT( opendate,  '%Y-%m' ) =  ? GROUP BY m ORDER BY m ASC ;";
        $sql .= "WHERE opendate is not null and DATE_FORMAT( opendate,  '%Y-%m' ) =  ? GROUP BY m ORDER BY m ASC ;";
        $Query = $this->db->query($sql,array($sdate));
        return $Query->result_array();
    }


    public function Analytics1($pcode,$date){
        $sql = "select ccode,count(*) as Cnt1,count(distinct(uid)) as Cnt2  from tbl_View_data where pcode=? and DATE_FORMAT(regidate,'%Y-%m')=? group by ccode order by 1 asc limit 10000;";
        $Query = $this->db->query($sql,array($pcode,$date));
        return $Query->result_array();
    }

    public function Analytics2($pcode,$scode,$date){
        $sql = "select *  from tbl_Cash_Log where pcode=? and scode=? and DATE_FORMAT(regidate,'%Y-%m')=? order by sn asc;";
        $Query = $this->db->query($sql,array($pcode,$scode,$date));
        return $Query->result_array();
    }









}