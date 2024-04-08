<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_tbl_wa extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_wa','mwa');
	
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	}  
	
	public function index()
	{
		$hasil= $this->mwa->GetFiles();
		$data['wa'] = $hasil;
		$data['view']='content/content_tbl_wa';
		$this->load->view('template/home',$data);

	}
	
	public function Add()
	{ 
       
		if ($this->input->post()) {
			$this->mwa->uploadfiles();

			redirect('c_tbl_wa');
		}
		$hasil= $this->mwa->loadproduct();
		$data['product']=$hasil;
		$data['view']='content/add_WA_material';
		$this->load->view('template/home',$data);
		
	}
}