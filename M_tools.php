<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_tools extends CI_Model {

    var $order = array('tl.id' => 'DESC');
    var $column_order = array('tl.id',null,'tl.code','tl.name','lg.nickname','tl.quantity','tl.notes','st_type',null);
    var $column_search = array('tl.id','tl.code','tl.name', 'lg.nickname', 'tl.quantity', 'tl.notes', 'ty.type');

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

   //  public function __ListTools($cons='') 
   //  {
   //    $user = $_SESSION['myuser']['karyawan_id'];
   //    $position_id = $_SESSION['myuser']['position_id'];
   //    $cabang = $_SESSION['myuser']['cabang'];
   //    $div = $_SESSION['myuser']['position'];
   //    $div = substr($div, -3);


   //    $sql = "SELECT tl.last_update,tl.id, tl.code, tl.name, tl.quantity,tl.notes, up.file_name, up.type as upl_type, lg.nickname, ty.type as st_type
			// 		FROM tbl_tools as tl
   //        LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
   //        LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
   //        LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
   //        LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
   //        LEFT JOIN tbl_karyawan as kr ON kr.id = ho.user_holder
   //        LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
   //        WHERE tl.published='0'";

   //    // if(in_array($position_id, array('1','2','77', '5', '9', '3', '83','14','106')) OR $_SESSION['myuser']['role_id'] == '15') {
   //    //     $sql .= " WHERE tl.published='0'";
   //    // }
   //    // elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18','134'))){ // WL42182
   //    //   $sql .= " WHERE kr.cabang = '$cabang' AND published='0'";
   //    // }
   //    // elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93', '100'))) {
   //    //   $sql .= "  WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%')) AND tl.published='0'";
   //    // }
   //    // elseif ($position_id == '13') {
   //    //   $sql .= " WHERE ps.id IN ('13', '102') AND tl.published='0'";
   //    // }
   //    // elseif ($position_id == '73') {
   //    //   $sql .= " WHERE lg.role_id = '12' AND tl.published='0'";
   //    // }
   //    // elseif ($position_id == '30') {
   //    //   $sql .= " WHERE lg.role_id = '4 AND tl.published='0''";
   //    // }
   //    // else{
   //    //   $sql .= " WHERE ho.user_holder = '$user' AND tl.published='0' ";
   //    // }

   //      // if(in_array($position_id, array('1','2','83')))
   //      // {
   //      //     $sql .= '';
   //      // }else
   //      // {
   //      //     $sql .= " AND  tl.status !='9'";
   //      // }


   //     if($cons == 'nonactive') { 
   //          $sql .= " AND tl.status = '9' ";
   //      } elseif($cons == 'active') { 
   //          $sql .= " AND tl.status !='9'";
   //      }else {
   //          $sql .= " ";
   //      }



  	// 	$i = 0;
     
   //      foreach ($this->column_search as $item) // loop column
   //      { 
   //          if($_POST['search']['value']) // if datatable send POST for search
   //          {
   //              if($i===0) // first loop
   //              {
   //                  //$sql .= $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
   //                  //$sql .= $this->db->like($item, $_POST['search']['value']);
   //                  // if(in_array($position_id, array('1','2','77', '5', '9', '3', '83')) OR $_SESSION['myuser']['role_id'] == '15') {
   //                  //   $sql .= " WHERE (".$item." LIKE '%".$_POST['search']['value']."%'";
   //                  // }else {
   //                    $sql .= " AND (".$item." LIKE '%".$_POST['search']['value']."%'";
   //                  // }
                    
   //              }
   //              else
   //              {
   //                  //$sql .=$this->db->or_like($item, $_POST['search']['value']);
   //                  $sql .= " OR ".$item." LIKE '%".$_POST['search']['value']."%'";
   //              }
 
   //              if(count($this->column_search) - 1 == $i) //last loop
   //                  //$sql .= $this->db->group_end(); //close bracket
   //                  $sql .= " ) ";
   //          }
   //          $i++;
   //      }

   //      $sql .= " GROUP BY tl.id";

   //      if(isset($_POST['order'])) // here order processing
   //      {
   //         //$sql .= $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
   //          //if($cons == 'Deal') {
   //          //    $column_order = array(null,'tl.date_closed','tl.id','tl.date_created','perusahaan', null, 'progress', 'deal_value', 'last_followup', null);
   //         // }
   //          $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." ";
   //      }
   //      else if(isset($this->order))
   //      {
   //          $order = $this->order;
   //          //$sql .= $this->db->order_by(key($order), $order[key($order)]);

   //          //if($cons != '') {
   //          //    $order = array('tl.date_closed' => 'DESC');
   //         // }

   //          $sql .= " ORDER BY ".key($order)." ".$order[key($order)]."";
   //      }

   //      return $sql;
  	// }


     public function __ListTools($cons='') 
    {
      $user = $_SESSION['myuser']['karyawan_id'];
      $position_id = $_SESSION['myuser']['position_id'];
      $cabang = $_SESSION['myuser']['cabang'];
      $div = $_SESSION['myuser']['position'];
      $div = substr($div, -3);


      $sql = "SELECT tl.last_update,tl.id, tl.code, tl.name, tl.quantity,tl.notes,  up.file_name, up.type as upl_type, kr.cabang, lg.nickname, ty.type as st_type
          FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN tbl_karyawan as kr ON kr.id = ho.user_holder
          LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
          ";

      // if(in_array($position_id, array('1','2','77', '5', '9', '3', '83','106','14')) OR $_SESSION['myuser']['role_id'] == '15') {
      //     $sql .= " WHERE tl.published='0'";
      // }
      // elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18','134'))){
      //   $sql .= " WHERE kr.cabang = '$cabang' AND published='0'";
      // }
      // elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93', '100'))) {
      //   $sql .= "  WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = '') OR (lg.role_id = 4 AND ps.position like '%$div%')) AND tl.published='0'";
      // }
      // elseif ($position_id == '13') {
      //   $sql .= " WHERE ps.id IN ('13', '102') AND tl.published='0'";
      // }
      // elseif ($position_id == '73') {
      //   $sql .= " WHERE lg.role_id = '12' AND tl.published='0'";
      // }
      // elseif ($position_id == '30') {
      //   $sql .= " WHERE lg.role_id = '4 AND tl.published='0''";
      // }
      // else{
      //   $sql .= " WHERE ho.user_holder = '$user' AND tl.published='0' ";
      // }

       if($cons == 'nonactive') { 
            $sql .= "WHERE tl.status = '9' ";
        } elseif($cons == 'active') { 
            $sql .= "WHERE tl.status !='9'";
        } elseif($cons == 'Medan') { 
            $sql .= "WHERE kr.cabang ='Medan'";
        } elseif($cons == 'Jakarta') { 
            $sql .= "WHERE kr.cabang ='Jakarta'";
        } elseif($cons == 'Semarang') { 
            $sql .= "WHERE kr.cabang ='Semarang'";
        } elseif($cons == 'Cikupa') { 
            $sql .= "WHERE kr.cabang ='Cikupa'";
        } elseif($cons == 'Bandung') { 
            $sql .= "WHERE kr.cabang ='Bandung'";
        }else {
            $sql .= " ";
        }



      $i = 0;
     
        foreach ($this->column_search as $item) // loop column
        { 
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    //$sql .= $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    //$sql .= $this->db->like($item, $_POST['search']['value']);
                    if(in_array($position_id, array('1','2','77', '5', '9', '3', '83')) OR $_SESSION['myuser']['role_id'] == '15') {
                      $sql .= " AND (".$item." LIKE '%".$_POST['search']['value']."%'";
                    }else {
                      $sql .= " AND (".$item." LIKE '%".$_POST['search']['value']."%'";
                    }
                    
                }
                else
                {
                    //$sql .=$this->db->or_like($item, $_POST['search']['value']);
                    $sql .= " OR ".$item." LIKE '%".$_POST['search']['value']."%'";
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    //$sql .= $this->db->group_end(); //close bracket
                    $sql .= " ) ";
            }
            $i++;
        }

        $sql .= " GROUP BY tl.id";

        if(isset($_POST['order'])) // here order processing
        {
           //$sql .= $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            //if($cons == 'Deal') {
            //    $column_order = array(null,'tl.date_closed','tl.id','tl.date_created','perusahaan', null, 'progress', 'deal_value', 'last_followup', null);
           // }
            $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." ";
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            //$sql .= $this->db->order_by(key($order), $order[key($order)]);

            //if($cons != '') {
            //    $order = array('tl.date_closed' => 'DESC');
           // }

            $sql .= " ORDER BY ".key($order)." ".$order[key($order)]."";
        }

        return $sql;
    }

    function get_datatables($cons)
    {
        $sql = $this->__ListTools($cons);

        // print_r($sql);die;

        if($_POST['length'] != -1)
          
                $sql .= " LIMIT ".$_POST['start'].",".$_POST['length'];

                $query = $this->db->query($sql);    

        return $query->result();
    }

 
    function count_filtered($cons)
    {
        $sql = $this->__ListTools($cons);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
 
    public function count_all($cons)
    {
        $sql = $this->__ListTools($cons);
        $query = $this->db->query($sql);
        return $query->num_rows();
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

        }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18','134'))){ // WL42182

          $sql .= " WHERE kr.cabang = '$cabang'";

        }elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93','100'))) {

         $sql .= " WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = 'Jakarta') OR (lg.role_id = 4 AND ps.position like '%$div%'))";

        }elseif ($position_id == '13') {

         $sql .= " WHERE kr.position_id IN ('13', '102')";

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

      $sql = "SELECT tl.id, tl.code, tl.name, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          GROUP BY tl.id DESC";

      if(in_array($position_id, array('1','2','77', '5', '9', '3', '83')) OR $_SESSION['myuser']['role_id'] == '15') {
      $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
          LEFT JOIN tbl_tools_kill as ki ON ki.tool_id = tl.id
          LEFT JOIN tbl_tools_type as ty ON ty.id = tl.status
          LEFT JOIN (SELECT tool_id, max(date_created) as mx FROM tbl_tools_approval GROUP BY tool_id) maxdate ON tl.id = maxdate.tool_id
          LEFT JOIN tbl_tools_approval as ap ON maxdate.tool_id = ap.tool_id AND maxdate.mx = ap.date_created
          LEFT JOIN tbl_loginuser as lap ON ap.user_approval = lap.karyawan_id
          GROUP BY tl.id DESC";

      }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18','134'))){ // WL42182
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
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
       $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
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
          WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = 'Jakarta') OR (lg.role_id = 4 AND ps.position like '%$div%'))
          GROUP BY tl.id DESC";

      }elseif ($position_id == '13') {
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
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
        $sql = "SELECT tl.*, up.file_name, up.type as upl_type, lg.nickname, ki.status as sts_kill, ty.type as st_type, ho.user_holder, ap.status_approval, lap.nickname as name_approval, ap.date_approval, appr_notes, ap.id as app_id, ap.tool_id as tool_ap, tl.quantity, tl.approval_id FROM tbl_tools as tl
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

  	public function getPhotoTools($id,$log,$type)
  	{
  		$sql = "SELECT file_name FROM tbl_upload_tools WHERE type = '$type' AND tool_id = '$id' AND status = '0' AND log_tool_id = '$log' ORDER BY id ASC";
  		$que = $this->db->query($sql)->result_array();

  		return $que;
  	}


    public function getPhoto($id)
    { // new pipit 20201112
      $sql = "SELECT * from tbl_upload_tools 
              where tool_id = '$id' AND log_tool_id = 
                (select log_tool_id from tbl_upload_tools 
                  where tool_id = '$id' order by log_tool_id 
                  ASC limit 1)";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

    public function getPhotolast($id)
    { // new pipit 20201112
      
      /*$sql ="SELECT * FROM tbl_upload_tools tls
             LEFT JOIN tbl_tools_log tl ON tls.log_tool_id = tl.id
             WHERE tls.tool_id='$id' ORDER BY tls.id DESC ";*/

      $sql = "SELECT * from tbl_upload_tools 
              where tool_id = '$id' AND log_tool_id = 
                (select log_tool_id from tbl_upload_tools 
                  where tool_id = '$id' order by log_tool_id 
                  desc limit 1)";
      $res = $this->db->query($sql)->result_array();


      return $res;
    }

  	// public function detailsTool($id)
  	// {
  	// 	$sql = "SELECT tl.*, up.file_name, up.type as type_upload, tltype.type as sttype, ho.user_holder, apr.lvl_approval, apr.status_approval FROM tbl_tools as tl
  	// 			LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
  	// 			LEFT JOIN tbl_tools_type as tltype ON tltype.id = tl.status
   //        LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
   //        LEFT JOIN tbl_tools_approval as apr ON apr.id = tl.approval_id
  	// 			WHERE tl.id = '$id'";
  	// 	$res = $this->db->query($sql)->row_array();


  	// 	return $res;
  	// }

    public function detailsTool($id)
    {
      $sql = "SELECT tl.*, up.file_name, up.type as type_upload, tltype.type as sttype, ho.user_holder, apr.lvl_approval, apr.status_approval FROM tbl_tools as tl
          LEFT JOIN tbl_upload_tools as up ON (up.tool_id = tl.id AND up.type = '0' AND up.status = '0')
          LEFT JOIN tbl_tools_type as tltype ON tltype.id = tl.status
          LEFT JOIN tbl_tools_holder as ho ON ho.tool_id = tl.id
          LEFT JOIN tbl_tools_approval as apr ON apr.id = tl.approval_id
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


      if(in_array($position_id, array('1','2','77', '9', '83', '3','14')) OR $_SESSION['myuser']['role_id'] == '15') {
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE too.published = 0 AND kr.published  ='1'
              GROUP BY user_holder";

      }elseif (in_array($position_id, array('55', '56', '57', '58', '59', '95', '60', '62', '75', '18','134'))){ // WL42182
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE kr.cabang = '$cabang' AND too.published = 0
              GROUP BY user_holder";

      }elseif (in_array($position_id, array('88', '89', '90', '91', '92', '93','100'))) {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE (((ps.position = 'Sales $div' OR ps.position = 'Leader Sales $div') AND kr.cabang = 'Jakarta') OR (lg.role_id = 4 AND ps.position like '%$div%')) AND too.published = 0
              GROUP BY user_holder";

      }elseif ($position_id == '13') {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE kr.position_id IN ('13','102') AND too.published = 0
              GROUP BY user_holder";

      }elseif ($position_id == '73') {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE lg.role_id = 12 AND too.published = 0
              GROUP BY user_holder";
      
      }elseif ($position_id == '30') {
       $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE lg.role_id = 4 AND too.published = 0
              GROUP BY user_holder";

      }else {
        $sql = "SELECT ho.*, count(ho.tool_id) as jml_tools, lg.nickname, ps.position, sum(too.price) as ttl_price, too.date_created as date_tool
              FROM tbl_tools_holder as ho
              LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = ho.user_holder
              LEFT JOIN tbl_karyawan as kr ON kr.id = lg.karyawan_id
              LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
              LEFT JOIN tbl_tools as too ON too.id = ho.tool_id
              WHERE user_holder = '$user' AND too.published = 0
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
      $pos_id = $_SESSION['myuser']['position_id'];

        if(in_array($pos_id, array('1','2','83')))
        {
           $status = '';
        }else
        {
           $status = "AND  tl.status !='9'";
        }

      $sql = "SELECT count(ho.tool_id) as jml_tools, sum(tl.price) as total_harga, AVG(TIMESTAMPDIFF(SECOND, tl.date_purchased, CURDATE())) AS umur, kar.nama, count(los.tool_id) as tool_loss, sum(too.price) as price_loss, COUNT(kil.tool_id) as tool_kill, SUM(tok.price) as price_kill
        FROM tbl_tools_holder as ho 
        LEFT JOIN tbl_tools as tl ON tl.id = ho.tool_id
        LEFT JOIN tbl_karyawan as kar ON kar.id = ho.user_holder
        LEFT JOIN tbl_tools_loss as los ON los.tool_id = tl.id
        LEFT JOIN tbl_tools_kill as kil ON kil.tool_id = ho.id
        LEFT JOIN tbl_tools as too ON too.id = los.tool_id
        LEFT JOIN tbl_tools as tok ON tok.id = kil.tool_id
        WHERE ho.user_holder = '$user' AND tl.published = 0 $status";
      $res = $this->db->query($sql)->row_array();

      return $res;
    }

    // public function table_details_holder($user) 
    // {
    //     $pos_id = $_SESSION['myuser']['position_id']; 

    //     if(in_array($pos_id, array('1','2','83')))
    //     {
    //        $status = '';
    //     }else
    //     {
    //        $status = "AND  tl.status !='9'";
    //     }

    //   $sql = "SELECT tl.*, upt.file_name, ho.date_created as date_holder FROM tbl_tools_holder as ho
    //           LEFT JOIN tbl_tools as tl ON tl.id = ho.tool_id
    //           LEFT JOIN tbl_upload_tools as upt ON (upt.tool_id = ho.tool_id AND upt.type = '0' AND upt.status = '0')
    //           WHERE ho.user_holder = '$user' AND tl.published = 0 $status
    //           GROUP BY tl.id ASC";
    //   $res = $this->db->query($sql)->result_array();
     

    //   return $res;
    // }


    public function table_details_holder($user) 
    {
        $pos_id = $_SESSION['myuser']['position_id']; 

        if(in_array($pos_id, array('1','2','83')))
        {
           $status = '';
        }else
        {
           $status = "AND  tl.status !='9'";
        }
       

       $sql = "SELECT tl.*, kr.cabang, upt.file_name, ho.date_created as date_holder FROM tbl_tools_holder as ho
              LEFT JOIN tbl_tools as tl ON tl.id = ho.tool_id
              LEFT JOIN tbl_upload_tools as upt ON (upt.tool_id = ho.tool_id AND upt.type = '0' AND upt.status = '0')
              LEFT JOIN tbl_karyawan as kr ON kr.id = $id
              WHERE ho.user_holder = '$id' $status
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

    public function getDiscuss($id)
    {
      $sql = "SELECT di.*, lg.nickname FROM tbl_tools_discussion di
              LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = di.user 
              WHERE di.tool_id = '$id'";
      $res = $this->db->query($sql)->result_array(); 

     
      return $res;
    }

    // public function getApproval($id)
    // {
    //   $sql = "SELECT apr.action,apr.id, lvl_approval, status_approval, user_create, user_penerima, user_pemberi, action_id, action FROM tbl_tools_approval apr
    //           LEFT JOIN tbl_tools_handover as ho ON (ho.id = apr.action_id AND apr.action = 'handover')
    //           WHERE apr.tool_id = '$id' AND apr.action ='handover' GROUP BY apr.id DESC LIMIT 1";
    //   $res = $this->db->query($sql)->row_array(); 


    //   return $res;      
    // }

    public function getApproval($id)
    {
      $sql = "SELECT apr.action,apr.id, lvl_approval, status_approval, user_create,user_approval, user_penerima, kar.nama, user_pemberi, action_id, action FROM tbl_tools_approval apr
              LEFT JOIN tbl_tools_handover as ho ON (ho.id = apr.action_id AND apr.action = 'handover')
              LEFT JOIN tbl_karyawan as kar ON kar.id = apr.user_approval
              WHERE apr.tool_id = '$id' AND apr.action ='handover' GROUP BY apr.id DESC LIMIT 1";
      $res = $this->db->query($sql)->row_array(); 

      return $res;      
    }

    public function getApprovalKill($id)
    {
      $sql = "SELECT apr.id, lvl_approval, status_approval, user_create, action_id, action, ho.user_acc,ho.id as kill_id FROM tbl_tools_approval apr
              LEFT JOIN tbl_tools_kill as ho ON (ho.id = apr.action_id AND apr.action = 'kill')
              WHERE apr.tool_id = '$id'AND apr.action ='kill' GROUP BY apr.id DESC LIMIT 1";
       
      $res = $this->db->query($sql)->row_array(); 

      return $res ;      
    }


    public function getleader($id)
    {
      $sql ="SELECT * FROM tbl_tools_holder WHERE tool_id='$id' ORDER BY id DESC";
      $res= $this->db->query($sql)->row_array();
      $holder = $res['user_holder'];

      $sql="SELECT id,head_division FROM tbl_karyawan WHERE id='$holder'";
      $re = $this->db->query($sql)->row_array();
   
      return $re;

    }

    // public function getholder($id)
    // { // new pipit 20201112
    //     $sql="SELECT hldr.user_holder, krw.nama, ps.position, krw.nik FROM tbl_tools_holder hldr 
    //           LEFT JOIN tbl_karyawan krw ON krw.id = hldr.user_holder
    //           LEFT JOIN tbl_position ps ON ps.id = krw.position_id
    //            WHERE tool_id='$id'";
    //     $res= $this->db->query($sql)->row_array();

    //     return $res;
    // }

    public function getholder($id)
    {
      $sql="SELECT hldr.user_holder, hldr.tool_id, krw.nama,krw.cabang, krw.nik, pst.position FROM tbl_tools_holder hldr 
      LEFT JOIN tbl_karyawan krw ON krw.id = hldr.user_holder
      LEFT JOIN tbl_position pst ON pst.id = krw.position_id
       WHERE tool_id='$id'";
        $res= $this->db->query($sql)->row_array();

        return $res;
    }

     public function getReportbensin($id)
    {
      $sql ="SELECT pr.*,lgn.nickname FROM tbl_record_kendaraan_perusahaan pr
             LEFT JOIN tbl_kar_kendaraan kend ON kend.id = pr.kendaraan_id
             LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = pr.user
             WHERE kend.tools_id='$id' ORDER BY pr.date_created ASC";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }

  	public function NewTool()
  	{ 
  		if($this->input->post()) 
      {
        $sess = $_SESSION['myuser'];
        $sales = substr($sess['position'], 0, 5);
        $div = substr($sess['position'], -3);

  			$date        = date('Y-m-d H:i:s');
  			$code_asset  = $this->input->post('kode_asset');
  			$name 		   = $this->input->post('name_tool');
  			$sn 		     = $this->input->post('s_num');
  			$type		     = $this->input->post('type');
  			$vendor		   = $this->input->post('vendor');
  			$brand		   = $this->input->post('brand');
  			$pr_date 	   = $this->input->post('purchased_date');
  			$pr_date 	   = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $pr_date);
  			$harga		   = $this->input->post('harga');
  			$harga		   = str_replace(".", "", $harga);
  			$mn_book	   = $this->input->post('manual_book');
  			$condition	 = $this->input->post('condition');
  			$warr_due	   = $this->input->post('warranty_date');
  			$phone 		   = $this->input->post('sc_phone');
  			$notes		   = $this->input->post('notes');
        $holder      = $this->input->post('holder');
        $kar         = $_SESSION['myuser']['karyawan_id'];
        // $qty         = $this->input->post('quantity');
        $item_id     = $this->input->post('item_id');
        $date_reminder  = date("Y-m-d", strtotime("+ 2 MONTH"));

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
          'last_report' => date('Y-m-d'),
          'reminder_report' => $date_reminder,
          // 'quantity'    => $qty,
  				);
  			$this->db->insert('tbl_tools', $addtool);
  			$id_tool = $this->db->insert_id();


        $upd = array(
                'tool_id' => $id_tool,
                'date_tf_holder' =>date('Y-m-d H:i:s'),
                'user_transfer' => $_SESSION['myuser']['karyawan_id'],
              );
        $this->db->where('id', $item_id);
        $this->db->update('tbl_pr_vendor', $upd);

        $addholder = array(
          'tool_id'       => $id_tool,
          'user_holder'   => $holder,
          'date_created'  => date('Y-m-d H:i:s'),
          );
        $this->db->insert('tbl_tools_holder', $addholder);

        if($sess['karyawan_id'] == $holder && in_array($sess['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '95','134')))  // WL42182
        {

        }elseif($sess['karyawan_id'] == $holder) 
        {

            // if($sess['cabang'] == 'Medan') 
            // {
            //   $pos = '56';
            // }elseif($sess['cabang'] == 'Surabaya') 
            // {
            //   $pos = '95';
            // }elseif ($sess['cabang'] == 'Bandung') 
            // {
            //   $pos = '57';
            // }elseif ($sess['cabang'] == 'Cikupa') 
            // {
            //   $pos = '58';
            // }elseif (in_array($sess['position_id'], array('5','7','8','9','11','12','76'))) 
            // {
            //   $pos = '77';
            // }elseif ($sess['cabang'] == $sales) 
            // {
            //   $leader = 'Leader Sales '.$div;
            //   $sql = "SELECT id FROM tbl_position WHERE position like '%$leader%'";
            //   $pos = $this->db->query($sql)->row_array();
            //   $pos = $pos['id'];
            // }else {
            //   $pos = '2';
            // }
            //   $sql = "SELECT lg.karyawan_id FROM tbl_loginuser lg LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id WHERE kr.position_id = '$pos' AND lg.published = 1 AND kr.published = 1";
            //   $kar = $this->db->query($sql)->row_array();
            //   $kar = $kar['karyawan_id'];

        }elseif($sess['karyawan_id'] != $holder) 
        {
          $approve =  array(
            'tool_id' => $id_tool,
            'user_create' => $sess['karyawan_id'],
            'user_approval' => $holder,
            'date_created'  => $date,
            );
         $this->db->insert('tbl_tools_approval', $approve);
         $id_appr = $this->db->insert_id();

         $this->notification($id_tool, $id_appr, '13', $holder);

        }

        $args = array(
          'tool_id'   => $id_tool,
          'kondisi'   => $condition,
          'user_report' => $holder,
          'date_created'  => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tbl_tools_report', $args);
        $id_rep = $this->db->insert_id();

  			// $this->uploadfile($id_tool, '0', 'phtuserfile');
  			// $this->uploadfile($id_tool, '1', 'warruserfile');
  			// $this->uploadfile($id_tool, '2', 'acsuserfile');
        
  			$log_tool = $this->log_tool($id_tool, '5', $id_rep);


        $this->uploadfile($id_tool,'1','utama',$log_tool);
        $this->uploadfile($id_tool,'1','warranty',$log_tool);
        $this->uploadfile($id_tool,'1','acsuserfile',$log_tool);
        $this->uploadfile($id_tool,'1','depan',$log_tool);
        $this->uploadfile($id_tool,'1','kiri',$log_tool);
        $this->uploadfile($id_tool,'1','kanan',$log_tool);
        $this->uploadfile($id_tool,'1','atas',$log_tool);

  			$this->logAll($id_tool, '1', $id_tool, 'tbl_tools', $condition);

  		$login = array(
				'code'	=> $code,
				'name'	=> $name,
			);
			$this->session->set_flashdata('newtool', $login);
  		}
  	}

    public function UpdateTool()
    {

      if($this->input->post()) {
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
        $psn = '';  
        // $qty = $this->input->post('quantity');
        // 
        
        $sql ="SELECT * FROM tbl_tools WHERE id='$id_tool'";
        $re= $this->db->query($sql)->row_array();

        $code_old = $re['code'];
        $code_asset_old = $re['code_asset'];
        $name_old = $re['name'];
        $type_old = $re['type'];
        $serial_number_old = $re['serial_number'];
        $brand_old = $re['brand'];
        $vendor_old = $re['vendor'];
        $price_old = $re['price'];
        $pr_date_old = $re['date_purchased'];
        $condition_old = $re['tool_condition_old'];
        $mn_book_old = $re['manual_book'];
        $warr_due_old = $re['warranty_due'];
        $phone_old = $re['phone'];
        $notes_old = $re['notes'];


        if($code_old != $code)
        {
            $psn .= "update code tools from ".$code_old." To ".$code."<br>";
        }

        if($code_asset_old != $code_asset)
        {
            $psn .= "update code asset tools from ".$code_asset_old." To ".$code_asset."<br>";
        }

        if($name_old != $name)
        {
          $psn .= "update name tools from ".$name_old." To ".$name."<br>";
        }

        if($type_old != $type)
        {
          $psn .= "update type tools from ".$type_old." To ".$type."<br>";
        }

        if($serial_number_old != $sn)
        {
          $psn .= "update serial number tools from ".$serial_number_old." To ".$sn."<br>";
        }

        if($brand_old != $brand)
        {
          $psn .= "update brand tools from ".$brand_old." To ".$brand."<br>";
        }

        if($vendor_old != $vendor)
        {
          $psn .= "update vendor tools from ".$vendor_old." To ".$vendor."<br>";
        }

        if($price_old != $harga)
        {
           $psn .= "update price tools from ".$price_old." To ".$harga."<br>";
        }

        if($pr_date_old != $pr_date)
        {
          $psn .= "update date purchase tools from ".$pr_date_old." To ".$pr_date."<br>";
        }

        if($condition_old != $condition)
        {
           $psn .= "update condition tools from ".$condition_old." To ".$condition."<br>";
        }

        if($mn_book_old != $mn_book)
        {
          $psn .= "update Manual Book tools from ".$mn_book_old." To ".$mn_book."<br>";
        }

        if($warr_due_old != $warr_due)
        {
          $psn .= "update warranty due tools from ".$warr_due_old." To ".$warr_due."<br>";
        }

        if($phone_old != $phone)
        {
          $psn .= "update Phone tools from ".$phone_old." To ".$phone."<br>";
        }

        if($notes_old != $notes)
        {
           $psn .= "update notes tools from ".$notes_old." To ".$notes."<br>";
        }




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
          // 'quantity'    => $qty,
          );
        $this->db->where('id', $id_tool);
        $this->db->update('tbl_tools', $addtool);

        if($holder) {
          if($sess['karyawan_id'] == $holder && in_array($sess['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '95','134'))) {

          }elseif($sess['karyawan_id'] == $holder) {
            if($sess['cabang'] == 'Medan') {
              $pos = '56';
            }elseif($sess['cabang'] == 'Surabaya') {
              $pos = '95';
            }elseif ($sess['cabang'] == 'Bandung') {
              $pos = '57';
            }elseif ($sess['cabang'] == 'Cikupa') {
              $pos = '58';
            }elseif ($sess['cabang'] == 'Semarang') {
              $pos = '134';
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

          }
        }

        $this->uploadfile($id_tool, '0', 'phtuserfile');
        $this->uploadfile($id_tool, '1', 'warruserfile');
        $this->uploadfile($id_tool, '2', 'acsuserfile');

        $this->logAll($id_tool, '3', $id_tool, 'tbl_tools', $user);

        if($psn !='')
        {
         $insert = array(
              'tool_id'       => $id_tool,
              'discuss'       => $psn,
              'date_created'  => date('Y-m-d H:i:s'),
              'user'          => $_SESSION['myuser']['karyawan_id'],
              );
          $this->db->insert('tbl_tools_discussion', $insert);
          $psn_id = $this->db->insert_id();
        }

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

        $date_reminder  = date("Y-m-d", strtotime("+".$reminder."days"));

        $rep = array('last_report' => date('Y-m-d'),'reminder_report' => $date_reminder);
        $this->db->where('id', $id);
        $this->db->update('tbl_tools',$rep );

  			$log_tool_id = $this->log_tool($id, '5', $id_report);

  			$this->uploadfile($id, '5', 'repuserfile', $log_tool_id);

  			$this->logAll($id, '1', $id_report, 'tbl_tools_report', $condition);


  		}
  	}

    private function notifHandOver($id, $id_handover, $penerima, $action, $lvl_approval = '')
    {
      $pos_id = $_SESSION['myuser']['position_id'];
      $cabang = $_SESSION['myuser']['cabang'];
      $psn = "";

      $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$penerima'";
      $que = $this->db->query($sql)->row_array($sql);

      $nickname = $que['nickname'];

      if($lvl_approval == 'leader') {     
        $kar = $penerima;
        $lvl_approval = 'kar'; 

        $psnapr = "Waiting for <b>".$nickname."</b> Approval.";

      }else {
        $psn = "Hand Over to <b>".$nickname."</b>.<br />";
        if(($cabang != 'Jakarta') AND !in_array($pos_id, array('55', '56', '57','58','134'))) { // WL42182

            switch ($cabang) {
              case 'Bandung':
                $position_id = '57';
                break;

              case 'Medan': 
                $position_id = '56';
                break;

              case 'Surabaya':
                $position_id = '55';
                break;

              case 'Cikupa':
                $position_id = '58';
                break; 

              case 'Semarang':
                $position_id = '134'; // WL42182
                break;          
            }

          $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
          $que = $this->db->query($sql)->row_array();
          $kar = $que['id'];

          $lvl_approval = 'leader';
          $psnapr = "Waiting for Leader Approval.";
        
        }elseif (in_array($pos_id, array('65','66','67','68','71','103','102','105'))) { //staff jkt
          switch ($pos_id) {
              case '68':
                  $position_id = '90';
                  break;
              case '67':
                  $position_id = '93'; 
                  break;
              case '65':
                  $position_id = '88'; 
                  break;
              case '71':
                  $position_id = '91'; 
                  break;
              case '66':
                  $position_id = '89'; 
                  break;
              case '103':
                  $position_id = '91'; //100
                  break;    
              case '102':
                  $position_id = '13'; 
                  break;    
               case '105':
                  $position_id = '89'; 
                  break;                        
          }

          $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
          $que = $this->db->query($sql)->row_array();
          $kar = $que['id'];

          $lvl_approval = 'leader';
          $psnapr = "Waiting for Leader Approval.";

        }elseif(in_array($pos_id, array('55', '56', '57','58','1','2','88','89','90','91','93','100','13','14'))) { // WL42182
          $kar = $penerima;
          $lvl_approval = 'kar';
          $psnapr = "Waiting for <b>".$nickname."</b> Approval.";
        
        }else {
          $position_id = '2'; 

          $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
          $que = $this->db->query($sql)->row_array();
          $kar = $que['id'];

          $lvl_approval = 'leader';
          $psnapr = "Waiting for Leader Approval.";
        }
      }

      $this->notification($id, $id_handover, '13', $kar);

      $approve =  array(
          'tool_id' => $id,
          'user_create' => $_SESSION['myuser']['karyawan_id'],
          'date_created'  => date('Y-m-d H:i:s'),
          'lvl_approval'  => $lvl_approval,
          'action'        => $action,
          'action_id'     => $id_handover,
          );
      $this->db->insert('tbl_tools_approval', $approve);
      $approval_id = $this->db->insert_id();

      $this->db->where('id', $id);
      $this->db->update('tbl_tools', array('approval_id' => $approval_id));

      $psn .= $psnapr;
      $this->addDiscuss($id,  $psn);
        
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
            $user_holder = $this->input->post('user_holder');
            $pos_id      = $sess['position_id'];
            $cabang      = $sess['cabang'];   
        
        $args = array(
          'tool_id'       => $id,
          'user_pemberi'  => $user,
          'user_penerima' => $penerima,
          'notes'         => $ket,
          'date_created'  => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tbl_tools_handover', $args);
        $id_handover = $this->db->insert_id();


        $this->notifHandOver($id, $id_handover, $penerima, 'handover');
        

     //    //$this->notification($id, $id_handover, '11', $penerima);
  			// $this->logAll($id, '1', $id_handover, 'tbl_tools_handover', '');

        // if($sess['karyawan_id'] != $penerima) {
        //   $approve =  array(
        //     'tool_id' => $id,
        //     'user_create' => $sess['karyawan_id'],
        //     'user_approval' => $penerima,
        //     'date_created'  => date('Y-m-d H:i:s'),
        //     );
        // $this->db->insert('tbl_tools_approval', $approve);
        // $id_appr = $this->db->insert_id();

        // $this->notification($id, $id_appr, '13', $user_holder);

        // }

        //approval tools ke leader, lalu approval ke penerima tools jika antar karyawan handover tools.
        //approval tools ke penerima saja bila leader HO tools ke penerima.

        //notifikasi akan terhapus bila penerima mengkonfirmasi tools tsb diterima / ditolak.
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

  	// public function KillTools()
  	// {

  	// 	if($this->input->post()) {
  	// 		$id 		         = $this->input->post('id_tool');
  	// 		$notes 		       = $this->input->post('notes');
  	// 		$user 		       = $_SESSION['myuser']['karyawan_id'];
   //      $position_id     = $_SESSION['myuser']['position_id'];
   //      $cabang          = $_SESSION['myuser']['cabang'];

   

  	// 		$add_kill = array(
  	// 		'tool_id'	=> $id,
  	// 		'user_kill'	=> $user,
  	// 		'status'	=> '0',
  	// 		'date_created'	=> date('Y-m-d H:i:s'),
  	// 		'notes'	=> $notes,
  	// 		);
  	// 		$this->db->insert('tbl_tools_kill', $add_kill);
  	// 		$kill_id = $this->db->insert_id();

  	// 		$this->uploadfile($id, '8', 'killuserfile');

   //      $up_status = array( 'status'  => '8');
   //      $this->db->where('id', $id);
   //      $this->db->update('tbl_tools', $up_status);

  	// 		$this->log_tool($id, '8', $kill_id);


   //      $this->notifKillTools($id, $kill_id,'Kill Tools');
   //      $this->logAll($id, '1', $kill_id, 'tbl_tools_kill', '');

  	// 	}
  	// }

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
          
          $id       = $this->input->post('tool_id');
          $note     = $this->input->post('notes');
          $user_app = $_SESSION['myuser']['karyawan_id'];
          $nickname = $_SESSION['myuser']['nickname'];
          $cabang   = $_SESSION['myuser']['cabang'];
          $pos_id   = $_SESSION['myuser']['position_id'];
          
          $getappr  = $this->getApproval($id);
          $app_id   = $getappr['id'];
          $act_id   = $getappr['action_id'];
          $lvl      = $getappr['lvl_approval'];  
          $action   = $getappr['action'];
          $receiver = $getappr['user_penerima'];
          $recent   = $getappr['user_pemberi'];

          $sql = "SELECT position_id FROM tbl_karyawan WHERE id = '$recent'";
          $que = $this->db->query($sql)->row_array();
          $leader_pos = $que['position_id'];

          if($lvl == 'leader') {    
            $msg = "Handover <span style='color : green;'>Approved</span> by <b>".$nickname."</b>.<br />Notes : ".$note;
            $this->addDiscuss($id, $msg);
            
            $this->notifHandOver($id, $act_id, $receiver, $action, 'leader');

          }elseif($lvl == 'kar') {

            $date_reminder  = date("Y-m-d", strtotime("+".$reminder."days"));

            switch ($action) {
              case 'handover':
                $holder = array(
                  'user_holder'   => $user_app,
                  'date_created'  => date('Y-m-d H:i:s'),
                  );
                $this->db->where('tool_id', $id);
                $this->db->update('tbl_tools_holder', $holder);

                $upstatus = array( 'status' => '6' ,'reminder_report' => $date_reminder,'last_report'=> date('Y-m-d'));
                $this->db->where('id', $id);
                $this->db->update('tbl_tools', $upstatus);

                $this->db->where('id',$act_id);
                $this->db->update('tbl_tools_handover', array('approval' => '1'));

                $log_id = $this->log_tool($id, '6', $act_id);

                $this->uploadfile($id, '6', 'handuserfile', $log_id);

                $sql="SELECT * FROM tbl_kar_kendaraan WHERE tools_id='$id'";
                $kend = $this->db->query($sql)->row_array();

                $kendaraan_id = $kend['id'];

                $this->db->where('id', $kendaraan_id);
                $this->db->update('tbl_kar_kendaraan', array('karyawan_id' => $user_app));


                break;
            }

            $msg = "Handover Tool <span style='color : green;'>Approved</span> by <b>".$nickname."</b>.<br /> Notes : ".$note;
            $this->addDiscuss($id, $msg);

            $this->db->where('modul', '4');
            $this->db->where('modul_id', $id);
            $this->db->where('record_id', $act_id);
            $this->db->update('tbl_notification', array('status' => '1'));
            
            if(in_array($pos_id, array('55', '56', '57','58','134','1','2','88','89','90','91','93','100','13','14')) OR in_array($leader_pos, array('55', '56', '57','58','1','2','88','89','90','91','93','100','13','14')))
            {

            }else {
            
              if(($cabang != 'Jakarta' AND $cabang != 'Jakarta') AND !in_array($pos_id, array('55', '56', '57','58','134'))) {
                switch ($cabang) {
                  case 'Bandung':
                    $position_id = '57';
                    break;

                  case 'Medan': 
                    $position_id = '56';
                    break;

                  case 'Surabaya':
                    $position_id = '55';
                    break;

                  case 'Cikupa':
                    $position_id = '58';
                    break;

                  case 'Semarang':
                    $position_id = '134'; // WL42182
                    break;   
                }             
              }elseif (in_array($pos_id, array('65','66','67','68','71','103','102','105'))) { //staff jkt
                switch ($pos_id) {
                    case '68':
                        $position_id = '90';
                        break;
                    case '67':
                        $position_id = '93'; 
                        break;
                    case '65':
                        $position_id = '88'; 
                        break;
                    case '71':
                        $position_id = '91'; 
                        break;
                    case '66':
                        $position_id = '89'; 
                        break;
                    case '103':
                        $position_id = '91'; //100
                        break;    
                    case '102':
                        $position_id = '13'; 
                        break;   
                    case '105':
                        $position_id = '89'; 
                        break;                        
                }
              }else {
                $position_id = '2'; 
              }

              $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
              $que = $this->db->query($sql)->row_array();
              $leader = $que['id'];

              $this->notification($id, $app_id, '29', $leader);
            }
          }  
          $this->notification($id, $app_id, '29', $recent);

          $updt = array(
            'status_approval' => '1',
            'date_approval'   => date('Y-m-d H:i:s'),
            'user_approval'   => $user_app,
            'appr_notes'      => $note,
            );
          $this->db->where('id', $app_id);
          $this->db->update('tbl_tools_approval', $updt);
          
        }
      }

      public function Rejected()
      {
        if($this->input->post()) {
          $id       = $this->input->post('tool_id');
          $note     = $this->input->post('notes');
          $user_app = $_SESSION['myuser']['karyawan_id'];
          $nickname = $_SESSION['myuser']['nickname'];
          $cabang   = $_SESSION['myuser']['cabang'];
          $pos_id   = $_SESSION['myuser']['position_id'];
          
          $getappr  = $this->getApproval($id);
          $app_id   = $getappr['id'];
          $act_id   = $getappr['action_id'];
          $lvl      = $getappr['lvl_approval'];  
          $action   = $getappr['action'];
          $receiver = $getappr['user_penerima'];
          $recent   = $getappr['user_pemberi'];

          $sql = "SELECT position_id FROM tbl_karyawan WHERE id = '$recent'";
          $que = $this->db->query($sql)->row_array();
          $leader_pos = $que['position_id'];


          if(in_array($pos_id, array('55', '56', '57','58','134','1','2','88','89','90','91','93','100','13','14')) OR in_array($leader_pos, array('55', '56', '57','58','1','2','88','89','90','91','93','100','13','14'))) // WL42182
          {

          }else {
          
            if(($cabang != 'Jakarta') AND !in_array($pos_id, array('55', '56', '57','58','134'))) { 
              // switch ($cabang) 
              // {
              //   case 'Bandung':
              //     $position_id = '57';
              //     break;

              //   case 'Medan': 
              //     $position_id = '56';
              //     break;

              //   case 'Surabaya':
              //     $position_id = '2';
              //   break;

              //   case 'Cikupa':
              //     $position_id = '58';
              //     break; 

              //   case 'Semarang':
              //     $position_id = '134'; // WL42182
              //     break;
              // }             
            }elseif (in_array($pos_id, array('65','66','67','68','71','103','102','105'))) { //staff jkt
              switch ($pos_id) {
                  case '68':
                      $position_id = '90';
                      break;
                  case '67':
                      $position_id = '93'; 
                      break;
                  case '65':
                      $position_id = '88'; 
                      break;
                  case '71':
                      $position_id = '91'; 
                      break;
                  case '66':
                      $position_id = '89'; 
                      break;
                  case '103':
                      $position_id = '91'; //100
                      break;    
                  case '102':
                      $position_id = '13'; 
                      break;
                  case '105':
                        $position_id = '89'; 
                        break;                           
              }
            }else {
              $position_id = '2'; 
            }

            $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
            $que = $this->db->query($sql)->row_array();
            $leader = $que['id'];

            $this->notification($id, $app_id, '29', $leader);
          }
          $this->notification($id, $app_id, '29', $recent);          

          switch ($action) {
            case 'handover':

              $this->db->where('id',$act_id);
              $this->db->update('tbl_tools_handover', array('approval' => '2'));

              break;
          }

          $msg = "Handover <span style='color : red;'>Not Approved</span> by <b>".$nickname."</b>.<br />Notes : ".$note;
            $this->addDiscuss($id, $msg);

            $this->db->where('modul', '4');
            $this->db->where('modul_id', $id);
            $this->db->where('record_id', $act_id);
            $this->db->update('tbl_notification', array('status' => '1'));

          $updt = array(
            'status_approval' => '2',
            'date_approval'   => date('Y-m-d H:i:s'),
            'user_approval'   => $user_app,
            'appr_notes'      => $note,
            );
          $this->db->where('id', $app_id);
          $this->db->update('tbl_tools_approval', $updt);
        }
      }

  	public function add_notes()
      {
        if($this->input->post())
        {
          $tl_id = $this->input->post('tool_id');
          $log_tl = $this->input->post('log_tl_id');
          $notes = $this->input->post('msg');

          if($log_tl != '')
          {

              $add = array(
                'tool_id'     => $tl_id,
                'log_tool_id' => $log_tl,
                'sender'      => $_SESSION['myuser']['karyawan_id'],
                'pesan'       => $notes,
                'date_created'  => date('Y-m-d H:i:s'),
                );
              $this->db->insert('tbl_tools_pesan', $add);
              $psn_id = $this->db->insert_id();
          }
          else
          {
             $insert = array(
              'tool_id'       => $tl_id,
              'discuss'       => $notes,
              'date_created'  => date('Y-m-d H:i:s'),
              'user'          => $_SESSION['myuser']['karyawan_id'],
              );
            $this->db->insert('tbl_tools_discussion', $insert);
            $psn_id = $this->db->insert_id();
          }

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
      return $this->db->insert_id();
  	}

    public function addDiscuss($id, $msg)
    {
      $insert = array(
        'tool_id'     => $id,
        'discuss'     => $msg,
        'date_created'  => date('Y-m-d H:i:s'),
        'user'      => $_SESSION['myuser']['karyawan_id'],
        );
      $this->db->insert('tbl_tools_discussion', $insert);
    }

  	public function uploadfile($id_tool, $type, $name, $log_tool_id='')
  	{

	    if($_FILES)
	    { 
          if(!empty($log_tool_id)) {
            $log_tool_id = $log_tool_id;
          }else {
            $log_tool_id = '0';
          }

	      	$uploaddir = 'assets/images/upload_tools';

	      	foreach ($_FILES[$name]['name'] as $key => $value)
	      	{

            $temp_file_location = $_FILES[$name]['tmp_name'][$key];
          
            $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);
            
            if ($upload[0] == 'Success')
            {
              $file_name = $upload[1];

              $file_upload = array(
                  'tool_id'       => $id_tool,
                  'file_name'     => $file_name,
                  'type'          => $type,
                  'uploader'      => $_SESSION['myuser']['karyawan_id'],
                  'date_created'  => date('Y-m-d H:i:s'),
                  'log_tool_id'   => $log_tool_id,
                );
                $this->db->insert('tbl_upload_tools', $file_upload);

              $insert = array(
                  'tool_id'     => $id_tool,
                  'discuss'     => $file_name,
                  'date_created'  => date('Y-m-d H:i:s'),
                  'user'      => $_SESSION['myuser']['karyawan_id'],
                  'type'      =>'1',
                );
                $this->db->insert('tbl_tools_discussion', $insert);    

            }  
              /*$temp =  explode(".", $value);
              $jns = end($temp);
              $fname = substr($value, 0, -4);
              $fname = $fname.'_'.$id_tool.'.'.$jns;*/

		        //if(!$value)
		        //{
			        //$file_name = basename($fname);

			        //$uploadfile = $uploaddir . basename($fname);
			        //move_uploaded_file($_FILES[$name]['tmp_name'][$key], $uploadfile);
		        //}else{
		          	/*$file_name = basename($fname);

			        $uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
			        move_uploaded_file($_FILES[$name]['tmp_name'][$key], $file_name);

              $conn_id = $this->mftp->conFtp();

			        if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa";
			        	$compress = compress_image($file_name, $file_name, 7);
			        }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
			            $compress = compress_image($file_name, $file_name, 40);
		  			  }*/

              //if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
               //echo "successfully uploaded $file_name = $uploadfile\n"; 


              // $upl_id = $this->db->insert_id();

              // $this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');

                //ftp_close($conn_id);

                //unlink($file_name);
              //} else {
               //echo "There was a problem while uploading $file_name\n";
              //}

		            
	        //}

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

    public function notification($id, $rec_id, $notif, $user,$url='',$notes='')
      {
        $date = date('Y-m-d H:i:s');
        $kar = $_SESSION['myuser']['karyawan_id'];
        $url = "tools/details/".$id;

       if($user == '') {
          $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, modul, date_created,url,notes)
                  SELECT sender, '$rec_id', '$notif', '$id', '4', '$date','$url','$notes' FROM tbl_tools_pesan
                  WHERE tool_id = '$id' AND sender != '$kar' GROUP BY sender
                  UNION SELECT user_holder, '$rec_id', '$notif', '$id', '4', '$date','$url','$notes' FROM tbl_tools_holder
                  WHERE tool_id = '$id' AND user_holder != '$kar' GROUP BY user_holder";

          $this->db->query($sql);
        }else {
           $add = array(
            'modul' => '4',
            'modul_id'  => $id,
            'record_id' => $rec_id,
            'record_type' => $notif,
            'user_id' => $user,
            'url'     => $url,
            'notes'   => $notes,
            'date_created' => $date,
          );
           $this->db->insert('tbl_notification', $add);
        }

      }



    public function KillTools()
    {

      if($this->input->post()) {
        $id     = $this->input->post('id_tool');
        $notes  = $this->input->post('notes');
        $user   = $_SESSION['myuser']['karyawan_id'];
        $pos_id = $_SESSION['myuser']['position_id'];
        $cabang = $_SESSION['myuser']['cabang'];
        
        if($cabang !='' AND !in_array($pos_id, array('55', '56', '57','58','134'))) // WL42182
        {

            switch ($cabang) {
              case 'Bandung':
                $position_id = '57';
                break;

              case 'Medan': 
                $position_id = '56';
                break;

              case 'Surabaya':
                $position_id = '55';
                break;

              case 'Cikupa':
                $position_id = '58';
                break;       

              case 'Semarang':
                $position_id = '134'; // WL42182
                break;           
            }

          $lvl_appr ="leader";
         
          $psn .= "Waiting Leader Approval";
        
        }elseif (in_array($pos_id, array('65','66','67','68','71','103','102','106','105'))) 
        { 
          switch ($pos_id) 
          {
              case '68':
                  $position_id = '90';
                  break;
              case '67':
                  $position_id = '93'; 
                  break;
              case '65':
                  $position_id = '88'; 
                  break;
              case '71':
                  $position_id = '91'; 
                  break;
              case '66':
                  $position_id = '89'; 
                  break;
              case '103':
                  $position_id = '91'; 
                  break;    
              case '102':
                  $position_id = '13'; 
                  break; 
              case '106':
                  $position_id = '14'; 
                  break;
               case '105':
                  $position_id = '89'; 
                  break;   
            }
            $lvl_appr ="leader";
            
             $psn .="Waiting Leader Approval";
          }else
          {
            $position_id ='2';
            $lvl_appr ="Direksi";
            
            $psn .="Waiting Director Approval";
          }

        $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
        $que = $this->db->query($sql)->row_array();
        $kar = $que['id'];

        $add_kill = array(
        'tool_id'       => $id,
        'user_kill'     => $user,
        'status'        => '0',
        'date_created'  => date('Y-m-d H:i:s'),
        'notes'         => $notes,
        'user_acc'      => $kar,
        );
        $this->db->insert('tbl_tools_kill', $add_kill);
        $kill_id = $this->db->insert_id();

       

        $up_status = array( 'status'  => '8');
        $this->db->where('id', $id);
        $this->db->update('tbl_tools', $up_status);

         $approve =  array(
          'tool_id'       => $id,
          'user_create'   => $_SESSION['myuser']['karyawan_id'],
          'date_created'  => date('Y-m-d H:i:s'),
          'lvl_approval'  => $lvl_appr,
          'action'        => 'kill',
          'action_id'     => $kill_id,
          );
        $this->db->insert('tbl_tools_approval', $approve);
        $approval_id = $this->db->insert_id();

        $this->db->where('id', $id);
        $this->db->update('tbl_tools', array('approval_id' => $approval_id));

        $log_id = $this->log_tool($id, '8', $kill_id);
        $this->uploadfile($id, '8', 'killuserfile', $log_id);
        


        $notes = $_SESSION['myuser']['nickname']." Purpose To Kill Tools ID ".$kill_id;
        $this->notification($id, $kill_id, '12', $kar,'',$notes);
        $this->logAll($id, '1', $kill_id, 'tbl_tools_kill', '');

        $psn1="Purpose To Kill Tools";
        $this->addDiscuss($id,$psn1);
        $this->addDiscuss($id,$psn);

      }
    }



  public function ApproveKill($type,$id,$lvl_approval,$kill_id)
  {
        $psn ='';
        $approve =  array(
          'tool_id'       => $id,
          'user_create'   => $_SESSION['myuser']['karyawan_id'],
          'date_created'  => date('Y-m-d H:i:s'),
          'lvl_approval'  => $lvl_approval,
          'action'        => 'kill',
          'action_id'     => $kill_id,
          'status_approval' => $type,
          'user_approval'   => $_SESSION['myuser']['karyawan_id'],
        );
        $this->db->insert('tbl_tools_approval', $approve);
        $approval_id = $this->db->insert_id();

        $this->db->where('id', $id);
        $this->db->update('tbl_tools', array('approval_id' => $approval_id));

        $this->db->where('id', $kill_id);
        $this->db->update('tbl_tools_kill', array('user_acc' => $_SESSION['myuser']['karyawan_id'],'date_acc'=> date('Y-m-d H:i:s')));

        if($type =='2')
        {
          $psn .="Waiting Approved Director";

          $sql ="SELECT user_kill FROM tbl_tools_kill WHERE id='$kill_id'";
          $res = $this->db->query($sql)->row_array();
          $kar = $res['user_kill'];

          $notes = $_SESSION['myuser']['nickname']." Not Approved Kill Tool ID ".$kill_id;
          $this->notification($id, $kill_id, '12', $kar,'',$notes);

          $sql ="SELECT id FROM tbl_karyawan WHERE position_id='2'";
          $res = $this->db->query($sql)->row_array();
          $kar = $res['id'];

          $notes = $_SESSION['myuser']['nickname']." Purpose Kill Tool ID ".$kill_id;
          $this->notification($id, $kill_id, '12', $kar,'',$notes);

        }
        elseif($type =='4')
        {
            $upkill = array(
            'status' => '9',
            );
          $this->db->where('id', $id);
          $this->db->update('tbl_tools', $upkill);

          $psn .="<span style='color:green'>Approved Kill Tool</span>";

          $sql ="SELECT user_kill FROM tbl_tools_kill WHERE id='$kill_id'";
          $res = $this->db->query($sql)->row_array();
          $kar = $res['user_kill'];

          $notes = $_SESSION['myuser']['nickname']." Approved Kill Tool ID ".$kill_id;
          $this->notification($id, $kill_id, '12', $kar,'',$notes);

          

        }

         $insert = array(
        'tool_id'     => $id,
        'discuss'     => $psn,
        'date_created'  => date('Y-m-d H:i:s'),
        'user'      => $_SESSION['myuser']['karyawan_id'],
        );
        $this->db->insert('tbl_tools_discussion', $insert);

  }

  public function notApprovedKill($id)
  {
      $notes = $this->input->post('notes');
      $type  = $this->input->post('type');
      $lvl_appr = $this->input->post('lvl_appr');
      $kill_id  = $this->input->post('kill_id');


        $approve =  array(
          'tool_id'         => $id,
          'user_create'     => $_SESSION['myuser']['karyawan_id'],
          'date_created'    => date('Y-m-d H:i:s'),
          'lvl_approval'    => $lvl_appr,
          'action'          => 'kill',
          'action_id'       => $kill_id,
          'status_approval' => $type,
          'user_approval'   => $_SESSION['myuser']['karyawan_id'],
          'appr_notes'      => $notes,

        );
        $this->db->insert('tbl_tools_approval', $approve);
        $approval_id = $this->db->insert_id();

        $this->db->where('id', $kill_id);
        $this->db->update('tbl_tools_kill', array('user_acc' => $_SESSION['myuser']['karyawan_id'],'date_acc'=> date('Y-m-d H:i:s')));

        $sql      = "SELECT * FROM tbl_tools_log WHERE tool_id='$id' AND log_type !='8' ORDER BY id DESC LIMIT 1";
        $log      = $this->db->query($sql)->row_array();
        $old_type = $log['log_type'];

        // print_r($old_type);die;

        $this->db->where('id', $id);
        $this->db->update('tbl_tools', array('status' => $old_type));

        $psn = "Not Approved Kill Tool<br>";
        $psn .= "alasan : ".$notes;
        $this->addDiscuss($id,  $psn);

        $sql ="SELECT user_kill FROM tbl_tools_kill WHERE id='$kill_id'";
        $res = $this->db->query($sql)->row_array();
        $kar = $res['user_kill'];

        $notes = $_SESSION['myuser']['nickname']." Not Approved Kill Tool ID ".$kill_id;
        $this->notification($id, $kill_id, '12', $kar,'',$notes);
  }



  public function add_accs($tools_id)
  {
    if($this->input->post())
    {
      $nama = $this->input->post('nama');
      $serial_number = $this->input->post('serial_number');
      $tgl_beli   = $this->input->post('tgl_beli');
      $tgl_beli   = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_beli);
      $date_reminder  = date("Y-m-d", strtotime("+ 2 month"));

      // print_r($tgl_beli);die;

      $arr= array(
        'nama_accs'=> $nama,
        'serial_number'=> $serial_number,
        'tgl_beli'  => $tgl_beli,
        'user_created' => $_SESSION['myuser']['karyawan_id'],
        'date_created'=> date('Y-m-d H:i:s'),
        'tools_id'  => $tools_id,
        'reminder_audit' => $date_reminder,

      );
      $this->db->insert('tbl_tools_accs', $arr);
      $accs_id = $this->db->insert_id();

      $this->uploadfile($tools_id,'0','file','0',$accs_id);

    }

  }

     public function getaccstool($id)
    {
      $sql ="SELECT acs.*,lgn.nickname FROM tbl_tools_accs acs 
            LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = acs.user_audit
            WHERE acs.tools_id='$id'";
      $res = $this->db->query($sql)->result_array();

      return $res;
    }


  public function check($id)
  {
       $sql ="SELECT * FROM tbl_tools_accs WHERE id='$id'";
       $res = $this->db->query($sql)->row_array();

       $audit = $res['audit'];

       if($audit == '1')
       {
        $adt ='0';
       }
       elseif($audit == '0')
       {
         $adt ='1';
       }

        $date_reminder  = date("Y-m-d", strtotime("+ 2 month"));


       $upd = array(
                'audit' => $adt,
                'user_audit' =>$_SESSION['myuser']['karyawan_id'],
                'tgl_audit' => date('Y-m-d H:i:s'),
                'reminder_audit' => $date_reminder,
              );
        $this->db->where('id', $id);
        $this->db->update('tbl_tools_accs', $upd);

        return $adt;
  }


  public function getfileaccs($accs_id,$tool_id)
  {
    $sql ="SELECT upl.*,lgn.nickname FROM tbl_upload_tools upl 
           LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = upl.uploader
           WHERE tool_id='$tool_id' AND accs_id ='$accs_id' ORDER BY id DESC";
    $res = $this->db->query($sql)->result_array();

    return $res;
  }

  public function change_status($tools_id,$id)
  {
       $status = $this->input->post('status');
       $upd = array(
                'status' => $status,
              );
        $this->db->where('id', $id);
        $this->db->update('tbl_tools_accs', $upd);

        return $adt;
  }

  public function gethistory_service($tool_id)
  {
    $sql ="SELECT hstr.*,lgn.nickname FROM tbl_kar_kendaraan knd 
          LEFT JOIN tbl_history_service_kendaraan hstr ON hstr.kendaraan_id = knd.id
          LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hstr.user_service
          WHERE knd.tools_id='$tool_id'";
    $res = $this->db->query($sql)->result_array();

    // print_r($res);die;

    return $res;
  }

  public function get_id_kendaraan($id)
  {
    $sql ="SELECT * FROM tbl_kar_kendaraan WHERE tools_id='$id'";
    $res = $this->db->query($sql)->row_array();
    return $res;
  }




} 
?>
