<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function Cartoon_List()	{
        $sql = "SELECT  * FROM tbl_cartoon order by code desc";
        $Query = $this->db->query($sql);
        return $Query->result_array();
    }


    public function all_count($pcode){
        $sql = 'SELECT qnum FROM tbl_quiz where pcode=?';
        $query = $this->db->query($sql,$pcode);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function Data_Load($pcode,$start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_quiz where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql,$pcode);
        return $query;
    }


    function Data_Add($param){
        $data = array(
            'qnum' => $param['qnum'],
            'pcode' => $param['pcode'],
            'scode' => $param['scode'],
            'quiz' => $param['quiz'],
            'aType' => $param['aType'],
            'explan' => $param['explan']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_quiz',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $qnum =  $param['id'];
        $data = array(
            'pcode' => $param['pcode'],
            'scode' => $param['scode'],
            'quiz' => $param['quiz'],
            'aType' => $param['aType'],
            'isOpen' => $param['isOpen']
        );

        $this->db->trans_start();
        $this->db->where('qnum',$qnum);
        $this->db->update('tbl_quiz',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz Update]');
        }
        return $affected_rows;

    }

    function Data_Del($sn){
        $data = array(
            'qnum' => $sn
        );
        $this->db->trans_start();
        $this->db->delete('tbl_quiz',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz Delete]');
        }
        return $affected_rows;
    }

    function Load_Answer($qnum){
        $sql = 'SELECT  * FROM tbl_quiz_answer where qnum=?';
        $Query = $this->db->query($sql,$qnum);
        return $Query->result_array();

    }

    function Load_Quiz($qnum){
        $sql = 'SELECT  * FROM tbl_quiz where qnum=?';
        $Query = $this->db->query($sql,$qnum);
        return $Query->result_array();

    }


    function insert_Quiz_Answer($param){
        if($param['aType']==0) {
            $data = array(
                'qnum' => $param['qnum'],
                'isCorrect' => $param['isCorrect'],
                'answer1' => $param['answer1'],
                'answer2' => $param['answer2'],
                'answer3' => $param['answer3'],
                'answer4' => $param['answer4']
            );
        }else{
            $data = array(
                'qnum' => $param['qnum'],
                'isCorrect' => $param['isCorrect'],
                'answer1' => $param['answer1'],
                'answer2' => $param['answer2'],
                'answer3' => '',
                'answer4' => ''
            );
        }

        $this->db->trans_start();
        $this->db->insert('tbl_quiz_answer',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz_answer Insert]');
        }

        return $insert_id;
    }

    function Del_Quiz_Answer($qnum){
        $data = array(
            'qnum' => $qnum
        );
        $this->db->trans_start();
        $this->db->delete('tbl_quiz_answer',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz_answer Delete]');
        }
        return $affected_rows;
    }

    public function Update_Quiz_Explan($param){
        $qnum =  $param['qnum'];
        $data = array(
            'explan' => $param['explan']
        );

        $this->db->trans_start();
        $this->db->where('qnum',$qnum);
        $this->db->update('tbl_quiz',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_quiz Update]');
        }
        return $affected_rows;
    }

}