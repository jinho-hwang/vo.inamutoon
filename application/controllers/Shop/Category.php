<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic', 'security', 'url'));
        $this->load->library('session');
        TMSLogin($this);
    }

    public function AGroup()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        if (!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        } else {
            $data = array();

            $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'acategory_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

          }
    }

    public function BGroup()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        if (!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        } else {

            $select_box = "'':'선택',";

            $this->load->model(SHOP_MODEL_ROOT.'/Category_m');
            $Rs = $this->Category_m->Load_ACategory_All();
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $row) {
                    $select_box .= "'" . $row['aCode'] . "':'" . $row['cName'] . "',";
                }
            }

            $data = array(
                'select_box' => $select_box
            );

            $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'bcategory_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
        }
    }

    public function CGroup()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        if (!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        } else {

            $select_box = "<option>선택하세요</option>";
            $select_box1 = "'':'선택',";
            $select_box2 = "'':'선택',";

            $this->load->model(SHOP_MODEL_ROOT.'/Category_m');
            $Rs = $this->Category_m->Load_ACategory_All();
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $row) {
                    $select_box .= "<option value='".$row['aCode']."'>".$row['cName']."</option>";
                    $select_box1 .= "'" . $row['aCode'] . "':'" . $row['cName'] . "',";
                }
            }
            $Rs = $this->Category_m->Load_BCategory_All();
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $row) {
                    $select_box2 .= "'" . $row['bCode'] . "':'" . $row['cName'] . "',";
                }
            }


            $data = array(
                'select_box' => $select_box,
                'select_box1' => $select_box1,
                'select_box2' => $select_box2
            );


            $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'ccategory_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

        }
    }

    public function AData_Load()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
        $count = $this->Category_m->ACaregory_all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Category_m->AData_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->aCode;
                $response->rows[$i]['cell'] = array(
                    $row->aCode, $row->cName, $row->isUse, $row->regidate
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

    public function AData_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->AData_Add($post)) {
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

    public function AData_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->AData_Update($post)) {
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

    public function AData_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            $affected_rows = $this->Category_m->AData_Del($post['id']);

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

    public function BData_Load()
{

    $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
    $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
    $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
    $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

    $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
    if ($totalrows) {
        $limit = $totalrows;
    }

    $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
    $count = $this->Category_m->BCaregory_all_count();

    $total_pages = ($count) ? ceil($count / $limit) : 0;
    $start = $limit * $page - $limit;

    $query = $this->Category_m->BData_Load($start, $limit, $sidx, $sord);
    if (!empty($query)) {
        $response = (object)array();
        $i = 0;

        foreach ($query->result() as $row) {
            $response->rows[$i]['id'] = $row->bCode;
            $response->rows[$i]['cell'] = array(
                $row->bCode,$row->aCode, $row->cName, $row->isUse, $row->regidate
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

    public function BData_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->BData_Add($post)) {
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

    public function BData_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->BData_Update($post)) {
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

    public function BData_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            $affected_rows = $this->Category_m->BData_Del($post['id']);

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


    public function CData_Load()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
        $count = $this->Category_m->CCaregory_all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Category_m->CData_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->cCode;
                $response->rows[$i]['cell'] = array(
                    $row->cCode,$row->aCode,$row->bCode,$row->cName, $row->isUse,$row->regidate
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

    public function CData_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        var_dump($post);


        if (empty($post)) {
            alert_close('필수 항목이 누락 되었습니다.');
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->CData_Add($post)) {
                alert_refresh_close('등록하였습니다.');
            } else {
                alert_close('등록 실패');
            }
        }
    }

    public function CData_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            if ($insert_id = $this->Category_m->CData_Update($post)) {
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

    public function CData_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
            $affected_rows = $this->Category_m->CData_Del($post['id']);

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

    public function GetCategory(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        $retArr = array();
        if(empty($post)){
            $temparr['Code'] ='';
            $temparr['Name'] ='';

            array_push($retArr,$temparr);
        }else{
            $this->load->model(SHOP_MODEL_ROOT . '/Category_m');

            if($post['type']==1) {
                $Rs = $this->Category_m->Load_BCategory_Code($post['code']);
                if (ArrayCount($Rs) > 0) {
                    foreach ($Rs as $d) {
                        $temparr['Code'] = $d['bCode'];
                        $temparr['Name'] = $d['cName'];

                        array_push($retArr, $temparr);
                    }
                } else {
                    $temparr['Code'] = '';
                    $temparr['Name'] = '';
                    array_push($retArr, $temparr);
                }
            }else{
                $Rs = $this->Category_m->Load_CCategory_Code($post['code']);
                if (ArrayCount($Rs) > 0) {
                    foreach ($Rs as $d) {
                        $temparr['Code'] = $d['cCode'];
                        $temparr['Name'] = $d['cName'];

                        array_push($retArr, $temparr);
                    }
                } else {
                    $temparr['Code'] = '';
                    $temparr['Name'] = '';
                    array_push($retArr, $temparr);
                }
            }

        }

        echo json_encode($retArr);
    }

    public function CGroup_Reg(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        if (!$sessionArr['islogin']) {
            alert_close('로그인을 하세요.');
        } else {

            $select_box = "<option>선택하세요</option>";

            $this->load->model(SHOP_MODEL_ROOT.'/Category_m');
            $Rs = $this->Category_m->Load_ACategory_All();
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $row) {
                    $select_box .= "<option value='".$row['aCode']."'>".$row['cName']."</option>";
                }
            }

            $data = array(
                'select_box' => $select_box
            );

            $this->load->view(SHOP_MODEL_ROOT . '/include/non_header_View.php', $hearder_Data);
            $this->load->view(SHOP_MODEL_ROOT . '/ccategory_win_View', $data);
            $this->load->view(SHOP_MODEL_ROOT . '/include/footer_View.php');
        }
    }
}