<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_crm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('M_crm', 'mcrm');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	public function index()
	{
		$data['crm'] = $this->mcrm->getCRM();
		$data['view'] = 'content/content_table_crm';
		$this->load->view('template/home', $data);

	}

	public function crm($term ='')
	{
		if($term == 'og') {
			$crm = $this->mcrm->getCRM();
			$view = 'content/content_table_crm';
		}elseif ($term == 'fin') {
			$crm = $this->mcrm->getCRMfin();
			$view = 'content/content_crm_fin';
		}elseif($term == 'lost') {
			$crm = $this->mcrm->getCRMloss();
			$view = 'content/content_crm_fin';
		}
		$data['crm'] = $crm;
		$data['view'] = $view;
		$this->load->view('template/home', $data);
	}

	public function details($id)
	{
		$data['ketentuan']  = $this->mcrm->getKetentuan($id);
		$data['contributor'] = $this->mcrm->getContributor($id);
		$data['detail'] = $this->mcrm->getDetail($id);
		$data['files'] = $this->mcrm->getFiles($id);
		$data['log'] = $this->mcrm->getLog($id);
		$data['karyawan'] = $this->mcrm->getKaryawan($id);
		$data['link'] = $this->mcrm->getLink($id);
		$data['grplink'] = $this->mcrm->getGroupLink($id);
		$data['view'] = 'content/content_detail_crm';
		$this->load->view('template/home', $data);
	}

	public function add()
	{
		if($this->input->post())
		{
			//$this->mcrm->addData();
			$html = "<div class='alert alert-success' style='font-size: 14px;'>
						<span class='fa fa-check-circle fa-lg'></span> Data prospek baru berhasil ditambahkan.
						<span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
					</div>";
			$this->session->set_flashdata('message', $html);

			redirect('C_crm/details/'.$this->mcrm->addData());
		}

		$data['employee'] = $this->mcrm->getEmployee();
		$data['view'] = 'content/form_new_crm';
		$this->load->view('template/home', $data);
	}

	public function add_customer()
	{
		echo json_encode($this->mcrm->add_customer());
	}

	public function addNotes()
	{
		$this->mcrm->addNotes();
	}

	public function addContributor()
	{
		$this->mcrm->addContributor();
		$id = $this->input->post('crm_id');
		redirect('C_crm/details/'.$id);
	}

	public function FollowUp()
	{
		$this->mcrm->FollowUp();
		$id = $this->input->post('crm_id');
		redirect('C_crm/details/'.$id);
	}

	public function UpProgress()
	{
		$this->mcrm->addProgress();
		$id = $this->input->post('crm_id');
		redirect('C_crm/details/'.$id);
	}

	public function add_pesan()
	{
		if($this->input->post())
		{
			$this->mcrm->add_pesan();
			
			$id = $this->input->post('crm_id');
			redirect('C_crm/details/'.$id);
		}
	}

	public function uploadFile()
	{
		if($this->input->post())
		{
			$id = $this->input->post('crm_id');
			$this->mcrm->uploadfiles($id);
			redirect('C_crm/details/'.$id);
		}
	}

	public function CloseCRM($id)
	{
		if($this->input->post())
		{
			$id = $this->input->post('crm_id');
			$this->mcrm->uploadfiles($id);
			
		}
		redirect('C_crm/details/'.$id);
	}

	public function linkTodel($crm_id)
	{
		$sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
		$row_arr = $this->db->query($sql)->row_array();

		$arr = array(
			'id' => $row_arr['id'],
			'divisi' => $row_arr['divisi'],
			'deal_value' => $row_arr['deal_value'],
			'customer_id' => $row_arr['customer_id'],
			'customer_type' => $row_arr['customer_type'],
			'modul' => '8',
		);

		$this->session->set_userdata('sess_crm_id', $arr);
		redirect('C_delivery/add/delv');
	}

	public function linkToSPS($crm_id)
	{
		$sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
		$row_arr = $this->db->query($sql)->row_array();

		$this->session->set_userdata('sess_crm_id', $row_arr);
		redirect('C_new_sps/add');
	}

	public function linkToProject($crm_id)
	{
		$sql = "SELECT id, divisi, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
		$row_arr = $this->db->query($sql)->row_array();

		$this->session->set_userdata('sess_crm_id', $row_arr);
		redirect('Project/add');
	}
}	