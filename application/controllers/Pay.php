<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic','security','url'));
        $this->load->library('session');
        TMSLogin($this);
    }
    
	public function index(){
		
	}


    public function Charge_Load(){

        $sdate = $this->uri->segment(3);
        $edate = $this->uri->segment(4);

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $count = $this->Pay_m->pay_count($sdate,$edate);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Pay_m->Data_Load($sdate,$edate,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(

                    $row->sn, $row->userid, $row->price.'원',$row->log,$row->regidate
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

    public function Detail(){

        $post = array();
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        empty($post['syear']) ? $syear =  date("Y") : $syear = $post['syear'];
        empty($post['smonth']) ? $smonth =  date("m") : $smonth = $post['smonth'];
        empty($post['sday']) ? $sday =  date("d") : $sday = $post['sday'];
        //$smaxDay = date("t", mktime(0, 0, 0, $smonth, 1, $syear));
        $smaxDay = 31;
        $sdate = $syear.'-'.$smonth.'-'.$sday;

        empty($post['eyear']) ? $eyear =  date("Y") : $eyear = $post['eyear'];
        empty($post['emonth']) ? $emonth =  date("m") : $emonth = $post['emonth'];
        //$emaxDay = date("t", mktime(0, 0, 0, $emonth, 1, $eyear));
        $emaxDay = 31;
        empty($post['eday']) ? $eday =  date("d") : $eday = $post['eday'];

        $edate = $eyear.'-'.$emonth.'-'.$eday;



        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $Rs = $this->Pay_m->priod_price_Sum($sdate,$edate);
        if(ArrayCount($Rs)<=0){
            $sum = 0;
            $cnt = 0;
        }else{
            $sum = $Rs[0]['sum'];
            $cnt =$Rs[0]['Cnt'];
        }


        $data = array(
            'sdate' => $sdate,
            'edate' => $edate,
            'syear' => $syear,
            'smonth' => $smonth,
            'sday' => $sday,
            'eyear' =>$eyear,
            'emonth' =>$emonth,
            'eday' => $eday,
            'smaxDay' => $smaxDay,
            'emaxDay' => $emaxDay,
            'sum' => $sum,
            'Cnt' => $cnt

        );


        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'charge_detail',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }

    public function Summary()
    {
        $year = $this->uri->segment(3);
        $month = $this->uri->segment(4);


        $year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(4);

        $sdate = $year."-".$month.'-01';
        $maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));
        $edate = $year."-".$month.'-'.$maxDay;


        $this->load->model(CMS_MODEL_ROOT.'pay_m');

        for($i=1;$i<=$maxDay;$i++) {
            empty($XValue) ? $XValue =$i :  $XValue .= ','.$i;
            $reg[$i]['date'] = $i . '일';
            $reg[$i]['sum'] = 0;
        }

        $Rs = $this->pay_m->Month_Charge_List($sdate,$edate);
        $Tcnt = 0;
        foreach($Rs as $val){
            $location = (int)$val['chk'];
            $reg[$location]['sum'] = $val['sum'];
            $Tcnt = $Tcnt + $val['Cnt'];
        }

        $charge = 0;
        foreach($reg as $d){
            $value = $d['sum'];
            empty($MSum1) ? $MSum1 ='['.$value :  $MSum1 .= ','.$value;
            $charge = $charge + $value;
        }
        $MSum1 .=']';
        $RetVal = array(
            'year' =>$year,
            'month' =>$month,
            'Xvalue' => $XValue,
            'MSum' => $MSum1,
            'charge' => $charge,
            'Tcnt' => $Tcnt
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'charge_View',$RetVal);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }


	
    public function MemberList()
    {
        $userid = $this->input->post('userid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $year =='' ? $year = date("Y") : $year = $this->input->post('year');
        $month =='' ? $month = date("m") : $month = $this->input->post('month');

        $sdate = $year."-".$month;


        if($userid ==''){
            $data = array(
                'userid'=>'',
                'uid'=>0,
                'cash'=>0,
                'free' => 0,
                'year' => $year,
                'month' =>$month
            );
        }else{
            $this->load->model(CMS_MODEL_ROOT.'Member_m');
            $Rs = $this->Member_m->Load_member_userid($userid);
            if(ArrayCount($Rs)<=0){
                $data = array(
                    'userid'=>'',
                    'uid'=>0,
                    'cash'=>0,
                    'free' => 0,
                    'year' => $year,
                    'month' =>$month
                );
            }else{
                $uid = $Rs[0]['uid'];
                $this->load->model(CMS_MODEL_ROOT.'Pay_m');
                $Rs = $this->Pay_m->Member_Buy_List_Sum($uid,$sdate);

                $data = array(
                    'userid'=>$userid,
                    'uid'=>$uid,
                    'cash'=>$Rs[0]['cash'],
                    'free' => $Rs[0]['free'],
                    'year' => $year,
                    'month' =>$month
                );
            }
        }

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'memberlist_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }
	
	public function MemberList_Data(){

		$uid = $this->uri->segment(3);
        $year = $this->uri->segment(4);
        $month = $this->uri->segment(5);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(5);

        $sdate = $year."-".$month;

		
		$page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
       
        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $count = $this->Pay_m->all_count_uid($uid,$sdate);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Pay_m->Member_Load($uid,$sdate,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->userid,$row->title,$row->wname,$row->payType,$row->cash,$row->rate,$row->free,$row->log,$row->regidate
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

    public function WriterDetailList(){
        $wid = $this->uri->segment(3);
        $pcode = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);

        $year =='' ? $year = date("Y") : $this->uri->segment(5);
        $month =='' ? $month = date("m") : $this->uri->segment(6);


        $this->load->model(CMS_MODEL_ROOT.'Writer_m');
        $writer = $this->Writer_m->Load_All();

        $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');
        $cartoon = $this->Cartoon_m->Load_Cartoon_Wid($wid);


        $data = array(
            'wid'=>$wid,
            'Writer' =>	$writer,
            'pcode' => $pcode,
            'cartoon' =>$cartoon,
            'year' => $year,
            'month' => $month
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'writerList_Detail_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

    }


	public function WriterList()
    {

        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $year =='' ? $year = date("Y") : $year = $this->input->post('year');
        $month =='' ? $month = date("m") : $month = $this->input->post('month');

        $sdate = $year."-".$month;

        $this->load->model(CMS_MODEL_ROOT.'Writer_m');
        $writer = $this->Writer_m->Load_All();

        $wid = $this->input->post('wid');
        $pcode = $this->input->post('pcode');
        $pcode =='' ? $pcode =0 : $pcode = $this->input->post('pcode');
        if($wid ==''){
            $data = array(
                'wid'=>0,
                'Writer' =>	$writer,
                'year' => $year,
                'month' => $month,
                'pcode' => $pcode
            );
        }else{
            $this->load->model(CMS_MODEL_ROOT.'Cartoon_m');
            $cartoon = $this->Cartoon_m->Load_Cartoon_Wid($wid);

            $this->load->model(CMS_MODEL_ROOT.'Pay_m');
            $Rs = $this->Pay_m->Load_buy_Log_Writer($wid,$sdate,$pcode);

            $chargeAr = Summary_Cash_Log($Rs);

            $Rs = $this->Pay_m->Cnt_Buy_Log($sdate,$wid,$pcode,1);
            $cashCnt = $Rs[0]['Cnt'];
            $Rs = $this->Pay_m->Cnt_Buy_Log($sdate,$wid,$pcode,2);
            $freeCnt = $Rs[0]['Cnt'];
            $Rs = $this->Pay_m->Cnt_Buy_Log($sdate,$wid,$pcode,3);
            $splitCnt = $Rs[0]['Cnt'];
            $Rs = $this->Pay_m->Cnt_View_Log($sdate,$wid,$pcode);
            $viewCnt = $Rs[0]['Cnt'];


            $data = array(
                'wid'=>$wid,
                'Writer' =>	$writer,
                'pcode' => $pcode,
                'cartoon' =>$cartoon,
                'year' => $year,
                'month' => $month,
                'charge' =>$chargeAr,
                'cashCnt' => $cashCnt,
                'freeCnt' =>$freeCnt,
                'splitCnt' =>$splitCnt,
                'viewCnt' =>$viewCnt
            );
        }
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'writerlist_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }
	
	public function WriterList_Data(){
		
		$wid = $this->uri->segment(3);
        $pcode = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(5);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(6);

        $sdate = $year."-".$month;
		
		$page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
       
        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $count = $this->Pay_m->all_count_wid($wid,$sdate,$pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Pay_m->Writer_Load($wid,$sdate,$pcode,$start, $limit, $sidx, $sord);
		if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->userid,$row->title,$row->wname,$row->payType,$row->cash,$row->rate,$row->free,$row->log,$row->regidate
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

    public function dnMemberExcel(){
        $uid = $this->uri->segment(3);
        $year = $this->uri->segment(4);
        $month = $this->uri->segment(5);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(5);

        $sdate = $year."-".$month;


        $this->load->model(CMS_MODEL_ROOT.'Pay_m');

        $this->load->library('excel');
        # 자료 가져오기
        $Rs = $this->Pay_m->Data_Load_All($uid,$sdate);
        $result = $Rs->result();
        # 시트지정
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Sheet1');
        # cell 헤더 설정
        $this->excel->getActiveSheet()->setCellValue('A1', '순번');
        $this->excel->getActiveSheet()->setCellValue('B1', '아이디');
        $this->excel->getActiveSheet()->setCellValue('C1', '타이틀');
        $this->excel->getActiveSheet()->setCellValue('D1', '작가명');
        $this->excel->getActiveSheet()->setCellValue('E1', '충전방법');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Cash');
        $this->excel->getActiveSheet()->setCellValue('G1', '수수료');
        $this->excel->getActiveSheet()->setCellValue('H1', '무료Cash');
        $this->excel->getActiveSheet()->setCellValue('I1', '로그');
        $this->excel->getActiveSheet()->setCellValue('J1', '일자');
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
        # cell 병합
        //$this->excel->getActiveSheet()->mergeCells('A1:D1');
        # 헤더 컬럼 가운데 정렬
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        # cell 데이터 출력
        $n=2;
        foreach($result as $row) {
            $this->excel->getActiveSheet()->setCellValue('A' . $n, $row->sn);
            $this->excel->getActiveSheet()->setCellValue('B' . $n, $row->userid);
            $this->excel->getActiveSheet()->setCellValue('C' . $n, $row->title);
            $this->excel->getActiveSheet()->setCellValue('D' . $n, $row->wname);
            if($row->payType==1){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE1_NAME);
            }else if($row->payType==2){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE2_NAME);
            }else if($row->payType==3){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE3_NAME);
            }else if($row->payType==4) {
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE4_NAME);
            }

            $this->excel->getActiveSheet()->setCellValue('F' . $n, number_format($row->cash*100));
            $this->excel->getActiveSheet()->setCellValue('G' . $n, ($row->rate/100));
            $this->excel->getActiveSheet()->setCellValue('H' . $n, $row->free);
            $this->excel->getActiveSheet()->setCellValue('I' . $n, $row->log);
            $this->excel->getActiveSheet()->setCellValue('J' . $n, $row->regidate);

            $n++;
        }



        $filename = 'sale_MemberList_' . $sdate . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function dnWriterExcel(){
        $wid = $this->uri->segment(3);
        $pcode = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);

        $year =='' ? $year = date("Y") : $year = $this->uri->segment(5);
        $month =='' ? $month = date("m") : $month = $this->uri->segment(6);

        $sdate = $year."-".$month;


        $this->load->model(CMS_MODEL_ROOT.'Pay_m');

        $this->load->library('excel');
        # 자료 가져오기
        $Rs = $this->Pay_m->WriterData_Load_All($wid,$sdate,$pcode);
        $result = $Rs->result();
        # 시트지정
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Sheet1');
        # cell 헤더 설정
        $this->excel->getActiveSheet()->setCellValue('A1', '순번');
        $this->excel->getActiveSheet()->setCellValue('B1', '아이디');
        $this->excel->getActiveSheet()->setCellValue('C1', '타이틀');
        $this->excel->getActiveSheet()->setCellValue('D1', '작가명');
        $this->excel->getActiveSheet()->setCellValue('E1', '충전방법');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Cash');
        $this->excel->getActiveSheet()->setCellValue('G1', '수수료');
        $this->excel->getActiveSheet()->setCellValue('H1', '무료Cash');
        $this->excel->getActiveSheet()->setCellValue('I1', '로그');
        $this->excel->getActiveSheet()->setCellValue('J1', '일자');
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
        # cell 병합
        //$this->excel->getActiveSheet()->mergeCells('A1:D1');
        # 헤더 컬럼 가운데 정렬
        $this->excel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        # cell 데이터 출력
        $n=2;
        foreach($result as $row) {
            $this->excel->getActiveSheet()->setCellValue('A' . $n, $row->sn);
            $this->excel->getActiveSheet()->setCellValue('B' . $n, $row->userid);
            $this->excel->getActiveSheet()->setCellValue('C' . $n, $row->title);
            $this->excel->getActiveSheet()->setCellValue('D' . $n, $row->wname);
            if($row->payType==1){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE1_NAME);
            }else if($row->payType==2){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE2_NAME);
            }else if($row->payType==3){
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE3_NAME);
            }else if($row->payType==4) {
                $this->excel->getActiveSheet()->setCellValue('E' . $n, CHARGE4_NAME);
            }

            $this->excel->getActiveSheet()->setCellValue('F' . $n, number_format($row->cash*100));
            $this->excel->getActiveSheet()->setCellValue('G' . $n, ($row->rate/100));
            $this->excel->getActiveSheet()->setCellValue('H' . $n, $row->free);
            $this->excel->getActiveSheet()->setCellValue('I' . $n, $row->log);
            $this->excel->getActiveSheet()->setCellValue('J' . $n, $row->regidate);

            $n++;
        }



        $filename = 'sale_writerList_' . $sdate . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function balanceList(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $Rs = $this->Pay_m->balance_Sum_Load();
        $sum = (ArrayCount($Rs)>0) ? $Rs[0]['cash_sum'] : 0;

        $data = array(
            'sum' => $sum
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'balance_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
    }


    public function balance_Data_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'Pay_m');
        $count = $this->Pay_m->all_count_balanse();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Pay_m->balance_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->uid;
                $response->rows[$i]['cell'] = array(
                    $row->uid,$row->userid,$row->cash,$row->mCash
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



}