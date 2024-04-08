<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_gallery extends CI_Controller {
var $limit=30;
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	}
	public function index()
	{
		//$sql = "SELECT * FROM tbl_upload";
		$sql = "SELECT a.sps_id, a.upload, b.id FROM tbl_upload as a JOIN tbl_sps as b ON b.id = a.sps_id";
		$query = $this->db->query($sql);
		$foto = $query->row_array();

		//$data['foto'] = $this->find_all_files('assets/images/upload/');		
		$data['foto'] = $foto;
		$data['view'] = 'content/content_upload';
		$this->load->view('template/home', $data); 

		//$this->view_gallery();
	}

	public function find_all_files($dir)
	{

		$root = scandir($dir);
		foreach($root as $value)
		{
			if($value === '.' || $value === '..'){continue;}
			
			$result[]=$value;
		}
		return $result;
	}

	public function hapusfoto()
	{
		$data = $this->input->post('foto');
		$count = count($data);
		
		for($x=0;$x<$count;$x++)
		{
			unlink('assets/images/upload/'.$data[$x]);
		}
		
		redirect('c_gallery');
	}

	public function view_gallery($offset=0)
	{

		$sql = "SELECT a.sps_id, a.upload, b.id FROM tbl_upload as a JOIN tbl_sps as b ON b.id = a.sps_id";
		$query = $this->db->query($sql);
		$foto = $query->result_array();
		$rows = $query->num_rows();
		$sql2 = "SELECT * 
				FROM tbl_upload LIMIT $this->limit OFFSET $offset";
		$query2 = $this->db->query($sql2);
		$foto2 = $query2->result_array();
		
		$config['base_url'] = site_url('c_upload/view_gallery');
		$config['per_page'] = $this->limit;
		$config['total_rows'] = $rows;
		$this->pagination->initialize($config);
		
		$data['pagination'] =  $this->pagination->create_links();
		
		//$data['selected'] ='gallery';
		$data['view']='content/content_upload';
		$data['foto'] = $foto2;
		$data['offset']= $offset;
		$this->load->view('template/home',$data);
	}

}