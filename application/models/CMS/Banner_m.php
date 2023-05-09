    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Banner_m extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        function Load_All()
        {
            $Query = $this->db->get('tbl_ad_info');
            return $Query->result_array();
        }

        public function all_count()
        {
            $sql = 'SELECT sn FROM tbl_ad_info';
            $query = $this->db->query($sql);
            if (!empty($query)) {
                return $query->num_rows();
            } else {
                return false;
            }
        }

        public function ad_all_count()
        {
            $sql = 'SELECT sn FROM tbl_PC_Ad';
            $query = $this->db->query($sql);
            if (!empty($query)) {
                return $query->num_rows();
            } else {
                return false;
            }
        }

        public function Data_Load($start, $limit, $sidx, $sord)
        {
            $sql = "SELECT * FROM tbl_ad_info ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql);
            return $query;
        }

        public function AdData_Load($start, $limit, $sidx, $sord)
        {
            $sql = "SELECT * FROM tbl_PC_Ad ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql);
            return $query;
        }

        public function AdData_Load2($pcode, $start, $limit, $sidx, $sord)
        {
            $sql = "SELECT * FROM tbl_Cartoon_Ad where pcode=? ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit;
            $query = $this->db->query($sql, $pcode);
            return $query;
        }

        function Data_Add($param)
        {
            $data = array(
                'Described' => $param['Described'],
                'Described2' => $param['Described2'],
                'Described3' => $param['Described3'],
                'Described4' => $param['Described4'],
                'Described5' => $param['Described5'],
                'font_color' => $param['font_color'],
                'mtype' => $param['mtype'],
                'URL' => $param['URL'],
                'isNum' => $param['isNum'],
                'bgcolor' => $param['bgcolor'],
                'isLink' => $param['isLink'],
                'isFix' => $param['isFix'],
            );

            $this->db->trans_start();
            $this->db->insert('tbl_ad_info', $data);
            $insert_id = $this->db->insert_id();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Insert]');
            }

            return $insert_id;
        }

        function AdData_Add($param)
        {
            $data = array(
                'title' => $param['title'],
                'location' => $param['location'],
                'Link' => $param['Link']
            );

            $this->db->trans_start();
            $this->db->insert('tbl_PC_Ad', $data);
            $insert_id = $this->db->insert_id();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Insert]');
            }

            return $insert_id;
        }

        function AdData_Add2($pcode, $param)
        {
            $data = array(
                'pcode' => $pcode,
                'title' => $param['title'],
                'location' => $param['location'],
                'Link' => $param['Link']
            );

            $this->db->trans_start();
            $this->db->insert('tbl_Cartoon_Ad', $data);
            $insert_id = $this->db->insert_id();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Insert]');
            }

            return $insert_id;
        }

        function Update_Main_Filename($sn, $filename)
        {
            $data = array(
                'imgname' => $filename
            );

            $this->db->trans_start();
            $this->db->where('sn', $sn);
            $this->db->update('tbl_ad_info', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner filename Update]');
            }
            return $affected_rows;
        }


        function Data_Update($param)
        {
            $sn = $param['id'];
            $data = array(
                'Described' => $param['Described'],
                'Described2' => $param['Described2'],
                'Described3' => $param['Described3'],
                'Described4' => $param['Described4'],
                'Described5' => $param['Described5'],
                'font_color' => $param['font_color'],
                'mtype' => $param['mtype'],
                'URL' => $param['URL'],
                'isOpen' => $param['isOpen'],
                'isLink' => $param['isLink'],
                'isNum' => $param['isNum'],
                'bgcolor' => $param['bgcolor'],
                'isFix' => $param['isFix'],
                'regidate' => date("Y-m-d H:i:s")
            );

            $this->db->trans_start();
            $this->db->where('sn', $sn);
            $this->db->update('tbl_ad_info', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Update]');
            }
            return $affected_rows;
        }

        function AdData_Update($param)
        {
            $sn = $param['id'];
            $data = array(
                'title' => $param['title'],
                'location' => $param['location'],
                'Link' => $param['Link'],
                'isUse' => $param['isUse']
            );

            $this->db->trans_start();
            $this->db->where('sn', $sn);
            $this->db->update('tbl_PC_Ad', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Update]');
            }
            return $affected_rows;
        }

        function AdData_Update2($param)
        {
            $sn = $param['id'];
            $data = array(
                'title' => $param['title'],
                'location' => $param['location'],
                'Link' => $param['Link'],
                'isUse' => $param['isUse']
            );

            $this->db->trans_start();
            $this->db->where('sn', $sn);
            $this->db->update('tbl_Cartoon_Ad', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Update]');
            }
            return $affected_rows;
        }

        function Data_Del($sn)
        {
            $data = array(
                'sn' => $sn
            );
            $this->db->trans_start();
            $this->db->delete('tbl_ad_info', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Delete]');
            }
            return $affected_rows;
        }

        function AdData_Del($sn)
        {
            $data = array(
                'sn' => $sn
            );
            $this->db->trans_start();
            $this->db->delete('tbl_PC_Ad', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Delete]');
            }
            return $affected_rows;
        }


        function AdData_Del_2($sn)
        {
            $data = array(
                'sn' => $sn
            );
            $this->db->trans_start();
            $this->db->delete('tbl_Cartoon_Ad', $data);
            $affected_rows = $this->db->affected_rows();

            if (!$this->db->trans_complete()) {
                throw new exception('transaction > [Banner Delete]');
            }
            return $affected_rows;
        }
    }