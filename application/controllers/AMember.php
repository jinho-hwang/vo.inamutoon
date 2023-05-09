<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AMember extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
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

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'amember_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function Cartoon(){

        $wid = $this->uri->segment(3);
        if(empty($wid)){
            alert("잘못된 접근입니다.");
        }else {

            $tstr = $this->input->post('tstr');
            $this->load->model('common_m');
            $p_Caregory = $this->common_m->cartoon_selectbox_All();


            $data = array(
                'p_Caregory' => $p_Caregory
            );

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid),
                'tstr' => $tstr,
                'wid' => $wid
            );

            $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'admin_cartoon_View', $data);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
        }
    }


    public function Auth(){
        $wid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $menu = Make_Menu($this,$wid);
        $data = array(
            'wid' => $wid,
            'menu' => $menu
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View');
        $this->load->view(CMS_VIEW_ROOT.'auth_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }

    public function Auth_Modify(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = 'error';
            $message = 'Not Input Parameter';
        } else {
            $wid = $post['wid'];
            $item1 = $post['item1'];
            $item2 = $post['item2'];

            $temp1 = explode("||",$item1);
            $temp2 = explode("||",$item2);

            $menu = array();
            for($i=0;$i<ArrayCount($temp1)-1;$i++){
                $menu['menu'.$temp1[$i]] = 1;
            }

            for($i=0;$i<ArrayCount($temp2)-1;$i++){
                $menu['menu'.$temp2[$i]] = 0;
            }

            $this->load->model(CMS_MODEL_ROOT.'/AMember_m');
            $cnt = $this->AMember_m->Data_Update2($wid,$menu);

            $result = 'ok';
            $message = 'success';
        }

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }



    public function Data_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
       
        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'/AMember_m');
        $count = $this->AMember_m->all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->AMember_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->userid, $row->passwd,$row->sn,$row->sn,$row->regidate
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

    public function Data_Load2(){

        $uid = ($this->input->post('wid')) ? $this->input->post('wid') : 0;

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/AMember_m');
        $count = $this->AMember_m->all_count2($uid);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->AMember_m->Data_Load2($uid,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;
            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->code
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
            $this->load->model(CMS_MODEL_ROOT . '/AMember_m');
            if ($insert_id = $this->AMember_m->Data_Add($post)) {
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

    public function Data_Add2(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $wid = $this->uri->segment(3);
            $this->load->model(CMS_MODEL_ROOT . '/AMember_m');
            if ($insert_id = $this->AMember_m->Data_Add2($wid,$post['code'])) {
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
            $this->load->model(CMS_MODEL_ROOT . '/AMember_m');
            if ($insert_id = $this->AMember_m->Data_Update($post)) {
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
    
    public function Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . '/AMember_m');
            $affected_rows = $this->AMember_m->Data_Del($post['id']);

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

    public function Data_Delete2(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . '/AMember_m');
            $affected_rows = $this->AMember_m->Data_Del2($post['id']);

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
