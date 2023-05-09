<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Re_Cartoon extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('basic','security','url','string'));
        $this->load->library('session','image_lib');
        TMSLogin($this);
    }

    public function index()
    {
        $tstr=$this->input->post('tstr');
        $this->load->model('common_m');
        $p_Caregory = $this->common_m->cartoon_selectbox_All();

        $data = array(
            'p_Caregory' => $p_Caregory,
            'tstr' => $tstr
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'re_cartoon_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include//footer_View');
    }

    public function Reg_pop()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'re_cartoon_reg_View');
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }

    public function Reg_pop2(){
        $tstr=$this->input->post('tstr');
        $this->load->model(CMS_VIEW_ROOT.'Cartoon_m');
        $data = $this->Cartoon_m->Load_Cartoon_like($tstr);

        $data = array(
            'data' => $data,
            'tstr' => $tstr
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'re_cartoon_reg2_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }

    public function Reg_proc(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        $this->load->model(CMS_VIEW_ROOT . 're_cartoon_m');
        $insert_id = $this->re_cartoon_m->Data_Add($post);

       alert_parent_move_close('success',ROOT_URL.'Re_Cartoon');
    }

    public function View()
    {
        $this->load->model('common_m');
        $p_Caregory = $this->common_m->cartoon_selectbox_All();


        $data = array(
            'p_Caregory' => $p_Caregory
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'re_cartoon_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }

    public function Data_Load(){

        $tstr=$this->input->post('tstr');
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

        $this->load->model(CMS_VIEW_ROOT.'re_cartoon_m');
        $count = $this->re_cartoon_m->all_count($tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->re_cartoon_m->Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                  $row->pcode,$row->scode,$row->isReserve,$row->opendate,$row->regidate
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
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_VIEW_ROOT . 're_cartoon_m');
            if ($insert_id = $this->re_cartoon_m->Data_Add($post)) {
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

    public function Data_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retVal = '';
            $filename = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_VIEW_ROOT . 're_cartoon_m');
            if ($insert_id = $this->re_cartoon_m->Data_Update($post)) {
                $result = true;
                $retVal = $post['id'];
                $message = 'Success';
            } else {
                $result = true;
                $retVal = $post['id'];
                $message = 'Not change';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $retVal,
            'filename' =>$filename,
            'message' => $message
        ));
    }

    public function Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_VIEW_ROOT . 're_cartoon_m');
            $affected_rows = $this->re_cartoon_m->Data_Del($post['id']);

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
