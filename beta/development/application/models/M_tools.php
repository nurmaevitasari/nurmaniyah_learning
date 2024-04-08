<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_tools extends CI_Model {

	public function __construct()
  	{
	    parent::__construct();
	    $user = $this->session->userdata('myuser');
      $this->load->model('Ftp_model', 'mftp');

	    if(!isset($user) or empty($user))
	    {
	      redirect('c_loginuser');
	    }
  	}

  	public function employee()
  	{
  		$sql = "SELECT id, nama FROM tbl_karyawan WHERE published = 1 AND id != '101' ORDER BY nama ASC";
  		$kar = $this->db->query($sql)->result_array();

  		return $kar;
  	}

  	public function idTool() {
  		$query = "SELECT id FROM tbl_tools";
		$rowcount = $this->db->query($query)->num_rows();

		return $rowcount;
  	}

    public function __ListTools() {
      $user = $_SESSION['myuser']['karyawan_id'];
      $position_id = $_SESSION['myuser']['position_id'];
      $cabang = $_SESSION['myuser']['cabang'];
      $div = $_SESSION['myuser']['position'];
      $div = substr($div, -3);

      $sql = "SELECT tl.*, up.file_name, up.type as upl_type,
					lg.nickname, ki.status as sts_kill, ty.type as st_type,
					ho.user_holder, ap.status_approval, lap.nickname as name_approval,
					ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity
					FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id";

      if(in_array($position_id, array('1','2','77', '5', '9', '3', '83')) OR $_SESSION['myuser']['role_id'] == '15') {
          $sql .= '';
      }
      elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18'))){
        $sql .= " WHERE kr.cabang = '$cabang'";
      }
      elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93', '100'))) {
        $sql .= "  WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%'))";
      }
      elseif ($position_id == '13' AND $_SESSION['myuser']['karyawan_id'] == '16') {
        $sql .= " WHERE ps.id = '13'";
      }
      else{
        $sql .= " WHERE ho.user_holder = '$user' ";
      }

      $sql .=" GROUP BY tl.id DESC";
      $sql .=" ORDER BY tl.id DESC";

  		$query = $this->db->query($sql)->result_array();

  		return $query;
  	}

    public function __toolHolder()
    {
        $user = $_SESSION['myuser']['karyawan_id'];
        $position_id = $_SESSION['myuser']['position_id'];
        $cabang = $_SESSION['myuser']['cabang'];
        $div = $_SESSION['myuser']['position'];
        $div = substr($div, -3);

        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position,
							sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id";



        if(in_array($position_id, array('1','2','77', '9', '83', '3')) OR $_SESSION['myuser']['role_id'] == '15') {

          $sql .= "";

        }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18'))){

          $sql .= " WHERE kr.cabang = '$cabang'";

        }elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93','100'))) {

         $sql .= " WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%'))";

        }elseif ($position_id == '13' AND $_SESSION['myuser']['karyawan_id'] == '16') {

         $sql .= " WHERE kr.position_id = '13'";

        }else {

          $sql .= " WHERE user_holder = '$user'";

        }

        $sql .= " GROUP BY user_holder";
        
        $res = $this->db->query($sql)->result_array();

        return $res;
    }


  	public function ListTools() {
      $user = $_SESSION['myuser']['karyawan_id'];
      $position_id = $_SESSION['myuser']['position_id'];
      $cabang = $_SESSION['myuser']['cabang'];
      $div = $_SESSION['myuser']['position'];
      $div = substr($div, -3);

      if(in_array($position_id, array('1','2','77', '5', '9', '3', '83')) OR $_SESSION['myuser']['role_id'] == '15') {
      $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          GROUP BY tl.id DESC";

      }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18'))){
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND  up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          WHERE kr.cabang = '$cabang'
          GROUP BY tl.id DESC";

      }elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93','100'))) {
       $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
          LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%'))
          GROUP BY tl.id DESC";

      }elseif ($position_id == '13') {
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
          LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          WHERE ps.id IN ('13', '102')
          GROUP BY tl.id DESC";
      }else {
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, note_rejected, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          WHERE ho.user_holder = '$user'
          GROUP BY tl.id DESC";
      }

  		$query = $this->db->query($sql)->result_array();

  		return $query;
  	}

    public function editTool($id)
    {
      $sql = "SELECT tl.*, hl.user_holder as holder, ap.user_create, ap.status_approval, lg.nickname FROM tbl_tools as tl
              LEFT JOIN tbl_tools_holder as hl ON hl.tool_id = tl.id
              LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
              LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = hl.user_holder
              WHERE tl.id = '$id'";
      $row = $this->db->query($sql)->row_array();

      $sql = "SELECT a.id, a.file_name, a.type, a.date_created, b.nickname FROM tbl_upload_tools a
              LEFT JOIN tbl_loginuser b ON b.karyawan_id = a.uploader
              WHERE a.tool_id = '$id' AND a.status = '0' GROUP BY a.id ASC";
      $que = $this->db->query($sql)->result_array();

      $data = array(
        'tool' => $row,
        'photo' => $que,
        );
      return $data;
    }

  	public function getPhotoTools($id, $type)
  	{
  		$sql = "SELECT file_name FROM tbl_upload_tools WHERE type = '$type' AND tool_id = '$id' AND status = '0' ORDER BY id ASC";
  		$que = $this->db->query($sql)->result_array();

  		return $que;
  	}

  	public function detailsTool($id)
  	{
  		$sql = "SELECT tl.*, up.file_name, up.type as type_upload, tltype.type as sttype, ho.user_holder FROM tbl_tools as tl
  				LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
  				LEFT JOIN tbl_tools_type as tltype ON tltype.id = tl.status
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
  				WHERE tl.id = '$id'";
  		$res = $this->db->query($sql)->row_array();

  		return $res;
  	}

  	public function logTool($id)
  	{
  		$sql = "SELECT lg.*, ty.type as logtype, lgr.nickname as reporter, lgo.nickname as penerima, lgs.nickname as user_loss, lgk.nickname as user_kill, rep.kondisi as rep_kondisi, rep.notes as rep_notes, lgoo.nickname as pemberi, ho.notes as ho_notes, lo.date_loss, lo.repurchased, lo.date_estimasi_tools, lo.alasan as loss_notes, ki.status as kill_status, ki.notes as kill_notes, ki.user_acc, ki.date_acc FROM tbl_tools_log as lg
              LEFT JOIN tbl_tools_type as ty ON ty.id = lg.log_type
              LEFT JOIN tbl_tools_report as rep ON (rep.id = lg.log_type_id AND lg.log_type = '5')
              LEFT JOIN tbl_tools_handover as ho ON (ho.id = lg.log_type_id AND lg.log_type = '6')
              LEFT JOIN tbl_tools_loss as lo ON (lo.id = lg.log_type_id AND lg.log_type = '7')
              LEFT JOIN tbl_tools_kill as ki ON (ki.id = lg.log_type_id AND lg.log_type = '8')
              LEFT JOIN tbl_loginuser as lgr ON lgr.karyawan_id = rep.user_report
              LEFT JOIN tbl_loginuser as lgo ON lgo.karyawan_id = ho.user_penerima
              LEFT JOIN tbl_loginuser as lgoo ON lgoo.karyawan_id = ho.user_pemberi
              LEFT JOIN tbl_loginuser as lgs ON lgs.karyawan_id = lo.user_loss
              LEFT JOIN tbl_loginuser as lgk ON lgk.karyawan_id = ki.user_kill
              WHERE lg.tool_id = '$id' AND lg.log_type NOT IN ('3', '4') ORDER BY lg.id DESC ";
  		$res = $this->db->query($sql)->result_array();

  		return $res;
  	}

    public function toolHolder()
    {
      $user = $_SESSION['myuser']['karyawan_id'];
      $position_id = $_SESSION['myuser']['position_id'];
      $cabang = $_SESSION['myuser']['cabang'];
      $div = $_SESSION['myuser']['position'];
      $div = substr($div, -3);

      if(in_array($position_id, array('1','2','77', '9', '83', '3')) OR $_SESSION['myuser']['role_id'] == '15') {
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              GROUP BY user_holder";

      }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18'))){
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE kr.cabang = '$cabang'
              GROUP BY user_holder";

      }elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93','100'))) {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%'))
              GROUP BY user_holder";

      }elseif ($position_id == '13') {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE kr.position_id IN ('13','102')
              GROUP BY user_holder";

      }else {
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE user_holder = '$user'
              GROUP BY user_holder";
      }
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

    public function date_report($user)
    {
      $sql = "SELECT max(date_created) as tgl_rep FROM tbl_tools_report WHERE user_report = '$user'";
      $rowres = $this->db->query($sql)->row_array();

      return $rowres;
    }

    public function details_holder($user)
    {
      $sql = "SELECT count(ho.tool_id) as jml_tools, sum(tl.price) as total_harga, AVG(TIMESTAMPDIFF(SECOND, tl.date_purchased, CURDATE())) AS umur, kar.nama, count(los.tool_id) as tool_loss, sum(too.price) as price_loss, COUNT(kil.tool_id) as tool_kill, SUM(tok.price) as price_kill
        FROM tbl_tools_holder as ho LEFT JOIN tbl_tools as tl ON tl.id = ho.tool_id
        LEFT JOIN tbl_karyawan as kar ON kar.id = ho.user_holder
        LEFT JOIN tbl_tools_loss as los ON los.tool_id = tl.id
        LEFT JOIN tbl_tools_kill as kil ON kil.tool_id = ho.id
        LEFT JOIN tbl_tools as too ON too.id = los.tool_id
        LEFT JOIN tbl_tools as tok ON tok.id = kil.tool_id
        WHERE ho.user_holder = '$user' ";

      /* $sql = "SELECT ho.tool_id, sum(too.price) as total_harga, kar.nama FROM tbl_tools_holder as ho
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              LEFT JOIN tbl_karyawan as kar ON kar.id = ho.user_holder
              WHERE ho.user_holder = '$user'"; */
      $res = $this->db->query($sql)->row_array();
      return $res;
    }

    public function table_details_holder($user) {
      $sql = "SELECT tl.*, upt.file_name, ho.date_created as date_holder FROM tbl_tools_holder as ho
              LEFT JOIN tbl_tools as tl ON tl.id = ho.tool_id
              LEFT JOIN tbl_upload_tools as upt ON (upt.tool_id = ho.tool_id AND upt.type = '0' AND upt.status = '0')
              WHERE ho.user_holder = '$user'
              GROUP BY tl.id ASC";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

    public function lastHandOver($id)
    {
      $sql = "SELECT ho.*, lg.nickname as nama_pemberi, lgn.nickname as nama_penerima
              FROM tbl_tools_handover as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_pemberi
              LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = ho.user_penerima
              WHERE tool_id = '$id' ORDER BY ho.id DESC LIMIT 1";
      $res = $this->db->query($sql)->row_array();

      return $res;
    }

    public function lastReportStatus($id)
    {
      $sql = "SELECT re.*, tl.status, ty.type as type_status, tl.status, ki.date_created as date_kill, lg.nickname as user_kill, lgn.nickname as user_acc, ki.date_acc FROM tbl_tools as tl
              LEFT JOIN tbl_tools_report as re ON tl.id = re.tool_id
              LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
              LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ki.user_kill
              LEFT JOIN tbl_loginuser as lgn ON lgn.karyawan_id = ki.user_acc
              LEFT JOIN tbl_tools_loss as lo ON lo.tool_id = tl.id
              WHERE re.tool_id = '$id' ORDER BY re.id DESC LIMIT 1";
      $res = $this->db->query($sql)->row_array();

      return $res;
    }

    public function getPesan($log_id)
    {
      $sql = "SELECT tps.*, lg.nickname FROM tbl_tools_pesan tps
              LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = tps.sender
              WHERE log_tool_id = '$log_id' GROUP BY tps.id ASC";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

  	public function NewTool()
  	{
  		if($this->input->post()) {
        $sess = $_SESSION['myuser'];
        $sales = substr($sess['position'], 0, 5);
        $div = substr($sess['position'], -3);

  			$date = date('Y-m-d H:i:s');
        //$code 		= $this->input->post('code_tool');
  			$code_asset = $this->input->post('kode_asset');
  			$name 		= $this->input->post('name_tool');
  			$sn 		= $this->input->post('s_num');
  			$type		= $this->input->post('type');
  			$vendor		= $this->input->post('vendor');
  			$brand		= $this->input->post('brand');
  			$pr_date 	= $this->input->post('purchased_date');
  			$pr_date 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $pr_date);
  			$harga		= $this->input->post('harga');
  			$harga		= str_replace(".", "", $harga);
  			$mn_book	= $this->input->post('manual_book');
  			$condition	= $this->input->post('condition');
  			$warr_due	= $this->input->post('warranty_date');
  			$phone 		= $this->input->post('sc_phone');
  			$notes		= $this->input->post('notes');
        $holder = $this->input->post('holder');
        $kar = $_SESSION['myuser']['karyawan_id'];
        $qty = $this->input->post('quantity');

        $count = $this->idTool();

        $cou = $count + 1;
        $co = sprintf("%06s", $cou);
        $code = "A".$co;

  			$addtool = array(
  				'code' 				  => $code,
  				'code_asset'		=> $code_asset,
  				'name'				  => $name,
  				'type'				  => $type,
  				'serial_number'	=> $sn,
  				'brand'				  => $brand,
  				'vendor'			  => $vendor,
  				'price'				  => $harga,
  				'date_purchased' => $pr_date,
  				'tool_condition'	=> $condition,
  				'manual_book'		 => $mn_book,
  				'warranty_due'		=> $warr_due,
  				'sc_phone'			=> $phone,
  				'notes'				=> $notes,
  				'date_created'  => date('Y-m-d H:i:s'),
  				'status'			=> '5',
          'quantity'    => $qty,
  				);
  			$this->db->insert('tbl_tools', $addtool);
  			$id_tool = $this->db->insert_id();

        $addholder = array(
          'tool_id' => $id_tool,
          'user_holder' => $holder,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_tools_holder', $addholder);

        if($sess['karyawan_id'] == $holder && in_array($sess['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '95'))) {

        }elseif($sess['karyawan_id'] == $holder) {
          if($sess['cabang'] == 'Medan') {
            $pos = '56';
          }elseif($sess['cabang'] == 'Surabaya') {
            $pos = '95';
          }elseif ($sess['cabang'] == 'Bandung') {
            $pos = '57';
          }elseif ($sess['cabang'] == 'Cikupa') {
            $pos = '58';
          }elseif (in_array($sess['position_id'], array('5','7','8','9','11','12','76'))) {
            $pos = '77';
          }elseif ($sess['cabang'] == $sales) {
            $leader = 'Leader Sales '.$div;
            $sql = "SELECT id FROM tbl_position WHERE position like '%$leader%'";
            $pos = $this->db->query($sql)->row_array();
            $pos = $pos['id'];
          }else {
            $pos = '2';
          }
            $sql = "SELECT lg.karyawan_id FROM tbl_loginuser lg LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id WHERE kr.position_id = '$pos' AND lg.published = 1 AND kr.published = 1";
            $kar = $this->db->query($sql)->row_array();
            $kar = $kar['karyawan_id'];

            /* $sql = "INSERT INTO tbl_tools_approval (tool_id, user_create, user_approval, date_created)
                    VALUES ('$id_tool', '$holder', '$kar', '$date')";
            $appr = $this->db->query($sql);
            $id_appr = $this->db->insert_id();

            $this->notification($id_tool, $id_appr, '13', $kar); */

        }elseif($sess['karyawan_id'] != $holder) {
          $approve =  array(
            'tool_id' => $id_tool,
            'user_create' => $sess['karyawan_id'],
            'user_approval' => $holder,
            'date_created'  => $date,
            );
         // $this->db->insert('tbl_tools_approval', $approve);
         // $id_appr = $this->db->insert_id();

         // $this->notification($id_tool, $id_appr, '13', $holder);

        }

        $args = array(
          'tool_id'   => $id_tool,
          'kondisi'   => $condition,
          'user_report' => $kar,
          'date_created'  => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tbl_tools_report', $args);
        $id_rep = $this->db->insert_id();

  			$this->uploadfile($id_tool, '0', 'phtuserfile');
  			$this->uploadfile($id_tool, '1', 'warruserfile');
  			$this->uploadfile($id_tool, '2', 'acsuserfile');

  			$this->log_tool($id_tool, '5', $id_rep);

  			$this->logAll($id_tool, '1', $id_tool, 'tbl_tools', $condition);

  			$login = array(
				'code'	=> $code,
				'name'	=> $name,
			);
			$this->session->set_flashdata('newtool', $login);
  		}
  	}

  	/* public function add_takeTool()
  	{
  		if($this->input->post())
  		{
  			$id = $this->input->post('id_tool');
  			$kar = $this->input->post('holder');

  			$arr = array(
  				'tool_id'		=> $id,
  				'user_holder'	=> $kar,
  				'date_created'	=> date('Y-m-d H:i:s'),
  				);
  			$this->db->insert('tbl_tools_holder', $arr);
  			$id_holder = $this->db->insert_id();

  			$update = array(
  				'status'	=> '4',
  				);
  			$this->db->where('id', $id);
  			$this->db->update('tbl_tools', $update);

  			$this->log_tool($id, '4', $id_holder);
  		}
  	} */
    public function UpdateTool()
    {

      if($this->input->post()) {
         //print_r($this->input->post()); exit();
        $sess = $_SESSION['myuser'];
        $id_tool = $this->input->post('id_tool');
        $code     = $this->input->post('code_tool');
        $code_asset = $this->input->post('kode_asset');
        $name     = $this->input->post('name_tool');
        $sn     = $this->input->post('s_num');
        $type   = $this->input->post('type');
        $vendor   = $this->input->post('vendor');
        $brand    = $this->input->post('brand');
        $pr_date  = $this->input->post('purchased_date');
        $pr_date  = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $pr_date);
        $harga    = $this->input->post('harga');
        $harga    = str_replace(".", "", $harga);
        $mn_book  = $this->input->post('manual_book');
        $condition  = $this->input->post('condition');
        $warr_due = $this->input->post('warranty_date');
        $phone    = $this->input->post('sc_phone');
        $notes    = $this->input->post('notes');
        $holder = $this->input->post('holder');
        $user = $_SESSION['myuser']['karyawan_id'];
        $date = date('Y-m-d H:i:s');
        $qty = $this->input->post('quantity');

        $addtool = array(
          'code'          => $code,
          'code_asset'    => $code_asset,
          'name'          => $name,
          'type'          => $type,
          'serial_number' => $sn,
          'brand'         => $brand,
          'vendor'        => $vendor,
          'price'         => $harga,
          'date_purchased' => $pr_date,
          'tool_condition' => $condition,
          'manual_book'    => $mn_book,
          'warranty_due'    => $warr_due,
          'sc_phone'      => $phone,
          'notes'       => $notes,
          'user_edit'   => $user,
          'date_edited' => date('Y-m-d H:i:s'),
          'quantity'    => $qty,
          );
        $this->db->where('id', $id_tool);
        $this->db->update('tbl_tools', $addtool);

        if($holder) {
          if($sess['karyawan_id'] == $holder && in_array($sess['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '95'))) {

          }elseif($sess['karyawan_id'] == $holder) {
            if($sess['cabang'] == 'Medan') {
              $pos = '56';
            }elseif($sess['cabang'] == 'Surabaya') {
              $pos = '95';
            }elseif ($sess['cabang'] == 'Bandung') {
              $pos = '57';
            }elseif ($sess['cabang'] == 'Cikupa') {
              $pos = '58';
            }elseif (in_array($sess['position_id'], array('5','7','8','9','11','12','76'))) {
              $pos = '77';
            }elseif ($sess['cabang'] == $sales) {
              $leader = 'Leader Sales '.$div;
              $sql = "SELECT id FROM tbl_position WHERE position like '%$leader%'";
              $pos = $this->db->query($sql)->row_array();
              $pos = $pos['id'];
            }else {
              $pos = '2';
            }
              $sql = "SELECT lg.karyawan_id FROM tbl_loginuser lg LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id WHERE kr.position_id = '$pos' AND lg.published = 1 AND kr.published = 1";
              $kar = $this->db->query($sql)->row_array();
              $kar = $kar['karyawan_id'];

            /*  $sql = "INSERT INTO tbl_tools_approval (tool_id, user_create, user_approval, date_created)
                      VALUES ('$id_tool', '$holder', '$kar', '$date')";
              $appr = $this->db->query($sql);
              $id_appr = $this->db->insert_id();

              $this->notification($id_tool, $id_appr, '13', $kar); */

          }elseif($sess['karyawan_id'] != $holder) {
            $approve =  array(
              'tool_id' => $id_tool,
              'user_create' => $sess['karyawan_id'],
              'user_approval' => $holder,
              'date_created'  => $date,
              );
            //$this->db->insert('tbl_tools_approval', $approve);
           // $id_appr = $this->db->insert_id();

            $up_holder = array('user_holder' => $holder);
            $this->db->where('tool_id', $id_tool);
            $this->db->update('tbl_tools_holder', $up_holder);

           // $this->notification($id_tool, $id_appr, '13', $holder);

          }
        }

        $this->uploadfile($id_tool, '0', 'phtuserfile');
        $this->uploadfile($id_tool, '1', 'warruserfile');
        $this->uploadfile($id_tool, '2', 'acsuserfile');

        $this->logAll($id_tool, '3', $id_tool, 'tbl_tools', $user);
      }
    }

    public function DeleteFiles()
    {
      $user = $_SESSION['myuser']['karyawan_id'];
      if($this->input->post()) {
        $id = $this->input->post('id');
        $tool_id = $this->input->post('tool_id');

        $delete = array(
          'status' => '1',
          'user_delete' => $user,
          'date_deleted'  => date('Y-m-d H:i:s'),
          );
        $this->db->where('id', $id);
        $this->db->update('tbl_upload_tools', $delete);

      $this->logAll($tool_id, '2', $id, 'tbl_upload_tools', '');
      }
    }

  	public function report()
  	{
  		if($this->input->post())
  		{
  			$id 		= $this->input->post('id_tool');
  			$condition 	= $this->input->post('condition');
  			$ket 		= $this->input->post('notes');
  			$user 		= $_SESSION['myuser']['karyawan_id'];

  			$args = array(
	  			'tool_id'		=> $id,
	  			'kondisi'		=> $condition,
	  			'notes'			=> $ket,
	  			'user_report'	=> $user,
	  			'date_created'	=> date('Y-m-d H:i:s'),
  			);
  			$this->db->insert('tbl_tools_report', $args);
  			$id_report = $this->db->insert_id();

  			$this->log_tool($id, '5', $id_report);

  			$this->uploadfile($id, '5', 'repuserfile');

  			$this->logAll($id, '1', $id_report, 'tbl_tools_report', $condition);


  		}
  	}

  	public function HandOver()
  	{
  		if($this->input->post())
  		{
  			$id 		     = $this->input->post('id_tool');
  			$penerima    = $this->input->post('penerima');
  			$ket 		     = $this->input->post('notes');
        $sess        = $_SESSION['myuser'];
  			$user 		   = $sess['karyawan_id'];

  			$args = array(
	  			'tool_id'		=> $id,
	  			'user_pemberi'	=> $user,
	  			'user_penerima'	=> $penerima,
	  			'notes'			=> $ket,
	  			'date_created'	=> date('Y-m-d H:i:s'),
  			);
  			$this->db->insert('tbl_tools_handover', $args);
  			$id_handover = $this->db->insert_id();

        $holder = array(
          'user_holder'   => $penerima,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->where('tool_id', $id);
        $this->db->update('tbl_tools_holder', $holder);

  			$this->log_tool($id, '6', $id_handover);

  			$upstatus = array( 'status' => '6' );
  			$this->db->where('id', $id);
  			$this->db->update('tbl_tools', $upstatus);

        $this->notification($id, $id_handover, '11', $penerima);
  			$this->logAll($id, '1', $id_handover, 'tbl_tools_handover', '');

        if($sess['karyawan_id'] != $penerima) {
          $approve =  array(
            'tool_id' => $id,
            'user_create' => $sess['karyawan_id'],
            'user_approval' => $penerima,
            'date_created'  => date('Y-m-d H:i:s'),
            );
         // $this->db->insert('tbl_tools_approval', $approve);
         // $id_appr = $this->db->insert_id();

         // $this->notification($id, $id_appr, '13', $holder);

        }

  		}
  	}

  	public function LossReport()
  	{

  		if($this->input->post())
  		{
  			$id 			= $this->input->post('id_tool');
  			$tgl_hilang 	= $this->input->post('tgl_hilang');
  			$tgl_hilang		= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_hilang);
  			$repurchased 	= $this->input->post('tools_baru');
  			$tgl_pengadaan 	= $this->input->post('tgl_pengadaan');
  			$tgl_pengadaan	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_pengadaan);
  			$alasan 		= $this->input->post('notes');
  			$user 			= $_SESSION['myuser']['karyawan_id'];

  			$add_loss = array(
  				'tool_id' 				=> $id,
  				'user_loss'				=> $user,
  				'date_loss'				=> $tgl_hilang,
  				'repurchased'			=> $repurchased,
  				'date_estimasi_tools'	=> $tgl_pengadaan,
  				'alasan'				=> $alasan,
  				'date_created'			=> date('Y-m-d H:i:s'),
  				);
  			$this->db->insert('tbl_tools_loss', $add_loss);
  			$id_loss = $this->db->insert_id();

  			$up_status = array('status' => '7');
  			$this->db->where('id', $id);
  			$this->db->update('tbl_tools', $up_status);

  			$this->log_tool($id, '7', $id_loss);

  			//$this->logAll($id, '1', $id_tool, 'tbl_tools_loss', '');

  		}
  	}

  	public function KillTools()
  	{

  		if($this->input->post()) {
  			$id 		= $this->input->post('id_tool');
  			$notes 		= $this->input->post('notes');
  			$user 		= $_SESSION['myuser']['karyawan_id'];

  			$add_kill = array(
  			'tool_id'	=> $id,
  			'user_kill'	=> $user,
  			'status'	=> '0',
  			'date_created'	=> date('Y-m-d H:i:s'),
  			'notes'	=> $notes,
  			);
  			$this->db->insert('tbl_tools_kill', $add_kill);
  			$kill_id = $this->db->insert_id();

  			$this->uploadfile($id, '8', 'killuserfile');

        $up_status = array( 'status'  => '8');
        $this->db->where('id', $id);
        $this->db->update('tbl_tools', $up_status);

  			$this->log_tool($id, '8', $kill_id);

        $this->notification($id, $kill_id, '12', '3');
        $this->logAll($id, '1', $kill_id, 'tbl_tools_kill', '');

  		}
  	}

     public function acc_kill($id)
      {
        $user = $_SESSION['myuser']['karyawan_id'];

        $sql = "SELECT tool_id FROM tbl_tools_kill WHERE tool_id = '$id'";
        $rowres = $this->db->query($sql)->row_array();

        if(!empty($rowres)) {
          $upkill = array(
          'status' => '1',
          'user_acc'  => $user,
          'date_acc'  => date('Y-m-d H:i:s'),
          );
        $this->db->where('tool_id', $id);
        $this->db->update('tbl_tools_kill', $upkill);
      }else{
         $upkill = array(
          'tool_id' => $id,
          'status' => '1',
          'user_acc'  => $user,
          'date_acc'  => date('Y-m-d H:i:s'),
          'date_created' => date('Y-m-d H:i:s'),
          );
         $this->db->insert('tbl_tools_kill', $upkill);
      }

        $upkill = array(
          'status' => '9',
          );
        $this->db->where('id', $id);
        $this->db->update('tbl_tools', $upkill);
        //$this->logAll();
        //$this->notification();
      }

      public function Approve()
      {
        if($this->input->post()) {
          $app_id = $this->input->post('appid');
          $user_app = $_SESSION['myuser']['karyawan_id'];
          $name = $_SESSION['myuser']['nickname'];
          $id = $this->input->post('id');

          $updt = array(
            'status_approval' => '1',
            'date_approval'   => date('Y-m-d H:i:s'),
            );
        //  $this->db->where('id', $app_id);
       //   $this->db->update('tbl_tools_approval', $updt);

       /*    $sql = "SELECT user_create FROM tbl_tools_approval WHERE id = '$app_id'";
          $user = $this->db->query($sql)->row_array();
          $user = $user['user_create'];
          $this->notification($id, $app_id, '14', $user);*/

          $json = array(
            'name' => $name,
            'date'  => date('d-m-Y H:i:s'),
            );
          return $json;
        }
      }

      public function Rejected()
      {
        if($this->input->post()) {
          $app_id = $this->input->post('appid');
          $name = $_SESSION['myuser']['nickname'];
          $note = $this->input->post('note_reject');
          $id = $this->input->post('toolid');

          $updt = array(
            'status_approval' => '2',
            'date_approval'   => date('Y-m-d H:i:s'),
            'note_rejected'   => $note,
            );
          //$this->db->where('id', $app_id);
          //$this->db->update('tbl_tools_approval', $updt);

          /* $sql = "SELECT user_create FROM tbl_tools_approval WHERE id = '$app_id'";
          $user = $this->db->query($sql)->row_array();
          $user = $user['user_create'];
          $this->notification($id, $app_id, '14', $user); */

          $json = array(
            'name' => $name,
            'date'  => date('d-m-Y H:i:s'),
            'note'  => $note,
            );
          return $json;
        }
      }

  	public function add_notes()
      {
        if($this->input->post())
        {
          $tl_id = $this->input->post('tool_id');
          $log_tl = $this->input->post('log_tl_id');
          $notes = $this->input->post('msg');

          $add = array(
            'tool_id'     => $tl_id,
            'log_tool_id' => $log_tl,
            'sender'      => $_SESSION['myuser']['karyawan_id'],
            'pesan'       => $notes,
            'date_created'  => date('Y-m-d H:i:s'),
            );
          $this->db->insert('tbl_tools_pesan', $add);
          $psn_id = $this->db->insert_id();

           $this->notification($tl_id, $psn_id, '2', '');
        }
      }

    public function log_tool($id, $type, $id_type)
  	{
  		$log_tool = array(
  			'tool_id'		=> $id,
  			'log_type'		=> $type,
  			'log_type_id'	=> $id_type,
  			'date_created'	=> date('Y-m-d H:i:s'),
  		);
  		$this->db->insert('tbl_tools_log', $log_tool);
  	}

  	public function uploadfile($id_tool, $type, $name)
  	{

  		if(!function_exists('compress_image')){
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
		}

	    if($_FILES)
	    {
	      	$uploaddir = 'assets/images/upload_tools/';

	      	foreach ($_FILES[$name]['name'] as $key => $value)
	      	{
              $temp =  explode(".", $value);
              $jns = end($temp);
              $fname = substr($value, 0, -4);
              $fname = $fname.'_'.$id_tool.'.'.$jns;

		        if(!$value)
		        {
			        //$file_name = basename($fname);

			        //$uploadfile = $uploaddir . basename($fname);
			        //move_uploaded_file($_FILES[$name]['tmp_name'][$key], $uploadfile);
		        }else{
		          	$file_name = basename($fname);

			        $uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
			        move_uploaded_file($_FILES[$name]['tmp_name'][$key], $file_name);

              $conn_id = $this->mftp->conFtp();

			        if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa";
			        	$compress = compress_image($file_name, $file_name, 7);
			        }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
			            $compress = compress_image($file_name, $file_name, 40);
		  			  }

              if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
               //echo "successfully uploaded $file_name = $uploadfile\n"; 

                $file_upload = array(
                'tool_id'       => $id_tool,
                'file_name'     => $file_name,
                'type'      => $type,
                'uploader'      => $_SESSION['myuser']['karyawan_id'],
                'date_created'  => date('Y-m-d H:i:s'),
              );
                $this->db->insert('tbl_upload_tools', $file_upload);
              // $upl_id = $this->db->insert_id();

              // $this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');

                ftp_close($conn_id);

                unlink($file_name);
              } else {
               //echo "There was a problem while uploading $file_name\n";
              }

		            
	        	}

	      		//$this->notification($type_id, $upl_id, $notif = '3');
	  		}
	    }


  	}

  	public function logAll($id, $desc, $desc_id, $ket, $isi)
      {
        $user = $_SESSION['myuser']['karyawan_id'];
        $logAll = array(
          'descrip'       => $desc,
          'descrip_id'    => $desc_id,
          'user_id'       => $user,
          'modul'         => '4',
          'modul_id'      => $id,
          'ket'           => $ket,
          'isi'			  => $isi,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_log', $logAll);
      }

    public function notification($id, $rec_id, $notif, $user)
      {
        $date = date('Y-m-d H:i:s');
        $kar = $_SESSION['myuser']['karyawan_id'];

       if($user == '') {
          $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, modul, date_created)
                  SELECT sender, '$rec_id', '$notif', '$id', '4', '$date' FROM tbl_tools_pesan
                  WHERE tool_id = '$id' AND sender != '$kar' GROUP BY sender
                  UNION SELECT user_holder, '$rec_id', '$notif', '$id', '4', '$date' FROM tbl_tools_holder
                  WHERE tool_id = '$id' AND user_holder != '$kar' GROUP BY user_holder";

          $this->db->query($sql);
        }else {
           $add = array(
            'modul' => '4',
            'modul_id'  => $id,
            'record_id' => $rec_id,
            'record_type' => $notif,
            'user_id' => $user,
          );
           $this->db->insert('tbl_notification', $add);
        }

      }

} ?>
