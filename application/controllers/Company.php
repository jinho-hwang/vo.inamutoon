<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    
    public function index()
    {
        $tstr=$this->input->post('tstr');
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid),
            'tstr' =>$tstr
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'company_View.php');
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }

    public function GroupList()
    {
        $ccode = $this->uri->segment(3);
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->model(CMS_MODEL_ROOT.'Company_m');
        $Rs = $this->Company_m->Company_Data_Load_Code($ccode);
        $cname = (ArrayCount($Rs)>0) ? $Rs[0]['cname'] : '';

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();

        $data = array(
            'writer' => $wrtier_selectbox,
            'ccode' => $ccode,
            'cname'=> $cname
        );



        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'company_group_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }


    public function GroupLoad(){

        $ccode = $this->uri->segment(3);
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : 
        

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'Company_m');
        $count = $this->Company_m->all_count($ccode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Company_m->Data_Load2($ccode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                   $row->code,$row->email,$row->code,$row->regidate
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

        $tstr=$this->input->post('tstr');
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : 
        

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'Company_m');
        $count = $this->Company_m->all_count($tstr);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->Company_m->Data_Load($tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->code;
                $response->rows[$i]['cell'] = array(
                   $row->code,$row->email,$row->cname,$row->tel,$row->mobile,$row->address,$row->isActive,$row->SKey,$row->code,$row->regidate
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
            $this->load->helper('string');
            $this->load->model(CMS_MODEL_ROOT . 'Company_m');
            $encrypt = random_string('alnum', 10);
            if ($insert_id = $this->Company_m->Data_Add($post, $encrypt)) {
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

    public function GroupAdd(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {

            $ccode = $this->uri->segment(3);
            $wcode = $this->input->post('writer1');
            $this->load->model(CMS_MODEL_ROOT . 'Company_m');
            if ($insert_id = $this->Company_m->Data_Add2($ccode,$wcode)) {
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
    
    public function Data_Update(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Company_m');
            $affected_rows = $this->Company_m->Data_Update($post);

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
            $this->load->model(CMS_MODEL_ROOT . 'Company_m');
            $affected_rows = $this->Company_m->Data_Del($post['id']);

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

    public function GroupDel(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retval = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'Company_m');
            $affected_rows = $this->Company_m->Data_Del2($post['id']);

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

}