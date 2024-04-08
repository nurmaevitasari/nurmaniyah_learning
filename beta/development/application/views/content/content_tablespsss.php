<style type="text/css">
		.label-outline {
		  color: black;
		  border: 1px solid #999;
		  background-color: transparent;
		}

		.label-servis{
		  color: black;
		  background-color: white;
		  border: 2px solid #d65752;
		}

		.label-instalasi{
		  color: black;
		  background-color: white;
		  border: 2px solid #d3a631;
		}

		.label-survey{
		  color: black;
		  background-color: white;
		  border: 2px solid #5171d5;
		}

		.label-rekondisi{
		  color: black;
		  background-color: white;
		  border: 2px solid grey;
		}

		.label-green{
		  color: white;
		  background-color: #1a908a;  
		}

		.label-maintenance{
		  color: black;
		  background-color: white;
		  border: 2px solid #1a908a;
		}

		.label-purple{
		  color: white;
		  background-color: #99004d;
		}

		.label-training{
		  color: black;
		  background-color: white;
		  border: 2px solid #99004d;
		}

		.label-brown{
		  color: white;
		  background-color: #833C14;
		}

		.label-perakitan{
		  color: black;
		  background-color: white;
		  border: 2px solid #833C14;
		}

		.label-bblue{
		  color : white;
		  background-color: #00cccc;
		}

		.label-persiapan{
		  color: black;
		  background-color: white;
		  border: 2px solid #00cccc;
		}

		.label-pink{
	      color : white;
	      background-color: #ff3399;
	    }

	    .label-kanibal{
	      color : black;
	      background-color: white;
	      border: 2px solid #ff3399;
	    }

		.label-finish{
		  color: black;
		  background-color: white;
		  border: 2px solid #5bba5b;
		}

		.fa-check {
		  color: white;
		  background-color: #5bba5b;
		}

		.label-border{
		  color: #5bba5b;
	   }

	   .btn-finish{
		background-color : #d9d9d9;
		border : 1px solid #d9d9d9;
	   }

	   .sm{
		background-color: Transparent;
		background-repeat:no-repeat;
		border: none;
		cursor:pointer;
		overflow: hidden;
		outline:none;
	   }

	   .edit-tgl{
	   	background-color: Transparent;
		background-repeat:no-repeat;
		border: none;
		cursor:pointer;
		overflow: hidden;
		outline:none;
	   }

