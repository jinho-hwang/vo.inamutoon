<?php
/**
 * Created by PhpStorm.
 * User: ullianze
 * Date: 2018-03-27
 * Time: 오전 11:30
 */



if ( ! function_exists('Counsel_Step')) {
    function Counsel_Step($step)
    {
        $stepname = '';
        if($step==0){
            $stepname = '감수 대기';
        }else if($step==1){
            $stepname = '자문위원 감수요청';
        }else if($step==2){
            $stepname = '자문위원 감수진행';
        }else if($step==3){
            $stepname = '자문위원 감수완료';
        }else if($step==4){
            $stepname = 'EBS 감수요청';
        }else if($step==5){
            $stepname = 'EBS 감수 진행';
        }else if($step==6){
            $stepname = 'EBS 감수완료';
        }else if($step==7){
            $stepname = 'EBS 재감수요청';
        }else if($step==8){
            $stepname = 'EBS 재감수진행';
        }else if($step==9){
            $stepname = 'EBS 재감수완료';
        }else if($step==10){
            $stepname = '오픈 대기';
        }

        return $stepname;
    }
}

if ( ! function_exists('fn_Log')) {
    function fn_Log($Form,$Log)
    {

        $sessionArr = Get_AdminSe_Data($Form);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        if($uid>0) {
            $Form->load->model(CMS_MODEL_ROOT . '/Member_m');
            $Cnt = $Form->Member_m->Insert_Log($uid, $Log);
            $bool = ($Cnt > 0) ? true : false;
        }else{
            $bool = false;
        }
        return $bool;
    }
}


if ( ! function_exists('Make_Heaer')) {
    function Make_Heaer($Form, $wid)
    {
        $Form->load->model(CMS_MODEL_ROOT.'/AMember_m');
        $Rs = $Form->AMember_m->Load_AMember($wid);

        $auth = array();
        for($i=1;$i<=50;$i++){
            $temparr = array();

            $temparr['menu'.$i] = $Rs['menu'.$i];
            array_push($auth, $temparr);
        }

        $hearder_Data = array(
            'menu' => $auth
        );

        $Form->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);

    }
}


if ( ! function_exists('Make_Menu')) {
    function Make_Menu($Form, $wid)
    {
        $Form->load->model(CMS_MODEL_ROOT.'/AMember_m');
        $Rs = $Form->AMember_m->Load_AMember($wid);


        $data = Make_Menu_Data();
        $menu = array();
        foreach($data as $d){
            $id = $d['id'];
            $menustr = "{item:{id:'tree".$id."',label:'".$d['label']."'},children: [";
            $menustr2 = '';
            foreach($d['children'] as $c){
                $value = $Rs[0]['menu'.$c['value']];
                $chk = ($value==1) ? 'true' : 'false';
                if($menustr2==''){
                    $menustr2 = "{item:{id:'".$c['id']."',label:'".$c['label']."',checked:".$chk.",value:".$c['value']."}}";
                }else{
                    $menustr2 .= ",{item:{id:'".$c['id']."',label:'".$c['label']."',checked:".$chk.",value:".$c['value']."}}";
                }
            }
            $menustr .= $menustr2. "]";

            $menu['menu'.$id] = $menustr;

        }
        return $menu;
    }
}


if ( ! function_exists('Make_Menu2')) {
    function Make_Menu2($Form, $wid)
    {
        $Form->load->model(CMS_MODEL_ROOT.'/AMember_m');
        $Rs = $Form->AMember_m->Load_AMember($wid);

        $data = Make_Menu_Data();
        $menu = array();
        $grade = $Rs[0]['grade'];
        $mbool = 0;
        foreach($data as $d){
            $children = array();
            $item = array();
            foreach($d['children'] as $c){

                if($grade==10 && $c['value']==9){
                    $url = '/Cartoon';
                }else{
                    $url = $c['url'];
                }


                $value = $Rs[0]['menu'.$c['value']];
                if($value==1){
                    $item = array(
                        'slable' => $c['label'],
                        'surl' => $url
                    );
                    array_push($children, $item);
                }
            }
            if(ArrayCount($item)>0) {
                $citem = array(
                    'mbool' => 1,
                    'label' => $d['label'],
                    'item' => $children
                );
                array_push($menu, $citem);
            }
        }
        return $menu;
    }
}


