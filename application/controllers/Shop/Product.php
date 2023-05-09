<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        if(!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        }else{
            $data = array();

            $this->load->view(CMS_VIEW_ROOT.'include/header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'product_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');

        }
    }

    public function Data_Load(){
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(SHOP_MODEL_ROOT.'/Product_m');
        $count = $this->Product_m->all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Product_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->pCode,$row->fname,$row->pName,$row->agName,$row->bgName,$row->cgName,$row->cName,$row->price,$row->sale,$row->point,$row->recom,$row->sellCnt,$row->pCode,$row->isUse,$row->regidate
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

    public function Reg_View(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        if(!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        }else{
            $this->load->model(SHOP_MODEL_ROOT.'/company_m');
            $Rs = $this->company_m->Load_Company_All();
            $com_Str = "<option value=''>선택하세요</option>";
            if(ArrayCount($Rs)>0){
                foreach($Rs as $d){
                    $com_Str .= "<option value='".$d['cCode']."'>".$d['cTitle']."</option>";
                }
            }

            $select_box = "<option>선택하세요</option>";

            $this->load->model(SHOP_MODEL_ROOT.'/Category_m');
            $Rs = $this->Category_m->Load_ACategory_All();
            if (ArrayCount($Rs) > 0) {
                foreach ($Rs as $row) {
                    $select_box .= "<option value='".$row['aCode']."'>".$row['cName']."</option>";
                }
            }

            $pCode = $this->MakeProductCode($this);

            $data = array(
                'pCode' => $pCode,
                'com' => $com_Str,
                'select_box' => $select_box
            );

            $this->load->view(CMS_VIEW_ROOT.'include/non_header_View',$hearder_Data);
            $this->load->view(SHOP_VIEW_ROOT.'product_Reg2_View',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View');
         }

    }

    public function Mod_View(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        if(!$sessionArr['islogin']) {
            redirect(WEB_URL . '/Login', 'refresh');
        }else{
            $pCode = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
            if(empty($pCode)){
                alert('잘못된 접근입니다. ');
            }else{
                $this->load->model(SHOP_MODEL_ROOT.'/product_m');
                $product = $this->product_m->Load_Product($pCode);

                if(ArrayCount($product)<=0){
                    alert('존재하지 않는 상품 입니다.');
                }else {
                    $option = $this->product_m->Load_Product_Option($pCode);
                    $data = $this->product_m->Load_Product_Img($pCode);
                    $img = array();

                    for($i=0;$i<=4;$i++) {
                        $img[$i]['sn'] = '';
                        $img[$i]['pCode'] = '';
                        $img[$i]['typ'] = $i+1;
                        $img[$i]['img'] = '';
                    }

                    if(ArrayCount($data)>0){
                        foreach($data as $d){
                            $typ = $d['typ']-1;

                            $img[$typ]['sn'] = $d['sn'];
                            $img[$typ]['pCode'] = $d['pCode'];
                            $img[$typ]['typ'] = $d['typ'];
                            $img[$typ]['img'] = $d['img'];

                        }
                    }


                    $this->load->model(SHOP_MODEL_ROOT.'/company_m');
                    $Rs = $this->company_m->Load_Company_All();
                    $com_Str = "<option value=''>선택하세요</option>";
                    if (ArrayCount($Rs) > 0) {
                        foreach ($Rs as $d) {
                            if($d['cCode']==$product[0]['cCode']){
                                $com_Str .= "<option value='" . $d['cCode'] . "' selected>" . $d['cTitle'] . "</option>";
                            }else{
                                $com_Str .= "<option value='" . $d['cCode'] . "'>" . $d['cTitle'] . "</option>";
                            }

                        }
                    }

                    $this->load->model(SHOP_MODEL_ROOT . '/Category_m');
                    $ACategory = "<option>선택하세요</option>";
                    $Rs = $this->Category_m->Load_ACategory_All();
                    if (ArrayCount($Rs) > 0) {
                        foreach ($Rs as $row) {
                            if($product[0]['agCode']==$row['aCode']){
                                $ACategory .= "<option value='" . $row['aCode'] . "' selected>" . $row['cName'] . "</option>";
                            }else{
                                $ACategory .= "<option value='" . $row['aCode'] . "'>" . $row['cName'] . "</option>";
                            }

                        }
                    }

                    $BCategory = "<option>선택하세요</option>";
                    $Rs = $this->Category_m->Load_BCategory_All();
                    if (ArrayCount($Rs) > 0) {
                        foreach ($Rs as $row) {
                            if($product[0]['bgCode']==$row['bCode']){
                                $BCategory .= "<option value='" . $row['bCode'] . "' selected>" . $row['cName'] . "</option>";
                            }else{
                                $BCategory .= "<option value='" . $row['bCode'] . "'>" . $row['cName'] . "</option>";
                            }

                        }
                    }

                    $CCategory = "<option>선택하세요</option>";
                    $Rs = $this->Category_m->Load_CCategory_All();
                    if (ArrayCount($Rs) > 0) {
                        foreach ($Rs as $row) {
                            if($product[0]['cgCode']==$row['cCode']){
                                $CCategory .= "<option value='" . $row['cCode'] . "' selected>" . $row['cName'] . "</option>";
                            }else{
                                $CCategory .= "<option value='" . $row['cCode'] . "'>" . $row['cName'] . "</option>";
                            }

                        }
                    }



                    $data = array(
                        'product' => $product,
                        'Acate' => $ACategory,
                        'Bcate' => $BCategory,
                        'Ccate' => $CCategory,
                        'com' => $com_Str,
                        'option' => $option,
                        'img' => $img
                    );

                    $this->load->view(CMS_VIEW_ROOT . 'include/non_header_View', $hearder_Data);
                    $this->load->view(SHOP_VIEW_ROOT . 'product_Mod2_View', $data);
                    $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
                }
            }
        }
    }

    function MakeProductCode($Form)
    {
        $Form->load->model(SHOP_MODEL_ROOT.'/Product_m');
        $Rs = $Form->Product_m->MaxProductCode();
        if(ArrayCount($Rs)>0){
            $num = String_Right($Rs[0]['pCode'],6);
            $new_num = $num + 1;
            $New_Code = 'CT'.str_pad($new_num,"6","0",STR_PAD_LEFT);
        }else{
            $new_num = 1;
            $New_Code = 'CT'.str_pad($new_num,"6","0",STR_PAD_LEFT);
        }
        return $New_Code;
    }


    public function CkEdit_upload()
    {

        $key = 'upload';
        $callID = $this->input->get('CKEditorFuncNum');
        $update_dir = '/home/toon/www/content.ebstoon/assets/data/shop/body/';
        $allowed_types = 'jpg|png|gif';
        preg_match("/\.(" . $allowed_types . ")$/i", $_FILES[$key]['name'], $ext);
        $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
        $config['upload_path'] = $update_dir;
        $config['max_size'] = '20000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if ($_FILES[$key]['size'] <= 0) {
            //$message = 'Not Upload File';
            alert('업로드 파일을 선택하세요.');
        } else {
            if (!$this->upload->do_upload($key)) {
                alert('업로드에 실패 하였습니다.\n원인:' . $this->upload->display_errors('', ''));
                //$message = array('error' => $this->upload->display_errors());
            } else {
                $upload = $this->upload->data();

                $filename = $upload['file_name'];
                $file_url = CONTENT_ASSETSROOT.'/data/shop/body/'.$filename;
                echo("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction('" . $callID . "', '" . $file_url . "', '업로드완료')</script>");
            }
        }
    }


    public function Edit_upload()
    {

        $key = 'Filedata';
        $update_dir = '/home/toon/www/content.ebstoon/assets/data/shop/body/';

        $allowed_types = 'jpg|JPG|png|gif';
        preg_match("/\.(" . $allowed_types . ")$/i", $_FILES[$key]['name'], $ext);
        $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
        $config['upload_path'] = $update_dir;
        $config['max_size'] = '3000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if ($_FILES[$key]['size'] <= 0) {
            //$message = 'Not Upload File';
            alert('업로드 파일을 선택하세요.');
        } else {

            if (!$this->upload->do_upload($key)) {
                alert('업로드에 실패 하였습니다.\n원인:' . $this->upload->display_errors('', ''));
                //$message = array('error' => $this->upload->display_errors());
            } else {
                $upload = $this->upload->data();

                $filename = $upload['file_name'];
                $file_url = CONTENT_ASSETSROOT.'/data/shop/body/'.$filename;
                $script = "<script src='/assets/CMS/js/jquery-1.6.4.min.js'></script>";
                $script .= "<script>";
                $script .= "var sHTML = '<img src=".$file_url .">';";
                $script .= "var target = opener.parent;";
                $script .= "target.pasteHTML(sHTML);	// 이미지 textarea에 삽입";
                $script .= "</script><script>window.close();</script>";

                echo($script);
            }
        }
    }

    public function Reg_Data(){
        foreach ($this->input->post() as $k_val => $value) {
            $post[$k_val] = $value;
        }

        if (empty($post)) {
            alert('필수항목이 누락 되었습니다.');
        } else {

            $update_dir = '/home/toon/www/content.ebstoon/assets/data/shop/top/';
            for($i=1;$i<=5;$i++) {

                $obj_name = 'main_thumb'.$i;
                if($_FILES[$obj_name]['size'] > 0) {
                    $main_thumb = $this->upload_Shop_img($update_dir, $_FILES[$obj_name],$obj_name);

                    $img = array(
                        'pCode' => $post['pCode'],
                        'typ' => $i,
                        'img' => $main_thumb
                    );

                    $this->load->model(SHOP_MODEL_ROOT . '/Product_m');
                    $Cnt = $this->Product_m->Img_Reg($img);
                }
            }


            $option = array(
                'pCode' => $post['pCode'],
                'option1' => $post['option1'],
                'option2' => $post['option2'],
                'option3' => $post['option3'],
                'option4' => $post['option4'],
                'option5' => $post['option5']
            );

            $Cnt = $this->Product_m->Option_Reg($option);
            if ($Cnt > 0) {
                $data = array(
                    'pCode' => $post['pCode'],
                    'pName' => $post['pName'],
                    'agCode' => $post['acategory'],
                    'bgCode' => $post['bcategory'],
                    'cgCode' => $post['ccategory'],
                    'cCode' => $post['cCode'],
                    'price' => $post['price'],
                    'sale' => $post['sale'],
                    'point' => $post['point'],
                    'explain' => $post['description']
                );

                $Cnt = $this->Product_m->Data_Reg($data);
                if($Cnt > 0){
                    alert_refresh_close('등록 하였습니다.');
                }else{
                    alert_close('상품 정보 등록에 실패 하였습니다.');
                }
            } else {
                alert_close('상품 옵션 등록에 실패 하였습니다.');
            }
        }
    }

    public function Mod_Data(){
        foreach ($this->input->post() as $k_val => $value) {
            $post[$k_val] = $value;
        }

        if (empty($post)) {
            alert('필수항목이 누락 되었습니다.');
        } else {
            $pCode = $post['pCode'];
            $this->load->model(SHOP_MODEL_ROOT.'/Product_m');


            $update_dir = '/home/toon/www/content.ebstoon/assets/data/shop/top/';
            for($i=1;$i<=5;$i++) {

                $obj_name = 'main_thumb'.$i;
                if($_FILES[$obj_name]['size'] > 0) {
                    $main_thumb = $this->upload_Shop_img($update_dir, $_FILES[$obj_name],$obj_name);

                    $img = array(
                        'pCode' => $post['pCode'],
                        'typ' => $i,
                        'img' => $main_thumb
                    );

                    $this->load->model(SHOP_MODEL_ROOT . '/Product_m');
                    $Cnt = $this->Product_m->Delete_Product_Image($pCode,$i);
                    $Cnt = $this->Product_m->Img_Reg($img);
                }
            }

            $option = array(
                'option1' => $post['option1'],
                'option2' => $post['option2'],
                'option3' => $post['option3'],
                'option4' => $post['option4'],
                'option5' => $post['option5']
            );

            $Cnt = $this->Product_m->Option_Update($pCode,$option);
            $data = array(
                'pName' => $post['pName'],
                'agCode' => $post['acategory'],
                'bgCode' => $post['bcategory'],
                'cgCode' => $post['ccategory'],
                'cCode' => $post['cCode'],
                'price' => $post['price'],
                'sale' => $post['sale'],
                'point' => $post['point'],
                'explain' => $post['description'],
                'isUse' => $post['isUse'],
                'recom' => $post['recom']
            );

            $Cnt = $this->Product_m->Data_Update($pCode,$data);
            alert_refresh_close('수정 하였습니다.');

        }
    }

    public function PImageDelete(){
        $pCode = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
        $typ = ($this->uri->segment(5)) ? $this->uri->segment(5) : '';

        if($pCode=='' || $typ==''){
            alert('필수항목이 누락 되었습니다.');
        }else{
            $this->load->model(SHOP_MODEL_ROOT . '/Product_m');
            $Cnt = $this->Product_m->Delete_Product_Image($pCode,$typ);
            alert('상품이미지를 삭제 하였습니다.');

        }
    }



    private function upload_Shop_img($tUrl,$fileArr,$key){
        if($fileArr['size'] >0) {
            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(" . $allowed_types . ")$/i", $fileArr['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path'] = $tUrl;
            $config['max_size'] = '20000';
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload($key)) {
                $filename = $this->upload->display_errors('<p>', '</p>');;
            } else {
                $upload = $this->upload->data();
                $filename = $upload['file_name'];
            }
        }else{
            $filename = '2';
        }

        return $filename;
    }

}

