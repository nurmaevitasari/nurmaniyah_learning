<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
  .bs-callout {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #eee;
    border-left-width: 5px;
    border-radius: 3px;
}

.bs-callout h4 {
    margin-top: 0;
    margin-bottom: 5px;
}
.bs-callout p:last-child {
    margin-bottom: 0;
}
.bs-callout code {
    border-radius: 3px;
}
.bs-callout+.bs-callout {
    margin-top: -5px;
}
.bs-callout-default {
    border-left-color: #777;
}
.bs-callout-default h4 {
    color: #777;
}
.bs-callout-primary {
    border-left-color: #428bca;
}
.bs-callout-primary h4 {
    color: #428bca;
}
.bs-callout-success {
    border-left-color: #5cb85c;
}
.bs-callout-success h4 {
    color: #5cb85c;
}
.bs-callout-danger {
    border-left-color: #d9534f;
}
.bs-callout-danger h4 {
    color: #d9534f;
}
.bs-callout-warning {
    border-left-color: #f0ad4e;
}
.bs-callout-warning h4 {
    color: #f0ad4e;
}
.bs-callout-info {
    border-left-color: #5bc0de;
}
.bs-callout-info h4 {
    color: #5bc0de;
}

.btn-contributor
  {
    background-color: #5107D8;
    border-color: #5107D8;
    color: white;
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
        if($do_log){
          $x = 1;
            foreach($do_log as $key => $row){
              if($x == 1){ ?> 
                <tr>
                  <td><?php echo $x; ?></td>
                  <td width = "10px"><?php echo $row['date_created']; ?></td>
                  <td><?php echo $row['nama']; ?><br>
                      (<?php echo $row['position']; ?>)
                  </td>
                  <td >Idle : 0d 0h 0m <br> 
                      Response : 0d 0h 0m <br>
                      Process : 0d 0h 0m
                  </td>
                  <td>
                  	<?php
	                  	$msg = $dlv_mdl->do_pesan($row['do_id'], $row['id']);

	                  	foreach ($msg as $psn) {
	                  		echo date('d-m-Y H:i:s', strtotime($psn['date_created'])); ?> <b style="color:#3992b0;"><?php echo $psn['nickname']; ?></b> : <?php echo $psn['pesan']; ?><br>
	                  	<?php }
	                ?>

                    <?php if($do_numrow == 1): ?>
                      <br><a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-info"><span class="fa fa-plus"></span> Message</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning"><span class="fa fa-plus"></span> Files</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalPause" class="btn btn-xs btn-default"><span class="fa fa-pause"></span> Pause</a>

                      <a href="javascript:;" data-toggle="modal" data-target="#myModalPlay" class="btn btn-xs btn-success"><span class="fa fa-play"></span> Play</a>
                    <?php   endif ?>          
                  </td>
                </tr>

              <?php }else{ ?>
                <tr>
                	<?php 	$start = date('Y/m/d H:i:s', strtotime($do_log[$key]['date_created'])); ?>
                  	<?php 	$date = datediff($start, date('Y/m/d H:i:s')); ?>
                  	<?php 	$time_nextto = date('Y/m/d H:i:s', strtotime($do_log[$key]['time_nextto']));
                        	$time_login = date('Y/m/d H:i:s', strtotime($do_log[$key-1]['time_login'])); 
                        	$date_process = datediff($time_login, date('Y/m/d H:i:s')); 
                        	//print_r('login : '.$time_login);
                        	?>
                  			
                  	<?php 	$time_process = datediff($time_login, $time_nextto); ?>
                  	<?php
		                    $idle_start = date('Y/m/d H:i:s', strtotime($do_log[$key-1]['time_nextto']));
		                    $idle_date = datediff($idle_start, date('Y/m/d H:i:s')); 
		                    $idle_end = date('Y/m/d H:i:s', strtotime($do_log[$key-1]['time_idle']));
		                    $idle = datediff($idle_start, $idle_end); 
		                    //print_r('start : '.$idle_start);

		                    $min = date('Y/m/d H:i:s', strtotime($respons['start_date'])); 
		                    $max = date('Y/m/d H:i:s', strtotime($do_log[$key]['date_created']));
		                    $respons_time = datediff($max, $min); 
		            ?>
                  	<td><?php echo $x; ?></td>
	                <td><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?></td>
	                <td><?php echo $row['nama']; ?>
	                	<br>(<?php echo $row['position']; ?>)
	                </td>
	                <td>
                  		<?php 
                  		$idletime = $dlv_mdl->timer($row['do_id'], $do_log[$key-1]['id']);
                  		//$sql = "SELECT id, time_idle, time_login, time_nextto, id_operator 
                  		//		FROM tbl_do_log 
            					//WHERE do_id = ".$row['do_id']." AND id = ".$do_log[$key-1]['id'];
    					//$idletime = $this->db->query($sql)->row_array();
                  		//$idletime = $idletimes['idletime'];
                  		//print_r($idletime);
                  		
                  		if ($idletime['time_idle'] == '0000-00-00 00:00:00' AND $idletime['time_nextto'] == '0000-00-00 00:00:00') { ?>
                             Idle : 0d 0h 0m<br>
                        <?php }elseif($idletime['time_idle'] == '0000-00-00 00:00:00' AND $idletime['time_nextto'] != '0000-00-00 00:00:00'){ ?>  
                            <input type="hidden" class = "date_start_time" value="<?php echo $idle_start; ?>">
                            Idle : <span name="logtime"> </span><br />
                        <?php }else{ ?>
                            Idle : <?php echo $idle['days_total']; ?>d <?php echo $idle['hours']; ?>h <?php echo $idle['minutes']; ?>m<br>
                        <?php  } ?>

                        Response : <?php echo $respons_time['days_total']; ?>d <?php echo $respons_time['hours']; ?>h <?php echo $respons_time['minutes']; ?>m<br />

                        <?php $process = $dlv_mdl->timer($row['do_id'], $row['id']); 
						//$process = $process['idletime'];
						//$sql = "SELECT id, time_idle, time_login, time_nextto, id_operator 
              //    				FROM tbl_do_log 
            		//			WHERE do_id = ".$row['do_id']." AND id = ".$row['id'];
    					//$process = $this->db->query($sql)->row_array();

	                    if($idletime['time_login'] == '0000-00-00 00:00:00'){
	                    	echo 'Process : 0d 0h 0m'; 
	                    }elseif($idletime['time_login'] != '0000-00-00 00:00:00' AND $process['time_nextto'] == '0000-00-00 00:00:00'){ ?>
	                    	<input type="hidden" class = "date_start_time" value = "<?php echo $time_login; ?>">
	                    	Process : <span name="logtime"></span>
	                    <?php }elseif($idletime['time_login'] != '0000-00-00 00:00:00' AND $process['time_nextto'] != '0000-00-00 00:00:00'){
	                    	echo "Process : ".$time_process['days_total']."d ".$time_process['hours']."h ".$time_process['minutes']."m"; 
	                    } ?>
                  	</td>
                  	<td>
	                  	<?php
	                  	$msg = $dlv_mdl->do_pesan($row['do_id'], $row['id']);

	                  	foreach ($msg as $psn) {

	                  		echo date('d-m-Y H:i:s', strtotime($psn['date_created'])); ?> <b style="color:#3992b0;" class="b-nick"><?php echo $psn['nickname']; ?></b> : <span id="msg_<?php echo $psn['id']; ?>" class=" 
                        <?php if($psn['pesan'] == '*** TAKE OVER ***') {
                          echo 'takeover';
                          }elseif ($psn['pesan'] == '***** FINISHED *****') {
                            echo 'delv-fin';
                          } ?>
                        " ><?php echo $psn['pesan']; ?></span><br>
	                  	<?php } 
	                  	
	                  	if($x == $do_numrow AND $_SESSION['myuser']['role_id'] != '15'){ 
                        if($row['do_status'] != '') {
                          if($row['lvl_approval'] == '' AND $row['cabang'] != '') { ?>
                            <b>Status <?php echo $row['do_status'] ?> : <span style="color: red;">Waiting for Kacab Approval.</span></b>
                          <?php }elseif (($row['lvl_approval'] == '' AND $row['cabang'] == '') OR $row['lvl_approval'] == 'Kacab') { ?>
                          <b>Status <?php echo $row['do_status'] ?> : <span style="color: red;">Waiting for Kadiv Approval.</span></b>
                          <?php }
                        } ?>

                          <br><a href="javascript:;" data-toggle="modal" data-target="#myModalMsg" class="btn btn-xs btn-info data-record"><span class="fa fa-plus" data-id = "<?php echo $row['overto']; ?>"></span> Message</a>
                  
                          <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning" id="addfiles"><span class="fa fa-plus"></span> Files</a>

                          <a href="javascript:;" data-toggle="modal" data-target="#myModalLink" class="btn btn-xs btn-success"><span class="fa fa-plus"></span> Link</a>

                          <button class="btn btn-default btn-contributor btn-xs" data-toggle="modal" data-target="#modalContributor"><span class="fa fa-plus"></span> Contributor</button>
                          
                          <?php if($do_log[$key]['id_operator'] != $_SESSION['myuser']['karyawan_id']){ ?>
                            <a href="<?php echo site_url('C_delivery/takeOver/'.$row['do_id']); ?>" class="btn btn-primary btn-xs" onclick="return confirm('Anda akan melakukan Take Over. Lanjutkan ?')">Take Over</a>
                          <?php  } 

                         // if($row['id_operator'] == $_SESSION['myuser']['karyawan_id'] AND $row['role_id'] == '11') { ?>
                              <!-- <a href="<?php //echo site_url('c_delivery/exec/'.$row['do_id'].'/'.$row['id']); ?>" class="btn btn-danger btn-xs" id = "exec" onclick="return confirm('Anda akan mengeksekusi pekerjaan ini. Lanjutkan ?')">Execution</a> -->
                          <?php // }

                          if(($do_status['status'] != 'Finished' AND $do_status['status'] != 'Delivering') AND $row['do_status'] != 'Cancel' AND $row['do_status'] == '') { ?>
                            <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModalCancel" data-id="<?php echo $row['id'] ?>" id="docancel">Cancel</button>
                          <?php }elseif(($do_status['status'] == 'Finished' OR $do_status['status'] == 'Delivering') AND ($row['do_status'] != 'Return' AND $row['do_status'] != 'Replacement')) { ?>
                            <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModalReturn">Return</button>
                            <button data-toggle="modal" data-target="#myModalReplace" class="btn btn-default btn-xs" style="background-color: black; color: white; border-color: black;" > Replacement</a>

                          <?php }elseif($row['lvl_approval'] != 'Kadiv' AND $row['do_status'] != '') {
                            if(($row['lvl_approval'] == 'Kacab' OR $row['cabang'] == '') AND in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100'))) { ?>
                              <a href="<?php echo site_url('C_delivery/approved/'.$row['do_status'].'/'.$row['do_id'].'/'.$row['id']); ?>" class="btn btn-success btn-xs" onclick="return confirm('Anda menyetujui <?php echo $row['do_status'] ?> pada Delivery ini. Lanjutkan ?')">Approved</a>
                              <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModalNotApproved">Not Approved</button>
                            <?php }elseif ($row['cabang'] != '' AND $row['lvl_approval'] != 'Kacab' AND in_array($_SESSION['myuser']['position_id'], array('55', '56', '57', '58'))) { ?>
                              <a href="<?php echo site_url('C_delivery/approved/'.$row['do_status'].'/'.$row['do_id'].'/'.$row['id']); ?>" class="btn btn-success btn-xs" onclick="return confirm('Anda menyetujui delivery ini. Lanjutkan ?')">Approved</a>
                              <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModalNotApproved">Not Approved</button>
                            <?php }
                          }elseif ($row['lvl_approval'] == 'Kadiv' AND $row['approval'] == '1') { 
                            if($row['do_status'] == 'Cancel') { ?> 
                              <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning" id="buktifiles"><span class="fa fa-plus"></span> Bukti Cancel SO</a>

                            <?php }elseif($row['do_status'] == 'Return') { ?>
                              <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning" id="buktifiles"><span class="fa fa-plus"></span> Bukti Sales Return</a>

                            <?php }elseif($row['do_status'] == 'Replacement' AND empty($cekreplace)) { ?>
                              <a href="<?php echo site_url('c_delivery/newdoreplace/'.$row['do_id']); ?>" class="btn btn-xs btn-info" onclick="return confirm('Anda akan membuat Replacement Delivery. Lanjutkan ?')">New Delivery Replacement</a>
                            <?php } 
                           } 

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

    <div>
      <?php 
      $min_date = date('Y/m/d H:i:s', strtotime($respons['date_open'])); 
      $max_date = date('Y/m/d H:i:s', strtotime($respons['date_close']));
    $total  = datediff($max_date, $min_date);

      if ($respons['date_close'] == '0000-00-00 00:00:00') { ?>
        <label style="font-size: 16px">
          <input type="hidden" class="date_start_time_total" value="<?php echo $min_date; ?>">
          Total time cost : <span name="totaltime"></span><br />
        </label>
      <?php  } else { ?>
        <label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
      <?php } ?>
    </div>
    <hr />

   
    <div>
      <?php
     if((!in_array($do_status['status'], array('Cancel', 'Return', 'Finished'))) OR ($do_status['status'] == 'Finished' AND $row['do_status'] != '')) {
      if(($row['do_status'] == '' AND ($row['lvl_approval'] == '' OR $row['approval'] == '2')) OR (($cofiles >= '1' AND in_array($row['do_status'], array('Cancel', 'Return'))) OR ($cofiles == '0' AND $row['do_status'] == 'Replacement') AND $row['do_status'] != '' AND $row['lvl_approval'] == 'Kadiv'  AND $row['approval'] == '1')) { 
      if($do_log[0]['cabang'] == 'Bandung' AND $_SESSION['myuser']['position_id'] == '75') { ?>
        <a href="<?php echo site_url('C_delivery/do_finished/'.$row['do_id'].'/'.$row['do_status']); ?>" class="btn btn-success fin" onclick="return confirm('Apakah anda yakin telah menyelesaikan Delivery ini ?')">Delivery Finished</a>
      <?php }elseif($do_log[0]['cabang'] == 'Medan' AND ($_SESSION['myuser']['position_id'] == '60' OR $_SESSION['myuser']['position_id'] == '56')) { ?>
        <a href="<?php echo site_url('C_delivery/do_finished/'.$row['do_id'].'/'.$row['do_status']); ?>" class="btn btn-success fin" onclick="return confirm('Apakah anda yakin telah menyelesaikan Delivery ini ?')">Delivery Finished</a>
      <?php }elseif ($do_log[0]['cabang'] == 'Surabaya' AND $_SESSION['myuser']['position_id'] == '62') { ?>
        <a href="<?php echo site_url('C_delivery/do_finished/'.$row['do_id'].'/'.$row['do_status']); ?>" class="btn btn-success fin" onclick="return confirm('Apakah anda yakin telah menyelesaikan Delivery ini ?')">Delivery Finished</a>
      <?php }elseif($_SESSION['myuser']['position_id'] == '19' OR $_SESSION['myuser']['position_id'] == '59') { ?>
        <a href="<?php echo site_url('C_delivery/do_finished/'.$row['do_id'].'/'.$row['do_status']); ?>" class="btn btn-success fin" onclick="return confirm('Apakah anda yakin telah menyelesaikan Delivery ini ?')">Delivery Finished</a>
      <?php }elseif ($do_log[0]['id_operator'] == $_SESSION['myuser']['karyawan_id']) { ?>
       <a href="<?php echo site_url('C_delivery/do_finished/'.$row['do_id'].'/'.$row['do_status']); ?>" class="btn btn-success fin" onclick="return confirm('Apakah anda yakin telah menyelesaikan Delivery ini ?')">Delivery Finished</a>
      <?php }
      } ?>
     <span>&nbsp; </span>
       <?php 
       $process = $dlv_mdl->timer($row['do_id'], $row['id']);
       if($process['id_operator'] == $_SESSION['myuser']['karyawan_id']) { ?>

    <a href="<?php echo site_url('C_delivery/nextTo/'.$row['do_id']); ?>" class="btn btn-primary">Next To >></a>
   
    <?php } ?>
  </div>
  <?php }  ?>



     <script type="text/javascript">
    
    $("#buktifiles").click(function() {
          var do_status = '<?php echo $row["do_status"] ?>';
          
          if(do_status == 'Cancel') {
            $("#textupload").text("Upload Bukti Cancel SO");
          $("#typefiles").val("3");
          }else if(do_status == 'Return') {
            $("#textupload").text("Upload Bukti Sales Return");
          $("#typefiles").val("4");
          }
        
      });     

    $(document).ready(function() {
       var do_status = '<?php echo $row["do_status"] ?>';
       var appr = '<?php echo $row["approval"] ?>';

       if(do_status == '') {
        do_status = 'Finished';
       }
       $(".fin").text(do_status + " Delivery");
    });
    </script>