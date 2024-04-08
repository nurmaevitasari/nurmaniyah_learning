<?php $file_url = $this->config->item('file_url'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
	.progress-bar {
		font-size: 10px;
	}

	.progress {
		width: 100%;
		max-width: 500px;
	}

	/* .btn-contributor
	{
		background-color: #96f76c;
		border-color: #96f76c;
		color: white;
	} */

	.btn-updates
	{
		background-color: #C477CF;
		border-color:  #C477CF;
		color: white;
	}

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

	.bs-callout-danger {
	    border-left-color: #d9534f;
	}
	.bs-callout-danger h4 {
	    color: #d9534f;
	}

	.btn-highlight{
        background-color: #ede621;
       // color :#ffffff;
    }	
    .tbl th {
    	text-align: center;
    }

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
		<a class="btn btn-default" href= "<?php echo site_url('Project'); ?>">
        	<span class="fa fa-arrow-left"></span> BACK
    	</a>
			<h2>Detail Project DHC</h2>
		</div>
	</div>
	<hr />

	<div class="col-sm-12">
		<dl style="font-size: 14px;" class="dl-horizontal">
			<dt>Project ID</dt>
			<dd><?= !empty($detail['id']) ? $detail['id'] : '-'; ?></dd>
			<?php if($link_modul) {
				echo "<dt>CRM ID</dt>";
				echo "<dd>";
					foreach ($link_modul as $val) { 
						if(in_array($_SESSION['myuser']['role_id'], array('1','2'))) {  ?>
							<a target="_blank" href="<?php echo site_url('crm/details/'.$val['link_from_id']); ?>"><?php echo $val['link_from_id'] ?></a> ;
						<?php }else {
							echo $val['link_from_id']." ;";
						} ?>
						
						
					<?php }
				echo "</dd>";
			} 

			if($link_dlv) {
				echo "<dt>Delivery ID</dt>";
				echo "<dd>";
					foreach ($link_dlv as $val) { ?>
						<a target="_blank" href="<?php echo site_url('C_delivery/details/'.$val['link_to_id']); ?>"><?php echo $val['link_to_id'] ?></a> ;
					<?php }
				echo "</dd>";
			} ?>
			<dt>Salesman</dt>
			<dd><?= !empty($detail['nickname']) ? $detail['nickname'] : '-'; ?></dd>		
			<dt>Client</dt>
			<dd><?= !empty($detail['perusahaan']) ? $detail['perusahaan'] : '-'; ?></dd>
			<dt>Site CP</dt>
			<dd><?= !empty($detail['site_cp']) ? $detail['site_cp'] : '-'; ?> / <?= !empty($detail['no_hp']) ? $detail['no_hp'] : '-'; ?> / <?= !empty($detail['email_cp']) ? $detail['email_cp'] : '-'; ?></dd>
			<dt>Site Location</dt>
			<dd><?= !empty($detail['project_addr']) ? $detail['project_addr'] : '-'; ?></dd>
			<dt>Google Map Link</dt>
			<dd>
				<?php if(!empty($files))
	  			{
	    			foreach($files as $fs)
	      			{
	       				if($fs['file_name'] != '' AND $fs['type'] == '2') {

		        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
		        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
		        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        	 		<?php 
	        			}
	      			}
	  			}else {
      				echo "-";
      			}  ?>
			</dd>
			<dt>Project Type</dt>
			<dd><?php if($detail['project_type'] == 0 ) { echo "Semi Project"; }else{ echo "Full Project"; } ?></dd>
			<dt>DP Date</dt>
			<dd><?php echo date('d-m-Y', strtotime($detail['dp_date'])); ?></dd>
			<dt>Deadline BAST</dt>
			<dd><?php echo str_replace('@@', '; ', $detail['dline_date']); ?></dd>
			<dt>Project Description</dt>
			<dd><?= !empty($detail['description']) ? $detail['description'] : '-'; ?></dd>
			<dt>Project Aging</dt>
			<dd><?php 
				if($detail['date_closed'] == '0000-00-00 00:00:00') {
					$time = date('Y-m-d H:i:s');
				}else {
					$time = $detail['date_closed'];
				}
			$datediff = datediff($detail['deadline_date'], $time);  
				if($detail['deadline_date'] > $time)
				{
					$plusmin = " +";
					$textcolor = "blue";
				}elseif($detail['deadline_date'] <= $time) {
					$plusmin = " -";
					$textcolor = "red";
				}
				$datediff = "<span style = 'color : ".$textcolor.";'>".$plusmin.$datediff['days_total']."d ".$datediff['hours']."h ".$datediff['minutes']."m </span>";
				?>
				<?= !empty($detail['days_deadline']) ? $detail['days_deadline'] : '0'; ?>d / <?php echo $datediff;  ?></span>
			</dd>
			<dt>Progress</dt>
			<dd>   
				<div class="progress">
					<?php $prg = '';
					if($detail['last_progress'] > '1' OR $detail['last_progress'] == '1') {
						$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#001433;">
				      DP
				    </div>';
					}
					
					if($detail['last_progress'] >= '2') {
						$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#001f4d;">
				      Survey
				    </div>';
					}

					if($detail['last_progress'] >= '3') {
						$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#002966">
				      KickOff
				    </div>';
					}

					if($detail['last_progress'] >= '4') {
						$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#003380;">
				      Material
				    </div>';
					}

					if($detail['last_progress'] >= '5') {
						$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#003d99;">
				      Production
				    </div>';
					}

					if($detail['last_progress'] >= '6') {
						$prg .= ' <div class="progress-bar " role="progressbar" style="width:11%; background-color:#0047b3;">
				      Delivery
				    </div> ';
					}

					if($detail['last_progress'] >= '7') {
						$prg .= '<div class="progress-bar " role="progressbar" style="width:11%; background-color:#0052cc;">
				      Installation
				    </div> ';
					}

					if($detail['last_progress'] >= '8') {
						$prg .= ' <div class="progress-bar" role="progressbar" style="width:11%; background-color:#005ce6;">
				      Finished
				    </div>';
					}

					if($detail['last_progress'] >= '9') {
						$prg .= '<div class="progress-bar" role="progressbar" style="width:12%; background-color:#0066ff;">
				      Paid
				    </div>';
					}

					echo $prg; ?>
				     
			  	</div>
			</dd>
			<dt>Status</dt>
			<dd><?php 
				if(!empty($detail['dates']))
				{
					$sts = date('Y-m-d', strtotime($detail['dates']));
					$dclose = date('Y-m-d', strtotime($detail['date_closed']));

					if($detail['date_closed'] != '0000-00-00 00:00:00') {
						$now = $dclose;
						$diff = datediff($sts, $dclose);
					}else {
						$now = date('Y-m-d');
						$diff = datediff($sts, $now);
					}

					if($now < $sts OR $sts == $now) {
						echo "On-Schedule / +".$diff['days_total']."d";
					}elseif($now > $sts) {
						echo "Overdue / -".$diff['days_total']."d";
					}
				}else{
					echo "-";
				} ?></dd>
			<dt>Execution</dt>
			<dd><?php if($detail['date_closed'] != '0000-00-00 00:00:00'){ echo "<span style='color : green;'> Finished </span>"; }elseif($detail['execution'] == '0') { echo "Queue"; }elseif($detail['execution'] == '1'){ echo "Worked-On"; } ?>
			</dd>
			<dt>File ACC Customer</dt>
			<dd><?php
				if($countfiles) {
					if(!empty($fileACCcus))
	  				{
		    			foreach($fileACCcus as $fs)
		      			{
		       					if($fs['file_name'] != '') {
		       						echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
					        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
					        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload_project/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
				        	 	<?php }else { 
				        				echo "-";
				        			}		
		      			}
	  				}else {
      				echo "-";
      				}	
				}elseif($detail['last_progress'] == '4') { ?>
					<span style="color: red;">Upload project layout ACC from customer to start the project</span>
				<?php }else {
					echo "-";
				} ?>
				
      		</dd>
			<dt>File ACC Salesman</dt>
			<dd><?php
				if($countfiles) {
					if(!empty($fileACCsales))
	  				{
		    			foreach($fileACCsales as $fs)
		      			{
	       					if($fs['file_name'] != '') {
	       						echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
				        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
				        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload_project/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
			        	 	<?php }else { 
			        				echo "-";
			        			}	
		      			}
	  				}else {
      				echo "-";
      				}	
				}elseif($detail['last_progress'] == '4') { ?>
					<span style="color: red;">Upload Salesman ACC on SPK NT to start the project</span>
				<?php }else {
					echo "-";
				} ?>
      		</dd>
			<dt>Files</dt>
			<dd>
				<?php
				if(!empty($files))
	  			{
	    			foreach($files as $fs)
	      			{
	       				if($fs['file_name'] != '' AND $fs['type'] == '0') {

		        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
		        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
		        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload_project/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        	 		<?php 
	        			}elseif($fs['file_name'] != '' AND $fs['type'] == '3') {
	        				echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
		        			<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
		        			<a target="_blank" href="<?php echo $file_url.'assets/images/upload_do/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        	 		<?php 
	        			}
	      			}
	  			}else {
      				echo "-";
      			}  ?>
			</dd>
			<?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '88', '14','73'))) { ?>
			<hr />
			<dt>Technical Files</dt>
			<dd>
				<?php if(!empty($files))
	  			{
	    			foreach($files as $fs)
	      			{
	       				if($fs['file_name'] != '' AND $fs['type'] == '1') {

		        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
		        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
		        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload_project/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        	 		<?php 
	        			}
	      			}
	  			}else {
      				echo "-";
      			}  ?>
			</dd>
			<?php } 

			if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '88', '14'))) { ?>
	
			<dt>Confidential Files</dt>
			<dd>
				<?php if(!empty($files))
	  			{
	    			foreach($files as $fs)
	      			{
	       				if($fs['file_name'] != '' AND $fs['type'] == '6') {

		        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
		        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
		        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload_project/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        	 		<?php 
	        			}
	      			}
	  			}else {
      				echo "-";
      			}  ?>
			</dd>
			<?php } ?>
		</dl>
		<br>
		<br>
		<br>
	</div>
	<br>
	
	<h3>Discussion & Marketing Activity Log</h3>
		
	<div class="table table-responsive">
		<table class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th style="width: 140px;">Date</th>
					<th>User</th>
					<th>Discussion</th>
				</tr>
			</thead>
			<tbody>
			<?php if($log) {
				$no = 1;
				foreach ($log as $val) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?></td>
						<td><?php echo $val['nickname'] ?></td>
						<td><?php echo ($val['type'] == 'Upload') ? 'Menambahkan file <a href="'.$file_url.'assets/images/upload_project/'.$val['pesan'].'"target="_blank" >'.$val['pesan'].'</a>' : $val['pesan'] ?></td>

					</tr>
				<?php $no++; 
				}
			} ?>	
			</tbody>
		</table>
	</div>
	<?php //echo $countfiles;
	if($_SESSION['myuser']['role_id'] != '15' AND $detail['project_type'] == '0' OR ($detail['last_progress'] < 4 OR ($detail['last_progress'] >= 4 AND $countfiles == '2'))) { ?>
		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg">+ Message</button>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload">+ Files</button>
		<button class="btn btn-default btn-contributor btn-sm" data-toggle="modal" data-target="#modalContributor" style="background-color: #C477CF; border-color: #C477CF; color: white;">+ Contributor</button>
		<button class="btn btn-default btn-danger btn-sm" data-toggle = "modal" data-target="#modalFollowUp" >Update</button>
		<a href="<?php echo site_url('Project/UpdateDeadline/'.$detail['id']); ?>" class="btn btn-primary btn-sm" onclick="return confirm('Anda akan mengupdate Tanggal Deadline BAST. Lanjutkan ?')"><b>+</b> Deadline BAST</a>
		<button class="btn btn-default btn-reminder btn-sm" data-toggle="modal" data-target="#modalReminder" style="background-color: #e37840; color: white; border-color:#e37840; ">+ Reminder</button>
		<a href="<?php echo site_url('Project/GoTagih/'.$detail['id']); ?>" class="btn btn-info btn-sm" onclick="return confirm('Anda akan meminta Tim FA untuk penagihan Project ID <?php echo $detail['id']; ?>. Lanjutkan ?')" style="background-color:#8e0748; border-color: #8e0748; color: white;" title="Tagih">Tagih</a>
		<a href="<?php echo site_url('Project/linkTodel/'.$detail['id']); ?>" class="btn btn-success btn-sm" onclick="return confirm('Anda akan membuat Delivery untuk Project ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Delivery</a>
		<button class="btn btn-highlight btn-sm" data-toggle="modal" data-target="#myModalhighlight">+ Highlight</button>
		<?php 
	}elseif($countfiles != '2') { ?>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload">+ ACC Files</button>
	<?php } ?>
	
	<br/>
    <hr />
    <br>
    <?php if($gethighlight) { ?>

	    <h3>Project Highlight</h3>
		<div id="dvData" class="table-responsive">
		  	<table class="table table-hover tbl" style="font-size: 12px;">
		      	<tr>
					<th class='head'>No</th>
					<th class='head'>Date</th>
					<th class='head'>User</th>
					<th class='head'>Project Highlight</th>
					<th class='head'>Status</th>
					<th class='head'>Notes</th>
					<th class='head'>Action</th>
		      	</tr>
		     	<tr class="active">
		          	<?php if($gethighlight) {
		                $no = 1;
		                foreach ($gethighlight as $hl) { ?>
		                    <tr>
		                        <td><?php echo $no; ?></td>
		                        <td><?php echo date('d-m-Y H:i:s', strtotime($hl['date_created'])); ?></td>
		                        <td><?php echo $hl['nickname'] ?></td>
		                        <td><?php echo $hl['highlight'] ?></td>
		                        <td>
		                            <?php
		                            if($hl['status']=='1'){
		                                echo '<center style="font-size: 11px;"><span class= "fa fa-check-circle fa-lg" style="color: green;"></span><b style="color: green;"> Completed</b><br>'.date("d-m-Y H:i:s", strtotime($hl['date_finish'])).' By : <b>'.$hl['user_fin'].'</b></center>';
		                            } ?>   
		                        </td>  
		                        <td>
		                        	<?php if($hl['status']=='1'){
		                               echo $hl['notes'];
		                            } ?>  
								</td>		                           
		                        <td>
		                        	<?php if($hl['status'] != '1') { ?>
		                        	<a href="javascript:;" data-toggle="modal" data-target="#modal_notes" class="btn btn-xs btn-info data-record" data-id = "<?php echo $hl['id']; ?>">Complete</a> 
		                        	<?php } ?>
		         				</td>    
		         		<?php $no++; 
		                }
		            } ?>
		     	</tr>
		  	</table>
		  	<hr>
		  	<br/>
		</div>
	<?php } ?>
	<br>

	<p>Project Contributor : <?php $count = count($contributor);
	$x = 1; 
	foreach ($contributor as $con) {
		if($x == $count) {
			$a =  ".";
		}else {
			$a = ",";
		}

		echo " ".$con['nickname'].$a;
	$x++; } ?></p>
	
	<div>
		<?php 
		$min_date = $detail['date_created']; 

		
	    if($detail['log_progress'] >= '8')
	    {
	    	$max_date = $detail['log_progress_date'];
	    	$total  = datediff($max_date, $min_date);

	    	echo '<label style="font-size: 16px">Total time cost: '.$total['days_total'].'days '.$total['hours'].'hours '.
	    	$total['minutes'].'minutes</label>';
      	}else { ?>
      		<label style="font-size: 16px">
	          <input type="hidden" class="date_start_time_total" value="<?php echo $min_date; ?>">
	          Total time cost : <span class ="totaltime"></span>
	        </label>
      	<?php } ?>
        
	</div>


	<div class="bs-callout bs-callout-danger" >
		<div style="overflow: hidden;">
			<div style="float: left;">
				<h4>Ketentuan SOP Project DHC : </h4>			
			</div>	
			<?php if(in_array($_SESSION['myuser']['position_id'], array('1','2', '14', '77'))) {
				echo '&nbsp; &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ketentuan" title="Edit"><span class="fa fa-edit"></span></button>';
			} ?>
		</div>	
	  	<div>
      	<?php if ($ketentuan)
		{ ?>
			<div style="font-size: 10px;">
				Last Update  : <?php $format = date('d-m-Y H:i:s', strtotime($ketentuan["date_created"] ));	echo $format;?>
				<br>
				By	 : <b> <?php echo $ketentuan["nickname"];?></b>
			</div>
			<br>
			<div style="font-size: 13px;">
				<?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?>
			</div>
			
			<?php  } ?>
    	</div>
	</div>

	<?php $this->load->view('content/project/modal'); ?>


