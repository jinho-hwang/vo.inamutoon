<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index()
    {
        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            $this->load->view(CMS_VIEW_ROOT . 'Login_View');
        } else {
            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this,$uid)
            );

            $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'notice_View');
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
        }

    }

    public function Data_Load()
    {
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'Notice_m');
        $count = $this->Notice_m->all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Notice_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn, $row->title,$row->content,$row->isOpen, $row->regidate
                );
                $i++;
            }
        }


        $response = (is_object($response)) ? $response : (object)array();
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
            $this->load->model(CMS_MODEL_ROOT . 'Notice_m');
            if ($insert_id = $this->Notice_m->Data_Add($post)) {
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
            $this->load->model(CMS_MODEL_ROOT . 'Notice_m');
            $insert_id = $this->Notice_m->Data_Update($post);
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
            $this->load->model(CMS_MODEL_ROOT . 'Notice_m');
            $affected_rows = $this->Notice_m->Data_Del($post['id']);

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