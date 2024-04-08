<?php $user = $this->session->userdata('myuser'); ?>
<!-- Include Required Prerequisites -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
  .panel-notif{
    overflow: auto;
    height: 825px;
  }

  .panel-norek {
    overflow-y: 250px;
  }

  .panel-notes {
    height: 800px;
  }

  .alert-default{
    background-color: #ffbb99;

  }

  #imp_start{
    background-color: #dde0d1;
  }

  #imp_finish{
    background-color: #ccffcc;
  }
  
  #imp_booking{
    background-color : #66b3ff;
  }

 .panel-norek, .panel-kurs{
    height: 200px;
  }

    th,td {
     border: 10px solid white;
    }

  .bca{
    background-color: #D9EDF7;
  }

  .uob{
    background-color: #F2DEDE;
  }

  .panin{
    background-color: #FCF8E3;
  }

  .mandiri{
    background-color: #DFF0D8;
  }

th{
  width : 25%;
}

.logo{
  width: 45px;
  height: 15px;
}

.lg-uob {
   width: 40px;
  height: 15px; 
}

.lg-panin{
  width: 85px;
  height: 15px;
}

.lg-mandiri{
  width: 65px;
  height: 20px;
}

.alert-handover {
  background-color: #AAABB6;
}

.alert-kill-tools {
  background-color: #f74b42;
}

.alert-primary {
  background-color: #d5d9e0;
  
}

.alert-progress {
  background-color: #ff82a3;
}

.alert-pemberitahuan {
  background-color: #f0f0f0;
  padding-left:  10px;
  padding-right:  10px;
  padding-top:  10px;
  padding-bottom: 1px; 
  border-radius: 4px;
  margin-bottom: 10px;
}

/* .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: scroll;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
    -webkit-overflow-scrolling: touch;
}

.table-responsive>.table { 
    margin-bottom: 0;
}

.table-responsive>.table>thead>tr>th, 
.table-responsive>.table>tbody>tr>th, 
.table-responsive>.table>tfoot>tr>th, 
.table-responsive>.table>thead>tr>td, 
.table-responsive>.table>tbody>tr>td, 
.table-responsive>.table>tfoot>tr>td {
    white-space: nowrap;
} */

.tabs{
    width: 25%;
  }

  .btn-rad {
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
  }

  .center {
   font-size: 11px;
  }

  /* body {
  -webkit-user-select: none;
     -moz-user-select: -moz-none;
      -ms-user-select: none;
          user-select: none;
}

input,
textarea {
     -moz-user-select: text;
} */

</style>

