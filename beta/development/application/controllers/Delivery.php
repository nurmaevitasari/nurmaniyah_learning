<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))

		{
			redirect('c_loginuser');

		}

     $this->load->model('M_delivery', 'dlv_mdl');

	}

  public function index()
  {
        $data = array(
          'view' => 'content/delivery/term/index',
        );

        $this->load->view('template/home', $data);
  }

  public function term($term = '')
  {
      $data = array(
        'view' => 'content/delivery/term/index',
      );

      $this->load->view('template/home', $data);
  }

  public function do_receipt()
  {
      $data = array(
        'view' => 'content/delivery/do_receipt/index',
      );

      $this->load->view('template/home', $data);
  }

  public function getDataDoReceipt()
  {
    $status = '';
    $do_receipt = $this->dlv_mdl->__do_receipt($status);

    $data = array();
    foreach($do_receipt as $key => $row)
    {

        $data[$key]['ID']          = $row['id'];
        $data[$key]['Date']        = date('d-m-Y H:i:s', strtotime($row['date_created']));
        $data[$key]['NoDO']        = $row['no_do'];

        if($row['cabang'])
        $data[$key]['NoDO']       .= '<center style="color : maroon;">'.$row['cabang'].'</center>';

        $data[$key]['Customer']    = $row['perusahaan'];
        $data[$key]['Status']      = $this->_getStatusDoReceipt($row);
        //$data[$key]['Status']      = '';

        $data[$key]['Notes']       = $row['ket'];
        $data[$key]['Files']       = $this->_getFilesDoReceipt($row);
        //$data[$key]['Files']       = $row['file_name'];

        $data[$key]['Actions']     = $this->_getButtonsDoReceipt($row);
    }

    $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData"=> $data
    );

    echo json_encode($results);
  }

  public function getDataDelivery($term = 'delivery')
  {
    //$term = '';
    $delivery = $this->dlv_mdl->__do($term);

    $xx = count($delivery);
    $data = array();
    foreach($delivery as $key => $row)
    {
        $do_date = '';
        if($row['date_close'] != '0000-00-00 00:00:00')
        {
            $start = date('Y/m/d H:i:s', strtotime($row['date_open']));
            $closed = date('Y/m/d H:i:s', strtotime($row['date_close']));
            $total = datediff($closed, $start);

            $do_date = $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m';
        }

        $data[$key]['ID']           = $row['id'];
        $data[$key]['NoSO']         = $row['no_so'];
        $data[$key]['NoSO']        .= '<br><b style="font-size: 11px;"> By : '.$row['sales'].' - '.strtoupper($row['divisi']).' </b>';
        $data[$key]['Date']         = date('d-m-Y H:i:s', strtotime($row['date_open']));
        $data[$key]['Customer']     = $row['perusahaan'];

        if ($row['pengiriman'] != '')
        $data[$key]['Customer']           .= '<br /><font color="navy"> Metode Kirim : '.strtoupper($row['pengiriman']).' </font>';


        //$data[$key]['Items']     = str_replace(',','<br><br>', $row['product_name']);
				$data[$key]['Items']     = $row['product_name'];

        $data[$key]['TransactionVal']     = 'Rp '.number_format($row['transaksi'],'0',',','.');
        $data[$key]['DOAge']     = $do_date;

        $ShippingDate  = '<input type="hidden" name="cat" id="cat_'. $row['id'] .'" value="'.$row['category'].'" >';


        if($row['date_edit'] != '0000-00-00 00:00:00')
        {
          $ShippingDate .= '<span style="color: blue;">'.date('d-m-Y', strtotime($row['tgl_estimasi'])).'</span><br>';
          $ShippingDate .= '<span style="font-size: 10px;">Last Updated: <br />'.date('d-m-Y H:i:s', strtotime($row['date_edit'])).'<br> ';
          $ShippingDate .= '<b>By : '.$row['user_edit'].'</b></span>';
        }
				else
				{
					$ShippingDate .= date('d-m-Y', strtotime($row['tgl_estimasi']));
				}

        $data[$key]['ShippingDate']     = $ShippingDate;

        $csts = strtolower($row['status']);

        $data[$key]['Status']            = '<b>'.$row['user_pending'].'</b><br/>';
        $data[$key]['Status']           .= '<span class="label '.$csts.'">'.$row['status'].'</span><br>';

        if($csts != 'waiting'){
            $data[$key]['Status'] .= '<span style="font-size: 10px;">Last Updated: '.date('d-m-Y H:i:s', strtotime($row['date_created'])).'<br>';
            $data[$key]['Status'] .= '<b>By : '.$row['nickname'].'</b></span>';
        }

        $data[$key]['Actions'] = '
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu pull-right">
              <li><a href="'.site_url('C_delivery/details/'.$row['id']).'"><i class="fa fa-file"></i> Detail</a></li>
            </ul>
          </div>';

          $data[$key]['Decr'] = $xx;
          $data[$key]['DateClose'] = $row['date_close'];
          $data[$key]['DateEdit'] = $row['date_edit'];
          $data[$key]['DateOpen'] = $row['date_open'];
          $data[$key]['Category'] = $row['category'];
					$data[$key]['RowsTotal'] = count($delivery);

        --$xx;
    }

    $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($data),
      "iTotalDisplayRecords" => count($data),
      "aaData"=> $data
    );

    echo json_encode($results);
  }



  private function _getStatusDoReceipt($args)
  {
      $row = $args;

      $str = '';

      switch ($row['status']) {
        case 0:
            $str .= '<b><center style="color: #177EE5; ">Processing</center></b>';
          break;
        case 1:
            $str .= '<center style="font-size: 11px;">';
            $str .= '<span class="fa fa-check-circle fa-lg" style="color: green;"></span> <b style="color: green;">Received Success</b>';
            $str .= '<br />';
            $str .= "<b> by {$row['nickname']}</b><br />";
            $str .= date('Y-m-d H:i:s', strtotime($row['date_receipt']));
            $str .= '</center>';
          break;
        case 2:
            $str .= '<center>';
            $str .= '<b  style="color: #177EE5; ">Receive</b>';
            $str .= '<br />';
            $str .= "<b> by {$row['nickname']}</b><br />";
            $str .= date('Y-m-d H:i:s', strtotime($row['date_receipt']));
            $str .= '</center>';
          break;

        default:
          # code...
          break;
      }

      return $str;

  }

  private function _getFilesDoReceipt($args)
  {
      $row = $args;

      //$file_name = $row['file_name'];
      $file_name = explode(',', $row['file_name']);

      //$date_file = $row['date_file'];
      $date_file = explode(',', $row['date_file']);

      //$updo_nickname = $row['updo_nickname'];
      $updo_nickname = explode(',', $row['updo_nickname']);

      $str = '';
      foreach ($file_name as $key => $value) {
        $str .= $date_file[$key].' '.$updo_nickname[$key].' '.'<a href="'.base_url('assets/images/upload_do/'.$value).'" target="_blank">'.$value.'</a><br />';
      }

      //$file_name = str_replace(',',$row['nickname'].'<br>',$row['file_name']);

      return $str;

  }

  private function _getButtonsDoReceipt($args)
  {
      $user = $this->session->userdata('myuser');

      $row = $args;

      $act = array(
        'final' => '<li><a href="javascript:;" onclick="baseJs.ChangeStatus(this)" name="btn-action" attr="1" id="btn_'.$row['id'].'"><i class="fa fa-cubes"></i> Final Receive</a></li>',
        'receive' => '<li><a href="javascript:;" onclick="baseJs.ChangeStatus(this)" name="btn-action"  attr="2" id="btn_'.$row['id'].'"><i class="fa fa-archive"></i> Receive</a></li>',
        'files' => '<li><a href="javascript:;" data-toggle="modal" onclick="baseJs.UploadReceipt(this)"  data-id = "'.$row['id'].'"><i class="fa fa-file"></i> Add File</a></li>',
      );

      $btn = '';
      if($_SESSION['myuser']['role_id'] != '15') {
        $btn .= '
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu pull-right">';

        if(in_array($user['position_id'], array('9', '14')) AND $row['status'] != '1') {
          $btn .= $act['final'];
        }
        elseif (in_array($user['position_id'], array('3', '14', '77')) AND $row['status'] == '0') {
          $btn .= $act['receive'];
        }
        else{
          $btn .= $act['files'];
        }

        $btn .='</ul>
          </div>';
      }


      return $btn;
  }

  // private function _getFilesDoReceipt($id)
  // {
  //     $files = $this->dlv_mdl->GetUploadReceipt($id);
  //
  //     $str = '';
  //     foreach ($files as $fs) {
  //         $str .= date('d/m/Y H:i:s', strtotime($fs['date_created']))." <b>".$fs['nickname']."</b>: <br>";
  //         $str .= '<a href="'.base_url('assets/images/upload_do/'.$fs['file_name']).'" target="_blank">'.$fs['file_name'].'<br></a>';
  //     }
  //
  //     return $str;
  // }

}
