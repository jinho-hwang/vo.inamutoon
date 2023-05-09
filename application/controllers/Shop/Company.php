<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index()
    {
        $tstr=$this->input->post('tstr');
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid),
            'tstr' =>$tstr
        );

        $select_box = "'':'선택',";
        $this->load->model(SHOP_MODEL_ROOT.'company_m');
        $Rs = $this->company_m->Load_Info_Delivery();
        if(ArrayCount($Rs)>0){
            foreach ($Rs as $row) {
                $select_box .= "'" . $row['dCode'] . "':'" . $row['dTitle'] . "',";
            }
        }

        $data = array(
            'delivery' => $select_box
        );


        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(SHOP_VIEW_ROOT.'company_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }


    public function Data_Load(){

        $tstr=$this->input->post('tstr');
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';


        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(SHOP_MODEL_ROOT.'company_m');
        $count = $this->company_m->all_count($tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->company_m->Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->cCode;
                $response->rows[$i]['cell'] = array(
                    $row->cCode,$row->cTitle,$row->cName,$row->cTel,$row->cAddress,$row->delivery_com,$row->isUse,$row->regidate
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

    public function Data_Add()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'company_m');
            if ($insert_id = $this->company_m->Data_Add($post)) {
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

    public function Data_Update()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'company_m');
            $insert_id = $this->company_m->Data_Update($post);
            //if ($insert_id = $this->Board_m->Data_Update($post)) {
            $result = true;
            $code = $post['id'];
            $message = 'Success';
            /*
            } else {
                $result = false;
                $code = '';
                $message = 'Fail!!';
            }
            */
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $code,
            'message' => $message
        ));
    }

    public function Data_Delete()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . 'company_m');
            $affected_rows = $this->company_m->Data_Del($post['id']);

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


    public function delivery(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        if(!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
            $data = array();
        }else{
            $data = array();

            $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'delivery_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');


        }


    }

    public function Delivery_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(SHOP_MODEL_ROOT.'/Company_m');
        $count = $this->Company_m->delivery_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Company_m->delivery_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->dCode;
                $response->rows[$i]['cell'] = array(
                    $row->dCode,$row->dTitle,$row->dTel,$row->dPrice,$row->delivery_url,$row->regidate
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


    public function Delivery_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Company_m');
            if ($insert_id = $this->Company_m->Delivery_Add($post)) {
                $result = true;
                $retval = $insert_id;
                $message = 'Success';
            } else {
                $result = false;
                $retval = '';
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $retval,
            'message' => $message
        ));
    }

    public function Delivery_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Company_m');
            if ($insert_id = $this->Company_m->Delivery_Update($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = true;
                $message = 'Not change';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $post['id'],
            'message' => $message
        ));
    }


    public function Delivery_Del()
    {

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Company_m');
            $affected_rows = $this->Company_m->Delivery_Del($post['id']);

            if ($affected_rows > 0) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }
        echo json_encode(array(
            'result' => $result,
            'code' => $post['id'],
            'message' => $message
        ));
    }
}