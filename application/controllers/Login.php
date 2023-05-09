<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $sessionArr = Get_AdminSe_Data($this);
        if(!$sessionArr['islogin']){
            $this->load->view(CMS_VIEW_ROOT.'Login_View');
        }else{
            redirect(ROOT_URL.'Main','refresh');
        }

    }
    
    
    public function Login_do(){
        
        $P_Value = $this->input->post(); 
        
        if(empty($P_Value)){
            $result = false;
        }else{
            $this->load->model(CMS_MODEL_ROOT.'/Member_m');
            $Rs = $this->Member_m->AMember_Data($P_Value);
            if(ArrayCount($Rs) <=0){
                $result = false;
            }else{
                $uid = $Rs[0]['sn'];
                 $LoginData= array(
                     'uid' => $uid,
                     'userid' => $Rs[0]['userid'],
                     'grade' => $Rs[0]['grade'],
                     'islogin' => true
                 );
                $this->session->set_userdata(Set_AdminSe_Data($LoginData));

                $Log = 'Login||'.$Rs[0]['userid'];
                fn_Log($this,$Log);

                $result = true;  
            }
        }
        echo json_encode(array('login' => $result));
    }

    public function Logout(){
        $this->session->sess_destroy();
        redirect(ROOT_URL.'Login','refresh');
    }

}
