<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))

		{
			redirect('c_loginuser');

		}

     $this->load->model('M_tools', 'mtools');

	}

  public function index()
  {
        $data = array(
          'view' => 'content/tools/index',
        );

        $this->load->view('template/home', $data);
  }

  public function list_tools()
  {

    $karyawan = $this->mtools->employee();

    $data = array(
      'view' => 'content/tools/list_tools',
      'employee' => $karyawan,
    );

    $this->load->view('template/home', $data);

  }

  public function getDataTools()
  {
    $listTools = $this->mtools->__ListTools();

    $data = array();
    foreach($listTools as $key => $row)
    {
        //$data[$key]['No']     = ($key+1);

        $data[$key]['No']     = $row['id'];


        if(file_exists(FCPATH.'assets/images/upload_tools/'.$row['file_name']))
        $data[$key]['Photo']  = '<img src="'.base_url('assets/images/upload_tools/'.$row['file_name']).'" alt="'.$row['file_name'].'" width="50">';
        else
        $data[$key]['Photo']  = 'No Foto';

        $data[$key]['IDTool'] = $row['code'];


        $data[$key]['Name']   = $row['name'];
        $data[$key]['ToolHolder'] = ($row['nickname']) ? $row['nickname'] : 'Available';
        $data[$key]['Quantity'] = $row['quantity'];
        $data[$key]['Notes'] = $row['notes'];
        $data[$key]['Status'] = $row['st_type'];
        $data[$key]['Status'] .= '
        <input type="hidden" name="price" value="Rp '.number_format($row['price'],'0',',','.').'">
          <input type="hidden" name="tipe" value="'.$row['type'].'">
          <input type="hidden" name="brand" value="'.$row['brand'].'">
        ';
        $data[$key]['Actions'] = $this->_toolsButtons($row);
    }

    $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData"=> $data
    );

    echo json_encode($results);
  }

  public function getDataHolderTools()
  {
    $holder = $this->mtools->__toolHolder();

    $data = array();
    foreach($holder as $key => $row)
    {
        $date_rpt = $this->mtools->date_report($row['user_holder']);

        $data[$key]['No']           = ($key+1);
        $data[$key]['Name']         = $row['nickname'];
        $data[$key]['Position']     = $row['position'];
        $data[$key]['ToolsInHand']  = ($row['jml_tools'] != '0') ? "Total ".$row['jml_tools']." items / Rp. ".number_format($row['ttl_price'], "0", ",", ".") : "Total ".$row['jml_tools']." items/ Rp. 0";
        $data[$key]['LastReport']   = ($date_rpt['tgl_rep']) ? date('d-m-Y H:i:s', strtotime($date_rpt['tgl_rep'])) : date('d-m-Y H:i:s', strtotime($row['date_tool']));
        $data[$key]['Actions']      = '
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu pull-right">
              <li><a href="'.site_url('C_tools/detail_holder/'.$row['user_holder']).'"><i class="fa fa-compress"></i> Details</a></li>
            </ul>
          </div>';
    }

    $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData"=> $data
    );

    echo json_encode($results);
  }

  private function _toolsButtons($args)
  {
    $user = $this->session->userdata('myuser');

    $act = array(
      'details' => '<li><a href="'.site_url('C_tools/detail_tool/'.$args['id']).'" target="_blank"><i class="fa fa-file"></i> Details</a></li>',
      'edit'    => '<li><a href="'.site_url('C_tools/editTool/'.$args['id']).'"><i class="fa fa-pencil"></i> Edit</a></li>',
      'tool_report' => '<li><a href="javascript:;" title="Tool Report" onclick="openModal(this)" data-btn="report"><i class="fa fa-file-text-o"></i> Tool Report</a></li>',
      'hand_over' => '<li><a href="javascript:;" title="Hand Over" onclick="openModal(this)" data-btn="handover"><i class="fa fa-exchange"></i> Hand Over</a></li>',
      'lost_report' => '<li><a href="javascript:;" title="Loss Report" onclick="openModal(this)" data-btn="loss"><i class="fa fa-files-o"></i> Lost Report</a></li>',
      'kill_toll' => '<li><a href="javascript:;" title="Kill Tool" onclick="openModal(this)" data-btn="kill"><i class="fa fa-ban"></i> Kill Tool</a></li>',
      'acc_kill_toll' => '<li><a href="'.site_url('C_tools/acc_kill/'.$args['id']).'" title="ACC Kill Tool" onclick="return confirm('.$args['name'].' ini akan di kill. Lanjutkan?)"><i class="fa fa-check"></i> Acc Kill Tool</a></li>',
    );

    $btn = '
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu pull-right">';

    $btn .= $act['details'];

    if($_SESSION['myuser']['position_id'] == '77' AND $args['sts_kill'] != '1') {
      $btn .= $act['acc_kill_toll'];
    }
    elseif(in_array($user['position_id'], array('1', '2', '55', '56', '57', '58', '59', '95', '9', '77', '18')) OR $user['karyawan_id'] == $args['user_holder'] OR $user['karyawan_id'] == '16' )
    {
        $btn .= $act['edit'];
        $btn .= $act['tool_report'];
        $btn .= $act['hand_over'];
        $btn .= $act['lost_report'];

        if($args['status'] != '8' AND $user['position_id'] != '77') {
          $btn .= $act['kill_toll'];
        }
    }
    elseif(in_array($_SESSION['myuser']['position_id'], array('60', '62', '75', '83')) OR $args['nickname'] == $_SESSION['myuser']['nickname'] AND $args['status'] != '7' AND empty($args['sts_kill']))
    {
        $btn .= $act['tool_report'];
        $btn .= $act['hand_over'];
        $btn .= $act['lost_report'];

        if($args['status'] != '8' AND $user['position_id'] != '77') {
          $btn .= $act['kill_toll'];
        }
    }

    $btn .='</ul>
      </div>';

      return $btn;
  }

}
