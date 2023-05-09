<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function index()
    {
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
        $this->load->view(CMS_VIEW_ROOT.'blank_View',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function File_Chk(){

        set_time_limit(6000);

        $snum = ($this->uri->segment(3)=='') ? 0 :$this->uri->segment(3);

        $max = 10000000;
        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Scene_Load_All($snum,$max);

        $org1 = '/data/mobile2/';
        $new1 = '/data/mobile/';


        if(ArrayCount($Rs)>0){
            $i=1;
            foreach($Rs as $d) {
                $is_file_exist = file_exists($org1 . $d['imgname']);
                if ($is_file_exist) {
                    $new = $new1 . $d['imgname'];
                    $old = $org1 . $d['imgname'];

                    if (!copy($old, $new)) {
                        echo('no<br>');
                    } else if (file_exists($new)) {
                        echo($i.'<br>');
                        $i++;
                    }
                } else {
                    echo('no<br>');
                }
            }
        }
    }

    public function File_Chk2(){

        set_time_limit(6000);

        $snum = ($this->uri->segment(3)=='') ? 0 :$this->uri->segment(3);

        $max = 10000000;
        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Scene_Load_All($snum,$max);

        $new1 = '/data/mobile/';


        if(ArrayCount($Rs)>0){
            $i=0;
            $j=0;
            foreach($Rs as $d) {
                $is_file_exist = file_exists($new1 . $d['imgname']);
                if (!$is_file_exist) {
                    echo($d['pcode'].'/'.$d['cnum'].'/'.$d['imgname'].'<br>');
                    $i++;
                }else{
                    $j++;
                }
            }
        }

        echo('총없어='.$i.'<br>');
        echo('총있어='.$j.'<br>');
    }


    public function File_Chk3(){

        set_time_limit(6000);

        $snum = ($this->uri->segment(3)=='') ? 0 :$this->uri->segment(3);

        $max = 10000000;
        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Scene_Load_All2($snum,$max);

        $org1 = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/mobile/';
        $new1 = '/data/mobile/';


        if(ArrayCount($Rs)>0){
            $i=1;
            foreach($Rs as $d) {
                $is_file_exist = file_exists($org1 . $d['imgname']);
                if ($is_file_exist) {
                    $new = $new1 . $d['imgname'];
                    $old = $org1 . $d['imgname'];

                    if (!copy($old, $new)) {
                        echo('no<br>');
                    } else if (file_exists($new)) {
                        echo($i.'<br>');
                        $i++;
                    }
                } else {
                    echo('no<br>');
                }
            }
        }
    }

    public function FileDel(){

        set_time_limit(6000);

        $pcode = ($this->uri->segment(3)!='') ? $this->uri->segment(3):0;
        $cnum = ($this->uri->segment(4)!='') ?$this->uri->segment(4) : 0;

        $org1 = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/mobile/';

        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Scene_Load_All3($pcode,$cnum);

        if(ArrayCount($Rs)>0){
            $i=0;
            foreach($Rs as $d) {
                $is_file_exist = file_exists($org1 . $d['imgname']);
                if ($is_file_exist) {
                    $turl = $org1.$d['imgname'];
                    $retval = unlink($turl);
                    if($retval!=0) {
                        echo($d['imgname'] . '   OK<br>');
                        $i++;
                    }else{
                        echo($d['imgname'] . '   NO<br>');
                    }
                } else {
                    echo($d['imgname'].'   NOT<br>');
                }
            }

            $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
            $Cnt = $this->Sub_cartoon_m->Scene_Del_All($pcode,$cnum);
            echo('total='.$i);
            alert_refresh_close('삭제 하였습니다.');
        }
    }

    public function FileCopy(){

        set_time_limit(10000);

        $org1 = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene2/mobile/';
        $new1 = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/mobile/';

        $searchdate = '2021-07-03';

        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Load_Scene_date($searchdate);

        if(ArrayCount($Rs)>0){
            $i=1;
            foreach($Rs as $d) {
                $new = $new1 . $d['imgname'];
                $old = $org1 . $d['imgname'];
                $is_file_exist = file_exists($old);
                if ($is_file_exist) {
                    $is_file_exist2 = file_exists($new);
                    if(!$is_file_exist2) {
                        if (!copy($old, $new)) {
                            echo($d['sn'] . '_no<br>');
                        } else if (file_exists($new)) {
                            echo($i . '<br>');
                            $i++;
                        }
                    }else{
                        echo($d['sn'] . '_exist<br>');
                    }
                } else {
                    echo('no<br>');
                }
            }
            echo('complete');
        }else{
            echo('nothing');
        }
    }

    public function FileDel2(){

        set_time_limit(600000);

        $pcode = ($this->uri->segment(3)!='') ? $this->uri->segment(3):0;

        $org1 = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/mobile/';

        $this->load->model(CMS_MODEL_ROOT.'Sub_cartoon_m');
        $Rs = $this->Sub_cartoon_m->Scene_Load_All4($pcode);

        if(ArrayCount($Rs)>0){
            $i=0;
            foreach($Rs as $d) {
                $is_file_exist = file_exists($org1 . $d['imgname']);
                if ($is_file_exist) {
                    $turl = $org1.$d['imgname'];
                    $retval = unlink($turl);
                    if($retval!=0) {
                        echo($d['imgname'] . '   OK<br>');
                        $i++;
                    }else{
                        echo($d['imgname'] . '   NO<br>');
                    }
                } else {
                    echo($d['imgname'].'   NOT<br>');
                }
            }

            echo('total='.$i);
        }



    }

    public function FileDel3(){

        set_time_limit(600000);

        $directory = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/temp';
        $d = @dir($directory);
        while ($entry = $d->read()) {
            if ($entry == "." || $entry == "..") continue;
            if (is_dir($entry)) delete_all($entry);
            else unlink($directory."/".$entry);
        }
        echo('Temp Folder Clean<br>');
        $directory = '/home/toon/www/content.ebstoon/assets/data/cartoon_scene1/desk';
        $d = @dir($directory);
        while ($entry = $d->read()) {
            if ($entry == "." || $entry == "..") continue;
            if (is_dir($entry)) delete_all($entry);
            else unlink($directory."/".$entry);
        }
        echo('Desk Folder Clean<br>');

    }


}



















