if ( ! function_exists('fnPercent')) {
    function fnPercent($range, $total, $slice)
    {
        if ($total == 0) $total = 1;
        $result = 0;
        if ($range == "totalPer" || $range == "total") {
            //n = 전체값 * 퍼센트 / 100;
            $result = ($total * $slice) / 100;
            return round($result);
        } else {
            //n% = 일부값 / 전체값 * 100;
            $result = ($slice / $total) * 100;
            return number_format($result, 2, '.', '');
        }
    }
}



if ( ! function_exists('Normal_Make_age')) {
    function Normal_Make_age($year)
    {
        $nowyear = date("Y");

        $age = $nowyear - $year;

        return $age;

    }
}


if ( ! function_exists('Summary_Cash_Log')) {
    function Summary_Cash_Log($data)
    {
        $chargeAr = array(
            'charge1' =>0,
            'charge1_free' =>0,
            'charge1_vat' =>0,
            'charge1_rate' =>0,
            'charge1_dicision' =>0,
            'charge1_share' => 0,
            'charge2' =>0,
            'charge2_free' =>0,
            'charge2_vat' =>0,
            'charge2_rate' =>0,
            'charge2_dicision' =>0,
            'charge2_share' => 0,
            'charge3' =>0,
            'charge3_free' =>0,
            'charge3_vat' =>0,
            'charge3_rate' =>0,
            'charge3_dicision' =>0,
            'charge3_share' => 0,
            'charge4' =>0,
            'charge4_free' =>0,
            'charge4_vat' =>0,
            'charge4_rate' =>0,
            'charge4_dicision' =>0,
            'charge4_share' => 0,
            'total_cash' =>0,
            'total_free' =>0,
            'total_vat' =>0,
            'total_rate' =>0,
            'total_dicision' =>0,
            'total_share' => 0
        );
        foreach($data as $d){
            $cash = $d['cash'] * CASHBYCOIN;
            $free = $d['free'] * CASHBYCOIN;
            //$vat = ($d['cash']* CASHBYCOIN) - (($d['cash']* CASHBYCOIN) *(CO_VAT/100));
            $vat = $cash/CO_VAT;
            $rate = $vat*($d['rate']/100);
            $decision = $vat - $rate;
            $share =($vat-$rate)*($d['fee']/100);
            if($d['payType']==1){
                $chargeAr['charge1'] = $chargeAr['charge1'] + $cash;
                $chargeAr['charge1_free'] = $chargeAr['charge1_free'] + $free;
                $chargeAr['charge1_vat'] = $chargeAr['charge1_vat'] + $vat;
                $chargeAr['charge1_rate'] = $chargeAr['charge1_rate'] + $rate;
                $chargeAr['charge1_dicision'] = $chargeAr['charge1_dicision'] + $decision;
                $chargeAr['charge1_share'] = $chargeAr['charge1_share'] + $share;
            }else if($d['payType']==2){
                $chargeAr['charge2'] = $chargeAr['charge2'] + $cash;
                $chargeAr['charge2_free'] = $chargeAr['charge2_free'] + $free;
                $chargeAr['charge2_vat'] = $chargeAr['charge2_vat'] + $vat;
                $chargeAr['charge2_rate'] = $chargeAr['charge2_rate'] + $rate;
                $chargeAr['charge2_dicision'] = $chargeAr['charge2_dicision'] + $decision;
                $chargeAr['charge2_share'] = $chargeAr['charge2_share'] + $share;
            }else if($d['payType']==3){
                $chargeAr['charge3'] = $chargeAr['charge3'] + $cash;
                $chargeAr['charge3_free'] = $chargeAr['charge3_free'] + $free;
                $chargeAr['charge3_vat'] = $chargeAr['charge3_vat'] + $vat;
                $chargeAr['charge3_rate'] = $chargeAr['charge3_rate'] + $rate;
                $chargeAr['charge3_dicision'] = $chargeAr['charge3_dicision'] + $decision;
                $chargeAr['charge3_share'] = $chargeAr['charge3_share'] + $share;
            }else if($d['payType']==4) {
                $chargeAr['charge4'] = $chargeAr['charge4'] + $cash;
                $chargeAr['charge4_free'] = $chargeAr['charge4_free'] + $free;
                $chargeAr['charge4_vat'] = $chargeAr['charge4_vat'] + $vat;
                $chargeAr['charge4_rate'] = $chargeAr['charge4_rate'] + $rate;
                $chargeAr['charge4_dicision'] = $chargeAr['charge4_dicision'] + $decision;
                $chargeAr['charge4_share'] = $chargeAr['charge4_share'] + $share;
            }

            $chargeAr['total_cash'] = $chargeAr['total_cash'] + $cash;
            $chargeAr['total_free'] = $chargeAr['total_free'] + $free;
            $chargeAr['total_vat'] = $chargeAr['total_vat']+ $vat;
            $chargeAr['total_rate'] = $chargeAr['total_rate']+$rate;
            $chargeAr['total_dicision'] = $chargeAr['total_dicision']+$decision;
            $chargeAr['total_share'] = $chargeAr['total_share'] + $share;

        }

        return $chargeAr;
    }
}


