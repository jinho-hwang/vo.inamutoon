<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counsel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function BList(){
        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . '/Login', 'refresh');
        } else {
            $typ=$this->input->post('typ');
            $tstr=$this->input->post('tstr');
            $sdate = $this->input->post('sdate');
            $edate = $this->input->post('edate');

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this,$uid)
            );

            $page = $this->uri->segment(3);
            empty($page) ? $page = 1 : $page = $this->uri->segment(3);

            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $this->load->model(CMS_MODEL_ROOT . 'Cartoon_m');
            $total = $this->Counsel_m->all_count1();

            $per_page = (empty($tsrt)) ? 30 : 100;
            $num_links = 4;

            $this->load->library('pagination');
            $config['base_url'] = ROOT_URL.'Counsel/BList/';
            $config['total_rows'] = $total;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = $num_links;
            $config['per_page'] = $per_page;
            $config['page_query_string'] = FALSE;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);

            $start = ($page - 1) * $per_page;
            $limit = $per_page;
            $Rs = $this->Counsel_m->Data_List_Load($tstr,$start, $limit);

            $List = array();
            foreach($Rs as $d){
                $temparr = array();

                $temparr['cid'] = $d['cid'];
                $temparr['title'] = $d['title'];
                $temparr['pNum'] = $d['pNum'];

                $new_sub = $this->Cartoon_m->Load_Sub_Title_Down($d['pCode'],$d['pNum']);
                $temparr['subname'] = (ArrayCount($new_sub)>0) ? Sub_Last_Name($new_sub[0]) : '';
                $temparr['sdate'] = String_Nomal_Left($d['startdate'],10);
                $temparr['edate'] = String_Nomal_Left($d['enddate'],10);
                $temparr['status'] = Counsel_Step($d['isStatus']);
                $temparr['isStatus'] = $d['isStatus'];

                if($d['isStatus']<=2){
                    $gmember = $this->Counsel_m->Cnt_Counsel_Member($d['cid'],0);
                    $gmemberA = $this->Counsel_m->Cnt_Counsel_Member_Answer($d['cid'],0);
                    ($gmemberA>=$gmember)? $gtype = 1 : $gtype = 0;
                }else if($d['isStatus']==3){
                    $gtype = 2;
                }else{
                    $gtype = 3;
                }
                $temparr['gtype'] = $gtype;

                if($d['isStatus']==4 || $d['isStatus']==5){
                    $emember = $this->Counsel_m->Cnt_Counsel_Member($d['cid'],1);
                    $ememberA = $this->Counsel_m->Cnt_Counsel_Member_Answer($d['cid'],1);
                    ($ememberA>=$emember)? $etype = 1 : $etype = 0;
                }else if($d['isStatus']==7 || $d['isStatus']==8){
                    $emember = $this->Counsel_m->Cnt_Counsel_Member($d['cid'],1);
                    $ememberA = $this->Counsel_m->Cnt_Counsel_Member_Answer($d['cid'],1);
                    ($ememberA>=$emember)? $etype = 1 : $etype = 0;
                }else{
                    $etype = 2;
                }
                $temparr['etype'] = $etype;

                if($d['isStatus']==6) {
                    $itype = 1;
                }else if($d['isStatus']==9) {
                    $itype = 1;
                }else{
                    $itype = 0;
                }
                $temparr['itype'] = $itype;


                array_push($List,$temparr);
            }

            if(empty($sdate) || empty($edate)){
                $sdate = date("Y-m-d");
                $edate = date("Y-m-d");

                $syear = date("Y");
                $smonth = date("m");
                $sday = date("d");
                $eyear = date("Y");
                $emonth = date("m");
                $eday = date("d");

            }else{


                $syear = date("Y",strtotime($sdate));
                $smonth = date("m",strtotime($sdate));
                $sday = date("d",strtotime($sdate));
                $eyear = date("Y",strtotime($edate));
                $emonth = date("m",strtotime($edate));
                $eday = date("d",strtotime($edate));
            }

            $syear_str = '';
            for($i=2019;$i<=2021;$i++){
                if($i==$syear){
                    $syear_str .= "<option value='".$i."' selected>".$i."</option>";
                }else{
                    $syear_str .= "<option value='".$i."'>".$i."</option>";
                }
            }

            $smonth_str= '';
            for($i=1;$i<=12;$i++){
                if($i==$smonth){
                    $smonth_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
                }else{
                    $smonth_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
                }
            }

            $sday_str= '';
            for($i=1;$i<=31;$i++){
                if($i==$sday){
                    $sday_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
                }else{
                    $sday_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
                }
            }


            $eyear_str = '';
            for($i=2019;$i<=2021;$i++){
                if($i==$eyear){
                    $eyear_str .= "<option value='".$i."' selected>".$i."</option>";
                }else{
                    $eyear_str .= "<option value='".$i."'>".$i."</option>";
                }
            }

            $emonth_str= '';
            for($i=1;$i<=12;$i++){
                if($i==$emonth){
                    $emonth_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
                }else{
                    $emonth_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
                }
            }

            $eday_str= '';
            for($i=1;$i<=31;$i++){
                if($i==$eday){
                    $eday_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
                }else{
                    $eday_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
                }
            }




            $data = array(
                'typ' => 0,
                'tstr' => $tstr,
                'data' => $List,
                'page' => $this->pagination->create_links(),
                'typ' =>$typ,
                'tstr' =>$tstr,
                'sdate' => $sdate,
                'edate' => $edate,
                'syear' =>$syear_str,
                'smonth' =>$smonth_str,
                'sday' =>$sday_str,
                'eyear' =>$eyear_str,
                'emonth' =>$emonth_str,
                'eday' =>$eday_str
            );

            $this->load->view(CMS_VIEW_ROOT . 'include/header_View',$hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'counsel2_list_View',$data);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');

        }
    }



    public function index(){
        $typ=$this->input->post('typ');
        $tstr=$this->input->post('tstr');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid),
            'tstr' =>$tstr
        );


        $this->load->model('common_m');
        $counsel_selectbox = $this->common_m->counsel_selectbox();
        $cartoon_selectbox = $this->common_m->cartoon_selectbox_All();


        if(empty($sdate) || empty($edate)){
            $sdate = date("Y-m-d");
            $edate = date("Y-m-d");

            $syear = date("Y");
            $smonth = date("m");
            $sday = date("d");
            $eyear = date("Y");
            $emonth = date("m");
            $eday = date("d");

        }else{


            $syear = date("Y",strtotime($sdate));
            $smonth = date("m",strtotime($sdate));
            $sday = date("d",strtotime($sdate));
            $eyear = date("Y",strtotime($edate));
            $emonth = date("m",strtotime($edate));
            $eday = date("d",strtotime($edate));
        }

        $syear_str = '';
        for($i=2019;$i<=2021;$i++){
            if($i==$syear){
                $syear_str .= "<option value='".$i."' selected>".$i."</option>";
            }else{
                $syear_str .= "<option value='".$i."'>".$i."</option>";
            }
        }

        $smonth_str= '';
        for($i=1;$i<=12;$i++){
            if($i==$smonth){
                $smonth_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
            }else{
                $smonth_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
            }
        }

        $sday_str= '';
        for($i=1;$i<=31;$i++){
            if($i==$sday){
                $sday_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
            }else{
                $sday_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
            }
        }


        $eyear_str = '';
        for($i=2019;$i<=2021;$i++){
            if($i==$eyear){
                $eyear_str .= "<option value='".$i."' selected>".$i."</option>";
            }else{
                $eyear_str .= "<option value='".$i."'>".$i."</option>";
            }
        }

        $emonth_str= '';
        for($i=1;$i<=12;$i++){
            if($i==$emonth){
                $emonth_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
            }else{
                $emonth_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
            }
        }

        $eday_str= '';
        for($i=1;$i<=31;$i++){
            if($i==$eday){
                $eday_str .= "<option value='".fn_formatZero($i,2)."' selected>".$i."</option>";
            }else{
                $eday_str .= "<option value='".fn_formatZero($i,2)."'>".$i."</option>";
            }
        }

        $data = array(
            'cartoon' => $cartoon_selectbox,
            'member' =>$counsel_selectbox,
            'typ' =>$typ,
            'tstr' =>$tstr,
            'sdate' => $sdate,
            'edate' => $edate,
            'syear' =>$syear_str,
            'smonth' =>$smonth_str,
            'sday' =>$sday_str,
            'eyear' =>$eyear_str,
            'emonth' =>$emonth_str,
            'eday' =>$eday_str
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'counsel1_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }


    public function Excel(){

        $mtyp = $this->uri->segment(3);
        $sdate = $this->uri->segment(4);
        $edate = $this->uri->segment(5);


        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');

        $this->load->library('excel');
        # 자료 가져오기
        $Rs = $this->Counsel_m->Load_Excel_List($mtyp, $sdate,$edate);
        $result = $Rs->result();
        # 시트지정
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Sheet1');
        $this->excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0');
        # cell 헤더 설정
        $this->excel->getActiveSheet()->setCellValue('A1', ' NO');
        $this->excel->getActiveSheet()->setCellValue('B1', ' 작품명');
        $this->excel->getActiveSheet()->setCellValue('C1', '시스템회차');
        $this->excel->getActiveSheet()->setCellValue('D1', '회차');
        $this->excel->getActiveSheet()->setCellValue('E1', '자문위원');
        $this->excel->getActiveSheet()->setCellValue('F1', '감수내용');
        $this->excel->getActiveSheet()->setCellValue('G1', '감수결과');
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
        # cell 병합
        //$this->excel->getActiveSheet()->mergeCells('A1:D1');
        # 헤더 컬럼 가운데 정렬
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        # cell 데이터 출력
        $n = 2;
        foreach ($result as $row) {
            $new_sub = $this->Cartoon_m->Load_Sub_Title_Down($row->pCode,$row->pNum);
            if(ArrayCount($new_sub)>0) {
                $last_name = Sub_Last_Name($new_sub[0]);
            }else{
                $last_name = '';
            }

            $comment = $row->Comment;
            $temparr = explode('<br />',$comment);
            if(ArrayCount($temparr) <= 0){
                $this->excel->getActiveSheet()->setCellValue('A' . $n, $n-1);
                $this->excel->getActiveSheet()->setCellValue('B' . $n, $row->title);
                $this->excel->getActiveSheet()->setCellValue('C' . $n, $row->pNum);
                $this->excel->getActiveSheet()->setCellValue('D' . $n, $last_name);
                $this->excel->getActiveSheet()->setCellValue('E' . $n, $row->wname);
                $this->excel->getActiveSheet()->setCellValue('F' . $n, $row->Comment);

                if($row->c_result == 0){
                    $this->excel->getActiveSheet()->setCellValue('G' . $n, '미검수');
                }else if($row->c_result == 1){
                    $this->excel->getActiveSheet()->setCellValue('G' . $n, '적합');
                }else if($row->c_result == 2) {
                    $this->excel->getActiveSheet()->setCellValue('G' . $n, '부적합');
                }

                $n++;
            }else{
                foreach($temparr as $d){
                    $this->excel->getActiveSheet()->setCellValue('A' . $n, $n-1);
                    $this->excel->getActiveSheet()->setCellValue('B' . $n, $row->title);
                    $this->excel->getActiveSheet()->setCellValue('C' . $n, $row->pNum);
                    $this->excel->getActiveSheet()->setCellValue('D' . $n, $last_name);
                    $this->excel->getActiveSheet()->setCellValue('E' . $n, $row->wname);
                    $this->excel->getActiveSheet()->setCellValue('F' . $n, $d);


                    if($row->c_result == 0){
                        $this->excel->getActiveSheet()->setCellValue('G' . $n, '미검수');
                    }else if($row->c_result == 1){
                        $this->excel->getActiveSheet()->setCellValue('G' . $n, '적합');
                    }else if($row->c_result == 2) {
                        $this->excel->getActiveSheet()->setCellValue('G' . $n, '부적합');
                    }


                    $n++;
                }
            }
        }

        if($mtyp==0) {
            $filename = 'EBSTOON_자문위원_컨텐츠_감수_리스트' . $sdate . '.xls';
        }else{
            $filename = 'EBSTOON_EBS위원_컨텐츠_감수_리스트' . $sdate . '.xls';
        }



        header('Content-Type: application/vnd.ms-excel:charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');

    }


    public function Reset_Com(){
        $cid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $sn = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $data = array(
            'ctyp' => 0,
            'isStatus'=>0
        );
        $Cnt = $this->Counsel_m->Update_Counsel_list($sn,$data);

        alert('success','/Counsel/View_Counsel/'.$cid);

    }

    public function View_Counsel(){
        $cid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');

        $Rs = $this->Counsel_m->Load_Counsel($cid);
        if(ArrayCount($Rs)>0){
            $title = $Rs[0]['cname'];
            $pNum = $Rs[0]['pNum'];
            $isStatus = $Rs[0]['isStatus'];
        }


        if($isStatus<3) {
            $Rs = $this->Counsel_m->Load_Counsel_Member_Date($cid, 0);
            if (ArrayCount($Rs) > 0) {
                $ein=array();
                $i=0;
                foreach($Rs as $d){
                    if($d['isStatus']<3){
                        $ein[$i] = $d['wid'];
                        $i++;
                    }
                }

                $param = array(
                    'Comment' =>'',
                    'c_result' => 1,
                    'isStatus' => 3,
                    'enddate' => date("Y-m-d H:i:s")
                );
                $Cnt = $this->Counsel_m->Update_Counsel_Recom($cid,$ein,$param);

                $Rs = $this->Counsel_m->Load_Counsel_memberType($cid,1);
                if(ArrayCount($Rs)>0){
                    $ein = array();
                    $i=0;
                    foreach($Rs as $d){
                        $ein[$i] = $d['wid'];
                        $i++;
                    }
                    if(ArrayCount($ein)>0){
                        $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,4);
                        $param = array('isStatus'=>1);
                        $Cnt = $this->Counsel_m->Update_Counsel_Recom($cid,$ein,$param);
                    }
                }
            }
        }


        $gmember = $this->Counsel_m->Load_Counsel_Member($cid,0);
        $emember = $this->Counsel_m->Load_Counsel_Member($cid,1);
        $recom = $this->Counsel_m->Load_Counsel_Recom($cid);



        $data = array(
            'title' => $title,
            'pNum' => $pNum,
            'cid' => $cid,
            'gmember' => $gmember,
            'emember' => $emember,
            'isStatus' => $isStatus,
            'recom' => $recom
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'counsel_data_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }

    public function Ready_Open(){
        $cid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $Rs = $this->Counsel_m->Load_Counsel($cid);
        if(ArrayCount($Rs)>0) {
            $isStatus = $Rs[0]['isStatus'];
        }else{
            $isStatus = 0;
        }

        if($isStatus==6||$isStatus==9){
            $Cnt =$this->Counsel_m->Update_Counsel_Status($cid,10);

            alert_refresh_close('success');
        }else{
            alert('잘못된 접근입니다.');
        }

    }

    public function Re_Open(){
        $cid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $Rs = $this->Counsel_m->Load_Counsel($cid);
        if(ArrayCount($Rs)>0) {
            $isStatus = $Rs[0]['isStatus'];
        }else{
            $isStatus = 0;
        }

        if($isStatus==6||$isStatus==9){

            $Rs = $this->Counsel_m->Load_Counsel_memberType($cid,1);
            if(ArrayCount($Rs)>0){
                $ein = array();
                $i=0;
                foreach($Rs as $d){
                    $data = array();
                    if($d['c_result']==2){
                        $data = array(
                            'wid' => $d['wid'],
                            'cid' => $cid,
                            'Comment' => $d['Comment']
                        );
                        $Cnt = $this->Counsel_m->Insert_Counsel_Recom($data);
                    }
                    $ein[$i] = $d['wid'];
                    $i++;
                }
            }

            $param = array(
                'Comment' =>'',
                'c_result' => 0,
                'isStatus' => 1,
                'enddate' => ''
            );
            $Cnt = $this->Counsel_m->Update_Counsel_Recom($cid,$ein,$param);

            $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,7);

            alert_refresh_close('success');
        }else{
            alert('잘못된 접근입니다.');
        }


    }

    public function Reg_Counsel(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $g_member = '';
        $e_member = '';
        $cartoon = '';

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $Rs = $this->Counsel_m->Cartoon_Load2();
        if(ArrayCount($Rs)>0) {
            $cartoon = '<option value="">선택하세요.</option>';
            foreach ($Rs as $d) {
                $cartoon .= '<option value="' . $d['code'] . '">' . $d['title'] . '</option>';
            }
        }

        $this->load->model(CMS_MODEL_ROOT.'CMember_m');
        $Rs = $this->CMember_m->Load_Member_Type(0);
        if(ArrayCount($Rs)>0){
            $g_member = '<option value="">선택하세요.</option>';
            foreach($Rs as $d){
                $g_member .= '<option value="'.$d['code'].'">'.$d['wname'].'</option>';
            }
        }
        $Rs = $this->CMember_m->Load_Member_Type(1);
        if(ArrayCount($Rs)>0){
            $e_member = '<option value="">선택하세요.</option>';
            foreach($Rs as $d){
                $e_member .= '<option value="'.$d['code'].'">'.$d['wname'].'</option>';
            }
        }


        $manager_date = date("Y-m-d", strtotime("+21 days"));
        $counsel_date = date("Y-m-d", strtotime("+7 days"));
        $ebs_date = date("Y-m-d", strtotime("+14 days"));


        $data = array(
            'g_member' => $g_member,
            'e_member' => $e_member,
            'cartoon' => $cartoon,
            'manager_date' => $manager_date,
            'counsel_date' => $counsel_date,
            'ebs_date' => $ebs_date
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'counsel_reg_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function View_All(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/non_header_View',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'counsel_All_View');
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }

    public function Mod_All(){
        foreach ($this->input->post() as $k_val => $value) {
            $post[$k_val] = $value;
        }

        if(empty($post)) {
            alert_close('필수 정보 입력 확인하세요.');
        }else {
            $mtyp = $post['mtyp'];
            $styp = $post['styp'];
            $sdate = $post['sdate'];
            $cidin = $post['cidin'];


            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $cid = explode(',',$cidin);
            for($i=0;$i<=ArrayCount($cid)-1;$i++){
                $nid = $cid[$i];
                if($nid<>'') {
                    if($styp==1){
                        $Rs = $this->Counsel_m->Load_Counsel_memberType($nid, $mtyp);
                        if(ArrayCount($Rs)>0) {
                            foreach($Rs as $d){
                                $data = array(
                                    'reqenddate' => $sdate
                                );
                                $Cnt = $this->Counsel_m->Update_Counsel_list($d['sn'],$data);
                            }
                        }
                    }else if($styp==2) {
                        $Rs = $this->Counsel_m->Load_Counsel_memberType($nid, $mtyp);
                        if(ArrayCount($Rs)>0) {
                            foreach($Rs as $d){
                                $data = array(
                                    'isStatus' => 1,
                                    'reqenddate' => $sdate
                                );
                                $Cnt = $this->Counsel_m->Update_Counsel_list($d['sn'],$data);
                            }
                        }
                        $Cnt = $this->Counsel_m->Update_Counsel_Status($nid,4);
                    }else if($styp==3) {
                        $data = array(
                            'enddate' => $sdate
                        );
                        $Cnt = $this->Counsel_m->Update_Counsel_list2($nid,$data);
                    }
                }
            }

            alert_close('success');
        }
    }

    public function Reg_Data(){
        foreach ($this->input->post() as $k_val => $value) {
            $post[$k_val] = $value;
        }

        if(empty($post)) {
            alert_close('필수 정보 입력 확인하세요.');
        }else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');

            $manager_date = (!empty($post['date1'])) ? $post['date1'] :  date("Y-m-d", strtotime("+21 days"));
            $counsel_date = (!empty($post['date2'])) ? $post['date2'] :  date("Y-m-d", strtotime("+7 days"));
            $ebs_date = (!empty($post['date3'])) ? $post['date3'] :  date("Y-m-d", strtotime("+14 days"));


            if (!strpos($post['pNum'], '-')) {
                $Cnt = $this->Counsel_m->Cnt_Counsel($post['pCode'], $post['pNum']);
                if ($Cnt > 0) {
                    alert_close('이미 등록된 감수 목록 입니다.');
                } else {

                    $data = array(
                        'pCode' => $post['pCode'],
                        'pNum' => $post['pNum'],
                        'gCnt' => 0,
                        'eCnt' => 0,
                        'isStatus' => 1,
                        'isActive' => 1,
                        'enddate' => $manager_date
                    );


                    $cid = $this->Counsel_m->Insert_Counsel($data);
                    if ($cid > 0) {
                        $arr_gmember = $post['gmember'];
                        $gCnt = ArrayCount($arr_gmember);
                        if ($gCnt > 0) {
                            for ($i = 0; $i <= ($gCnt - 1); $i++) {
                                $gmember = array();
                                if ($arr_gmember[$i] != '') {
                                    $gmember['wid'] = $arr_gmember[$i];
                                    $gmember['cid'] = $cid;
                                    $gmember['Comment'] = '';
                                    $gmember['c_result'] = 0;
                                    $gmember['isStatus'] = 1;
                                    $gmember['reqenddate'] = $counsel_date;

                                    $Cnt = $this->Counsel_m->Insert_Counsel_GMember($gmember);
                                }
                            }

                            $Cnt = $this->Counsel_m->Update_Counsel_Cnt(1, $cid, $gCnt);
                        }

                        $arr_emember = $post['emember'];
                        $eCnt = ArrayCount($arr_emember);
                        if ($eCnt > 0) {
                            $emember = array();
                            for ($i = 0; $i <= ($eCnt - 1); $i++) {
                                if ($arr_emember[$i] != '') {
                                    $emember['wid'] = $arr_emember[$i];
                                    $emember['cid'] = $cid;
                                    $emember['Comment'] = '';
                                    $emember['c_result'] = 0;
                                    $gmember['isStatus'] = 0;
                                    $emember['reqenddate'] = $ebs_date;

                                    $Cnt = $this->Counsel_m->Insert_Counsel_GMember($emember);
                                }
                            }
                            $Cnt = $this->Counsel_m->Update_Counsel_Cnt(2, $cid, $eCnt);
                        }
                    }
                }
            } else {

                $temp = explode('-', $post['pNum']);
                $start = $temp[0];
                $end = $temp[1];

                if (!is_numeric($start) || !is_numeric($end)) {
                    alert_close('잘못된 회자 정포 입니다. 확인하세요.');
                } else {
                    for ($k = $start; $k <= $end; $k++) {
                        $Cnt = $this->Counsel_m->Cnt_Counsel($post['pCode'], $k);
                        if ($Cnt <= 0) {
                            $data = array(
                                'pCode' => $post['pCode'],
                                'pNum' => $k,
                                'gCnt' => 0,
                                'eCnt' => 0,
                                'isStatus' => 1,
                                'isActive' => 1,
                                'enddate' => $manager_date
                            );

                            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
                            $cid = $this->Counsel_m->Insert_Counsel($data);
                            if ($cid > 0) {
                                $arr_gmember = $post['gmember'];
                                $gCnt = ArrayCount($arr_gmember);
                                if ($gCnt > 0) {
                                    for ($i = 0; $i <= $gCnt; $i++) {
                                        $gmember = array();
                                        if ($arr_gmember[$i] != '') {
                                            $gmember['wid'] = $arr_gmember[$i];
                                            $gmember['cid'] = $cid;
                                            $gmember['Comment'] = '';
                                            $gmember['c_result'] = 0;
                                            $gmember['isStatus'] = 1;
                                            $gmember['reqenddate'] = $counsel_date;

                                            $Cnt = $this->Counsel_m->Insert_Counsel_GMember($gmember);
                                        }
                                    }
                                    $Cnt = $this->Counsel_m->Update_Counsel_Cnt(1, $cid, $gCnt);
                                }

                                $arr_emember = $post['emember'];
                                $eCnt = ArrayCount($arr_emember);
                                if ($eCnt > 0) {
                                    for ($i = 0; $i <= $eCnt; $i++) {
                                        $emember = array();
                                        if ($arr_emember[$i] != '') {
                                            $emember['wid'] = $arr_emember[$i];
                                            $emember['cid'] = $cid;
                                            $emember['Comment'] = '';
                                            $emember['c_result'] = 0;
                                            $gmember['isStatus'] = 0;
                                            $emember['reqenddate'] = $ebs_date;

                                            $Cnt = $this->Counsel_m->Insert_Counsel_GMember($emember);
                                        }
                                    }
                                }
                                $Cnt = $this->Counsel_m->Update_Counsel_Cnt(2, $cid, $eCnt);
                            }
                        }
                    }
                }
            }
            alert_refresh_close('success');
        }
    }


    public function Member(){

        $cid = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $Rs = $this->Counsel_m->Load_Counsel($cid);
        if(ArrayCount($Rs)>0){
            $title = $Rs[0]['cname'];
            $pNum = $Rs[0]['pNum'];
        }

        $data = array(
            'title' => $title,
            'pNum' => $pNum,
            'cid' => $cid
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'counsel_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }




    public function AData_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';


        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $count = $this->Counsel_m->all_count1();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Counsel_m->Data_Load1($start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->cid;
                $response->rows[$i]['cell'] = array(
                    $row->cid,$row->pCode,$row->pNum,String_Nomal_Left($row->startdate,10),String_Nomal_Left($row->enddate,10),$row->isStatus,$row->cid,$row->cid
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


    public function Data_Load(){

        $cid = ($this->input->post('cid')) ? $this->input->post('cid') : 0;
        $typ = ($this->input->post('typ')) ? $this->input->post('typ') : 0;
        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';


        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'Counsel_m');
        $count = $this->Counsel_m->all_count($cid,$typ,$tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Counsel_m->Data_Load($cid,$typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->mtyp,$row->wname,$row->isStatus,String_Nomal_Left($row->regidate,10),String_Nomal_Left($row->reqenddate,10),String_Nomal_Left($row->enddate,10),$row->Comment,$row->c_result
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
            $message = 'Not Input Parameter';
        } else {

            if(!strpos($post['pNum'],'-')){

                $data = array(
                    'wid' => $post['wid'],
                    'pCode' => $post['pCode'],
                    'pNum' => $post['pNum'],
                    'Comment' => '',
                    'c_result' => 0
                );

                $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
                if ($insert_id = $this->Counsel_m->Data_Add($data)) {
                    $result = true;
                    $message = 'Success';
                } else {
                    $result = false;
                    $message = 'Fail!!';
                }
            }else{
                $temp = explode('-',$post['pNum']);
                $start = $temp[0];
                $end = $temp[1];

                if(!is_numeric($start) || !is_numeric($end)){
                    $result = false;
                    $message = 'Fail!!';
                }else{
                    for($i=$start;$i<=$end;$i++){

                        $data = array(
                            'wid' => $post['wid'],
                            'pCode' => $post['pCode'],
                            'pNum' => $i,
                            'Comment' => '',
                            'c_result' => 0
                        );


                        $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
                        if ($insert_id = $this->Counsel_m->Data_Add($data)) {
                            $result = true;
                            $message = 'Success';
                        } else {
                            $result = false;
                            $message = 'Fail!!';
                        }
                    }
                }
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $post['sn'],
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
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $affected_rows = $this->Counsel_m->Data_Update($post);

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

    public function Data_Delete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $affected_rows = $this->Counsel_m->Data_Del($post['id']);

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

    public function Act_do(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $retval = '';
            $message = 'Not Input Parameter';
        } else {

            if($post['act']==0){
                $act = 1;
            }else if($post['act']==1){
                $act = 0;
            }

            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $affected_rows = $this->Counsel_m->Data_Update2($post['sn'],$act);

            if ($affected_rows > 0) {
                $retval = $post['sn'];
                $message = 'success';
            } else {
                $retval = '';
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'status' => $message,
            'code' => $retval
        ));
    }

    public function Process_Step(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = 'error';
            $status = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $mtyp = $post['mtyp'];
            $cid = $post['cid'];
            $Rs = $this->Counsel_m->Load_Counsel($cid);
            if(ArrayCount($Rs)>0) {
                $isStatus = $Rs[0]['isStatus'];
            }else{
                $isStatus = 0;
            }


            $Rs = $this->Counsel_m->Load_Complete($cid,$mtyp);
            if(ArrayCount($Rs)>0){
                foreach($Rs as $d){
                    $param = array(
                        'isStatus'=>3,
                        'ctyp' => 1,
                        'enddate' => date("Y-m-d H:i:s")
                    );
                    $Cnt = $this->Counsel_m->Complete_Update($d['sn'],$param);
                }
            }

            if($isStatus==7 ){
                $Cnt = $this->Counsel_m->Update_Counsel_Status($cid, 8);
            }else {
                if ($mtyp == 0) {
                    $Cnt = $this->Counsel_m->Update_Counsel_Status($cid, 2);
                } else if ($mtyp == 1) {
                    $Cnt = $this->Counsel_m->Update_Counsel_Status($cid, 5);
                }
            }

            $result = 'ok';
            $status = $isStatus;
            $message = 'Success';
        }

        echo json_encode(array(
            'result' => $result,
            'status' => $isStatus,
            'message' => $message
        ));
    }

    public function Process_Step2(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = 'error';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $step = $post['step'];
            $cid = $post['cid'];
            if($step==4){
                $Rs = $this->Counsel_m->Load_Complete($cid,1);
                if(ArrayCount($Rs)>0){
                    foreach($Rs as $d){
                        $param = array(
                            'isStatus'=>1
                        );
                        $Cnt = $this->Counsel_m->Complete_Update($d['sn'],$param);
                    }
                }
            }
            $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,$step);



            $result = 'ok';
            $message = 'Success';
        }

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }

    public function Process_Step3(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = 'error';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $cid = $post['cid'];
            $Rs = $this->Counsel_m->Load_Counsel($cid);
            if(ArrayCount($Rs)>0) {
                $isStatus = $Rs[0]['isStatus'];
            }else{
                $isStatus = 0;
            }

            if($isStatus==6||$isStatus==9){
                $Cnt =$this->Counsel_m->Update_Counsel_Status($cid,10);

                $result = 'ok';
                $message = 'Success';
            }else{
                $result = 'error1';
                $message = 'Not Data';
            }

        }

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }

    public function Process_Step4(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = 'error';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $cid = $post['cid'];
            $Rs = $this->Counsel_m->Load_Counsel($cid);
            if(ArrayCount($Rs)>0) {
                $isStatus = $Rs[0]['isStatus'];
            }else{
                $isStatus = 0;
            }

            if($isStatus==6||$isStatus==9){
                $Rs = $this->Counsel_m->Load_Counsel_memberType($cid,1);
                if(ArrayCount($Rs)>0){
                    $ein = array();
                    $i=0;
                    foreach($Rs as $d){
                        $data = array();
                        if($d['c_result']==2){
                            $data = array(
                                'wid' => $d['wid'],
                                'cid' => $cid,
                                'Comment' => $d['Comment']
                            );
                            $Cnt = $this->Counsel_m->Insert_Counsel_Recom($data);
                        }
                        $ein[$i] = $d['wid'];
                        $i++;
                    }
                }

                $param = array(
                    'Comment' =>'',
                    'c_result' => 0,
                    'isStatus' => 1,
                    'enddate' => ''
                );
                $Cnt = $this->Counsel_m->Update_Counsel_Recom($cid,$ein,$param);

                $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,7);

                $result = 'ok';
                $message = 'Success';
            }else{
                $result = 'error1';
                $message = 'Not Data';
            }

        }

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }

    public function Schedule_Other(){
        $mtyp = 0;

        $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
        $nowComplete = $this->Counsel_m->Load_Counsel_Schedule($mtyp);
        if(ArrayCount($nowComplete) > 0){
            foreach($nowComplete as $d){
                $param = array(
                    'isStatus' => 3,
                    'ctyp' => 1,
                    'enddate' => date("Y-m-d H:i:s")
                );
                $Cnt = $this->Counsel_m->Complete_Update($d['sn'], $param);
            }
        }

        $disComplete = $this->Counsel_m->Load_Counsel_Schedule_distict($mtyp,2);
        if(ArrayCount($disComplete) > 0){
            foreach($disComplete as $d){
                $cid = $d['Cid'];
                $Rs = $this->Counsel_m->Load_Counsel_SN($cid);
                if(ArrayCount($Rs)>0) {
                    $gCnt = $Rs[0]['gCnt'];

                    $Rs = $this->Counsel_m->Cnt_End_Counsel($cid, $mtyp);
                    $Cnt1 = (ArrayCount($Rs) > 0) ? $Rs[0]['Cnt'] : 0;
                    if ($Cnt1 >= $gCnt) {
                        $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,3);
                    }
                }
            }
        }

        $result = 'ok';
        $message = 'Success';

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }

    public function Schedule_Enter(){
        $mtyp = 1;

        $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
        $nowComplete = $this->Counsel_m->Load_Counsel_Schedule($mtyp);
        if(ArrayCount($nowComplete) > 0){
            foreach($nowComplete as $d){
                $param = array(
                    'isStatus' => 3,
                    'ctyp' => 1,
                    'enddate' => date("Y-m-d H:i:s")
                );
                $Cnt = $this->Counsel_m->Complete_Update($d['sn'], $param);
            }
        }

        $disComplete = $this->Counsel_m->Load_Counsel_Schedule_distict($mtyp,5);
        if(ArrayCount($disComplete) > 0){
            foreach($disComplete as $d){
                $cid = $d['Cid'];
                $Rs = $this->Counsel_m->Load_Counsel_SN($cid);
                if(ArrayCount($Rs)>0) {
                    $eCnt = $Rs[0]['eCnt'];

                    $Rs = $this->Counsel_m->Cnt_End_Counsel($cid, $mtyp);
                    $Cnt1 = (ArrayCount($Rs) > 0) ? $Rs[0]['Cnt'] : 0;
                    if ($Cnt1 >= $eCnt) {
                        $Cnt = $this->Counsel_m->Update_Counsel_Status($cid,6);
                    }
                }
            }
        }

        $result = 'ok';
        $message = 'Success';

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }

    public function Process_Del(){
        $cid = $this->input->post("cid");

        if (empty($cid)) {
            $result = 'error';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $Rs = $this->Counsel_m->Load_Counsel($cid);
            if(ArrayCount($Rs)<=0) {
                $result = 'error1';
                $message = 'NotFound';
            }else if($Rs[0]['isStatus']!=1){
                $result = 'error2';
                $message = 'NotStep';
            }else{
                $Cnt = $this->Counsel_m->Data_Del($cid);

                $result = 'ok';
                $message = 'Success';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'message' => $message
        ));
    }


}