<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic','security','url'));
        $this->load->library('session');
        TMSLogin($this);
    }

    public function QuizList(){

        $pcode = $this->uri->segment(3);
        if(empty($pcode)){
            alert("카툰을 선택하세요.",ROOT_URL.'Cartoon/');
        }else {

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.",ROOT_URL.'Cartoon/');
            }else {
                $data = array(
                    'pcode' => $pcode,
                    'c_name' => $Rs[0]['title']
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
                $this->load->view(CMS_VIEW_ROOT.'quiz_View.php',$data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
            }
        }
    }


    public function Data_Load(){

        $pcode = $this->uri->segment(3);

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'quiz_m');
        $count = $this->quiz_m->all_count($pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->quiz_m->Data_Load($pcode,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->qnum;
                $response->rows[$i]['cell'] = array(
                    $row->qnum,$row->scode,$row->aType,$row->isOpen,$row->quiz,$row->qnum
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

    public function Data_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {

            $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

            $this->load->model(CMS_MODEL_ROOT . 'quiz_m');
            if ($insert_id = $this->quiz_m->Data_Add($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => '',
            'message' => $message
        ));
    }

    public function Data_Update(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
            $this->load->model(CMS_MODEL_ROOT . 'quiz_m');
            if ($insert_id = $this->quiz_m->Data_Update($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $post['code'],
            'message' => $message
        ));
    }

    public function Data_Delete(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retVal = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'quiz_m');
            $affected_rows = $this->quiz_m->Data_Del($post['id']);

            if ($affected_rows > 0) {
                $result = true;
                $retVal = $post['id'];
                $message = 'Success';
            } else {
                $result = false;
                $retVal = '';
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'sn' => $retVal,
            'message' => $message
        ));
    }

    public function Answer(){
        $qnum = $this->uri->segment(3);

        if(empty($qnum)){
            alert_close('잘못된 접근입니다.');
        }else{
            $this->load->model(CMS_MODEL_ROOT . 'quiz_m');
            $Rs = $this->quiz_m->Load_Answer($qnum);
            if(ArrayCount($Rs)<=0){
                $answer = array(
                    'isCorret' => '',
                    'a1' => '',
                    'a2' => '',
                    'a3' => '',
                    'a4' => '',
                );
            }else {
                $answer = array(
                    'isCorret' => $Rs[0]['isCorrect'],
                    'a1' => $Rs[0]['answer1'],
                    'a2' => $Rs[0]['answer2'],
                    'a3' => $Rs[0]['answer3'],
                    'a4' => $Rs[0]['answer4'],
                );
            }

            $Rs = $this->quiz_m->Load_Quiz($qnum);
            if(ArrayCount($Rs)<=0){
                alert_close('잘못된 접근입니다.error102');
            }else {
                $data = array(
                    'qnum' => $qnum,
                    'aType' => $Rs[0]['aType'],
                    'quiz' => $Rs[0]['quiz'],
                    'explan' => $Rs[0]['explan'],
                    'answer' => $answer
                );
            }


            $this->load->view(CMS_VIEW_ROOT . 'quiz_a_View', $data);
        }

    }

    public function Answer_do(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert_close('잘못된 접근입니다.');
        }else{
            $this->load->model(CMS_MODEL_ROOT . 'quiz_m');
            $Cnt = $this->quiz_m->Del_Quiz_Answer($post['qnum']);

            $Cnt = $this->quiz_m->insert_Quiz_Answer($post);
            $Cnt = $this->quiz_m->Update_Quiz_Explan($post);
            if($Cnt > 0){
                alert_close('success');
            }else{
                alert_close('DB_Error');
            }
        }

    }



}