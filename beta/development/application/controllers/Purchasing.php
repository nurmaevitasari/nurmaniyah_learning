<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasing extends CI_Controller {

	 public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');

		}

     $this->load->model('M_purchasing', 'pr');

	}

  public function index()
  {
      $data = array(
        'view' => 'content/purchasing/index',
      );

      $this->load->view('template/home', $data);
  }

  public function getDataPR()
  {
      $purchasing = $this->pr->__tablePR();

      $data = array();
      foreach($purchasing as $key => $row)
      {
					$PRAge = '';
					if($row['status'] == 101)
					{
	          $start  = date('Y/m/d H:i:s', strtotime($row['date_created']));
	          $closed = date('Y/m/d H:i:s', strtotime($row['date_closed']));
	          $fin    = datediff($closed, $start);

						$PRAge = $fin['days_total']."d ".$fin['hours']."h ".$fin['minutes']."m ";
					}
          $data[$key]['ID']        = $row['id'];
          $data[$key]['Date']      = date('d/m/Y H:i:s', strtotime($row['date_created']));
          $data[$key]['Operator']  = $row['nickname'] .'<br> ('.$row['position'].')';
          //$data[$key]['Item']      = $this->_prItems($row['id']);
					$data[$key]['Item']      = $row['items'];

					//$data[$key]['PRAge']     = ($row['status'] == '101') ? $fin['days_total']."d ".$fin['hours']."h ".$fin['minutes']."m " : '<input type="hidden" class="date_start_time" value="'.$row['date_created'].'">';
					$data[$key]['PRAge']     = $PRAge;
					$data[$key]['Deadline']  = date('d/m/Y', strtotime($row['date_deadline']));
          $data[$key]['Status']    = $this->pr->getStatusPR($row['status'], $row);
          $data[$key]['Approval']  = $this->_getApproval($row);
          $data[$key]['Actions'] = '
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu pull-right">
                <li><a href="'.site_url('c_purchasing/details/'.$row['id']).'"><i class="fa fa-file"></i> Detail</a></li>
              </ul>
            </div>';
					$data[$key]['StatusOri']    = $row['status'];
					$data[$key]['DateCreated']    = $row['date_created'];
					$data[$key]['Vendors']    = $row['vendors'];
					$data[$key]['Qty']    = $row['qty'];
					$data[$key]['Mou']    = $row['mou'];
      }

      $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData"=> $data
      );

      echo json_encode($results);
  }

  private function _prItems($id)
  {
      $items = $this->pr->loadItems($id);

      $data = '<ul>';

      foreach ($items as $val) {
        $data .= "<li>[".$val['vendor']."] - ".$val['items']." (".$val['qty']." ".$val['mou'].")</li>";
      }

      $data .= '</ul>';

      return $data;

  }

  private function _getApproval($args)
  {
    $user = $this->session->userdata('myuser');
    $row = $args;

    $appr = $this->pr->getApproval($row['id']);
    $co = count($appr);
    if(!empty($co)) {
      $arr = $appr[0];
    }

    $pos = substr($row['position'], -3);
    $user_pos = substr($user['position'], -3);

    $str = '';

    $btn = array(
        'approve1' => '<a href="'.site_url('c_purchasing/UpStatus/1/'.$row['id'].'/').'" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm("Anda menyetujui PR ini. Lanjutkan ?")"><i class="glyphicon glyphicon-ok" ></i></a>',
        'approve3' => '<a href="'.site_url('c_purchasing/UpStatus/3/'.$row['id'].'/').'" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm("Anda menyetujui PR ini. Lanjutkan ?")"><i class="glyphicon glyphicon-ok" ></i></a>',
        'remove'  => '<button type="button" name="no" class="btn btn-xs btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="'.$row['id'].'"><span class="glyphicon glyphicon-remove"></span></button>',
    );

    if($row['status'] == '0' AND $co == 0) {

      if($row['sales_id'] != $user['karyawan_id']) {
        if(in_array($user['position_id'], array('1', '2', '77')))  {
          $str .= $btn['approve3'];
					$str .= '&nbsp;&nbsp;';
          $str .= $btn['remove'];
        }
        elseif(in_array($user['position_id'], array('55', '56', '57', '58', '59', '95')) AND $user['cabang'] == $row['cabang'])
        {
          $str .= $btn['approve1'];
					$str .= '&nbsp;&nbsp;';
          $str .= $btn['remove'];
        }
        elseif (in_array($user['position_id'], array('88', '89', '90', '91', '92', '93')) AND $pos == $user_pos AND $row['cabang'] == '')
        {
          $str .= $btn['approve1'];
					$str .= '&nbsp;&nbsp;';
          $str .= $btn['remove'];
        }
      }

    }
    elseif(!empty($appr) AND in_array($user['position_id'], array('1', '2', '77')) AND $co == 1 AND ($arr['status_approval'] == 1 OR $arr['status_approval'] == 2))
    {
        if($arr['status_approval'] == '1') {
          $str .= $btn['approve3'];
					$str .= '&nbsp;&nbsp;';
          $str .= $btn['remove'];
          $str .= '<br>';
          $str .= '<span style="font-size: 11px;">'.date('d/m/Y H:i:s', strtotime($arr['date_created'])).'</span></br>';
          $str .= '<b style="color:#0CB754">Approved 1</b> By : <b>'.$arr['nickname'].'</b><br>';
        }
        elseif ($arr['status_approval'] == '2') {
          $str .= '<span style="font-size: 11px;">'.date('d/m/Y H:i:s', strtotime($arr['date_created'])).'</span></br>';
          $str .= '<b style="color:#0CB754">Approved 1</b> By : <b>'.$arr['nickname'].'</b><br>';
          $str .= 'Ket : '.$arr['alasan'].'<br>';
        }
    }
    else
    {
      foreach ($appr as $key => $val) {
        if($val['status_approval'] == '1' OR $val['status_approval'] == '3') {
          $str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
          $str .= "<b style='color:#0CB754'>Approved </b> By : <b>".$val['nickname']."</b><br>";
        }elseif ($val['status_approval'] == '2' OR $val['status_approval'] == '4') {
          $str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
          $str .= "<b style='color:#CD0000'>Not Approved </b> By : <b>".$val['nickname']."</b><br>";
          $str .= "Ket : ".$val['alasan']."<br>";
        }
       }
    }

    return $str;

  }


}
