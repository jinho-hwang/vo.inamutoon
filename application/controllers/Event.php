<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('basic', 'security', 'url'));
        $this->load->library('session');
        TMSLogin($this);
    }


    public function PushEvent(){
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
        $this->load->view(CMS_VIEW_ROOT.'Event/pushevent_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function PushEvent_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->Push_Event_all();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->Push_Event_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->title,$row->cash,$row->s_date,$row->e_date,$row->adddate,$row->isUse,$row->regidate,$row->tCnt
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


    public function PushEvent_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Event_m');
            if ($insert_id = $this->Event_m->PushEvent_Add($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => '',
            'message' => $message
        ));
    }


    public function PushEvent_Update(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Event_m');
            $affected_rows = $this->Event_m->PushEvent_Update($post);

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
            'code' => $post['code'],
            'message' => $message
        ));
    }

    public function PushEvent_Del(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Event_m');
            $affected_rows = $this->Event_m->PushEvent_Del($post['id']);

            if ($affected_rows > 0) {
                $result = true;
                $retval = $post['id'];
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


    public function e20210506_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->e20210506_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->e20210506_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $address = $row->address1.' '.$row->address2;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$address,$row->mobile,$row->regidate
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

    public function e20210506(){
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
        $this->load->view(CMS_VIEW_ROOT.'Event/event20210506_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }



    public function m20200901(){
        $grade = '';
        for($i=1;$i<=10;$i++){
            $grade .= "'" . $i . "':'" . $i . "등급',";
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->m20200901_all_count();

        $data = array(
            'grade' => $grade,
            'total' => $count

        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'m20200901_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function m20200901_Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->m20200901_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->m20200901_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$row->url,$row->regidate
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

    public function e20200901(){
        $grade = '';
        for($i=1;$i<=10;$i++){
            $grade .= "'" . $i . "':'" . $i . "등급',";
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->e20200901_all_count();

        $data = array(
            'grade' => $grade,
            'total' => $count

        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'e20200901_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function e20200901_Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->e20200901_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->e20200901_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$row->regidate
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


    public function openEvent1(){
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
        $this->load->view(CMS_VIEW_ROOT.'event1_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function open1_Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->open1_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->open1_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $address = $row->address1.' '.$row->address2;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$address,$row->mobile,$row->regidate
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

    public function openEvent2(){
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
        $this->load->view(CMS_VIEW_ROOT.'event2_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function open2_Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->open2_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->open2_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $address = $row->address1.' '.$row->address2;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$address,$row->mobile,$row->regidate
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

    public function openEvent3(){
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
        $this->load->view(CMS_VIEW_ROOT.'event3_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function open3_Data_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'/Event_m');
        $count = $this->Event_m->open3_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Event_m->open3_Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $address = $row->address1.' '.$row->address2;
                $response->rows[$i]['cell'] = array(
                    $row->userid,$row->uname,$address,$row->mobile,$row->regidate
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

    public function ToonView(){


        $year = $this->uri->segment(3);
        $month = $this->uri->segment(4);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(4);
        $sdatestr = $year."-".$month;

        $maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');


        $Rs = $this->Cartoon_m->Load_Cartoon_Type(3);
        if(ArrayCount($Rs)<=0) {
            alert('잘못된 접근입니다.');
        }else{
            $darr = array();
            for($i=0;$i<=(ArrayCount($Rs)-1);$i++){
                $darr[$i] = $Rs[$i]['code'];
            }

            $dastr = implode(',', $darr);
            $Viewarr = array();
            $Titlearr = array();
            $Dayarr = array();
            $Sumarr = array();
            $TotalView = 0;
            $TCnt = ArrayCount($darr);
            for ($i = 0; $i <= $TCnt - 1; $i++) {
                $pcode = $darr[$i];
                $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
                $Titlearr[$i] = (ArrayCount($info) > 0) ? $info[0]['title'] : '';
                for ($day = 1; $day <= $maxDay; $day++) {
                    $sdate = $year . "-" . $month . '-' . sprintf('%02d', $day);
                    $Dayarr[$day] = $sdate;
                    $Sumarr[$pcode] = 0;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['sdate'] = $sdate;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['cnt'] = 0;

                }
            }

            $Rs = $this->dashboard_m->View_data_Cnt4($dastr, $sdatestr);
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $v) {
                    $pcode = $v['pcode'];
                    $sdate2 = $v['m'];

                    $Viewarr[$pcode][$sdate2]['cnt'] = $v['Cnt'];
                    $Sumarr[$pcode] = $Sumarr[$pcode] + $v['Cnt'];
                    $TotalView = $TotalView + $v['Cnt'];
                }
            }

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $RetVal = array(
                'year' => $year,
                'month' => $month,
                'title' => $Titlearr,
                'data' => $Viewarr,
                'day' => $Dayarr,
                'Total' => $TotalView,
                'Sum' => $Sumarr,
                'code' => $darr,
                'maxday' => $maxDay

            );


            $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'compe_View', $RetVal);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
        }
    }


    public function ToonView2(){


        $year = $this->uri->segment(3);
        $month = $this->uri->segment(4);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(4);
        $sdatestr = $year."-".$month;

        $maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');


        $Rs = $this->Cartoon_m->Load_Cartoon_Type(3);
        if(ArrayCount($Rs)<=0) {
            alert('잘못된 접근입니다.');
        }else{
            $darr = array();
            for($i=0;$i<=(ArrayCount($Rs)-1);$i++){
                $darr[$i] = $Rs[$i]['code'];
            }

            $dastr = implode(',', $darr);
            $Viewarr = array();
            $Titlearr = array();
            $Dayarr = array();
            $Sumarr = array();
            $TotalView = 0;
            $TCnt = ArrayCount($darr);
            for ($i = 0; $i <= $TCnt - 1; $i++) {
                $pcode = $darr[$i];
                $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
                $Titlearr[$i] = (ArrayCount($info) > 0) ? $info[0]['title'] : '';
                for ($day = 1; $day <= $maxDay; $day++) {
                    $sdate = $year . "-" . $month . '-' . sprintf('%02d', $day);
                    $Dayarr[$day] = $sdate;
                    $Sumarr[$pcode] = 0;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['sdate'] = $sdate;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['cnt'] = 0;

                }
            }

            $Rs = $this->dashboard_m->View_data_Cnt6($dastr, $sdatestr);
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $v) {
                    $pcode = $v['pcode'];
                    $sdate2 = $v['m'];

                    $Viewarr[$pcode][$sdate2]['cnt'] = $v['Cnt'];
                    $Sumarr[$pcode] = $Sumarr[$pcode] + $v['Cnt'];
                    $TotalView = $TotalView + $v['Cnt'];
                }
            }

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $RetVal = array(
                'year' => $year,
                'month' => $month,
                'title' => $Titlearr,
                'data' => $Viewarr,
                'day' => $Dayarr,
                'Total' => $TotalView,
                'Sum' => $Sumarr,
                'code' => $darr,
                'maxday' => $maxDay

            );


            $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'compe2_View', $RetVal);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
        }
    }

    public function ToonView3(){


        $year = $this->uri->segment(3);
        $month = $this->uri->segment(4);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(4);
        $sdatestr = $year."-".$month;

        $maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');


        $Rs = $this->Cartoon_m->Load_Cartoon_Type(3);
        if(ArrayCount($Rs)<=0) {
            alert('잘못된 접근입니다.');
        }else{
            $darr = array();
            for($i=0;$i<=(ArrayCount($Rs)-1);$i++){
                $darr[$i] = $Rs[$i]['code'];
            }

            $dastr = implode(',', $darr);
            $Viewarr = array();
            $Titlearr = array();
            $Dayarr = array();
            $Sumarr = array();
            $TotalView = 0;
            $TCnt = ArrayCount($darr);
            for ($i = 0; $i <= $TCnt - 1; $i++) {
                $pcode = $darr[$i];
                $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
                $Titlearr[$i] = (ArrayCount($info) > 0) ? $info[0]['title'] : '';
                for ($day = 1; $day <= $maxDay; $day++) {
                    $sdate = $year . "-" . $month . '-' . sprintf('%02d', $day);
                    $Dayarr[$day] = $sdate;
                    $Sumarr[$pcode] = 0;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['sdate'] = $sdate;
                    $Viewarr[$pcode][sprintf('%02d', $day)]['cnt'] = 0;

                }
            }

            $Rs = $this->dashboard_m->View_data_Cnt7($dastr, $sdatestr);
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $v) {
                    $pcode = $v['pcode'];
                    $sdate2 = $v['m'];

                    $Viewarr[$pcode][$sdate2]['cnt'] = $v['Cnt'];
                    $Sumarr[$pcode] = $Sumarr[$pcode] + $v['Cnt'];
                    $TotalView = $TotalView + $v['Cnt'];
                }
            }

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $RetVal = array(
                'year' => $year,
                'month' => $month,
                'title' => $Titlearr,
                'data' => $Viewarr,
                'day' => $Dayarr,
                'Total' => $TotalView,
                'Sum' => $Sumarr,
                'code' => $darr,
                'maxday' => $maxDay

            );


            $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'compe3_View', $RetVal);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
        }
    }


}