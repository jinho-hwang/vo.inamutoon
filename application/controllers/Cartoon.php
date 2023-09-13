<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartoon extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $typ=$this->input->post('typ');
        $tstr=$this->input->post('tstr');

        $this->load->model('common_m');
        $wrtier_selectbox = $this->common_m->wrtier_selectbox();
        $category_selectbox = $this->common_m->category_selectbox();

        $typ == '' ? $typ='' : $typ=$this->input->post('typ');
        $tstr == '' ? $tstr='' : $tstr=$this->input->post('tstr');


        $data = array(
            'writer' => $wrtier_selectbox,
            'category' => $category_selectbox,
            'typ' =>$typ,
            'tstr' =>$tstr
        );

        $sessionArr = Get_AdminSe_Data($this);
        $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
        $hearder_Data = array(
            'grade' => 1
        );

        $this->load->view(CMS_VIEW_ROOT.'include/header_View.php',$hearder_Data);
        $this->load->view(CMS_VIEW_ROOT.'cartoon_View.php',$data);
        $this->load->view(CMS_VIEW_ROOT.'include/footer_View.php');
    }
    
    public function Data_Load(){

        $typ = ($this->input->post('typ')) ? $this->input->post('typ') : 1;
        $tstr = ($this->input->post('tstr')) ? $this->input->post('tstr') : '';

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';
        

        $totalrows = $this->input->post('totalrows') ? $this->input->post('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->new_all_count();

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->New_Data_Load($typ,$tstr,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->code;
                $response->rows[$i]['cell'] = array(
                    $row->code, $row->imgname, $row->title,$row->code
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

    public function View()
    {
        $pcode = $this->uri->segment(3);
        if(empty($pcode)){
            alert("카툰을 선택하세요.",ROOT_URL.'Cartoon/');
        }else {

            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid = $sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => 1
            );

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);

            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.");
            }else {
                $data = array(
                  'pcode' => $pcode,
                  'c_name' => $Rs[0]['title']
                );

                $this->load->view(CMS_VIEW_ROOT . 'include/header_View.php', $hearder_Data);
                $this->load->view(CMS_VIEW_ROOT . 'sub_cartoon_View', $data);
                $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');
            }
        }
    }

    public function Sub_Data_Load(){


        $pcode = ($this->input->post('pcode')) ? $this->input->post('pcode') : 0;

        $page = ($this->input->post('page')) ? $this->input->post('page') : 1;
        $limit = ($this->input->post('rows')) ? $this->input->post('rows') : 2;
        $sidx = ($this->input->post('sidx')) ? $this->input->post('sidx') : 1;
        $sord = ($this->input->post('sord')) ? $this->input->post('sord') : 'ASC';
        $searchString = ($this->input->post('searchString')) ? $this->input->post('searchString') : '';
        $searchField = ($this->input->post('searchField')) ? $this->input->post('searchField') : '';
        $searchOper = ($this->input->post('searchOper')) ? $this->input->post('searchOper') : '';
        

        $totalrows = $this->input->post('totalrows') ? $this->input->post('totalrows'): false;
        if($totalrows) {
            $limit = $totalrows;
        }
        
        $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
        $count = $this->cartoon_m->Sub_all_count($pcode);

        $total_pages = ($count) ? ceil($count/$limit) : 0;
        $start = $limit * $page - $limit;

        $query = $this->cartoon_m->Sub_Data_Load($pcode,$start, $limit, $sidx, $sord,$searchString,$searchField,$searchOper);
        if (!empty($query)) {
            $response = (object) array();
            $i = 0;

            foreach ($query->result() as $row) {
                $response->rows[$i]['id'] = $row->pcode;
                $response->rows[$i]['cell'] = array(
                    $row->cnum, $row->sub_Title,$row->imgname, $row->cnum,$row->cnum
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
    
    public function fView(){
        $pcode = $this->uri->segment(3);
        $cnum = $this->uri->segment(4);
        if(empty($pcode) || empty($cnum)){
            alert("잘못된 접근입니다.");
        }else{

            $this->load->model(CMS_MODEL_ROOT.'cartoon_m');
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.");
            }else {
                $Rs1 = $this->cartoon_m->Load_Scean($pcode,$cnum);
                if(ArrayCount($Rs1)<=0){
                    alert_close('존재하지 않는 Scene입니다.');
                }else {
                    $data = array('data' => $Rs1);
                    $this->load->view(CMS_MODEL_ROOT . 'freeScene_View', $data);
                }
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
            $Rs = $this->cartoon_m->Load_Cartoon($pcode);
            if(empty($Rs)){
                alert("존재 하지 않는 카툰입니다.");
            }else {
                $Rs1 = $this->cartoon_m->Load_Scean($pcode,$cnum);
                if(ArrayCount($Rs1)<=0){
                    alert_close('존재하지 않는 Scene입니다.');
                }else {
                    $data = array('data' => $Rs1);
                    $this->load->view(CMS_MODEL_ROOT . 'freeScene2_View', $data);
                }
            }
        }
    }


}
