<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Answer_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('shop', true);
    }

    public function all_count()
    {
        $this->db->from('tbl_shop_question');
        $Cnt = $this->db->count_all_results();
        return $Cnt;
    }

    public function Data_Load($start, $limit, $sidx, $sord, $searchString, $searchField, $searchOper)
    {
        if ($searchString != '') {
            if ($searchOper == 'eq') {
                $sql = "SELECT a.*,b.pName FROM tbl_shop_question a,tbl_shop_product b where a.pCode=b.pCode and " . $searchField . "=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql, $searchString);
            } else if ($searchOper == 'cn') {
                $term = '%' . $searchString . "%";
                $sql = "SELECT a.*,b.pName FROM tbl_shop_question a,tbl_shop_product b where a.pCode=b.pCode and " . $searchField . " LIKE ? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
                $query = $this->db->query($sql, $term);
            }
        } else {
            $sql = "SELECT a.*,b.pName FROM tbl_shop_question a,tbl_shop_product b where a.pCode=b.pCode ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql);
        }
        return $query;
    }

    public function Del_Reply($sn)
    {

        $this->db->trans_start();
        $this->db->where('sn',$sn);
        $this->db->delete('tbl_shop_question_reply');
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_question_reply delete]');
            $this->db->trans_rollback();
        }
        return $affected_rows;
    }

    public function Load_Reply($sn)
    {
        $sql = "SELECT * FROM tbl_shop_question_reply where qsn=? order by sn asc";
        $Query = $this->db->query($sql, $sn);
        return $Query->result_array();
    }

    public function Insert_Reply($param)
    {
        $data = array(
            'qsn' => $param['qsn'],
            'comment' => $param['comment']
        );

        $this->db->trans_start();
        $this->db->insert('tbl_shop_question_reply', $data);
        $insert_id = $this->db->insert_id();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_question_reply Update]');
            $this->db->trans_rollback();
        }

        return $insert_id;
    }

    public function Update_Answer($sn)
    {
        $this->db->trans_start();
        $this->db->set('reply', 'reply+1', FALSE);
        $this->db->where('sn', $sn);
        $this->db->update('tbl_shop_question');
        $affected_rows = $this->db->affected_rows();

        $result = $this->db->trans_complete();
        if($result === true){
            $this->db->trans_commit();
        }else{
            throw new exception('transaction > [tbl_shop_question Update]');
            $this->db->trans_rollback();
        }
        return $affected_rows;
    }


}