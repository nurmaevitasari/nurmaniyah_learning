<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct() {
        parent::__construct();
        //load model untuk fungsi crud
        $this->load->model('crud_model','crud');
        //load libarry upload
        $this->load->library('upload'); 
        //laod library session
        $this->load->library('session'); 

    }

	public function index()
	{
		$data['list'] = $this->crud->show('image');
		$this->load->view('upload',$data);
	}
	public function add()
	{
		$this->load->view('add');
	}
	public function proses()
	{
		if (empty($_FILES['image_1']['name'])) {
    		 	    $this->session->set_flashdata('warning', 'Setidaknya 1 file harus diupload');	
                   redirect('upload/add');
                } else {
                    //with upload image
                    $config['upload_path'] = "assets/"; //lokasi folder yang akan digunakan untuk menyimpan file
                    $config['allowed_types'] = 'jpg|png|JPEG';
                    
                    foreach($_FILES as $row => $val ){
                    	$config['file_name'] = url_title($this->input->post($row));
                    	$this->upload->initialize($config);
	                    	 if (!$this->upload->do_upload($row)) {
	                        	$error = $this->upload->display_errors();
		                        $this->session->set_flashdata('warning', $error);
		                       redirect('upload/add');
		                    } else {
		                        $data['nama'] = $this->upload->file_name;
		                       
		                        $this->crud->insert($data,'image');
		                    }
                    }
                    redirect('upload/');
                }
	}
}