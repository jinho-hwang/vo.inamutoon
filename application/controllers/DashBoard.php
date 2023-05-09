<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashBoard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		TMSLogin($this);
    }

	public function index(){

		redirect(ROOT_URL.'DashBoard/Data');
	}


	public function Data()
	{
		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);

		$today = date("Y")."-". date("m")."-".date("d");
		$sdate = $year."-".$month;
		$maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

		$this->load->model(CMS_MODEL_ROOT.'dashboard_m');



		for($i=1;$i<=$maxDay;$i++) {
			empty($XValue) ? $XValue =$i :  $XValue .= ','.$i;
			$reg[$i]['date'] = $i . '일';
			$reg[$i]['cnt1'] = 0;
			$reg[$i]['cnt2'] = 0;
			$reg[$i]['cnt3'] = 0;
			$reg[$i]['cnt4'] = 0;
			$reg[$i]['cnt5'] = 0;
			$reg[$i]['cnt6'] = 0;
            $reg[$i]['cnt7'] = 0;
			$reg[$i]['sum1'] = 0;
			$reg[$i]['sum2'] = 0;
			$reg[$i]['sum3'] = 0;
			$coupon[$i]['date'] = $i . '일';
			$coupon[$i]['cnt'] = 0;
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,1);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt1'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,2);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt2'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,3);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt3'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,4);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt4'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,5);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt5'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Month_MemberReg_Load($sdate,6);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt6'] = $val['Cnt'];
		}

        $Rs = $this->dashboard_m->Month_MemberReg_Load2($sdate);
        foreach($Rs as $val){
            $location = (int)$val['chk'];
            $reg[$location]['cnt7'] = $val['Cnt'];
        }

		$Rs = $this->dashboard_m->Month_Charge_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum1'] = $val['Sell'];
		}

		$Rs = $this->dashboard_m->Month_Coin_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum2'] = $val['Sell']*CASHBYCOIN;
		}

		$Rs = $this->dashboard_m->Month_Free_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum3'] = $val['Sell']*CASHBYCOIN;
		}

		$couponTotal = 0;
		$Rs = $this->dashboard_m->View_data_Coupon($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$coupon[$location]['cnt'] = $val['Cnt'];
			$couponTotal = $couponTotal +  $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Today_memberReg_Cnt($today);
		$todayCnt = (ArrayCount($Rs)>0) ? $Rs[0]['Cnt'] : 0;





//		$darr = array(167,168,169,170,171,188,196,198,199);
//		$dRs1 = array();
//		$dRs2 = array();
//		$dRs3 = array();
//		$dRs4 = array();
//		$dRs5 = array();
//		$dRs6 = array();
//		$dRs7 = array();
//		$dRs8 = array();
//		$dRs9 = array();
//		for($i=0;$i<=ArrayCount($darr)-1;$i++){
//			$Rs = $this->dashboard_m->View_data_Cnt2($darr[$i],$sdate);
//			if(ArrayCount($Rs)>0){
//				$k=0;
//				foreach($Rs as $v){
//					${'dRs'.$i}[$k]['sdate'] = $v['m'];
//					${'dRs'.$i}[$k]['title'] = $v['title'];
//					${'dRs'.$i}[$k]['cnt'] = $v['Cnt'];
//					$k++;
//				}
//			}
//		}



		$charge = 0;
		$coin = 0;
		$free = 0;
		$sum1 = 0;
		$sum2 = 0;
		$sum3 = 0;
		$sum4 = 0;
		$sum5 = 0;
		$sum6 = 0;

		foreach($reg as $d){
			$value1 = $d['cnt1'];
			$value2 = $d['cnt2'];
			$value3 = $d['cnt3'];
			$value4 = $d['cnt4'];
			$value5 = $d['cnt5'];
			$value9 = $d['cnt6'];
            $value10 = $d['cnt7'];
			$sum1 = $sum1 + $value1;
			$sum2 = $sum2 + $value2;
			$sum3 = $sum3 + $value3;
			$sum4 = $sum4 + $value4;
			$sum5 = $sum5 + $value5;
			$sum6 = $sum6 + $value9;
			$value6 = $d['sum1'];
			$value7 = $d['sum2'];
			$value8 = $d['sum3'];


			empty($MCnt1) ? $MCnt1 ='['.$value1 :  $MCnt1 .= ','.$value1;
			empty($MCnt2) ? $MCnt2 ='['.$value2 :  $MCnt2 .= ','.$value2;
			empty($MCnt3) ? $MCnt3 ='['.$value3 :  $MCnt3 .= ','.$value3;
			empty($MCnt4) ? $MCnt4 ='['.$value4 :  $MCnt4 .= ','.$value4;
			empty($MCnt5) ? $MCnt5 ='['.$value5 :  $MCnt5 .= ','.$value5;
			empty($MCnt6) ? $MCnt6 ='['.$value9 :  $MCnt6 .= ','.$value9;
            empty($MCnt7) ? $MCnt7 ='['.$value10 :  $MCnt7 .= ','.$value10;
			empty($ASum1) ? $ASum1 ='['.$sum1 :  $ASum1 .= ','.$sum1;
			empty($ASum2) ? $ASum2 ='['.$sum2 :  $ASum2 .= ','.$sum2;
			empty($ASum3) ? $ASum3 ='['.$sum3 :  $ASum3 .= ','.$sum3;
			empty($ASum4) ? $ASum4 ='['.$sum4 :  $ASum4 .= ','.$sum4;
			empty($ASum5) ? $ASum5 ='['.$sum5 :  $ASum5 .= ','.$sum5;

			empty($MSum1) ? $MSum1 ='['.$value6 :  $MSum1 .= ','.$value6;
			empty($MSum2) ? $MSum2 ='['.$value7 :  $MSum2 .= ','.$value7;
			empty($MSum3) ? $MSum3 ='['.$value8 :  $MSum3 .= ','.$value8;
			$charge = $charge + $value6;
			$coin = $coin + $value7;
			$free = $free + $value8;
		}

		foreach($coupon as $d){
			$value1 = $d['cnt'];

			empty($Mcoupon) ? $Mcoupon ='['.$value1 :  $Mcoupon .= ','.$value1;
		}


		$MCnt1 .=']';
		$MCnt2 .=']';
		$MCnt3 .=']';
		$MCnt4 .=']';
		$MCnt5 .=']';
		$MCnt6 .=']';
        $MCnt7 .=']';
		$ASum1 .=']';
		$ASum2 .=']';
		$ASum3 .=']';
		$ASum4 .=']';
		$ASum5 .=']';
		$MSum1 .=']';
		$MSum2 .=']';
		$MSum3 .=']';
		$Mcoupon .=']';

		$RetVal = array(
				'year' =>$year,
				'month' =>$month,
				'Xvalue' => $XValue,
				'MCnt1' => $MCnt1,
				'MCnt2' => $MCnt2,
				'MCnt3' => $MCnt3,
				'MCnt4' => $MCnt4,
				'MCnt5' => $MCnt5,
				'MCnt6' => $MCnt6,
                'MCnt7' => $MCnt7,
				'ASum1' => $ASum1,
				'ASum2' => $ASum2,
				'ASum3' => $ASum3,
				'ASum4' => $ASum4,
				'ASum5' => $ASum5,
				'TSum1' => $sum1,
				'TSum2' => $sum2,
				'TSum3' => $sum3,
				'TSum4' => $sum4,
				'TSum5' => $sum5,
				'MSum1' => $MSum1,
				'MSum2' => $MSum2,
				'MSum3' => $MSum3,
				'charge' => $charge,
				'coin' => $coin,
				'free' =>$free,
				'totalmember' => $sum1 + $sum2 + $sum3 + $sum4 + $sum5 + $sum6 ,
				'today' => $today,
				'totalToday' => $todayCnt,
				'coupon' => $Mcoupon,
				'couponTotal' =>$couponTotal
		);


		$sessionArr = Get_AdminSe_Data($this);
		$sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
		$hearder_Data = array(
				'grade' => Load_Grade($this,$uid)
		);

		$this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
		$this->load->view(CMS_VIEW_ROOT.'dashboard_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');
	}

	public function Year()
	{
		$year = $this->uri->segment(3);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);

		$sdate = $year;
		$maxMonth =12;

		$this->load->model(CMS_MODEL_ROOT.'dashboard_m');

		for($i=1;$i<=$maxMonth;$i++) {
			empty($XValue) ? $XValue =$i :  $XValue .= ','.$i;
			$reg[$i]['date'] = $i . '월';
			$reg[$i]['cnt1'] = 0;
			$reg[$i]['cnt2'] = 0;
			$reg[$i]['sum1'] = 0;
			$reg[$i]['sum2'] = 0;
			$reg[$i]['sum3'] = 0;
		}

		$Rs = $this->dashboard_m->Year_MemberReg_Load($sdate,1);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt1'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Year_MemberReg_Load($sdate,2);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['cnt2'] = $val['Cnt'];
		}

		$Rs = $this->dashboard_m->Year_Charge_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum1'] = $val['Sell'];
		}

		$Rs = $this->dashboard_m->Year_Coin_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum2'] = $val['Sell']*CASHBYCOIN;
		}

		$Rs = $this->dashboard_m->Year_Free_Load($sdate);
		foreach($Rs as $val){
			$location = (int)$val['chk'];
			$reg[$location]['sum3'] = $val['Sell']*CASHBYCOIN;
		}


		$inamuCnt = 0;
		$goyangCnt = 0;
		$charge = 0;
		$coin = 0;
		$free =0;
		foreach($reg as $d){
			$value1 = $d['cnt1'];
			$value2 = $d['cnt2'];
			$sum = $value1 + $value2;
			$value3 = $d['sum1'];
			$value4 = $d['sum2'];
			$value5 = $d['sum3'];


			empty($MCnt1) ? $MCnt1 ='['.$value1 :  $MCnt1 .= ','.$value1;
			empty($MCnt2) ? $MCnt2 ='['.$value2 :  $MCnt2 .= ','.$value2;
			empty($MCnt3) ? $MCnt3 ='['.$sum :  $MCnt3 .= ','.$sum;
			empty($MSum1) ? $MSum1 ='['.$value3 :  $MSum1 .= ','.$value3;
			empty($MSum2) ? $MSum2 ='['.$value4 :  $MSum2 .= ','.$value4;
			empty($MSum3) ? $MSum3 ='['.$value5 :  $MSum3 .= ','.$value5;
			$inamuCnt = $inamuCnt + $value1;
			$goyangCnt = $goyangCnt +$value2;
			$charge = $charge + $value3;
			$coin = $coin + $value4;
			$free = $free + $value5;
		}
		$MCnt1 .=']';
		$MCnt2 .=']';
		$MCnt3 .=']';
		$MSum1 .=']';
		$MSum2 .=']';
		$MSum3 .=']';

		$RetVal = array(
				'year' =>$year,
				'Xvalue' => $XValue,
				'MCnt1' => $MCnt1,
				'MCnt2' => $MCnt2,
				'MCnt3' => $MCnt3,
				'MSum1' => $MSum1,
				'MSum2' => $MSum2,
				'MSum3' => $MSum3,
				'inamuCnt' => $inamuCnt,
				'goyangCnt' => $goyangCnt,
				'charge' => $charge,
				'coin' => $coin,
				'free' =>$free,
				'totalmember' => $inamuCnt + $goyangCnt
		);





		$sessionArr = Get_AdminSe_Data($this);
		$sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
		$hearder_Data = array(
				'grade' => Load_Grade($this,$uid)
		);

		$this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
		$this->load->view(CMS_VIEW_ROOT.'dashboard_Year_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');
	}



	public function dnMonthExcel(){
		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);
		$stype = $this->uri->segment(5);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);
		$stype =='' ? $stype=1 : $stype = $this->uri->segment(5);

		$sdate = $year."-".$month;


		$this->load->model(CMS_MODEL_ROOT.'Dashboard_m');

		$this->load->library('excel');
		# 자료 가져오기
		$Rs = $this->Dashboard_m->Data_Load_All($sdate,$stype);
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


		if($stype==1) {
			$filename = 'sale_AllList_' . $sdate . '.xls';
		}else if($stype==2) {
			$filename = 'sale_CashList_' . $sdate . '.xls';
		}else if($stype==3) {
			$filename = 'sale_FreeList_' . $sdate . '.xls';
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		# Excel5 포맷(excel 2003 .XLS file)으로 저장한다.
		# 두 번째 매개변수를 'Excel2007'로 바꾸면 Excel 2007 .XLSX 포맷으로 저장한다.
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		# 이용자가 다운로드하여 컴퓨터 HD에 저장하도록 강제한다.
		$objWriter->save('php://output');

	}



	public function Summary(){
		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);


		$sdate = $year."-".$month;

		$this->load->model(CMS_MODEL_ROOT.'Dashboard_m');
		$Rs = $this->Dashboard_m->Load_buy_Log($sdate);

		$chargeAr = Summary_Cash_Log($Rs);

		$Rs = $this->Dashboard_m->Cnt_Buy_Log($sdate,1);
		$cashCnt = $Rs[0]['Cnt'];
		$Rs = $this->Dashboard_m->Cnt_Buy_Log($sdate,2);
		$freeCnt = $Rs[0]['Cnt'];
		$Rs = $this->Dashboard_m->Cnt_Buy_Log($sdate,3);
		$splitCnt = $Rs[0]['Cnt'];
		$Rs = $this->Dashboard_m->Cnt_View_Log($sdate);
		$viewCnt = $Rs[0]['Cnt'];


		$RetVal = array(
				'year' =>$year,
				'month' =>$month,
				'charge' => $chargeAr,
				'cashCnt' =>$cashCnt,
				'freeCnt' => $freeCnt,
				'viewCnt' => $viewCnt,
				'splitCnt' =>$splitCnt,
		);

		$sessionArr = Get_AdminSe_Data($this);
		$sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
		$hearder_Data = array(
				'grade' => Load_Grade($this,$uid)
		);

		$this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
		$this->load->view(CMS_VIEW_ROOT.'sale_summary_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');

	}

	public function DataList()
	{
		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);
		$stype = $this->uri->segment(5);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);
		$stype =='' ? $stype=1 : $stype = $this->uri->segment(5);

		//$sdate = $year."-".$month;

		$RetVal = array(
			'year' =>$year,
			'month' =>$month,
			'stype' => $stype
		);

		$sessionArr = Get_AdminSe_Data($this);
		$sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
		$hearder_Data = array(
				'grade' => Load_Grade($this,$uid)
		);

		$this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
		$this->load->view(CMS_VIEW_ROOT.'sale_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');
	}

	public function Data_Load(){

		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);
		$stype = $this->uri->segment(5);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);
		$stype =='' ? $stype=1 : $stype = $this->uri->segment(5);

		$sdate = $year."-".$month;

		$page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'Dashboard_m');
        $count = $this->Dashboard_m->all_count($sdate,$stype);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Dashboard_m->Data_Load($sdate,$stype,$start, $limit, $sidx, $sord);
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


	public function ToonView(){


		$year = $this->uri->segment(3);
		$month = $this->uri->segment(4);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(3);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(4);
		$sdatestr = $year."-".$month;

		$maxDay = date("t", mktime(0, 0, 0, $month, 1, $year));

		$this->load->model(CMS_MODEL_ROOT.'dashboard_m');
		$this->load->model(CMS_MODEL_ROOT.'Cartoon_m');

		$Rs = $this->Cartoon_m->Load_CartoonList_type(2);
		if(ArrayCount($Rs)>0) {

			$darr = array();

			for($i=0;$i<=(ArrayCount($Rs)-1);$i++){
				$darr[$i] = $Rs[$i]['code'];
			}

			//$darr = array(196, 168, 198, 199, 171, 176, 177, 178, 179, 209, 181, 210, 211, 212, 185, 186, 187, 213, 190, 191, 192, 214, 194, 195, 188, 201, 202, 203, 215, 205, 216, 207, 217, 167, 169, 170, 180, 182, 183, 184, 189, 193, 204, 206, 208);


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
			$this->load->view(CMS_VIEW_ROOT . 'inden_toon_View', $RetVal);
			$this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
		}

	}





}