</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-9">
			<h2>Table SPS</h2>
		</div>

		<div class="col-md-3" style="margin-top: 22px;">
			<div class="btn-group">
				<input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
				<input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm  disabled ">
			</div>
		</div>
	</div>
	<hr />

	<?php if($_SESSION['myuser']['role_id'] != 12){ ?>
	 <div>
    	<a target ="_blank" href="<?php echo site_url('c_monitoring'); ?>" type="button" class="btn btn-info">Technician Daily Activity</a><br /><br />
  	</div>
  	<?php } ?>

	<div class="table-responsive" style="font-size: 12px;" >
		<table class="table table-hover" id="example">
			<thead>
				<tr>
					<th>Job ID</th>
					<th>No. SPS</th>
					<th>Tanggal</th>
					<th>Customer</th>
					<th>Nama Produk</th> 
					<th>Umur SPS</th>
					<th style="width : 150px;">Status</th>
					<th>Umur Pembelian</th>
					<th style="width : 41px;"><img src = "<?php echo base_url('assets/images/job_edit.png')?>" /></th>
					<?php if ($_SESSION['myuser']['role_id'] == 3){ ?>
						<th>Schedule</th>
					<?php } ?>
					<th>Action</th>
				</tr> 
			</thead>
			
			<tbody>
				<?php if($c_tablesps) {
					
					$i = $row_sps;
					foreach($c_tablesps as $key => $row)
					{      
						if($row['status'] == 101 ) { ?>
							<tr class = "hidethis" data-user = "101" id = "#row_<?php echo $row['id']; ?>">
						<?php }elseif($row['status'] != 101){ ?>
							<tr class = "showthis" id = "#row_<?php echo $row['id']; ?>">
						<?php  } ?>
						
						<td><?php echo $row['job_id']; ?></td>
						<td><?php echo $row['no_sps']; ?><input type=hidden name="idSPS" value="<?php echo $idSPS; ?>">
							<b><br>By : <?php echo $row['nickname']; ?> - <?php echo strtoupper($row['divisi']); ?></b>
						</td>
						<td><?php $date = new DateTime($row['date_open']);
								echo date_format($date, 'd-m-Y H:i:s'); ?></td>
						<td><?php echo $row['perusahaan']; ?><br />
								<?php echo $row['areaservis']; ?>
						</td>
						<td><?php $load_prd = $c_tablesps[$key]['sps_id']; 
		                    foreach ($load_prd as $prd) {
		                      echo "<li>".$prd['product']."<br>";
		                    } ?>
                  		</td>

						</td>
						<?php 
						$idSPS = $row['id'];
						$nama = $row['nama'];
						$jns = $row['jenis_pekerjaan'];
						$status = $row['status'];
						$execution = $row['execution'];
						$nickname = $row['nick_tek'];
						$tgl_pembelian = $row['tgl_pembelian'];
						$date_open = $row['date_open'];

						$p = "SELECT pause FROM tbl_sps_log WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 1";
						$pause = $this->db->query($p)->row_array();
						$pause = $pause['pause'];

						$a = "SELECT date_open, date_close, status FROM tbl_sps WHERE id = '$idSPS'";
						$b = $this->db->query($a);
						$c = $b->row_array();
						$coba = $c['date_open'];
						$min = date('Y/m/d H:i:s', strtotime($coba));

						$coba2 = $c['date_close'];
						$max = date('Y/m/d H:i:s', strtotime($coba2));

						$total = datediff($max, $min);

						$implode = $c['status'];

						if ($implode != 101) { ?>
							<td class="time-elapsed"></td>
							<input type="hidden" class="date_start_time" value="<?php echo $min; ?>"></input>
						<?php  } else { ?>
							<td><?php echo $total['days_total']; ?>d <?php echo $total['hours']; ?>h <?php echo $total['minutes']; ?>m</td>
						<?php } ?>

						<td id="status_<?php echo $idSPS; ?>">
						<?php if ($jns == '1'){ 
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-danger update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-danger label-servis">Servis</span>&nbsp;
									
								<?php }else{ ?>
									<span class="label label-danger update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-danger label-servis">Servis</span>
									
								<?php } ?>
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish">Servis</span> &nbsp; &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php } 
							
						}elseif($jns == '2'){
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-warning update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-warning label-instalasi">Instalasi</span>    
									
								<?php  }else{ ?>
									<span class="label label-warning update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-warning label-instalasi">Instalasi</span>
									
								<?php } ?>
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish" id = "instalasi">Instalasi </span> &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
						
						}elseif($jns == '3' ){
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-primary update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-primary label-survey">Survey</span>                     
									
								<?php }else{ ?>
									<span class="label label-primary update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-primary label-survey">Survey</span>
									
								<?php } ?>
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish">Survey </span> &nbsp; &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
						
						}elseif($jns == '4'){
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-default update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-default label-rekondisi">Rekondisi</span>
									
								<?php }else{ ?>
									<span class="label label-default update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-default label-rekondisi">Rekondisi</span>
									
								<?php } ?>
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish">Rekondisi </span> &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
						
						}elseif($jns == '5' ){ 
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-info label-green update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-default label-maintenance">Maintenance</span>
									
								<?php }else{ ?>
									<span class="label label-info label-green update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-default label-maintenance">Maintenance</span>
									
								<?php } ?> 
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span> 
									<br>
									<span class="label label-success label-finish">Maintenance </span> &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
			  
						}elseif($jns == '6' ){ 
							if($status != '101') {
								if($pause == 1){  ?>
									
										<span class="label label-info label-purple update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause "></span><br>                       
										<span class="label label-default label-training ">Training</span>
									
								<?php }else{   ?>
									<span class="label label-info label-purple update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-default label-training">Training</span>
									
								<?php } ?> 
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish">Training </span> &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
			  
						}elseif($jns == '7' ){ 
							if($status != '101') { 
								if($pause == 1){  ?>
									<span class="label label-info label-brown update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-default label-perakitan">Perakitan</span>
									
								<?php }else{ ?>
									<span class="label label-info label-brown update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-default label-perakitan">Perakitan</span>
									
								<?php } ?> 
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
									<br>
									<span class="label label-success label-finish">Perakitan </span> &nbsp;
									<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
								
							<?php }
						
						}elseif($jns == '8' ){ 
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-info label-bblue update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span><br>
										<span class="label label-default label-persiapan">Persiapan Barang</span>
									
								<?php }else{ ?>
									<span class="label label-info label-bblue update"><?php echo strtoupper($nama); ?></span><br>
										<span class="label label-default label-persiapan">Persiapan Barang</span>
									
								<?php } ?>      
								<?php }elseif($status == '101'){ ?>
									<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
										<br>
										<span class="label label-success label-finish">Persiapan Barang </span> &nbsp;
										<span class="label label-success label-border "><span class = "fa fa-check"></span></span>
									
								<?php }    
						}elseif($jns == '9' ){ 
		                    if($status != '101') {
		                      	if($pause == 1){ 
		                     ?>
		                      
		                      <span class="label label-info label-pink update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause "></span><br>                       
		                      <span class="label label-default label-kanibal ">Kanibal</span>
		                       
		                     
		                      <?php }else{   ?>
		                        <span class="label label-info label-pink update"><?php echo strtoupper($nama); ?></span><br>
		                       <span class="label label-default label-kanibal">Kanibal</span>
		                      
		                        <?php } ?> 
		                    <?php }elseif($status == '101'){ ?>
		                      <span class="label label-success update"><?php echo strtoupper($nama); ?></span>
		                        <br>
		                        <span class="label label-success label-finish">Kanibal</span> &nbsp;
		                        <span class="label label-success label-border "><span class = "fa fa-check"></span></span>
		                      
		                    <?php }
						}else{
							if($status != '101') { 
								if($pause == 1){ ?>
									<span class="label label-danger update"><?php echo strtoupper($nama); ?></span>&nbsp;<span class = "glyphicon glyphicon-pause"></span>
									
								<?php }else{ ?>
									<span class="label label-danger update"><?php echo strtoupper($nama); ?></span>
									
								<?php } ?>  
							<?php }elseif($status == '101'){ ?>
								<span class="label label-success update"><?php echo strtoupper($nama); ?></span>
								
							<?php 
							}
						}   ?>
						</td>

						<td id = "tgl_beli_<?php echo $row['id']; ?>"<?php if ($_SESSION['myuser']['position_id'] == '9') { ?>
							ondblclick="openModalPembelian('<?php echo $row['id'] ?>')"
						<?php } ?>>
						<?php if($tgl_pembelian != '0000-00-00') {
		                    $dateopen = date('Y-m-d 00:00:00', strtotime($date_open));
		                    $tglpembelian = date('Y-m-d 00:00:00', strtotime($tgl_pembelian));

		                    $diff = datediff($dateopen, $tglpembelian);
		                    echo date('d/m/Y', strtotime($tgl_pembelian));
		                    echo "<br>";
		                    echo $diff['years']."Y ".$diff['months']."M ".$diff['days']."D ";

		                } ?>
							<!--  <?php /* if($row['free_servis'] != '0') {
								if($row['status_free'] == '0') { ?>
									<span style="font-size: 11px;">Waiting for Approval</span>
								<?php }elseif ($row['status_free'] == '1') { ?>
									<span style="font-size: 11px;"><?php echo date('Y/m/d H:i:s', strtotime($row['date_free'])) ?><br><b style="color: green;">Approved</b> by : <b><?php echo $row['free_name']; ?></b></span>
								<?php }elseif ($row['status_free'] == '1') { ?>
									<span style="font-size: 11px;"><?php echo date('Y/m/d H:i:s', strtotime($row['date_free'])) ?><br><b style="color: red;">Not Approved</b> by : <b><?php echo $row['free_name']; ?></b></span>
								<?php }
							} */ ?> -->
						</td>
         
						<?php 
						$role_id = $_SESSION['myuser']['role_id']; 
						$now = date('Y-m-d');
							if($_SESSION['myuser']['position_id'] == 20 AND $status != 101){
								if($row['job_teknisi'] == 0){ ?>
									<td><button class = "btn btn-default btn-sm sm fa fa-square-o fa-lg" data-status = <?php echo $status; ?> id = "<?php echo $idSPS?>" onClick = "job(this.id)" ></button>
									</td>
								<?php }elseif ($row['job_teknisi'] == 1) { ?>
									<td><button class = "btn btn-default btn-sm sm fa fa-check-square-o fa-lg" data-status = <?php echo  $status; ?> id = "<?php echo $idSPS?>" onClick = "job(this.id)"></button>
									</td>
								<?php }
							
							}elseif ($_SESSION['myuser']['position_id'] != 20 AND $status != 101) {
								if ($row['status_teknisi'] == 2) { ?>
								<td><img src = "<?php echo base_url('assets/images/finish.png'); ?>" /><br>
									<p style="font-size: 10px;">By : <?php echo $nickname; ?></p>
									</td>
								<?php }elseif ($row['job_teknisi'] == 1 OR $execution == 1) { ?>
									<td><img src = "<?php echo base_url('assets/images/job_edit.png'); ?>" />
									</td>
								<?php }elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] > $now AND $execution == 0) {
									$date = new DateTime($row['schedule']);
									echo "<td style ='color : #0024AE'>".date_format($date, 'd-m-Y')."</td>";
								}elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] < $now AND $execution == 0) {
									$date = new DateTime($row['schedule']);
									echo "<td style='color : #ff0000;'>".date_format($date, 'd-m-Y')."</td>";
								}elseif ($row['schedule'] != '0000-00-00' AND $row['schedule'] == $now AND $execution == 0) {
									$date = new DateTime($row['schedule']);
									echo "<td style='color : #218A25;'>".date_format($date, 'd-m-Y')."</td>";
								}elseif($row['job_teknisi'] == 0){
									echo "<td>Queue</td>";
								}
							}else{ ?>
								<td></td>
							<?php }

						if($role_id =='3') {
							if ($row['schedule'] == '0000-00-00' AND $status != 101){ ?>   
								<td id = "schedule_<?php echo $idSPS?>"><button class="btn btn-info btn-xs" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "<?php echo $idSPS; ?>"><span class="fa fa-plus"></span> Add</button>
								</td>
								
							<?php	}elseif ($row['schedule'] != '0000-00-00' AND $status != 101) {
								if($row['schedule'] > $now){
									$date = new DateTime($row['schedule']); ?>
									<td style = "color: #0024AE" id = "schedule_<?php echo $idSPS?>"><div style="width : 100px;"><?php echo date_format($date, 'd-m-Y') ?><button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "<?php echo $idSPS; ?>"></div>
									</td>
								<?php }elseif ($row['schedule'] < $now) {
									$date = new DateTime($row['schedule']); ?>
									<td style='color : #ff0000;' id = "schedule_<?php echo $idSPS?>"><div style="width : 100px;"><?php echo date_format($date, 'd-m-Y') ?> <button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "<?php echo $idSPS; ?>"></button></div>
									</td>
								<?php }elseif($row['schedule'] == $now)	{
									$date = new DateTime($row['schedule']); ?>
									<td style='color : #218A25;' id = "schedule_<?php echo $idSPS?>"><div style="width : 100px;"><?php echo date_format($date, 'd-m-Y') ?><button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "<?php echo $idSPS; ?>"></button></div>
									</td>
								<?php }
							}elseif($status == 101){
								echo "<td></td>";
							}
						}
          
						$karyawanID = $_SESSION['myuser']['karyawan_id'];
						$sql = "SELECT id_sps, overto, time_login FROM tbl_sps_log WHERE id_sps = '$idSPS' AND overto = '$karyawanID' AND time_login = '0000-00-00 00:00:00'";
						$query = $this->db->query($sql);
						$a = $query->row_array();  ?>
        
						<?php if ($a == TRUE) { ?>
							<td><a href="<?php echo site_url('c_tablesps/savetime/'.$idSPS); ?>" >
								<button class="btn btn-default" target="_blank">Detail</button></a>
							</td>
						<?php }else{ ?>
							<td><a href="<?php echo site_url('c_tablesps/update/'.$idSPS); ?>" >
								<button class="btn btn-default" target="_blank">Detail</button></a>
							</td>
						<?php } ?>
						</tr>
						<?php
						$i--;
					}
				} ?>
			</tbody> 
		</table>
	</div>
