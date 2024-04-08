<style>
  .lb-pause{
    font-size: 10.5px;
    background: #000000;
  }

  #t_import{
    background-color: #ffff4d;
  }
</style>
  
  <table class="table table-hover" style="overflow: auto; font-size: 11.125px;">
    <thead>
      <tr>
        <th>No. </th>
        <th>Date & Time</th>
        <th>Operator</th>
        <th style="width: 150px;">Timer</th>
        <th>Message</th>
      </tr>   
    </thead>
       
    <tbody>
      <?php
        if($detail_table){
          $x = 1;
            foreach($detail_table as $key => $row){
              if($x == 1){ ?> 
                <tr>
                  <td><?php echo $x; ?></td>
                  <td width = "10px">
                  <?php $a = new DateTime($row['date_create'] );
                  echo date_format($a, 'd-m-Y H:i:s');  ?>
                    

                  </td>
                  <td><?php echo $row['nama']; ?><br>
                      (<?php echo $row['position'] ?>)
                  </td>
                  <td >Idle : 0d 0h 0m <br> 
                      Response : 0d 0h 0m <br>
                      Process : 0d 0h 0m
                  </td>
                  <td>
                    <?php if(!empty($row['log_notes'])){ ?>
                      <?php echo $row['log_notes']; ?><br>
                    <?php } ?>

                    <?php 
                      $idSPS = $this->uri->segment(3);
                      $sql = "SELECT a.sender_id, a.pesan, b.nickname, a.date_created FROM tbl_pesan as a JOIN tbl_loginuser as b ON a.sender_id = b.karyawan_id
                         WHERE a.sps_id = '$idSPS' AND a.log_sps_id = '0'";
                      $hasil = $this->db->query($sql)->result_array();
               
                      foreach($hasil as $hasil_row) 
                      {
                        
                        echo $hasil_row['date_created'].' <b style="color:#3992b0;">'.$hasil_row['nickname'].'</b> : '.$hasil_row['pesan'].'<br>'; 
                      } ?>
                    
                    <?php
                      $sql_pesan = "SELECT a.id as id_pesan, a.pesan, b.nickname, a.date_created FROM tbl_pesan as a 
                        JOIN tbl_loginuser as b ON b.karyawan_id = a.sender_id 
                        WHERE log_sps_id = ".$row['id']." 
                        ORDER BY id_pesan ASC";
                      $query_pesan = $this->db->query($sql_pesan)->result_array();

                      foreach($query_pesan as $dt)
                      {
                        $a = new DateTime($dt['date_created']);
                        echo date_format($a, 'd-m-Y H:i:s').' <b style="color:#3992b0;">'.$dt['nickname'].'</b> : '.$dt['pesan'].'<br>';          
                      } ?>

                    <?php if($detail_row == 1): ?>
                      <br><a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-info"><span class="fa fa-plus"></span> Message</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning"><span class="fa fa-plus"></span> Files</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalPause" class="btn btn-xs btn-default"><span class="fa fa-pause"></span> Pause</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalPlay" class="btn btn-xs btn-success"><span class="fa fa-play"></span> Play</a>
                    <?php   endif ?>          
                  </td>
                </tr>

              <?php }else{ ?>
                <tr>
                  <?php $start = date('Y/m/d H:i:s', strtotime($detail_table[$key]['date_create'])); ?>
                  <?php $date = datediff($start, date('Y/m/d H:i:s')); ?>

                  <?php $time_nextto = date('Y/m/d H:i:s', strtotime($detail_table[$key]['time_nextto']));
                        $time_login = date('Y/m/d H:i:s', strtotime($detail_table[$key-1]['time_login'])); 
                        // print_r($time_login);
                        $date_process = datediff($time_login, date('Y/m/d H:i:s'));
                        ?>
                  <?php $time_process = datediff($time_login, $time_nextto); ?>
                  <?php
                    $idle_start = date('Y/m/d H:i:s', strtotime($detail_table[$key-1]['time_nextto']));
                    $idle_date = datediff($idle_start, date('Y/m/d H:i:s')); 
                    $idle_end = date('Y/m/d H:i:s', strtotime($detail_table[$key-1]['time_idle']));
                    $idle = datediff($idle_start, $idle_end); ?>
                  <?php 
                    $idSPS = $this->uri->segment(3);
                    $sql_min = "SELECT min(date_create) FROM tbl_sps_log WHERE id_sps = $idSPS";
                    $query = $this->db->query($sql_min);
                    $array = $query->row_array();
                    $change = implode('', $array);
                    $min = date('Y/m/d H:i:s', strtotime($change)); 
                    $max = date('Y/m/d H:i:s', strtotime($detail_table[$key]['date_create']));
                    $respons_time = datediff($max, $min); 
                  ?>

                  <td><?php echo $x; ?></td>
                  <td><?php $a = new DateTime($row['date_create'] );
                    echo date_format($a, 'd-m-Y H:i:s'); ?></td>
                  <td><?php 
                    if ($row['nama'] == 'Pause'){
                      echo '<br><label class = "label label-default lb-pause"><span class = "fa fa-pause"></span>  Pause</label>';
                    }else{
                      echo $row['nama']; ?><br>
                      (<?php echo $row['position']; ?>)
                    <?php  } ?>
                  </td>
                  <td>
                  <!--  IDLE TIME -->
                    <?php 
                      $karyawanID = $_SESSION['myuser']['karyawan_id'];
                      $idSPS = $this->uri->segment(3);
                      $zz = $detail_table[$key-1]['id'];
                          //print_r($zz);
                      $sql = "SELECT time_idle, time_login, time_nextto FROM tbl_sps_log WHERE id_sps = '$idSPS' AND id = '$zz'";
                      $aa = $this->db->query($sql)->result_array();
                        
                        foreach ($aa as $key => $a) {
                          if ($a['time_idle'] == '0000-00-00 00:00:00' AND $a['time_nextto'] == '0000-00-00 00:00:00') {  //echo "idle mati"; ?>
                             Idle : 0d 0h 0m<br>
                          <?php }elseif($a['time_idle'] == '0000-00-00 00:00:00' AND $a['time_nextto'] != '0000-00-00 00:00:00'){ //echo "idle jalan"; ?>  
                              <input type="hidden" class = "date_start_time" value="<?php echo $idle_start; ?>">
                              Idle : <span name="logtime"> </span><br />
                          <?php }else{ //echo "hasil idle"; ?>
                            Idle : <?php echo $idle['days_total']; ?>d <?php echo $idle['hours']; ?>h <?php echo $idle['minutes']; ?>m<br>
                          <?php  } 
                        } ?>   
                  
                  <!-- RESPONE TIME -->
                    Response : <?php echo $respons_time['days_total']; ?>d <?php echo $respons_time['hours']; ?>h <?php echo $respons_time['minutes']; ?>m<br />

                  <!-- PROCESS TIME -->
                    <?php
                    $xx = $row['id']; 
                    $sql = "SELECT id, overto, time_login, time_nextto FROM tbl_sps_log WHERE id_sps = '$idSPS' AND id = '$xx'";
                    $quer = $this->db->query($sql)->row_array();
                   // print_r($quer['time_nextto']);

                    $sql1 = "SELECT id, overto, time_login, time_nextto FROM tbl_sps_log WHERE id_sps = '$idSPS' AND id = '$zz'";
                    $query = $this->db->query($sql1)->row_array();
                   //print_r($query);
                    if($query['time_login'] == '0000-00-00 00:00:00'){
                      echo 'Process : 0d 0h 0m';
                    }elseif($query['time_login'] != '0000-00-00 00:00:00' AND $quer['time_nextto'] == '0000-00-00 00:00:00'){ ?>
                      <input type="hidden" class = "date_start_time" value = "<?php echo $time_login; ?>">
                      Process : <span name="logtime"></span>
                    <?php }elseif($query['time_login'] != '0000-00-00 00:00:00' AND $quer['time_nextto'] != '0000-00-00 00:00:00'){
                     echo "Process : ".$time_process['days_total']."d ".$time_process['hours']."h ".$time_process['minutes']."m"; 
                    }

                    ?>
                  </td>
                  <td>
                    <?php if(!empty($row['log_notes'])){ ?>
                      <?php echo $row['log_notes']; ?><br>
                    <?php } ?>
                    <?php
                      $sql_pause = "SELECT a.user_pause, a.date_pause, a.alasan, b.nickname
                      FROM tbl_pause as a LEFT JOIN tbl_loginuser as b ON a.user_pause = b.karyawan_id WHERE sps_id = ".$row['id_sps']." AND log_sps_id = ".$row['id']."";
                        $que_pause = $this->db->query($sql_pause)->result_array();

                      $sql_pesan = "SELECT a.log_sps_id, a.id as id_pesan, a.pesan, a.import_id, b.nickname, a.date_created, a.sender_id, a.import_type, c.arrival, c.dept, c.ship_via, c.shipment, c.id as id_imp, c.kedatangan, d.nickname as nama, g.product FROM tbl_pesan as a 
                        LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.sender_id
                        LEFT JOIN tbl_import as c ON c.id = a.import_id
                        LEFT JOIN tbl_loginuser as d ON d.karyawan_id = c.ship_to
                        LEFT JOIN tbl_import_booking as e ON e.id = a.pesan
                        LEFT JOIN tbl_import_product as f ON f.id = e.import_product_id
                        LEFT JOIN tbl_product as g ON g.id = f.product_id
                        WHERE a.sps_id = ".$this->uri->segment(3)." AND log_sps_id = ".$row['id']."     
                        GROUP BY id_pesan ASC";
                      $query_pesan = $this->db->query($sql_pesan)->result_array();
                     
                     foreach ($que_pause as $key => $val) {
                        if(!empty($val['alasan'])){ 
                          $d = new DateTime($val['date_pause']);
                          echo date_format($d, 'd-m-Y H:i:s').' <b>'.$val['nickname'].'</b> : Paused <br>';
                          echo '<b>Alasan : </b>'.$val['alasan'].'<br>';
                        }else{ 
                          $d = new DateTime($val['date_pause']);
                          echo date_format($d, 'd-m-Y H:i:s').' <b>'.$val['nickname'].'</b> : Play <br>';    
                        }            
                      }
            
                      foreach($query_pesan as $dt)
                      { ?>
                        <?php
                         $count = str_word_count($dt['pesan']);
                         $huruf = strlen($dt['pesan']);
                          
                        if($dt['import_type'] == 0 AND $dt['date_created'] === "0000-00-00 00:00:00"){
                          echo "0000-00-00 00:00:00 "."<b style = 'color: #3992b0'; >".$dt['nickname']."</b> : ".$dt['pesan']."<br>";
                        }elseif(strpos($dt['pesan'], 'FINISHED') !== false AND $huruf == 8){
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;"><?php echo $dt['nickname']; ?></b> : ****** <b><span style="background-color: #00FF00;">FINISHED</span></b> *******<br />
                        <?php }elseif ($dt['import_type'] == 0 ) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;"><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br>
                        
                        <?php }elseif ($dt['import_type'] == 1) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;" id="t_import"><?php echo $dt['nickname']; ?></b> : Permintaan komponen telah diimport dengan ID Import <a target="_blank" href="<?php echo site_url('c_import/details/'.$dt['pesan']);?>"><?php echo $dt['shipment']; ?></a> [ Departure : <?php echo date('d-m-Y', strtotime($dt['dept'])); ?>; Arrival : <?php echo date('d-m-Y', strtotime($dt['arrival'])); ?>; by <?php echo $dt['ship_via'] ?> ]<br> 
                        
                        <?php }elseif ($dt['import_type'] == 2) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;" id="t_import"><?php echo $dt['nickname']; ?></b> : Import Komponen telah selesai dilakukan dengan ID import <a target="_blank" href="<?php echo site_url('c_import/details/'.$dt['id_imp']); ?>"><?php echo $dt['shipment']; ?></a> <?php echo $dt['pesan']; ?>, kepada pihak2 terkait harap segera mengurus SO komponen tersebut untuk melanjutkan service ini.<br />
                        
                        <?php }elseif ($dt['import_type'] == 3) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;" id="t_import"><?php echo $dt['nickname']; ?></b> : Import komponen <span style="color: #FF2F00;"><?php echo $dt['product']?></span> dijalankan dengan ID import <a target="_blank" href="<?php echo site_url('c_import/details/'.$dt['id_imp']); ?>"><?php echo $dt['shipment']; ?></a> dan akan diterima oleh <?php echo $dt['nama']?> (ETA : <?php echo date('d-m-Y', strtotime($dt['arrival'])); ?>) di <?php echo $dt['kedatangan']?><br />
                        
                        <?php }elseif ($dt['import_type'] == 4) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0;" id="t_import"><?php echo $dt['nickname']; ?></b> : Import Komponen <span style="color: #FF2F00;"><?php echo $dt['product']; ?></span> telah selesai dilakukan dengan ID import <a target="_blank" href="<?php echo site_url('c_import/details/'.$dt['id_imp']); ?>"><?php echo $dt['shipment']; ?></a> dan diterima oleh <?php echo $dt['nama']; ?>, kepada pihak2 terkait harap segera mengurus SO komponen tersebut untuk melanjutkan service ini.<br />

                        <?php }elseif ($dt['import_type'] == 5) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0; background-color : #8cff1a"><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br>
                       
                        <?php }elseif ($dt['import_type'] == 6) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0; background-color : #ff80ff"><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br>
                        
                        <?php }elseif($dt['import_type'] == 7){
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="background-color: yellow; "><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br/>
                          <br />
                          <b>>>>>>></b> &nbsp <b><span style="background-color: #00FFFF">MASUK KE TAHAP SELANJUTNYA : MELENGKAPI BARANG YANG TELAH DIKANIBAL AGAR SIAP DIJUAL KEMBALI</span></b> &nbsp <b>>>>>>></b>  
                          <br>
                          <br>
    
                          <ul class="list-unstyled">
                            <li><b> PERINGATAN :  </b></li>
                            <ul >
                              <li>Sales yang bersangkutan bertanggung jawab memproses pengadaan komponen untuk melengkapi barang yg telah dikanibal baik via lokal maupun import, dan mengawasi sampai lengkap kembali.</li>
                              <li>Pihak-pihak terkait wajib membantu pengadaan dan pelaksanaan pemasangannya agar dapat segera dijual kembali.</li>
                              <li>Packing kardus barang yg telah dikanibal harus dipelihara baik-baika sampai barang dilengkapi kembali agar siap untuk dijual.</li>
                              <li>Proses kanibal jangan sampai menyebabkan kerusakan paking, kerusakan barang, kehilangan aksesoris yg menyebabkan barang sulit untuk dijual kembali.</li>
                              <li>Proses kanibal tidak boleh menyisakan kerusakan apa pun pada barang yg dikanibal.</li>
                            </ul>
                          </ul>
                         
                        <?php }elseif ($dt['import_type'] == 8) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="background-color: yellow; "><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br/>
                          
                           &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp<b>>>>>>>>>>>>>>>>>>></b> &nbsp <b><span>JOB KANIBAL TUNTAS, BARANG TELAH KEMBALI SEPERTI SEMULA</span></b> &nbsp <b>>>>>>>>>>>>>>>>>>></b>  <br><br />

                        <?php }elseif ($dt['import_type'] == 9) {
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:#3992b0; background-color : #8cff1a"><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br>
                        <?php }elseif ($dt['import_type'] == 10){
                          $a = new DateTime($dt['date_created']);
                          echo date_format($a, 'd-m-Y H:i:s'); ?> <b style="color:black; background-color : yellow; "><?php echo $dt['nickname']; ?></b> : <?php echo $dt['pesan']; ?><br>
                        <?php }
                      }   ?>

                      <?php if($x == $detail_row AND $_SESSION['myuser']['role_id'] != '15'){ ?>
                        <br><a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-info data-record"><span class="fa fa-plus" data-id = "<?php echo $row['overto']; ?>"></span> Message</a>
                
                        <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning"><span class="fa fa-plus"></span> Files</a>

                        <?php if(in_array($exec['jenis_pekerjaan'], array('1', '2', '3', '5', '6', ''))) { ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#myModalLink" class="btn btn-xs btn-default" style="background-color: #B19BD9; border-color: #B19BD9; color: white;"><span class="fa fa-plus"></span> Link</a>
                        <?php } ?>

                        <?php if($row['pause'] == 1){ ?>
                          <a class="btn btn-xs btn-success" onclick= "return confirm('Apakah anda yakin ingin membatalkan pause ?')" 
                          <?php if($_SESSION['myuser']['role_id'] ==  1 OR $_SESSION['myuser']['role_id'] == '2' ){ ?>
                            href = "<?php echo site_url('C_tablesps_admin/play/'.$this->uri->segment(3)); ?>"
                         <?php }else{ ?>
                          href = "<?php echo site_url('C_tablesps/play/'.$this->uri->segment(3)); ?>"
                        <?php } ?>"><span class="fa fa-play"></span> Play</a>
                        <?php }else{ ?>
                          <a href="javascript:;" data-toggle="modal" data-target="#myModalPause" class="btn btn-xs btn-default"><span class="fa fa-pause"></span> Pause</a>
                        
                    <?php }
                      if($_SESSION['myuser']['role_id'] == 4){
                      if($exec['execution'] == 0 AND $exec['status'] == $karyawanID){ 
                            if($row['pause'] == 0){ ?>
                            <a href="<?php echo site_url('C_execution/exec/'.$idSPS.'/'.$row['id'])?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda akan eksekusi SPS ini. Lanjutkan ?')">Execution</a>
                          <?php }
                           }elseif ($exec['execution'] == 1) { ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#myModalExec" class="btn btn-xs btn-default" style="background-color : #cccccc; ">Cancel Execution</a>
                          <?php if(empty($p_teknisi) OR $p_teknisi['status'] == 2){
                            
                          }elseif(!empty($p_teknisi) AND $exec['jenis_pekerjaan'] != 8){ ?>
                            <a href="<?php echo site_url('C_execution/fin_exec/'.$idSPS.'/'.$row['id'])?>" class = "btn btn-success btn-xs" onclick="return confirm('Apakah Anda yakin pekerjaan ini telah selesai ?')">Finish Job</a>
                            <a href="<?php echo site_url('C_execution/failed_exec/'.$idSPS.'/'.$row['id'])?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda menekan tombol Failed Job. Lanjutkan ?')">Failed Job</a>
                          <?php }
                    }
                     }

                    if ($_SESSION['myuser']['position_id'] == 18 AND $exec['kanibal_fin'] == 0) { ?>
                      <a href="<?php echo site_url('C_execution/kanibal/'.$idSPS.'/'.$row['id'])?>" class="btn btn-success btn-xs" onclick="return confirm('Apakah anda yakin sudah melakukan Job Costing & Item Transfer Accurate ?')">Kanibal Finished</a> 

                    <?php }elseif ($_SESSION['myuser']['position_id'] == 18 AND $exec['kanibal_fin'] == 1) {
                      # code...
                    }

                    if ($row['id_operator'] != $_SESSION['myuser']['karyawan_id'] AND $exec['status'] != 101 AND $row['pause'] == 0) { ?>
                      <a href="<?php echo site_url('C_execution/takeover/'.$idSPS.'/'.$row['id'])?>" class="btn btn-primary btn-xs" onclick="return confirm('Anda akan melakukan Take Over. Lanjutkan ?')">Take Over</a>
                    <?php }
                     } ?>
                  </td>
                </tr>
              <?php  
              }
            $x++;
          }
        } ?>
      </tbody> 
    </table>
