<?php $user = $this->session->userdata('myuser'); 
$file_url = $this->config->item('file_url');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
	

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
</style>
<div id="page-inner">
  	<div class="col-sm-2">
      	<a href="<?php echo site_url('C_imp/index'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="row">
      <div class="col-md-12" style="overflow: hidden;">
        <h2>IMP Details</h2>     
      </div> 
    </div>
    <hr>

    <div id="detail" class="row">
  		<div class="col-sm-11">
   			<dl class="dl-horizontal" style="font-size: 14px;">
				<dt>IMP ID</dt>
		 	 		<dd><?php echo $imp['id'];?></dd>   
				<dt>Employee Name</dt>
		  			<dd>
		  				<?php 
						if(($pos = strpos($imp['nama'], ".")) !== FALSE)
						{
						echo substr($imp['nama'], $pos+1); 
						}else{
						echo strtok($imp['nama'], " ");
						} ?>
						(<?php echo $imp['position']; ?> - <?php echo $imp['penempatan']; ?>)
					</dd>
   				<dt>keperluan</dt>
     				<dd>
	     				<?php 
						$keperluan = $imp['keperluan'];
						if($keperluan == 1){
							echo "<b style='color : #39B3D7'>Cuti Tahunan</b>";
						}elseif ($keperluan == 2) {
							echo "<b style='color : #39B3D7'>Hutang Cuti</b>";
						}elseif ($keperluan == 3) {
							echo "<b style='color : #39B3D7'>Izin</b>";
						}elseif ($keperluan == 4) {
							echo "<b style='color : #39B3D7'>Sakit</b>";
						}elseif($keperluan == 5) {
							echo "<b style='color : #39B3D7'>Tugas Luar Kota</b>";
						} 	?> 
     				</dd>
    			<dt>Time Period</dt>
      				<dd> 
      					<?php echo $imp['hari']; ?> Day <?php echo $imp['jam']; ?> Hour <br>
      				</dd>
				<dt>Start Date</dt>
		  			<dd>
					  	<b><?php echo date("d-m-Y", strtotime($imp['tgl_awal'])); ?></b> s/d
						<b><?php echo date("d-m-Y", strtotime($imp['tgl_akhir']));?></b>
		  			</dd>
				<dt>Status </dt>
					<dd>
						<?php if($imp['status'] == '1'){ ?>
							<span class="label label-warning" style="font-size: 11px;">Received</span>
						<?php }elseif($imp['status'] == '2'){ ?>
							<span class="label label-default" style="font-size: 11px;">Not Received</span>
						<?php }elseif ($imp['status'] == '3') { ?>
							<span class="label label-primary" style="font-size: 11px;">Processing</span>
						<?php }elseif ($imp['status'] == '4') { ?>
							<span class="label label-success" style="font-size: 11px;">Approved</span>
						<?php }elseif($imp['status'] == '5') { ?>
							<span class="label label-danger" style="font-size: 11px;">Not Approved</span>
						<?php }else{
							echo "Waiting";
						} ?>
					</dd>
				<dt>Notes </dt>
					<dd>
						<?= !empty($imp['notes']) ? $imp['notes'] : '-'; ?>
					</dd> 
				<dt>Keterangan </dt>
					<dd>
						<?php echo $imp['keterangan'];?>	
					</dd>     
				<dt>Files</dt>
					<dd>
						<?php 
							$sql = "SELECT file_name, IF(up.uploader != 0, lg.nickname, '') as nickname, date_created FROM tbl_upload_hrd up LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
									WHERE type = 1 AND type_id = ".$imp['id']."";
							$files =  $this->db->query($sql)->result_array();
						?>
	      				<?php if(!empty($files)){ 
							foreach($files as $val) { ?>
								<?php echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?>
								<b style="color: #39B3D7;"><?php echo $val['nickname'] ?></b> : 
				 				<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/'.$val['file_name'] ?>"><?php echo str_replace("_", " ", $val['file_name']) ?></a><br>
						<?php } 										
						}?>
					</dd> 	
    		</dl>
  		</div>
  </div>
  <hr>

  	<h3>Discussion And Log</h3>	
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
				<?php if($log) 
				{
					$no = 1;
						foreach ($log as $val) 
						{ ?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?></td>
								<td><?php echo $val['nickname'] ?></td>
								<td><?php echo ($val['type'] == 1) ? 'Menambahkan file <a href="'.$file_url.'assets/images/upload_hrd/'.$val['discuss'].'"target="_blank" >'.$val['discuss'].'</a>' : $val['discuss'] ?></td>
							</tr>
					<?php $no++; 
					}
				} ?>	
			</tbody>
		</table>
	</div>

		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg">+ Message</button>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload">+ Files</button>
	
</div>


<!-- SEMUA MODAL DETAIL IMP -->

<!-- MODAL ADD DISCUSSION -->
	<div class="modal fade" id="myModalMsg" role="dialog" method="post">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action='<?php echo site_url('c_imp/add_pesan'); ?>'; onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Adding...'; ">
					<div class="modal-header">
						<h4>Add Discussion</h4>
					</div>
						<div class="modal-body">
							<br>
							<div class="form-group">
								<div class="col-lg-12">
									<textarea class="form-control textarea-control" rows="6" name="msg" id="msg" required="true"></textarea>
									<input type="hidden" name="imp_id" value="<?php echo $this->uri->segment(3); ?>"> 
								</div>
							</div>
						</div>
					<div class="modal-footer">
						<a class="btn btn-default pull-left" data-dismiss="modal">Close</a>
						<input type='submit' class='btn btn-info submit_btn' value='Add' name="submit_btn" id="add_btn">
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- MODAL UPLOAD FILE -->
	<div class="modal fade" id="myModalUpload" role="dialog">
    	<div class="modal-dialog">
     		<div class="modal-content">
      			<form class="form-horizontal" method="post" action="<?php echo site_url('c_imp/upload'); ?>" enctype="multipart/form-data" onsubmit="this.save.disabled = true; this.save.text = 'Uploading...'; ">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Upload Files</h4>
        			</div>
        				<div class="modal-body">
        					<div class="form-group row file-row" id = "file-row-1">
        						<div class="col-sm-9">
        							<input type="file" name="userfile[]" class="controls" required="true">
        							<input type="hidden" id="imp_id" name="imp_id" value="<?php echo $imp['id'];?>">
        						</div>
	        					
	        					<div class="col-sm-3">
								&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;	<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
								</div>
        					</div>
        					<div id="add-row">
							</div>
        				</div>
        				<div class="modal-footer">
       						<button type="Submit" class="btn btn-info pull-left" name="save">Upload</button>
          					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        				</div>
      	 		</form> 
      		</div>
    	</div>
	</div>


<script type="text/javascript">
 	$('body').delegate('.btn-add-file', 'click', function()
 		{
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

    $('body').delegate('.btn-remove-file', 'click', function()
    {
      var id = $(this).data('id');
      var length = $('.file-row').length;
      	if(length > 1)
     	 	{
       		 	$('#file-row-'+id).remove();
      	 	}
    });
	
</script>



