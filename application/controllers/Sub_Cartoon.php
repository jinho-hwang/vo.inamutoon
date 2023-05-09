<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_Cartoon extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        TMSLogin2($this,10);
    }
    
    public function View()
    {

        $ccode = $this->uri->segment(3);
        if(empty($ccode)){
            alert("카툰을 선택하세요.",ROOT_URL.'Cartoon/');
        }else {

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this, $uid)
            );

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($ccode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.");
            }else {
                $data = array(
                  'ccode' => $ccode,
                  'c_name' => $Rs[0]['title']
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
                $this->load->view(CMS_VIEW_ROOT . 'sub_cartoon_View', $data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
            }
        }
    }
    
    public function Data_Load(){

        $pcode = ($this->input->post('pcode')) ? $this->input->post('pcode') : 0;

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
        
        $this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');
        $count = $this->sub_cartoon_m->all_count($pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->sub_cartoon_m->Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $Scene = $row->pcode."||".$row->cnum;
                $response->rows[$i]['id'] = $row->sn;
                $row->isActive == 0 ? $rdate ='' : $rdate = $row->update_date;

                $response->rows[$i]['cell'] = array(
                    //$row->id, "<img class='main_img' src='/assets/data/".$row->main_img."' />", $row->main_img, $row->thmb_img, $row->kind, $row->subject, $row->cartoonist_id, $row->cartoonist1, $row->cartoonist2, $row->cartoonist3, $row->genre, $row->day_series, $row->manuscript_charge, $row->revenue_share, $row->point_share, $row->week_series, $row->contract_date, $row->termination_date, $row->rdate, $row->bdate, $row->coin, $row->point, $row->blog_cafe, $row->fnct_setup, $row->adult, $row->plot, $row->idle, $row->hidden
                    $row->sn,$row->cnum,$row->sub_Title, $row->imgname,$row->imgname,$row->isLogin,$row->Supervisor,$row->star,$row->cartoon_price,$row->cartoon_sale,$row->cartoon_price2,$row->cartoon_sale2,$row->sType,$row->isActive,$row->regidate,$rdate,$Scene
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
         $post = array();
         foreach ($this->input->post() as $key => $value) {
             $post[$key] = $value;
         }

         if (empty($post)) {
             $result = false;
             $retval = '';
             $message = 'Not Input Parameter';
         } else {
             $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

             $this->load->model(CMS_MODEL_ROOT . 'sub_cartoon_m');
             if ($insert_id = $this->sub_cartoon_m->Data_Add($post)) {

                 $Log = 'Sub_Cartoon_Add||'.$post['pcode'];
                 fn_Log($this,$Log);

                 $result = true;
                 $retval = $insert_id;
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
     
     public function Data_Update(){
         foreach ($this->input->post() as $key => $value) {
             $post[$key] = $value;
         }

         if (empty($post)) {
             $result = false;
             $retVal = '';
             $filename = '';
             $message = 'Not Input Parameter';
         } else {
             $post['pcode'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

             $filename = $post['pcode'] . '-' . $post['cnum'];
             $this->load->model(CMS_MODEL_ROOT . 'sub_cartoon_m');
             if ($insert_id = $this->sub_cartoon_m->Data_Update($post)) {

                 $Log = 'Sub_Cartoon_Update||'.$post['pcode'].'||'.$filename;
                 fn_Log($this,$Log);

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
            'filename' =>$filename,
            'message' => $message
        ));
    }
     
     public function Data_Delete(){
         foreach ($this->input->post() as $key => $value) {
             $post[$key] = $value;
         }

         if (empty($post)) {
             $result = false;
             $message = 'Not Input Parameter';
         } else {
             $this->load->model(CMS_MODEL_ROOT . 'sub_cartoon_m');
             $Rs = $this->sub_cartoon_m->Load_Sub_Cartoon($post['id']);
             if(ArrayCount($Rs)<=0){
                 $result = false;
                 $message = 'Not Found';
             }else {
                 $pcode = $Rs[0]['pcode'];
                 $scode = $Rs[0]['cnum'];
                 $affected_rows = $this->sub_cartoon_m->Scene_Del_All($pcode,$scode);
                 $affected_rows = $this->sub_cartoon_m->Data_Del($post['id']);

                 if ($affected_rows > 0) {

                     $Log = 'Sub_Cartoon_Del||'.$pcode.'||'.$scode;
                     fn_Log($this,$Log);

                     $result = true;
                     $message = 'Success';
                 } else {
                     $result = false;
                     $message = 'Fail!!';
                 }
             }
         }
            
        echo json_encode(array(
            'result' => $result,
            'code' => $post['id'],
            'message' => $message
        ));
    }
     
    public function upload_main_img()
    {
        $sn = $this->input->post('sn');
        $key = $this->input->post('key');
        if ($sn === null || $key=== null) {
            $result = false;
            $message = 'missing params.';
        }else{
            
            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES['imgname']['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = '/www/inamutoon_com/assets/data/detail_banner/';    
            $config['max_size'] = '20000';
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);
            
            
             if($_FILES[$key]['size'] <=0){
                 $result = true;
                 $message = 'Not Upload File';
             }else{
                 if (!$this->upload->do_upload($key)){
                    $result = false;
                    $message = array('error' => $this->upload->display_errors());
                 }else{
                    $upload = $this->upload->data();
                    $filename = $upload['raw_name'].$upload['file_ext'];
                    
                    $this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');
                    $Cnt = $this->sub_cartoon_m->Update_Main_Filename($sn,$filename);    
                    if($Cnt > 0){
                        $result = true;
                        $message = 'success';
                    }else{
                        $result = true;
                        $message = 'NOT Change';
                    }
                 }
             }
         }
        print json_encode(array('result' => $result, 'message'=>$message));
    } 
     
    public function upload_content_img()
    {
        $sn = $this->input->post('sn');
        $fn = $this->input->post('fn');
        $key = $this->input->post('key');
        if ($sn === null || $key=== null || $sn === null) {
            $result = false;
            $message = 'missing params.';
        }else{
            $filename = $fn.'.jpg';
            
            $allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES['imgname']['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = '/www/inamutoon_com/assets/data/cartoon/';    
            $config['max_size'] = '20000';
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $config['file_name'] = $filename;
            $config['overwrite'] = TRUE;
            $this->load->library('upload',$config);
            
            
             if($_FILES[$key]['size'] <=0){
                 $result = false;
                 $message = 'Not Upload File';
             }else{
                 if (!$this->upload->do_upload($key)){
                    $result = false;
                    $message = array('error' => $this->upload->display_errors());
                 }else{
                    $upload = $this->upload->data();
                    
                    
                    $this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');
                    $Cnt = $this->sub_cartoon_m->Update_content_Filename($sn,$filename);    
                    if($Cnt > 0){
                        $result = true;
                        $message = 'success';
                    }else{
                        $result = true;
                        $message = 'Not Change';
                    }
                 }
             }
         }
        print json_encode(array('result' => $result, 'message'=>$message));
    }  
     
    public function Load_ImgName_frame(){
        $pcode = $this->input->post('pcode');
        $cnum = $this->input->post('cnum');
        if(empty($pcode) || empty($cnum)){
            $result = 'error';
            $orgname = '';
        }else{
            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->temp_imgname_Load($pcode,$cnum);
            ArrayCount($Rs)>0 ? $fname = $Rs[0]['fname'] : $fname = '';

            $result = 'ok';
            $orgname = $fname;
        }

        $data = array(
            'result' => $result,
            'fname' =>$orgname
        );
        echo json_encode($data);
    }



    public function Scene(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);
            if(ArrayCount($Rs)>0){
                $title = $Rs[0]['title'];
                $view_type = $Rs[0]['view_type'];
            }else{
                $title = '';
                $view_type = '';
            }

            $Rs2 = $this->cartoon_m->temp_imgname_Load($pcode,$cnum);
            ArrayCount($Rs2)>0 ? $orgname = $Rs2[0]['fname'] : $orgname = '';

            $data = array(
                'pcode' =>  $pcode,
                'cnum' =>  $cnum,
                'title' =>$title,
                'lastname' =>$orgname,
                'view_type' =>$view_type
            );

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this,$uid)
            );

            $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
            $this->load->view(CMS_VIEW_ROOT.'scene_View.php',$data);
            $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
        }
    }

    public function Scene_ADel(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
            $Cnt = $this->Sub_cartoon_m->Scene_Del_All($pcode,$cnum);
            if($Cnt > 0){
                alert("삭제가 완료 되었습니다.",TMS_ROOT.'/Sub_Cartoon/Scene/'.$pcode.'/'.$cnum);
            }
        }
    }

    public function Scene_Add(){
    	$result = true;
        $retval = 0;
        $message = 'Success';   
		
		/*		
        $pcode = $this->uri->segment(4);
        $cnum = $this->uri->segment(5);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            foreach ($this->input->post() as $key => $value) {
                $post[$key] = $value;
            }
            
            if(empty($post)){
                   $result = false;
                   $retval = '';
                   $message = 'Not Input Parameter';
            }else{
                
                $post['pcode'] = $pcode;
                $post['cnum'] = $cnum;
                $this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');
                if($insert_id = $this->sub_cartoon_m->Scean_Add($post)){
                    $result = true;
                    $retval = $insert_id;
                    $message = 'Success';        
                }else{
                    $result = false;
                    $retval = '';
                    $message = 'Fail!!';
                }
                
                echo json_encode(array(
                    'result' => $result,
                    'code' => $retval,
                    'message' => $message
                ));
            }
            
        }
        
		 * 
		 */
		  echo json_encode(array(
                    'result' => $result,
                    'code' => $retval,
                    'message' => $message
                ));
        
    }
  
    public function Scene_Load(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
            $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
            $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
            $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
          
            $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
            if($totalrows) {
                $limit = $totalrows;
            }
            
            $this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');
            $count = $this->sub_cartoon_m->all_Scene_count_pcode($pcode,$cnum);
    
            $total_pages = ($count) ? ceil($count/$limit) : 0;
            $start = $limit * $page - $limit;
    
            $query = $this->sub_cartoon_m->Scene_Load($start, $limit, $sidx, $sord,$pcode,$cnum);
            if (!empty($query)) {
                $response = (object) array();
                $i = 0;
    
                foreach ($query->result() as $row) {
                    $response->rows[$i]['id'] = $row->sn;
                    $response->rows[$i]['cell'] = array(
                        //$row->id, "<img class='main_img' src='/assets/data/".$row->main_img."' />", $row->main_img, $row->thmb_img, $row->kind, $row->subject, $row->cartoonist_id, $row->cartoonist1, $row->cartoonist2, $row->cartoonist3, $row->genre, $row->day_series, $row->manuscript_charge, $row->revenue_share, $row->point_share, $row->week_series, $row->contract_date, $row->termination_date, $row->rdate, $row->bdate, $row->coin, $row->point, $row->blog_cafe, $row->fnct_setup, $row->adult, $row->plot, $row->idle, $row->hidden
                       $row->title, $row->cnum,$row->scene, $row->imgname,$row->imgname,$row->regidate
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
    
	function upload_Scene_img(){
        $sn = $this->input->post('sn');
        $pcode = $this->input->post('pcode');
        $cnum = $this->input->post('cnum');
        $key = $this->input->post('key');
        if ($sn === null || $key=== null || $pcode === null || $cnum=== null) {
            $result = false;
            $message = 'missing params.';
        }else{
        	$uptempPass = '/www/inamutoon_com/assets/data/cartoon_scen1/temp';
			$DeskTopPass = '/www/inamutoon_com/assets/data/cartoon_scene1/desk';
			$MobileTopPass = '/www/inamutoon_com/assets/data/cartoon_scene1/mobile';
			$allowed_types = 'jpg|png|gif';
            preg_match("/\.(".$allowed_types.")$/i", $_FILES['imgname']['name'], $ext);
            $config['allowed_types'] = (isset($ext[1])) ? $ext[1] : false;
            $config['upload_path']   = $uptempPass;    
            $config['max_size'] = '20000';
            $config['max_width'] = '10000';
            $config['max_height'] = '10000';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);
            
            
             if($_FILES[$key]['size'] <=0){
                 $result = false;
                 $message = 'Not Upload File';
             }else{
                 if (!$this->upload->do_upload($key)){
                    $result = false;
                    $message = array('error' => $this->upload->display_errors());
                 }else{
                    $upload = $this->upload->data();
                    $filename = $upload['raw_name'].$upload['file_ext'];
                    
					
					$imagesize = getimagesize($uptempPass."/".$filename);
					$width = $imagesize[0];
					$height = $imagesize[1];
					$DefaultHeight = 1000;
					$chWidth = 720;
					$SaveCnt = ($height) ? ceil($height/$DefaultHeight) : 0;
					$startX = 0;
					$startY = 0;
					$sourcePass = $uptempPass.'/'.$filename;
				
					$this->load->model(CMS_MODEL_ROOT.'sub_cartoon_m');	
					$Rs = $this->sub_cartoon_m->Scene_Cnt($pcode,$cnum);
					if(ArrayCount($Rs)<=0){
						$nowCnt = 0;
					}else if(ArrayCount($Rs)>=0){
						$nowCnt = $Rs[0]['Cnt'];
					}else{
						$nowCnt = 0;
					}
					
					
					for($i=0;$i<=$SaveCnt-1;$i++){
						(($DefaultHeight*($i+1)) > $height) ? $Cutheight= $height-($DefaultHeight*$i)  : $Cutheight = $DefaultHeight ;	
						(($DefaultHeight*$i) <= 0) ? $startY=0: $startY = ($DefaultHeight*$i) ;  
						
						$NewFilename = random_string('alnum',32).$upload['file_ext'];
						$NewDeskPath= $DeskTopPass.'/'.$NewFilename;
						$NewMobilePath = $MobileTopPass.'/'.$NewFilename;
						//$this->Make_Cartoon_Desk($width,$Cutheight,$startX,$startY,$sourcePass, $NewDeskPath);
						$this->Make_Cartoon_Mobile($chWidth, $NewDeskPath, $NewMobilePath);
						
						$data = array(
							'pcode' => $pcode,
							'cnum' =>$cnum,
							'scene' => $nowCnt + ($i+1),
							'img' =>$NewFilename
							);
						$this->sub_cartoon_m->Insert_Scean($data);
					}
					
					$result = true;
					$message = 'success';
                 }
             }
         }
        print json_encode(array('result' => $result, 'message'=>$message));
    }

    function Scene_Delete(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'sub_cartoon_m');
            $affected_rows = $this->sub_cartoon_m->Scene_Del($post['id']);

            if ($affected_rows > 0) {

                $Log = 'Scene_Del||sn='.$post['id'];
                fn_Log($this,$Log);

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
    
    function Scene_Update(){
        $pcode = $this->uri->segment(4);
        $cnum = $this->uri->segment(5);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else {
            foreach ($this->input->post() as $key => $value) {
                $post[$key] = $value;
            }

            if (empty($post)) {
                $result = false;
                $retval = '';
                $message = 'Not Input Parameter';
            } else {
                $post['pcode'] = $pcode;
                $post['cnum'] = $cnum;

                $this->load->model(CMS_MODEL_ROOT . 'sub_cartoon_m');
                if ($insert_id = $this->sub_cartoon_m->Scean_Update($post)) {

                    $Log = 'Scene_Add||'.$pcode.'||'.$cnum;
                    fn_Log($this,$Log);

                    $result = true;
                    $retval = $insert_id;
                    $message = 'Success';
                } else {
                    $result = true;
                    $retval = $post['id'];
                    $message = 'Not Change';
                }
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => $retval,
            'message' => $message
        ));
    }
  

    public function Make_Cartoon_Desk($width,$height,$startX,$startY,$srcimg,$tgtimg){

        $sc_x = $startX;
        $sc_y = $startY;

        $rs_img_width = 	$width;
        $rs_img_height = $height;

        // copyresampled 값이 동일하다 why? 이미지의 확대 축소가 발생하지는 않기 때문이다.
        $sc_img_width = $rs_img_width;
        $sc_img_height = $rs_img_height;

        $rs_x =0;
        $rs_y =0;

        $sc_img = imagecreatefromjpeg($srcimg);
        $rs_img = imagecreatetruecolor($rs_img_width, $rs_img_height);
        imagecopyresampled($rs_img, $sc_img, $rs_x, $rs_y, $sc_x, $sc_y, $rs_img_width, $rs_img_height, $sc_img_width, $sc_img_height);
        imagejpeg($rs_img, $tgtimg, 100);
        imagedestroy($sc_img);
    }

    public function Make_Cartoon_Mobile($chWidth,$srcimg,$tgtimg){


        $sc_x = 0;
        $sc_y = 0;
        $rs_x =0;
        $rs_y =0;

        $size = getimagesize($srcimg);
        $sc_img_width = $size[0];
        $sc_img_height = $size[1];

        // copyresampled 값이 동일하다 why? 이미지의 확대 축소가 발생하지는 않기 때문이다.
        $resize_rule = $chWidth / $sc_img_width;
        $chHeight = ceil($resize_rule * $sc_img_height);
        $rs_img_width = $chWidth;
        $rs_img_height = $chHeight;

        $sc_img = imagecreatefromjpeg($srcimg);
        $rs_img = imagecreatetruecolor($rs_img_width, $rs_img_height);
        imagecopyresampled($rs_img, $sc_img, $rs_x, $rs_y, $sc_x, $sc_y, $rs_img_width, $rs_img_height, $sc_img_width, $sc_img_height);
        imagejpeg($rs_img, $tgtimg, 100);
        imagedestroy($sc_img);
    }

    public function fView(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Scean($pcode,$cnum);
            if(ArrayCount($Rs)<=0){
                alert_close('존재하지 않는 Scene입니다.');
            }else {
                $data = array('data' => $Rs);
                $this->load->view(CMS_MODEL_ROOT . 'freeScene_View', $data);
            }
        }
    }

    public function fView2(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{
            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Scean($pcode,$cnum);
            if(ArrayCount($Rs)<=0){
                alert_close('존재하지 않는 Scene입니다.');
            }else {
                $data = array('data' => $Rs);
                $this->load->view(CMS_MODEL_ROOT . 'freeScene3_View', $data);
            }
        }
    }
}
