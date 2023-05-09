<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }
    
    public function index()
    {
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this,$uid)
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'category_View.php');
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }
    
    public function Data_Load(){
        
        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
       
        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'category_m');
        $count = $this->category_m->all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->category_m->Data_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                   $row->code,$row->cname,$row->isActive,$row->regidate
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
            $this->load->model(CMS_MODEL_ROOT . 'category_m');
            if ($insert_id = $this->category_m->Data_Add($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => '',
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
            $this->load->model(CMS_MODEL_ROOT . 'category_m');
            if ($insert_id = $this->category_m->Data_Update($post)) {
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
             $retVal = '';
             $message = 'Not Input Parameter';
         } else {
             $this->load->model(CMS_MODEL_ROOT . 'category_m');
             $affected_rows = $this->category_m->Data_Del($post['id']);

             if ($affected_rows > 0) {
                 $result = true;
                 $retVal = $post['id'];
                 $message = 'Success';
             } else {
                 $result = false;
                 $retVal = '';
                 $message = 'Fail!!';
             }
         }
            
        echo json_encode(array(
            'result' => $result,
            'sn' => $retVal,
            'message' => $message
        ));
    }

    public function Education(){
        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => Load_Grade($this, $uid)
        );

        $this->load->model('common_m');
        $cartoon_selectbox = $this->common_m->cartoon_selectbox_All();
        $main_arr = array(
            'toon' =>$cartoon_selectbox
        );

        $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
        $this->load->view(CMS_VIEW_ROOT . 'education_View',$main_arr);
        $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
    }

    public function EduData_Load(){

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 1;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';

        $totalrows = $this->input->get('totalrows') ? $this->input->get('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }

        $this->load->model(CMS_MODEL_ROOT.'category_m');
        $count = $this->category_m->Eduall_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->category_m->EduData_Load($start, $limit, $sidx, $sord);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->sn;
                $response->rows[$i]['cell'] = array(
                    $row->sn,$row->code,$row->mtype,$row->isUse,$row->regidate
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

    public function EduData_Add(){
        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'category_m');
            if ($insert_id = $this->category_m->EduData_Add($post)) {
                $result = true;
                $message = 'Success';
            } else {
                $result = false;
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'code' => '',
            'message' => $message
        ));
    }

    public function EduData_Update(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'category_m');
            if ($insert_id = $this->category_m->EduData_Update($post)) {
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

    public function EduData_Delete(){

        foreach ($this->input->post() as $key => $value) {
            $post[$key] = $value;
        }

        if (empty($post)) {
            $result = false;
            $retVal = '';
            $message = 'Not Input Parameter';
        } else {
            $this->load->model(CMS_MODEL_ROOT . 'category_m');
            $affected_rows = $this->category_m->EduData_Del($post['id']);

            if ($affected_rows > 0) {
                $result = true;
                $retVal = $post['id'];
                $message = 'Success';
            } else {
                $result = false;
                $retVal = '';
                $message = 'Fail!!';
            }
        }

        echo json_encode(array(
            'result' => $result,
            'sn' => $retVal,
            'message' => $message
        ));
    }

}
    