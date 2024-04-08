<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_delivery extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('myuser');
    $this->load->model('Project_m', 'mpro');
    $this->load->model('Crm_model', 'mcrm');
    $this->load->model('Ftp_model', 'mftp');

    if(!isset($user) or empty($user))
    {
      redirect('c_loginuser');
    }
  }

  public function customer()
  {
    $sql = "SELECT id, id_customer, perusahaan FROM tbl_customer ORDER BY id DESC";
    $customer = $this->db->query($sql)->result_array();

    return $customer;
  }

  public function product()
  {
    $sql = "SELECT id, kode, product FROM tbl_product ORDER BY id DESC";
    $product = $this->db->query($sql)->result_array();

    return $product;
  }

  public function overto()
  {
    $sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a
            LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.id
            WHERE a.id NOT IN ('101', '123' '133', '109') AND a.published = '1' AND b.published = '1' ORDER BY a.nama ASC";
    $operator = $this->db->query($sql)->result_array();

    return $operator;
  }

    public function GetFileQc()
    {
      if($this->input->post()) {
        $div = $this->input->post('divisi');
        $sql = " SELECT file_name FROM tbl_upload_do
          WHERE status = 'Show' AND divisi = '$div' AND do_id = '0' ORDER BY file_name ASC";
        $query = $this->db->query($sql)->result_array();

        return $query;
      }
    }

    public function getDOfinished()
    {
      $sql = "SELECT do.id, no_so, perusahaan FROM tbl_do do 
              LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
              WHERE do.date_close >= DATE_ADD( NOW( ) , INTERVAL -6 MONTH )  AND do.status = 'Finished'";
      return $this->db->query($sql)->result_array();
    } 



    public function __do($term)
    {
        $position = strtolower($_SESSION['myuser']['position']);
        $position = substr($position, -3, 3);
        $cabang = $_SESSION['myuser']['cabang'];
        $role_id = $_SESSION['myuser']['role_id'];
        $pos_id = $_SESSION['myuser']['position_id'];
        $kar = $_SESSION['myuser']['karyawan_id'];



        $sql_primary = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id,
              do.tgl_estimasi, do.date_edit, do.category,
              do.pengiriman,do.transaksi, cs.perusahaan,
              do.status, do.status_date as date_created,
              lg.nickname as user_edit, lgn.nickname,
              lgp.nickname as user_pending,
              lgdo.nickname as sales, do.divisi,
              prd_list.product_name
            FROM tbl_do AS do
              LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
              LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
              LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
              LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
              LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
              LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
              LEFT JOIN (
                SELECT mpd.type_id,
                GROUP_CONCAT(pd.product SEPARATOR '@') as product_name
                FROM tbl_multi_product mpd
                LEFT JOIN tbl_product pd ON mpd.product_id = pd.id
                WHERE mpd.type = 2
                GROUP BY mpd.type_id
            ) prd_list ON prd_list.type_id = do.id";

        $sql_status = " WHERE do.status != 'Finished'";

        if($term == 'delivery_finished')
            $sql_status = " WHERE do.status = 'Finished'";

        $sql = '';

        if(in_array($pos_id, array('1', '2', '77', '14', '6', '8')) || $role_id == '15') {
            $sql .= $sql_primary;
            $sql .= $sql_status;
        }
        elseif(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '92', '93', '100'))) {
            $div = $position;

            $sql .= $sql_primary;
            $sql .= $sql_status;
            $sql .= " AND (do.divisi = '$div' OR ov.overto = '$kar' OR do.sales_id = '$kar')";
        }
        elseif(in_array($pos_id, array('55', '56', '57', '59')) || $role_id == '6') {
            $cbg = $cabang;

            $sql .= $sql_primary;
            $sql .= "LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
                     LEFT JOIN tbl_karyawan as kov ON kov.id = ov.overto";
            $sql .= $sql_status;
            $sql .= " AND (kar.cabang = '$cbg' OR ov.overto = '$kar' OR kov.cabang = '$cbg')";

        }
        elseif($role_id == '11' || in_array($pos_id, array('18', '19', '58', '82', '38'))) {
            $sql .= $sql_primary;
            $sql .= "LEFT JOIN tbl_karyawan as kr ON kr.id = ov.overto";
            $sql .= $sql_status;
            $sql .= " AND (kr.cabang LIKE '%Cikupa%' OR kr.cabang LIKE '%Jakarta%' OR kr.cabang LIKE '% %' OR kr.cabang like '%0%')";
        }
        else{
          $sql .= $sql_primary;
          $sql .= $sql_status;
          $sql .= " AND (ov.overto = '$kar' OR do.sales_id = '$kar')";
        }

        $sql .= " GROUP BY do.id DESC";

        $do = $this->db->query($sql)->result_array();

        return $do;

    }


  public function _do($term)
  {
    $position = strtolower($_SESSION['myuser']['position']);
    $position = substr($position, -3, 3);
    $cabang = $_SESSION['myuser']['cabang'];
    $role_id = $_SESSION['myuser']['role_id'];
    $pos_id = $_SESSION['myuser']['position_id'];
    $kar = $_SESSION['myuser']['karyawan_id'];
    //print_r($position);exit();

/*     if($term == 'delivery_finished')
    {
      $where = "do.status = 'Finished'";
    }elseif($term == 'delivery') {
      $where = "do.status != 'Finished'";
    } */

    if($term == 'delivery_finished')
    {
      $where = "do.status IN ('Finished', 'Return', 'Cancel')";
    }elseif($term == 'delivery') {
      $where = "do.status NOT IN ('Finished', 'Return', 'Cancel')";
    }

    if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '93', '100'))) {
      $div = $position;
      //print_r($div); exit();
      /* $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, cs.perusahaan, st.status, st.date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do_status as st
            LEFT JOIN tbl_do AS do ON st.do_id = do.id
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '0' AND (do.divisi = '$div' OR ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC "; */

      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE $where AND (do.divisi = '$div' OR ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC ";
    }elseif($pos_id == '90') {
      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE $where AND (do.divisi IN ('dce', 'dgc') OR ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC ";
    }elseif($pos_id == '91') {   
         $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE $where AND (do.divisi IN ('dhe', 'dwt') OR ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC ";
    }elseif(in_array($pos_id, array('55', '56', '57', '59'))) {
      $cbg = $cabang;
      /* $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, cs.perusahaan, st.status, st.date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do_status as st
            LEFT JOIN tbl_do AS do ON st.do_id = do.id
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '0' AND (kar.cabang = '$cbg' OR ov.overto = '$kar')
            GROUP BY do.id DESC "; */

       $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
            LEFT JOIN tbl_karyawan as kov ON kov.id = ov.overto
            WHERE $where AND (kar.cabang = '$cbg' OR ov.overto = '$kar' OR kov.cabang = '$cbg')
            GROUP BY do.id DESC ";

    }elseif($role_id == '11' OR in_array($pos_id, array('18', '19', '58', '82', '38'))) { //echo "aaa"; exit();
        /* $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, cs.perusahaan, st.status, st.date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do_status as st
            LEFT JOIN tbl_do AS do ON st.do_id = do.id
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            LEFT JOIN tbl_karyawan as kr ON kr.id = ov.overto
            WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '0' AND (kr.cabang LIKE '%Cikupa%' OR kr.cabang LIKE '%Jakarta%' OR kr.cabang LIKE '% %' OR kr.cabang like '%0%')
            GROUP BY do.id DESC"; */

        $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            LEFT JOIN tbl_karyawan as kr ON kr.id = ov.overto
            WHERE $where AND (kr.cabang LIKE '%Cikupa%' OR kr.cabang LIKE '%Jakarta%' OR kr.cabang LIKE '% %' OR kr.cabang like '%0%')
            GROUP BY do.id DESC ";
    }elseif(in_array($pos_id, array('1', '2', '77', '14', '6', '8')) OR $role_id == '15' OR $role_id == '6') {
      /* $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, cs.perusahaan, st.status, st.date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do_status as st
            LEFT JOIN tbl_do AS do ON st.do_id = do.id
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '0'
            GROUP BY do.id DESC "; */

      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE $where
            GROUP BY do.id DESC ";
    }else {
      /* $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, cs.perusahaan, st.status, st.date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do_status as st
            LEFT JOIN tbl_do AS do ON st.do_id = do.id
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '0' AND (ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC "; */

      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, do.pengiriman,do.transaksi, cs.perusahaan, do.status, do.status_date as date_created, lg.nickname as user_edit, lgn.nickname, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
            FROM tbl_do AS do
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id =  do.user_edit
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.status_user
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
            LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
            WHERE $where AND (ov.overto = '$kar' OR do.sales_id = '$kar')
            GROUP BY do.id DESC ";
    }
    $do = $this->db->query($sql)->result_array();

    foreach ($do as $index => $prd) {   // loop through those entries
    $prod = $this->load_product('2', $prd['id']); // call this model's `get_stats` method
    $do[$index]['type_id'] = $prod;      // add a `stats` key to the entry array
    }
    return $do;
  }

  public function _do_terjadwal()
  {
    $position = strtolower($_SESSION['myuser']['position']);
    $position = substr($position, -3, 3);
    $cabang = $_SESSION['myuser']['cabang'];
    $role_id = $_SESSION['myuser']['role_id'];
    $pos_id = $_SESSION['myuser']['position_id'];
    $kar = $_SESSION['myuser']['karyawan_id'];
    //print_r($position);exit();
    if(in_array($position, array('dre', 'dee', 'dhe', 'dgc', 'dce', 'dhc')) AND in_array($cabang, array('', '0', 'Jakarta'))) {
      $div = $position;

      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, st.status, st.date_created, cs.perusahaan, lgn.nickname, lg.nickname as user_edit, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
          FROM tbl_do_status as st
          LEFT JOIN tbl_do AS do ON st.do_id = do.id
          LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
          LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
          LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
          LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
          LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
          WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '1'  AND (do.divisi = '$div' OR ov.overto = '$kar' OR do.sales_id = '$kar')
          GROUP BY do.id DESC";

    }elseif($role_id == '1' AND in_array($cabang, array('Bandung', 'Surabaya', 'Medan'))) {
      $cbg = $cabang;

      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, st.status, st.date_created, cs.perusahaan, lgn.nickname, lg.nickname as user_edit, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
          FROM tbl_do_status as st
          LEFT JOIN tbl_do AS do ON st.do_id = do.id
          LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
          LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
          LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
          LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
          LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
          LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
          WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '1'  AND (kar.cabang = '$cbg' OR ov.overto = '$kar')
          GROUP BY do.id DESC";

    }elseif(in_array($pos_id, array('18', '19', '58', '82')) OR $role_id == '11') {
        $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, st.status, st.date_created, cs.perusahaan, lgn.nickname, lg.nickname as user_edit, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
          FROM tbl_do_status as st
          LEFT JOIN tbl_do AS do ON st.do_id = do.id
          LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
          LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
          LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
          LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
          LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
          LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
          LEFT JOIN tbl_karyawan as kr ON kr.id = ov.overto
          WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '1' AND (kr.cabang LIKE '%Cikupa%' OR kr.cabang LIKE '%Jakarta%' OR kr.cabang LIKE '% %' OR kr.cabang like '%0%')
          GROUP BY do.id DESC";
    }elseif(in_array($pos_id, array('1', '2', '77', '14', '6'))) {
      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, st.status, st.date_created, cs.perusahaan, lgn.nickname, lg.nickname as user_edit, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
        FROM tbl_do_status as st
        LEFT JOIN tbl_do AS do ON st.do_id = do.id
        LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
        LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
        LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
        LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
        LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
        WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '1'
        GROUP BY do.id DESC";
    }else {
      $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.date_edit, do.category, st.status, st.date_created, cs.perusahaan, lgn.nickname, lg.nickname as user_edit, lgp.nickname as user_pending, lgdo.nickname as sales, do.divisi
        FROM tbl_do_status as st
        LEFT JOIN tbl_do AS do ON st.do_id = do.id
        LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
        LEFT JOIN tbl_multi_overto as ov ON (ov.type_id = do.id AND ov.type = '2')
        LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = st.user_id
        LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
        LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = do.user_pending
        LEFT JOIN tbl_loginuser as lgdo ON lgdo.karyawan_id = do.sales_id
        WHERE st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id) AND do.category = '1' AND (ov.overto = '$kar' OR do.sales_id = '$kar')
        GROUP BY do.id DESC";
    }

    $do_jdwl = $this->db->query($sql)->result_array();

    foreach ($do_jdwl as $index => $pd) {   // loop through those entries
      $prod = $this->load_product('2', $pd['id']); // call this model's `get_stats` method
      $do_jdwl[$index]['type_id'] = $prod;
    }
    return $do_jdwl;
  }

  public function load_product($type, $id)
  {
    $sql = "SELECT mpd.*, pd.product FROM tbl_multi_product as mpd
            LEFT JOIN tbl_product as pd ON pd.id = mpd.product_id
            WHERE type = '$type' AND type_id = '$id'";
    $load_prd = $this->db->query($sql)->result_array();

    return $load_prd;
  }

  public function descriptions($id)
  {
    $sql = "SELECT do.id, do.no_so, do.date_open, do.date_close, do.customer_id, do.tgl_estimasi, do.user_edit, do.date_edit, do.pengiriman, do.transaksi, do.status, cs.perusahaan, cs.alamat, cs.pic, cs.telepon, cs.tlp_hp, do.item_transfer, do.do_notes, do.divisi, do.sales_id, do.do_status, do.lvl_approval, do.approval, ncs.pic as npic, ncs.alamat as nalamat, ncs.telepon as ntelepon, rp.do_id, rp.replacement_id
            FROM tbl_do as do
            LEFT JOIN tbl_do_status AS st ON st.do_id = do.id
            LEFT JOIN tbl_do_replacement as rp ON (rp.do_id = do.id OR rp.replacement_id = do.id)
            LEFT JOIN tbl_customer as cs ON cs.id = do.customer_id
            LEFT JOIN tbl_non_customer as ncs ON (ncs.modul_type_id = do.id AND ncs.modul_type = '2')
            WHERE do.id = '$id' AND st.id IN (SELECT MAX(id) FROM tbl_do_status GROUP BY do_id)";
    $descriptions = $this->db->query($sql)->row_array();

    return $descriptions;
  }

  public function link_modul($id)
  {
      /* $sql = "SELECT li.link_from_id, li.link_from_modul as link_modul FROM tbl_link li
        LEFT JOIN tbl_do do ON (do.id = li.link_to_id AND li.link_to_modul = '2')
        WHERE li.link_to_id = $id AND li.link_to_modul = '2'"; */

        $sql = "SELECT li.*, lm.nama_modul FROM tbl_link li
          LEFT JOIN tbl_log_modul lm ON lm.id = li.link_from_modul
          WHERE li.link_to_modul = '2' AND li.link_to_id = '$id'";
       $res = $this->db->query($sql)->row_array(); 

    return $res;
  }

  public function do_log($id)
  {
    $sql = "SELECT dolog.id, dolog.do_id, dolog.id_operator, dolog.overto, dolog.date_created, dolog.time_login, dolog.time_nextto, dolog.time_idle, kr.nama, kr.cabang, pos.position, lg.role_id, do.do_status, do.lvl_approval, do.approval, dkr.cabang FROM tbl_do_log as dolog
            LEFT JOIN tbl_karyawan as kr ON kr.id = dolog.id_operator
            LEFT JOIN tbl_position as pos ON pos.id = kr.position_id
            LEFT JOIN tbl_loginuser as lg ON (lg.karyawan_id = kr.id AND lg.published = '1')
            LEFT JOIN tbl_do AS do ON do.id = dolog.do_id
            LEFT JOIN tbl_karyawan as dkr ON dkr.id = do.sales_id
            WHERE dolog.do_id = '$id' ORDER BY dolog.id ASC";
    $query = $this->db->query($sql);
    $do_log = $query->result_array();
    $do_numrow = $query->num_rows();

    $sql = "SELECT status FROM tbl_do_status WHERE do_id = '$id' ORDER BY id DESC LIMIT 1";
    $do_status = $this->db->query($sql)->row_array();

    $arr_do_log = array(
      'do_log'    => $do_log,
      'do_numrow' => $do_numrow,
      'do_status' => $do_status,
      );

    return $arr_do_log;
  }

  public function do_pesan($id, $do_log_id)
  {
    $sql = "SELECT psn.id, psn.type_id, psn.log_type_id, psn.pesan, psn.date_created, lg.nickname FROM tbl_multi_pesan as psn
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = psn.sender_id
            WHERE type = '2' AND type_id = '$id' AND log_type_id = '$do_log_id' GROUP BY psn.id ORDER BY psn.date_created ASC";
    $pesan = $this->db->query($sql)->result_array();

    return $pesan;
  }

  public function do_files($do_id)
  {
    $sql = "SELECT * FROM tbl_upload_do as updo
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = updo.uploader
            WHERE updo.do_id = '$do_id' AND updo.type = '0' GROUP BY updo.id ASC ";
    $files = $this->db->query($sql)->result_array();

    return $files;
  }

  public function countstatusfiles($do_id)
  {
    $sql = "SELECT updo.id FROM tbl_upload_do as updo
            WHERE updo.do_id = '$do_id' AND (updo.type = '3' OR updo.type = '4') GROUP BY updo.type ASC";
    $files = $this->db->query($sql)->num_rows();

    return $files;
  }

   public function statusfiles($do_id)
    {
      $dolog = $this->do_log($do_id);

      $dolog = $dolog['do_log'][0]['do_status'];
      $sql = "SELECT * FROM tbl_upload_do as updo
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = updo.uploader
              WHERE updo.do_id = '$do_id' ";

      switch ($dolog) {
        case 'Cancel':
          $sql .= "AND updo.type = '3' ";
          break;
        
        case 'Return':
           $sql .= "AND updo.type = '4' ";
          break;

        case 'Replacement':
            $sql .= "AND updo.type = '5'";
          break;    
      }
      
      $sql .= "GROUP BY updo.id ASC";

      $files = $this->db->query($sql)->result_array();

      return $files;
    }

  public function savetime($id){
    $karyawanID = $_SESSION['myuser']['karyawan_id'];
    $time = date('Y-m-d H:i:s');

    $sql = "SELECT id FROM tbl_do_log WHERE do_id = '$id' AND overto = '$karyawanID' AND time_login = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
    $query = $this->db->query($sql)->row_array();
    $child = $query['id'];

    if($query){
      $sql2 = "UPDATE tbl_do_log SET time_login = '$time', time_idle = '$time' WHERE id = '$child'";
      $que = $this->db->query($sql2);
    }
  }

  public function timer($do_id, $log_do_id)
  {
    //$sql = "SELECT id FROM tbl_do_log WHERE do_id = '$do_id' ORDER BY id DESC LIMIT 1";
    //$query = $this->db->query($sql)->row_array();
    //$log_do_id = $query['id'];

    $sql = "SELECT id, time_idle, time_login, time_nextto, id_operator FROM tbl_do_log
            WHERE do_id = '$do_id' AND id = '$log_do_id'";
    $idle = $this->db->query($sql)->row_array();

    return $idle;
  }

  public function total_time($do_id)
  {
     $sql = "SELECT do.date_close, do.date_open, max(log.date_created) as end_date, min(log.date_created) as start_date
            FROM tbl_do_log as log
            LEFT JOIN tbl_do as do ON do.id = log.do_id
            WHERE log.do_id = '$do_id'";
    $query = $this->db->query($sql);
    $respon = $query->row_array();

    return $respon;
  }

  public function getKetentuan($id = '')
  {
    $sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan
        LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id
        WHERE tbl_ketentuan.nama_modul = '2'
        ORDER BY tbl_ketentuan.id DESC LIMIT 1";
      return $this->db->query($sql)->row_array();
  }

   public function checkReplacement($do_id)
  {
    $sql = "SELECT id FROM tbl_do_replacement WHERE do_id = '$do_id' OR replacement_id = '$do_id'";
    return $this->db->query($sql)->row_array();
    
  } 

  public function changeStatus()
  {
      $do_id = $this->input->post('id');
      $status = $this->input->post('status');
      $user_id = $_SESSION['myuser']['karyawan_id'];

      if($this->input->post()){
        $insert = array(
          'do_id'   => $do_id,
          'status'  => $status,
          'user_id' => $user_id,
          'date_created' => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_do_status', $insert);
        $addsts = $this->db->insert_id();

        $update = array(
          'status' => $status,
          'status_date' => date('Y-m-d H:i:s'),
          'status_user' => $user_id,
          );
        $this->db->where('id', $do_id);
        $this->db->update('tbl_do', $update);

        $this->logAll($do_id, $desc = '1', $addsts, $ket='tbl_do_status');
      }

    $sql = "SELECT st.status, st.date_created, lg.nickname, lgn.nickname as user_pending FROM tbl_do_status as st
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = st.user_id
            LEFT JOIN tbl_do as do ON do.id = st.do_id
            LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = do.user_pending
            WHERE st.do_id = '$do_id' ORDER BY st.id DESC LIMIT 1";
    $change = $this->db->query($sql)->row_array();
    $change = array(
      'status' => $change['status'],
      'date_created' => date('d-m-Y H:i:s', strtotime($change['date_created'])),
      'nickname'  => $change['nickname'],
      'user_pending'  => $change['user_pending']
      );
    return $change;
  }

  public function delivDate()
  {
    $do_id = $this->input->post('do_id');
    $tgl_kirim = $this->input->post('tgl_kirim');
    $tgl_kirim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_kirim);
    $category = $this->input->post('category');
    $user = $_SESSION['myuser']['karyawan_id'];

    $sql = "SELECT dl.id, re.days_reminder FROM tbl_do_log dl
            LEFT JOIN tbl_reminder re ON dl.do_id = re.do_id
            WHERE dl.do_id = '$do_id' ORDER BY dl.id DESC LIMIT 1";
    $row_log = $this->db->query($sql)->row_array();
    $log_do = $row_log['id'];
    $days_reminder  = $row_log['days_reminder'];

      if($this->input->post())
      {
        if($category == '0')
        {

         $ket = $this->input->post('tgl_txa');
          $ket_pesan = array(
            'type'          => '2',
            'type_id'       => $do_id,
            'log_type_id'   => $log_do,
            'sender_id'     => $user,
            'pesan'         => $ket,
            'date_created'  => date('Y-m-d H:i:s'),
            );
          $this->db->insert('tbl_multi_pesan', $ket_pesan);

          $changeDate = array(
          'tgl_estimasi'  => $tgl_kirim,
          'user_edit'     => $user,
          'date_edit'     => date('Y-m-d H:i:s'),
          'category'      => $category,
          );
          $this->db->where('id', $do_id);
          $this->db->update('tbl_do', $changeDate);

          if(!empty($days_reminder)) {
            $days_reminder = "+".$days_reminder."days";
            $new_reminder = date('Y-m-d', strtotime($days_reminder, strtotime($tgl_kirim)));
            $upreminder = array('date_reminder' => $new_reminder);
            $this->db->where('do_id', $do_id);
            $this->db->update('tbl_reminder', $upreminder);
          }

          $this->logAll($do_id, $desc = '3', $do_id, $tgl_kirim);

        }elseif($category == '1') {

          $changeDate = array(
          'tgl_estimasi'  => $tgl_kirim,
          'user_edit'     => $user,
          'date_edit'     => date('Y-m-d H:i:s'),
          'category'      => $category,
          );
          $this->db->where('id', $do_id);
          $this->db->update('tbl_do', $changeDate);

          if(!empty($days_reminder)) {
            $days_reminder = "+".$days_reminder."days";
            $new_reminder = date('Y-m-d', strtotime($days_reminder, strtotime($tgl_kirim)));
            $upreminder = array('date_reminder' => $new_reminder);
            $this->db->where('do_id', $do_id);
            $this->db->update('tbl_reminder', $upreminder);
          }

          $this->logAll($do_id, $desc_id = '3', $do_id, $tgl_kirim);
        }
      }

    $sql = "SELECT do.date_edit, do.tgl_estimasi, lg.nickname, do.category FROM tbl_do as do
            LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = do.user_edit
            WHERE do.id = '$do_id'";
    $date = $this->db->query($sql)->row_array();
    $date = array(
      'date_edit'     => date('d-m-Y H:i:s', strtotime($date['date_edit'])),
      'tgl_estimasi'  => date('d-m-Y', strtotime($date['tgl_estimasi'])),
      'nickname'      => $date['nickname'],
      'kategori'      => $date['category'],
      );

    return $date;
  }

  public function takeOver($id)
  {
    $sql = "SELECT * FROM tbl_do_log WHERE do_id = '$id' ORDER BY id DESC LIMIT 2";
    $res = $this->db->query($sql)->result_array();

    $iddown = $res[0]['id'];
    $idup = $res[1]['id'];
    $user = $_SESSION['myuser']['karyawan_id'];

    if($res[1]['time_login'] != '0000-00-00 00:00:00') {
     //update time_nextto iddown kemudian insert
      $upnext = array(
        'overto'      => $user,
        'time_nextto' => date('Y-m-d H:i:s'),
        );
      $this->db->where('id', $iddown);
      $this->db->update('tbl_do_log', $upnext);

      $insert = array(
        'do_id'         => $id,
        'id_operator'   => $user,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_log', $insert);

    }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {
     // update time_login dan idle idup kemudian update timelogin, time nextto, idle iddown kemudian insert
      $uplogin = array(
        'time_login'  => date('Y-m-d H:i:s'),
        'time_idle'   => date('Y-m-d H:i:s'),
        );
      $this->db->where('id', $idup);
      $this->db->update('tbl_do_log', $uplogin);

      $upnext2 = array(
        'overto'      => $user,
        'time_nextto' => date('Y-m-d H:i:s'),
        );
      $this->db->where('id', $iddown);
      $this->db->update('tbl_do_log', $upnext2);

      $newrow = array(
        'do_id'         => $id,
        'id_operator'   => $user,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_log', $newrow);
    }

    $up_do = array(
      'user_pending' => $user,
      );
    $this->db->where('id', $id);
    $this->db->update('tbl_do', $up_do);

    $pesan = array(
        'type'        => '2',
        'type_id'     => $id,
        'log_type_id' => $iddown,
        'sender_id'   => $user,
        'pesan'       => '*** TAKE OVER ***',
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_multi_pesan', $pesan);
      $id_pesan = $this->db->insert_id();

      $this->notification($id, $id_pesan, $notif = '2');

      $this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');

  }

  public function add()
  {
    if($this->input->post())
    {
      $sales_id     = $this->input->post('sales_id');
      $divisi       = $this->input->post('divisi');
      $no_so1       = $this->input->post('no_so1');
      $no_so2       = $this->input->post('no_so2');
      $no_so3       = $this->input->post('no_so3');
      $it1          = $this->input->post('it1');
      $it2          = $this->input->post('it2');
      $it3          = $this->input->post('it3');
      $date_created = $this->input->post('date_created');
      $customer_id  = $this->input->post('customer_id');
      $pic          = $this->input->post('pic');
      $tlp          = $this->input->post('telepon');
      $alamat       = $this->input->post('alamat');
      $alamat       = str_replace("'", "''", $alamat);
      $product      = $this->input->post('product');
      $catatan      = $this->input->post('notes');
      $upload       = $this->input->post('userfile');
      $overto       = $this->input->post('overto');
      $overto_type  = $this->input->post('overtotype');
      $message      = $this->input->post('message');
      $jenis        = $this->input->post('jenis');
      $tgl_estimasi = $this->input->post('tgl_estimasi');
      $tgl_estimasi = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_estimasi);
      $no_memo      = $this->input->post('no_memo');
      $pengiriman     = $this->input->post('pengiriman');
      $ekspedisi     = $this->input->post('ekspedisi');
      $transaksi     = $this->input->post('transaksi');
      $transaksi   = str_replace(".", "", $transaksi);
      $replacement_id  = $this->input->post('replacement_id');


      if($it1 AND $it2 AND $it3)
      {
        $it = "IT".$it1."/".$it2."/".$it3;
      }else {
        $it = "-";
      }

      if($no_so1) {
        $no = "SO".$no_so1."/".$no_so2."/".$no_so3;
      }elseif($no_memo) {
        $no = $no_memo;
      }

       if($pengiriman=='ekspedisi'){
        $pengiriman= "Ekspedisi ".$ekspedisi;
      }else {
        $pengiriman;
      }

      $delivery = array(
        'no_so'         => $no,
        'item_transfer' => $it,
        'divisi'        => $divisi,
        'sales_id'      => $sales_id,
        'date_open'     => date('Y-m-d H:i:s'),
        'customer_id'   => $customer_id,
        'tgl_estimasi'  => $tgl_estimasi,
        'do_notes'      => $catatan,
        'user_pending'  => $overto,
        'status'        => 'Waiting',
        'pengiriman'    => $pengiriman,
        'transaksi'    => $transaksi,
      );
      $this->db->insert('tbl_do', $delivery);
      $type_id = $this->db->insert_id();

      if($this->input->post('gmap')) {
        $file_upload = array(
            'do_id'         => $type_id,
            'file_name'     => $this->input->post('gmap'),
            'uploader'      => $_SESSION['myuser']['karyawan_id'],
            'date_created'  => date('Y-m-d H:i:s'),
            'type'          => '2',

          );
          $this->db->insert('tbl_upload_do', $file_upload);
      }

      $do_log1 = array(
        'do_id'         => $type_id,
        'id_operator'   => $sales_id,
        'overto'        => $overto,
        'date_created'  => date('Y-m-d H:i:s'),
        'time_nextto'   => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_log', $do_log1);
      $do_log_id1 = $this->db->insert_id();

       $do_log2 = array(
        'do_id'         => $type_id,
        'id_operator'   => $overto,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_log', $do_log2);
      $do_log_id2 = $this->db->insert_id();

      $status = array(
        'do_id'   => $type_id,
        'status'  => 'Waiting',
        'user_id' => $sales_id,
        'date_created' => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_status', $status);

      $pesan = array(
        'type'          => '2',
        'type_id'       => $type_id,
        'log_type_id'   => $do_log_id2,
        'sender_id'     => $sales_id,
        'pesan'         => $message,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_multi_pesan', $pesan);

      if($replacement_id) {

        $args = array(
          'user_id'         => $_SESSION['myuser']['karyawan_id'],
          'do_id'           => $type_id,
          'replacement_id'  => $replacement_id,
          'date_created'    => date('Y-m-d H:i:s'), 
        );
        $this->db->insert('tbl_do_replacement', $args);
        $rep_id = $this->db->insert_id();

        $this->db->where('id', $type_id);
        $this->db->update('tbl_do', array('doreplace_id' => $rep_id, 'lvl_approval' => 'Kadiv', 'approval' => '1'));

        $this->db->where('id', $replacement_id);
        $this->db->update('tbl_do', array('lvl_approval' => 'Kadiv', 'approval' => '1'));


        $this->updateDO($replacement_id, 'Replacement');
        $this->updateDO($type_id, 'Replacement');

        $sql = "SELECT id FROM tbl_do_log WHERE do_id = '$replacement_id' GROUP BY id DESC LIMIT 1";
        $replacement_log = $this->db->query($sql)->row_array();
        //add pesan ke id lama
        $pesan = array(
          'type'          => '2',
          'type_id'       => $replacement_id,
          'log_type_id'   => $replacement_log['id'],
          'sender_id'     => $sales_id,
          'pesan'         => 'Membuat Replacement (Tukar) terhadap <a target="_blank" href="'.site_url('C_delivery/details/'.$type_id).'"> Delivery ID '.$type_id.'</a>',
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_multi_pesan', $pesan);

        // add pesan ke id baru
        $pesan = array(
          'type'          => '2',
          'type_id'       => $type_id,
          'log_type_id'   => $do_log_id1,
          'sender_id'     => $sales_id,
          'pesan'         => 'Membuat Replacement (Tukar) terhadap <a target="_blank" href="'.site_url('C_delivery/details/'.$replacement_id).'"> Delivery  ID '.$replacement_id.'</a>',
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_multi_pesan', $pesan);  

        $this->session->unset_userdata('sess_do_replacement');
      }

      if($this->input->post('form_type') == 'delv') {
        if($this->input->post('modul') == '8') {
          $crm_id = $this->input->post('sess_id');
          $link_crm = site_url('C_crm/details/'.$crm_id);
          $link_del = site_url('C_delivery/details/'.$type_id);

          //$this->db->where('id', $crm_id);
          //$this->db->update('tbl_crm', array('link_modul_id' => $type_id, 'link_modul' => '2'));

          //$this->db->where('id', $type_id);
          //$this->db->update('tbl_do', array('link_modul_id' => $crm_id, 'link_modul' => '8'));

          $inslink = array(
            'link_from_modul' => '8',
            'link_from_id'    => $crm_id,
            'link_to_modul'   => '2',
            'link_to_id'      => $type_id,
            'user'            => $_SESSION['myuser']['karyawan_id'],
            'date_created'    => date('Y-m-d H:i:s'),
          );
          $this->db->insert('tbl_link', $inslink);

          $pesan = array(
            'type'          => '2',
            'type_id'       => $type_id,
            'log_type_id'   => $do_log_id1,
            'sender_id'     => $_SESSION['myuser']['karyawan_id'],
            'pesan'         => 'Membuat delivery dari deal <a target="_blank" href="'.$link_crm.'"> CRM ID '.$crm_id.'</a>',
            'date_created'  => date('Y-m-d H:i:s'),
            );
          $this->db->insert('tbl_multi_pesan', $pesan);

          $log = array(
            'crm_id'        => $crm_id,
            'date_created'  => date('Y-m-d H:i:s'),
            'crm_type'      => 'Pesan',
            'user_id'       => $_SESSION['myuser']['karyawan_id'],
          );
          $this->db->insert('tbl_crm_log', $log);
          $log_id = $this->db->insert_id();

          $pesan = array(
            'crm_id'        => $crm_id,
            'log_crm_id'    => $log_id,
            'sender'        => $_SESSION['myuser']['karyawan_id'],
            'pesan'         => 'Melanjutkan stage Deal ke stage Delivery barang dengan <a target="_blank" href="'.$link_del.'"> Delivery ID '.$type_id.'</a>',
            'date_created'  => date('Y-m-d H:i:s'),        
          );
          $this->db->insert('tbl_crm_pesan', $pesan);
          $psn_id = $this->db->insert_id();

          $this->db->where('id', $log_id);
          $this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

          $this->mcrm->setStatusLinkCRM('2', $type_id, $crm_id, 'Delivery');

          $this->session->unset_userdata('sess_crm_id');
        

        }elseif($this->input->post('modul') == '9') {
          
          $project_id = $this->input->post('sess_id');
          $link_project = site_url('Project/details/'.$project_id);
          $link_del = site_url('C_delivery/details/'.$type_id);

          $inslink = array(
            'link_from_modul' => '9',
            'link_from_id'    => $project_id,
            'link_to_modul'   => '2',
            'link_to_id'      => $type_id,
            'user'            => $_SESSION['myuser']['karyawan_id'],
            'date_created'    => date('Y-m-d H:i:s'),
          );
          $this->db->insert('tbl_link', $inslink);
          $link_id = $this->db->insert_id();

          $pesan = array(
            'type'          => '2',
            'type_id'       => $type_id,
            'log_type_id'   => $do_log_id1,
            'sender_id'     => $_SESSION['myuser']['karyawan_id'],
            'pesan'         => 'Membuat delivery dari <a target="_blank" href="'.$link_project.'"> Project ID '.$project_id.'</a>',
            'date_created'  => date('Y-m-d H:i:s'),
            );
          $this->db->insert('tbl_multi_pesan', $pesan);

          $pesan = 'Melanjutkan ke stage Delivery barang dengan <a target="_blank" href="'.$link_del.'"> Delivery ID '.$type_id.'</a>';
          $this->mpro->logProject($project_id, 'Link', $link_id, $pesan);

          $this->session->unset_userdata('sess_project_id');
        }
      }

      $overto_ = array(
        'type'          => '2',
        'type_id'       => $type_id,
        'user_id'       => $sales_id,
        'overto'        => $overto,
        'overto_type'   => $overto_type,
        'date_created'  => date('Y-m-d H:i:s'),
      );
      $this->db->insert('tbl_multi_overto', $overto_);
      $overto_id = $this->db->insert_id();

      $overto_notif = array(
        'modul'         => '2',
        'modul_id'      => $type_id,
        'record_id'     => $overto_id,
        'record_type'   => '1',
        'user_id'       => $overto,
        'status'        => '0',
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_notification', $overto_notif);


      if($customer_id == '1563' OR $customer_id == '7773' ){
        $non_cus = array(
          'modul_type'    => '2',
          'modul_type_id' => $type_id,
          'pic'           => $pic,
          'telepon'       => $tlp,
          'alamat'        => $alamat,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_non_customer', $non_cus);

      }else{
        $sql = "UPDATE tbl_customer SET pic = '$pic', telepon = '$tlp', alamat = '$alamat' WHERE id = '$customer_id'";
        $this->db->query($sql);

      }

      if($this->input->post('email_cust') && $this->input->post('jangka_wkt')) {
        $jgk_wkt = $this->input->post('jangka_wkt');
        $date_wkt = "+".$jgk_wkt."days";

        $date_reminder = date('Y-m-d', strtotime($date_wkt, strtotime($tgl_estimasi)));
        $array = array(
          'do_id'         => $type_id,
          'divisi'        => $divisi,
          'date_created'  => date('Y-m-d H:i:s'),
          'cust_email'    => $this->input->post('email_cust'),
          'days_reminder' => $this->input->post('jangka_wkt'),
          'date_reminder' => $date_reminder,
          );
        $this->db->insert('tbl_reminder', $array);
      }

      foreach ($product as $prd) {
        $this->multi_product($prd, $type_id);
      }

      if($this->input->post('qcfile'))
      {
        $fileqc = $this->input->post('qcfile');
        foreach ($fileqc as $qc) {
         $file_upload = array(
          'do_id'         => $type_id,
          'file_name'     => $qc,
          'uploader'      => $_SESSION['myuser']['karyawan_id'],
          'date_created'  => date('Y-m-d H:i:s'),
          'type'          => '0',
        );
        $this->db->insert('tbl_upload_do', $file_upload);
        }
      }

      $this->uploadfile($type_id, $jenis, '0');

      $this->logAll($type_id, $desc = '1', $type_id, $ket = 'tbl_do');
      $this->logAll($type_id, $desc = '1', $type_id, $tgl_estimasi);

      return $type_id;

    }
  }

  public function multi_product($prd, $type_id)
  {
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbl_multi_product (type, type_id, product_id, date_created) VALUES ('2', '$type_id', '$prd', '$date')";
    $this->db->query($sql);
  }

  public function nextTo()
  {
    if($this->input->post())
    {
      $karyawanID   = $this->input->post('karyawan');
      $message      = $this->input->post('message');
      $do_id        = $this->input->post('do_id');
      $overto_type  = $this->input->post('overto_type');
      $user_id      = $_SESSION['myuser']['karyawan_id'];

      $updatedo = array(
        'user_pending'  => $karyawanID,
        );
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', $updatedo);

      $simpan_overto = array(
        'type'  => '2',
        'type_id' => $do_id,
        'user_id' => $user_id,
        'overto' => $karyawanID,
        'overto_type' => $overto_type,
        'date_created'  => date('Y-m-d H:i:s'),
      );
      $this->db->insert('tbl_multi_overto', $simpan_overto);
      $overto_id = $this->db->insert_id();
      $this->logAll($do_id, $desc='1', $overto_id, $ket='tbl_multi_overto');

      $overto_notif = array(
        'modul'         => '2',
        'modul_id'      => $do_id,
        'record_id'     => $overto_id,
        'record_type'   => '1',
        'user_id'       => $karyawanID,
        'status'        => '0',
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_notification', $overto_notif);

      $this->uploadfile($do_id, $jenis = 'details', '0');

      $sql = "SELECT id, time_login, time_nextto, time_idle, id_operator, overto
              FROM tbl_do_log
              WHERE do_id = '$do_id'
              ORDER BY id DESC LIMIT 1";
      $result = $this->db->query($sql)->row_array();

      $log_do = array(
        'overto'      => $karyawanID,
        'time_nextto' => date('Y-m-d H:i:s'),
      );
      $this->db->where('id', $result['id']);
      $this->db->update('tbl_do_log', $log_do);

      $newlog = array(
        'do_id'       => $do_id,
        'id_operator' => $karyawanID,
        'date_created'  => date('Y-m-d H:i:s'),
      );
      $this->db->insert('tbl_do_log', $newlog);
      $logid = $this->db->insert_id();
      $this->logAll($do_id, $desc='1', $logid, $ket='tbl_do_log');

      $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$karyawanID'";
      $result = $this->db->query($sql)->row_array();
      $nickname = $result['nickname'];

      if($message == '') {
        $pesan = array(
          'type'          => '2',
          'type_id'       => $do_id,
          'log_type_id'   => $logid,
          'sender_id'     => $user_id,
          'pesan'         =>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar cepat selesai.',
          'date_created'  => date('Y-m-d H:i:s'),
          );
      }else {
        $pesan = array(
          'type'          => '2',
          'type_id'       => $do_id,
          'log_type_id'   => $logid,
          'sender_id'     => $user_id,
          'pesan'         => $message,
          'date_created'  => date('Y-m-d H:i:s'),
          );
      }
      $this->db->insert('tbl_multi_pesan', $pesan);
      $pesanid = $this->db->insert_id();

      $this->notification($do_id, $pesanid, $notif='2');
      $this->logAll($do_id, $desc='1', $pesanid, $ket='tbl_multi_pesan');
    }
  }

  public function do_finished($id, $dostatus)
  {
    $sql = "SELECT id, id_operator, time_login FROM tbl_do_log WHERE do_id = '$id' ORDER BY id DESC LIMIT 2";
    $res = $this->db->query($sql)->result_array();

    $iddown = $res[0]['id'];
    $idup = $res[1]['id'];
    $user = $_SESSION['myuser']['karyawan_id'];

    if($_SESSION['myuser']['karyawan_id'] == $res[0]['id_operator']) {
      //update overto karyawan_id time login, idle, nextto.
      $uplog = array(
        'overto'      => $user,
        'time_login'  => date('Y-m-d H:i:s'),
        'time_nextto' => date('Y-m-d H:i:s'),
        'time_idle'   => date('Y-m-d H:i:s'),
        );
      $this->db->where('id', $iddown);
      $this->db->update('tbl_do_log', $uplog);

    }elseif ($_SESSION['myuser']['karyawan_id'] != $res[0]['id_operator']) {

      if($res[1]['time_login'] != '0000-00-00 00:00:00') {
        $upnext = array(
          'overto'      => $user,
          'time_nextto' => date('Y-m-d H:i:s'),
          );
        $this->db->where('id', $iddown);
        $this->db->update('tbl_do_log', $upnext);

        $insert = array(
          'do_id'         => $id,
          'id_operator'   => $user,
          'date_created'  => date('Y-m-d H:i:s'),
          'time_login'    => date('Y-m-d H:i:s'),
          'time_nextto'   => date('Y-m-d H:i:s'),
          'time_idle'     => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_do_log', $insert);
        $iddown = $this->db->insert_id();

      }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {

        $uplogin = array(
          'time_login'  => date('Y-m-d H:i:s'),
          'time_idle'   => date('Y-m-d H:i:s'),
          );
        $this->db->where('id', $idup);
        $this->db->update('tbl_do_log', $uplogin);

        $upnext2 = array(
          'overto'      => $user,
          'time_nextto' => date('Y-m-d H:i:s'),
          );
        $this->db->where('id', $iddown);
        $this->db->update('tbl_do_log', $upnext2);

        $newrow = array(
          'do_id'         => $id,
          'id_operator'   => $user,
          'date_created'  => date('Y-m-d H:i:s'),
          'time_login'    => date('Y-m-d H:i:s'),
          'time_nextto'   => date('Y-m-d H:i:s'),
          'time_idle'     => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_do_log', $newrow);
        $iddown = $this->db->insert_id();
      }
    }

    //$sql = "SELECT status FROM tbl_do_status WHERE id IN (SELECT max(id) FROM tbl_do_status WHERE do_id = '$id')";
    //$stt = $this->db->query($sql)->row_array();

    switch ($dostatus) {
      case 'Cancel':
        $status = 'Cancel';
        $psn = '***** CANCELED *****';
        break;

      case 'Return':
        $status = 'Return';
        $psn = '***** RETURNED *****';
        break;  

      default :
        $status = 'Finished';
        $psn = '***** FINISHED *****';
        break;     
    }

    if($status == 'Finished') {
      $this->mcrm->setStatusLinkCRM('2', $id, '0', 'Finished');
    }

    //if($stt['status'] != 'Finished'){

      $do_status = array(
        'do_id' => $id,
        'status'  => $status,
        'user_id' => $user,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_do_status', $do_status);

      $update = array(
        'status'      => $status,
        'status_date' => date('Y-m-d H:i:s'),
        'status_user' => $user,
        );
      $this->db->where('id', $id);
      $this->db->update('tbl_do', $update);
    //}  

    $sql = "SELECT category FROM tbl_do WHERE id = '$id'";
    $cat = $this->db->query($sql)->row_array();

    if($cat['category'] == 0){
      $args = array(
        'user_edit' => $user,
        'date_edit' => date('Y-m-d H:i:s'),
        'category'  => '1',
        );
      $this->db->where('id', $id);
      $this->db->update('tbl_do', $args);
    }

    $up_do = array(
      'user_pending' => $user,
      'date_close' => date('Y-m-d H:i:s'),
      );
    $this->db->where('id', $id);
    $this->db->update('tbl_do', $up_do);

    $pesan = array(
        'type'        => '2',
        'type_id'     => $id,
        'log_type_id' => $iddown,
        'sender_id'   => $user,
        'pesan'       => $psn,
        'date_created'  => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_multi_pesan', $pesan);
      $id_pesan = $this->db->insert_id();

      $this->notification($id, $id_pesan, $notif = '2');

      $this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');

  }

  public function uploadfile($type_id, $jenis, $type)
  {
    function compress_image($src, $dest , $quality)
    {
        $info = getimagesize($src);

        if ($info['mime'] == 'image/jpeg')
        { //echo "jpeg zzz"; exit();
           $image = imagecreatefromjpeg($src);
           //compress and save file to jpg
        imagejpeg($image, $dest, $quality);
        }
        elseif ($info['mime'] == 'image/png')
        { //echo "png cscscsc"; exit();
            $image = imagecreatefrompng($src);
        imagepng($image, $dest, $quality);
        }

        //return destination file
        return $dest;
    }

    if($_FILES)
    {

      $details = $this->input->post('jenis');
      //print_r($details); exit();
      $uploaddir = 'assets/images/upload_do/';

      foreach ($_FILES['userfile']['name'] as $key => $value)
      {

        $temp =  explode(".", $value);
        $jns = end($temp);
        $fname = substr($value, 0, -4);
        $fname = $fname.'_'.$type_id.'.'.$jns;

        if(!$value)
        {
          //$file_name = basename($fname);

          //$uploadfile = $uploaddir . basename($fname);
          //move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
        }else{
          $file_name = basename($fname);

          $uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
          move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

          $conn_id = $this->mftp->conFtp();

          if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa";
            $compress = compress_image($file_name, $file_name, 7);
          }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
            $compress = compress_image($file_name, $file_name, 40);
          }

          if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
           /*echo "successfully uploaded $file_name = $uploadfile\n"; 
          } else {
           echo "There was a problem while uploading $file_name\n";
          }
		  */

			   $file_upload = array(
				'do_id'         => $type_id,
				'file_name'     => $file_name,
				'uploader'      => $_SESSION['myuser']['karyawan_id'],
				'date_created'  => date('Y-m-d H:i:s'),
				'type'          => $type,
	
			  );
			  $this->db->insert('tbl_upload_do', $file_upload);
			  $upl_id = $this->db->insert_id();
	
			  $this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');
	
			  ftp_close($conn_id);
	
			  unlink($file_name);
		  
		  } else {
           //echo "There was a problem while uploading $file_name\n";
          }

        }
         if($details == 'details'){ 
          $this->notification($type_id, $upl_id, $notif = '3');
        }
        //if($jenis == 'details'){
        //  $this->notification($type_id, $upl_id, $notif = '3');
        //}
      }
    }
  }

    public function add_pesan()
    {
      if($this->input->post())
      {
        $id = $this->input->post('do_id');
        
        $this->db->select('id');
        $this->db->from('tbl_do_log');
        $this->db->where('do_id', $id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $que = $this->db->get()->row_array();

        $log_do_id = $que['id'];

        $sender = $_SESSION['myuser']['karyawan_id'];
        $pesan = $this->input->post('msg');
        $pesan = str_replace("'", "''", $pesan);

        $addpesan = array(
          'type'          => '2',
          'type_id'       => $id,
          'log_type_id'   => $log_do_id,
          'sender_id'     => $sender,
          'pesan'         => $pesan,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_multi_pesan', $addpesan);
        $msg_id = $this->db->insert_id();

        $this->notification($id, $msg_id, $notif = '2');
        $this->logAll($id, $desc = '1', $msg_id, $ket = 'tbl_multi_pesan');
      }
    }

    public function __do_receipt($status)
    {
        $sql = "SELECT re.id, re.no_do, re.date_created, re.status,
                re.date_receipt, re.ket, re.cabang, cu.perusahaan, lg.nickname,
                upload_do.file_name, upload_do.date_file, upload_do.updo_nickname
                FROM tbl_do_receipt as re
                LEFT JOIN tbl_customer as cu ON cu.id = re.customer_id
                LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = re.user_receipt
                LEFT JOIN (
                  SELECT updo.do_id,
                  GROUP_CONCAT(file_name) as file_name,
                  GROUP_CONCAT(date_created) as date_file,
                  GROUP_CONCAT(lg.nickname) as updo_nickname
                  FROM tbl_upload_do updo
                  LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = updo.uploader
                  WHERE type = 1
                  GROUP BY do_id
                ) upload_do ON re.id = upload_do.do_id";

        if($status == 1)
        {
          $sql .= " WHERE re.status = 1";
        }

        $sql .= " GROUP BY re.id DESC ORDER BY re.status ASC";

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

     public function do_receipt($status)
    {
      if($status == 1) {
        $where = 'WHERE re.status = 1';
      }else {
        $where = '';
      }
      $sql = "SELECT re.id, re.no_do, re.date_created, re.status, re.date_receipt, re.ket, re.cabang, cu.perusahaan, lg.nickname
              FROM tbl_do_receipt as re
              LEFT JOIN tbl_customer as cu ON cu.id = re.customer_id
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = re.user_receipt
              $where
              GROUP BY re.id DESC ORDER BY re.status ASC";
      $result = $this->db->query($sql)->result_array();

      return $result;
    }

    public function GetUploadReceipt($id_receipt)
    {
      $sql = "SELECT file_name, nickname, updo.date_created FROM tbl_upload_do updo
              LEFT JOIN tbl_loginuser AS lg ON lg.karyawan_id = updo.uploader WHERE updo.type = '1' AND updo.do_id = '$id_receipt' GROUP BY updo.id ASC";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

    public function add_newdoreceipt()
    {
      if($this->input->post())
      {
        $no_do1 = $this->input->post('no_do1');
        $no_do2 = $this->input->post('no_do2');
        $no_do3 = $this->input->post('no_do3');
        $no_do = 'DO'.$no_do1.'/'.$no_do2.'/'.$no_do3;
        $id_customer = $this->input->post('customer');
        $cabang = $this->input->post('cabang');

        $array = array(
          'no_do'         => $no_do,
          'date_created'  => date('Y-m-d H:i:s'),
          'customer_id'   => $id_customer,
          'cabang'        => $cabang,
          );
        $this->db->insert('tbl_do_receipt', $array);
        $do_receipt_id = $this->db->insert_id();

        $this->logAll($do_receipt_id, $desc = '1', $do_receipt_id, $ket = 'tbl_do_receipt');
      }
    }

    public function receiptStatus()
    {
      $id = $this->input->post('id');
      $stt = $this->input->post('stt');
      if($this->input->post()) {
        $arr = array(
          'status'        => $stt,
          'user_receipt'  => $_SESSION['myuser']['karyawan_id'],
          'date_receipt'  => date('Y-m-d H:i:s'),
          );
        $this->db->where('id', $id);
        $this->db->update('tbl_do_receipt', $arr);
      }

      $sql = "SELECT re.date_receipt, lg.nickname
              FROM tbl_do_receipt as re
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = re.user_receipt
              WHERE re.id = '$id'";
      $res = $this->db->query($sql)->row_array();
      $result = array(
        'date_receipt' => date('d-m-Y H:i:s', strtotime($res['date_receipt'])),
        'nickname'  => $res['nickname'],
        );
      return $result;
    }

    public function changeNotes($method)
    {
      $id = $this->input->post('receipt_id');

      if($this->input->post()) {
        $ket = $this->input->post('notes');
        $ket = str_replace("'", "''", $ket);
        $args = array(
          'ket' => $ket,
            );
        $this->db->where('id', $id);
        $this->db->update('tbl_do_receipt', $args);

        if($method == 'add')
        {
          $this->logAll($id, $desc = '1', $id, $ket = 'tbl_do_receipt');

        }elseif($method == 'edit') {

          $this->logAll($id, $desc = '3', $id, $ket = 'tbl_do_receipt');
        }

        $sql = "SELECT id, ket FROM tbl_do_receipt WHERE id = '$id'";
        $notes = $this->db->query($sql)->row_array();

        return $notes;
      }

    }

      public function notification($id, $msg_id, $notif)
      {
        $user = $_SESSION['myuser']['karyawan_id'];
        $sql = "SELECT do.divisi, kar.cabang, kar.nama FROM tbl_do as do
                LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id
                WHERE do.id = '$id'";
        $query = $this->db->query($sql)->row_array();

        $a = $query['cabang'];
        $div = $query['divisi'];
        $date = date('Y-m-d H:i:s');

        if($a == 'Bandung') {
          $position_cbg = '57';
        }elseif ($a == 'Surabaya') {
          $position_cbg = '55';
        }elseif ($a == 'Medan') {
          $position_cbg = '56';
        }else{
          $position_cbg = '';
        }

        if($div == 'dhc') {
          $div = '88';
        }elseif ($div == 'dre') {
          $div = '89';
        }elseif ($div == 'dce') {
          $div = '90';
        }elseif ($div == 'dhe') {
          $div = '91';
        }elseif ($div == 'dgc') {
          $div = '92';
        }elseif ($div == 'dee') {
          $div = '93';
        }elseif ($div == 'dwt') {
          $div = '100';
        }

        if(!empty($position_cbg)) {
          $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created)
                  SELECT uploader, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_upload_do
                  WHERE do_id = '$id' AND uploader != '$user' AND type = '0' GROUP BY uploader
                  UNION SELECT overto, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_do_log
                  WHERE do_id = '$id' AND overto NOT IN (' ', '$user') GROUP BY overto
                  UNION SELECT sender_id, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_multi_pesan
                  WHERE type_id = '$id' AND type = '2' AND sender_id != '$user' GROUP BY sender_id
                  UNION SELECT id, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_karyawan
                  WHERE published = '1' AND position_id IN ('$position_cbg', '$div')";

        } else {
          $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created)
                  SELECT uploader, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_upload_do
                  WHERE do_id = '$id' AND uploader != '$user' AND type = '0' GROUP BY uploader
                  UNION SELECT overto, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_do_log
                  WHERE do_id = '$id' AND overto NOT IN (' ', '$user') GROUP BY overto
                  UNION SELECT sender_id, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_multi_pesan
                  WHERE type_id = '$id' AND type = '2' AND sender_id != '$user' GROUP BY sender_id
                  UNION SELECT id, '$msg_id', '$notif', '$id', '0', '2', '$date' FROM tbl_karyawan
                  WHERE published = '1' AND position_id IN ('$div', '58')";
        }
        $this->db->query($sql);
      }

      public function logAll($id, $desc, $desc_id, $ket)
      {
        $user = $_SESSION['myuser']['karyawan_id'];
        $logAll = array(
          'descrip'       => $desc,
          'descrip_id'    => $desc_id,
          'user_id'       => $user,
          'modul'         => '2',
          'modul_id'      => $id,
          'ket'           => $ket,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_log', $logAll);
      }

      public function uploadlink()
      {
        $file_name  = $this->input->post('file_name');
        $uploader   = $this->input->post('uploader');
        $do_id      = $this->input->post('do_id');

        $link = array(
          'file_name'     => $file_name,
          'type'          => '2',
          'uploader'        => $_SESSION['myuser']['karyawan_id'],
          'date_created'    => date('Y-m-d H:i:s'),
          'do_id '        => $do_id,
        );
        $this->db->insert('tbl_upload_do', $link);

        return $do_id;
      }

    public function do_link($do_id)
    {
      $sql = "SELECT updo.*, lg.nickname FROM tbl_upload_do as updo
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = updo.uploader
          WHERE updo.do_id = '$do_id' AND updo.type = '2' ORDER BY updo.id ASC ";
      $link = $this->db->query($sql)->result_array();

      return $link;
    }

    private function getdatakar($sales_id)
  {
    $sql = "SELECT cabang FROM tbl_karyawan WHERE id = '$sales_id'";
    return $this->db->query($sql)->row_array();
  }

  private function getposition_id($div, $cbg)
  {
     switch ($div) {
      case 'dce':
        $leader = '90';
        break;
      case 'dee':
        $leader = '93';
        break;
      case 'dhc':
        $leader = '88';
        break;
      case 'dhe':
        $leader = '91';
        break;
      case 'dgc':
        $leader = '90';
        break;
      case 'dre':
        $leader = '89';
        break;   
      case 'dwt':
        $leader = '91';
        break;          
    }

    switch ($cbg) {
      case 'Bandung':
        $kacab = '57';
        break;
      case 'Medan':
        $kacab = '56';
        break;
      case 'Surabaya':
        $kacab = '55';
        break;    
      case 'Cikupa':
        $kacab = '58';
        break;
      default :
        $kacab = 'NULL'; 
        break; 
    }

    return array('kadiv' => $leader, 'kacab' => $kacab);
  }

  public function do_cancel()
  {
    $do_id    = $this->input->post('do_id');
    $alasan   = $this->input->post('msg');
    $div      = $this->input->post('divisi');
    $sales_id = $this->input->post('sales_id');

    $log_id  = $this->lastlogid($do_id);
    $cbg      = $this->getdatakar($sales_id);
    $pos_id   = $this->getposition_id($div, $cbg['cabang']);


    $pesan = "<b>Mengajukan Cancel (Pembatalan) Delivery</b>";
    $pesan .= "<br><b>Alasan : </b>".$alasan;

    $pesan_id = $this->__pesan($do_id, $log_id['id'], $pesan);

    $this->updateDO($do_id, 'Cancel');

    $this->notifapproval($pos_id['kadiv'], $pos_id['kacab'], $do_id, $pesan_id);

    if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kadiv', 'approval' => '1',));
    }elseif(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kacab', 'approval' => '1',));
    }

    return $do_id;

  }

  public function do_return()
  {
    $do_id    = $this->input->post('do_id');
    $alasan   = $this->input->post('msg');
    $div      = $this->input->post('divisi');
    $sales_id = $this->input->post('sales_id');

    $log_id  = $this->lastlogid($do_id);
    $cbg      = $this->getdatakar($sales_id);
    $pos_id   = $this->getposition_id($div, $cbg['cabang']);


    $pesan = "<b>Mengajukan Return (Pengembalian) Delivery</b>";
    $pesan .= "<br><b>Alasan : </b>".$alasan;

    $pesan_id = $this->__pesan($do_id, $log_id['id'], $pesan);

    $this->updateDO($do_id, 'Return');

    $this->notifapproval($pos_id['kadiv'], $pos_id['kacab'], $do_id, $pesan_id);

    if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kadiv', 'approval' => '1',));
    }elseif(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kacab', 'approval' => '1',));
    }

    return $do_id;
  }

  public function do_replace()
  {
    $do_id    = $this->input->post('do_id');
    $alasan   = $this->input->post('msg');
    $div      = $this->input->post('divisi');
    $sales_id = $this->input->post('sales_id');

    $log_id  = $this->lastlogid($do_id);
    $cbg      = $this->getdatakar($sales_id);
    $pos_id   = $this->getposition_id($div, $cbg['cabang']);


    $pesan = "<b>Mengajukan Replace (Tukar) Delivery</b>";
    $pesan .= "<br><b>Alasan : </b>".$alasan;

    $pesan_id = $this->__pesan($do_id, $log_id['id'], $pesan);

    $this->updateDO($do_id, 'Replacement');

    $this->notifapproval($pos_id['kadiv'], $pos_id['kacab'], $do_id, $pesan_id);

    if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kadiv', 'approval' => '1',));
    }elseif(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) {
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => 'Kacab', 'approval' => '1',));
    }

    return $do_id;
  }

  private function updateDO($do_id, $do_status)
  {
    $args = array(
      'do_status' => $do_status,
    );

    $this->db->where('id',$do_id);
    $this->db->update('tbl_do', $args);
  }

  public function __pesan($do_id, $log_id, $pesan)
  {
    $ket_pesan = array(
            'type'          => '2',
            'type_id'       => $do_id,
            'log_type_id'   => $log_id,
            'sender_id'     => $_SESSION['myuser']['karyawan_id'],
            'pesan'         => $pesan,  
            'date_created'  => date('Y-m-d H:i:s'), 
            );
    $this->db->insert('tbl_multi_pesan', $ket_pesan);
    return $this->db->insert_id();
  }

  private function lastlogid($id)
  {
    $sql = "SELECT id FROM tbl_do_log WHERE do_id = '$id' GROUP BY id DESC LIMIT 1";
    return $this->db->query($sql)->row_array();
  }

  private function notifapproval($leader, $kacab, $do_id, $pesan_id)
  {

    $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, moduL_id, modul) SELECT id, '$pesan_id', '13', '$do_id', '2' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$leader', $kacab)";
    $this->db->query($sql);
  }

  public function approved($do_status, $do_id, $log_id)
  { 
      if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) 
      {
         $lvl_appr = 'Kadiv';
      }elseif(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) {
        $lvl_appr = 'Kacab';
      }

      $pesan = "<b>".$do_status." Delivery</b> <b style='color : green;'>Approved</b> <b>by ".$lvl_appr."</b>";

      $appr = array(
        'do_id'           => $do_id,
        'log_do_id'       => $log_id,
        'user_id'         => $_SESSION['myuser']['karyawan_id'],
        'jenis_approval'  => $do_status,
        'status_approval' => '1',
        'date_approval'   => date('Y-m-d H:i:s'),
      );
      $this->db->insert('tbl_do_approval', $appr);

      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', array('lvl_approval' => $lvl_appr, 'approval' => '1',));

      if($lvl_appr == 'Kadiv' AND $do_status == 'Return') {
        $this->db->where('id', $do_id);
        $this->db->update('tbl_do', array('date_close' => '0000-00-00 00:00:00'));
      }

      $id_pesan = $this->__pesan($do_id, $log_id, $pesan);

      $this->notification($do_id, $id_pesan, '2');

  }

  public function notapproved()
  {
    if($this->input->post()) {

      $do_id     = $this->input->post('do_id');
      $do_status = $this->input->post('do_status');
      $ket       = $this->input->post('msg');

      $sql = "SELECT id FROM tbl_do_log WHERE do_id = '$do_id' GROUP BY id DESC LIMIT 1";
      $que = $this->db->query($sql)->row_array();

      $log_id = $que['id'];

      if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) 
      {
         $lvl_appr = 'Kadiv';
      }elseif(in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) {
        $lvl_appr = 'Kacab';
      }

      $pesan = "<b>".$do_status." (Pembatalan) Delivery, </b><b style='color : red;'>Not Approved</b> <b>by ".$lvl_appr."</b>";
      $pesan .= "<br><b>Ket : </b> ".$ket;

      $appr = array(
        'do_id'           => $do_id,
        'log_do_id'       => $log_id,
        'user_id'         => $_SESSION['myuser']['karyawan_id'],
        'jenis_approval'  => $do_status,
        'status_approval' => '2',
        'date_approval'   => date('Y-m-d H:i:s'),
      );
      $this->db->insert('tbl_do_approval', $appr);

      $notappr = array(
        'lvl_approval' => $lvl_appr,
        'approval'     => '2',
        'do_status'    => '',
      );
      $this->db->where('id', $do_id);
      $this->db->update('tbl_do', $notappr);

      $id_pesan = $this->__pesan($do_id, $log_id, $pesan);

      $this->notification($do_id, $id_pesan, '2');

      return $do_id;
    }
  }
}
