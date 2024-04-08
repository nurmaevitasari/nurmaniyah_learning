<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_customer extends CI_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('m_paging_customer');

		$user = $this->session->userdata('myuser');
		
		if (!isset($user) or empty($user))
		 {
			redirect('c_loginuser');
		}
	}

public function index()
{
	 $sql		= "SELECT * FROM `tbl_customer` ORDER BY id_customer DESC";
	$query		= $this->db->query($sql);
	$c_customer = $query->result_array();
	
	$data['view'] = 'content/content_table_customer';
	$data['c_customer'] = $c_customer;
	$this->load->view('template/home', $data);
	//$this->view();
}

public function add()
{	
		
	if($this->input->post())
	{
		$id_customer = $this->input->post('id_customer');
		$nama_customer = $this->input->post('perusahaan');
		$alamat_customer = $this->input->post('alamat');
		$pic_customer = $this->input->post('pic');
		$telepon_customer = $this->input->post('telepon');
	
		$args = array(
			'id_customer' => $id_customer,
			'perusahaan'	=> $nama_customer,
			'alamat'	=> $alamat_customer,
			'pic'		=> $pic_customer,
			'telepon'	=> $telepon_customer
			);

		$this->db->insert('tbl_customer', $args);
		$this->session->set_flashdata('message', 'Customer telah berhasil ditambahkan');
		redirect('c_customer/add');
	}
	
	//$data['kode'] = $kode;
	$data['view'] = 'content/add_newcustomer';
	$data['action'] = 'c_customer/add';
	$this->load->view('template/home', $data);
}

 public function update($id){
		
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_customer');
		
		if($get->num_rows() > 0)
		{
			$data['c_customer'] = $get->row_array();
		}
		
		//$data['kode'] = $kode;
		$data['view'] = 'content/content_edit_customer';
		//$data['c_customer'] = $c_customer;
		$data['action'] = 'c_customer/update_data/' .$id;
		$this->load->view('template/home', $data);
}

public function update_data($id)
	{
	
		if($this->input->post())
		{

		//$id_customer = $this->input->post('id_customer');
		$nama_customer = $this->input->post('perusahaan');
		$alamat_customer = $this->input->post('alamat');
		$pic_customer = $this->input->post('pic');
		$telepon_customer = $this->input->post('telepon');
					
			$args = array(
			//'id_customer' => $kode,
			'perusahaan'		=> $nama_customer,
			'alamat'	=> $alamat_customer,
			'pic'		=> $pic_customer,
			'telepon'	=> $telepon_customer
			);
			
		$this->db->where('id', $id);
		$this->db->update('tbl_customer', $args);
		$this->session->flashdata('message','Data Berhasil Diupdate');
		redirect('c_customer');
		
	}
	}

public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete(tbl_customer);
		redirect('c_customer');
	}

public function view($offset=0) {
  
   $jml = $this->db->get('tbl_customer');
   
   $config['base_url'] = base_url().'index.php/c_customer/view';
   
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

   $data['data'] = $this->m_paging_customer->view($config['per_page'], $offset);
   
  $data['view'] = 'content/content_table_customer';
   $this->load->view('template/home',$data);
   /*memanggil view pagination*/
  }

}