<hr>
<div>
  <?php 
    $idSPS = $this->uri->segment(3);
    $a = "SELECT min(date_create) FROM tbl_sps_log WHERE id_sps = $idSPS";
    $b = $this->db->query($a);
    $c = $b->row_array();
    $coba = implode('', $c);
    $min = date('Y/m/d H:i:s', strtotime($coba));
   // print_r($min);exit();

    $a = "SELECT max(time_nextto) FROM tbl_sps_log WHERE id_sps = $idSPS";
    $b = $this->db->query($a);
    $c = $b->row_array();
    $coba2 = implode('', $c);

    $max = date('Y/m/d H:i:s', strtotime($coba2));
    $total = datediff($max, $min);

    $date = datediff(date('Y/m/d H:i:s'), $coba); 
    //print_r($total);exit();
    ?>

  <?php 
    $sql = "SELECT status FROM tbl_sps WHERE id = $idSPS";
    $que = $this->db->query($sql);
    $row = $que->row_array();
    $implode = implode(" ", $row);
 
  if ($implode != 101) { ?>
    <label style="font-size: 16px">
    <input type="hidden" class="date_start_time_total" value="<?php echo $min; ?>">
    Total time cost : <span name="totaltime"></span><br />
    </label>
  <?php  } else { ?>
    <label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
  <?php } ?>