<div id="page-inner"> 
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">   
          <div style="overflow: hidden;"> 
            <div style="float:left; margin-top: 1%;">
              PENGUMUMAN RESMI INDOTARA
            </div>
            <div style="float:right;">
              <?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77', '83', '14', '12'))) { ?>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" >+ New</button>
              <?php } ?>
              
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- konten modal-->
            <div class="modal-content">
              <!-- heading modal -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Pengumuman</h4>
              </div>
              <!-- body modal -->
              <form action="Home/simpan" method="post" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
                <div class="modal-body">
                  <textarea type="text" id="fr2" class="form-control reptext" name="pemberitahuan" placeholder="Isi Pemberitahuan."></textarea>
                  <br>
                  <div class="form-group row">
                    <label class="control-label col-sm-3" style="width: 120px; margin-top: 5px;"> Masa Tayang</label>
                    <div class="col-sm-3" style="padding: 0px;">
                      <input class="form-control" type="number" name="max_day" id="max_day" required="true" >
                    </div>
                    <label class="control-label col-sm-1" style="margin-top: 5px;">Days</label>
                  </div>
                </div>
               <!-- footer modal -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary submit_btn" value="Save" name="submit_btn" id="submit_btn"> 
                </div>
              </form>
            </div>
          </div>
        </div>
       <div class="panel-body panel-pemberitahuan" >
          <?php if ($pemberitahuan) {
            foreach ($pemberitahuan as $row) { ?>
          <div class="alert alert-pemberitahuan" style="font-size: 11px;" >
            <?php if($user['nickname'] == $row['nickname']) { ?>
                <a href="Home/del_pemberitahuan/<?php echo $row['id']; ?>" class="close" aria-label="close" onclick="return confirm('Anda akan menghapus Pemberitahuan ini. Lanjutkan ?');">&times;</a> 
              <?php } ?>
            
            <div style="text-align:left; font-size: 9px;" >
              Last Update  : <?php $format = date('d-m-Y H:i:s', strtotime($row["date_created"] )); echo $format;?>
              <br>
              By   : <b> <?php echo $row["nickname"];?></b>
            </div>
            <br>
            <div style="font-size: 12px;">
              <?= !empty($row['pemberitahuan']) ? $row['pemberitahuan'] : ''; ?>
            </div>
          </div>
          <?php  }  
          } ?>
        </div>
      </div>
      <div class="panel panel-default ">
          <div class="panel-heading">
            NOTIFICATION
          </div>
        <!-- /.panel-heading -->
          <div class="panel-body panel-notif">
            <?php if($notif)
            {
              foreach ($notif as $ntf) 
              { 
                $idsps = $ntf['modul_id'];
                $userid = $_SESSION['myuser']['karyawan_id'];

                if($ntf['record_type'] == 1)
                {
                  if($ntf['modul'] == '3') {
                    $overto_id = $ntf['record_id'];
                    $sql1 = "SELECT a.user_id, a.date_created, b.no_sps, e.perusahaan, d.nickname, f.time_idle FROM tbl_notification as a 
                    JOIN tbl_sps as b ON b.id = a.modul_id
                    JOIN tbl_sps_overto as c ON c.id = a.record_id
                    JOIN tbl_loginuser as d ON d.karyawan_id = a.user_id
                    JOIN tbl_customer as e ON e.id = b.customer_id 
                    JOIN tbl_sps_log as f ON f.id_sps = a.modul_id 
                    WHERE a.modul_id = '$idsps' AND c.id = '$overto_id' AND a.status = '0' AND a.modul = '3' GROUP BY a.id DESC";

                    $que1 = $this->db->query($sql1)->result_array();

                    }elseif($ntf['modul'] == '2'){
                      $overto_id = $ntf['record_id'];
                      $sql1 = "SELECT a.user_id, a.date_created, b.no_so, e.perusahaan, d.nickname FROM tbl_notification as a 
                      JOIN tbl_do as b ON b.id = a.modul_id
                      JOIN tbl_multi_overto as c ON c.id = a.record_id
                      JOIN tbl_loginuser as d ON d.karyawan_id = a.user_id
                      JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE a.modul_id = '$idsps' AND c.id = '$overto_id' AND a.status = '0' AND a.modul = '2' GROUP BY a.id DESC";

                      $que1_do = $this->db->query($sql1)->result_array();
                    }elseif ($ntf['modul'] == 5) {
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, b.id, d.nickname, e.items FROM tbl_notification as a 
                      JOIN tbl_purchasing as b ON b.id = a.modul_id
                      JOIN tbl_pr_overto as c ON c.id = a.record_id
                      JOIN tbl_loginuser as d ON d.karyawan_id = a.user_id
                      LEFT JOIN tbl_pr_vendor as e ON e.pr_id = a.modul_id
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $ov_pr = $this->db->query($sql)->result_array();
                    }elseif ($ntf['modul'] == 7) {
                      $overto_id = $ntf['record_id'];
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, b.title FROM tbl_notification as a 
                      LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                      LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.user             
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $que_wi = $this->db->query($sql)->result_array();
                    }elseif ($ntf['modul'] == '8') {
                      $new_id = $ntf['record_id'];
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                      LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.sales_id  
                      LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                      LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')           
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $new_crm = $this->db->query($sql)->result_array();
                    }elseif($ntf['modul'] == '9') {
                      $new_id = $ntf['record_id'];
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, cs.perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                      LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.salesman  
                      LEFT JOIN tbl_customer cs ON b.customer_id = cs.id        
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $new_project = $this->db->query($sql)->result_array();
                    }elseif($ntf['modul'] == '12') {
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, c.nickname, b.id, b.keterangan FROM tbl_notification as a 
                              LEFT JOIN tbl_hrd_imp as b ON b.id = a.record_id
                              LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.id_karyawan
                              WHERE a.id = $id_notif GROUP BY a.id DESC";
                      $new_imp = $this->db->query($sql)->row_array();
                    }
                }elseif($ntf['record_type'] == 2) {
                  switch ($ntf['modul']) {
                    case '2':
                      $pesan_id = $ntf['record_id'];
                      $sql = "SELECT a.date_created, b.no_so, d.nickname, e.perusahaan FROM tbl_notification as a 
                      JOIN tbl_do as b ON a.modul_id = b.id 
                      JOIN tbl_multi_pesan as c ON c.id = a.record_id 
                      JOIN tbl_loginuser as d ON c.sender_id = d.karyawan_id
                      JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE c.id = '$pesan_id' AND a.modul_id = '$idsps' AND c.sender_id != '$userid' AND a.status = '0' AND a.modul = '2' GROUP BY c.type_id DESC";

                      $que2_do = $this->db->query($sql)->result_array();
                      break;

                    case '3':
                      if($ntf['imp_id'] == 0)
                      {
                        $pesan_id = $ntf['record_id'];
                        $sql = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                        JOIN tbl_sps as b ON a.modul_id = b.id 
                        JOIN tbl_pesan as c ON c.id = a.record_id 
                        JOIN tbl_loginuser as d ON c.sender_id = d.karyawan_id
                        JOIN tbl_customer as e ON e.id = b.customer_id
                        WHERE c.id = '$pesan_id' AND a.modul_id = '$idsps' AND c.sender_id != '$userid' AND a.status = '0' AND a.modul = '3' GROUP BY c.sps_id DESC";

                        $que2 = $this->db->query($sql)->result_array();

                      }elseif($ntf['imp_id'] != 0){
                        $sql = "SELECT a.date_created, a.user_id, b.shipment, d.nickname FROM tbl_notification as a 
                        JOIN tbl_import as b ON b.id = a.imp_id 
                        JOIN tbl_import_pesan as c ON c.id = a.record_id
                        JOIN tbl_loginuser as d ON c.sender = d.karyawan_id 
                        WHERE imp_id = ".$ntf['imp_id']." AND c.sender != '$userid' AND a.status = '0' AND record_type = '2' AND a.modul = '3' GROUP BY c.import_id DESC";

                        $imp_ntf = $this->db->query($sql)->result_array();
                      }
                      break;

                    case '5':
                      $pesan_id = $ntf['record_id'];
                      $sql = "SELECT a.id as notif_id, a.date_created, b.id, d.nickname FROM tbl_notification as a 
                      JOIN tbl_purchasing as b ON a.modul_id = b.id 
                      JOIN tbl_pr_pesan as c ON c.id = a.record_id 
                      JOIN tbl_loginuser as d ON c.sender = d.karyawan_id
                      WHERE c.id = '$pesan_id' AND a.modul_id = '$idsps' AND c.sender != '$userid' AND a.status = '0' AND a.modul = '5' GROUP BY c.pr_id DESC";

                      $que2_pr = $this->db->query($sql)->result_array();
                      break;

                    case '7':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.id as notif_id, a.date_created, d.nickname, b.title FROM tbl_notification as a 
                      LEFT JOIN tbl_wishlist as b ON a.modul_id = b.id
                      LEFT JOIN tbl_wish_discussion as c ON c.id = a.record_id 
                      LEFT JOIN tbl_loginuser as d ON c.user = d.karyawan_id
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $psn_wish = $this->db->query($sql)->result_array();
                      break;

                    case '8':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                          LEFT JOIN tbl_crm as b ON b.id = a.modul_id 
                          LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                          LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                          LEFT JOIN tbl_crm_pesan ps ON ps.id = a.record_id
                          LEFT JOIN tbl_loginuser as c ON c.karyawan_id = ps.sender            
                          WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $psn_crm = $this->db->query($sql)->result_array();
                      break;

                    case '9':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, cs.perusahaan FROM tbl_notification as a 
                          LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id 
                          LEFT JOIN tbl_customer cs ON b.customer_id = cs.id
                          LEFT JOIN tbl_project_pesan ps ON ps.id = a.record_id
                          LEFT JOIN tbl_loginuser as c ON c.karyawan_id = ps.sender            
                          WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $psn_project = $this->db->query($sql)->result_array();
                      break;

                    case '10':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, d.id, c.nickname, IF(d.type = 1, 'Advance', 'Expenses') as tipe_cash, d.alasan_pembelian FROM tbl_notification as a 
                              LEFT JOIN tbl_cash_pesan as b ON b.id = a.record_id
                              LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.sender
                              LEFT JOIN tbl_cash as d ON d.id = b.cash_id
                              WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $psn_cash = $this->db->query($sql)->row_array();  
                      break;

                    case '12':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, c.nickname, d.id, d.keterangan FROM tbl_notification as a 
                              LEFT JOIN tbl_hrd_imp_discussion as b ON b.id = a.record_id
                              LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.user
                              LEFT JOIN tbl_hrd_imp as d ON d.id = b.imp_id
                              WHERE a.id = $id_notif GROUP BY a.id DESC";
                      $psn_imp = $this->db->query($sql)->row_array();        
                      break;  
                  }  
                
                }elseif ($ntf['record_type'] == 3) {
                  $upl_id = $ntf['record_id'];

                  switch ($ntf['modul']) {
                    case '2':
                      $sql3 = "SELECT a.date_created, b.no_so, d.nickname, e.perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_do as b ON a.modul_id = b.id 
                      LEFT JOIN tbl_upload_do as c ON c.id = a.record_id 
                      LEFT JOIN tbl_loginuser as d ON c.uploader = d.karyawan_id
                      LEFT JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE a.modul = '2' AND c.id = '$upl_id' AND a.modul_id = '$idsps' AND c.uploader != '$userid' AND a.status = '0' GROUP BY c.do_id DESC";

                      $que3_do = $this->db->query($sql3)->result_array();
                      break;

                    case '3':
                      $sql3 = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                      JOIN tbl_sps as b ON a.modul_id = b.id 
                      JOIN tbl_upload as c ON c.id = a.record_id 
                      JOIN tbl_loginuser as d ON c.uploader = d.karyawan_id
                      JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE a.modul = '3' AND c.id = '$upl_id' AND a.modul_id = '$idsps' AND c.uploader != '$userid' AND a.status = '0' GROUP BY c.sps_id DESC";

                      $que3 = $this->db->query($sql3)->result_array();
                      break;

                    case '5':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, d.nickname, b.id, e.items FROM tbl_notification as a 
                      LEFT JOIN tbl_purchasing as b ON a.modul_id = b.id 
                      LEFT JOIN tbl_upload_pr as c ON c.id = a.record_id 
                      LEFT JOIN tbl_loginuser as d ON c.uploader = d.karyawan_id
                      LEFT JOIN tbl_pr_vendor as e ON e.pr_id = a.modul_id
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_pr = $this->db->query($sql)->result_array();
                      break;

                    case '7':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, d.nickname, b.title FROM tbl_notification as a 
                      LEFT JOIN tbl_wishlist as b ON a.modul_id = b.id 
                      LEFT JOIN tbl_upload_wish as c ON c.id = a.record_id 
                      LEFT JOIN tbl_loginuser as d ON c.uploader = d.karyawan_id
                      WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_wish = $this->db->query($sql)->result_array();
                      break;

                    case '8':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                        LEFT JOIN tbl_crm as b ON b.id = a.modul_id    
                        LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                        LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                        LEFT JOIN tbl_upload_crm up ON up.id = a.record_id 
                        LEFT JOIN tbl_loginuser as c ON c.karyawan_id = up.uploader           
                        WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_crm = $this->db->query($sql)->result_array();
                      break;

                    case '9':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, cs.perusahaan FROM tbl_notification as a 
                        LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id    
                        LEFT JOIN tbl_customer cs ON b.customer_id = cs.id
                        LEFT JOIN tbl_upload_project up ON up.id = a.record_id 
                        LEFT JOIN tbl_loginuser as c ON c.karyawan_id = up.uploader           
                        WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_project = $this->db->query($sql)->result_array();
                      break;

                    case '10':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, d.id, d.alasan_pembelian, c.nickname, IF(d.type = 1, 'Advance', 'Expenses') as tipe_cash FROM tbl_notification as a 
                              LEFT JOIN tbl_upload_cash as b ON b.id = a.record_id
                              LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.uploader
                              LEFT JOIN tbl_cash as d ON d.id = b.cash_id           
                        WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_cash = $this->db->query($sql)->row_array();
                      break;

                    case '11':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.user_id, a.date_created, b.file_name FROM tbl_notification as a 
                        LEFT JOIN tbl_upload_pricelist as b ON b.id = a.modul_id           
                        WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $upl_pricelist = $this->db->query($sql)->result_array();
                      break;

                    case '12':
                      $id_notif = $ntf['id'];
                      $sql = "SELECT a.date_created, c.nickname, d.id, d.keterangan FROM tbl_notification as a 
                              LEFT JOIN tbl_upload_hrd as b ON b.id = a.record_id
                              LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.uploader
                              LEFT JOIN tbl_hrd_imp as d ON d.id = b.type_id
                              WHERE a.id = $id_notif GROUP BY a.id DESC";
                      $upl_imp = $this->db->query($sql)->row_array();        
                      break;  
                  }
                
                }elseif ($ntf['record_type'] == 4) { 
                  switch ($ntf['modul']) {
                    case '3':
                      $pause_id = $ntf['record_id'];
                      $sql4 = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                      JOIN tbl_sps as b ON a.modul_id = b.id 
                      JOIN tbl_pause as c ON c.id = a.record_id 
                      JOIN tbl_loginuser as d ON c.user_pause = d.karyawan_id
                      JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE a.modul = '3' AND c.id = '$pause_id' AND a.modul_id = '$idsps' AND c.user_pause != '$userid' AND a.status = '0' GROUP BY c.sps_id DESC";
                     
                      $que4 = $this->db->query($sql4)->result_array();
                      break;
                    
                    case '7':
                      $notif_id = $ntf['id'];
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                              LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                              LEFT JOIN tbl_wish_status as c ON (c.id = a.record_id AND c.wish_id = a.modul_id)
                              LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user
                              WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $pause_wi = $this->db->query($sql)->row_array(); 
                      break; 
                  }
                  
                }elseif ($ntf['record_type'] == 5) {
                  switch ($ntf['modul']) {
                    case '3':
                      $pause_id = $ntf['record_id'];
                      $sql5 = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                      JOIN tbl_sps as b ON a.modul_id = b.id 
                      JOIN tbl_pause as c ON c.id = a.record_id 
                      JOIN tbl_loginuser as d ON c.user_pause = d.karyawan_id
                      JOIN tbl_customer as e ON e.id = b.customer_id
                      WHERE a.modul = '3' AND c.id = '$pause_id' AND a.modul_id = '$idsps' AND c.user_pause != '$userid' AND a.status = '0' GROUP BY c.sps_id DESC";
                    
                      $que5 = $this->db->query($sql5)->result_array();
                      break;
                    
                    case '7':
                      $notif_id = $ntf['id'];
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                              LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                              LEFT JOIN tbl_wish_status as c ON (c.id = a.record_id AND c.wish_id = a.modul_id)
                              LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user
                              WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $play_wi = $this->db->query($sql)->row_array(); 
                      break;
                  }

                }elseif($ntf['record_type'] == 6){
                  $sql = "SELECT a.id, imp_id, user_id, record_type, a.date_created, shipment, a.status FROM tbl_notification as a
                  JOIN tbl_import as b ON imp_id = b.id 
                  WHERE a.modul = '3' AND record_type = 6 AND a.status = 0 AND user_id = '$userid' AND imp_id = ".$ntf['imp_id']." GROUP BY b.id DESC";

                  $res6 = $this->db->query($sql)->result_array();
          
                }elseif($ntf['record_type'] == 7){
                  $sql = "SELECT a.id, imp_id, user_id, record_type, a.date_created, shipment, a.status FROM tbl_notification as a
                  JOIN tbl_import as b ON imp_id = b.id 
                  WHERE a.modul = '3' AND record_type = 7 AND a.status = 0 AND user_id = '$userid' AND imp_id = ".$ntf['imp_id']." GROUP BY b.id DESC";

                  $res7 = $this->db->query($sql)->result_array();
    
                }elseif($ntf['record_type'] == 8){
                  $book_id = $ntf['record_id'];
                  $imp_id  = $ntf['imp_id'];
                  $sql = "SELECT a.imp_id, a.date_created, a.record_type, b.shipment, d.nickname, f.kode FROM tbl_notification as a
                  JOIN tbl_import as b ON b.id = a.imp_id
                  JOIN tbl_import_booking as c ON c.id = a.record_id
                  JOIN tbl_loginuser as d ON d.karyawan_id = c.booked_by
                  JOIN tbl_import_product as e ON e.id = c.import_product_id
                  JOIN tbl_product as f ON f.id = e.product_id
                  WHERE a.modul = '3' AND a.status = 0 AND c.booked_by != '$userid' AND record_type = 8 AND c.id = '$book_id' AND a.imp_id = '$imp_id' GROUP BY c.import_id DESC ";
                  
                  $booking = $this->db->query($sql)->result_array();
              
                }elseif ($ntf['record_type'] == 9) {
                  if($ntf['modul'] == '3') {
                    $pesan_id = $ntf['record_id'];
                    $sql = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                    JOIN tbl_sps as b ON a.modul_id = b.id 
                    JOIN tbl_pesan as c ON c.id = a.record_id 
                    JOIN tbl_loginuser as d ON c.sender_id = d.karyawan_id
                    JOIN tbl_customer as e ON e.id = b.customer_id
                    WHERE a.modul = '3' AND c.id = '$pesan_id' AND a.modul_id = '$idsps' AND c.sender_id != '$userid' AND a.status = '0' GROUP BY c.sps_id DESC";

                    $execution = $this->db->query($sql)->result_array();
                  }elseif($ntf['modul'] == '9') {
                    $id_notif = $ntf['id'];
                    $sql = "SELECT a.date_created, b.id, e.perusahaan, if(b.execution = '0', 'Queue', 'Worked-On') as execution FROM tbl_notification as a 
                    JOIN tbl_project_dhc as b ON a.modul_id = b.id 
                    JOIN tbl_customer as e ON e.id = b.customer_id
                    WHERE a.id = $id_notif GROUP BY a.id DESC";

                    $exe_project = $this->db->query($sql)->result_array();
                  }

                }elseif ($ntf['record_type'] == 10) {
                  $pesan_id = $ntf['record_id'];
                  $sql = "SELECT a.date_created, b.no_sps, d.nickname, e.perusahaan FROM tbl_notification as a 
                    JOIN tbl_sps as b ON a.modul_id = b.id 
                    JOIN tbl_pesan as c ON c.id = a.record_id 
                    JOIN tbl_loginuser as d ON c.sender_id = d.karyawan_id
                    JOIN tbl_customer as e ON e.id = b.customer_id
                    WHERE a.modul = '3' AND c.id = '$pesan_id' AND a.modul_id = '$idsps' AND c.sender_id != '$userid' AND a.status = '0' GROUP BY c.sps_id DESC";
                  $cancel_exe = $this->db->query($sql)->result_array();
                }elseif ($ntf['record_type'] == 12) {
                  $kill_id = $ntf['record_id'];
                  $sql = "SELECT no.id, no.date_created, lo.nickname, too.code, too.name FROM tbl_notification as no
                   JOIN tbl_tools as too ON too.id = no.modul_id 
                   JOIN tbl_tools_kill as ki ON ki.id = no.record_id
                   JOIN tbl_loginuser as lo ON lo.karyawan_id = ki.user_kill
                    WHERE no.modul = '4' AND no.user_id = '$userid' AND no.status = '0' AND ki.id = '$kill_id' GROUP BY no.id DESC";
                    $tl_kill = $this->db->query($sql)->result_array();    
                }elseif ($ntf['record_type'] == 13) {
                  $id_notif = $ntf['id'];
                  switch ($ntf['modul']) {
                    case '2':
                       $sql = "SELECT b.id, b.do_status, a.date_created, b.no_so, d.nickname, e.perusahaan FROM tbl_notification as a 
                              LEFT JOIN tbl_do as b ON a.modul_id = b.id  
                              LEFT JOIN tbl_multi_pesan as c ON c.id = a.record_id
                              LEFT JOIN tbl_loginuser as d ON c.sender_id = d.karyawan_id
                              LEFT JOIN tbl_customer as e ON e.id = b.customer_id
                              WHERE a.id = '$id_notif' GROUP BY a.id DESC";
                        $appr_do = $this->db->query($sql)->row_array();
                      break;
                    case '5':
                      $sql = "SELECT a.date_created, d.nickname, b.id, e.items FROM tbl_notification as a 
                              LEFT JOIN tbl_purchasing as b ON a.modul_id = b.id 
                              LEFT JOIN tbl_loginuser as d ON b.sales_id = d.karyawan_id
                              LEFT JOIN tbl_pr_vendor as e ON e.pr_id = a.modul_id
                              WHERE a.id = $id_notif GROUP BY a.id DESC";

                      $appr_pr = $this->db->query($sql)->result_array();
                      break;
                    case '8':
                      $sql = "SELECT a.date_created, d.nickname, b.id, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                        LEFT JOIN tbl_crm as b ON a.modul_id = b.id 
                        LEFT JOIN tbl_crm_progress_approval as c ON c.id = a.record_id
                        LEFT JOIN tbl_loginuser as d ON c.user = d.karyawan_id
                        LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                        LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                        WHERE a.id = $id_notif GROUP BY a.id DESC";
                      $appr_crm = $this->db->query($sql)->result_array();
                      break;

                    case '10':
                        $sql = "SELECT a.date_created, b.id, b.alasan_pembelian, c.nickname, IF (b.type = 1, 'Advance', 'Expenses') as tipe_cash FROM tbl_notification as a
                                LEFT JOIN tbl_cash as b ON b.id = a.modul_id
                                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.sales_id
                                WHERE a.id = $id_notif GROUP BY a.id DESC";
                        $appr_cash = $this->db->query($sql)->row_array();          
                      break;         
                  }
                }elseif($ntf['record_type'] == 14) { 
                  $id_notif = $ntf['id'];
                  switch ($ntf['modul']) { 
                     case '10': 
                       $sql = "SELECT a.date_created, b.id, b.alasan_pembelian, c.nickname, IF (b.type = 1, 'Advance', 'Expenses') as tipe_cash FROM tbl_notification as a
                                LEFT JOIN tbl_cash as b ON b.id = a.modul_id
                                LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.sales_id
                                LEFT JOIN tbl_cash_expenses as d ON d.id = a.record_id
                                WHERE a.id = $id_notif GROUP BY a.id DESC";
                        $rcv_cash = $this->db->query($sql)->row_array();
                       break;
                   }  
                }elseif ($ntf['record_type'] == 15) {
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          LEFT JOIN tbl_wish_status as c ON (c.id = a.record_id AND c.wish_id = a.modul_id)
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                  $prgs_wi = $this->db->query($sql)->result_array();        
                
                }elseif ($ntf['record_type'] == '16') {
                  $notif_id = $ntf['id'];

                  switch ($ntf['modul']) {
                    case '2':
                      $sql = "SELECT b.id, b.do_status, a.date_created, b.no_so, d.nickname, e.perusahaan FROM tbl_notification as a 
                              LEFT JOIN tbl_do as b ON a.modul_id = b.id  
                              LEFT JOIN tbl_do_contributor as c ON c.id = a.record_id
                              LEFT JOIN tbl_loginuser as d ON c.user_id = d.karyawan_id
                              LEFT JOIN tbl_customer as e ON e.id = b.customer_id
                              WHERE a.id = '$notif_id' GROUP BY a.id DESC";
                      $cont_do = $this->db->query($sql)->row_array();
                      break;
                    case '5':
                      $sql = "SELECT a.date_created, b.id, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_purchasing as b ON b.id = a.modul_id
                          LEFT JOIN tbl_pr_contributor as c ON c.id = a.record_id
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user_id
                          WHERE a.id = $notif_id GROUP BY a.id DESC";

                      $cont_pr = $this->db->query($sql)->row_array();    
                      break;

                    case '7':
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          LEFT JOIN tbl_wish_contributor as c ON (c.id = a.record_id AND c.wish_id = a.modul_id)
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user_id
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $contributor_wi = $this->db->query($sql)->row_array();       
                    break;

                    case '8':
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                      LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                      LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                      LEFT JOIN tbl_crm_contributor cn ON cn.id = a.record_id
                      LEFT JOIN tbl_loginuser c ON c.karyawan_id = cn.user_id            
                      WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $contributor_crm = $this->db->query($sql)->result_array(); 
                    break;

                    case '9':
                      $sql = "SELECT a.user_id, a.date_created, c.nickname, cs.perusahaan, b.id FROM tbl_notification as a 
                      LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                      LEFT JOIN tbl_customer cs ON b.customer_id = cs.id
                      LEFT JOIN tbl_project_contributor cn ON cn.id = a.record_id
                      LEFT JOIN tbl_loginuser c ON c.karyawan_id = cn.user_id            
                      WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $contributor_project = $this->db->query($sql)->result_array(); 
                    break;    
                  }
                }elseif ($ntf['record_type'] == '17') {
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                      LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                      LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                      LEFT JOIN tbl_crm_followup cn ON cn.id = a.record_id
                      LEFT JOIN tbl_loginuser c ON c.karyawan_id = cn.user_id            
                      WHERE a.id = $notif_id GROUP BY a.id DESC";
                  $followup_crm = $this->db->query($sql)->result_array(); 
                }elseif ($ntf['record_type'] == '18') {
                  if($ntf['modul'] == '8') {
                    $notif_id = $ntf['id'];
                    $sql = "SELECT a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                      LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                      LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                      LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                      LEFT JOIN tbl_crm_progress cn ON cn.id = a.record_id
                      LEFT JOIN tbl_loginuser c ON c.karyawan_id = cn.user_id            
                      WHERE a.id = $notif_id GROUP BY a.id DESC";
                    $progress_crm = $this->db->query($sql)->result_array(); 

                  }elseif($ntf['modul'] == '9') {
                    $notif_id = $ntf['id'];
                    $sql = "SELECT a.user_id, a.date_created, c.nickname, cs.perusahaan, b.id FROM tbl_notification as a 
                        LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                        LEFT JOIN tbl_customer cs ON b.customer_id = cs.id
                        LEFT JOIN tbl_project_log_progress cn ON cn.id = a.record_id
                        LEFT JOIN tbl_loginuser c ON c.karyawan_id = cn.user            
                        WHERE a.id = $notif_id GROUP BY a.id DESC";
                    $progress_project = $this->db->query($sql)->result_array(); 
                  }
                }elseif ($ntf['record_type'] == '19') {
                    $notif_id = $ntf['id'];
                    $sql = "SELECT a.date_created, b.id, b.title, b.progress FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                    $appr_wi = $this->db->query($sql)->result_array();   
                
                }elseif($ntf['record_type'] == '20') {
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.date_created, cs.perusahaan, b.id, c.note, lg.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                          LEFT JOIN tbl_project_reminder as c ON c.project_id = b.id
                          LEFT JOIN tbl_customer cs ON cs.id = b.customer_id
                          LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = c.user
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                  $reminder_project = $this->db->query($sql)->result_array();

                }elseif($ntf['record_type'] == '21') {
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.date_created, cs.perusahaan, b.id, dl.deadline, lg.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                          LEFT JOIN tbl_project_deadline dl ON dl.id = a.record_id
                          LEFT JOIN tbl_customer  cs ON cs.id = b.customer_id
                          LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = dl.user
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                  $deadline_project = $this->db->query($sql)->result_array();
                }elseif($ntf['record_type'] == '22') {
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.date_created, cs.perusahaan, b.id, lg.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_project_dhc as b ON b.id = a.modul_id
                          LEFT JOIN tbl_customer cs ON cs.id = b.customer_id
                          LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = b.salesman
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                  $tagih_project = $this->db->query($sql)->result_array();
                }elseif($ntf['record_type'] == '23') { //IMPORT
                  $notif_id = $ntf['id'];
                  $sql = "SELECT a.id, imp_id, user_id, record_type, a.date_created, shipment, a.status FROM tbl_notification as a
                  LEFT JOIN tbl_import as b ON a.imp_id = b.id 
                  WHERE a.id = '$notif_id' GROUP BY a.id DESC";

                  $checked_import = $this->db->query($sql)->result_array();
                }elseif($ntf['record_type'] == '24') {
                  $notif_id = $ntf['id']; 

                  switch ($ntf['modul']) {
                    case '7':
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.user
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $po_wi = $this->db->query($sql)->row_array();  
                    break;

                    case '8':
                      $sql = "SELECT a.modul_id, a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan FROM tbl_notification as a 
                        LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                        LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.sales_id  
                        LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                        LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')           
                        WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $auto_reminder = $this->db->query($sql)->row_array();
                    break;   
                  }
                }elseif($ntf['record_type'] == '26') {
                  $notif_id = $ntf['id'];

                  switch ($ntf['modul']) {
                    case '6':
                      $sql = "SELECT a.date_created, a.user_id, b.shipment, d.nickname FROM tbl_notification as a 
                      JOIN tbl_import as b ON b.id = a.modul_id 
                      JOIN tbl_import_discussion as c ON c.id = a.record_id
                      JOIN tbl_loginuser as d ON c.user = d.karyawan_id 
                      WHERE a.id = $notif_id GROUP BY a.id DESC";

                      $disc_imp = $this->db->query($sql)->row_array();
                    break;
                  }        
                }elseif($ntf['record_type'] == '27') {
                  $notif_id = $ntf['id'];

                  switch ($ntf['modul']) {
                    case '7':
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          LEFT JOIN tbl_wish_handover as c ON (c.id = a.record_id AND c.wish_id = a.modul_id)
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.user_pemberi
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $ho_wi = $this->db->query($sql)->row_array();  
                    break;

                    case '8':
                      $sql = "SELECT a.modul_id, a.user_id, a.date_created, c.nickname, IF (b.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, c.nickname as user_id, d.nickname as sales_exist, e.nickname as sales_new FROM tbl_notification as a 
                        LEFT JOIN tbl_crm as b ON b.id = a.modul_id
                        LEFT JOIN tbl_crm_change_sales cr ON cr.id = a.record_id
                        LEFT JOIN tbl_loginuser as c ON c.karyawan_id = cr.user_id
                        LEFT JOIN tbl_loginuser d ON d.karyawan_id = cr.sales_exist
                        LEFT JOIN tbl_loginuser e ON e.karyawan_id = cr.sales_new
                        LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                        LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0')
                                   
                        WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $chsls_crm = $this->db->query($sql)->row_array();    
                    break;
                  }       
                }elseif($ntf['record_type'] == '28') {
                  $notif_id = $ntf['id'];

                  switch ($ntf['modul']) {
                    case '7':
                      $sql = "SELECT a.date_created, b.id, b.title, b.progress, d.nickname FROM tbl_notification as a
                          LEFT JOIN tbl_wishlist as b ON b.id = a.modul_id
                          LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.user
                          WHERE a.id = $notif_id GROUP BY a.id DESC";
                      $po_wi = $this->db->query($sql)->row_array();  
                    break;
                  }
                }
         
                if($ntf['record_type'] == 1){ 
                  if($ntf['modul'] == '3') {
                    foreach ($que1 as $row1) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php $date = new DateTime($row1['date_created']); echo date_format($date, 'd-m-Y H:i:s');?> <b><?php echo $row1['no_sps'];?></b> <?php echo $row1['perusahaan']?> >> over to <b><?php echo $row1['nickname']?></b>.
                        <a href= "<?php echo site_url('home/go/'.$ntf['modul_id'].'/1/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div> 
                    <?php  }
                  }elseif ($ntf['modul'] == '2') {
                    foreach ($que1_do as $rows1) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($rows1['date_created'])); ?> <b><?php echo $rows1['no_so'];?></b> <?php echo $rows1['perusahaan']?> >> over to <b><?php echo $rows1['nickname']?></b>.
                        <a href= "<?php echo site_url('home/go_do/'.$ntf['modul_id'].'/'.$ntf['id'].'/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                  <?php }
                  }elseif($ntf['modul'] == 5) {
                    foreach ($ov_pr as $row) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b>PR ID <?php echo $row['id'];?></b> <?php echo $row['items']; ?> >> over to <?php echo $row['nickname']; ?>
                        <a href= "<?php echo site_url('home/go_pr/'.$ntf['modul_id'].'/1');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php  }  
                  }elseif($ntf['modul'] == 7) {
                    foreach ($que_wi as $row) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b><?php echo $row['nickname'];?></b> menambahkan Wishlist kepada Anda.
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/1');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php  }
                  }elseif($ntf['modul'] == '8') { 
                    foreach ($new_crm as $row) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['nickname'];?></b> membuat data prospek baru <b><?php echo $row['perusahaan']; ?></b>.
                        <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/1');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php  } 
                  }elseif($ntf['modul'] == '9') {
                    foreach ($new_project as $row) { ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname'];?></b> membuat data project baru <b><?php echo $row['perusahaan']; ?></b>.
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/1');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php  } 
                  }elseif ($ntf['modul'] == '12') { ?>
                    <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($new_imp['date_created'])); ?> <b><?php echo $new_imp['nickname'];?></b> membuat IMP baru. <b>IMP ID <?php echo $new_imp['id'] ?></b> : <?php echo $new_imp['keterangan'] ?>
                        <a href= "<?php echo site_url('home/go_hrd/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                  <?php }

                }elseif($ntf['record_type'] == 2){
                  
                  switch ($ntf['modul']) {
                    case '2':
                      foreach ($que2_do as $rows2) { ?>
                        <div class="alert alert-info" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($rows2['date_created'])); ?> <b><?php echo $rows2['no_so'];?></b> <?php echo $rows2['perusahaan']?> >> <b><?php echo $rows2['nickname'] ?></b> menambahkan pesan baru.
                          <a href= "<?php echo site_url('home/go_do2/'.$ntf['modul_id'].'/2/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;

                    case '3':
                      if($ntf['imp_id'] == 0) {
                        foreach ($que2 as $row2) { ?>
                          <div class="alert alert-info" style="font-size: 11px;" >
                            <?php $date = new DateTime($row2['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> <b><?php echo $row2['no_sps'];?></b> <?php echo $row2['perusahaan']?> >> <b><?php echo $row2['nickname'] ?></b> menambahkan pesan baru.
                            <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/2/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                          </div>
                        <?php }
                      }elseif($ntf['imp_id'] != 0){ //echo "pesan import ";  
                        foreach ($imp_ntf as $ntf_imp) { ?>
                          <div class="alert alert-info" style="font-size: 11px;" >
                            <?php $date = new DateTime($ntf_imp['date_created']); echo date_format($date, 'd-m-Y H:i:s');?> Import <b><?php echo $ntf_imp['shipment'];?></b>  >> <b><?php echo $ntf_imp['nickname'] ?></b> menambahkan pesan baru.
                            <a href= "<?php echo site_url('home/go_imp/'.$ntf['imp_id'].'/2/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                          </div>
                        <?php }
                      }
                      break;

                    case '5':
                      foreach ($que2_pr as $rows2) { ?>
                        <div class="alert alert-info" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($rows2['date_created'])); ?> <b>Purchase ID <?php echo $rows2['id'];?></b> >> <b><?php echo $rows2['nickname'] ?></b> menambahkan pesan baru.
                          <a href= "<?php echo site_url('home/go_pr2/'.$ntf['modul_id'].'/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;
                      
                    case '7':
                      foreach ($psn_wish as $row) { ?>
                        <div class="alert alert-info" style="font-size: 11px;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b><?php echo $row['nickname']; ?></b> menambahkan pesan baru pada wishlist <?php echo $row['title'] ?>.
                            <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/2');?>" name="go" class="btn btn-default btn-xs">GO</a>
                          </div>
                      <?php  }
                      break;
                      
                    case '8':
                      foreach ($psn_crm as $row) { ?>
                        <div class="alert alert-info" style="font-size: 11px;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['nickname']; ?></b> menambahkan pesan baru pada data prospek <?php echo $row['perusahaan']; ?>.
                            <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/2');?>" name="go" class="btn btn-default btn-xs">GO</a>
                          </div>
                      <?php  }
                      break;

                    case '9':
                      foreach ($psn_project as $row) { ?>
                        <div class="alert alert-info" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname']; ?></b> menambahkan pesan baru pada project <?php echo $row['perusahaan']; ?>.
                          <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/2');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '10': ?>
                      <div class="alert alert-info" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($psn_cash['date_created'])); ?> <b><?php echo $psn_cash['nickname']; ?></b> menambahkan pesan baru pada <b>Cash <?php echo $psn_cash['tipe_cash']; ?> ID <?php echo $psn_cash['id'] ?></b> [ <?php echo $psn_cash['alasan_pembelian'] ?> ].
                        <a href= "<?php echo site_url('home/go_cash/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div> 
                      <?php
                      break;

                    case '12': ?>
                      <div class="alert alert-info" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($psn_imp['date_created'])); ?> <b><?php echo $psn_imp['nickname']; ?></b> menambahkan pesan baru pada <b>IMP ID <?php echo $psn_imp['id']; ?></b> : <?php echo $psn_imp['keterangan'] ?>.
                        <a href= "<?php echo site_url('home/go_hrd/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div> 
                      <?php
                      break;  

                  }

                }elseif($ntf['record_type'] == 3) {
                  switch ($ntf['modul']) {
                    case '2':
                      foreach ($que3_do as $rows3) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($rows3['date_created'])); ?> <b><?php echo $rows3['no_so'];?></b> <?php echo $rows3['perusahaan']?> >> <b><?php echo $rows3['nickname'] ?></b> menambahkan file baru.
                          <a href= "<?php echo site_url('home/go_do2/'.$ntf['modul_id'].'/3/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;

                    case '3':
                      foreach ($que3 as $row3) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php $date = new DateTime($row3['date_created']); echo date_format($date, 'd-m-Y H:i:s');?> <b><?php echo $row3['no_sps'];?></b> <?php echo $row3['perusahaan']?> >> <b><?php echo $row3['nickname'] ?></b> menambahkan file baru.
                          <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/3/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;

                    case '5':
                      foreach ($upl_pr as $row) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b>PR <?php echo $row['id']; ?></b> <?php echo $row['items']; ?> >> <b><?php echo $row['nickname']; ?></b> menambahkan file baru.
                          <a href= "<?php echo site_url('home/go_pr/'.$ntf['modul_id'].'/3');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '7':
                      foreach ($upl_wish as $row) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b><?php echo $row['nickname']; ?></b> menambahkan file baru pada wishlist <?php echo $row['title']; ?>
                          <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/3');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '8':
                      foreach ($upl_crm as $row) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['nickname']; ?></b> menambahkan file baru pada prospek <?php echo $row['perusahaan']; ?>
                          <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/3');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '9':
                      foreach ($upl_project as $row) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname']; ?></b> menambahkan file baru pada project <?php echo $row['perusahaan']; ?>
                          <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/3');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '10': ?>
                      <div class="alert alert-danger" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($upl_cash['date_created'])); ?> <b><?php echo $upl_cash['nickname']; ?></b> menambahkan file baru pada <b>Cash <?php echo $upl_cash['tipe_cash'] ?> ID <?php echo $upl_cash['id'] ?></b> [ <?php echo $upl_cash['alasan_pembelian']; ?> ]
                        <a href= "<?php echo site_url('home/go_cash/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                      <?php
                      break;

                    case '11':
                      foreach ($upl_pricelist as $row) { ?>
                        <div class="alert alert-danger" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [PRICELIST] File <b><?php echo str_replace('_', ' ', strtoupper($row['file_name'])); ?></b> ditambahkan ke dalam Folder Pricelist.
                          <a href= "<?php echo site_url('home/go_pricelist/'.$ntf['id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php  }
                      break;

                    case '12': ?>
                      <div class="alert alert-danger" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($upl_imp['date_created'])); ?> <b><?php echo $upl_imp['nickname']; ?></b> menambahkan file baru pada <b>IMP ID <?php echo $upl_imp['id'] ?></b> : <?php echo $upl_imp['keterangan']; ?>
                        <a href= "<?php echo site_url('home/go_hrd/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                      <?php
                      break;
                    
                  }
                            
                }elseif($ntf['record_type'] == 4) {
                  switch ($ntf['modul']) {
                    case '3':
                      foreach ($que4 as $row4) { ?>
                        <div class="alert alert-warning" style="font-size: 11px;" >
                          <?php $date = new DateTime($row4['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> <b><?php echo $row4['nickname'] ?></b> menunda <b><?php echo $row4['no_sps'];?></b> <?php echo $row4['perusahaan']?>
                          <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/4/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;
                    
                    case '7': ?>
                        <div class="alert alert-warning" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($pause_wi['date_created'])); ?> <b><?php echo $pause_wi['nickname'] ?></b> menunda <b>Wishlist ID <?php echo $pause_wi['id'];?></b> <?php echo $pause_wi['title']?>
                          <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/4/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php 
                      break;
                    }  
                }elseif($ntf['record_type'] == 5 ){
                  switch ($ntf['modul']) {
                    case '3':
                      foreach ($que5 as $row5) { ?>
                        <div class="alert alert-default" style="font-size: 11px;" >
                          <?php $date = new DateTime($row5['date_created']); echo date_format($date, 'd-m-Y H:i:s');?> <b><?php echo $row5['nickname'] ?></b> mengaktifkan <b>Play</b> untuk <b><?php echo $row5['no_sps'];?></b> <?php echo $row5['perusahaan']?>
                          <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/5/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;
                    
                    case '7': ?>
                      <div class="alert alert-default" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($play_wi['date_created'])); ?> <b><?php echo $play_wi['nickname'] ?></b> melanjutkan <b>Wishlist ID <?php echo $play_wi['id'];?></b> <?php echo $play_wi['title']?>
                          <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/5/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                    <?php  break;
                  }
                }elseif($ntf['record_type'] == 6){ 
                  foreach ($res6 as $imp_start) { ?>
                    <div class="alert alert-default" style="font-size: 11px;" id="imp_start">
                      <?php $date = new DateTime($imp_start['date_created']); echo date_format($date, 'd-m-Y H:i:s');?> Komponen telah diimport dengan ID Import <b><?php echo $imp_start['shipment']?></b>
                      <a href= "<?php echo site_url('home/go_imp/'.$imp_start['imp_id'].'/6/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php } 
                }elseif ($ntf['record_type'] == 7) { 
                  foreach ($res7 as $ntf_imp) { ?>
                    <div class="alert alert-default" style="font-size: 11px;" id = "imp_finish">
                      <?php $date = new DateTime($ntf_imp['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> Import Komponen dengan ID Import <b><?php echo $ntf_imp['shipment'] ?></b> telah selesai dilakukan. 
                      <a href= "<?php echo site_url('home/go_imp/'.$ntf_imp['imp_id'].'/7/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php }  
                }elseif($ntf['record_type'] == 8){
                  foreach ($booking as $book){ //echo " 8"; ?>
                    <div class = "alert alert-default" style="font-size : 11px" id = "imp_booking">
                      <?php $date = new DateTime($book['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> Komponen <b><?php echo $book['kode']; ?></b> telah dipesan oleh <b><?php echo $book['nickname']; ?></b> dengan Shipment <b><?php echo $book['shipment']?> </b> 
                      <a href="<?php echo site_url('home/go_imp/'.$book['imp_id'].'/8/'); ?>" name = "go" class="btn btn-default btn-xs">GO</a>
                    </div>
                 <?php  } 
                }elseif ($ntf['record_type'] == 9) {
                    if($ntf['modul'] == '3') {
                      foreach ($execution as $exe) { ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color :  #d9b3ff" >
                        <?php $date = new DateTime($exe['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> <b><?php echo $exe['no_sps'];?></b> <?php echo $exe['perusahaan']?> >> dieksekusi oleh <b><?php echo $exe['nickname'] ?></b>. 
                        <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/9/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php }
                  }elseif($ntf['modul'] == '9') {
                    foreach ($exe_project as $exe) { ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color :  #d9b3ff" >
                        <?php echo date('d-m-Y H:i:s', strtotime($exe['date_created'])); ?> [DHC] <b>Project ID <?php echo $exe['id'];?></b> >> <b><?php echo $exe['perusahaan']?></b> dibuah menjadi <b><?php echo $exe['execution'] ?></b>. 
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/9/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php }
                  }
                }elseif ($ntf['record_type'] == 10) {
                  foreach ($cancel_exe as $exe) { ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color :  #BDB6BF" >
                        <?php $date = new DateTime($exe['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?> <b><?php echo $exe['nickname'] ?></b> membatalkan eksekusi <b><?php echo $exe['no_sps'];?></b> <?php echo $exe['perusahaan']?>
                        <a href= "<?php echo site_url('home/go2/'.$ntf['modul_id'].'/10/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php }
                }elseif ($ntf['record_type'] == 12) {
                  foreach ($tl_kill as $kill) { ?>
                    <div class="alert alert-kill-tools" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($kill['date_created'])); ?> <b><?php echo $kill['nickname'] ?></b> propose to KILL <b><?php echo $kill['code'];?> : <?php echo $kill['name']; ?></b>. 
                        <a href= "<?php echo site_url('home/go_tools/'.$ntf['id'].'/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php } 
                }elseif ($ntf['record_type'] == 13) {
                  switch ($ntf['modul']) {
                    case '2': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #d9b9ea;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($appr_do['date_created'])); ?> <b><?php echo $appr_do['nickname'] ?></b> mengajukan <b><?php echo $appr_do['do_status'] ?></b> Delivery ID <b><?php echo $appr_do['id']?></b> >> <?php echo $appr_do['perusahaan'] ?>.
                            <a href= "<?php echo site_url('home/go_do2/'.$ntf['modul_id'].'/13');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                    <?php break;
                    case '5':
                      foreach ($appr_pr as $row) { ?>
                      <div class="alert alert-progress" style="font-size: 11px;" >
                          <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b>PR ID <?php echo $row['id']?></b> >> Need to be Approved.
                          <a href= "<?php echo site_url('home/go_pr/'.$ntf['modul_id'].'/13');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                      <?php }
                    break;
                    case '8':
                      foreach ($appr_crm as $row) { ?>
                        <div class="alert alert-default" style="font-size: 11px; background-color: #f4f765;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b><?php echo $row['nickname'] ?></b> mengajukan Penurunan Progress pada <b>CRM ID <?php echo $row['id']?></b> >> <?php echo $row['perusahaan'] ?>.
                            <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/13');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php } 
                      break;
                    case '10': ?>
                        <div class="alert alert-default" style="font-size: 11px; background-color: #f4f765;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($appr_cash['date_created'])); ?> <b>CASH <?php echo $appr_cash['tipe_cash'] ?> ID <?php echo $appr_cash['id'] ?></b> <?php echo $appr_cash['alasan_pembelian'] ?> <b>by <?php echo $appr_cash['nickname'] ?></b> >> need to be approved.
                            <a href= "<?php echo site_url('home/go_cash/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                    <?php 
                    break;       
                  }
                     
                }elseif ($ntf['record_type'] == 14) { 
                  switch ($ntf['modul']) {
                    case '10': ?>
                      <div class="alert alert-progress" style="font-size: 11px; background-color: #899fc1;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($rcv_cash['date_created'])); ?> <b>CASH <?php echo $rcv_cash['tipe_cash'] ?> ID <?php echo $rcv_cash['id'] ?></b> <?php echo $rcv_cash['alasan_pembelian'] ?> <b>by <?php echo $rcv_cash['nickname'] ?></b> >> need to be received.
                            <a href= "<?php echo site_url('home/go_cash/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                    <?php 
                    break;
                  }
                
                }elseif ($ntf['record_type'] == 15) {
                  foreach ($prgs_wi as $row) { ?>
                    <div class="alert alert-progress" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b>Wishlist ID <?php echo $row['id']?></b> <?php echo $row['title']; ?> >> Progress Updated to <b><?php echo $row['progress']; ?>%</b> By <b><?php echo $row['nickname']; ?></b> 
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/15');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php }  
                }elseif ($ntf['record_type'] == '16') {
                  switch ($ntf['modul']) {
                    case '2': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #aae2c1;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($cont_do['date_created'])); ?> <b>Delivery ID <?php echo $cont_do['id'];  ?></b> <?php echo $cont_do['perusahaan'] ?> >> <b><?php echo $cont_do['nickname'] ?></b> menambahkan Anda sebagai Contributor.
                            <a href= "<?php echo site_url('home/go_do3/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php 
                      break;

                    case '5': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #aae2c1;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($cont_pr['date_created'])); ?> <b>PR ID <?php echo $cont_pr['id'];  ?></b> >> <b><?php echo $cont_pr['nickname'] ?></b> menambahkan Anda sebagai Contributor.
                            <a href= "<?php echo site_url('home/go_pr/'.$ntf['modul_id'].'/16');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php 
                      break;

                    case '7': ?>
                        <div class="alert alert-default" style="font-size: 11px; background-color: #aae2c1;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($contributor_wi['date_created'])); ?> <b>[WISHLIST] </b><?php echo $contributor_wi['title'];  ?> >> <b><?php echo $contributor_wi['nickname'] ?></b> menambahkan Anda sebagai Contributor.
                            <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/16');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php 
                      break;

                      case '8':
                      foreach ($contributor_crm as $row) { ?>
                        <div class="alert alert-progress" style="font-size: 11px;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['perusahaan'];  ?></b> >> <b><?php echo $row['nickname'] ?></b> menambahkan Anda sebagai Contributor.
                            <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/16');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php }
                      break;

                      case '9':
                      foreach ($contributor_project as $row) { ?>
                        <div class="alert alert-progress" style="font-size: 11px;" >
                            <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname'] ?></b> menambahkan Anda sebagai Contributor pada <b>Project ID <?php echo $row['id']." >> ".$row['perusahaan'];  ?></b>
                            <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/16');?>" name="go" class="btn btn-default btn-xs">GO</a>
                        </div>
                      <?php } 
                      break;
                  }
                }elseif ($ntf['record_type'] == '17') {
                  foreach ($followup_crm as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color :  #d9b3ff" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['nickname'] ?></b> melakukan <b>Follow Up</b> pada data prospek <b><?php echo $row['perusahaan']; ?></b>
                        <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/17');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                  <?php }  
                }elseif ($ntf['record_type'] == '18') {
                  if($ntf['modul'] == '8') {
                    foreach ($progress_crm as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color :  #BDB6BF" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [CRM] <b><?php echo $row['nickname'] ?></b> mengupdate <b>Progress</b> pada data prospek <b><?php echo $row['perusahaan']; ?></b>
                        <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/18');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php } 
                  }elseif($ntf['modul'] == '9') {
                    foreach ($progress_project as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color :  #BDB6BF" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname'] ?></b> mengupdate <b>Progress</b> pada <b>Project ID <?php echo $row['id']." >> ".$row['perusahaan']; ?></b>
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/18');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                  <?php }  
                  }      
                }elseif ($ntf['record_type'] == '19') {
                  foreach ($appr_wi as $row) { ?>
                    <div class="alert alert-progress" style="font-size: 11px;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> <b>Wishlist ID <?php echo $row['id']?></b> <?php echo $row['title']; ?> >> Need to be Approved.
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id'].'/19');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php }  
                }elseif($ntf['record_type'] == 20) { 
                  foreach ($reminder_project as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color: #f7c588" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname']; ?></b> menambahkan reminder pada <b>Project ID <?php echo $row['id']; ?></b> >> <?php echo $row['perusahaan']; ?>
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/20');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php }  
                }elseif($ntf['record_type'] == 21) {
                  foreach ($deadline_project as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color: #77cea0" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] <b><?php echo $row['nickname']; ?></b> mengubah tanggal deadline menjadi <?php echo date('d-m-Y', strtotime($row['deadline'])) ?> pada <b>Project ID <?php echo $row['id']; ?></b> >> <?php echo $row['perusahaan']; ?> 
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/21');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php } 
                }elseif($ntf['record_type'] == 22) {
                  foreach ($tagih_project as $row) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color: #ff3333;" >
                        <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?> [DHC] Sales <b><?php echo $row['nickname']; ?></b> meminta Tim FA untuk Penagihan <b>Project ID <?php echo $row['id']; ?></b> >> <b><?php echo $row['perusahaan']; ?></b> 
                        <a href= "<?php echo site_url('home/go_dhc/'.$ntf['modul_id'].'/22');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php }
                }elseif($ntf['record_type'] == 23) {
                  foreach ($checked_import as $ntf_imp) { ?>
                    <div class="alert alert-default" style="font-size: 11px; background-color: #3cc3d8;">
                      <?php date('d-m-Y H:i:s', strtotime($ntf_imp['date_created'])); ?> Import Komponen dengan ID Import <b><?php echo $ntf_imp['shipment'] ?></b> telah tiba. Mohon dilakukan pengecekan komponen. 
                      <a href= "<?php echo site_url('home/go_imp/'.$ntf_imp['imp_id'].'/23/');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                  <?php } 
                }elseif($ntf['record_type'] == 24) {
                  switch ($ntf['modul']) {
                    case '7': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #40fdaf;" >
                        <?php echo date('d-m-Y h:i:s', strtotime($po_wi['date_created'])) ?> <b>REMINDER : </b> Segera realisasikan <b>Wishlist ID <?php echo $po_wi['id'] ?></b> : <?php echo $po_wi['title'] ?>.
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php break;

                    case '8': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #99e6e6; color: #000066;">
                      <?php echo date('d-m-Y H:i:s', strtotime($auto_reminder['date_created'])); ?> CRM ini sudah tidak ada update lebih dari 2 minggu. Segera Follow Up dan Update <b> CRM ID <?php echo $auto_reminder['modul_id'] ?> >> <?php echo $auto_reminder['perusahaan'] ?></b>. 
                      <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/24');?>" name="go" class="btn btn-default btn-xs">GO</a>
                    </div>
                    <?php break;
                  } ?>
                    
                  <?php
                }elseif($ntf['record_type'] == 26) { 
                  switch ($ntf['modul']) {
                    case '6': ?>
                      <div class="alert alert-info" style="font-size: 11px;" >
                        <?php echo date('d-m-Y h:i:s', strtotime($disc_imp['date_created'])) ?> Import <b><?php echo $disc_imp['shipment'];?></b>  >> <b><?php echo $disc_imp['nickname'] ?></b> menambahkan diskusi baru.
                        <a href= "<?php echo site_url('home/go_imp2/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php break;
                  }
                }elseif($ntf['record_type'] == 27) {
                  switch ($ntf['modul']) {
                    case '7': ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y h:i:s', strtotime($ho_wi['date_created'])) ?> <b><?php echo $ho_wi['nickname'] ?></b> melakukan handover <b> Wishlist ID <?php echo $ho_wi['id'] ?></b> : <?php echo $ho_wi['title'] ?> kepada Anda.
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php break;

                    case '8': ?>
                      <div class="alert alert-success" style="font-size: 11px;" >
                        <?php echo date('d-m-Y h:i:s', strtotime($chsls_crm['date_created'])) ?> [CRM] <b><?php echo $chsls_crm['user_id'] ?></b> melakukan <b>Change Sales</b> dari <b><?php echo $chsls_crm['sales_exist']?></b> ke <b><?php echo $chsls_crm['sales_new'] ?></b> pada data prospek <b><?php echo $chsls_crm['perusahaan']; ?></b>
                        <a href= "<?php echo site_url('home/go_crm/'.$ntf['modul_id'].'/27');?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php break;
                  }
                }elseif($ntf['record_type'] == 28) {
                  switch ($ntf['modul']) {
                    case '7': ?>
                      <div class="alert alert-default" style="font-size: 11px; background-color: #67c5fa;" >
                        <?php echo date('d-m-Y h:i:s', strtotime($po_wi['date_created'])) ?> Silahkan masukkan point pada <b> Wishlist ID <?php echo $po_wi['id'] ?></b> : <?php echo $po_wi['title'] ?>.
                        <a href= "<?php echo site_url('home/go_wishlist/'.$ntf['modul_id']);?>" name="go" class="btn btn-default btn-xs">GO</a>
                      </div>
                    <?php break;
                  }
                }
              } 
            }  ?>
        <!-- .panel-body -->
          </div>
        </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          NO. REKENING & KURS
        </div>
        <div class="panel-body">
      <div class="col-sm-6">
        <table class="table table-bordered" style="border: 1px;">
        <tbody>
        <tr>
          <td>
          <div class="center">
            <center>
            <img class="logo" src="<?php echo base_url('assets/images/logo-bca.png'); ?>"><br>
            
            No Rek : 309 128 6899 <br>
            A/n  : PT. Indotara Persada <br>
            KCP : Kedoya Baru, Jakarta <br>
            </center>
          </div>   
          </td>
          </tr>
        <tr>
          <td>
          <div class="center">
            <center>
            <img class = "lg-uob" src="<?php echo base_url('assets/images/logo-uob.png'); ?>"><br>
            
            No Rek : 597 300 1818 <br>
            A/n  : PT. Indotara Persada <br>
            KCP : Kebon Jeruk <br>
            </center>
          </div>  
          </td>
        </tr>
        <tr>
          <td>
          <div class="center">
            <center>
            <img class="lg-panin" src="<?php echo base_url('assets/images/logo-panin.png'); ?>"><br>
            No Rek : 175 500 1656 <br>
            A/n  : PT. Indotara Persada <br>
            KCP : Graha Kencana <br>
            </center>  
          </div> 
          </td>
          </tr>
        <tr>
          <td>
          <div class="center"> 
            <center>
            <img class = "lg-mandiri" src="<?php echo base_url('assets/images/logo-mandiri.png'); ?>"><br>
            No Rek : 1650 03128 9995 <br>
            A/n  : PT. Indotara Persada <br>
            KCP : Kebon Jeruk Perjuangan<br>
            </center>
          </div>  
          </td>
        </tr>
        </tbody>
      </table>
      </div>
          
        <div class="col-sm-6">
          <div class="alert alert-info text-center">
            <b> USD</b>
            <p><b>Rp. <?php echo $c_kurs['kurs']; ?></b>
            <br>
            <span style="font-size: 10px;">Last Update <?php echo date('d-m-Y', strtotime($c_kurs['tgl_ambil']))." ".$c_kurs['wkt_ambil']; ?></span>
            </p>
          </div>
    
      <form method="get" action="">
        <div class="input-group">
          <input type="text" class="form-control" name="tglkurs" id="tgl" placeholder="Search Kurs">
          <div class="input-group-btn">
            <button type="submit" name="search" id="search" class="btn btn-primary btn-rad"><i class="fa fa-search" ></i></button>
          </div>
        </div>
         <br>

        <?php if(isset($_GET['search']))
        {
          $tgl = $_GET['tglkurs'];
          $sql = "SELECT tgl_ambil, wkt_ambil, kurs FROM tbl_kurs WHERE tgl_ambil = '$tgl' AND currency = 'USD'";
          $que = $this->db->query($sql)->result_array();
          $num_rows = $this->db->query($sql)->num_rows(); ?>

          
          <div class="alert alert-danger text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php if($num_rows > 0){
                foreach ($que as $row) { ?>
                <b> <center>USD</center></b>
                <span style="font-size: 11px;"><?php $a = new DateTime($row['tgl_ambil']); echo date_format($a, 'd-m-Y'); ?> <?php echo $row['wkt_ambil']; ?></span><br> 
                <b style="font-size: 11.5px;">Rp. <?php echo $row['kurs']; ?></b><hr style="margin: 4px;">           
              <?php  }
            }else{
              echo '<b>DATA NOT FOUND !</b>';
            } ?>
          </div>
        <?php } ?>
      </form>
        </div>

        <!-- BATAS KURS USD -->

    <div class="col-sm-6">
      <div class="alert alert-success text-center">
        <b>EUR</b>
        <p><b>Rp. <?php echo $c_kurs_eur['kurs']; ?></b>
          <br>
          <span style="font-size: 10px;">Last Update <?php echo date('d-m-Y', strtotime($c_kurs_eur['tgl_ambil']))." ".$c_kurs_eur['wkt_ambil']; ?></span>
        </p>
      </div>
      <form method="get" action="">
        <div class="input-group">
          <input type="text" class="form-control" name="tglkurs" id="tgl-eur" placeholder="Search Kurs EUR">
          <div class="input-group-btn">
            <button type="submit" name="cari" id="cari" class="btn btn-primary btn-rad"><i class="fa fa-search" ></i>
            </button>
          </div>
        </div>
        <br>

        <?php if(isset($_GET['cari']))
        {
          $tgl = $_GET['tglkurs'];
          $sql = "SELECT currency,tgl_ambil, wkt_ambil, kurs FROM tbl_kurs WHERE currency='EUR' AND tgl_ambil = '$tgl'";
          $que = $this->db->query($sql)->result_array();
          $num_rows = $this->db->query($sql)->num_rows(); ?>

          
          <div class="alert alert-danger text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php if($num_rows > 0){
                foreach ($que as $row) { ?>
                <b> <center>EUR</center></b>
                <span style="font-size: 11px;"><?php $a = new DateTime($row['tgl_ambil']); echo date_format($a, 'd-m-Y'); ?> <?php echo $row['wkt_ambil']; ?></span><br> 
                <b style="font-size: 11.5px;">Rp. <?php echo $row['kurs']; ?></b><hr style="margin: 4px;">           
              <?php  }
            }else{
              echo '<b>DATA NOT FOUND !</b>';
            } ?>
          </div>
        <?php } ?>
      </form>
    </div> 

        </div>
      </div>
    <div class="panel panel-default">
        <div class="panel-heading">
          NOTES - Hanya dapat dilihat masing masing user saja. (TIDAK DISHARE)
        </div>
        <div class="panel-body panel-notes">
          <form action="<?php echo site_url('Home/saveNotes'); ?>" method="POST">
            <textarea rows="5" name ="txt" id="fr"><?= !empty($notes['notes']) ? $notes['notes'] : ''; ?></textarea>
          </form>
        </div>
    </div>
      </div>
</div>
<script>
        /* $('#tgl').datepicker(
        {
            format: 'yyyy-mm-dd',
            autoclose: true,
            endDate: new Date(),
            orientation:'botton auto',
            });
         
         $('#tgl-popup').datetimepicker({

      format: 'YYYY-MM-DD',
      //maxDate: new Date()
      }); */
  CKEDITOR.replace('fr', {
    customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js'); ?>',
    height : 600
  });

  CKEDITOR.replace('fr2', {
    customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js'); ?>',
    height : 200
  });
  $('#tgl,#tgl-eur').datetimepicker({
    format: 'YYYY-MM-DD',
  });

  function CheckNotification()
  { 
    $.post('<?php echo site_url('Home'); ?>');  
  }
  setInterval(CheckNotification, 5000 );

  $('#myTabs').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });

</script>

<script language="javascript" type="text/javascript"> 
/*      function disableselect(e) {             
          return false 
      } 
      function reEnable() { 
          return true 
      } 

      document.onselectstart = new Function("return false") 

      if (window.sidebar) { 
          document.onmousedown = disableselect                    
      } 

      function clickIE() { 
          if (document.all) { 
              (message); 
              return false; 
          } 
      } 
      
      document.oncontextmenu = new Function("return false") 
      var element = document.getElementById('tbl'); 
      element.onmousedown = function () { return false; } */
     //var ele = $("input");
      //alert(ele);

       // document.oncontextmenu = new Function("return false")

      //document.oncontextmenu = new Function("return false")

     // $('input').bind('contextmenu', function(e){

      //alert("We're sorry. Right-Click is not available");

      //return true;

      //});
      
</script>
