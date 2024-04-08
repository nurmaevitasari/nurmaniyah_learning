<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	 public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');

		}

     $this->load->model('M_import', 'mimport');

	}

  public function index()
  {
      $data = array(
        'view' => 'content/import/index',
      );

      $this->load->view('template/home', $data);
  }

  public function getDataImport()
  {
    $import = $this->mimport->getDataImport();

    $data = array();
    foreach($import as $key => $row)
    {
				$ShiptAge = '';

				if($row['status'] == 8)
				{
					$min  = date('Y/m/d H:i:s', strtotime($row['date_created']));
        	$max = date('Y/m/d H:i:s', strtotime($row['date_closed']));

        	$total = datediff($max, $min);

					$ShiptAge = $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m '.$total['seconds'].'s ';
				}

        $data[$key]['No']              = ($key+1);
        $data[$key]['ShipmentID']      = $row['shipment'];
        $data[$key]['ShipmentID']      = $row['shipment'];
        $data[$key]['Date']            = date('d-m-Y H:i:s', strtotime($row['date_created']));
        $data[$key]['ShipmentVia']     = $row['ship_via'].'<br>'.$row['nickname'];
        $data[$key]['DeptArr']         = 'Dept : '.date('d-m-Y', strtotime($row['dept'])).'<br>';
        $data[$key]['DeptArr']        .= 'Arr : '.date('d-m-Y', strtotime($row['arrival'])).'<br>';
        $data[$key]['ArrDest']         = $row['kedatangan'];
        //$data[$key]['ShiptAge']        = ($row['status'] == 8) ? $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m '.$total['seconds'].'s ' : '<input type="hidden" class="date_start_time" value="'.$min.'">';
				$data[$key]['ShiptAge']        = $ShiptAge;
				$data[$key]['GoodsInfo']       = $row['info'];
        $data[$key]['Status']          = $this->mimport->getStatus($row['status']);
        $data[$key]['Actions']         = $this->_importButtons($row);
        $data[$key]['StatusOri']       = $row['status'];
        $data[$key]['IDImport']        = $row['id'];

        if($_SESSION['myuser']['role_id'] != '15') {
          $data[$key]['Notes']           = !empty($row['notes']) ? $row['notes'] : '<button class="btn btn-primary btn-notes btn-xs" data-id = "'.$row['id'].'"><span class="fa fa-plus"></span></button>';
        }
        else{
          $data[$key]['Notes']           = '';
        }

				$data[$key]['DateCreated']        = date('Y/m/d H:i:s', strtotime($row['date_created']));


    }

    $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData"=> $data
    );

    echo json_encode($results);
  }

  private function _importButtons($args)
  {
      $act = array(
        'details' => '<li><a href="'.site_url('c_import/details/'.$args['id']).'"><i class="fa fa-file"></i> Details</a></li>',
        'edit' => '<li><a href="'.site_url('c_import/details/'.$args['id']).'"><i class="fa fa-pencil"></i> Edit</a></li>',
      );

      $btn = '
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu pull-right">';

      if($_SESSION['myuser']['position_id'] == '1' OR $_SESSION['myuser']['position_id'] == '2' OR $_SESSION['myuser']['position_id'] == '4' ){
        $btn .= $act['details'];
        $btn .= $act['edit'];
      }
      else
      {
        $btn .= $act['details'];
      }

      $btn .='</ul>
        </div>';

        return $btn;

  }


}
