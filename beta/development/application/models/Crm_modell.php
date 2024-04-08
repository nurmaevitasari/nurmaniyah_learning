<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Crm_model extends CI_Model {
    
    var $order = array('cr.id' => 'DESC');
    var $column_order = array(null,'cr.date_closed','cr.id','cr.date_created','perusahaan', null, 'progress', 'prospect_value', 'last_followup', 'progress_sts', null);
    var $column_search = array('cr.id','kr.nickname','cs.perusahaan', 'ncs.perusahaan', 'cs.pic', 'ncs.pic', 'cr.date_created', 'cr.divisi', 'cr.prospect', 'cr.competitor', 'cr.prospect_value', 'cr.last_followup', 'cr.progress', 'cr.date_closed', 'progress_sts', 'cr.status_show', 'cr.status_cancel');
    //var $column_search = array('id','perusahaan','nickname','dates', null);
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $user = $this->session->userdata('myuser');
        $this->load->model('Ftp_model', 'mftp');
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
    private function _get_datatables_query($cons = '')
    {
        $cbg = $_SESSION['myuser']['cabang'];
        $pos_id = $_SESSION['myuser']['position_id'];
        $kar = $_SESSION['myuser']['karyawan_id'];
        $position = strtolower($_SESSION['myuser']['position']);
        $position = substr($position, -3, 3);
        $role_id = $_SESSION['myuser']['role_id'];

        $sql = "SELECT cr.id, cr.link_modul, cr.link_modul_id, cr.divisi, cr.prospect, cr.prospect_value, cr.deal_value, cr.special_note, cr.progress, cr.progress_sts, cr.competitor, cr.posibilities, cr.last_followup, cr.note, cr.status_closed, cr.date_created, cr.date_closed, cr.published, cr.status_show, cr.status_cancel, lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
                        LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
                        LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
                        LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
                        LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
                        LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
                        LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
                        LEFT JOIN tbl_karyawan as kar ON kar.id = kr.karyawan_id
                        LEFT JOIN tbl_crm_contributor co ON (co.crm_id = cr.id AND co.published = 0)
                        WHERE cr.published = '0'";
        
        if($cons == 'Deal') { 
            $sql .= " AND (cr.status_closed = 'Deal')";
        }elseif($cons == 'Loss') {
            $sql .= " AND (cr.status_closed = 'Loss')";
        }else {
            $sql .= " AND (cr.status_closed NOT IN ('Deal', 'Loss'))";
        }
        
        if(in_array($pos_id, array('1', '2', '14', '77', '3', '5', '9'))) 
        {

        }elseif(in_array($pos_id, array('88', '89','93'))) {
            $div = $position;
            $sql .= " AND (cr.divisi = '$div' OR co.contributor = '$kar')";  
        }elseif(in_array($pos_id, array('90', '92'))) {
            $sql .= " AND (cr.divisi IN ('DCE', 'DGC') OR co.contributor = '$kar')";
        }elseif(in_array($pos_id, array('91', '100'))) {
            $sql .= " AND (cr.divisi IN ('DHE', 'DWT') OR co.contributor = '$kar')";    
        }elseif(in_array($cbg, array('Bandung', 'Surabaya', 'Medan')) AND ($role_id == '1')) {
            $sql .= " AND (kar.cabang = '$cbg' OR cr.sales_id = '$kar' OR co.contributor = '$kar')";
        }else {
            $sql .= " AND (cr.sales_id = '$kar' OR co.contributor = '$kar')";
        } 

        $i = 0;
     
        foreach ($this->column_search as $item) // loop column
        { 
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    //$sql .= $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    //$sql .= $this->db->like($item, $_POST['search']['value']);

                    $sql .= " AND (".$item." LIKE '%".$_POST['search']['value']."%'";
                }
                else
                {
                    //$sql .=$this->db->or_like($item, $_POST['search']['value']);
                    $sql .= " OR ".$item." LIKE '%".$_POST['search']['value']."%'";
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    //$sql .= $this->db->group_end(); //close bracket
                    $sql .= " ) ";
            }
            $i++;
        }

        $sql .= " GROUP BY cr.id";

        if(isset($_POST['order'])) // here order processing
        {
           //$sql .= $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            if($cons == 'Deal') {
                $column_order = array(null,'cr.date_closed','cr.id','cr.date_created','perusahaan', null, 'progress', 'deal_value', 'last_followup', null);
            }
            $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." ";
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            //$sql .= $this->db->order_by(key($order), $order[key($order)]);

            if($cons != '') {
                $order = array('cr.date_closed' => 'DESC');
            }

            $sql .= " ORDER BY ".key($order)." ".$order[key($order)]." ";
        }

        return $sql;
        
    }
 
    function get_datatables($cons)
    {
        $sql = $this->_get_datatables_query($cons);

        if($_POST['length'] != -1)
        //$sql .= $this->db->limit($_POST['length'], $_POST['start']);
        $sql .= " LIMIT ".$_POST['start'].",".$_POST['length'];
    
        $query = $this->db->query($sql);    
        
        //print_r($sql); exit();
        return $query->result();
    }
 
    function count_filtered($cons)
    {
        $sql = $this->_get_datatables_query($cons);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
 
    public function count_all($cons)
    {
        $sql = $this->_get_datatables_query($cons);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function getDetail($id)
        {   
            $sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, IF (cr.customer_type = 1, cs.email, ncs.email) AS email, IF (cr.customer_type = 1, cs.telepon, ncs.telepon) AS telepon, IF (cr.customer_type = 1, cs.tlp_hp, ncs.tlp_hp) AS tlp_hp, kr.nama, cs.id_customer FROM tbl_crm cr 
                    LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
                    LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
                    LEFT JOIN tbl_karyawan as kr ON kr.id = cr.sales_id
                    WHERE cr.id = $id";
            $rowarr = $this->db->query($sql)->row_array();
            
            return $rowarr;     
        }

        public function getLink($id)
        {
            $sql = "SELECT IF(sps.id = 'NULL', '', sps.job_id) as job_id, li.link_to_id, li.link_to_modul as link_modul, sps.id FROM tbl_link li 
                LEFT JOIN tbl_crm crm ON (crm.id = li.link_from_id AND li.link_from_modul = '8') 
                LEFT JOIN tbl_sps sps ON (sps.id = li.link_to_id AND li.link_to_modul = '3') 
                WHERE li.link_from_id = $id";
            $res = $this->db->query($sql)->result_array();
            
            return $res;    

        }

        public function getGroupLink($id)
        {
            $sql = "SELECT li.*, lm.nama_modul FROM tbl_link li
                    LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
                    WHERE li.link_from_modul = '8' AND li.link_from_id = '$id' GROUP BY li.link_to_modul ASC";
            $res = $this->db->query($sql)->result_array();
            
            return $res;    

        }

        public function gethighlight($id)
        {
            $sql = "SELECT hl.date_finish,hl.date_created,hl.id,hl.highlight, hl.status, hl.notes, hl.user, hl.notes_user,lg.nickname, lgn.nickname as user_fin
                    FROM tbl_crm_highlight hl
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = hl.user
                    LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hl.notes_user
                    WHERE hl.crm_id = $id GROUP BY hl.id";
            $query = $this->db->query($sql)->result_array();
 
            return $query;
        } 

        public function getFiles($id)
        {
            $sql = "SELECT up.*, lg.nickname FROM tbl_upload_crm up
                    LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = up.uploader
                    WHERE up.crm_id = $id ";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getLog($id)
        {
            /* $sql = "SELECT lo.*, lg.nickname, ps.pesan, lgap.nickname as name_approval FROM tbl_crm_log lo
                    LEFT JOIN tbl_crm cr ON cr.log_crm_id = lo.id
                    LEFT JOIN tbl_crm_pesan ps ON ps.log_crm_id = lo.id
                    LEFT JOIN tbl_loginuser lg ON lo.user_id = lg.karyawan_id
                    LEFT JOIN tbl_loginuser lgap ON lgap.karyawan_id = lo.user_approval
                    LEFT JOIN tbl_crm_progress_approval ap ON (ap.id = lo.crm_type_id AND lo.crm_type = 'Approval Progress')
                    WHERE lo.crm_id = $id GROUP BY lo.id ASC"; */

            $sql = "SELECT lo.*, lg.nickname, ps.pesan, kr.cabang FROM tbl_crm_log lo
                    LEFT JOIN tbl_crm cr ON cr.log_crm_id = lo.id
                    LEFT JOIN tbl_crm_pesan ps ON ps.log_crm_id = lo.id
                    LEFT JOIN tbl_loginuser lg ON lo.user_id = lg.karyawan_id
                    LEFT JOIN tbl_crm_progress_approval ap ON (ap.id = lo.crm_type_id AND lo.crm_type = 'Approval Progress')
                    LEFT JOIN tbl_karyawan kr ON kr.id = ap.user
                    WHERE lo.crm_id = $id GROUP BY lo.id ASC";

            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getLogApproval($log_id) {
            $sql = "SELECT log_id, lgap.nickname as name_appr, status_approval as status_appr, date_approval as date_appr, note as note_appr 
                    FROM tbl_crm_log_approval lapr
                    LEFT JOIN tbl_loginuser lgap 
                    ON lgap.karyawan_id = lapr.user_approval
                    WHERE lapr.log_id = '$log_id' 
                    GROUP BY lapr.id";
            return $this->db->query($sql)->result_array();        
        }

        public function getEmployee()
        {
            $user = $_SESSION['myuser']['karyawan_id'];
            $sql = "SELECT id, nama FROM tbl_karyawan 
                    WHERE published = '1' AND id != $user ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getKaryawan($id)
        {
            $sql = "SELECT id, nama FROM tbl_karyawan 
                    WHERE published = '1' AND id NOT IN (SELECT contributor FROM tbl_crm_contributor WHERE crm_id = $id AND published = 0 GROUP BY contributor) ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function selKaryawan()
        {
            $sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
                    LEFT JOIN tbl_position ps ON kr.position_id = ps.id
                    WHERE published = 1 AND kr.id NOT IN ('101', '109', '123', '133') ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getContributor($id)
        {
            $sql = "SELECT lg.nickname FROM tbl_crm_contributor cr
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cr.contributor
                    WHERE cr.crm_id = $id AND cr.published = 0 GROUP BY lg.nickname ASC";
            return $this->db->query($sql)->result_array();      
        }

        public function CheckContributor($id)
        {
            $kar_id = $_SESSION['myuser']['karyawan_id'];
            $sql = "SELECT cr.published FROM tbl_crm_contributor cr
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cr.contributor
                    WHERE cr.crm_id = $id AND cr.contributor = '$kar_id' GROUP BY lg.nickname ASC";
            return $this->db->query($sql)->row_array();      
        }

        public function getKetentuan($id = '')
        {
            $sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan 
                LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
                WHERE tbl_ketentuan.nama_modul = '8'
                ORDER BY tbl_ketentuan.id DESC LIMIT 1";
            return $this->db->query($sql)->row_array(); 
        }

        public function getApprovalData($appr_id)
        {
            $sql = "SELECT * FROM tbl_crm_progress_approval WHERE id = '$appr_id'";
            return $this->db->query($sql)->row_array();
        }

        private function getKarData($kar_id)
        {
            $sql = "SELECT lg.nickname, ps.position FROM tbl_karyawan kr
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = kr.id
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    WHERE kr.id = '$kar_id'";
            return $this->db->query($sql)->row_array();        
        }

        public function getChangeSales($id)
        {
            $sql = "SELECT lg.nickname as nick_exist, lg2.nickname as nick_new FROM tbl_crm_change_sales cs 
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cs.sales_exist
                    LEFT JOIN tbl_loginuser lg2 ON lg2.karyawan_id = cs.sales_new
                    WHERE cs.crm_id = '$id' ORDER BY cs.id DESC";

            return $this->db->query($sql)->result_array();        
        }

        public function addData()
        {
            if($this->input->post())
            {   
                $sales          = $_SESSION['myuser']['karyawan_id'];
                $div            = $this->input->post('divisi');
                $cust_type      = $this->input->post('cust_type');
                $non_cust_id    = $this->input->post('non_cust_id');
                $cust_id        = $this->input->post('customer_id');
                $source         = $this->input->post('source');
                $site           = $this->input->post('site');
                $prospect_value = $this->input->post('prospect_value');
                $prospect_value = str_replace(".", "", $prospect_value);
                $competitor     = $this->input->post('competitor');
                $prospect_desc  = $this->input->post('prospect_desc');
                $progress       = $this->input->post('progress');
                $posibilities   = $this->input->post('posibilities');
                $special_note   = $this->input->post('special_note');
                $date           = date('Y-m-d H:i:s');
                $progress_note  = $this->input->post('progress_note');
                $contributor    = $this->input->post('contributor');
                $lain           = $this->input->post('lain');
                $deal_value     = $this->input->post('deal_value');
                $deal_value     = str_replace(".", "", $deal_value);
                $cust   = $this->input->post('nama_cust');
                $pic    = $this->input->post('pic_name');
                $alamat = $this->input->post('alamat_cust');
                $tlp    = $this->input->post('telepon_pstn');
                $fax    = $this->input->post('fax');
                $hp     = $this->input->post('tlp_hp');
                $email  = $this->input->post('email');
                $note   = $this->input->post('note');

                
                if($cust_type == 0)
                {
                    $cust_type = '0';

                    $insert = array(
                    'modul_type'    => '8',
                    'perusahaan'    => $cust,
                    'pic'           => $pic,
                    'alamat'        => $alamat,
                    'email'         => $email,
                    'telepon'       => $tlp,
                    'fax'           => $fax,
                    'tlp_hp'        => $hp,
                    'note'          => $note,
                    'date_created'  => date('Y-m-d H:i:s'), 
                );
                $this->db->insert('tbl_non_customer', $insert);
                $non_cust_id = $this->db->insert_id();

                $customer_id = $non_cust_id;

                }elseif ($cust_type == 1) {
                    $customer_id = $cust_id;
                }

                if($lain) {
                    $source = $lain;
                }

                switch ($progress) {
                    case 'Introduction':
                        $progress_num = '2';
                        break;
                    case 'Quotation':
                        $progress_num = '3';
                        break;    
                    case 'Negotiation':
                        $progress_num = '4';
                        break;
                    case 'Deal':
                        $progress_num = '5';
                        break;
                    case 'Loss':
                        $progress_num = '1';
                        break;        
                }
                
                $ins_crm = array(
                    'sales_id'          => $sales,
                    'divisi'            => $div,
                    'customer_id'       => $customer_id,
                    'customer_type'     => $cust_type,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'source'            => $source,
                    'prospect'          => $prospect_desc,
                    'prospect_value'    => $prospect_value,
                    'site'              => $site,
                    'special_note'      => $special_note,
                    'progress'          => $progress,
                    'progress_num'      => $progress_num,
                    'competitor'        => $competitor,
                    'posibilities'      => $posibilities,
                    'deal_value'        => $deal_value,
                );
                $this->db->insert('tbl_crm', $ins_crm);
                $crm_id = $this->db->insert_id();
                
                $ins_log = array(
                    'crm_id'        => $crm_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'crm_type'      => 'New',
                    'crm_type_id'   => $crm_id,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                );
                $this->db->insert('tbl_crm_log', $ins_log);
                $log_id = $this->db->insert_id();

                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('log_crm_id' => $log_id));

                if($progress == 'Deal')
                {   
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', array('status_closed'  => $progress,
                                                        'date_closed'   => date('Y-m-d H:i:s'),
                                                        'status_show'   => 'Undelivered'));

                }

                $ins_pesan = array(
                    'crm_id'        => $crm_id,
                    'log_crm_id'    => $log_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'sender'        => $sales,
                    'pesan'         => 'Membuat data Prospek Baru.',
                );
                $this->db->insert('tbl_crm_pesan', $ins_pesan);

                $progress_log = array(
                    'crm_id'        => $crm_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'crm_type'      => 'Progress',
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                );
                $this->db->insert('tbl_crm_log', $progress_log);
                $log_prgs_id = $this->db->insert_id();
                
                $ins_prog = array(
                    'crm_id'        => $crm_id,
                    'log_crm_id'    => $log_prgs_id,
                    'user_id'       => $sales,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'progress'      => $progress,
                    'posibilities'  => $posibilities,
                    'date_progress' => date('Y-m-d'),
                    'progress_note' => $progress_note,
                );
                $this->db->insert('tbl_crm_progress', $ins_prog);
                $prog_id = $this->db->insert_id();

                $this->db->where('id', $log_prgs_id);
                $this->db->update('tbl_crm_log', array('crm_type_id' => $prog_id));

                $sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
                $rows = $this->db->query($sql)->num_rows();

                if($rows >= 1) {
                    $co = sprintf("%02s", $rows);

                    $pesan = array(
                        'crm_id'     => $crm_id,
                        'log_crm_id' => $log_prgs_id,
                        'sender'     => $sales,
                        'pesan'      => 'Progress #'.$co." : ".date('d/m/Y')." Progress : ".$progress." / ".$posibilities."% <br>
                                        Progress Note : ".$progress_note,
                        'date_created' => date('Y-m-d H:i:s'),              
                    );
                    $this->db->insert('tbl_crm_pesan', $pesan);
                }
                
                $sql = "INSERT INTO tbl_crm_contributor (crm_id, user_id, contributor, date_created) 
                        SELECT '$crm_id', '$sales', '$sales', '$date' FROM tbl_crm 
                        WHERE id = '$crm_id' GROUP BY sales_id";
                $this->db->query($sql);

                if($contributor) {
                    $this->addContributor($contributor, $crm_id);
                }
                
                $this->last_update($crm_id);

                $this->notification($crm_id, $crm_id, '1');

                $this->uploadfiles($crm_id);

                return $crm_id;
            }
        }

        public function add_pesan()
        {
            $crm_id = $this->input->post('crm_id');
            $msg = $this->input->post('msg');

            $log = array(
                'crm_id'        => $crm_id,
                'date_created'  => date('Y-m-d H:i:s'),
                'crm_type'      => 'Pesan',
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
            );
            $this->db->insert('tbl_crm_log', $log);
            $log_id = $this->db->insert_id();

            $pesan = array(
                'crm_id'     => $crm_id,
                'log_crm_id' => $log_id,
                'sender'     => $_SESSION['myuser']['karyawan_id'],
                'pesan'      => $msg,
                'date_created' => date('Y-m-d H:i:s'),              
            );
            $this->db->insert('tbl_crm_pesan', $pesan);
            $psn_id = $this->db->insert_id();

            $this->db->where('id', $log_id);
            $this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

            $this->notification($crm_id, $psn_id, '2');

            $cc = $this->CheckContributor($crm_id);

            if(empty($cc)) {
                $args = array(
                    'crm_id'        => $crm_id,
                    'contributor'   => $_SESSION['myuser']['karyawan_id'],
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_crm_contributor', $args);
            }

            //$this->last_update($crm_id);
        }


        public function add_customer()
        {
            if($this->input->post())
            {
                $cust   = $this->input->post('nama_cust');
                $pic    = $this->input->post('pic');
                $alamat = $this->input->post('alamat');
                $tlp    = $this->input->post('telepon');
                $fax    = $this->input->post('fax');
                $hp     = $this->input->post('tlp_hp');
                $email  = $this->input->post('email');
                $note   = $this->input->post('note');

                $insert = array(
                    'modul_type'    => '8',
                    'perusahaan'    => $cust,
                    'pic'           => $pic,
                    'alamat'        => $alamat,
                    'email'         => $email,
                    'telepon'       => $tlp,
                    'fax'           => $fax,
                    'tlp_hp'        => $hp,
                    'note'          => $note,
                    'date_created'  => date('Y-m-d H:i:s'), 
                );
                $this->db->insert('tbl_non_customer', $insert);
                $non_cust_id = $this->db->insert_id();  

                return array('non_cust_id' => $non_cust_id,
                    'nama_cust' => $cust);
            }
        }

        public function addNotes()
        {
            $id = $this->input->post('id_crm');
            $notes = $this->input->post('notes');

            $insert = array(
                'crm_id'        => $id,
                'notes'         => $notes,
                'date_created'  => date('Y-m-d H:i:s'),
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
                'notes_type'    => '1',
                );
            $this->db->insert('tbl_crm_notes', $insert);
            $note_id = $this->db->insert_id();

            $this->db->where('id', $id);
            $this->db->update('tbl_crm', array('note' => $note_id));

            //logall
            //notification
        }

        public function addContributor($contributor = '', $crm_id = '')
        {
            
            if($contributor == '' AND $crm_id == '') {
                $contributor = $this->input->post('contributor');
                $crm_id = $this->input->post('crm_id');
            }
            
            foreach ($contributor as $con) {
                $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$con'";
                $row = $this->db->query($sql)->row_array();

                $args = array(
                    'crm_id'        => $crm_id,
                    'contributor'   => $con,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_crm_contributor', $args);
                $con_id = $this->db->insert_id();

                $ins_log = array(
                    'crm_id'        => $crm_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'crm_type'      => 'Contributor',
                    'crm_type_id'   => $crm_id,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                );
                $this->db->insert('tbl_crm_log', $ins_log);
                $log_id = $this->db->insert_id();

                $pesan = array(
                    'crm_id'        => $crm_id,
                    'log_crm_id'    => $log_id,
                    'pesan'         => $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor",
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_crm_pesan', $pesan); 

                $notif = array(
                    'modul_id'      => $crm_id,
                    'user_id'       => $con,
                    'record_id'     => $con_id,
                    'record_type'   => '16',
                    'status'        => '0',
                    'modul'         => '8',
                    'date_created'  =>  date('Y-m-d H:i:s'),    
                    );
                $this->db->insert('tbl_notification', $notif);

                $this->last_update($crm_id);

            }
        }

        public function FollowUp()
        {
            $tgl_follow1 = $this->input->post('tgl_follow');
            $tgl_follow = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_follow1);
            $crm_id     = $this->input->post('crm_id');
            $pic        = $this->input->post('pic');
            $via        = $this->input->post('via');
            $hasil      = $this->input->post('hasil');
            $crm_id     = $this->input->post('crm_id');

            $log = array(
                'crm_id'        => $crm_id,
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
                'crm_type'      => 'FollowUp',
                'date_created'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_crm_log', $log);
            $log_id = $this->db->insert_id();

            $inst = array(
                'crm_id'        => $crm_id,
                'log_crm_id'    => $log_id,
                'date_follow'   => $tgl_follow,
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
                'via'           => $via,
                'pic'           => $pic,
                'hasil'         => $hasil,
                'date_created'  => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_crm_followup', $inst);
            $fol_id = $this->db->insert_id();

            $this->db->where('id', $log_id);
            $this->db->update('tbl_crm_log', array('crm_type_id' => $fol_id));

            //$this->db->where('id', $crm_id);
            //$this->db->update('tbl_crm', array('last_followup' => $tgl_follow." ".date('H:i:s')));

            $sql = "SELECT id FROM tbl_crm_followup WHERE crm_id = '$crm_id' ";
            $rows = $this->db->query($sql)->num_rows();

            if($rows >= 1) {
                $co = sprintf("%02s", $rows);

                $pesan = array(
                    'crm_id'     => $crm_id,
                    'log_crm_id' => $log_id,
                    'sender'     => $_SESSION['myuser']['karyawan_id'],
                    'pesan'      => 'Follow Up #'.$co." : ".$tgl_follow1." Via ".$via." / ".$pic."<br>
                                    Hasil Follow Up : ".$hasil,
                    'date_created' => date('Y-m-d H:i:s'),              
                );
                $this->db->insert('tbl_crm_pesan', $pesan);
            }

            $this->last_update($crm_id);

            $this->notification($crm_id, $fol_id, '17');


        }

        /* public function addProgress()
        {
            $crm_id         = $this->input->post('crm_id');
            $tgl_upprgs1    = $this->input->post('tgl_upprgs');
            $tgl_upprgs     = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_upprgs1);
            $progress       = $this->input->post('progress');
            $posibilities   = $this->input->post('posibilities');
            $prgs_note      = $this->input->post('prgs_note');
            $value          = $this->input->post('deal_value');
            $value          = str_replace(".", "", $value);
            $competitor     = $this->input->post('competitor');

            $insert = array(
                'crm_id' => $crm_id,
                'user_id'   => $_SESSION['myuser']['karyawan_id'],
                'progress'  => $progress,
                'posibilities'  => $posibilities,
                'progress_note' => $prgs_note,
                'date_created' => date('Y-m-d H:i:s'),
                'date_progress' => $tgl_upprgs,
                );
            $this->db->insert('tbl_crm_progress', $insert);
            $prgs_id = $this->db->insert_id();

            $log = array(
                'crm_id' => $crm_id,
                'user_id'   => $_SESSION['myuser']['karyawan_id'],
                'crm_type'  => 'Progress',
                'crm_type_id'   => $prgs_id,
                'date_created' => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_crm_log', $log);
            $log_id = $this->db->insert_id();

            $this->db->where('id', $prgs_id);
            $this->db->update('tbl_crm_progress', array('log_crm_id' => $log_id));

            if($progress != 'Loss') {
                $up_crm = array(
                'progress'      => $progress,
                'posibilities'  => $posibilities,
                );
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', $up_crm);
            }
            
            if($progress == 'Deal' OR $progress == 'Loss') {
                $up_crm = array(
                    'date_closed'   => date('Y-m-d H:i:s'),
                    'status_closed' => $progress,
                    'posibilities'  => $posibilities,           
                );
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', $up_crm);
            }elseif($progress != 'Deal' OR $progress != 'Loss') {
                $up_crm = array(
                    'date_closed'   => '0000-00-00 00:00:00',
                    'status_closed' => '',
                    'posibilities'  => $posibilities,           
                );
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', $up_crm);
            }

            $sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
            $rows = $this->db->query($sql)->num_rows();

            if($rows >= 1) {
                $co = sprintf("%02s", $rows);

                $sql = "SELECT prospect_value, competitor FROM tbl_crm WHERE id = $crm_id";
                $query = $this->db->query($sql)->row_array();
                $prosval = $query['prospect_value'];
                $comp = $query['competitor'];

                $pesan = 'Progress #'.$co." : ".$tgl_upprgs1." Progress : ".$progress." / ".$posibilities."% <br>"; 
                
                if($progress != 'Deal' AND $prosval != $value) {
                    $pesan .= "Change Prospect Value from Rp. ".number_format($prosval, '0', ',', '.')." to Rp. ".number_format($value, "0", ",", ".")."<br>";
                }

                if($competitor != $comp) {
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', array('competitor' => $competitor));
                    
                    $pesan .= 'Update Competitor : '.$competitor."<br>";
                }   

                $pesan .= "Progress Note : ".$prgs_note."<br>";

                $pesan = array(
                    'crm_id'     => $crm_id,
                    'log_crm_id' => $log_id,
                    'sender'     => $_SESSION['myuser']['karyawan_id'],
                    'pesan'      => $pesan,
                    'date_created' => date('Y-m-d H:i:s'),              
                );
                $this->db->insert('tbl_crm_pesan', $pesan);
            }

            if($progress == 'Deal') {
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('deal_value' => $value));
            }elseif ($progress != 'Deal') {
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('prospect_value' => $value));
            }


            $this->last_update($crm_id);

            $this->notification($crm_id, $fol_id, '18');
        } */

        public function addProgress()
        {
            $crm_id         = $this->input->post('crm_id');
            $tgl_upprgs1    = $this->input->post('tgl_upprgs');
            $tgl_upprgs     = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_upprgs1);
            $progress_num   = $this->input->post('progress');
            $posibilities   = $this->input->post('posibilities');
            $prgs_note      = $this->input->post('prgs_note');
            $value          = $this->input->post('deal_value');
            $value          = str_replace(".", "", $value);
            $competitor     = $this->input->post('competitor');

            switch ($progress_num) {
                case '2':
                    $progress = 'Introduction';
                    break;
                case '3':
                    $progress = 'Quotation';
                    break;    
                case '4':
                    $progress = 'Negotiation';
                    break;
                case '5':
                    $progress = 'Deal';
                    break;
                case '1':
                    $progress = 'Loss';
                    break;        
            }

            $getDetails = $this->getDetail($crm_id);
            $last_prgnum = $getDetails['progress_num'];
            $last_value = $getDetails['prospect_value'];
            $last_competitor = $getDetails['competitor'];
            $last_progress = $getDetails['progress'];

            if($progress_num < $last_prgnum AND !in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93','100'))) {
                $insert = array(
                    'crm_id'            => $crm_id,
                    'user'              => $_SESSION['myuser']['karyawan_id'],
                    'progress'          => $progress,
                    'progress_num'      => $progress_num,
                    'posibilities'      => $posibilities,
                    'note'              => $prgs_note,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'upprogress_date'   => $tgl_upprgs,
                );
                $this->db->insert('tbl_crm_progress_approval', $insert);
                $progress_approval_id = $this->db->insert_id();

                if($last_value != $value) {
                    $this->db->where('id', $progress_approval_id);
                    $this->db->update('tbl_crm_progress_approval', array('value' => $value));
                }

                if($last_competitor != $competitor) {
                    $this->db->where('id', $progress_approval_id);
                    $this->db->update('tbl_crm_progress_approval', array('competitor' => $competitor));
                }

                $log = array(
                    'crm_id' => $crm_id,
                    'user_id'   => $_SESSION['myuser']['karyawan_id'],
                    'crm_type'  => 'Approval Progress',
                    'crm_type_id'   => $progress_approval_id,
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_crm_log', $log);
                $log_id = $this->db->insert_id();

                $isi_pesan = "Mengajukan penurunan Progress dari ".$last_progress." menjadi ".$progress." <br>";
                $isi_pesan .= "Alasan : ".$prgs_note;

                $pesan = array(
                    'crm_id'     => $crm_id,
                    'log_crm_id' => $log_id,
                    'sender'     => $_SESSION['myuser']['karyawan_id'],
                    'pesan'      => $isi_pesan,
                    'date_created' => date('Y-m-d H:i:s'),              
                );
                $this->db->insert('tbl_crm_pesan', $pesan);

                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('progress_sts' => '1'));

                if(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57'))) {
                    $this->db->where('id', $log_id);
                    $this->db->update('tbl_crm_log', array('lvl_approval' => 'Kacab'));
                }

                $this->notification($crm_id, $progress_approval_id, '13');


            }elseif($progress_num >= $last_prgnum OR in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) {
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('progress_num' => $progress_num, 'status_cancel' => ''));

                $insert = array(
                    'crm_id' => $crm_id,
                    'user_id'   => $_SESSION['myuser']['karyawan_id'],
                    'progress'  => $progress,
                    'posibilities'  => $posibilities,
                    'progress_note' => $prgs_note,
                    'date_created' => date('Y-m-d H:i:s'),
                    'date_progress' => $tgl_upprgs,
                );
                $this->db->insert('tbl_crm_progress', $insert);
                $prgs_id = $this->db->insert_id();

                $log = array(
                    'crm_id' => $crm_id,
                    'user_id'   => $_SESSION['myuser']['karyawan_id'],
                    'crm_type'  => 'Progress',
                    'crm_type_id'   => $prgs_id,
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_crm_log', $log);
                $log_id = $this->db->insert_id();

                $this->db->where('id', $prgs_id);
                $this->db->update('tbl_crm_progress', array('log_crm_id' => $log_id));

                if($progress != 'Loss') {
                    $up_crm = array(
                        'progress'      => $progress,
                        'posibilities'  => $posibilities,
                    );
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', $up_crm);
                }

                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('progress_sts' => '0'));


                $this->notification($crm_id, $prgs_id, '18');
            }

            
            
            if($progress == 'Deal' OR $progress == 'Loss') {
                $up_crm = array(
                    'date_closed'   => date('Y-m-d H:i:s'),
                    'status_closed' => $progress,
                    'posibilities'  => $posibilities,           
                );
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', $up_crm);
                
            }elseif($progress != 'Deal' OR $progress != 'Loss') {
                $up_crm = array(
                    'date_closed'   => '0000-00-00 00:00:00',
                    'status_closed' => '',
                    'posibilities'  => $posibilities,           
                );
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', $up_crm);
            }

            $sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
            $rows = $this->db->query($sql)->num_rows();

            if($rows >= 1) {
                $co = sprintf("%02s", $rows);

                $sql = "SELECT prospect_value, competitor FROM tbl_crm WHERE id = $crm_id";
                $query = $this->db->query($sql)->row_array();
                $prosval = $query['prospect_value'];
                $comp = $query['competitor'];

                $pesan = 'Progress #'.$co." : ".$tgl_upprgs1." Progress : ".$progress." / ".$posibilities."% <br>"; 
                
                if($progress != 'Deal' AND $prosval != $value) {
                    $pesan .= "Change Prospect Value from Rp. ".number_format($prosval, '0', ',', '.')." to Rp. ".number_format($value, "0", ",", ".")."<br>";
                }

                if($competitor != $comp) {
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', array('competitor' => $competitor));
                    
                    $pesan .= 'Update Competitor : '.$competitor."<br>";
                }   

                $pesan .= "Progress Note : ".$prgs_note."<br>";

                $pesan = array(
                    'crm_id'     => $crm_id,
                    'log_crm_id' => $log_id,
                    'sender'     => $_SESSION['myuser']['karyawan_id'],
                    'pesan'      => $pesan,
                    'date_created' => date('Y-m-d H:i:s'),              
                );
                $this->db->insert('tbl_crm_pesan', $pesan);
            }

            if($progress == 'Deal') {
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('deal_value' => $value, 'status_show' => 'Undelivered'));
            }elseif ($progress != 'Deal') {
                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('prospect_value' => $value, 'deal_value' => '0'));
            }

            if($progress == 'Loss' AND in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93','100'))) 
            {
                $sql = "SELECT progress FROM tbl_crm_progress WHERE crm_id = $crm_id AND progress = 'Deal'";
                $count_deal = $this->db->query($sql)->num_rows();
                
                if($count_deal >= 1) 
                {
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', array('status_cancel' => 'Cancel Dealt'));
                }
            }


            $this->last_update($crm_id);
        }


         public function last_update($crm_id)
        {
            $pg = array(
            'last_followup' => date('Y-m-d H:i:s'),
            'user_last_followup' => $_SESSION['myuser']['karyawan_id'],
            'date_reminder' => date("Y-m-d", strtotime("+14 day")),
            'two_day_reminder' => '0000-00-00',
            );
            $this->db->where('id', $crm_id);
            $this->db->update('tbl_crm',$pg);
        }

        public function ApprovalProgress($type, $crm_id, $appr_id ='', $log_id = '')
        {
            $alasan = '';
            if($type == '2') {
                $appr_id    = $this->input->post('progress_approval_id');
                $log_id     = $this->input->post('log_id');
                $alasan     = $this->input->post('notes');

                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('progress_sts' => '3', 'status_closed' => '', 'date_closed' => '0000-00-00 00:00:00'));

            }elseif ($type == '1' AND $_SESSION['myuser']['cabang'] == '') {
                $app = $this->getApprovalData($appr_id);
                
                $progress_date1 = $app['upprogress_date'];
                $progress_date  = date('d/m/Y', strtotime($progress_date1));
                $progress_num   = $app['progress_num'];
                $progress       = $app['progress'];
                $posibilities   = $app['posibilities'];
                $note           = $app['note'];
                $value          = $app['value'];
                $competitor     = $app['competitor'];
                $user           = $app['user'];

                if($value != '0') {
                    $this->db->where('id', $appr_id);
                    $this->db->update('tbl_crm', array('prospect_value' => $value, 'deal_value' => '0'));
                }

                if(!empty($competitor)) {
                    $this->db->where('id', $appr_id);
                    $this->db->update('tbl_crm', array('competitor' => $competitor));
                }

                if($progress_num == '1')
                {
                    $up_crm = array(
                        'date_closed'   => date('Y-m-d H:i:s'),
                        'status_closed' => $progress,
                        'progress_num'  => $progress_num,
                        'posibilities'  => $posibilities,
                    );
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', $up_crm);

                    $sql = "SELECT progress FROM tbl_crm_progress WHERE crm_id = $crm_id AND progress = 'Deal'";
                    $count_deal = $this->db->query($sql)->num_rows();

                    if($count_deal >= 1) {
                        $this->db->where('id', $crm_id);
                        $this->db->update('tbl_crm', array('status_cancel' => 'Cancel Dealt'));
                    }
                }else {
                    $ins_crm = array(
                        'progress'      => $progress,
                        'progress_num'  => $progress_num,
                        'posibilities'  => $posibilities,
                        'date_closed'   => '0000-00-00 00:00:00',
                        'status_closed' => '',
                    );
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', $ins_crm);
                }

                $insert = array(
                    'crm_id'        => $crm_id,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'progress'      => $progress,
                    'posibilities'  => $posibilities,
                    'progress_note' => $note,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'date_progress' => $progress_date,
                );
                $this->db->insert('tbl_crm_progress', $insert);
                $prgs_id = $this->db->insert_id();

                $sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
                $rows = $this->db->query($sql)->num_rows();

                if($rows >= 1) {
                    $co = sprintf("%02s", $rows);

                    $sql = "SELECT prospect_value, competitor FROM tbl_crm WHERE id = $crm_id";
                    $query = $this->db->query($sql)->row_array();
                    $prosval = $query['prospect_value'];
                    $comp = $query['competitor'];

                    $pesan = 'Progress #'.$co." : ".$progress_date." Progress : ".$progress." / ".$posibilities."% <br>"; 
                    
                    if($prosval != $value AND $value != '0') {
                        $pesan .= "Change Prospect Value from Rp. ".number_format($prosval, '0', ',', '.')." to Rp. ".number_format($value, "0", ",", ".")."<br>";
                    }

                    if($competitor != $comp AND !empty($competitor)) {
                        $this->db->where('id', $crm_id);
                        $this->db->update('tbl_crm', array('competitor' => $competitor));
                        
                        $pesan .= 'Update Competitor : '.$competitor."<br>";
                    }   

                    $pesan .= "Progress Note : ".$note."<br>";

                    $pesan = array(
                        'crm_id'     => $crm_id,
                        'sender'     => $user,
                        'pesan'      => $pesan,
                        'date_created' => date('Y-m-d H:i:s'),              
                    );
                    $this->db->insert('tbl_crm_pesan', $pesan);
                    $pesan_id = $this->db->insert_id();

                    $log = array(
                        'crm_id'        => $crm_id,
                        'user_id'       => $user,
                        'crm_type'      => 'Progress',
                        'crm_type_id'   => $pesan_id,
                        'date_created'  => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('tbl_crm_log', $log);
                    $log_id2 = $this->db->insert_id();

                    $this->db->where('id', $pesan_id);
                    $this->db->update('tbl_crm_pesan', array('log_crm_id' => $log_id2,)); 
                }

                 $this->notification($crm_id, $appr_id, '18', $_SESSION['myuser']['karyawan_id']);

                $this->db->where('id', $crm_id);
                $this->db->update('tbl_crm', array('progress_sts' => '2'));
            }

            if($_SESSION['myuser']['cabang'] != '' AND $type == '2') {
                $lvl_approval = 'Kadiv';
            }elseif($_SESSION['myuser']['cabang'] != '') {
                $lvl_approval = 'Kacab';
            }elseif ($_SESSION['myuser']['cabang'] == '') {
                $lvl_approval = 'Kadiv';
            }

            $update = array(
                'lvl_approval'      => $lvl_approval,
                'status_approval'   => $type,
            );
            $this->db->where('id', $log_id);
            $this->db->update('tbl_crm_log', $update);

            $log_approval = array(
                'crm_id' => $crm_id,
                'log_id'    => $log_id,
                'user_approval' => $_SESSION['myuser']['karyawan_id'],
                'status_approval' => $type,
                'date_approval' => date('Y-m-d H:i:s'),
                'note'          => $alasan,
                'date_created'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_crm_log_approval', $log_approval);

            $this->db->where('id', $appr_id);
            $this->db->update('tbl_crm_progress_approval', array('status' => $type));

            $this->last_update($crm_id);

        }

        public function setStatusLinkCRM($modul, $modul_id, $crm, $sts)
        {
            if($crm == '0') {
                $sql = "SELECT link_from_id FROM tbl_link WHERE link_to_modul = '$modul' AND link_from_modul = '8' AND link_to_id = '$modul_id'";
                $res = $this->db->query($sql)->result_array();

                if(!empty($res)) {
                    foreach ($res as $key => $val) {
                        $this->upCRM($val['link_from_id'], $sts);
                    }
                }
            }elseif($crm != '0') {
               $this->upCRM($crm, $sts);
            }     
        }

        private function upCRM($crm, $sts) {
             $array = array(
                'status_show' => $sts,
            );

            $this->db->where('id', $crm);
            $this->db->update('tbl_crm', $array);
        }

        public function ChangeSales()
        {
            $sales_new = $this->input->post('sales-new');
            $sales_exist = $this->input->post('sales-exist');
            $crm_id = $this->input->post('crm_id');
            $alasan = $this->input->post('alasan');

            $se = $this->getKarData($sales_exist);
            $nick_ex = $se['nickname'];

            $sn = $this->getKarData($sales_new);
            $nick_new = $sn['nickname'];

            $sql = "SELECT id FROM tbl_crm_contributor WHERE crm_id = '$crm_id' AND contributor = $sales_new";
            $que = $this->db->query($sql)->row_array();

            $sls_con = $que['id'];

            $this->db->where('id', $crm_id);
            $this->db->update('tbl_crm', array('sales_id' => $sales_new));

            $arr = array(
                'user_id'   => $_SESSION['myuser']['karyawan_id'],
                'crm_id'    => $crm_id,
                'sales_exist'   => $sales_exist,
                'sales_new'     => $sales_new,
                'alasan'        => $alasan,
                'date_created'  => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_crm_change_sales', $arr);
            $change_id = $this->db->insert_id();

            if(empty($sls_con)) {
                $args = array(
                    'crm_id'        => $crm_id,
                    'contributor'   => $sales_new,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_crm_contributor', $args);
            }else {
                $this->db->where('id', $sls_con);
                $this->db->where('contributor', $sales_new);
                $this->db->update('tbl_crm_contributor', array('published' => '0'));
            }

            $this->db->where('crm_id', $crm_id);
            $this->db->where('contributor', $sales_exist);
            $this->db->update('tbl_crm_contributor', array('published' => '1'));

            $log = array(
                'crm_id'        => $crm_id,
                'date_created'  => date('Y-m-d H:i:s'),
                'crm_type'      => 'Change Sales',
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
            );
            $this->db->insert('tbl_crm_log', $log);
            $log_id = $this->db->insert_id();

            $pesan = array(
                'crm_id'     => $crm_id,
                'log_crm_id' => $log_id,
                'sender'     => $_SESSION['myuser']['karyawan_id'],
                'pesan'      => 'Melakukan <b>Change Sales</b> dari '.$nick_ex.' ke '.$nick_new.'<br><b>Alasan Change Sales : </b>'.$alasan,
                'date_created' => date('Y-m-d H:i:s'),              
            );
            $this->db->insert('tbl_crm_pesan', $pesan);
            $psn_id = $this->db->insert_id();

            $this->db->where('id', $log_id);
            $this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

            $notif = array(
                'modul'     => '8',
                'modul_id'  => $crm_id,
                'record_id' => $change_id,
                'record_type' => '27',
                'user_id'   => $sales_exist,
                'date_created'  => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_notification', $notif);

            $this->notification($crm_id, $change_id, '27', $sales_new);

            return $crm_id;
        }

        public function Uploadhighlight()
        {       
            $post   = $this->input->post('highlight');
            $id     = $this->input->post('crm_id');
 
            foreach ($post as $key => $value) {
                $dataSet = array (  
                    'crm_id'    => $id,
                    'user'          => $_SESSION['myuser']['karyawan_id'],
                    'highlight'     => $value,
                    'status'        => '0',
                    'date_created'  => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_crm_highlight', $dataSet);
            }
        }

        public function Highlight_fin()
        {
            if($type='1')
            {
                $id             = $this->input->post('crm_id');
                $highlight_id   = $this->input->post('highlight_id');
         
         
                $arr = array(
                    'date_finish'   => date("Y-m-d H:i:s"),
                    'notes_user'    => $_SESSION['myuser']['karyawan_id'],
                    'status'        => '1',
                    'notes'         => $this->input->post('notes'),
                );
                $this->db->where('id',$highlight_id);
                $this->db->update('tbl_crm_highlight', $arr);
            }
        }

        public function uploadfiles($type_id)
        {
            function compress_image($src, $dest , $quality) 
            { 
                $info = getimagesize($src);
              
                if ($info['mime'] == 'image/jpeg') 
                { 
                    $image = imagecreatefromjpeg($src);
                    imagejpeg($image, $dest, $quality);
                }
                elseif ($info['mime'] == 'image/png') 
                {
                    $image = imagecreatefrompng($src);
                    imagepng($image, $dest, $quality);
                }

                return $dest;
            }

            function thumb_image($src, $dest) {

                $info = getimagesize($src);
                $direktoriThumb     = "assets/images/upload_crm/thumb_crm/";

                $temp   = explode(".", $dest); 
                $jns    = end($temp);
                $cut     = substr($dest, 0, -4);
                $dest = $cut.'_thumb.'.$jns;
                

                 if ($info['mime'] == 'image/jpeg') 
                { 
                   $image = imagecreatefromjpeg($src); 
                }
                elseif ($info['mime'] == 'image/png') 
                { 
                    $image = imagecreatefrompng($src);
                }

                $width  = imageSX($image);
                $height = imageSY($image);

                $thumbWidth     = 150;
                $thumbHeight    = ($thumbWidth / $width) * $height;

                $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
                imagecopyresampled($thumbImage, $image, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);
                
                if ($info['mime'] == 'image/jpeg') 
                { 
                    imagejpeg($thumbImage,$direktoriThumb.$dest);
                }
                elseif ($info['mime'] == 'image/png') 
                {
                    imagepng($thumbImage,$direktoriThumb.$dest);
                }
               
                //return destination file
                //return $dest;
            }
        
            if($_FILES)
            { 
                $uploaddir = 'assets/images/upload_crm/';

                foreach ($_FILES['userfile']['name'] as $key => $value) 
                {
                    $temp =  explode(".", $value); 
                    $jns = end($temp);
                    $cojns  = strlen($jns);
                    
                    if($cojns == '3') {
                        $fname = substr($value, 0, -4);
                        $fname = $fname.'_'.$type_id.'-'.date('ymd').'.'.$jns;
                    }elseif($cojns == '4') {
                        $fname = substr($value, 0, -5);
                        $fname = $fname.'_'.$type_id.'-'.date('ymd').'.'.$jns;
                    }

                    if(!$value) 
                    {
                        //$file_name = basename($fname);

                        //$uploadfile = $uploaddir . basename($fname);
                        //move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
                    }else{
                        $file_name = basename($fname);

                        $uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
                        move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

                        $conn_id = $this->mftp->conFtp();

                        /* in_array(getimagesize($file_name)['mime'], array('image/png','image/jpeg','image/gif','image/vnd.adobe.photoshop','image/vnd.dwg','video/3gp','video/mp4','video/x-msvideo','video/m4v','application/pdf','application/rtf','application/vnd.ms-office','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/mp4','application/x-rar-compressed','application/tar','application/zip','audio/x-ms-wma','audio/mp4a','audio/x-pn-realaudio-plugin','audio/wav','text/plain')); */

                        if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
                            $compress = compress_image($file_name, $file_name, 7); 
                            //$thumb = thumb_image($uploadfile, $fname);
                        }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
                            $compress = compress_image($file_name, $file_name, 40);
                            //$thumb = thumb_image($uploadfile, $fname);
                        }

                        if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						

                         $file_upload = array(
                            'crm_id'        => $type_id,
                            'file_name'     => $file_name,
                            'uploader'      => $_SESSION['myuser']['karyawan_id'],
                            'date_created'  => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('tbl_upload_crm', $file_upload);
                        $upl_id = $this->db->insert_id();

                        $cc = $this->CheckContributor($type_id);

                        if(empty($cc)) {
                            $args = array(
                                'crm_id'        => $type_id,
                                'contributor'   => $_SESSION['myuser']['karyawan_id'],
                                'user_id'       => $_SESSION['myuser']['karyawan_id'],
                                'date_created'  => date('Y-m-d H:i:s'),
                                );
                            $this->db->insert('tbl_crm_contributor', $args);
                        }
                        
                        $this->notification($type_id, $upl_id, '3');

                        //$this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');

                        ftp_close($conn_id);

                        unlink($file_name);
						} else {
						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}

                        
                    }
                }
            }
        }

        /* public function notification($crm_id, $rec_id, $notif)
        {
            $user = $_SESSION['myuser']['karyawan_id'];
            $date = date('Y-m-d H:i:s');

            $user = $_SESSION['myuser']['karyawan_id'];
            $sql = "SELECT do.divisi, kar.cabang, kar.nama FROM tbl_crm as do 
                    LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id 
                    WHERE do.id = '$crm_id'";
            $query = $this->db->query($sql)->row_array();
            
            $a = $query['cabang'];
            $div = $query['divisi'];

            if($a == 'Bandung') {
              $position_cbg = '57';
            }elseif ($a == 'Surabaya') {
              $position_cbg = '55';
            }elseif ($a == 'Medan') {
              $position_cbg = '56';
            }else{
              $position_cbg = '';
            }

            if($div == 'dhc') {
              $div = '88';
            }elseif ($div == 'dre') {
              $div = '89';
            }elseif ($div == 'dce') {
              $div = '90';
            }elseif ($div == 'dhe') {
              $div = '91';
            }elseif ($div == 'dgc') {
              $div = '92';
            }elseif ($div == 'dee') {
              $div = '93';
            }

            if($notif == '13') {
                $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$div' AND published = '1'";
                $kadiv = $this->db->query($sql)->row_array();
                
                $insert = array(
                    'user_id' => $kadiv['id'],
                    'record_id' => $rec_id,
                    'record_type' =>$notif,
                    'modul_id' => $crm_id,
                    'status'    => '0',
                    'modul' => '8',
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_notification', $insert);
            }else {

                if(!empty($position_cbg)) { 
                    $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                          SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
                          WHERE crm_id = '$crm_id' AND contributor != '$user'
                          UNION SELECT sender as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_pesan 
                          WHERE crm_id = '$crm_id' AND sender != '$user'
                          UNION SELECT uploader as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_upload_crm 
                          WHERE crm_id = '$crm_id' AND uploader != '$user'
                          UNION SELECT id as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_karyawan
                          WHERE id != '$user' AND position_id IN ('$position_cbg', '$div') AND published = '1'
                          GROUP BY user
                          ";                
                }else { 
                $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                          SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
                          WHERE crm_id = '$crm_id' AND contributor != '$user'
                          UNION SELECT sender as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_pesan 
                          WHERE crm_id = '$crm_id' AND sender != '$user'
                          UNION SELECT uploader as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_upload_crm 
                          WHERE crm_id = '$crm_id' AND uploader != '$user'
                          UNION SELECT id as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_karyawan
                          WHERE id != '$user' AND position_id = '$div' AND published = '1'
                          GROUP BY user
                          ";
                }          
                $this->db->query($sql);        

            }  
        } */

        public function notification($crm_id, $rec_id, $notif, $user = '')
        {
            $user = $_SESSION['myuser']['karyawan_id'];
            $date = date('Y-m-d H:i:s');

            $user = $_SESSION['myuser']['karyawan_id'];
            $sql = "SELECT do.divisi, kar.cabang, kar.nama FROM tbl_crm as do 
                    LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id 
                    WHERE do.id = '$crm_id'";
            $query = $this->db->query($sql)->row_array();
            
            $a = $query['cabang'];
            $div = $query['divisi'];

            if($a == '' OR ($notif == '13' AND in_array($_SESSION['myuser']['position_id'], array('55', '56', '57'))))
            {
                $position_cbg = '';
            }elseif($a == 'Bandung') {
              $position_cbg = '57';
            }elseif ($a == 'Surabaya') {
              $position_cbg = '55';
            }elseif ($a == 'Medan') {
              $position_cbg = '56';
            }

            if($div == 'dhc') {
              $div = '88';
            }elseif ($div == 'dre') {
              $div = '89';
            }elseif ($div == 'dce') {
              $div = '90';
            }elseif ($div == 'dhe') {
              $div = '91';
            }elseif ($div == 'dgc') {
              //$div = '92';
              $div = '90';  
            }elseif ($div == 'dee') {
              $div = '93';
            }elseif ($div == 'dwt') {
              //$div = '100';
              $div = '91';  
            }
            
            $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                    SELECT id as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_karyawan
                        WHERE id NOT IN ('$user', '101', '123', '133', '109') AND position_id IN ('$position_cbg', '$div') AND published = '1'
                        GROUP BY user ";

            if($notif != '13') {
                
                $sql .= "UNION SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
                      WHERE crm_id = '$crm_id' AND contributor != '$user' AND published = 0";   

                /* $sql .= "UNION SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
                      WHERE crm_id = '$crm_id' AND contributor != '$user' AND published = 0
                      UNION SELECT sender as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_pesan cps LEFT JOIN tbl_crm_contributor cr1 ON cr1.crm_id = cps.crm_id
                      WHERE cps.crm_id = '$crm_id' AND sender != '$user' AND cr1.published = 0
                      UNION SELECT uploader as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_upload_crm up LEFT JOIN tbl_crm_contributor cr2 ON cr2.crm_id = up.crm_id
                      WHERE up.crm_id = '$crm_id' AND uploader != '$user' AND cr2.published = 0"; */         
            }        
                //print_r($sql); exit();
                $this->db->query($sql);         
        }
}