<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Project_m', 'mpro');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}

	public function index()
	{
		$data['view'] = 'content/project/index';
		$this->load->view('template/home', $data);
	}

	public function add()
	{
		if($this->input->post())
		{

			$html = "<div class='alert alert-success' style='font-size: 14px;'>
						<span class='fa fa-check-circle fa-lg'></span> Data Project baru berhasil ditambahkan.
						<span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
					</div>";
			$this->session->set_flashdata('message', $html);

			//echo json_encode("Project/details/".$this->mpro->addData());
			
			redirect('Project/details/'.$this->mpro->addData());
			
		}	

		$data['employee']  	= $this->mpro->getEmployee();
		$data['qc']  	= $this->mpro->getFileQC();
		$data['view'] 		= 'content/project/form_new_project';
		$this->load->view('template/home', $data);
	}

	public function details($id)
	{
		$getData = $this->mpro->getDetailsProject($id);
		$files 	 = $this->mpro->getFiles($id);
		$log 	 = $this->mpro->getLogProject($id);
		$karyawan = $this->mpro->getEmployee($id);
		$listProgress = $this->mpro->getProgressList($id);
		$contributor = $this->mpro->getContributor($id);
		$ketentuan = $this->mpro->getKetentuan($id);
		$link_modul = $this->mpro->link_modul($id);
		$link_dlv = $this->mpro->link_modul_del($id);
		$gethighlight = $this->mpro->gethighlight($id);
		$countFiles = $this->mpro->countFiles($id);
		$fileACCcus = $this->mpro->getFilesACCcus($id);
		$fileACCsales = $this->mpro->getFilesACCsales($id);

		$data['detail'] = $getData; 
		$data['files'] = $files;
		$data['log'] = $log;
		$data['karyawan']  	= $karyawan;
		$data['listProgress'] = $listProgress;
		$data['contributor'] = $contributor;
		$data['ketentuan'] = $ketentuan;
		$data['link_modul'] = $link_modul;
		$data['link_dlv'] = $link_dlv;
		$data['gethighlight'] = $gethighlight;
		$data['countfiles'] = $countFiles;
		$data['fileACCcus'] = $fileACCcus;
		$data['fileACCsales'] = $fileACCsales;
		$data['view'] = 'content/project/content_project_details';
		$this->load->view('template/home', $data);
	}

	public function add_pesan()
	{
		if($this->input->post())
		{
			$id = $this->input->post('project_id');
			$pesan = $this->input->post('msg');

			$this->mpro->logProject($id, 'Pesan', '0', $pesan);

			redirect('Project/details/'.$id);
		}	
	}

	public function UploadFiles()
	{
		if($this->input->post())
		{
			$tipe = $this->input->post('tipefile');
			$id = $this->input->post('project_id');

			$this->mpro->uploadfiles($id, $tipe);

			redirect('Project/details/'.$id);
		}
	}

	public function AddContributor()
	{
		if($this->input->post())
		{
			$id = $this->input->post('project_id');

			$this->mpro->addContributor('', $id);

			redirect('Project/details/'.$id);
		}
	}

	public function Updates()
	{
		if($this->input->post())
		{
			$id = $this->input->post('project_id');

			$this->mpro->Updates();

			redirect('Project/details/'.$id);
		}
	}

	public function UpdateDeadline($id)
	{
		if($this->input->post())
		{
			$this->mpro->UpdateDeadline();

			redirect('Project/details/'.$id);
		}

		$getData = $this->mpro->getDetailsProject($id);
		$getDays = $this->mpro->getDaysProgress($id);

		$data['detail'] = $getData;
		$data['getDays'] = $getDays;
		$data['view'] = 'content/project/update_deadline';
		$this->load->view('template/home', $data);
	}

	public function AddReminder()
	{
		if($this->input->post())
		{
			$id = $this->input->post('project_id');

			$this->mpro->AddReminder();

			redirect('Project/details/'.$id);
		}
	}

	public function GoTagih($project_id)
	{
			$this->mpro->GoTagih($project_id);
			redirect('Project/details/'.$project_id);
	}

	public function getDataTable($cons = '')
	{
		$dhc = $this->mpro->getProject($cons);

		$data = array();

		foreach ($dhc as $key => $row) {
			$data[$key]['ProjectID']	= $row['id'];
			$data[$key]['Customer']     = $row['perusahaan'];
			$data[$key]['Customer']     .= "<br>".$row['project_addr'];
			$data[$key]['DPdate'] 		= date('d-m-Y', strtotime($row['dp_date']));
			$data[$key]['ProjectDesc'] 	= $row['description'];
			$data[$key]['ProjectDesc']	.= "<br> Deadline BAST : ".date('d-m-Y', strtotime($row['deadline_date']));
			$data[$key]['ProjectDesc']	.= "<br> Salesman : ".$row['nickname'];
			$data[$key]['ProjectAging'] =  $this->getAging($row);
			$data[$key]['Progress'] 	= "<div class='progress'>".$this->getProgress($row)."</div>".$row['proj_type'];
			$data[$key]['Status'] 		= $this->getStatus($row);
			$data[$key]['Execution'] 	= $this->getExecution($row);
			$data[$key]['Action']		= "<a href='".site_url('Project/details/'.$row['id'])."' target='_blank' class='btn btn-sm btn-default'>Detail</a>";
		}

		$results = array(
			"sEcho" 				=> 1,
			"iTotalRecords" 		=> count($data),
			"iTotalDisplayRecords" 	=> count($data),
			"aaData"				=> $data
		);

	  	echo json_encode($results);
	}

	private function getAging($args)
	{
		$row = $args;
		$str = '';

		if($row['date_closed'] == '0000-00-00 00:00:00') {
			$date = date('Y-m-d H:i:s');
		}else {
			$date = $row['date_closed'];
		}
		
		$datediff = datediff($row['deadline_date'], $date);  
		if($row['deadline_date'] > $date) {
			$plusmin = " +";
		}elseif($row['deadline_date'] <= $date) {
			$plusmin = " -";
		}
		
		$datediff = $plusmin.$datediff['days_total']."d ".$datediff['hours']."h ".$datediff['minutes']."m";
				
		if(!empty($row['days_deadline'])) {
			$str = $row['days_deadline']."d <br> ".$datediff;
		}else{
			$str = "0d <br> ".$datediff;
		}

		return $str;
	}

	private function getProgress($args)
	{
		$row = $args;

		$prg = '';
		
		if($row['last_progress'] >= '1') {
			$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#001433;">
	      DP
	    </div>';
		}
		
		if($row['last_progress'] >= '2') {
			$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#001f4d;">
	      Surv
	    </div>';
		}

		if($row['last_progress'] >= '3') {
			$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#002966">
	      K.Off
	    </div>';
		}

		if($row['last_progress'] >= '4') {
			$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#003380;">
	      Mat
	    </div>';
		}

		if($row['last_progress'] >= '5') {
			$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#003d99;">
	      Prod
	    </div>';
		}

		if($row['last_progress'] >= '6') {
			$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#0047b3;">
	      Delv
	    </div> ';
		}

		if($row['last_progress'] >= '7') {
			$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#0052cc;">
	      Inst
	    </div> ';
		}

		if($row['last_progress'] >= '8') {
			$prg .= ' <div class="progress-bar" role="progressbar" style="width:11%; background-color:#005ce6;">
	      Fin
	    </div>';
		}

		if($row['last_progress'] >= '9') {
			$prg .= '<div class="progress-bar" role="progressbar" style="width:12%; background-color:#0066ff;">
	      Paid
	    </div>';
		}

		return $prg;
	}

	private function getStatus($args)
	{
		$row = $args;
		$str = '';

		
		
		if(!empty($row['dates']))
		{
			$sts = date('Y-m-d', strtotime($row['dates']));
			$dclose = date('Y-m-d', strtotime($row['date_closed']));

			if($row['date_closed'] != '0000-00-00 00:00:00') {
				$now = $dclose;
				$diff = datediff($sts, $dclose);
			}else {
				$now = date('Y-m-d');
				$diff = datediff($sts, $now);
			}

			if($now < $sts OR $sts == $now) {
				$str .= "On-Schedule / +".$diff['days_total']."d";
			}elseif($now > $sts) {
				$str .= "Overdue / -".$diff['days_total']."d";
			}
		}else{
			$str .= "-";
		}
		return $str;
	}

	private function getExecution($args)
	{
		$row = $args;

		$str = '';
		
		if($row['date_closed'] != '0000-00-00 00:00:00') {
			$str .= "<span style='color : green;'> Finished </span>";
		}elseif($row['execution'] == '0') { 
			$str =  "Queue"; 
		}elseif($row['execution'] == '1'){ 
			$str = "<img src = ".base_url('assets/images/job_edit.png')." />"; 
		} 

		return $str;
	}

	public function linkTodel($project_id)
	{
		$sql = "SELECT id, customer_id FROM tbl_project_dhc WHERE id = $project_id";
		$row_arr = $this->db->query($sql)->row_array();

		$arr = array(
			'id' => $row_arr['id'],
			'customer_id' => $row_arr['customer_id'],
			'modul' => '9',
			'divisi' => 'dhc',
			'deal_value' => '0'
		);

		$this->session->set_userdata('sess_project_id', $arr);
		redirect('C_delivery/add/delv');
	}

	public function Uploadhighlight()
    {
        if($this->input->post())
        {
            $id = $this->input->post('project_id');
            $this->mpro->Uploadhighlight();
 
            redirect('Project/details/'.$id);
        }   
    }
    
    public function AddNotes()
    {
        $id        = $this->input->post('project_id');
        $this->mpro->Highlight_fin();
 
        redirect('Project/details/'.$id);
    }
}