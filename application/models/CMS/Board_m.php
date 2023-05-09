<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count(){
        $sql = 'SELECT bid FROM tbl_board_env';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_board_env a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    function Data_Add($param){
        $data = array(
            'bname' => $param['bname'],
            'bType' => $param['bType'],
            'w_grade' => $param['w_grade'],
            'r_grade' => $param['r_grade'],
            'p_cnt' => $param['p_cnt'],
            'v_cnt' => $param['v_cnt']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_board_env',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board_Env Insert]');
        }

        return $insert_id;
    }

	function Data_Update($param){
        $id =  $param['id'];
        $data = array(
            'bname' => $param['bname'],
            'bType' => $param['bType'],
            'w_grade' => $param['w_grade'],
            'r_grade' => $param['r_grade'],
            'p_cnt' => $param['p_cnt'],
            'v_cnt' => $param['v_cnt']
        );
        
        
        $this->db->trans_start();
        $this->db->where('bid',$id);
        $this->db->update('tbl_board_env',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board_Env Update]');
        }
        return $affected_rows;
        
    }
   
   function Data_Del($id){
          $data = array(
                'bid' => $id
          );
        $this->db->trans_start();
        $this->db->delete('tbl_board_env',$data);
        $affected_rows = $this->db->affected_rows();
        
        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board_Env Delete]');
        }
        return $affected_rows;
    }

    function Load_Board_bid($code){
        $sql = "SELECT * FROM tbl_board where bid=?";
        $query = $this->db->query($sql,$code);
        return $query->result_array();
    }

    function Load_Board_Env($code){
        $sql = "SELECT * FROM tbl_board_env where bid=?";
        $query = $this->db->query($sql,$code);
        return $query->result_array();
    }

    function Data_Reg($param){
        if($param['bid']!=4) {
            $data = array(
                'bid' => $param['bid'],
                'bTitle' => $param['bTitle'],
                'bContent' => $param['bContent'],
                'main_thumb' => $param['main_thumb'],
                'thumb' => $param['thumb'],
                'writer' => $param['writer']
            );
        }else{
            $data = array(
                'bid' => $param['bid'],
                'bTitle' => $param['bTitle'],
                'bContent' => $param['bContent'],
                'writer' => $param['writer']
            );
        }

        $this->db->trans_start();
        $this->db->insert('tbl_board',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board Insert]');
        }

        return $insert_id;
    }

    function Data_Mod($param){
        $bid = $param['bid'];
        $code =  $param['bcode'];
        if($bid!=4) {
            $data = array(
                'bTitle' => $param['title'],
                'bContent' => $param['description'],
                'main_thumb' => $param['main_thumb'],
                'thumb' => $param['thumb'],
                'writer' => $param['writer']
            );
        }else{
            $data = array(
                'bTitle' => $param['title'],
                'bContent' => $param['description'],
                'writer' => $param['writer']
            );
        }

        $this->db->trans_start();
        $this->db->where('bcode',$code);
        $this->db->update('tbl_board',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board Update]');
        }
        return $affected_rows;
    }


    function Data_View($code){
        $sql = "SELECT * FROM tbl_board where bcode=?";
        $query = $this->db->query($sql,$code);
        return $query->result_array();
    }

    function Data_View1 ($code)
    {
        $sql = "select *, (select main_thumb from tbl_cartoon_info where sn=a.cid) as C_main_thumb,"."
                (select sub_thumb from tbl_cartoon_info where sn=a.cid) as C_sub_thumb,"."
                (select thumb from tbl_cartoon_info where sn=a.cid) as C_thumb"."
                from tbl_board a where bcode=?";

        $query = $this->db->query($sql, $code);
        return $query->result_array();
    }

    function Data_Total_Cnt($bid){
        $sql = "SELECT count(*) as Cnt FROM tbl_board where bid=?";
        $query = $this->db->query($sql,$bid);
        return $query->result_array();
    }

    function Data_Board($bid,$start,$readNum){
        $sql = 'SELECT * FROM tbl_board a where a.bid=? order by a.bcode desc limit ?,?';
        $query = $this->db->query($sql,array($bid,$start,$readNum));
        return $query->result_array();
    }

    function Data_Board_Del($bcode){
        $data = array(
            'bcode' => $bcode
        );
        $this->db->trans_start();
        $this->db->delete('tbl_board',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board_Del Delete]');
        }
        return $affected_rows;
    }

    function getLastData ($bid, $count )
    {
        $sql = "SELECT * FROM tbl_board WHERE bid =".$bid." AND isAgree = 1 ORDER BY regidate DESC  LIMIT 0 , ".$count;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getHomeData ($start, $count)
    {
        $sql = "select *, (select title from tbl_cartoon_info where sn=a.cid) as C_title,"."
                (select main_thumb from tbl_cartoon_info where sn=a.cid) as C_main_thumb,"."
                (select sub_thumb from tbl_cartoon_info where sn=a.cid) as C_sub_thumb,"."
                (select regidate from tbl_cartoon_info where sn=a.cid) as C_regdate,"."
                (select thumb from tbl_cartoon_info where sn=a.cid) as C_thumb"."
                from tbl_board a  WHERE a.isAgree = 1 order by bcode desc"."
                Limit ".$start.",".$count;

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getHomeData_count(){

        $sql = "select *, (select title from tbl_cartoon_info where sn=a.cid) as C_title,"."
                (select main_thumb from tbl_cartoon_info where sn=a.cid) as C_main_thumb,"."
                (select sub_thumb from tbl_cartoon_info where sn=a.cid) as C_sub_thumb,"."
                (select thumb from tbl_cartoon_info where sn=a.cid) as C_thumb"."
                from tbl_board a  WHERE a.isAgree = 1 order by bcode desc";

        $query = $this->db->query($sql);
        
        if (!empty($query)) {

            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function getMainScrollData ()
    {
        $sql = "SELECT *
                FROM  `tbl_board`
                WHERE (bid =2  OR bid =3) AND isAgree =1
                ORDER BY bCode DESC
                LIMIT 0 , 4";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function Update_Agree($param){
        $code =  $param['bcode'];
        $data = array(
            'isAgree' => $param['type']
        );

        $this->db->trans_start();
        $this->db->where('bcode',$code);
        $this->db->update('tbl_board',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board Update]');
        }
        return $affected_rows;
    }

    function Update_Fix($param){
        $code =  $param['bcode'];
        $data = array(
            'isFix' => $param['type']
        );

        $this->db->trans_start();
        $this->db->where('bcode',$code);
        $this->db->update('tbl_board',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Board Update]');
        }
        return $affected_rows;
    }

}