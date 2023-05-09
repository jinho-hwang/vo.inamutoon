<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartoon_tendency_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all_count($tstr)
    {
        if(empty($tstr)) {
            $sql = 'SELECT sn FROM tbl_Cartoon_Tendency';
        }else{
            $sql = "SELECT sn FROM tbl_Cartoon_Tendency a,tbl_cartoon b where a.pcode=b.code and b.title like '%".$tstr."%'";
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
                $sql = "SELECT * FROM tbl_Cartoon_Tendency where ".$searchField."=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql,$searchString);
            }
        }else{
            if(empty($tstr)) {
                $sql = "SELECT *,b.title FROM tbl_Cartoon_Tendency a,tbl_cartoon b where a.pcode=b.code ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }else{
                $sql = "SELECT *,b.title, FROM tbl_Cartoon_Tendency a,tbl_cartoon b where a.pcode=b.code and b.title like '%".$tstr."%' ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            }
            $query = $this->db->query($sql);
        }
        return $query;
    }

    function Data_Add($param){
        $data = array(
            'pcode' => $param['pcode'],
            'TField1' => $param['TField1'],
            'TField2' => $param['TField2'],
            'TField3' => $param['TField3'],
            'TField4' => $param['TField4'],
            'TField5' => $param['TField5'],
            'TField6' => $param['TField6'],
            'TField7' => $param['TField7']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_Cartoon_Tendency',$data);
        $insert_id = $this->db->insert_id();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_Tendency Insert]');
        }

        return $insert_id;
    }

    function Data_Update($param){
        $code =  $param['id'];
        $data = array(
            'TField1' => $param['TField1'],
            'TField2' => $param['TField2'],
            'TField3' => $param['TField3'],
            'TField4' => $param['TField4'],
            'TField5' => $param['TField5'],
            'TField6' => $param['TField6'],
            'TField7' => $param['TField7']
        );

        $this->db->trans_start();
        $this->db->where('pcode',$code);
        $this->db->update('tbl_Cartoon_Tendency',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_Tendency Update]');
        }
        return $affected_rows;

    }

    function Data_Del($code){
        $data = array(
            'pcode' => $code
        );
        $this->db->trans_start();
        $this->db->delete('tbl_Cartoon_Tendency',$data);
        $affected_rows = $this->db->affected_rows();

        if ( ! $this->db->trans_complete()) {
            throw new exception('transaction > [tbl_Cartoon_Tendency Delete]');
        }
        return $affected_rows;
    }




}