<script type="text/javascript">
	$("#sel-progress").change(function() {
		val = $(this).val();
		if(val == 'Deal') {
			$("#dealvalue").css({'display' : 'block'});
			$("input[name='deal_value']").attr('required', true);
			$(".dealvalue").html("Deal Value (Rp)");
			$("#pdeal").text("Wajib diisi dengan harga final deal berikut PPn");
		}else {
			$("#dealvalue").css({'display' : 'block'});
			$("input[name='deal_value']").attr('required', false);
			$(".dealvalue").html("Change Value (Rp)");
			$("#pdeal").text("**Pastikan Value CRM benar sebelum deal, karena tidak dapat diubah kembali");
		}
	});

	$("#deal_value").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {    
	    	alert("Number Only !");
			return false;
		}
	});	

  	$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;
      var tipefile = $('#tipefile').val();

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
		        	'<div class="controls col-sm-9">'+
		        		'<input class="" type="file" name="userfile[]"> '+
		          	'</div>'+
		        	'<div class="col-sm-3">'+
			            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

		          	'</div>'+ 
		        '</div> <input type = "hidden" name="tipefile" value="'+tipefile+'">';

      $('#add-row').append(html); 
    });

    $('body').delegate('.btn-remove-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;
      
      if(length > 1)
      {
        $('#file-row-'+id).remove();
      }
    });

    function updateClock() {
    	$('.date_start_time_total').each(function() {
	       var startDateTime = new Date( $(this).attr('value') );
	        startStamp = startDateTime.getTime();
	        newDate = new Date();
	        newStamp = newDate.getTime();
	        var diff = Math.round((newStamp - startStamp) / 1000);

	        var d = Math.floor(diff / (24 * 60 * 60));
	      
	      diff = diff - (d * 24 * 60 * 60);
	        var h = Math.floor(diff / (60 * 60));
	        diff = diff - (h * 60 * 60);
	        var m = Math.floor(diff / (60));
	        diff = diff - (m * 60);
	        var s = diff;

	        $(this).parent().find(".totaltime").html(d + "d " + h + "h " + m + "m " + s + "s");
	    });
    }
    
    setInterval(updateClock, 1000);

    CKEDITOR.replace('kt', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      	shiftEnterMode: CKEDITOR.ENTER_P
    });

     CKEDITOR.replace('msg', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      	shiftEnterMode: CKEDITOR.ENTER_P
    });

    $("#add_btn").click(function(e) {
    	var messageLength = CKEDITOR.instances['msg'].getData().replace(/<[^>]>/gi, ' ').length;
    	var space = CKEDITOR.instances['msg'].getData().replace(/&nbsp;/gi, '').length;
    	
    	if(!messageLength || !space) {
    		alert('Pesan tidak boleh kosong');
    		e.preventDefault();
    		
    	}
    });

    function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }

	function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
    }

    $('#exec').change(function() {
    	val = $(this).val();
    	
    	if(val != '')
    	{
    		$("#exec_note").attr('required', true);
    	}else{
    		$("#exec_note").attr('required', false);
    	} 	
    });

    $('#listprogress').change(function() {
    	val = $(this).val();
    	
    	if(val != '')
    	{
    		$("#listprogress_note").attr('required', true);
    	}	
    });

    $("#reminder").datetimepicker({
  		format: 'DD/MM/YYYY',
  		useCurrent : false
	});

	$('body').delegate('.btn-add-highlight', 'click', function(){
    	var length = $('.highlight-row').length;
        
      	html =	'<div class="form-group highlight-row" id="highlight-row-'+(length+1)+'">'
                        +'<div class="row col-sm-12">'
                        	+'<div class="controls col-sm-9">'
                                +'<input type="text" name="highlight[]" class="form-control" >'
                            +'</div>'
                            +'<div class="col-sm-3">'
                        		+'<button type="button" class="btn btn-primary btn-add-highlight" data-id="'+(length+1)+'">+</button>'
                        		+'&nbsp;&nbsp;<button type="button" class="btn btn-danger highlight-min" data-id="'+(length+1)+'">-</button>'
                    		+'</div>'
                        +'</div>'
                        +'</div>'
                    +'</div>';
 
      	$('#highlight').append(html); 
    });
 
    $('body').delegate('.highlight-min', 'click', function(){
      
    	var id = $(this).data('id');
   		var length = $('.highlight-row').length;
       
		if(length > 1)
		{
			$('#highlight-row-'+id).remove();
		}
    });
 
 
    $(document).on( "click", '.data-record',function(e) {
 
	    var id = $(this).data('id');
	 	$(".highlight-id").val(id);
      
    }); 


</script>



