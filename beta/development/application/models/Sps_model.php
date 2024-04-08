<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sps_model extends CI_Model {

  public function get()
  {
      $sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan,
                a.id, a.no_sps, a.date_open, a.areaservis,
                a.status, a.job_teknisi, a.schedule,
                a.execution, b.nickname as nama,
                c.perusahaan, f.nickname, h.status as status_teknisi,
                i.nickname as nick_tek, a.free_servis,
                a.status_free, a.date_free, j.nickname as free_name,
                a.tgl_pembelian
              FROM tbl_sps as a
                LEFT JOIN tbl_loginuser as b
                  ON b.karyawan_id = a.status
                JOIN tbl_customer as c
                  ON c.id = a.customer_id
                LEFT JOIN tbl_loginuser as f
                  ON f.karyawan_id = a.sales_id
                JOIN tbl_sps_overto as g
                  ON g.sps_id = a.id
                LEFT JOIN tbl_point_teknisi as h
                  ON h.sps_id = a.id
                LEFT JOIN tbl_loginuser as i
                  ON i.karyawan_id = h.karyawan_id
                LEFT JOIN tbl_loginuser as j
                  ON j.karyawan_id = a.user_free
              WHERE a.jenis_pekerjaan != 8 AND a.status != 101
                GROUP BY a.id DESC";

        $query = $this->db->query($sql);

        $data = array(
          'rows' => $query->num_rows(),
          'results' => $query->result_array(),
        );

        return $data;
  }

  public function getData($cons = '')
  {
      $karyawanID = $_SESSION['myuser']['karyawan_id'];

      $sql_primary = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id,
  			a.no_sps, a.date_open, a.date_close, a.areaservis, a.status, a.job_teknisi,
  			a.schedule, a.execution, b.nickname as nama,
  			c.perusahaan, f.nickname, h.status as status_teknisi,
  			i.nickname as nick_tek, a.free_servis, a.status_free,
  			a.date_free, j.nickname as free_name, a.tgl_pembelian,
        prd_list.product_name, lg.time_login, spsl.pause
  			FROM tbl_sps as a
          LEFT JOIN (
            SELECT id_sps, MAX(pause) as pause
            FROM tbl_sps_log
            GROUP BY id_sps
          ) spsl ON spsl.id_sps = a.id
          LEFT JOIN tbl_sps_log as lg ON lg.id_sps = a.id
          LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status
  				JOIN  tbl_customer as c ON c.id = a.customer_id
  				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
  				JOIN tbl_sps_overto as g ON g.sps_id = a.id
  				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
  				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
  				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
          LEFT JOIN tbl_loginuser as k ON k.karyawan_id = lg.overto
          LEFT JOIN (
            SELECT sprd.sps_id,
            GROUP_CONCAT(pd.product SEPARATOR '@') as product_name
            FROM tbl_sps_product as sprd
            LEFT JOIN tbl_product as pd ON sprd.product_id = pd.id
            GROUP BY sprd.sps_id
          ) prd_list ON prd_list.sps_id = a.id";

    $sql_cons = " WHERE a.jenis_pekerjaan != 8 AND a.status != 101";

    if($cons == 8) {
			$sql_cons = " WHERE a.jenis_pekerjaan = 8 AND a.status != 101";
		}

    if($cons == 101) {
			$sql_cons = " WHERE a.status = 101";
		}

    $sql = '';

    if($_SESSION['myuser']['role_id'] == '1' OR $_SESSION['myuser']['role_id'] == '15'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
    }
    elseif($_SESSION['myuser']['role_id'] == '1' && $_SESSION['myuser']['cabang'] == 'Surabaya'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (g.overto = '$karyawanID' OR a.sales_id IN (
				SELECT a.id FROM tbl_karyawan a
				JOIN tbl_loginuser b ON b.karyawan_id = a.id
				WHERE a.cabang = 'Surabaya'))";
    }
    elseif ($_SESSION['myuser']['role_id'] == '1' && $_SESSION['myuser']['cabang'] == 'Medan') {
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (g.overto IN (
				SELECT a.id
				FROM tbl_karyawan a
				JOIN tbl_loginuser b ON b.karyawan_id = a.id
					WHERE a.cabang = 'Medan' AND b.role_id IN ('1', '4'))
						OR a.sales_id IN (
							SELECT a.id
							FROM tbl_karyawan a
							JOIN tbl_loginuser b ON b.karyawan_id = a.id
								WHERE a.cabang = 'Medan'
							)
						)";
    }
    elseif ($_SESSION['myuser']['role_id'] == '1' && $_SESSION['myuser']['cabang'] == 'Bandung') {
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (g.overto = '91' OR a.sales_id IN (
					SELECT a.id
					FROM tbl_karyawan a
					JOIN tbl_loginuser b ON b.karyawan_id = a.id
						WHERE a.cabang = 'Bandung'
				)
			)";
    }
    elseif($_SESSION['myuser']['position_id'] == '90'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dce' OR a.divisi = 'dgc')";
    }
    elseif($_SESSION['myuser']['position_id'] == '89'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dre') GROUP BY a.id DESC";
    }
    elseif($_SESSION['myuser']['position_id'] == '93'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dee') GROUP BY a.id DESC";
    }
    elseif($_SESSION['myuser']['position_id'] == '91'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhe') GROUP BY a.id DESC";
    }
    elseif(in_array($_SESSION['myuser']['position_id'], array('87', '88'))){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhc') GROUP BY a.id DESC";
    }
    elseif($_SESSION['myuser']['position_id'] == '92'){
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dgc') GROUP BY a.id DESC";
    }
    else{
      $sql .= $sql_primary;
      $sql .= $sql_cons;
      $sql .= " AND (a.sales_id =$karyawanID OR g.overto = $karyawanID) GROUP BY a.id DESC";
    }

    $sql .= " GROUP BY a.id DESC";

    $query	= $this->db->query($sql);
		$result	= $query->result_array();

    return $result;

  }

}
