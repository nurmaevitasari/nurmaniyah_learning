<table class="table table-hover" style="font-size: 11px;">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Operator</th>
					<th style="width: 150px;">Timer</th>
					<th>Messages</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(!empty($logpr)){
				$no = 1; 
				foreach ($logpr as $key => $lg) { 
					?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo date('d/m/Y H:i:s', strtotime($lg['date_created'])); ?></td>
						<td><?php echo $lg['nickname']; ?><br>
							(<?php echo $lg['position']; ?>)
						</td>
						<td>
							<?php 
							if($no == 1) { 
								echo "Idle : 0d 0h 0m <br />";
								echo "Response : 0d 0h 0m <br />";
								echo "Process : 0d 0h 0m";
							}elseif($no > 1) { 
								$start = date('Y/m/d H:i:s', strtotime($logpr[$key]['date_created'])); 
		                  	 	$date = datediff($start, date('Y/m/d H:i:s')); 
		                  	 	$time_nextto = date('Y/m/d H:i:s', strtotime($logpr[$key]['time_nextto']));
	                        	$time_login = date('Y/m/d H:i:s', strtotime($logpr[$key-1]['time_login'])); 
	                        	$date_process = datediff($time_login, date('Y/m/d H:i:s')); 
	                 
	                  			$time_process = datediff($time_login, $time_nextto);
	                  	
			                    $idle_start = date('Y/m/d H:i:s', strtotime($logpr[$key-1]['time_nextto']));
			                    $idle_date = datediff($idle_start, date('Y/m/d H:i:s')); 
			                    $idle_end = date('Y/m/d H:i:s', strtotime($logpr[$key-1]['time_idle']));
			                    
			                    $idle = datediff($idle_start, $idle_end); 
			                    
			                    $min = date('Y/m/d H:i:s', strtotime($respons['start_date'])); 
			                    $max = date('Y/m/d H:i:s', strtotime($logpr[$key]['date_created']));
			                    $respons_time = datediff($max, $min);
								$idletime = $pr->timer($lg['pr_id'], $logpr[$key-1]['id']);
				            	
				            	if($lg['status'] != '101') {
				     			
					     			if ($idletime['time_idle'] == '0000-00-00 00:00:00' AND $idletime['time_nextto'] == '0000-00-00 00:00:00') { ?>
			                            Idle : 0d 0h 0m<br>
			                        <?php }elseif($idletime['time_idle'] == '0000-00-00 00:00:00' AND $idletime['time_nextto'] != '0000-00-00 00:00:00'){ ?>  
			                            <input type="hidden" class = "date_start_time" value="<?php echo $idle_start; ?>">
			                            Idle : <span name="logtime"> </span><br />
			                        <?php }else{ ?>
			                            Idle : <?php echo $idle['days_total']; ?>d <?php echo $idle['hours']; ?>h <?php echo $idle['minutes']; ?>m<br>
			                        <?php  } ?>

	                        		Response : <?php echo $respons_time['days_total']; ?>d <?php echo $respons_time['hours']; ?>h <?php echo $respons_time['minutes']; ?>m<br />

	                        		<?php $process = $pr->timer($lg['pr_id'], $lg['id']); 
							
				                    if($idletime['time_login'] == '0000-00-00 00:00:00'){
				                    	echo 'Process : 0d 0h 0m'; 
				                    }elseif($idletime['time_login'] != '0000-00-00 00:00:00' AND $process['time_nextto'] == '0000-00-00 00:00:00'){ ?>
				                    	<input type="hidden" class = "date_start_time" value = "<?php echo $time_login; ?>">
				                    	Process : <span name="logtime"></span>
				                    <?php }elseif($idletime['time_login'] != '0000-00-00 00:00:00' AND $process['time_nextto'] != '0000-00-00 00:00:00'){
				                    	echo "Process : ".$time_process['days_total']."d ".$time_process['hours']."h ".$time_process['minutes']."m ".$time_process['seconds']."s"; 
				                    } ?>
				            	<?php }elseif ($lg['status'] == '101') {
					            	echo "Idle : ".$idle['days_total']."d ".$idle['hours']."h ".$idle['minutes']."m <br>";
									echo "Response : ".$respons_time['days_total']."d ".$respons_time['hours']."h ".$respons_time['minutes']."m <br>";
									echo "Process : ".$time_process['days_total']."d ".$time_process['hours']."h ".$time_process['minutes']."m <br>";
				            	} 
				        	} ?>
						</td>
						<td><?php 
								$pr_log_pesan = $pr->load_pesan($lg['pr_id'], $lg['id']);	

								foreach ($pr_log_pesan as $psn) { ?>
									<b style="color: #3992b0;"><?php echo $psn['nickname']; ?></b> [ <?php echo date('d/m/Y H:i:s', strtotime($psn['date_created'])); ?> ] : <?php echo $psn['pesan']."<br>"; 
								}
							
								if($no == $numrows AND $_SESSION['myuser']['role_id'] != '15') { ?>
									<br><a href="javascript:;" data-toggle="modal" data-target="#myModalMsg" class="btn btn-xs btn-info data-record"><span class="fa fa-plus" data-id = "<?php echo $lg['overto']; ?>"></span> Message</a>
		                
		                        	<a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning"><span class="fa fa-plus"></span> Files</a>

		                        	<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalContributor"><b>+</b> Contributor</button>
	                          	
	                          	<?php /* if($logpr[$key]['id_operator'] != $_SESSION['myuser']['karyawan_id']){ ?>
	                            	<!-- <a href="<?php echo site_url('C_purchasing/takeOver/'.$lg['pr_id']); ?>" class="btn btn-primary btn-xs">Take Over</a> -->
								<?php } */
								} ?>
						</td>
					</tr>
				<?php $no++; } } ?>
			</tbody>
		</table>
		  <hr />
		<div>
	    	<?php 
	      	$min_date = date('Y/m/d H:i:s', strtotime($respons['date_created'])); 
	      	$max_date = date('Y/m/d H:i:s', strtotime($respons['date_closed']));
	    	$total  = datediff($max_date, $min_date);

	      	if ($respons['date_closed'] == '0000-00-00 00:00:00') { ?>
	        	<label style="font-size: 16px">
	          		<input type="hidden" class="date_start_time" value="<?php echo $min_date; ?>">
	          		Total time cost : <span name="logtime"></span><br />
	       		</label>
	      	<?php  } else { ?>
	        	<label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
	      	<?php } ?>
	    </div>
  		
  		<div>
  			<?php 
  			$appr = $pr->getApproval($lg['pr_id']);
  			$co = end($appr); 	
			if(!empty($co)) {
				$arr = $co;
			}


  			if($lg['status'] != '101' AND $lg['status'] !='100' AND $lg['status'] != '0') {
  				$end = end($logpr);
  				if($lg['sales_id'] == $_SESSION['myuser']['karyawan_id']) { ?>
  					<a href="<?php echo site_url('C_purchasing/pr_finished/'.$lg['pr_id']); ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin PR ini telah selesai ?')">Purchase Finished</a>
  				<?php }elseif(in_array($_SESSION['myuser']['position_id'], array('12', '58', '77')) AND $row['qty_received'] == $row['qty_approved']) { ?>
  					<a href="<?php echo site_url('C_purchasing/pr_finished/'.$lg['pr_id']); ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin PR ini telah selesai ?')">Purchase Finished</a>
  				<?php } ?>
     			<span>&nbsp; </span>

		    <?php
				if($end['id_operator'] == $_SESSION['myuser']['karyawan_id'] AND $co != '0' AND in_array($arr['status_approval'], array('1', '3')))  { ?>
					<a href="<?php echo site_url('C_purchasing/nextTo/'.$lg['pr_id']); ?>" class="btn btn-primary">Next To >></a>
			<?php	} } ?>
		
  		</div>	