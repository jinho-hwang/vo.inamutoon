<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();

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

        $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
        $this->load->view(SHOP_VIEW_ROOT.'question_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
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
        
        $this->load->model(SHOP_MODEL_ROOT.'/Answer_m');
        $count = $this->Answer_m->all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Answer_m->Data_Load($start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->uid, $row->userid, $row->pCode,$row->pName,$row->typ,$row->comment,$row->reply, $row->regidate,$row->sn
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
            $this->load->model(SHOP_MODEL_ROOT . 'Answer_m');
            $affected_rows = $this->Answer_m->Data_Del($post['id']);

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
        $sn = $this->uri->segment(4);
        if ($sn == '') {
            alert_close('잘못된 접근입니다.');
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'Answer_m');
            $Rs = $this->Answer_m->Load_Reply($sn);

            $data = array(
                'sn' => $sn,
                'list' => $Rs
            );

            $this->load->view(SHOP_VIEW_ROOT . 'reply_View.php', $data);
        }
    }
    
    public function Reply_do(){

        $sn = $this->input->post('qsn');
        $commment = $this->input->post('content');

        if ($sn == '' || $commment == '') {
            alert('잘못된 접근입니다.');
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'Answer_m');

            $data = array(
                'qsn' => $sn,
                'comment' => nl2br($commment)
            );

            $id = $this->Answer_m->Insert_Reply($data);
            if ($id > 0) {
                $Cnt = $this->Answer_m->Update_Answer($sn);
                alert_refresh_close('success!');
            } else {
                alert('Failed');
            }
        }
    }

    public function Reply_del(){
        $sn = $this->uri->segment(4);
        if ($sn == '') {
            alert_close('잘못된 접근입니다.');
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'Answer_m');
            $Cnt = $this->Answer_m->Del_Reply($sn);

            alert_refresh_close('success!');
        }
    }
}