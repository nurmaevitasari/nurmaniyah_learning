<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class C_position extends CI_Controller {



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

		$sql		= "SELECT * FROM tbl_position ORDER BY position ASC ";

		$query		= $this->db->query($sql);

		$c_position	= $query->result_array();

		

		$data['view'] = 'content/content_table_position';

		$data['c_position'] = $c_position;

		$this->load->view('template/home', $data);

	}

	

	public function add()

	{

		if($this->input->post())

		{

			$position	= $this->input->post('position');

			

			$args = array(

				'position'		 	=> $position,

			);

			

			$this->db->insert('tbl_position', $args);

			

			$this->session->set_flashdata('message', 'Data Berhasil Disimpan');

			redirect('c_position/add');

		}

		

		$data['view'] = 'content/add_newposition';

		$data['action'] ='c_position/add';

		$this->load->view('template/home', $data);

	}

	

	public function delete($id)

	{

			$this->db->where('id', $id);

			$this->db->delete('tbl_position');

			redirect('c_position');

		}

}