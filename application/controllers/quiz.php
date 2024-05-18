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
		$role = $_SESSION['myuser']['role'];



		$data['notification'] = $this->mhome->getNotification();

		if($role !='Siswa')
		{
			$data['list']  = $this->dtmateri->getMateri();

			$data['view'] = 'content/quiz/index';
			$data['mhome'] = $this->mhome;
		}else
		{	
			$data['view'] = 'content/quiz/index_siswa';
			$data['mhome'] = $this->mhome;
		}

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

	public function list_quiz_siswa($filter)
	{
		$list = $this->dtquiz->getQuizSiswa($filter);
		
		$data = array();
		$user_prev_browser = array();
		$user_prev_ip = array();
		$no = $_POST['start'];
		
        foreach ($list as $value) 
		{
			

			switch ($value['status']) 
			{
				case 'WorkingOn':
					 $status = '<span class="badge" style="background-color:#D8AF21; color:white">Working On</label>';
				break;

				case 'Completed':
					  $status = '<span class="badge" style="background-color:#3B7220; color:white">Completed</label>';
				break;
				
	
			}


			if($value['date_finished'] =='0000-00-00 00:00:00')
			{
				$date_finished='-';
			}else
			{
				$date_finished =date('d-m-Y',strtotime($value['date_finished'])); 

				$diff = datediff($value['date_start'],$value['date_finished']);

				$date_finished.= "<br><br>Waktu pengerjaan : ".$diff['hours_total']."H ".$diff['minutes']."m ".$diff['seconds']."s";
			}


			$no++;
	    	$jsondata = array();
			
			$jsondata[] = $value['id'];
			$jsondata[] = $value['quiz_name'];
			$jsondata[] = date('d-m-Y H:i:s',strtotime($value['date_start']));
			$jsondata[] = $date_finished;
			$jsondata[] = $status;
			$jsondata[] = '<a href="'.urldecode(site_url('quiz/detail_quiz_siswa/'.$value['id'])).'" class="btn btn-primary btn-sm" style="color:white;">Detail</a>';

					
			$data[] = $jsondata;
	    }
 
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dtquiz->count_all_siswa($filter),
			"recordsFiltered" => $this->dtquiz->count_filtered_siswa($filter),
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

	public function edit($id)
	{

		$data['notification'] = $this->mhome->getNotification();

		$data['dtquiz'] = $this->dtquiz;
		
		$data['detail'] =$this->dtquiz->getDetail($id);
		$data['soal'] =$this->dtquiz->getSoal($id);


		$data['view'] = 'content/quiz/edit_quiz';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function detail_satuan($id)
	{
		$id_soal = $this->input->post('id');

		$sql ="SELECT * FROM tbl_quiz_soal WHERE id ='$id_soal'";
		$detail_soal = $this->db->query($sql)->row_array();

		$jawaban = $this->dtquiz->getJawaban($id,$id_soal);


		$data = array(
			'detail_soal' => $detail_soal,
			'jawaban' => $jawaban,
		);


		echo json_encode($data);
	}

	public function edit_soal($id)
	{
		$this->dtquiz->edit_soal($id);
		redirect('quiz/detail/'.$id);
	}

	public function delete_jawaban($id)
	{
		$this->dtquiz->delete_soal($id);
		redirect('quiz/detail/'.$id);
	}

	public function add_soal($id)
	{
		$this->dtquiz->add_soal($id);
		redirect('quiz/detail/'.$id);
	}


	public function add_kode()
	{
		$this->dtquiz->add_kode();
	}


	public function acc_quiz($id_soal)
	{	
		$data['notification'] = $this->mhome->getNotification();

		$data['detail'] =$this->dtquiz->getDetail($id_soal);

		$data['view'] = 'content/quiz/acc_quiz';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function join_quiz($id_soal)
	{
		$this->dtquiz->join_quiz($id_soal);
	}

	public function task($id)
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['dtquiz'] = $this->dtquiz;
		$data['soal'] =$this->dtquiz->getSoalQuizSiswa($id);
		$data['detail'] = $this->dtquiz->detail_pengerjaan($id);
		

		$data['view'] = 'content/quiz/pengerjaan_quiz';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function finished_quiz($id)
	{
		$this->dtquiz->finished_quiz($id);
		redirect('quiz/detail_quiz_siswa/'.$id);
	}

	public function detail_quiz_siswa($id)
	{
		$data['notification'] 	= $this->mhome->getNotification();
		$data['detail'] 		= $this->dtquiz->detail_pengerjaan($id);
		$data['progress'] 		= $this->dtquiz->getProgress($id);
		$soal_id 				= $data['detail']['soal_id'];
		$data['soal'] 			= $this->dtquiz->getSoal($soal_id);
		$data['dtquiz'] 		= $this->dtquiz;



		$data['view'] = 'content/quiz/detail_quiz_siswa';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

}