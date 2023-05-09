<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }
    
    public function index()
    {
        $typ=$this->input->post('typ');
        $tstr=$this->input->post('tstr');
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $typ == '' ? $typ='' : $typ=$this->input->post('typ');
        $tstr == '' ? $tstr='' : $tstr=$this->input->post('tstr');

        $this->load->model(CMS_MODEL_ROOT.'member_m');
        $Rs = $this->member_m->Group_Auth_Cnt();


        $data = array(
            'typ' =>$typ,
            'tstr' =>$tstr,
            'auth' =>$Rs
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'member_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }
    
    public function Data_Load(){

        $typ = ($this->input->post('typ')) ? $this->input->post('typ') : 0;
        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';

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
        
        $this->load->model(CMS_MODEL_ROOT.'member_m');
        $count = $this->member_m->all_count($typ,$tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->member_m->Data_Load($typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->uid;
                $response->rows[$i]['cell'] = array(
                    $row->uid,$row->pic, $row->userid, $row->uname,$row->superID, $row->cash, $row->auth, $row->secret, $row->isCert, $row->regidate
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
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'member_m');
            if ($insert_id = $this->member_m->Data_Add($post)) {
                $result = true;
                $code = $insert_id;
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
    
    public function Data_Update(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'member_m');
            if ($insert_id = $this->member_m->Data_Update($post)) {
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
            'uid' => $code,
            'message' => $message
        ));
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
            $this->load->model(CMS_MODEL_ROOT . 'member_m');
            $affected_rows = $this->member_m->Data_Del($post['id']);

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

    
}