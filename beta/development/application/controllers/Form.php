<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Form extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
 
        $this->load->library(array('CKEditor','CKFinder')); //library ckfinder ditambahkan untuk diload

        $user = $this->session->userdata('myuser');
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
    /**
     * halaman awal ketika controller form diakses
     */
    public function index($position_id)
    {
            $sql = "SELECT a.id, a.position_id, ckeditor, a.date_modified, b.nickname, c.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE a.position_id = $position_id";
            $rslt = $this->db->query($sql)->row_array();    
       
        $data['rslt'] = $rslt;
        $data['view'] = 'content/content_sop';
        $this->load->view('template/home', $data);
    }

    public function showAll()
    {   
        $user = $this->session->userdata('myuser');
        $sales = $_SESSION['myuser']['position'];
        $sales = substr($sales, -3);
        
        if($user['position_id'] == 1 OR $user['position_id'] == 2 OR $user['position_id'] == 77 OR $user['position_id'] == 83)
        { //Komisaris //Direktur //DIR-KEUANGAN //HRD
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id";
        }elseif($user['position_id'] == 3) { //MANAGER FIN N ACC
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('3','5','6','7','8','9')";
        }elseif($user['position_id'] == 6) { //SPV FIN N ACC
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('5','6','7','8','9')";
        }elseif($sales == 'DHC') { 
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('65', '88')";
        }elseif ($sales == 'DRE') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('66', '89')";
        }elseif ($sales == 'DEE') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('67', '93')";
        }elseif ($sales == 'DCE') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('68', '90')";
        }elseif ($sales == 'DHE') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('71', '91')";
        }elseif ($sales == 'DGC') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('72', '92')";
        }elseif($user['cabang'] == 'Bandung'){
            $sql = "SELECT a.*, c.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_karyawan as b ON b.id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE b.cabang = 'Bandung'";
        }elseif($user['cabang'] == 'Medan') {
            $sql = "SELECT a.*, c.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_karyawan as b ON b.id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE b.cabang = 'Medan'";
        }elseif($user['cabang'] == 'Surabaya') {
            $sql = "SELECT a.*, c.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_karyawan as b ON b.id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE b.cabang = 'Surabaya'";
        }elseif($user['cabang'] == 'Cikupa') {
            $sql = "SELECT a.*, c.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_karyawan as b ON b.id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE b.cabang = 'Cikupa'";
        }elseif ($user['position_id'] == '59') {
            $sql = "SELECT a.*, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                WHERE a.position_id IN ('59', '94', '35', '33')";
        }
        $res = $this->db->query($sql)->result_array();

        $data['res'] = $res;
        $data['view'] = 'content/content_sop_show_all';
        $this->load->view('template/home', $data);
    }

    public function edit($id)
    {
        $width = '100%';
        $height = '300px';
        $this->editor($width,$height);
        
        $sql = "SELECT a.id, user_edit, a.date_modified, a.position_id, ckeditor, b.position FROM tbl_ckeditor as a
                LEFT JOIN tbl_position as b ON a.position_id = b.id WHERE a.id = '$id'";
        $sop = $this->db->query($sql)->row_array();

        $sql  = "SELECT id, position FROM tbl_position ORDER BY position ASC";
        $pos = $this->db->query($sql)->result_array();

        $data['sop'] = $sop;
        $data['pos'] = $pos;
        $data['view'] = 'content/formeditor';
        $this->load->view('template/home', $data);
    }

    public function add()
    {
        $width = '100%';
        $height = '300px';
        $this->editor($width,$height);

        $sql  = "SELECT id, position FROM tbl_position ORDER BY position ASC";
        $pos = $this->db->query($sql)->result_array();

        $data['pos'] = $pos;
        $data['view'] = 'content/formeditor';
        $this->load->view('template/home', $data);
    }
 
    function editor($width,$height) {
    //configure base path of ckeditor folder
    $this->ckeditor->basePath = base_url().'plugins/ckeditor/';
    $this->ckeditor->config['toolbar'] = 'Full';
    $this->ckeditor->config['language'] = 'en';
    $this->ckeditor->config['width'] = $width;
    $this->ckeditor->config['height'] = $height;

     $path = base_url('plugins/ckfinder/');

    //configure ckfinder with ckeditor config
	$this->ckfinder->SetupCKEditor($this->ckeditor, $path);
    //$path = base_url('plugins/ckeditor/'); //path folder ckfinder
    //$this->ckfinder->SetupCKEditor($this->ckeditor,$path);
  }

  public function save()
    {
        if($this->input->post())
        {
            $posisi_id = $this->input->post('posisi_id');
            $user_edit = $this->input->post('user_edit');
            $ckeditor = $this->input->post('deskripsi');

            $args = array(
                'ckeditor' => $ckeditor,
                'position_id' => $posisi_id,
                'user_edit' => $user_edit,
                'date_modified' => date('y-m-d H:i:s'),
            );

            $this->db->insert('tbl_ckeditor', $args);
        }
        redirect('Form/index/'.$posisi_id);
    }

    public function update()
    {
        if($this->input->post())
        {
            $posisi_id = $this->input->post('posisi_id');
            $user_edit = $this->input->post('user_edit');
            $ckeditor = $this->input->post('deskripsi');

            $args = array(
                'ckeditor' => $ckeditor,
                'user_edit' => $user_edit,
                'date_modified' => date('y-m-d H:i:s'),
            );
            $this->db->where('position_id', $posisi_id);
            $this->db->update('tbl_ckeditor', $args);
        }
        redirect('Form/index/'.$posisi_id);
    }          
}