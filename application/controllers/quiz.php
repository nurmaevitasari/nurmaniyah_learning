<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		$this->load->model('M_data_materi', 'dtmateri');
		$this->load->model('M_data_siswa', 'dtsiswa');
		$this->load->model('M_data_guru', 'dtguru');
		$this->load->model('M_data_quiz', 'dtquiz');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}

	public function index()
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['list']  = $this->dtmateri->getMateri();

		$data['view'] = 'content/quiz/index';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function list_quiz($filter)
	{
		$list = $this->dtquiz->getQuiz($filter);
		
		$data = array();
		$user_prev_browser = array();
		$user_prev_ip = array();
		$no = $_POST['start'];
		
        foreach ($list as $value) 
		{
			

			switch ($value['status']) 
			{
				case 'OnGoing':
					 $status = '<span class="badge" style="background-color:#D8AF21; color:white">On Going</label>';
				break;

				case 'Completed':
					  $status = '<span class="badge" style="background-color:#3B7220; color:white">Completed</label>';
				break;

				case 'Cancelled':
					 $status = '<span class="badge" style="background-color:red; color:white">Cancelled</label>';
				break;
				
	
			}


			$no++;
	    	$jsondata = array();
			
			$jsondata[] = $value['id'];
			$jsondata[] = $value['quiz_name'];
			$jsondata[] = date('d-m-Y H:i:s',strtotime($value['date_created']));
			$jsondata[] = date('d-m-Y',strtotime($value['date_expired']));
			$jsondata[] = $value['amount_of_work'];
			$jsondata[] = $status;
			$jsondata[] = '<a href="'.urldecode(site_url('quiz/detail/'.$value['id'])).'" class="btn btn-primary btn-sm" style="color:white;">Detail</a>';

					
			$data[] = $jsondata;
	    }
 
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dtquiz->count_all($filter),
			"recordsFiltered" => $this->dtquiz->count_filtered($filter),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);
	}

	public function add_new()
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['list']  = $this->dtmateri->getMateri();

		$data['view'] = 'content/quiz/form_new_quiz';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function save_quiz()
	{
		$this->dtquiz->save_quiz();
	}

	public function detail($id)
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['dtquiz'] = $this->dtquiz;
		
		$data['detail'] =$this->dtquiz->getDetail($id);
		$data['soal'] =$this->dtquiz->getSoal($id);


		$data['view'] = 'content/quiz/detail_quiz';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

}