<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count(){
        $sql = 'SELECT sn FROM tbl_Notice';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return false;
        }
    }


    public function Data_Load($start, $limit, $sidx, $sord){
        $sql = "SELECT * FROM tbl_Notice a ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query;
    }

    function Data_Add($param){
        $data = array(
            'title' => $param['title'],
            'content' => nl2br($param['content']),
            'isOpen' => $param['isOpen'],
            'isFAQ' => 1
        );

        $this->db->trans_start();
        $this->db->insert('tbl_Notice',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Notice Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $id =  $param['id'];
        $data = array(
            'title' => $param['title'],
            'content' => nl2br($param['content']),
            'isOpen' => $param['isOpen']
        );


        $this->db->trans_start();
        $this->db->where('sn',$id);
        $this->db->update('tbl_Notice',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Notice Update]');
        }
        return $affected_rows;

    }

    function Data_Del($id){
        $data = array(
            'sn' => $id
        );
        $this->db->trans_start();
        $this->db->delete('tbl_Notice',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [Notice Delete]');
        }
        return $affected_rows;
    }

}