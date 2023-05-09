<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartoon extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        TMSLogin2($this,10);
    }
    
    public function index()
    {
        $typ=$this->input->post('typ');
        $tstr=$this->input->post('tstr');

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();
        $category_selectbox = $this->common_m->category_selectbox();

        $typ == '' ? $typ='' : $typ=$this->input->post('typ');
        $tstr == '' ? $tstr='' : $tstr=$this->input->post('tstr');


        $data = array(
            'writer' => $wrtier_selectbox,
            'category' => $category_selectbox,
            'typ' =>$typ,
            'tstr' =>$tstr
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'cartoon_View.php',$data);
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
        

        $totalrows = $this->input->post('totalrows') ? $this->input->post('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->all_count($typ,$tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->Data_Load($typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->code;
                $response->rows[$i]['cell'] = array(
                    $row->code, $row->imgname,$row->imgname2, $row->title,$row->sub_title, $row->category,$row->cat_month,$row->writer1,$row->Supervisor,$row->imgname,$row->imgname2, $row->cartoon_fee,$row->cash,$row->p_cash, $row->isSale,$row->view_type,$row->view_dir,$row->isStatus, $row->cartoon_typ1,$row->cartoon_typ2,$row->isNotList,$row->isLike,$row->isOpen,$row->isPwd,$row->isFree,$row->isMonth, $row->isRecom,$row->recom_fix, $row->hit, $row->explan, $row->regidate,$row->code,$row->code,$row->code,$row->code,$row->code,$row->code
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
                    'price2' => $post['p_cash']
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


    public function Ca_Advert(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($pcode > 0){
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon_Code($pcode);
            $title = (ArrayCount($Rs)>0) ? $Rs[0]['title'] : '';
        }

        $main_arr = array(
            'title' => $title,
            'pcode' => $pcode
        );


        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'ad_banner2_View',$main_arr);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }


    public function AdData_Load2()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'banner_m');
        $count = $this->banner_m->ad_all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->banner_m->AdData_Load2($pcode,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->fname,$row->fname, $row->title, $row->location, $row->Link, $row->bg_img,$row->bg_img,$row->isUse, $row->regidate
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

    public function AdData_Add2(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {

            $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->load->model(CMS_MODEL_ROOT . 'banner_m');
            if ($insert_id = $this->banner_m->AdData_Add2($pcode,$post)) {
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

    public function AdData_Update2()
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
            if ($insert_id = $this->banner_m->AdData_Update2($post)) {
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

    public function AdData_Del2()
    {

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Banner_m');
            $affected_rows = $this->Banner_m->AdData_Del_2($post['id']);

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

    public function Week()
    {
        $grade = '';
        for($i=1;$i<=10;$i++){
            $grade .= "'" . $i . "':'" . $i . "등급',";
        }



        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($pcode==''){
            alert('잘못된 접근입니다.');
        }else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);
            $title = (ArrayCount($Rs)>0) ? $Rs[0]['title'] : '';

            $data = array(
                'grade' => $grade,
                'pcode' => $pcode,
                'title' => $title
            );



            $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'week_View.php', $data);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View.php');
        }
    }

    public function Week_Load()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
        $count = $this->cartoon_m->week_all_count($pcode);

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->week_Data_Load($pcode,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                   $row->week
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

    public function Week_Delete()
    {

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            $affected_rows = $this->cartoon_m->Week_Del($post['id']);

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


    public function Week_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {

            $pcode = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $this->load->model(CMS_MODEL_ROOT . 'cartoon_m');
            if ($insert_id = $this->cartoon_m->Week_Add($pcode,$post)) {
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

}
