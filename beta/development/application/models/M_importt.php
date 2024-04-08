<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_import extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('myuser');

  }

  public function getDataImport()
  {
      $sql = "SELECT a.id, a.sps_id, a.info, a.shipment,
      a.date_created, a.date_closed, a.ship_via, a.dept, a.arrival,
      a.kedatangan, a.status, a.notes, b.nickname
  		FROM tbl_import as a
      JOIN tbl_loginuser as b
      ON a.ship_to = b.karyawan_id
      ORDER BY a.date_created ASC";

  		$c_import = $this->db->query($sql)->result_array();

      return $c_import;
  }

  public function getStatus($status)
  {
      $str = '';

      switch ($status) {
        case 1:
            $str = '<span class= "label label-default">Production</span>';
          break;
        case 2:
            $str = '<span class= "label label-info">Ship by Sea</span>';
          break;
        case 3:
            $str = '<span class= "label label-purple">Custom Clearance</span>';
          break;
        case 4:
            $str = '<span class= "label label-primary">Customs Check</span>';
          break;
        case 5:
            $str = '<span class="label label-default " id = "sppb"> SPPB</span>';
          break;
        case 6:
            $str = '<span class = "label label-warning">Del. by Truck</span>';
          break;
        case 7:
            $str = '<span class = "label label-danger">Checked</span>';
          break;
        case 8:
            $str = '<span class = "label label-success">Finished</span>';
          break;
        default:
            $str = '<span class = "label label-default lb-air">Ship by Air</span>';
          break;
      }

      return $str;
  }

}
