<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SCartoon extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index()
    {

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $typ=$this->input->post('typ');
        $tstr=$this->input->post('tstr');

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();
        $category_selectbox = $this->common_m->category_selectbox();

        $typ == '' ? $typ='' : $typ=$this->input->post('typ');
        $tstr == '' ? $tstr='' : $tstr=$this->input->post('tstr');


        $data = array(
            'wid' =>$uid,
            'writer' => $wrtier_selectbox,
            'category' => $category_selectbox,
            'typ' =>$typ,
            'tstr' =>$tstr
        );



        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'scartoon_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function Data_Load(){

        $wid = ($this->input->post('wid')) ? $this->input->post('wid') : 0;
        $typ = ($this->input->post('typ')) ? $this->input->post('typ') : 0;
        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';


        $totalrows = $this->input->post('totalrows') ? $this->input->post('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->all_count2($wid,$typ,$tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->Data_Load2($wid,$typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->code;
                $response->rows[$i]['cell'] = array(
                    $row->code, $row->imgname,$row->imgname2, $row->title,$row->sub_title, $row->category,$row->cat_month,$row->cat_week, $row->writer1,$row->Supervisor,$row->imgname,$row->imgname2, $row->cash, $row->sale,$row->sale_date,$row->view_type,$row->view_dir, $row->isStatus,$row->isOpen,$row->isFree, $row->explan, $row->regidate,$row->code,$row->code
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
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            if ($insert_id = $this->cartoon_m->Data_Add($post)) {
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
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            if ($insert_id = $this->cartoon_m->Data_Update($post)) {
                $data = array(
                    'pcode' => $post['id'],
                    'price' => $post['cash'],
                    'sale' => $post['sale'],
                    'sale_date' => $post['sale_date']
                );

                $tid = $this->cartoon_m->Sub_Cartoon_Update($data);
                $result = true;
                $message = 'Success';
            } else {
                $result = true;
                $message = 'Not change';
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
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $affected_rows = $this->cartoon_m->Data_Del($post['id']);

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

    public function upload_main_img()
    {
        $code = $this->input->post('code');
        $key = $this->input->post('key');
        if ($code === null || $key=== null) {
            $result = false;
            $message = 'missing params.';
        }else{

            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES['imgname']['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = '/www/inamutoon_com/assets/data/cartoon_list/';
            $config['max_size'] = '20000';
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);


            if($_FILES[$key]['size'] <=0){
                $result = true;
                $message = 'Not Upload File';
            }else{
                if (!$this->upload->do_upload($key)){
                    $result = false;
                    $message = array('error' => $this->upload->display_errors());
                }else{
                    $upload = $this->upload->data();
                    $filename = $upload['raw_name'].$upload['file_ext'];

                    $this->load->model(ROOT_URL.'cartoon_m');
                    $Cnt = $this->cartoon_m->Update_Main_Filename($code,$filename);
                    if($Cnt > 0){
                        $result = true;
                        $message = 'success';
                    }else{
                        $result = false;
                        $message = 'Upload Error(102)';
                    }
                }
            }
        }
        print json_encode(array('result' => $result, 'message'=>$message));
    }

    public function Image(){
        $ccode = $this->uri->segment(3);
        if(empty($ccode)){
            alert("카툰을 선택하세요.",ROOT_URL.'Cartoon/');
        }else {

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($ccode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.",ROOT_URL.'Cartoon/');
            }else {
                $data = array(
                    'ccode' => $ccode,
                    'c_name' => $Rs[0]['title']
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
                $this->load->view(CMS_VIEW_ROOT . 'cartoon_image_View', $data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
            }
        }

    }

    public function Img_Data_Load(){

        $pcode = ($this->input->post('pcode')) ? $this->input->post('pcode') : 0;

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

        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->Img_all_count($pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->Img_Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->location,$row->isUse, $row->fname,$row->sn,$row->fcolor,$row->font_color,$row->regidate
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

    public function Img_Data_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
            if(empty($post['pcode'])){
                $result = false;
                $retval = '';
                $message = 'Not Input Parameter2';
            }else {
                $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
                if ($insert_id = $this->cartoon_m->Img_Data_Add($post)) {
                    $result = true;
                    $retval = $insert_id;
                    $message = 'Success';
                } else {
                    $result = false;
                    $retval = '';
                    $message = 'Fail!!';
                }
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $retval,
            'message' => $message
        ));

    }

    public function Img_Data_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            if ($insert_id = $this->cartoon_m->Img_Data_Update($post)) {
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

    public function Img_Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $affected_rows = $this->cartoon_m->Img_Data_Del($post['id']);

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

    public function Notice(){
        $ccode = $this->uri->segment(3);
        if(empty($ccode)){
            alert("카툰을 선택하세요.",ROOT_URL.'Cartoon/');
        }else {

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($ccode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.",ROOT_URL.'Cartoon/');
            }else {
                $data = array(
                    'ccode' => $ccode,
                    'c_name' => $Rs[0]['title']
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
                $this->load->view(CMS_VIEW_ROOT . 'cartoon_notice_View', $data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
            }
        }
    }

    public function Notice_Data_Load(){

        $pcode = ($this->input->post('pcode')) ? $this->input->post('pcode') : 0;

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

        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->Notice_all_count($pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->Notice_Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->title,$row->isOpen,$row->regidate
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

    public function Notice_Data_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
            if(empty($post['pcode'])){
                $result = false;
                $retval = '';
                $message = 'Not Input Parameter2';
            }else {
                $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
                if ($insert_id = $this->cartoon_m->Notice_Data_Add($post)) {
                    $result = true;
                    $retval = $insert_id;
                    $message = 'Success';
                } else {
                    $result = false;
                    $retval = '';
                    $message = 'Fail!!';
                }
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $retval,
            'message' => $message
        ));

    }

    public function Notice_Data_Update(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            if ($insert_id = $this->cartoon_m->Notice_Data_Update($post)) {
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

    public function Notice_Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $affected_rows = $this->cartoon_m->Notice_Data_Del($post['id']);

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