if ( ! function_exists('order_statys')) {
    function order_status($status)
    {
        $msg = '';
        if($status==0){
            $msg = '결제대기';
        }else if($status==1){
            $msg = '결제완료';
        }else if($status==2){
            $msg = '상품 준비중';
        }else if($status==3){
            $msg = '배송중';
        }else if($status==4) {
            $msg = '배송완료';
        }else if($status==5) {
            $msg = '반품신청';
        }else if($status==6) {
            $msg = '반품완료';
        }else if($status==7) {
            $msg = '취소신청';
        }else if($status==8) {
            $msg = '취소완료';
        }else if($status==9) {
            $msg = '반품진행중';
        }else if($status==10) {
            $msg = '거래완료';
        }

        return $msg;
    }
}

if ( ! function_exists('Get_AdminSe_Data'))
{
    function Get_AdminSe_Data($Form)
    {
        if($Form->session->userdata('admin_uid')){
            $data = array(
                'uid' => $Form->session->userdata('admin_uid'),
                'userid' => $Form->session->userdata('admin_userid'),
                'grade' => $Form->session->userdata('admin_grade'),
                'islogin' => $Form->session->userdata('admin_islogin')
            );
        }else{
            //$Form->session->sess_destroy();
            $data = array(
                'islogin' => false,
                'uid' =>0
            );
        }
        return $data;
    }
}


if ( ! function_exists('Set_AdminSe_Data'))
{
    function Set_AdminSe_Data($param)
    {
        $data = array(
            'admin_uid' => $param['uid'],
            'admin_userid' => $param['userid'],
            'admin_grade' => $param['grade'],
            'admin_islogin' => true
        );
        return $data;
    }
}



if ( ! function_exists('TMSLogin')) {
    function TMSLogin($Form)
    {
        $sessionArr = Get_AdminSe_Data($Form);
        if (!$sessionArr['islogin']) {
            redirect(BASE_URL . 'Login', 'refresh');
            return;
        }
    }
}

if ( ! function_exists('TMSLogin2')) {
    function TMSLogin2($Form,$grade)
    {
        $sessionArr = Get_AdminSe_Data($Form);
        if (!$sessionArr['islogin']) {
            redirect(CMS_ROOT . '/Login', 'refresh');
            return;
        }else{
            $Form->load->model(CMS_MODEL_ROOT.'/AMember_m');
            $Rs = $Form->AMember_m->Load_AMember($sessionArr['uid']);
            if(ArrayCount($Rs)<=0){
                redirect(CMS_ROOT . '/Login', 'refresh');
                return;
            }else{
                if($Rs[0]['grade']<$grade){
                    alert('잘봇된 접근입니다.');
                }
            }
        }
    }
}


if ( ! function_exists('Load_Grade')) {
    function Load_Grade($Form,$Tuid)
    {
        if($Tuid>0) {
            $menu = Make_Menu2($Form, $Tuid);


            $Log = 'Move||'.$_SERVER["REQUEST_URI"];
            fn_Log($Form,$Log);

        }

        return $menu;
    }
}

if ( ! function_exists('FileSizeCheck')) {
    function FileSizeCheck($FileSize, $LimitSize)
    {
        if ($FileSize > $LimitSize) {
            $LimitSize = number_format($LimitSize);
            ALERT('Upload capacity is exceeded. [capacity is ' . $LimitSize . ' Byte]');
        }
    }
}

if ( ! function_exists('FileNameCheck')) {
    function FileNameCheck($FileName, $TailName)
    {
        if (!preg_match("/\.($TailName)/i", $FileName)) {
            ALERT("Please check file extension.");
        }
    }
}