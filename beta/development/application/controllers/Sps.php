<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Sps extends CI_Controller {

	 public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))

		{
			redirect('c_loginuser');

		}

		$this->load->model('sps_model', 'msps');

	}

  public function index()
  {

    $data = array(
      'view' => 'content/sps/index',

    );

    $this->load->view('template/home', $data);


  }

  public function selected()
  {
    $data = array(
      'view' => 'content/sps/index',

    );

    $this->load->view('template/home', $data);
  }

  public function getDataTable($cons = '')
  {
      $sps = $this->msps->getData($cons);

      $data = array();
      foreach($sps as $key => $row)
      {
					$SPSAge = '';
					if($row['date_close'] != '0000-00-00 00:00:00')
					{
							$start = date('Y/m/d H:i:s', strtotime($row['date_open']));
							$closed = date('Y/m/d H:i:s', strtotime($row['date_close']));
							$total = datediff($closed, $start);

							if($row['status'] == 101)
							{
									$SPSAge = $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m';
							}

					}

					$PurchaseAge = '';
					if($row['tgl_pembelian'] != '0000-00-00')
					{
						$start = date('Y-m-d 00:00:00', strtotime($date_open));
						$closed = date('Y-m-d 00:00:00', strtotime($tgl_pembelian));
						$total = datediff($dateopen, $tglpembelian);

						$PurchaseAge = $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m';
					}

					$data[$key]['JobID']      	= $row['job_id'];
					$data[$key]['NoSPS']      	= $row['no_sps'];
					$data[$key]['NoSPS']     	 .= '<b><br> By : '.$row['nickname'].' - '.strtoupper($row['divisi']).'</b>';
					$data[$key]['Date']       	= date('d-m-Y H:i:s', strtotime($row['date_open']));
					$data[$key]['Customer']   	= $row['perusahaan'].'<br>'.$row['areaservis'];
					$data[$key]['Products']   	= $row['product_name'];
					//$data[$key]['SPSAge']   		= ($row['status'] == 101) ? $SPSAge : '<input type="hidden" class="date_start_time" value="'.date('Y/m/d H:i:s', strtotime($row['date_open'])).'">';
					$data[$key]['SPSAge']   		= $SPSAge;

					$data[$key]['Status']   		= $this->_getStatus($row);
					$data[$key]['PurchaseAge']  = $PurchaseAge;
					$data[$key]['Finish']   		= $this->_getFinish($row);
					$data[$key]['Schedule']   	= $row['schedule'];


					$act = '<li><a href="'.site_url('c_tablesps_admin/update/'.$row['id']).'"><i class="fa fa-file"></i> Detail</a></li>';

					if($row['time_login'] == '0000-00-00 00:00:00')
						$act = '<li><a href="'.site_url('c_tablesps_admin/savetime/'.$row['id']).'"><i class="fa fa-file"></i> Detail</a></li>';

					$data[$key]['Actions'] = '
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
							</button>
							<ul class="dropdown-menu pull-right">
								'.$act.'
							</ul>
						</div>';

						$data[$key]['StatusOri']   	= $row['status'];
						$data[$key]['SPSID']   			= $row['id'];
						$data[$key]['DateOpen']   			= date('Y/m/d H:i:s', strtotime($row['date_open']));


			}

      $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData"=> $data
      );

      echo json_encode($results);
  }

	private function _getFinish($args)
	{
			$row = $args;
			$now = date('Y-m-d');

			$str = '';
			if($_SESSION['myuser']['karyawan_id'] == 140 && $row['status'] != 101)
			{
				if($row['job_teknisi'] == 0)
				{
					$str = '<button class = "btn btn-default btn-sm sm fa fa-square-o fa-lg" data-status="'.$row['status'].'" id="'.$row['id'].'" onClick = "baseJs.job(this.id)" ></button>';
				}

				if($row['job_teknisi'] == 1)
				{
					$str = '<button class = "btn btn-default btn-sm sm fa fa-check-square-o fa-lg" data-status="'.$row['status'].'" id="'.$row['id'].'" onClick = "baseJs.job(this.id)" ></button>';
				}
			}
			elseif ($_SESSION['myuser']['karyawan_id'] != 140 && $row['status'] != 101)
			{
				if($row['status_teknisi'] == 2)
				{
						$str .= '<img src = "'.base_url('assets/images/finish.png').'" /><br>';
						$str .= '<p style="font-size: 10px;">By : '.$row['nick_tek'].' </p>';
				}
				elseif($row['job_teknisi'] == 1 || $row['execution'] == 1)
				{
					$str = '<img src = "'.base_url('assets/images/job_edit.png').'" />';
				}
				elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] > $now AND $row['execution'] == 0)
				{
					$str = '<span style="color:#0024AE;">'.date('d-m-Y', strtotime($row['schedule'])).'</span>';
				}
				elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] < $now AND $row['execution'] == 0)
				{
					$str = '<span style="color: #ff0000;">'.date('d-m-Y', strtotime($row['schedule'])).'</span>';
				}
				elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] == $now AND $row['execution'] == 0)
				{
					$str = '<span style="color: #218A25;">'.date('d-m-Y', strtotime($row['schedule'])).'</span>';
				}
				elseif($row['schedule'] == 0){
					$str = 'Queue';
				}
				else
				{
					$str = '';
				}
			}
			else
			{
				$str = '';
			}

			return $str;
		}

		private function _getStatus($args)
		{
				$row = $args;
				$str = '';

				if($row['jenis_pekerjaan'] == 1)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-danger">'.strtoupper($row['nama']).'</span>&nbsp<span class = "glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-danger label-servis">Servis</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-danger">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-danger label-servis">Servis</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Servis</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class = "fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 2)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-warning">'.strtoupper($row['nama']).'</span>&nbsp<span class = "glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-warning label-instalasi">Instalasi</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-warning">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-warning label-instalasi">Instalasi</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Instalasi</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class = "fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 3)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-primary">'.strtoupper($row['nama']).'</span>&nbsp<span class = "glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-primary label-survey">Survey</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-primary">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-primary label-survey">Survey</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Survey</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class = "fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 4)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-default">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-rekondisi">Rekondisi</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-default">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-rekondisi">Rekondisi</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Rekondisi</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 5)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-info label-green">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-maintenance">Maintenance</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-info label-green">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-maintenance">Maintenance</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Maintenance</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 6)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-info label-purple">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-training">Training</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-info label-purple">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-training">Training</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Training</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 7)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-info label-brown">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-perakitan">Perakitan</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-info label-brown">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-perakitan">Perakitan</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Perakitan</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 8)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-info label-bblue">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-persiapan">Persiapan Barang</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-info label-bblue">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-persiapan">Persiapan Barang</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Persiapan Barang</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				elseif($row['jenis_pekerjaan'] == 9)
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str .= '<span class="label label-info label-pink">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
										$str .= '<span class="label label-default label-kanibal">Kanibal</span>&nbsp';
								}
								else
								{
										$str .= '<span class="label label-info label-pink">'.strtoupper($row['nama']).'</span><br>';
										$str .= '<span class="label label-default label-kanibal">Kanibal</span>';
								}
						}
						else
						{
								$str .= '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
								$str .= '<span class="label label-success label-finish">Kanibal</span> &nbsp &nbsp';
								$str .= '<span class="label label-success label-border "><span class="fa fa-check"></span></span>';
 						}
				}
				else
				{
						if($row['status'] != 101)
						{
								if($row['pause'] == 1)
								{
										$str = '<span class="label label-danger">'.strtoupper($row['nama']).'</span>&nbsp<span class="glyphicon glyphicon-pause"></span><br>';
								}
								else
								{
										$str = '<span class="label label-danger">'.strtoupper($row['nama']).'</span>';
								}
						}
						else
						{
								$str = '<span class="label label-success">'.strtoupper($row['nama']).'</span><br>';
						}
				}


				return $str;


		}

}
