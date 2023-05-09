<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('basic', 'security', 'url'));
        $this->load->library('session');
        TMSLogin($this);
    }

    public function Book111(){

        $pcode = 111;
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }


        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        if(empty($post['syear'])){
            $sdate ='';
            $edate ='';
        }else{
            $sdate = $post['syear'].'-'.$post['smonth'].'-'.$post['sday'].' 00:00:00';
            $edate = $post['eyear'].'-'.$post['emonth'].'-'.$post['eday'].' 23:59:59';
        }



        if(empty($post)){
          $data = array(
              'pcode' => $pcode,
              'sdate' => $sdate,
              'edate' => $edate,
              'syear' =>'',
              'smonth' =>'',
              'sday' =>'',
              'eyear' =>'',
              'emonth' =>'',
              'eday' =>''
          );
        }else {
            $data = array(
                'pcode' => $pcode,
                'sdate' => $sdate,
                'edate' => $edate,
                'syear' =>$post['syear'],
                'smonth' =>$post['smonth'],
                'sday' =>$post['sday'],
                'eyear' =>$post['eyear'],
                'emonth' =>$post['emonth'],
                'eday' =>$post['eday']
            );
        }

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'book111_View', $data);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');

    }

    public function Book111_Load(){

        $pcode = ($this->input->post('pcode')) ? $this->input->post('pcode') : '';
        $sdate = ($this->input->post('sdate')) ? $this->input->post('sdate') : '';
        $edate = ($this->input->post('edate')) ? $this->input->post('edate') : '';


        if($pcode=='' || $sdate=='' || $edate ==''){

        }else {
            $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
            $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
            $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
            $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
            $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
            $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
            $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';


            $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows') : false;
            if ($totalrows) {
                $limit = $totalrows;
            }

            $this->load->model(CMS_MODEL_ROOT . 'data_m');
            $count = $this->data_m->all_count_Book111($pcode,$sdate,$edate);

            $total_pages = ($count) ? ceil($count / $limit) : 0;
            $start = $limit * $page - $limit;

            $query = $this->data_m->Book111_Data_Load($pcode,$sdate,$edate);
            if (!empty($query)) {
                $response = (object)array();
                $i = 0;

                foreach ($query->result() as $row) {
                    $response->rows[$i]['id'] = $row->ccode;
                    $response->rows[$i]['cell'] = array(
                        $row->ccode, $row->Cnt
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

    }



    public function User()
    {
        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';
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
        $this->load->view(CMS_VIEW_ROOT.'data_user_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }

    public function Data_Load(){

        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';

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

        $this->load->model(CMS_MODEL_ROOT.'data_m');
        $count = $this->data_m->all_count($tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->data_m->Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->Userid,$row->pcode,$row->ccode,$row->regidate
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

    public function Gender(){

        $tempdata = $this->uri->segment(3);
        $tempdata=='' ? $gender =1 : $gender = $tempdata;

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'data_m');
        $Rs = $this->data_m->gender_Data($gender);

        for($i=0;$i<=9;$i++){
            $graph[$i]['title'] = '';
            $graph[$i]['Cnt'] = '';
        }

        $i = 0;
        $totalCnt = 0;
        foreach($Rs as $d){
            if(!empty($d['title'])) {
                $totalCnt = $totalCnt + $d['Cnt'];

                if ($i <= 8) {
                    $graph[$i]['title'] = $d['title'];
                    $graph[$i]['Cnt'] = $d['Cnt'];
                } else {
                    $graph[$i]['title'] = '기타';
                    $graph[$i]['Cnt'] = $graph[$i]['Cnt'] + $d['Cnt'];
                }

                $i<9 ? $i++ : $i=9;
            }
        }


        $data = array(
            'data' => $Rs,
            'total' => $totalCnt,
            'gender' => $gender,
            'graph' => $graph
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'gender_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include//footer_View');

    }

    public function Part()
    {
        $tempdata = $this->uri->segment(3);
        $tempdata == '' ? $part = 0 : $part = $tempdata;


        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );


        $graph = array();
        $this->load->model(CMS_MODEL_ROOT . 'data_m');
        if ($part > 0) {
            $totalCnt = 0;
            $Rs = $this->data_m->part_Data($part);
            $i = 0;
            foreach($Rs as $d){
                if(!empty($d['title'])) {
                    $totalCnt = $totalCnt + $d['Cnt'];

                    if ($i <= 8) {
                        $graph[$i]['title'] = $d['title'];
                        $graph[$i]['Cnt'] = $d['Cnt'];
                    } else {
                        $graph[$i]['title'] = '기타';
                        $graph[$i]['Cnt'] = $graph[$i]['Cnt'] + $d['Cnt'];
                    }

                    $i<9 ? $i++ : $i=9;
                }
            }


            $data = array(
                'data' => $Rs,
                'part' => $part,
                'total' =>$totalCnt,
                'graph' => $graph
            );
        }else {
            $totalarr = array();
            for ($i = 1; $i <= 7; $i++) {
                $Rs1 = $this->data_m->part_Data_All($i);
                if ($i == 1) {
                    $title = '감상';
                } else if ($i == 2) {
                    $title = '액션';
                } else if ($i == 3) {
                    $title = '일상';
                } else if ($i == 4) {
                    $title = '스포츠';
                } else if ($i == 5) {
                    $title = '판타지';
                } else if ($i == 6) {
                    $title = '학습';
                } else if ($i == 7) {
                    $title = 'SF';
                }

                $totalarr[$i]['title'] = $title;
                $totalarr[$i]['Cnt'] = $Rs1[0]['Cnt'];
            }
            $data = array(
                'part' => $part,
                'tData' =>$totalarr
            );
        }




        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'part_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include//footer_View');

    }

    public function Age(){

        $syear = ($this->input->post('syear')) ? $this->input->post('syear') : '2010';
        $eyear = ($this->input->post('eyear')) ? $this->input->post('eyear') : '2010';

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'data_m');
        $Rs = $this->data_m->member_Birth();

        $option1 = '';
        $option2 = '';
        foreach($Rs as $d){
            if(!empty($d['cbirth'])){
                if($d['cbirth']==$syear){
                    $option1 .= "<option value='".$d['cbirth']."' selected>".Normal_Make_age($d['cbirth'])."세</option>";
                }else{
                    $option1 .= "<option value='".$d['cbirth']."' >".Normal_Make_age($d['cbirth'])."세</option>";
                }

                if($d['cbirth']==$eyear){
                    $option2 .= "<option value='".$d['cbirth']."' selected>".Normal_Make_age($d['cbirth'])."세</option>";
                }else{
                    $option2 .= "<option value='".$d['cbirth']."' >".Normal_Make_age($d['cbirth'])."세</option>";
                }

            }
        }

        $date1 = $eyear.'0101';
        $date2 = $syear.'1231';

        $Rs = $this->data_m->age_Data($date1,$date2);
        $totalCnt = 0;

        for($i=0;$i<=9;$i++){
            $graph[$i]['title'] = '';
            $graph[$i]['Cnt'] = '';
        }

        $i = 0;
        foreach($Rs as $d){
            if(!empty($d['title'])) {
                $totalCnt = $totalCnt + $d['Cnt'];

                if ($i <= 8) {
                    $graph[$i]['title'] = $d['title'];
                    $graph[$i]['Cnt'] = $d['Cnt'];
                } else {
                    $graph[$i]['title'] = '기타';
                    $graph[$i]['Cnt'] = $graph[$i]['Cnt'] + $d['Cnt'];
                }

                $i<9 ? $i++ : $i=9;
            }
        }

        $data = array(
            'data' => $Rs,
            'total' => $totalCnt,
            'option1' => $option1,
            'option2' => $option2,
            'graph' => $graph
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'age_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include//footer_View');


    }

    public function SearchTitle(){
        $sword = urldecode($this->uri->segment(3));

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');
        $Rs = $this->Cartoon_m->Load_Cartoon_like($sword);

        $data = array(
            'data' => $Rs
        );


        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'search_title_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }


//    public function ToonView(){
//        $sdate = $this->uri->segment(3);
//        $edate = $this->uri->segment(4);
//
//
//        $syear = ($sdate =='') ? date("Y") : substr($sdate,0,4);
//        $smonth = ($sdate =='') ? date("m") : substr($sdate,4,2);
//        $sday = ($sdate =='') ? date("d") : substr($sdate,6,2);
//        $sdatestr = $syear."-".$smonth."-".$sday;
//
//        $eyear = ($edate =='') ? date("Y") : substr($edate,0,4);
//        $emonth = ($edate =='') ? date("m") : substr($edate,4,2);
//        $eday = ($edate =='') ? date("d") : substr($edate,6,2);
//        $edatestr = $eyear."-".$emonth."-".$eday;
//
//
//
//
//
//
//
//
//        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
//        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');
//
//        $Cartoon = $this->Cartoon_m->Load_Cartoon_All();
//        $OtionStr = '';
//        if(ArrayCount($Cartoon)>0){
//            foreach($Cartoon as $d){
//                if($pcode==$d['code']){
//                   $OtionStr .= "<option value='".$d['code']."' selected>".$d['title']."</option>";
//                }else{
//                   $OtionStr .= "<option value='".$d['code']."' >".$d['title']."</option>";
//                }
//            }
//        }
//
//        for ($day = 1; $day <= $maxDay; $day++) {
//            $sdate = $year . "-" . $month . '-' . sprintf('%02d', $day);
//            $Viewarr[sprintf('%02d', $day)]['sdate'] = $sdate;
//            $Viewarr[sprintf('%02d', $day)]['cnt'] = 0;
//        }
//
//        if($pcode!='') {
//            $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
//            $title = (ArrayCount($info) > 0) ? $info[0]['title'] : '';
//            $TotalView = 0;
//            $Rs = $this->dashboard_m->View_data_Cnt5($pcode,$sdatestr);
//            if(ArrayCount($Rs)>0){
//                foreach($Rs as $v){
//                    $sdate2 = $v['m'];
//
//                    $Viewarr[$sdate2]['cnt'] = $v['Cnt'];
//                    $TotalView = $TotalView + $v['Cnt'];
//                }
//            }
//        }else{
//            $title = '';
//            $TotalView = 0;
//        }
//
//        $sessionArr = Get_AdminSe_Data($this);
//        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
//        $hearder_Data = array(
//            'grade' => Load_Grade($this,$uid)
//        );
//
//        $RetVal = array(
//            'pcode' => $pcode,
//            'option' => $OtionStr,
//            'year' =>$year,
//            'month' =>$month,
//            'title' => $title,
//            'data' => $Viewarr,
//            'Total' => $TotalView,
//            'maxday' => $maxDay
//        );
//
//        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
//        $this->load->view(CMS_VIEW_ROOT.'toon_Cnt_View',$RetVal);
//        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
//
//    }

    public function ToonView(){
        $pcode = $this->uri->segment(3);
        $year = $this->uri->segment(4);
        $month = $this->uri->segment(5);


        $year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(5);
        $sdatestr = $year."-".$month;

        $maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');

        $Cartoon = $this->Cartoon_m->Load_Cartoon_All();
        $OtionStr = '';
        if(ArrayCount($Cartoon)>0){
            foreach($Cartoon as $d){
                if($pcode==$d['code']){
                    $OtionStr .= "<option value='".$d['code']."' selected>".$d['title']."</option>";
                }else{
                    $OtionStr .= "<option value='".$d['code']."' >".$d['title']."</option>";
                }
            }
        }

        for ($day = 1; $day <= $maxDay; $day++) {
            $sdate = $year . "-" . $month . '-' . sprintf('%02d', $day);
            $Viewarr[sprintf('%02d', $day)]['sdate'] = $sdate;
            $Viewarr[sprintf('%02d', $day)]['cnt'] = 0;
        }

        if($pcode!='') {
            $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
            $title = (ArrayCount($info) > 0) ? $info[0]['title'] : '';
            $TotalView = 0;
            $Rs = $this->dashboard_m->View_data_Cnt5($pcode,$sdatestr);
            if(ArrayCount($Rs)>0){
                foreach($Rs as $v){
                    $sdate2 = $v['m'];

                    $Viewarr[$sdate2]['cnt'] = $v['Cnt'];
                    $TotalView = $TotalView + $v['Cnt'];
                }
            }
        }else{
            $title = '';
            $TotalView = 0;
        }

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $RetVal = array(
            'pcode' => $pcode,
            'option' => $OtionStr,
            'year' =>$year,
            'month' =>$month,
            'title' => $title,
            'data' => $Viewarr,
            'Total' => $TotalView,
            'maxday' => $maxDay
        );



        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'toon_Cnt_View',$RetVal);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }

    public function Analytics1(){


        $pcode = $this->uri->segment(3);
        $year = $this->uri->segment(4);
        $month = $this->uri->segment(5);


        $year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(5);
        $sdatestr = $year."-".$month;

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');

        $Cartoon = $this->Cartoon_m->Load_Cartoon_All();
        $OtionStr = '';
        if(ArrayCount($Cartoon)>0){
            foreach($Cartoon as $d){
                if($pcode==$d['code']){
                    $OtionStr .= "<option value='".$d['code']."' selected>".$d['title']."</option>";
                }else{
                    $OtionStr .= "<option value='".$d['code']."' >".$d['title']."</option>";
                }
            }
        }

        $Viewarr = array();
        $total1 = 0;
        $total2 = 0;
        if($pcode!='') {
            $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
            $title = (ArrayCount($info) > 0) ? $info[0]['title'] : '';

            $maxSub = $this->Cartoon_m->Cnt_Sub_Cartoon($pcode);



            for($i=1;$i<=$maxSub;$i++){
                $Viewarr['val1_'.fn_formatZero($i,2)] = 0;
                $Viewarr['val2_'.fn_formatZero($i,2)] = 0;
            }



            $this->load->model(CMS_MODEL_ROOT . 'dashboard_m');
            $Rs = $this->dashboard_m->Analytics1($pcode, $sdatestr);
            foreach($Rs as $d){
                $Viewarr['val1_'.fn_formatZero($d['ccode'],2)] = $d['Cnt1'];
                $Viewarr['val2_'.fn_formatZero($d['ccode'],2)] = $d['Cnt2'];

                $total1  = $total1 + $d['Cnt1'];
                $total2  = $total2 + $d['Cnt2'];

            }
        }else{
            $title = '';
            $maxSub = 0;
        }

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $RetVal = array(
            'pcode' => $pcode,
            'option' => $OtionStr,
            'year' =>$year,
            'month' =>$month,
            'title' => $title,
            'data' => $Viewarr,
            'total1' => $total1,
            'total2' => $total2,
            'maxday' => $maxSub
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'toon_Cnt2_View',$RetVal);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }

    public function Analytics2(){


        $pcode = $this->uri->segment(3);
        $year = $this->uri->segment(4);
        $month = $this->uri->segment(5);


        $year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(5);
        $sdatestr = $year."-".$month;

        $this->load->model(CMS_MODEL_ROOT.'dashboard_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');

        $Cartoon = $this->Cartoon_m->Load_Cartoon_All();
        $OtionStr = '';
        if(ArrayCount($Cartoon)>0){
            foreach($Cartoon as $d){
                if($pcode==$d['code']){
                    $OtionStr .= "<option value='".$d['code']."' selected>".$d['title']."</option>";
                }else{
                    $OtionStr .= "<option value='".$d['code']."' >".$d['title']."</option>";
                }
            }
        }

        $Viewarr = array();
        $totalfree = 0;
        $totalcash = 0;
        if($pcode!='') {
            $info = $this->Cartoon_m->Load_Cartoon_Code($pcode);
            $title = (ArrayCount($info) > 0) ? $info[0]['title'] : '';

            $maxSub = $this->Cartoon_m->Cnt_Sub_Cartoon($pcode);
            for($i=1;$i<=$maxSub;$i++){
                $Rs = $this->dashboard_m->Analytics2($pcode,$i,$sdatestr);
                //var_dump($Rs);
                if(ArrayCount($Rs)>0){
                    $temparr = array();
                    $temparr1 = array();
                    foreach($Rs as $d){
                        $temparr['sn'] = $d['sn'];
                        $temparr['free'] = $d['free'];
                        $temparr['cash'] = $d['cash'];

                        $totalfree = $totalfree + $d['free'];
                        $totalcash = $totalcash + $d['cash'];

                        array_push($temparr1,$temparr);
                    }

                    $Viewarr['data_'.fn_formatZero($i,2)] = $temparr1;
                }else{
                    $Viewarr['data_'.fn_formatZero($i,2)] = array();
                }

            }

        }else{
            $title = '';
            $maxSub = 0;
        }

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $RetVal = array(
            'pcode' => $pcode,
            'option' => $OtionStr,
            'year' =>$year,
            'month' =>$month,
            'title' => $title,
            'total1' => $totalfree,
            'total2' => $totalcash,
            'data' => $Viewarr,
            'maxday' => $maxSub
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'toon_Cnt3_View',$RetVal);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }


}