</div>

 <div class="modal fade" id="myModalSchedule" role="dialog" method="post">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form class="form-horizontal" method="post" role="form" id="form">
              
					<div class="modal-header">
					  <h4>Add New Scedule</h4>
					</div>
	 
					<div class="modal-body">   
						<div class="form-group error">
				            <input type="text" class="form-control tanggal" id = "tanggal" placeholder=" Pilih Tanggal" val="" name="tanggal" required>
				            <input type="hidden" id="hidden_id" val="" name="idsps" >
				        </div>
				        <div class="form-group error">
				        	<select class="form-control" style="width: 287px;" id="sel_teknisi" name="sel_teknisi" required>
				            	<option value="">-- Pilih Teknisi --</option>
				              	<?php if($teknisi)
				              	{
					                foreach ($teknisi as $val) 
					                { ?>
				                  		<option value="<?php echo $val['karyawan_id']; ?>"><?php echo $val['nickname']; ?></option>
				                	<?php } 
				              	} ?>
				            </select>
				          </div>
					</div>
					
					<div class="modal-footer">
						<button type="submit" name="submit" id="submit" class="btn btn-info pull-left">Submit </button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
					</form>
			</div>
		</div>
    </div>

    <div class="modal fade" id="mdlPembelian" role="dialog" method="post">
    	<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form class="form-horizontal" method="post" role="form" id="form_pembelian">
              
					<div class="modal-header">
					  <h4>Add Tanggal Pembelian</h4>
					</div>
	 
					<div class="modal-body">   
						<div class="form-group error">
				            <input type="text" class="form-control tanggal" id = "tgl_pembelian" placeholder=" Pilih Tanggal" val="" name="tanggal" required>
				            <input type="hidden" id="spsid" val="" name="spsid" >
				        </div>
					</div>
					
					<div class="modal-footer">
						<button type="submit" name="submit" id="submit" class="btn btn-info pull-left">Submit </button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
					</form>
			</div>
		</div>
    </div>

