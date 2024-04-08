<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_paging_product');
		$user = $this->session->userdata('myuser');

		if (!isset($user) or empty($user))
		 {
			redirect('c_loginuser');
		}
	}

public function index()
{
	$sql		= "SELECT * FROM tbl_product";
	$query		= $this->db->query($sql);
	$c_product = $query->result_array();
	
	$data['view'] = 'content/content_table_product';
	$data['c_product'] = $c_product;
	$this->load->view('template/home', $data); 

	//$this->view();
	
}

public function add()
{		
	if($this->input->post())
	{
		$kode = $this->input->post('kode');
		$nama = $this->input->post('product');
		//$no_serial = $this->input->post('no_serial');
	
		$args = array(
			'kode' => $kode,
			'product'	=> $nama,
			//'no_serial' => $no_serial
			);

		$this->db->insert('tbl_product', $args);
		$this->session->set_flashdata('message', 'Product telah berhasil ditambahkan');
		redirect('c_product/add');
	}
	
	
	$data['view'] = 'content/add_newproduct';
	$data['action'] = 'c_product/add';
	$this->load->view('template/home', $data);
}

 public function update($id){
		
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_product');
		
		if($get->num_rows() > 0)
		{
			$data['c_product'] = $get->row_array();
		}
		
		$data['view'] = 'content/content_edit_product';
		$data['action'] = 'c_product/update_data/' .$id;
		$this->load->view('template/home', $data);
}

public function update_data($id)
	{
		
		if($this->input->post())
		{

		$kode	= $this->input->post('kode');
		$nama = $this->input->post('product');
		//$no_serial = $this->input->post('no_serial');
		
			$args = array(
			'kode' => $kode,
			'product'		=> $nama
			//'no_serial' => $no_serial
			);
			
		$this->db->where('id', $id);
		$this->db->update('tbl_product', $args);
		$this->session->flashdata('message','Data Berhasil Diupdate');
		redirect('c_product');
		
	}
	}

	public function view($offset=0) {
  
   $jml = $this->db->get('tbl_product');
   
   $config['base_url'] = base_url().'index.php/c_product/view';
   
   $config['total_rows'] = $jml->num_rows();
   $config['per_page'] = 50; /*Jumlah data yang dipanggil perhalaman*/ 
   $config['uri_segment'] = 3; /*data selanjutnya di parse diurisegmen 3*/
   
   /*Class bootstrap pagination yang digunakan*/
   $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-25px;'>";
      $config['full_tag_close'] ="</ul>";
   $config['num_tag_open'] = '<li>';
   $config['num_tag_close'] = '</li>';
   $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
   $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
   $config['next_tag_open'] = "<li>";
   $config['next_tagl_close'] = "</li>";
   $config['prev_tag_open'] = "<li>";
   $config['prev_tagl_close'] = "</li>";
   $config['first_tag_open'] = "<li>";
   $config['first_tagl_close'] = "</li>";
   $config['last_tag_open'] = "<li>";
   $config['last_tagl_close'] = "</li>";
  
   $this->pagination->initialize($config);
   
   $data['halaman'] = $this->pagination->create_links();
   /*membuat variable halaman untuk dipanggil di view nantinya*/
   $data['offset'] = $offset;

   $data['data'] = $this->m_paging_product->view($config['per_page'], $offset);
   
  $data['view'] = 'content/content_table_product';
   $this->load->view('template/home',$data);
   /*memanggil view pagination*/
  }

public function delete($id)
	{
		$this->db->where('id', $id);
		$sql = "DELETE FROM tbl_product WHERE id = '$id'";
		$query = $this->db->query($sql);
		redirect('c_product');
	}

}