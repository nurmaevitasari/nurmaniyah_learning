<?php $file_url = $this->config->item('file_url'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
	.btn-contributor
	{
		background-color: #96f76c;
		border-color: #96f76c;
	}

	.btn-followup
	{
		background-color: #C477CF;
		border-color:  #C477CF;
	}

	.btn-demo {
		background-color: #f99261;
		border-color:  #f99261;	
	}

	.btn-changesales {
		background-color: #5107d8;
		border-color:  #5107d8;	
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

	#dealvalue
	{
		display: none;
	}

	.approved {
		font-weight: bold;
		color: green;
	}

	.not-approved {
		font-weight: bold;
		color: red;
	}

	.waiting {
		color: red;
	}

	.fontsize {
		font-size: 10.5px;
	}

	.red {
		color: red;
	}
	.highlight {
		background-color: #CEAF05;
	}

	@media all and (min-width: 600px) {
		.dl-horizontal dt {
		    float: left;
		    width: 250px;
		    overflow: hidden;
		    clear: left;
		    text-align: right;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		}

		.dl-horizontal dd {
			margin-left: 260px;
		}
	}

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
		<a class="btn btn-default" href="<?php echo site_url('crm'); ?>">
        	<span class="fa fa-arrow-left"></span> BACK
    	</a>
		
			<?php if($detail['status_closed'] == 'Deal') {
				echo "<h2>Detail Dealt CRM</h2>";
			}elseif ($detail['status_closed'] == 'Loss') {
				echo "<h2>Detail Lost CRM</h2>";
			}else {
				echo "<h2>Detail CRM</h2>";
			} ?>
			
		</div>
	</div>
	<hr />

	<div class="col-sm-12">
		<dl style="font-size: 14px;" class="dl-horizontal">
			<dt>Prospect ID</dt>
			<dd><?= !empty($detail['id']) ? $detail['id'] : '-'; ?></dd>
			<?php if($grplink) {
				foreach ($grplink as $key => $grp) {
					if($grp['link_to_modul'] == '2') {
						echo "<dt>".$grp['nama_modul']." ID</dt>";
						echo "<dd>";
						foreach ($link as $val) {
							if($val['link_modul'] == '2') { ?>
								<a target="_blank" href="<?php echo site_url('c_delivery/details/'.$val['link_to_id']); ?>"><?php echo $val['link_to_id'] ?></a> ;
							<?php }
						}
						echo "</dd>";
					}elseif($grp['link_to_modul'] == '3') {
						echo "<dt>".$grp['nama_modul']." ID</dt>";
						echo "<dd>";
						foreach ($link as $val) {
							if($val['link_modul'] == '3') { ?>
								<a target="_blank" href="<?php echo site_url('c_tablesps_admin/update/'.$val['id']); ?>"><?php echo $val['job_id'] ?></a> ;
							<?php }
						}
						echo "</dd>";
					}elseif($grp['link_to_modul'] == '9') {
						echo "<dt>".$grp['nama_modul']." ID</dt>";
						echo "<dd>";
						foreach ($link as $val) {
							if($val['link_modul'] == '9') { ?>
								<a target="_blank" href="<?php echo site_url('Project/details/'.$val['link_to_id']); ?>"><?php echo $val['link_to_id'] ?></a> ;
							<?php }
						}
						echo "</dd>";
					}
					
				}	
			}
			/* if($detail['link_modul'] == '2') { ?>
				<dt>Delivery ID</dt>
				<dd><a target="_blank" href="<?php echo site_url('c_delivery/details/'.$detail['link_modul_id']); ?>"><?php echo $detail['link_modul_id'] ?></a></dd>	
			<?php } */ ?>
			<dt>Sales</dt>
			<dd>
				<?php if(!empty($changesales)) {
					foreach ($changesales as $key => $val) {
						echo $val['nick_exist'].' (Change to) '.$val['nick_new'].'<br>';
					}
				}else {
					echo !empty($detail['nama']) ? $detail['nama'] : '-';
				} ?>
			</dd>		
			<dt>Company Name</dt>
			<dd><?= !empty($detail['perusahaan']) ? $detail['perusahaan'] : '-'; ?></dd>
			<dt>CP</dt>
			<dd><?= !empty($detail['pic']) ? $detail['pic'] : '-'; ?></dd>
			<dt>Telepon</dt>
			<dd><?= !empty($detail['telepon']) ? $detail['telepon'] : '-'; ?></dd>
			<dt>HP</dt>
			<dd><?= !empty($detail['tlp_hp']) ? $detail['tlp_hp'] : '-'; ?></dd>
			<dt>Email</dt>
			<dd><?= !empty($detail['email']) ? $detail['email'] : '-'; ?></dd>
			<dt>Date</dt>
			<dd><?php if($detail['date_created'] != '0000-00-00 00:00:00') {
					echo date('d-m-Y H:i:s', strtotime($detail['date_created']));
				}else {
					echo "-";
				} ?>
			</dd>
			<dt>Inquiry Source</dt>
			<dd><?= !empty($detail['source']) ? $detail['source'] : '-'; ?></dd>
			<dt>Product & Prospect Description</dt>
			<dd><?= !empty($detail['prospect']) ? $detail['prospect'] : '-'; ?></dd>
			<dt>Client Location</dt>
			<dd><?= !empty($detail['site']) ? $detail['site'] : '-'; ?></dd>
			<dt>Progress</dt>
			<dd><?= !empty($detail['progress']) ? $detail['progress'] : '-'; ?> Stage</dd>
			<?php if($detail['status_closed'] == 'Deal') { ?>
				<dt>Deal Value</dt>
				<dd><?php echo "Rp. ".number_format($detail['deal_value'], "0", ",", "."); ?>
				</dd>
			<?php }else { ?>
				<dt>Prospect Value</dt>
				<dd><?php echo "Rp. ".number_format($detail['prospect_value'], "0", ",", "."); ?>
				</dd>
			<?php } ?>
			
			<dt>Last Follow Up</dt>
			<dd><?php if($detail['last_followup'] != '0000-00-00 00:00:00') {
					echo date('d-m-Y', strtotime($detail['last_followup']))." ";
					$datediff = datediff($detail['last_followup'], date('Y-m-d H:i:s'));
					echo " // ".$datediff['days_total']."d ".$datediff['hours']."h ago";
				}else {
					echo "-";
				} ?></dd>
			<dt>Competitor</dt>
			<dd><?= !empty($detail['competitor']) ? $detail['competitor'] : '-'; ?></dd>
			<dt>Special Note</dt>
			<dd><?= !empty($detail['special_note']) ? $detail['special_note'] : '-'; ?></dd>
			<dt>Files</dt>
			<dd><?php if($files) {
					foreach ($files as $row) { ?>
						<?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?>
						<b style = "color : #3992b0"><?php echo $row['nickname']; ?> : </b><a target = "_blank" href="<?php echo $file_url.'assets/images/upload_crm/'.$row['file_name']; ?>"><?php echo $row['file_name']; ?></a><br>
					<?php }
				} ?>
			</dd>
		</dl>
		<br>
		<br>
	</div>
	<br>
	<input type="hidden" name="prg_num" id="prg-num" value="<?php echo $detail['progress_num']; ?>">
	<h3>Discussion & Marketing Activity Log</h3>
		
	<div class="table table-responsive">
		<table class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th style="width: 150px;">Date</th>
					<th>User</th>
					<th>Discussion</th>
					<th style="width: 200px;">Approval</th>
				</tr>
			</thead>
			<tbody>
			<?php if($log) {
				$no = 1;
				foreach ($log as $val) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?></td>
						<td><b style="color:#3992b0;"><?php echo $val['nickname'] ?></b></td>
						<td><?php switch ($val['nickname']) {
							case 'IIOS':
								echo "<span class='red'>".$val['pesan']."</span>";
								break;
							
							default:
								echo $val['pesan'];
								break;
							} ?></td>
						<td><?php 
							
							if($val['crm_type'] == 'Approval Progress') { 
								switch ($val['lvl_approval']) {
									case 'Kadiv':
										$apr = $crm->getLogApproval($val['id']);
										foreach ($apr as $row) {
											switch ($row['status_appr']) {
												case '1':
													echo "<span class='fontsize'><span class ='approved'>Approved</span><br>".date('d-m-Y H:i:s', strtotime($row['date_appr']))." <b>By ".$row['name_appr']."</b></span><br>";
													break;
												
												case '2':
													echo "<span class='fontsize'><span class ='not-approved'>Not Approved</span><br>".date('d-m-Y H:i:s', strtotime($row['date_appr']))." <b>By ".$row['name_appr']."</b><br> Ket : ".$row['note_appr']."</span><br>";
													break;
											}
										}
										
										break;
									case 'Kacab' :
										if(in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93')))
										{ ?>
											<div>
		            							<a href="<?php echo site_url('crm/ApprovalProgress/1/'.$detail['id'].'/'.$val['crm_type_id'].'/'.$val['id']) ?>" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm('Anda menyetujui penurunan progress CRM ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;
		            							<button type="button" name="no" class="btn btn-xs btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $val['crm_type_id'] ?>" data-log = "<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
		          							</div>
										<?php }else {
											echo "<span class='waiting'>Waiting for Ka Div Approval</span>";
										}
										echo "<br>";
										$apr = $crm->getLogApproval($val['id']);
										foreach ($apr as $row) {
											switch ($row['status_appr']) {
												case '1':
													echo "<span class='fontsize'><span class ='approved'>Approved</span><br>".date('d-m-Y H:i:s', strtotime($row['date_appr']))." <b>By ".$row['name_appr']."</b></span><br>";
													break;
												
												case '2':
													echo "<span class='fontsize'><span class ='not-approved'>Not Approved</span><br>".date('d-m-Y H:i:s', strtotime($row['date_appr']))." <b>By ".$row['name_appr']."</b><br> Ket : ".$row['note_appr']."</span><br>";
													break;
											}
										}
										break;
									default : 
										if($val['cabang'] == $_SESSION['myuser']['cabang'] AND in_array($_SESSION['myuser']['position_id'], array('55', '56', '57'))) {  ?>
											<div>
		            							<a href="<?php echo site_url('crm/ApprovalProgress/1/'.$detail['id'].'/'.$val['crm_type_id'].'/'.$val['id']) ?>" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm('Anda menyetujui penurunan progress CRM ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;
		            							<button type="button" name="no" class="btn btn-xs btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $val['crm_type_id'] ?>" data-log = "<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
		          							</div>
										<?php }elseif($val['cabang'] == '' AND in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93'))) { ?>
											<div>
		            							<a href="<?php echo site_url('crm/ApprovalProgress/1/'.$detail['id'].'/'.$val['crm_type_id'].'/'.$val['id']) ?>" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm('Anda menyetujui penurunan progress CRM ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;
		            							<button type="button" name="no" class="btn btn-xs btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $val['crm_type_id'] ?>" data-log = "<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
		          							</div>
										<?php }elseif($val['cabang'] != '') {
											echo "<span class='waiting'>Waiting for Ka Cab Approval</span>";
										}elseif($val['cabang'] == '') {
											echo "<span class='waiting'>Waiting for Ka Div Approval</span>";
										}
										break;		
								}
							} ?>
						</td>
					</tr>
				<?php $no++; 
				}
			} ?>	
			</tbody>
		</table>
	</div>
	<?php if($_SESSION['myuser']['role_id'] != '15' AND ($con_published['published'] != 1 OR in_array($_SESSION['myuser']['position_id'], array('88', '89', '90', '91', '93', '100')))) { ?>
		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg">+ Message</button>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload">+ Files</button>
		<button class="btn btn-default btn-contributor btn-sm" data-toggle="modal" data-target="#modalContributor">+ Contributor</button>
		<button class="btn btn-default btn-followup btn-sm" data-toggle = "modal" data-target="#modalFollowUp">+ Follow Up</button>
		<?php if($detail['progress_sts'] != '1') { ?>
			<button class="btn btn-primary btn-sm" data-toggle= "modal" data-target="#modalProgress">Update Progress</button>
		<?php }
		if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77', '14', '55', '56', '57', '58', '88', '89', '90', '91', '93'))) { ?>
			<button class="btn btn-default btn-sm btn-changesales" data-toggle = "modal" data-target="#modalChangeSales">Change Sales</button>	
		<?php }
		 ?>
		
		<button class="btn btn-sm highlight" data-toggle="modal" data-target="#myModalhighlight">+ Highlight</button>
		<a href="<?php echo site_url('Crm/linkToSPSDemo/'.$detail['id']); ?>" class="btn btn-default btn-sm btn-demo" onclick="return confirm('Anda akan membuat SPS untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">SPS Demo</a>
		<a href="<?php echo site_url('Crm/linkToSPSSurvey/'.$detail['id']); ?>" class="btn btn-default btn-sm btn-survey" onclick="return confirm('Anda akan membuat SPS untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">SPS Survey</a>
		<?php if($detail['progress'] == 'Deal') { ?>
			<a href="<?php echo site_url('Crm/linkToSPS/'.$detail['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda akan membuat SPS untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Create SPS</a>
			<a href="<?php echo site_url('Crm/linkTodel/'.$detail['id']); ?>" class="btn btn-success btn-sm" onclick="return confirm('Anda akan membuat Delivery untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Delivery</a>
			
			<?php if($detail['divisi'] == 'dhc') { ?>
			<a href="<?php echo site_url('Crm/linkToProject/'.$detail['id']); ?>" class="btn btn-default btn-sm" style="background-color: #f2d502; border-color: #f2d502;" onclick="return confirm('Anda akan membuat Project untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Go Project</a>
			<?php } ?>
		<?php }

	} ?>
	
	<br>
	<br>

	<p>Prospect Contributor : <?php $count = count($contributor);
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
	    $max_date = $detail['date_closed'];
	    $total  = datediff($max_date, $min_date);

		if ($detail['date_closed'] == '0000-00-00 00:00:00') { ?>
        <label style="font-size: 16px">
          <input type="hidden" class="date_start_time_total" value="<?php echo $min_date; ?>">
          Total time cost : <span class ="totaltime"></span>
        </label>
      <?php  } else { ?>
        <label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
      <?php } ?>
	</div>

	<br>
	<br>

	<?php
    if(!empty($gethighlight))
    { ?>
	
	<h4>CRM Highlight</h4>
	<h6><font color = "#F8040F" size="2">CRM Highlight hanya digunakan untuk menambahkan hal2 khusus &
	 penting agar tidak terlupakan selama menggarap CRM, tidak untuk berdiskusi</font></h6>
	 <br >

	<div class="table table-responsive">
	<table class="table table-hover" style="font-size: 12px;">
      <tr>
          <th class='head'>No</th>
          <th class='head'>Date</th>
          <th class='head'>user</th>
          <th class='head'>Crm Highlight</th>
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
						<td><?php echo $hl['date_created'] ?></td>
						<td><?php echo $hl['nickname'] ?></td>
						<td><?php echo $hl['highlight'] ?></td>
						<td>
							<?php
							if($hl['status']=='1'){
								echo '<span class="fa fa-check-circle fa-lg" style="color: green; "> Complete</span> <br> By : <b>'.$hl['user_fin']."<br></b> &nbsp;".$hl['date_finish'];
							
							}
							?>	
						</td>	 
						<td><?php echo $hl['notes'] ?></td>
				
        				 <td> 

        				 <?php if($hl['status']=='0'){?>

        				 <a href="javascript:;" data-toggle="modal" data-target="#notes_highlight" class="btn btn-xs btn-info data-record" data-id = "<?php echo $hl['id']; ?>">Complete</a> 

						<?php }?>

         </td>	
         <?php $no++; 
				}
			} ?>
     </tr>
  </table>
  <hr>
  <br/>
</div>
<?php }?>


	<div class="bs-callout bs-callout-danger" >
		<div style="overflow: hidden;">
			<div style="float: left;">
				<h4>Ketentuan SOP CRM : </h4>			
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

	<?php $this->load->view('content/crm/modal_detail_crm'); ?>

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

	$("#tgl_follow, #tgl_upprgs").datetimepicker({
  		format: 'DD/MM/YYYY',
  		useCurrent : false
  	});

  	$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
		        	'<div class="controls col-sm-9">'+
		        		'<input class="" type="file" name="userfile[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

		          	'</div>'+ 
		        '</div>';

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

	        $(this).parent().find(".totaltime").html(d + "d " + h + "h " + m + "m");
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

    CKEDITOR.replace('hasil', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
		shiftEnterMode: CKEDITOR.ENTER_P
    }); 

    CKEDITOR.replace('prgs_note', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
		shiftEnterMode: CKEDITOR.ENTER_P
    });

    CKEDITOR.replace('alasan-change', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
		shiftEnterMode: CKEDITOR.ENTER_P
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

     $("button[name='no']").click(function() {
    	appr_id = $(this).data('id');
    	log_id = $(this).data('log');
    	
    	$("#progress_approval_id").val(appr_id);
    	$("#log_id").val(log_id);
    });

     $('body').delegate('.btn-add-highlight', 'click', function(){
    
      var length = $('.highlight-row').length;
       
   
      html =	 '<div class="form-group highlight-row" id="highlight-row-'+(length+1)+'">'
						+'<div class="row col-sm-12">'
						+	'<div class="controls col-sm-10">'
								+'<input type="text" name="highlight[]" class="form-control" >' 
							+'</div>'

								+'<div class="col-sm-2">'
			            +'<button type="button" class="btn btn-primary btn-add-highlight" data-id="'+(length+1)+'">+</button>'
			            +'&nbsp;&nbsp;<button type="button" class="btn btn-danger highlight-min" data-id="'+(length+1)+'">-</button>'
		          	+'</div>'
							+'</div>'
						+'</div>'
					+'</div>'
				+'</div>';

      $('#highlight').append(html); 
    });

    $('body').delegate('.highlight-min', 'click', function(){
     
     var id = $(this).data('id');
     // alert(id);
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



