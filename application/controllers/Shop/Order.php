<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }
        if(empty($post)){
            $sdate = date("Y-m-d");
            $edate = date("Y-m-d");

            $syear = date("Y");
            $smonth = date("m");
            $sday = date("d");
            $eyear = date("Y");
            $emonth = date("m");
            $eday = date("d");

        }else{
            $sdate = $post['sdate'];
            $edate = $post['edate'];

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




        $main_arr = array(
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
        $this->load->view(SHOP_VIEW_ROOT . 'order_View',$main_arr);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
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


        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            $sdate = date("Y-m-d");
            $edate = date("Y-m-d");
        }else{
            $sdate = $post['sdate'];
            $edate = $post['edate'];
        }

        $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
        $count = $this->Order_m->all_count($sdate,$edate);

        $total_pages = ($count) ? ceil($count / $limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Order_m->Data_Load($sdate,$edate,$start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object)array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $total = ($row->totalprice) + ($row->totaldelivery);
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->oCode,$row->sName,$total,$row->totalprice,$row->totaldelivery,$row->totalsale,$row->totalpoint,$row->payType,$row->payComplete,$row->paydate,$row->regidate,$row->oCode
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

    public function Product(){

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $oCode = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';

        if(empty($oCode)){
            alert('잘못된 접근입니다.');
        }else{

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $info = $this->Order_m->Load_Info_Order($oCode);
            if(ArrayCount($info) <=0){
                alert(' 주문정보가 존재하지 않습니다.');
            }else {
                $delivery = $this->Order_m->Load_Info_Order_Delivery($oCode);
                if (ArrayCount($delivery) <= 0) {
                    alert('배송정보가 존재하지 않습니다.');
                } else {
                    $Rs = $this->Order_m->Load_Info_Order_Product($oCode);

                    if (ArrayCount($Rs) > 0) {
                        $temparr = array();
                        $product = array();
                        $updatestr = array();
                        foreach ($Rs as $d) {
                            $price = 0;
                            $temparr['sn'] = $d['sn'];
                            $temparr['pCode'] = $d['pCode'];
                            $temparr['pTitle'] = $d['pTitle'];
                            $price = ($d['price'] - ($d['price'] * ($d['sale'] / 100))) * $d['pCnt'];
                            $temparr['price'] = $price;
                            $temparr['dName'] = $d['dName'];
                            $temparr['delivery'] = $d['delivery'];
                            $temparr['status'] = $d['status'];
                            $temparr['delivery_num'] = $d['delivery_num'];
                            array_push($product, $temparr);

                            if($info[0]['payComplete']==109 && $d['status']==1){
                                array_push($updatestr,$d['sn']);
                            }


                        }
                    }

                    if(ArrayCount($updatestr)>0){
                        $Cnt = $this->Order_m->Update_Order_Make_Product_Lv2($updatestr);
                    }

                    $main_arr = array(
                        'oCode' => $oCode,
                        'delivery' => $delivery,
                        'product' => $product
                    );

                    $this->load->view(CMS_VIEW_ROOT . 'include/non_header_View.php', $hearder_Data);
                    $this->load->view(SHOP_VIEW_ROOT . 'order_detail_View', $main_arr);
                    $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
                }
            }
        }
    }

    public function Input_DelNum(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'status' => 3,
                'delivery_num' => $post['del']
            );

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('등록실패');
            }
        }
    }

    public function Update_DelNum(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'sn' => $post['sn'],
                'delivery_num' => $post['del']
            );


            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('수정실패');
            }
        }
    }

    public function Update_Complete(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'status' => 4,
            );

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('수정실패');
            }
        }
    }

    public function Update_Allow_Return(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'status' => 9,
            );

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('수정실패');
            }
        }
    }

    public function Update_Allow_Return2(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'status' => 6,
            );

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('수정실패');
            }
        }
    }

    public function Update_Allow_Cancel(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if(empty($post)){
            alert('잘못된 접근입니다.');
        }else{
            $data = array(
                'status' => 8,
            );

            $this->load->model(SHOP_MODEL_ROOT . 'Order_m');
            $Cnt = $this->Order_m->Update_Order_Product($post['sn'],$data);
            if($Cnt > 0){
                alert ('success','/Shop/Order/Product/'.$post['oCode']);
            }else{
                alert('수정실패');
            }
        }
    }


}