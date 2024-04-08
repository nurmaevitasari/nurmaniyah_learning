<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_monitoring extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('M_monitor');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}


	}

	public function index()
	{	
		
		$tampil = $this->M_monitor->tampil();
		$assist = $this->M_monitor->asst_tech();

		$data['tampil'] = $tampil;
		$data['assist'] = $assist;
		$data['current'] = $this->M_monitor->search_current();
		$data['result'] = $this->M_monitor->search_result();
		$data['order'] = $this->M_monitor->search_order();
		$data['order2'] = $this->M_monitor->search_order2();
		$data['point_status'] = $this->M_monitor->search_point_teknisi();
		$data['today'] = $this->M_monitor->today();

		$data['view'] = 'content/content_monitoring';
		$this->load->view('template/home', $data);

	}

	public function search()
	{
	
		$data['tampil'] 	= $this->M_monitor->tampil();
		$data['assist']		= $this->M_monitor->asst_tech();
		$data['current']	= $this->M_monitor->search_current();
		$data['result'] 	= $this->M_monitor->search_result();
		$data['order'] 		= $this->M_monitor->search_order();
		$data['today'] 		= $this->M_monitor->today();
		$data['order2'] 	= $this->M_monitor->search_order2(); 
		$data['point_status'] = $this->M_monitor->search_point_teknisi();

		$data['view'] = 'content/content_monitoring';
		$this->load->view('template/home', $data);
	}

	public function pick_assist()
	{
		$data = $_POST['pick'];
		$tech = $_POST['tech'];
		$redirect = $_POST['redirect'];

		foreach ($data as $pick) 
		{
			if($pick != $tech){
				$this->M_monitor->pick($pick, $tech);
			}	
		}
		return redirect('C_monitoring?'.$redirect);
	}

	public function cancel_asst()
	{
	
			$tech_id = $_POST['data_tek'];
			$asst_id = $_POST['data_asst'];

			$this->M_monitor->cancel_asst($tech_id, $asst_id);	
		
	}

}	