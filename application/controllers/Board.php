<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function Env()
    {
        $grade = '';
        for ($i = 1; $i <= 10; $i++) {
            $grade .= "'" . $i . "':'" . $i . "등급',";
        }
        $data = array('grade' => $grade);

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'board_env_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
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

        $this->load->model(CMS_MODEL_ROOT . 'Board_m');
        $count = $this->Board_m->all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Board_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->bid;
                $response->rows[$i]['cell'] = array(
                    $row->bid, $row->bname,$row->bType,$row->w_grade, $row->r_grade, $row->p_cnt, $row->v_cnt,$row->regidate, $row->bid
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
            $this->load->model(CMS_MODEL_ROOT . 'Board_m');
            if ($insert_id = $this->Board_m->Data_Add($post)) {
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
            $this->load->model(CMS_MODEL_ROOT . 'Board_m');
            $insert_id = $this->Board_m->Data_Update($post);
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
            $this->load->model(CMS_MODEL_ROOT . 'Board_m');
            $affected_rows = $this->Board_m->Data_Del($post['id']);

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

    public function BList()
    {
        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . '/Login', 'refresh');
        } else {
            $code = ($this->uri->segment(3)!='') ? $this->uri->segment(3) : 1 ;
            $page = ($this->uri->segment(4)!='') ? $this->uri->segment(4) : 1 ;

            if (empty($code)) {
                alert('잘못된 접근입니다.');
            } else {

                $this->load->model(CMS_MODEL_ROOT . 'Board_m');
                $env = $this->Board_m->Load_Board_Env($code);
                $Rs = $this->Board_m->Data_Total_Cnt($code);

                $per_page = (int)$env[0]['v_cnt'];
                $num_links = (int)$env[0]['p_cnt'];
                $total = $Rs[0]['Cnt'];

                $this->load->library('pagination');
                $config['base_url'] = ROOT_URL.'Board/BList/'.$code;
                $config['total_rows'] = $total;
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] = $num_links;
                $config['per_page'] = $per_page;
                $config['page_query_string'] = FALSE;
                $config['uri_segment'] = 4;
                $this->pagination->initialize($config);

                $start = ($page - 1) * $per_page;
                $limit = $per_page;
                $board = $this->Board_m->Data_Board($code, $start, $limit);

                $data = array(
                    'typ' => 0,
                    'env' => $env,
                    'board' => $board,
                    'page' => $this->pagination->create_links()
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/non_header_View');
                $this->load->view(CMS_VIEW_ROOT . 'board_list_View',$data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');

            }
        }
    }

    public function Write()
    {

        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . 'Login', 'refresh');
        } else {
            $code = $this->uri->segment(3);

            $this->load->model(CMS_MODEL_ROOT . 'Board_m');
            $Rs = $this->Board_m->Load_Board_Env($code);

            /*$this->load->model(CMS_VIEW_ROOT . 'Writer_m');
            $writer = $this->Writer_m->Load_All();*/

            /*$this->load->model(CMS_VIEW_ROOT . 'Cartoon_m');
            $cartoon = $this->Cartoon_m->Load_Cartoon_All();*/


            $data = array(
                'view_title' => '게시판',
                'userid' => $sessionArr['userid'],
                'bid' => $code,
                'bname' => $Rs[0]['bname'],
                'bType' => $Rs[0]['bType']
            );

            $this->load->view(CMS_VIEW_ROOT . 'include/non_header_View');
            $this->load->view(CMS_VIEW_ROOT . 'board_write_View',$data);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');

        }

    }

    public function CkEdit_upload()
    {

        $key = 'upload';
        $callID = $this->input->get('CKEditorFuncNum');
        $allowed_types = 'jpg|png|gif';
        preg_match("/\.(" . $allowed_types . ")$/i", $_FILES[$key]['name'], $ext);
        $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
        $config['upload_path'] = BOARD_UPLOAD_DIR;
        $config['max_size'] = '20000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if ($_FILES[$key]['size'] <= 0) {
            //$message = 'Not Upload File';
            alert('업로드 파일을 선택하세요.');
        } else {
            if (!$this->upload->do_upload($key)) {
                alert('업로드에 실패 하였습니다.\n원인:' . $this->upload->display_errors('', ''));
                //$message = array('error' => $this->upload->display_errors());
            } else {
                $upload = $this->upload->data();
                //var_dump($upload);
                if($upload['image_width'] > 1024 ){
                    //echo('1');
                    $resize_name = $upload['raw_name'].'_thumb'.$upload['file_ext'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $_FILES[$key]['tmp_name'];
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']  = 720;
                    $config['new_image'] =  BOARD_UPLOAD_DIR.'/'.$upload['file_name'];

                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $filename = $resize_name;
                }else{
                    //echo('2');
                    $filename = $upload['file_name'];
                }
                $url = WWWROOT . 'assets/data/board/' . $filename;
                echo("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('" . $callID . "', '" . $url . "', '업로드완료')</script>");
            }
        }
    }

    public function Reg_Board()
    {
        foreach ($this->input->post() as $k_val => $value) {
            $post[$k_val] = $value;
        }

        if (empty($post)) {
            alert('필수항목이 누락 되었습니다.');
        } else {

            $data = array(
                'bid' => $post['bid'],
                'bTitle' => $post['title'],
                'bContent' => $post['description'],
                'writer' => $post['writer'],
                'main_thumb' => '',
                'thumb' => ''

            );



            $this->load->model(CMS_VIEW_ROOT . 'Board_m');
            $Cnt = $this->Board_m->Data_Reg($data);
            alert_refresh_close('등록 하였습니다.');
        }
    }

    public function Bview()
    {
        /*$sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . '/Login', 'refresh');
            return;
        }*/


        $code = $this->uri->segment(3);
        if (empty($code)) {
            alert('필수항목이 누락 되었습니다.');
        } else {
            $this->load->model(CMS_VIEW_ROOT . 'Board_m');
            $Rs = $this->Board_m->Data_View($code);


            if (empty($Rs)) {
                alert('존재 하지 않는 글 입니다.');
            } else {
                $Rs1 = $this->Board_m->Load_Board_Env($Rs[0]['bid']);
                if (empty($Rs1)) {
                    alert('잘못된 게시판 환경 입니다.');
                } else {

                    $data = array(
                        'data' => $Rs,
                        'env' => $Rs1
                    );

                    $this->load->view(CMS_VIEW_ROOT . 'include/non_header_View');
                    $this->load->view(CMS_VIEW_ROOT . 'Board_Data_View',$data);
                    $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
                }
            }

        }
    }

    public function Mod_Board()
    {
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            alert('필수항목이 누락 되었습니다.');
        } else {
            $data = array(
                'bid' => $post['bid'],
                'bcode' => $post['bcode'],
                'cid' => 0,
                'title' => $post['title'],
                'description' => $post['description'],
                'writer' => $post['writer']
            );

            $this->load->model(CMS_MODEL_ROOT . 'Board_m');
            $Cnt = $this->Board_m->Data_Mod($data);
            alert_refresh_close('수정 하였습니다.');
        }
    }


    public function Del_Board(){
        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . '/Login', 'refresh');
        } else {
            $code = $this->uri->segment(3);
            if (empty($code)) {
                alert('잘못된 접근입니다.');
            } else {
                $this->load->model(CMS_MODEL_ROOT . 'Board_m');
                $Cnt = $this->Board_m->Data_Board_Del($code);
                alert_refresh_close('삭제 하였습니다.');
            }
        }
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
            preg_match("/\.(".$allowed_types.")$/i", $_FILES[$key]['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = UPLOAD_PATH.'/assets/upload/board/main/';
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

                    $this->load->model(CMS_MODEL_ROOT.'Board_m');
                    $Cnt = $this->Board_m->Update_Main_Filename($code,$filename);
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

    public function upload_sub_img()
    {
        $code = $this->input->post('code');
        $key = $this->input->post('key');
        if ($code === null || $key=== null) {
            $result = false;
            $message = 'missing params.';
        }else{

            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES[$key]['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = UPLOAD_PATH.'/assets/upload/board/sub/';
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

                    $this->load->model(CMS_MODEL_ROOT.'Board_m');
                    $Cnt = $this->Board_m->Update_Sub_Filename($code,$filename);
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


    public function upload_thumb_img()
    {
        $code = $this->input->post('code');
        $key = $this->input->post('key');
        if ($code === null || $key=== null) {
            $result = false;
            $message = 'missing params.';
        }else{

            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES[$key]['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = UPLOAD_PATH.'/assets/upload/board/thumb/';
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

                    $this->load->model(CMS_MODEL_ROOT.'Board_m');
                    $Cnt = $this->Board_m->Update_Thumb_Filename($code,$filename);
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


    private function upload_board_img($tUrl,$fileArr,$key){
        if($fileArr['size'] >0) {
            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(" . $allowed_types . ")$/i", $fileArr['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path'] = $tUrl;
            $config['max_size'] = '20000';
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload($key)) {
                $filename = $this->upload->display_errors('<p>', '</p>');;
            } else {
                $upload = $this->upload->data();
                $filename = $upload['file_name'];
            }
        }else{
            $filename = '2';
        }

        return $filename;
    }

    public function Ch_Agree(){
        $bcode = $this->uri->segment(3);
        $type = $this->uri->segment(4);


//        echo('bcode='.$bcode.'</br>');
//        echo('type='.$type.'</br>');

        if($bcode=='' || $type==''){
            alert('잘못된 접근입니다.');
        }else{

            $data = array(
                'bcode' => $bcode,
                'type' =>$type,
            );

            $this->load->model(CMS_MODEL_ROOT.'Board_m');
            $Cnt = $this->Board_m->Update_Agree($data);

            if($Cnt > 0){
                alert_refresh_close('success!!');
            }
        }
    }

    public function Ch_Fix(){
        $bcode = $this->uri->segment(3);
        $type = $this->uri->segment(4);


//        echo('bcode='.$bcode.'</br>');
//        echo('type='.$type.'</br>');

        if($bcode=='' || $type==''){
            alert('잘못된 접근입니다.');
        }else{

            $data = array(
                'bcode' => $bcode,
                'type' =>$type,
            );

            $this->load->model(CMS_MODEL_ROOT.'Board_m');
            $Cnt = $this->Board_m->Update_Fix($data);

            if($Cnt > 0){
                alert_refresh_close('success!!');
            }
        }
    }

    public function FreeView()
    {
        $code = $this->uri->segment(3);
        if (empty($code)) {
            alert('필수항목이 누락 되었습니다.');
        } else {
            $this->load->model(CMS_MODEL_ROOT.'/Board_m');
            $Rs = $this->Board_m->Data_View($code);
            if (ArrayCount($Rs)<=0) {
                alert_close('존재 하지 않는 글 입니다.');
            } else {
                $Rs1 = $this->Board_m->Load_Board_Env($Rs[0]['bid']);
                if (ArrayCount($Rs1)<=0) {
                    alert_close('잘못된 게시판 환경 입니다.');
                } else {
                    $data = array(
                        'data' => $Rs,
                        'title' => '미리보기'
                    );
                    $this->load->view(CMS_VIEW_ROOT . 'freeview_View',$data);
                }
            }
        }
    }

}