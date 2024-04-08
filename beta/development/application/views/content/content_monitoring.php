<?php 
$user = $this->session->userdata('myuser');
require_once(APPPATH.'libraries/underscore.php'); ?>

<style type="text/css">
	th{
		text-align: center;
	}

	.on-progress{
		text-align: center;
		background-color: #62f442;
	}

	.idle{
		text-align: center;
		background-color: #ff1a1a;
	}

	.search-date{
		background-color: #CDFFCC;
		border : 2px solid #dce0e8;
		margin-top: 4px;
		font-size: 13px;
		text-align : center;
	}

	table{
		width: 80px;
	}

	.past-date{
		background-color : #c9c9c9; 
		text-align : center;
	}
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Technician Daily Activity Monitoring</h2>
		</div>
	</div>              
<!-- /. ROW  -->
	<hr />
	<br />

	<div class="col-sm-12 col-md-12 row">
		<div class="col-sm-3 col-md-3">
			<form class="navbar-form" role="search" method = "get" action="<?php echo site_url('c_monitoring/search'); ?>">
				<div class="input-group">
					<input id = "tanggal" type="text" class="form-control" placeholder="Search Date" name="tanggal">
					<div class="input-group-btn">
						<button class="btn btn-primary" name="search" type="submit">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
			</form>	
		</div>
		
		<div class="col-sm-6 col-md-6"></div>
		
		<?php 
		$tmp_ord = array();
		foreach ($order as $key => $ord) {
			$tmp_ord[$key] = $ord;
		}		

		$tmp_rslt = array();
		foreach ($result as $key => $rslt)
		{
   			$tmp_rslt[$key] = $rslt;
   		}		
		
		$tmp_cur = array();
		foreach ($current as $curr) {
			$tmp_cur[$curr->tek_point] = $curr;
		}

		$tmp_arr = array();
		foreach ($assist as $sts) {
			$tmp_arr[$sts->tech_id] = $sts;
		}

		$tmp_ord2 = array();
		foreach ($order2 as $key => $ord2) 
		{
		 	$tmp_ord2[$key] = $ord2;
		 } 
		 //print_r(count($tmp_ord2));

		 $tmp_point_st = array();
		 foreach ($point_status as $pst) {
		 	$tmp_point_st[$pst->karyawan_id] = $pst;
		 }


		?>
		
		<div class="col-sm-3 col-md-3 search-date well-sm">
			Date : 
			<?php 
			$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			$todays = strtotime($today);
			echo $hari[date('w', $todays)].", ".date('j', $todays)." ".$bulan[date('n', $todays)]." ".date('Y'); 
			?>
		</div>

		<br />
		<br />
		<br />
	</div>

	<div class="table-responsive">
		<table class="table table-bordered" style="font-size: 11px;">
			<thead>
				<tr>
					<th style="width: 50px;">No.</th>
					<th style="width: 110px;">Technician</th>
					<th style="width: 150px;">Current Status</th>
					<th style="width : 245px;"> Today Job Result</th>
					<th>Today Job Order</th>
					<th>Job On Hand</th>
					<?php if($_SESSION['myuser']['role_id'] == 4 OR $_SESSION['myuser']['position_id'] == 20 OR $_SESSION['myuser']['position_id'] == 58){ ?>
					<th style=" width: 100px;">Assistance</th>
					<?php } ?>
				</tr>
			</thead>

			<tbody>
			<?php
				$no = 1;
				foreach ($tampil as $val) 
				{
					$sts = isset($tmp_arr[$val->karyawan_id]) ? $tmp_arr[$val->karyawan_id] : NULL;

					$cur = isset($tmp_cur[$val->karyawan_id]) ? $tmp_cur[$val->karyawan_id] : NULL;

					$ress = isset($tmp_rslt[$val->karyawan_id]) ? $tmp_rslt[$val->karyawan_id] : array();

					$order = isset($tmp_ord[$val->karyawan_id]) ? $tmp_ord[$val->karyawan_id] : array();

					$order2 = isset($tmp_ord2[$val->karyawan_id]) ? $tmp_ord2[$val->karyawan_id] : array();
					
					$pst = isset($tmp_point_st[$val->karyawan_id]) ? $tmp_point_st[$val->karyawan_id] : NULL;
				
					if($sts AND $sts->tech_id == $val->karyawan_id)
					{	
						echo "<tr>";
							echo "<td>".$no."</td>";
							echo "<td>".$sts->tech_name." [T]<br>".$sts->asst_name." [A]</td>";

							$sql = "SELECT b.areaservis, a.date_created, a.date_closed FROM tbl_point_teknisi as a LEFT JOIN tbl_sps as b ON b.id = a.sps_id WHERE a.karyawan_id = ".$sts->tech_id." AND (a.status = 2 OR a.status = 1) ORDER by a.date_closed DESC LIMIT 1";
							$idle = $this->db->query($sql)->row_array();

							if(!empty($cur))
							{
								if($today == date('Y-m-d'))
								{ 
									echo "<td class = 'on-progress'>";
										echo "<b>On Progress</b> <br>";
										echo "<a target ='_blank' href=".site_url('c_tablesps/update/'.$cur->sps_id)."> Job ID ".$cur->job_id."</a><br />";
										echo $cur->areaservis."<br />";
										echo "Start : ".substr($cur->date_created, -8, 5)."<br />";
										echo "<input type = 'hidden' class='date_start_time' value = '".$cur->date_created."'>";
										echo "Elapse Time : <span class = 'hasil'></span>";
									echo "</td>"; 
								
								}elseif($today < date('Y-m-d')) {
									echo "<td class='past-date' >";
										echo "<b>On Progress</b> <br>";
										echo "<a target ='_blank' href=".site_url('c_tablesps/update/'.$cur->sps_id)."> Job ID ".$cur->job_id."</a><br />";
										echo $cur->areaservis."<br />";
										echo "Start : ".substr($cur->date_created, -8, 5)."<br />";
										echo "<input type = 'hidden' class='date_start_time' value = '".$cur->date_created."'>";
										echo "Elapse Time : <span class = 'hasil'></span>";
									echo "</td>"; 
								}elseif($today > date('Y-m-d')) {
									echo "<td></td>";
								}
							}elseif($idle){
								if($today == date('Y-m-d')) {
									echo "<td class = 'idle'>";
										echo "<b>Idle</b> <br>";
										echo "Last Place : ".$idle['areaservis']."<br />";
										$diff = datediff($idle['date_created'], $idle['date_closed']);
										echo "Elapse Time : ".$diff['hours_total']."h ".$diff['minutes']."m";
									echo "</td>";
								}elseif($today < date('Y-m-d')) {
									echo "<td class='past-date'>";
										echo "<b>Idle</b> <br>";
										echo "Last Place : ".$idle['areaservis']."<br />";
										$diff = datediff($idle['date_created'], $idle['date_closed']);
										echo "Elapse Time : ".$diff['hours_total']."h ".$diff['minutes']."m";
									echo "</td>";
								}elseif($today > date('Y-m-d')) {
									echo "<td></td>";
								}
							}else{
								echo "<td></td>";
							}
					
							echo "<td>";
								if($ress)
								{
									foreach ($ress as $res) 
									{
										if ($res['status'] == 2 )
										{ ?>
											<p>
												<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$res['sps_id']) ?>">Job ID <?php echo $res['job_id']; ?></a> 
												[<?php echo substr($res['date_created'], -8,5) ?> - <?php echo substr($res['date_closed'], -8,5) ?>]
												<?php $diff = datediff($res['date_created'], $res['date_closed']); 
													echo $diff['hours_total']."h ".$diff['minutes']."m";
												?>
												<b style = 'background-color : #00FF00;'>&nbsp;Finished&nbsp;</b><br />
											</p>
										<?php }elseif($res['status'] == 3 OR $res['status'] == 4) { ?>
											<p>
												<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$res['sps_id']) ?>">Job ID <?php echo $res['job_id']; ?></a> 
												[<?php echo substr($res['date_created'], -8,5) ?> - <?php echo substr($res['date_closed'], -8,5) ?>]
												<?php $diff = datediff($res['date_created'], $res['date_closed']); 
												echo $diff['hours_total']."h ".$diff['minutes']."m";
												?>
												<b style = 'background-color : #FF0000; color : white;'>&nbsp;Failed&nbsp;</b><br/>
											</p>
										<?php }
									}
								}elseif(empty($ress)) {
										echo "No Result";
								}
							echo "</td>"; 
					
							echo "<td>";
							$n = 1;
								if($order2)
								{
									foreach ($order2 as $ord2) 
									{ ?>
											<p>
											[<?php echo $n; ?>]
											<?php echo $ord2['nickname'] ?>  
											[<?php echo substr($ord2['date_created'], -8,5); ?>] :  
											<a href="<?php echo site_url('c_tablesps/update/'.$ord2['sps_id']); ?>">Job ID <?php echo $ord2['job_id']; ?></a> 
											<?php echo $ord2['perusahaan']; ?> - <?php echo $ord2['areaservis']; ?></p>

										<?php 
											$n++;
									}
								}else{
									echo "No Job";
								}		
							echo "</td>";

							echo "<td>";					
								$n = 1;
								if($order)
								{
									foreach ($order as $ord) 
									{
									 ?>
											<p>
											[<?php echo $n; ?>]
											<?php echo $ord['nickname'] ?>  
											[<?php echo substr($ord['date_created'], -8,5); ?>] :  
											<a href="<?php echo site_url('c_tablesps/update/'.$ord['sps_id']); ?>">Job ID <?php echo $ord['job_id']; ?></a> 
											<?php echo $ord['perusahaan']; ?> - <?php echo $ord['areaservis']; ?></p>

										<?php 
											$n++;
									}
								}else{
									echo "No Job";
								}	
							echo "</td>";
					
							
								if ($_SESSION['myuser']['role_id'] == 4 OR $_SESSION['myuser']['position_id'] == 20 OR $_SESSION['myuser']['position_id'] == 58)
								{ 
									echo "<td>"; 
									?>
									<button type='button' class='btn btn-default btn-sm cancel' >Cancel Assistant</button>
								<?php 
								echo "</td>";
								}  ?>
								<input type="hidden" class="teknisi" value="<?php echo $sts->tech_id ?>">
								<input type="hidden" class="asisten" value="<?php echo $sts->asst_id ?>" >
								<input type="hidden" class="red" value="<?php echo $_SERVER['QUERY_STRING'] ?>">	
							<?php 
							
						echo "</tr>";
						$no++;

					}elseif($val->status == 0) { ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $val->tek_name; ?></td>
							
							<?php 
							$sql = "SELECT b.areaservis, a.date_created, a.date_closed, b.id FROM tbl_point_teknisi as a LEFT JOIN tbl_sps as b ON b.id = a.sps_id WHERE a.karyawan_id = ".$val->karyawan_id." AND (a.status = 2 OR a.status = 1) ORDER by a.date_closed DESC LIMIT 1";
							$idle = $this->db->query($sql)->row_array(); ?>

							<?php if($cur)
							{
								if($today == date('Y-m-d'))
								{ ?>
									<td class="on-progress">
										<b> On Progress</b> <br>
										<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$cur->sps_id); ?>">Job ID <?php echo $cur->job_id ?></a><br />
										<?php echo $cur->areaservis; ?><br />
										Start : <?php echo substr($cur->date_created, -8, 5) ?><br />
										<input type="hidden" class="date_start_time" value="<?php echo $cur->date_created; ?>">
										Elapse Time : <span class="hasil"></span>
									</td>	
								<?php }elseif($today < date('Y-m-d')) { ?>
									<td class="past-date">
										<b> On Progress</b> <br>
										<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$cur->sps_id); ?>">Job ID <?php echo $cur->job_id; ?></a><br />
										<?php echo $cur->areaservis; ?><br />
										Start : <?php echo substr($cur->date_created, -8, 5) ?><br />
										<input type="hidden" class="date_start_time" value="<?php echo $cur->date_created; ?>">
										Elapse Time : <span class="hasil"></span>
									</td>
								<?php	}elseif($today > date('Y-m-d')) { ?>
									<td></td>
								<?php	} ?>
								
							<?php }elseif($idle) {
								if($today == date('Y-m-d'))
								{ ?>
									<td class="idle">
										<b>Idle</b> 
										<br />
										Last Place : <?php echo $idle['areaservis']; ?> <br/ >
										<?php $diff = datediff($idle['date_created'], $idle['date_closed']); ?>
										Elapse Time : <?php echo  $diff['hours_total']; ?>h <?php echo $diff['minutes']; ?>m 
										<br>
									</td>
								<?php	}elseif($today < date('Y-m-d')) { ?>
									<td class="past-date">
									<b>Idle</b> <br />
								Last Place : <?php echo $idle['areaservis']; ?> <br/ >
								<?php $diff = datediff($idle['date_created'], $idle['date_closed']); ?>
								Elapse Time : <?php echo  $diff['hours_total']; ?>h <?php echo $diff['minutes']; ?>m <br>
								</td>
								<?php	}elseif($today > date('Y-m-d')) { ?>
									<td></td>
								<?php	} ?>

							<?php }else { ?>
								<td></td>
							<?php	} ?>
								
							<td>
								<?php
								if($ress)
								{
									foreach ($ress as $res) 
									{
										if ($res['status'] == 2 )
										{ ?>
											<p>
												<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$res['sps_id']) ?>">Job ID <?php echo $res['job_id']; ?></a> 
												[<?php echo substr($res['date_created'], -8,5) ?> - <?php echo substr($res['date_closed'], -8,5) ?>]
												<?php $diff = datediff($res['date_created'], $res['date_closed']); 
													echo $diff['hours_total']."h ".$diff['minutes']."m";
												?>
												<b style = 'background-color : #00FF00;'>&nbsp;Finished&nbsp;</b><br />
											</p>
										<?php }elseif($res['status'] == 3 OR $res['status'] == 4) { ?>
											<p>
												<a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$res['sps_id']) ?>">Job ID <?php echo $res['job_id']; ?></a> 
												[<?php echo substr($res['date_created'], -8,5) ?> - <?php echo substr($res['date_closed'], -8,5) ?>]
												<?php $diff = datediff($res['date_created'], $res['date_closed']); 
												echo $diff['hours_total']."h ".$diff['minutes']."m";
												?>
												<b style = 'background-color : #FF0000; color : white;'>&nbsp;Failed&nbsp;</b><br/>
											</p>
										<?php }
									}
								}elseif(empty($ress)) {
										echo "No Result";
								}	?>
							</td>

							<td>
								<?php 	
								if($order2)
								{
									$n = 1;
									foreach ($order2 as $ord2) 
									{ ?>
										<p>
											[<?php echo $n; ?>]
											<?php echo $ord2['nickname'] ?>  
											[<?php echo substr($ord2['date_created'], -8,5); ?>] :  
											<a href="<?php echo site_url('c_tablesps/update/'.$ord2['sps_id']); ?>">Job ID <?php echo $ord2['job_id']; ?></a>
											<?php if($pst AND $pst->sps_id == $ord2['sps_id']){ ?>
												<span style="background-color: #62F442;"><?php echo $ord2['perusahaan']; ?> - <?php echo $ord2['areaservis']; ?></span>
											<?php }else{ ?>
											<?php echo $ord2['perusahaan']; ?> - <?php echo $ord2['areaservis']; 
											}
											?>
										</p>
									<?php 
										$n++;
									}
								}elseif(empty($order2)) {
									echo "No Job";
								} ?>
							</td>

							<td>
								<?php 	
								if($order)
								{
									$n = 1;
									foreach ($order as $ord) 
									{ ?>
										<p>
											[<?php echo $n; ?>]
											<?php echo $ord['nickname'] ?>  
											[<?php echo substr($ord['date_created'], -8,5); ?>] :  
											<a href="<?php echo site_url('c_tablesps/update/'.$ord['sps_id']); ?>">Job ID <?php echo $ord['job_id']; ?></a> 
											<?php echo $ord['perusahaan']; ?> - <?php echo $ord['areaservis']; ?>
										</p>
									<?php 
										$n++;
									}
								}elseif(empty($order)) {
									echo "No Job";
								} ?>
							</td>

							
							<?php if ($_SESSION['myuser']['role_id'] == 4 OR $_SESSION['myuser']['position_id'] == 20 OR $_SESSION['myuser']['position_id'] == 58) 
							{ ?>
							<td>
								<button type='button' class='btn btn-info btn-sm pick-assist' data-toggle='modal' data-target='#myModalPick' data-tech = '<?php echo $val->karyawan_id ?>'>Pick Assistant</button>
								</td>
							<?php } ?>	
							
						</tr>
					<?php 
					$no++;
					}
				} ?>						
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="myModalPick" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content  ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Assistant</h4>
			</div> 
			<form method="post" action="<?php echo site_url('c_monitoring/Pick_assist/');?>">  
				<div class="modal-body">
					<?php foreach ($tampil as $tech) 
					{
						if($tech->status == 0)
						{ ?>
							<div class="checkbox">
								<input type="checkbox" name="pick[]" value="<?php echo $tech->karyawan_id; ?>">
								<input class="tech-id" type="hidden" name="tech">
								<input type="hidden" name="redirect" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
								<span><?php echo $tech->tek_name; ?></span>
							</div>
							<?php 
						}
					} ?>    
				</div>
				
				<div class="modal-footer">
					<input type='submit' class='btn btn-info pull-left' value='Submit'>
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tanggal').datetimepicker({
		format : 'DD/MM/YYYY',
	});

	 $(document).on( "click", '.pick-assist',function(e) {

     	var tech = $(this).data('tech');
     	
        $(".tech-id").val(tech);
     
    }); 

	function updateClock() {

    $('.date_start_time').each(function() {
       var startDateTime = new Date( $(this).attr('value') );
       console.log(startDateTime);
        startStamp = startDateTime.getTime();
        newDate = new Date();
        newStamp = newDate.getTime();
        var diff = Math.round((newStamp - startStamp) / 1000);

        var d = Math.floor(diff / (24 * 60 * 60));
      
      	//	diff = diff - (d * 24 * 60 * 60);
        var h = Math.floor(diff / (60 * 60));
        diff = diff - (h * 60 * 60);
        var m = Math.floor(diff / (60));
        diff = diff - (m * 60);
        var s = diff;

        $(this).parent().find(".hasil").html(h + "h " + m + "m ");
    });
} 

setInterval(updateClock, 1000);

 $(document).on("click", '.cancel', function(){

	confirm("Anda akan melakukan Cancel Assistant. Lanjutkan ?");
	
	var qs = $(".red").val();
	var tech = $(".teknisi").val();
	var asst = $(".asisten").val();
	
	$.ajax({
		type : 'POST',
		url : '<?php echo site_url('C_monitoring/cancel_asst'); ?>',
		data : {
			data_tek : tech,
			data_asst : asst,
			data_qs : qs,
		},
		success : function(){
			window.location.href = '<?php echo site_url('c_monitoring?'); ?>' + qs;
		},
		error : function (xhr, status, error){
			console.log(xhr);
		},
	}); 
}); 

</script>