<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counsel2 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        TMSLogin($this);
    }

    public function BList(){
        $sessionArr = Get_AdminSe_Data($this);
        if (!$sessionArr['islogin']) {
            redirect(CMS_VIEW_ROOT . '/Login', 'refresh');
        } else {
            $sessionArr = Get_AdminSe_Data($this);
            $sessionArr['islogin'] ? $uid=$sessionArr['uid'] : $uid = 0;
            $hearder_Data = array(
                'grade' => Load_Grade($this,$uid)
            );

            $page = $this->uri->segment(3);
            empty($page) ? $page = 1 : $page = $this->uri->segment(3);

            echo('page='.$page);


            $this->load->model(CMS_MODEL_ROOT . 'Counsel_m');
            $this->load->model(CMS_MODEL_ROOT . 'Cartoon_m');
            $total = $this->Counsel_m->all_count1();

            $per_page = 30;
            $num_links = 4;

            $this->load->library('pagination');
            $config['base_url'] = ROOT_URL.'Counsel2/BList/';
            $config['total_rows'] = $total;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = $num_links;
            $config['per_page'] = $per_page;
            $config['page_query_string'] = FALSE;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);

            $start = ($page - 1) * $per_page;
            $limit = $per_page;
            $Rs = $this->Counsel_m->Data_List_Load($start, $limit);

            $List = array();
            foreach($Rs as $d){
                $temparr = array();

                $temparr['cid'] = $d['cid'];
                $temparr['title'] = $d['title'];
                $temparr['pNum'] = $d['pNum'];

                $new_sub = $this->Cartoon_m->Load_Sub_Title_Down($d['pCode'],$d['pNum']);
                $temparr['subname'] = Sub_Last_Name($new_sub[0]);
                $temparr['sdate'] = String_Nomal_Left($d['startdate'],10);
                $temparr['edate'] = String_Nomal_Left($d['enddate'],10);
                $temparr['status'] = Counsel_Step($d['isStatus']);

                array_push($List,$temparr);


            }




            $data = array(
                'typ' => 0,
                'data' => $List,
                'page' => $this->pagination->create_links()
            );

            $this->load->view(CMS_VIEW_ROOT . 'include/header_View',$hearder_Data);
            $this->load->view(CMS_VIEW_ROOT . 'counsel2_list_View',$data);
            $this->load->view(CMS_VIEW_ROOT . 'include/footer_View');

        }
    }

}