</div>

<script type="text/javascript">
  function updateClock() {
    $('.date_start_time').each(function() {
     // var proses = document.getElementById("proses");
       var startDateTime = new Date( $(this).attr('value') );
        startStamp = startDateTime.getTime();
        newDate = new Date();
        newStamp = newDate.getTime();
        var diff = Math.round((newStamp - startStamp) / 1000);
        var d = Math.floor(diff / (24 * 60 * 60));
       /* though I hope she won't be working for consecutive days :) */
      diff = diff - (d * 24 * 60 * 60);
        var h = Math.floor(diff / (60 * 60));
        diff = diff - (h * 60 * 60);
        var m = Math.floor(diff / (60));
        diff = diff - (m * 60);
        var s = diff;
        //alert(startDateTime);
        var xxx = d + "d " + h + "h " + m + "m";
        console.log(xxx);
        document.getElementsByName("logtime")[0].innerHTML=xxx;
    });

    $('.date_start_time_total').each(function() {
     // var proses = document.getElementById("proses");
       var startDateTime = new Date( $(this).attr('value') );
        startStamp = startDateTime.getTime();
        newDate = new Date();
        newStamp = newDate.getTime();
        var diff = Math.round((newStamp - startStamp) / 1000);
        var d = Math.floor(diff / (24 * 60 * 60));
       /* though I hope she won't be working for consecutive days :) */
      diff = diff - (d * 24 * 60 * 60);
        var h = Math.floor(diff / (60 * 60));
        diff = diff - (h * 60 * 60);
        var m = Math.floor(diff / (60));
        diff = diff - (m * 60);
        var s = diff;
        //alert(startDateTime);
        var xxx = d + " days " + h + " hours " + m + " minutes";
        console.log(xxx);
        //$(this).parent().find("td.time-elapsed").html(d + "d " + h + "h " + m + "m " + s + "s ");
        //alert(xxx);
        document.getElementsByName("totaltime")[0].innerHTML=xxx;
    });
} 

setInterval(updateClock, 1000);

</script>