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

	#dealvalue {
		display: none;
	}	

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
		<a class="btn btn-default" onclick="history.back(-1)">
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
			<dd><?= !empty($detail['nama']) ? $detail['nama'] : '-'; ?></dd>		
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
						<b style = "color : #3992b0"><?php echo $row['nickname']; ?> : </b><a target = "_blank" href="<?php echo base_url('assets/images/upload_crm/'.$row['file_name']); ?>"><?php echo $row['file_name']; ?></a><br>
					<?php }
				} ?>
			</dd>
		</dl>
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
					<th style="width: 150px;">Date</th>
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
						<td><?php echo $val['pesan']; ?></td>
					</tr>
				<?php $no++; 
				}
			} ?>	
			</tbody>
		</table>
	</div>
	<?php if($_SESSION['myuser']['role_id'] != '15') { ?>
	<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg">+ Message</button>
	<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload">+ Files</button>
	<button class="btn btn-default btn-contributor btn-sm" data-toggle="modal" data-target="#modalContributor">+ Contributor</button>
	<button class="btn btn-default btn-followup btn-sm" data-toggle = "modal" data-target="#modalFollowUp">+ Follow Up</button>
	<?php if($detail['progress'] != 'Deal') { ?>
			<button class="btn btn-primary btn-sm" data-toggle= "modal" data-target="#modalProgress">Update Progress</button>
		<?php } ?>
	<a href="<?php echo site_url('C_crm/linkToSPS/'.$detail['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda akan membuat SPS untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Create SPS</a>
	<?php if($detail['progress'] == 'Deal') { ?>
			<a href="<?php echo site_url('C_crm/linkTodel/'.$detail['id']); ?>" class="btn btn-success btn-sm" onclick="return confirm('Anda akan membuat Delivery untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Delivery</a>
			<?php if($detail['divisi'] == 'dhc') { ?>
			<a href="<?php echo site_url('C_crm/linkToProject/'.$detail['id']); ?>" class="btn btn-default btn-sm" style="background-color: #f2d502; border-color: #f2d502;" onclick="return confirm('Anda akan membuat Project untuk CRM ID <?php echo $detail['id']; ?>. Lanjutkan ?')">Go Project</a>
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


	<div id="ketentuan" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<!-- konten modal-->
			<div class="modal-content">
			<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Ketentuan</h4>
				</div>
				<!-- body modal -->
				<form method="post" action="<?php echo site_url('c_ketentuan/simpanSOP') ?>">
					<div class="modal-body">
						<textarea type="text" id="kt" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
						<input type="hidden" value="8" name="nama_modul">
						<input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
					</div>
					<!-- footer modal -->
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFollowUp" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('C_crm/FollowUp'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Follow Up</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Date</label>
	            		<div class="col-sm-4">
	            			<input type="text" name="tgl_follow" id="tgl_follow" class="form-control">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">PIC</label>
	            		<div class="col-sm-8">
	            			<input type="text" name="pic" id="pic" class="form-control">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Follow Up Via</label>
	            		<div class="col-sm-8">
	            			<select name="via" class="form-control" style="width: 100%;">
	            				<option value="">-Pilih-</option>
	            				<option value="Email">Email</option>
	            				<option value="Kunjungan">Kunjungan / Meeting</option>
	            				<option value="Sms">SMS</option>
	            				<option value="Telepon">Telepon</option>
	            				<option value="Wa">WA</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Hasil Follow Up</label>
	            		<div class="col-sm-8">
	            			<textarea name="hasil" id="hasil" class="form-control" rows="4"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProgress" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('C_crm/UpProgress'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Update Progress</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Date</label>
	            		<div class="col-sm-4">
	            			<input type="text" name="tgl_upprgs" id="tgl_upprgs" class="form-control" required="true">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress</label>
	            		<div class="col-sm-8">
	            			<select name="progress" class="form-control" style="width: 100%;" required="true" id="sel-progress">
	            				<option value="">-Pilih-</option>
	            				<option value="Introduction">Introduction</option>
	            				<option value="Quotation">Quotation</option>
	            				<option value="Negotiation">Negotiation</option>
	            				<option value="Deal">Deal</option>
	            				<option value="Loss">Loss</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group row" id="dealvalue">
						<label class="control-label col-sm-3 dealvalue">Deal Value (Rp)</label>
						<div class="col-sm-8">
							<input type="text" name="deal_value" class="form-control" onkeyup="splitInDots(this)" placeholder="Enter Integer Number" id="deal_value" value="<?php echo number_format($detail['prospect_value'], "0", ",", "."); ?>">
							<p style="font-size: 12px;" id="pdeal">Wajib diisi dengan harga final deal berikut PPn</p>
						</div>
					</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Posibilities</label>
	            		<div class="col-sm-8">
	            			<select name="posibilities" class="form-control" style="width: 100%;" required="true">
	            				<option value="">-Pilih-</option>
	            				<option value="10">10%</option>
	            				<option value="20">20%</option>
	            				<option value="30">30%</option>
	            				<option value="40">40%</option>
	            				<option value="50">50%</option>
	            				<option value="60">60%</option>
	            				<option value="70">70%</option>
	            				<option value="80">80%</option>
	            				<option value="99">99%</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group row" id="competitor">
						<label class="control-label col-sm-3">Update Competitor</label>
						<div class="col-sm-8">
							<input type="text" name="competitor" class="form-control" id="competitorid" value="<?php echo $detail['competitor']; ?>">
						</div>
					</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress Note</label>
	            		<div class="col-sm-8">
	            			<textarea name="prgs_note" id="prgs_note" class="form-control" rows="4"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalContributor" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('C_crm/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Add Contributor</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Contributor</label>
	            		<div class="col-sm-8">
	            			<select name="contributor[]" class="form-control" style="width: 100%;" multiple="true">
	            				<option value="">-Pilih-</option>
	            				<?php if($karyawan) {
	            					foreach ($karyawan as $kar) { ?>
	            						<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
	            					<?php }
	            					} ?>
	            			</select>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalMsg" role="dialog" method="post">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" method="post" action='<?php echo site_url('c_crm/add_pesan'); ?>'; onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Adding...'; ">
				<div class="modal-header">
					<h4>Add Message</h4>
				</div>
				<div class="modal-body">
					<br>
					<div class="form-group">
						<label for="contact-msg" class="col-sm-1 col-md-1 control-label">&nbsp;</label>
						<div class="col-md-10">
							<textarea class="form-control" rows="6" name="msg" id="msg" required=""></textarea>
							<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type='submit' class='btn btn-info pull-left' value='Add' name="submit_btn">
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalUpload" role="dialog" method="post">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_crm/uploadFile/');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Uploading...'; ">
				<div class="modal-header">
					<h4>Upload Files</h4>
				</div>
				<div class="modal-body">
					<div class="form-group file-row " id="file-row-1">
						<div class="row col-sm-12">
							<div class="controls col-sm-10">
								<input class="" type="file" name="userfile[]">
							</div>
							<div class="col-sm-2">   
								<button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>
						</div>
					</div>
					<div id="add-row">

					</div>
					<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
				</div>
				<div class="modal-footer">
					<input type="submit" name="submit_btn" id="submit" value="Upload" class="btn btn-info pull-left" /> 
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>


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
    	height : 200
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
</script>



