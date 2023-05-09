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

	public function dnMonthExcel(){
		$year = $this->uri->segment(4);
		$month = $this->uri->segment(5);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(5);

		$sdate = $year."-".$month;

		$this->load->model(SHOP_MODEL_ROOT.'Dashboard_m');

		$this->load->library('excel');
		# 자료 가져오기
		$Rs = $this->Dashboard_m->Sum_Order_Total1($sdate);
		$result = $Rs->result();


		# 시트지정
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Sheet1');
		# cell 헤더 설정
		$this->excel->getActiveSheet()->setCellValue('A1', '순번');
		$this->excel->getActiveSheet()->setCellValue('B1', '주문번호');
		$this->excel->getActiveSheet()->setCellValue('C1', '아이디');
		$this->excel->getActiveSheet()->setCellValue('D1', '상품가격');
		$this->excel->getActiveSheet()->setCellValue('E1', '배송비');
		$this->excel->getActiveSheet()->setCellValue('F1', '쿠폰할인액');
		$this->excel->getActiveSheet()->setCellValue('G1', '충전사용액');
		$this->excel->getActiveSheet()->setCellValue('H1', '결제방법');
		$this->excel->getActiveSheet()->setCellValue('I1', '일자');
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
			$this->excel->getActiveSheet()->setCellValue('B' . $n, $row->oCode);
			$this->excel->getActiveSheet()->setCellValue('C' . $n, $row->userid);
			$this->excel->getActiveSheet()->setCellValue('D' . $n, number_format($row->totalprice));
			$this->excel->getActiveSheet()->setCellValue('E' . $n, number_format($row->totaldelivery));
			$this->excel->getActiveSheet()->setCellValue('F' . $n, number_format($row->totalsale));
			$this->excel->getActiveSheet()->setCellValue('G' . $n, number_format($row->totalpoint));
			if($row->payType==0){
				$this->excel->getActiveSheet()->setCellValue('H' . $n, '신용카드');
			}
			$this->excel->getActiveSheet()->setCellValue('I' . $n, $row->regidate);
			$n++;
		}



		$filename = 'MDShop_SaleList_' . $sdate . '.xls';

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
		$year = $this->uri->segment(4);
		$month = $this->uri->segment(5);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(5);


		$sdate = $year."-".$month;

		$this->load->model(SHOP_MODEL_ROOT.'Dashboard_m');
		$Rs = $this->Dashboard_m->Sum_Order_Total($sdate);

		$total_real = ($Rs[0]['total1'] - ($Rs[0]['total3']+$Rs[0]['total4']));
		$total_share1 = $total_real * (SHOP_RATE*0.01);
		$total_share2 = $total_real - $total_share1;

		$RetVal = array(
				'year' =>$year,
				'month' =>$month,
				'total_real' => $total_real,
				'totalprice' => $Rs[0]['total1'],
				'totaldel' => $Rs[0]['total2'],
				'totalsale' => $Rs[0]['total3'],
				'totalpoint' => $Rs[0]['total4'],
				'totalCnt' => $Rs[0]['cnt'],
				'total_amount' =>$total_share2,
				'total_share' =>$total_share1
		);

		$sessionArr = Get_AdminSe_Data($this);
		$sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
		$hearder_Data = array(
				'grade' => Load_Grade($this,$uid)
		);

		$this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
		$this->load->view(SHOP_VIEW_ROOT.'shop_summary_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');

	}

	public function DataList()
	{
		$year = $this->uri->segment(4);
		$month = $this->uri->segment(5);
		$stype = $this->uri->segment(6);

		$year =='' ? $year = date("Y") : $year = $this->uri->segment(4);
		$month =='' ? $month = date("m") : $month = $this->uri->segment(5);
		$stype =='' ? $stype=1 : $stype = $this->uri->segment(6);

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
		$this->load->view(SHOP_VIEW_ROOT.'sale_View',$RetVal);
		$this->load->view(CMS_VIEW_ROOT.'include/footer_View');
	}

	public function Data_Load(){

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

        $this->load->model(SHOP_MODEL_ROOT.'Dashboard_m');
        $count = $this->Dashboard_m->all_count($sdate);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Dashboard_m->Data_Load($sdate,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                   $row->sn,$row->oCode,$row->userid,$row->totalprice,$row->totaldelivery,$row->totalsale,$row->totalpoint,$row->payType,$row->regidate,$row->oCode
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