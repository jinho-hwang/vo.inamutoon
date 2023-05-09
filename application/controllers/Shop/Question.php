<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic','security','url'));
        $this->load->library('session');
        TMSLogin($this);
    }

    public function index()
    {
        $grade = '';
        for($i=1;$i<=10;$i++){
            $grade .= "'" . $i . "':'" . $i . "등급',";
        }

        $data = array(
            'grade' => $grade
        );


        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_FOLDER.'/include/header_View.php',$hearder_Data);
        $this->load->view(CMS_FOLDER.'/order_question_View.php',$data);
        $this->load->view(CMS_FOLDER.'/include/footer_View.php');
    }

    public function Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_FOLDER.'/Question_m');
        $count = $this->Question_m->all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Question_m->Data_Load($start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->Bnum;
                $userid = 'test';
                $response->rows[$i]['cell'] = array(
                    $row->uid, $userid, $row->typ,$row->filename,$row->isAnswer,$row->title,$row->content, $row->regidate,$row->Bnum
                );
                $i++;
            }
        }


        $response = (is_object($response)) ? $response : (object) array();
        $response->page = $page;
        $response->total = $total_pages;
        $response->records = $count;

        echo json_encode($response);

    }

    public function Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_FOLDER . 'Question_m');
            $affected_rows = $this->Question_m->Data_Del($post['id']);

            if ($affected_rows > 0) {
                $result = true;
                $code = $post['id'];
                $message = 'Success';
            } else {
                $result = false;
                $code = '';
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $code,
            'message' => $message
        ));
    }

    public function Reply(){
        $Bnum = $this->uri->segment(4);
        if ($Bnum == '') {
            alert_close('잘못된 접근입니다.');
        } else {
            $this->load->model(CMS_FOLDER . 'Question_m');
            $Rs = $this->Question_m->Load_Reply($Bnum);

            $data = array(
                'Bnum' => $Bnum,
                'list' => $Rs
            );

            $this->load->view(CMS_FOLDER . 'reply_View.php', $data);
        }
    }

    public function Reply_do(){

        $Bnum = $this->input->post('Bnum');
        $content = $this->input->post('content');

        if ($Bnum == '' || $content == '') {
            alert('잘못된 접근입니다.');
        } else {
            $this->load->model(CMS_FOLDER . 'Question_m');

            $data = array(
                'Bnum' => $Bnum,
                'content' => nl2br($content)
            );

            $id = $this->Question_m->Insert_Reply($data);
            if ($id > 0) {
                $Cnt = $this->Question_m->Update_Answer($Bnum);
                alert('success!!', TMS_ROOT . '/Answer/Reply/' . $Bnum);
            } else {
                alert('Failed');
            }
        }
    }
}