<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'banner_View');
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }

    public function Data_Load()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'banner_m');
        $count = $this->banner_m->all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->banner_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn, $row->imgname, $row->Described, $row->Described2, $row->Described3, $row->Described4, $row->Described5,$row->font_color, $row->mtype, $row->URL, $row->bgcolor, $row->isNum, $row->isLink, $row->isOpen, $row->isFix, $row->imgname, $row->regidate
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
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            if ($insert_id = $this->banner_m->Data_Add($post)) {
                $result = true;
                $code = $insert_id;
                $message = 'Success';
            } else {
                $result = true;
                $code = '';
                $message = 'Not Change';
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
            $retVal = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            if ($insert_id = $this->banner_m->Data_Update($post)) {
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
            'message' => $message
        ));
    }

    public function Data_Del()
    {

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            $affected_rows = $this->banner_m->Data_Del($post['id']);

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

    public function Advert()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'ad_banner_View');
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }


    public function AdData_Load()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'banner_m');
        $count = $this->banner_m->ad_all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->banner_m->AdData_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn, $row->fname, $row->fname, $row->title, $row->location, $row->Link, $row->bg_img, $row->bg_img, $row->isUse, $row->regidate
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


    public function AdData_Add()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            if ($insert_id = $this->banner_m->AdData_Add($post)) {
                $result = true;
                $code = $insert_id;
                $message = 'Success';
            } else {
                $result = true;
                $code = '';
                $message = 'Not Change';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $code,
            'message' => $message
        ));
    }

    public function AdData_Update()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retVal = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            if ($insert_id = $this->banner_m->AdData_Update($post)) {
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
            'message' => $message
        ));
    }


    public function AdData_Del()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            $affected_rows = $this->banner_m->AdData_Del($post['id']);

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