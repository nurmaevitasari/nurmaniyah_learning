<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class C_sop extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
 
        $this->load->library(array('CKEditor','CKFinder')); //library ckfinder ditambahkan untuk diload

        $user = $this->session->userdata('myuser');
        $this->load->model('Ftp_model', 'mftp');
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
            $cabang = $_SESSION['myuser']['cabang'];
            $posisi = $_SESSION['myuser']['position_id'];
            $role = $_SESSION['myuser']['role_id'];
            $position = $_SESSION['myuser']['position'];
            if($position_id == '33') { //Teknisi
                 $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id
                    WHERE a.type = '2' AND b.position_id = $position_id AND b.user_id = '$cabang'";
            }else {
                $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id
                    WHERE a.type = '2' AND b.position_id = $position_id";  
            }         
                 
            $result = $this->db->query($sql)->result_array();

        $data['result'] = $result;
        $data['view'] = 'content/content_table_sop';
        $this->load->view('template/home', $data);
    }

    public function table_sop()
    {
        $user = $this->session->userdata('myuser');
        $position_id = $user['position_id'];
        $sales = $_SESSION['myuser']['position'];
        $sales = substr($sales, -3);

        if($user['position_id'] == 1 OR $user['position_id'] == 2 OR $user['position_id'] == 77 OR $user['position_id'] == 83) {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    WHERE a.type = '2'";
        }elseif($user['position_id'] == 3) { //MANAGER FIN N ACC
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('3','5','6','7','8','9')";
        }elseif($user['position_id'] == 6) { //SPV FIN N ACC
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('5','6','7','8','9')";
        }elseif ($user['position_id'] == '59') { //KEPALA GUDANG SURABAYA
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('59', '94', '35', '33')"; 
        }elseif ($user['position_id'] == '87') { //LEADER WORKSHOP
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('87', '24', '25', '23', '26', '96')";
           
        }elseif($sales == 'DHC') { 
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('65', '88')";
        }elseif ($sales == 'DRE') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('66', '89')";
        }elseif ($sales == 'DEE') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('67', '93')";
        }elseif ($sales == 'DCE') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('68', '90')";
        }elseif ($sales == 'DHE') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('71', '91')";    
        }elseif ($sales == 'DGC') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id IN ('72', '92')";
        }elseif($user['cabang'] == 'Bandung'){
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id 
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id 
                    WHERE a.type = '2' AND d.cabang = 'Bandung'";
        }elseif($user['cabang'] == 'Surabaya') {
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id 
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id 
                    WHERE a.type = '2' AND d.cabang = 'Surabaya'";
        }elseif($user['cabang'] == 'Medan') {
            /* $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                LEFT JOIN tbl_karyawan as d ON d.position_id = b.position_id
                WHERE a.type = '2' AND d.cabang = 'Medan'";  */ 

            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id 
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id 
                    WHERE a.type = '2' AND d.cabang = 'Medan'";          
        }elseif($user['cabang'] == 'Cikupa') { 
            $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                    LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id 
                    LEFT JOIN tbl_position as c ON c.id = b.position_id 
                    LEFT JOIN tbl_karyawan as d ON d.id = b.user_id 
                    WHERE a.type = '2' AND d.cabang = 'Cikupa'";     
        }else {
             $sql = "SELECT a.*, b.*, c.position FROM tbl_upload_hrd as a 
                LEFT JOIN tbl_hrd_sop as b ON b.id = a.type_id
                LEFT JOIN tbl_position as c ON c.id = b.position_id
                WHERE a.type = '2' AND b.position_id = '$position_id'";
        }


        $result = $this->db->query($sql)->result_array();

        $sql = "SELECT id, judul_sop FROM tbl_hrd_sop";
        $judul = $this->db->query($sql)->result_array();

        $data['judul'] = $judul;
        $data['result'] = $result;
        $data['view'] = 'content/content_table_sop';
        $this->load->view('template/home', $data);        
    }

    public function showAll()
    {   
        $user = $this->session->userdata('myuser');
        $sales = $_SESSION['myuser']['position'];
       
        $sales = substr($sales, -3);
        
        if($user['position_id'] == 1 OR $user['position_id'] == 2 OR $user['position_id'] == 77 OR $user['position_id'] == 83)
        { //Komisaris //Direktur //DIR-KEUANGAN //HRD
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit";
        }elseif($user['position_id'] == 3) { //MANAGER FIN N ACC
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('3','5','6','7','8','9')";
        }elseif($user['position_id'] == 6) { //SPV FIN N ACC
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('5','6','7','8','9')";
        }elseif($user['position_id'] == '87') { //LEADER WORKSHOP
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('87', '24', '25', '23', '26', '96')";        
        }elseif($sales == 'DHC') { 
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('65', '88')";
        }elseif ($sales == 'DRE') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('66', '89')";
        }elseif ($sales == 'DEE') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('67', '93')";
        }elseif ($sales == 'DCE') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('68', '90')";
        }elseif ($sales == 'DHE') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('71', '91')";
        }elseif ($sales == 'DGC') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('72', '92')";
        }elseif($user['cabang'] == 'Bandung'){
            $sql = "SELECT a.*, c.position, d.nickname FROM tbl_hrd_sop as a 
                        LEFT JOIN tbl_karyawan AS b ON b.id = a.user_edit 
                        LEFT JOIN tbl_position as c ON c.id = a.position_id 
                        LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.id 
                        WHERE a.user_id IN (SELECT id FROM tbl_karyawan where cabang = 'Bandung' )";        
        }elseif($user['cabang'] == 'Medan') {
           /* $sql = "SELECT a.*, c.position, d.nickname FROM tbl_hrd_sop as a 
                JOIN tbl_karyawan as b ON b.position_id = a.position_id 
                JOIN tbl_position as c ON c.id = a.position_id
                JOIN tbl_loginuser as d ON d.karyawan_id = a.user_edit 
                WHERE b.cabang = 'Medan'"; */
                $sql = "SELECT a.*, c.position, d.nickname FROM tbl_hrd_sop as a 
                        LEFT JOIN tbl_karyawan AS b ON b.id = a.user_edit 
                        LEFT JOIN tbl_position as c ON c.id = a.position_id 
                        LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.id 
                        WHERE a.user_id IN (SELECT id FROM tbl_karyawan where cabang = 'Medan' )";
        }elseif($user['cabang'] == 'Surabaya') {
            $sql = "SELECT a.*, c.position, d.nickname FROM tbl_hrd_sop as a 
                        LEFT JOIN tbl_karyawan AS b ON b.id = a.user_edit 
                        LEFT JOIN tbl_position as c ON c.id = a.position_id 
                        LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.id 
                        WHERE a.user_id IN (SELECT id FROM tbl_karyawan where cabang = 'Surabaya' )"; 

        }elseif($user['cabang'] == 'Cikupa') {
            $sql = "SELECT a.*, c.position, d.nickname FROM tbl_hrd_sop as a 
                        LEFT JOIN tbl_karyawan AS b ON b.id = a.user_edit 
                        LEFT JOIN tbl_position as c ON c.id = a.position_id 
                        LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.id 
                        WHERE a.user_id IN (SELECT id FROM tbl_karyawan where cabang = 'Cikupa' )";
        }elseif ($user['position_id'] == '59') {
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id IN ('59', '94', '35', '33')";
        }else{
            $sql = "SELECT a.*, b.position, c.nickname FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON b.id = a.position_id
                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.user_edit
                WHERE a.position_id = ".$user['position_id']."";
        }
        $res = $this->db->query($sql)->result_array();

        $data['res'] = $res;
        $data['view'] = 'content/content_sop_show_all';
        $this->load->view('template/home', $data);
    }

    public function details($id)
    {
        $sql = "SELECT a.id, a.position_id, ckeditor, a.date_modified, a.judul_sop, b.nickname, c.position FROM tbl_hrd_sop as a
                LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.user_edit
                LEFT JOIN tbl_position as c ON c.id = a.position_id
                WHERE a.id = '$id'";
            $rslt = $this->db->query($sql)->row_array();    
       
        $data['rslt'] = $rslt;
        $data['view'] = 'content/content_sop';
        $this->load->view('template/home', $data);
    }

    public function edit($id)
    {
        $width = '100%';
        $height = '300px';
        $this->editor($width,$height);
        
        $sql = "SELECT a.id, user_edit, a.date_modified, a.position_id, ckeditor, a.judul_sop, b.position FROM tbl_hrd_sop as a
                LEFT JOIN tbl_position as b ON a.position_id = b.id WHERE a.id = '$id'";
        $sop = $this->db->query($sql)->row_array();

        $sql  = "SELECT id, position FROM tbl_position ORDER BY position ASC";
        $pos = $this->db->query($sql)->result_array();

        $data['sop'] = $sop;
        $data['pos'] = $pos;
        $data['view'] = 'content/formeditor';
        $this->load->view('template/home', $data);
    }

    public function update()
    {
        if($this->input->post())
        {
            $id         = $this->input->post('id_sop');
            $posisi_id  = $this->input->post('posisi_id');
            $user_edit  = $this->input->post('user_edit');
            $ckeditor   = $this->input->post('deskripsi');
            $judul      = $this->input->post('jdl_sop');

            $args = array(
            'ckeditor' => $ckeditor,
            'user_edit' => $user_edit,
            'date_modified' => date('y-m-d H:i:s'),
            'judul_sop' => $judul,
            );
            
            $this->db->where('id', $id);
            $this->db->update('tbl_hrd_sop', $args);

            $log = array(
                'date_created'  => date('Y-m-d H:i:s'),
                'user_id'       => $user_edit,
                'descrip'       => '3',
                'descrip_id'    => $id,
                'modul'         => '1',
                'modul_id'      => $id,
                'ket'           => 'tbl_hrd_sop',
            );
            $this->db->insert('tbl_log', $log);

        }
        redirect('C_sop/details/'.$id);
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
            $judul = $this->input->post('jdl_sop');
            $posisi_id = $this->input->post('posisi_id');
            $user_edit = $this->input->post('user_edit');
            $ckeditor = $this->input->post('deskripsi');

            $args = array(
                'ckeditor'  => $ckeditor,
                'position_id'   => $posisi_id,
                'user_id'   => $user_edit,
                'user_edit' => $user_edit,
                'date_modified' => date('y-m-d H:i:s'),
                'judul_sop' => $judul,
            );

            $this->db->insert('tbl_hrd_sop', $args);
            $id = $this->db->insert_id();

             $log = array(
                'date_created'  => date('Y-m-d H:i:s'),
                'user_id'       => $user_edit,
                'descrip'       => '1',
                'modul'         => '1',
                'modul_id'      => $id,
                'ket'           => 'tbl_hrd_sop',
            );
            $this->db->insert('tbl_log', $log);
        }

        redirect('C_sop/showAll');
    }

    public function upload()
    {
        if($this->input->post())
        {   
            $id_sop = $this->input->post('id_sop');

            function compress_image($src, $dest , $quality) 
            { //echo "compress";

                $info = getimagesize($src);
          
                if ($info['mime'] == 'image/jpeg') 
                { //echo "jpeg zzz"; exit();
                   $image = imagecreatefromjpeg($src);
                   //compress and save file to jpg
                    imagejpeg($image, $dest, $quality);
                }
                elseif ($info['mime'] == 'image/png') 
                { //echo "png cscscsc"; exit(); 
                    $image = imagecreatefrompng($src);
                    imagepng($image, $dest, $quality);
                }
          
                //return destination file
                return $dest;
                }
                
                if($_FILES) 
                {
            
                $uploaddir = 'assets/images/upload_hrd/';
                    
                    foreach ($_FILES['userfile']['name'] as $key => $value) {

                        if(!$value) {
                            //$file_name = basename($value);

                            //$uploadfile = $uploaddir . basename($value);
                            //move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
                    
                        }else{
                            $file_name = basename($value);

                            $uploadfile = "/htdocs/iios/".$uploaddir . basename($value);
                            move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

                            $conn_id = $this->mftp->conFtp();

                            if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
                                $compress = compress_image($file_name, $file_name, 7);    
                            }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
                                $compress = compress_image($file_name, $file_name, 40);
                            }

                            if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
                              $file_upload = array(
                                'type'          => '2',
                                'type_id'       => $id_sop,
                                'file_name'     => $file_name,
                                'date_created'  => date('Y-m-d H:i:s'),
                            );

                            $this->db->insert('tbl_upload_hrd', $file_upload);
                            $id = $this->db->insert_id();

                            ftp_close($conn_id);

                            unlink($file_name);
                            } else {
                              $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
                            }

                            $user_id = $_SESSION['myuser']['karyawan_id'];
                            $log = array(
                                'date_created'  => date('Y-m-d H:i:s'),
                                'user_id'       => $user_id,
                                'descrip'       => '4',
                                'descrip_id'    => $id,
                                'modul'         => '1',
                                'modul_id'      => $id,
                                'ket'           => 'tbl_hrd_upload',
                            );
                            $this->db->insert('tbl_log', $log);

                            
                        }
                    }
                } 
                redirect('C_sop/table_sop');
        }  
    }
        
}