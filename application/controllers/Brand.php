<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index11()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();
        $this->load->model('Shop/Company_m');
        $company_selectbox = $this->Company_m->company_selectbox();
        $main_arr = array(
            'writer' =>$wrtier_selectbox,
            'company' => $company_selectbox
        );

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'brand_View',$main_arr);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }

    public function index()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();
        $this->load->model('Shop/Company_m');
        $company_selectbox = $this->Company_m->company_selectbox();
        $main_arr = array(
            'writer' =>$wrtier_selectbox,
            'company' => $company_selectbox
        );

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'brand_View2',$main_arr);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }

    public function Brand_Reg(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $g_member = '';
        $e_member = '';
        $cartoon = '';

        $this->load->model('common_m');
        $Rs = $this->common_m->Load_Writer();
        if(ArrayCount($Rs)>0) {
            $writer = '<option value="">선택하세요.</option>';
            foreach ($Rs as $d) {
                $writer .= '<option value="' . $d['code'] . '">' . $d['wname'] . '</option>';
            }
        }
        $this->load->model('Shop/Company_m');
        $Rs = $this->Company_m->Load_Company_All();
        if(ArrayCount($Rs)>0) {
            $company = '<option value="">선택하세요.</option>';
            foreach ($Rs as $d) {
                $company .= '<option value="' . $d['cCode'] . '">' . $d['cTitle'] . '</option>';
            }
        }

        $data = array(
            'writer' => $writer,
            'company' => $company
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'brand_reg_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function Data_Reg(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            $result = 'error';
            $code = '';
            $message = 'Not Post Data';
        }else{
            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            $b_title = $post['btitle'];
            $b_content = $post['bcontent'];
            $data = array(
              'b_title' => $b_title,
              'b_content' => $b_content
            );

            $bCode = $this->brand_m->Brand_Add($data);
            if(!empty($bCode)) {
                $arr_toon = $post['toon'];
                $gCnt = ArrayCount($arr_toon);
                if ($gCnt > 0) {
                    for ($i = 0; $i <= ($gCnt - 1); $i++) {
                        $t_data = array();
                        if ($arr_toon[$i] != '') {
                            $t_data['ccode'] = $arr_toon[$i];
                            $t_data['bcode'] = $bCode;
                            $t_data['typ'] = 1;
                            $t_data['isUse'] = 1;

                            $Cnt = $this->brand_m->Brand_Member_Add($t_data);
                        }
                    }
                }

                $arr_md = $post['md'];
                $mCnt = ArrayCount($arr_md);
                if ($mCnt > 0) {
                    for ($i = 0; $i <= ($mCnt - 1); $i++) {
                        $m_data = array();
                        if ($arr_toon[$i] != '') {
                            $m_data['ccode'] = $arr_md[$i];
                            $m_data['bcode'] = $bCode;
                            $m_data['typ'] = 2;
                            $m_data['isUse'] = 1;

                            $Cnt = $this->brand_m->Brand_Member_Add($m_data);
                        }
                    }
                }

                $result = 'ok';
                $code = $bCode;
                $message = 'success';

            }else{
                $result = 'error101';
                $code = '';
                $message = 'Not Create Code';
            }
        }

        $json = array(
            'result' => $result,
            'code' => $code,
            'msg' => $message
        );

        echo json_encode($json);
    }

    public function Member(){

        $typ = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $bcode = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT . 'brand_m');
        $Rs = $this->brand_m->Load_Brand_Info($bcode);
        if(ArrayCount($Rs)>0){
            $title = $Rs[0]['b_title'];
        }else{
            $title = '';
        }

        if($typ==1){
            $this->load->model('common_m');
            $selecter = $this->common_m->wrtier_selectbox();
            $title = $title.' > 웹툰';

        }else{
            $this->load->model('Shop/Company_m');
            $selecter = $this->Company_m->company_selectbox();
            $title = $title.' > MD샵';
        }

        $main_arr = array(
            'selecter' =>$selecter,
            'bcode' => $bcode,
            'typ' => $typ,
            'title' => $title
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'brand_member_View.php',$main_arr);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
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

        $this->load->model(CMS_MODEL_ROOT . 'brand_m');
        $count = $this->brand_m->all_count();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->brand_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn, $row->wcode, $row->company,$row->imgname, $row->imgname,$row->imgname2, $row->imgname2,$row->content,$row->isUse,$row->regidate
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

    public function Data_Load2()
    {

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'brand_m');
        $count = $this->brand_m->all_count2();

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->brand_m->Data_Load2($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->bcode;
                $response->rows[$i]['cell'] = array(
                    $row->bcode,$row->b_title, $row->b_content,$row->forder,$row->fname,$row->fname,$row->fname2,$row->fname2,$row->isUse,$row->regidate,$row->bcode,$row->bcode

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

    public function Data_Load3()
    {

        $typ = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $bcode = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
        if ($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT . 'brand_m');
        $count = $this->brand_m->all_count3($typ,$bcode);

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->brand_m->Data_Load3($typ,$bcode,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->ccode,$row->ccode, $row->isUse,$row->regidate
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

    public function Data_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $code = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            if ($insert_id = $this->brand_m->Data_Add($post)) {
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
            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            if ($insert_id = $this->brand_m->Data_Update($post)) {
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
            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            $affected_rows = $this->brand_m->Data_Del($post['id']);

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

    public function Data_Member_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $typ = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $bcode = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data = array(
                'ccode' => $post['ccode'],
                'bcode' => $bcode,
                'typ' => $typ,
                'isUse' => $post['isUse']
            );

            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            $affected_rows = $this->brand_m->Data_Member_Add($data);

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

    public function Data_Member_Del(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {

            $this->load->model(CMS_MODEL_ROOT . 'brand_m');
            $affected_rows = $this->brand_m->Data_Member_Del($post['id']);

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