<!-- <script>

  $(document).ready(function(){
    $("#data_time").load("<?php// echo site_url('c_tablesps/data_sps'); ?>");
  })
  
	ea();
function ea(){
  setTimeout(function(){
    ea();
    LoadDataTable();
  },1000);
}

  function LoadDataTable(){
    $("#data_time").load("<?php //echo site_url('c_tablesps/data_sps'); ?>");
  }
</script> -->


<script type="text/javascript">
 // var timer;

  var table = $('#example').DataTable({
    "aaSorting": [[0, "desc"]],
    'iDisplayLength': 100
});

  $("#tanggal, #tgl_pembelian").datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent : false
  });

  $("#btn_hide").click(function() {

    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        return $(table.row(dataIndex).node()).attr('data-user') != 101;
      }
    );
    table.draw();
    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
    $("#btn_show").attr('class', 'btn btn-primary btn-sm');  
  
});


$("#btn_show").click(function(){
  $.fn.dataTable.ext.search.pop();
     table.draw();
     $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
 });  

function updateClock() {
    $('.date_start_time').each(function() {
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

        $(this).parent().find("td.time-elapsed").html(d + "d " + h + "h " + m + "m");
    });
} 

setInterval(updateClock, 1000); 

function job(idsps){

  var id = idsps;
  var status = $("#" + id).data('status');
  var square = $("#" + id).hasClass('fa-square-o');
 
  if(square == true){
  
    $.ajax({
    type : 'POST',
    url : '<?php echo site_url('c_tablesps/check_job/')?>',
    data : {
    data_id : id,
    data_job : '1',
    data_status : status,

    },
    success : function(data){
      $('#' + id).removeClass('fa-square-o').addClass('fa-check-square-o');
    },
    error : function(){
      alert('failure');
    },
    });

  }else if(square == false){
   
   $.ajax({
    type : 'POST',
    url : '<?php echo site_url('c_tablesps/check_job/')?>',
    data : {
    data_id : id,
    data_job : '0',
    data_status : status,
    },
    success : function(data){
      $('#' + id).removeClass('fa-check-square-o').addClass('fa-square-o');
    },
    error : function(){
      alert('failure');
    },
    });
  } 
}

 $(document).on("click", "#schedule", function(){

    var id = $(this).data('id');
    $("#hidden_id").val(id);
    $('#form')[0].reset();

 });

 $("#form").submit(function() {

 	var tgl = $("#tanggal").val();
  	var id = $("#hidden_id").val();
  	var teknisi = $('#sel_teknisi').val();

  $.ajax({
    type : 'POST',
    url : '<?php echo site_url('c_tablesps/schedule/')?>',
    data : {
    tgl : tgl,
    id : id,
    teknisi : teknisi
    },
    dataType : 'json',
    success : function(data){
	    $('#myModalSchedule').modal('hide');
	    $('#schedule_'+id).load('c_execution/load_data/' + id);
	    $('#status_'+id+' .update').html(data.nickname.toUpperCase());

    },
    error: function (jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
    },  
  }); 
	return false;
 });

 function openModalPembelian(e)
 {
 	$("#mdlPembelian").modal('show');
 	$('#form_pembelian')[0].reset();
 	$("#spsid").val(e);
 	
 }

 $("#form_pembelian").submit(function() {

 	var tgl = $("#tgl_pembelian").val();
  	var id = $("#spsid").val();

  $.ajax({
    type : 'POST',
    url : '<?php echo site_url('c_tablesps/addTglPembelian/')?>',
    data : {
	    tgl : tgl,
	    id : id,
    },
    dataType : 'json',
    success : function(data){
	    $('#mdlPembelian').modal('hide');
       	$("#tgl_beli_" + id).html(data.tgl_pembelian +"<br>"+data.diff);
    },
    error: function (jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
    },  
  }); 
	return false;
 });



</script>