<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_tools extends CI_Controller {
	
	public function __construct()
  	{
	    parent::__construct();
	    $user = $this->session->userdata('myuser');
	    $this->load->model('M_tools', 'mtools');
	    
	    if(!isset($user) or empty($user))
	    {
	      redirect('c_loginuser');
	    }
  	}

  	public function index()
  	{
      $mtools = $this->mtools;
      $holder = $this->mtools->toolHolder();

  		$data['mtools'] = $mtools;
      $data['holder'] = $holder;
      $data['view'] = 'content/content_tools';
  		$this->load->view('template/home', $data);
  	}

    public function detail_holder($user)
    {
      $holder = $this->mtools->details_holder($user);
      $tbl_holder = $this->mtools->table_details_holder($user);
      $mtools = $this->mtools;

      $data['mtools'] = $mtools;
      $data['tbl_holder'] = $tbl_holder;
      $data['holder'] = $holder;
      $data['view'] = 'content/content_details_tool_holder';
      $this->load->view('template/home', $data);
    }

  	public function listTools()
  	{
  		if($this->input->post('take')) {
        $this->mtools->add_takeTool();
        redirect('C_tools/listTools');
      
      }elseif($this->input->post('report')) {
        $this->mtools->report();
        redirect('C_tools/listTools');
      
      }elseif($this->input->post('loss')) {
        $this->mtools->LossReport();
        redirect('C_tools/listTools');
      
      }elseif ($this->input->post('kill')) {
        $this->mtools->KillTools();
        redirect('C_tools/listTools');
      
      }elseif($this->input->post('handover')) {
        $this->mtools->HandOver();
        redirect('C_tools/listTools');
      }
      
      $mtools = $this->mtools;
  		$listTools = $this->mtools->ListTools();
      $karyawan = $this->mtools->employee();

  		$data['employee'] = $karyawan;
      $data['mtools'] = $mtools;
  		$data['listTools'] = $listTools;
  		$data['view'] = 'content/content_list_tools';
  		$this->load->view('template/home', $data);

  	}

  	public function new_tool()
  	{
  		if($this->input->post()) {
  			$this->mtools->NewTool();
  			redirect('C_tools/new_tool');
  		}
  		$kar = $this->mtools->employee();
      $mtools = $this->mtools;
  		//$countrow = $this->mtools->idTool();

  		$data['karyawan'] = $kar;
      $data['mtools'] = $mtools;
  		//$data['count'] = $countrow;
  		$data['view'] = 'content/form_new_tools';
  		$this->load->view('template/home', $data);
  	}

    public function editTool($id)
    {
      if($this->input->post()) {
        $this->mtools->UpdateTool();
        redirect('C_tools/detail_tool/'.$id);
      }
      $kar = $this->mtools->employee();
      $edit = $this->mtools->editTool($id);
      $mtools = $this->mtools;

      $data['edit'] = $edit['tool'];
      $data['photo'] = $edit['photo'];
      $data['karyawan'] = $kar;
      $data['mtools'] = $mtools;
      $data['view'] = 'content/content_edit_tools';
      $this->load->view('template/home', $data);
    }

    public function DeleteFiles()
    {
      if($this->input->post()) {
        $this->mtools->DeleteFiles();
      }
    }

   /*  public function takeTool() 
    {
      if ($this->input->post()) {
        $this->mtools->add_takeTool();
      }
    } */

    public function detail_tool($id)
    {
      $detail = $this->mtools->detailsTool($id);
      $mtools = $this->mtools;

      $data['detail'] = $detail;
      $data['mtools'] = $mtools;
      $data['view'] = 'content/content_details_tool';
      $this->load->view('template/home', $data);
    }

    public function log_tool($id)
    {
      $log = $this->mtools->logTool($id);
      $mtools = $this->mtools;

      $data['mtools'] = $mtools;
      $data['log'] = $log;
      $this->load->view('content/content_tools_log', $data);
    }

    public function acc_kill($id)
    {
      $this->mtools->acc_kill($id);
      redirect('C_tools/listTools');
    }

    public function add_notes()
    {
      if($this->input->post()) {
        $tl_id = $this->input->post('tool_id');
        $this->mtools->add_notes();

        redirect('C_tools/detail_tool/'.$tl_id);
      }
    }

}