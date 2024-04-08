<?php $user = $this->session->userdata('myuser'); 
$file_url = $this->config->item('file_url');
?>
<style type="text/css">
	th{
		text-align: center;
	}

	.label{
		padding: 1px 3px 1px;
	}

	.dropdown-menu {
	    min-width: 0px;
	    width: 100%;
	    font-size: 12px;
	    left: 0px;
	}

	.dropdown-toggle{
		width: 113px;
	}

	.jwaktu{
		line-height: 30px;
	}

</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Table IMP </h2>
        </div>
    </div>
    <hr />

	<a href="<?php echo site_url('c_imp/add'); ?>" type="button" class = "btn btn-danger"><i class="fa fa-plus"></i> New IMP</a><br /><br />				
	
	<div class="table-responsive"  >
		<table id="example" class="table table-hover" style="font-size: 11.5px; ">
			<thead>
				<tr>			
				<?php if(in_array($user['position_id'], array('55', '56', '57', '58', '59', '77', '83', '2', '95', '88', '89', '90', '91', '93')))
				{ ?>
					<th >No.</th>
					<th >Tanggal</th>
					<th >Nama</th>
					<th >Keperluan</th>
					<th style="width: 50px;">Jangka Waktu</th>
					<th >Status</th>
					<th>Notes</th>
					<th >Files</th>
					<th >Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				foreach ($imp as $rows) 
				{ ?>
					<tr id = "tr_<?php echo $rows['id']; ?>" 
					<?php if($user['position_id'] == 83){ ?> ondblClick = "edit_imp(<?php echo $rows['id'] ?>);" <?php } ?> >
							<td><?php echo $rows['id']; ?></td>
							<td><?php echo date("d-m-Y H:i:s", strtotime($rows['date_created'])); ?></td>
							<td><?php 
								if(($pos = strpos($rows['nama'], ".")) !== FALSE)
								{
									echo substr($rows['nama'], $pos+1); 
								}else{
									echo strtok($rows['nama'], " ");
								} ?>
								<br /> 
								(<?php echo $rows['position']; ?> - <?php echo $rows['penempatan']; ?>)
							</td>
							<td><?php 
								$keperluan = $rows['keperluan'];
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
								<br />
								<?php 
								if($rows['keterangan'])
								{
									echo "<b>Ket : </b>".$rows['keterangan'];
								}
								
								 ?>	
							 </td>
							<td>
								<?php echo $rows['hari']; ?> Hari <?php echo $rows['jam']; ?> Jam <br><br>
								<?php echo date("d-m-Y", strtotime($rows['tgl_awal'])); ?> s/d <?php echo date("d-m-Y", strtotime($rows['tgl_akhir']));?>
							</td>
							<td><?php if($rows['status'] == '1'){ ?>
									<span class="label label-warning" style="font-size: 11px;">Received</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif($rows['status'] == '2'){ ?>
									<span class="label label-default" style="font-size: 11px;">Not Received</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif ($rows['status'] == '3') { ?>
									<span class="label label-primary" style="font-size: 11px;">Processing</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif ($rows['status'] == '4') { ?>
									<span class="label label-success" style="font-size: 11px;">Approved</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif($rows['status'] == '5') { ?>
									<span class="label label-danger" style="font-size: 11px;">Not Approved</span>
										<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }else{
									echo "Waiting";
								} ?>
							</td>
							<td>
								<?php if($rows['notes'])
								{
									echo $rows['notes'];	
								}elseif($user['position_id'] == 83 OR $user['position_id'] == 2){ ?>
									<button type="button" class="btn btn-default btn-xs" data-target="#modal_notes" data-toggle = "modal" id="note" data-id = "<?php echo $rows['id'] ?>"><span class="fa fa-plus" ></span> Notes</button>
								<?php } ?>
							</td>
							
							<td>
								<?php $sql = "SELECT id, file_name FROM tbl_upload_hrd WHERE type = 1 AND type_id = ".$rows['id']."";
								$files =  $this->db->query($sql)->result_array(); 
								
								if(!empty($files))
								{ 
									foreach($files as $val) { ?>
										<p style="line-height: 0.32cm;"><a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/'.$val['file_name'] ?>"><?php echo str_replace("_", " ", $val['file_name']) ?></a><br></p>
									<?php }

								}elseif(($rows['head_division'] == $user['position_id']) OR ($user['karyawan_id'] == $rows['id_karyawan']) OR $user['position_id'] == 83 OR $user['position_id'] == 2 OR $user['position_id'] == 1){  ?>
								
									<center><button type="button" class="btn btn-warning btn-xs" data-target="#myModalUpload" data-toggle = "modal" id="upl" data-id = "<?php echo $rows['id'] ?>"><span class="fa fa-plus" ></span> Files</button></center>
								
								<?php } ?>
							</td>
					
									<?php if($rows['head_division'] == $user['position_id'] AND ($rows['status'] != 4 AND $rows['status'] != 5) AND ($user['position_id'] != 1 AND $user['position_id'] != 83 AND $user['position_id'] != 2))
									{ ?>
										<td>
										<div class="btn-group">
  											<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Actions &nbsp;
	    										<span class="caret"></span>
	   	 										<span class="sr-only">Toggle Dropdown</span>
  											</button>
  											<ul class="dropdown-menu" role="menu">
											    <li><a href="#">-Pilih-</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/1/'); ?>">Received</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/2/'); ?>">Not Received</a></li>
  											</ul>
										</div>
										</td>
									<?php }elseif($user['position_id'] == 83 OR $user['position_id'] == 2) { ?>
									<td>
										<div class="btn-group">
  											<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Actions &nbsp;
	    										<span class="caret"></span>
	   	 										<span class="sr-only">Toggle Dropdown</span>
  											</button>
  											<ul class="dropdown-menu" role="menu">
											    <li><a href="#">-Pilih-</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/1/'); ?>">Received</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/2/'); ?>">Not Received</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/3/'); ?>">Processing</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/4/'); ?>">Approved</a></li>
											    <li><a href="<?php echo site_url('C_imp/change_status/'.$rows['id'].'/5/'); ?>">Not Approved</a></li>
  											</ul>
										</div>
									</td>			
									<?php }else{
										echo "<td></td>";
									}
				} ?>
			</tbody> 

					<?php	}else { ?>
					
						<th >No.</th>
						<th >Tanggal</th>
						<th >Nama</th>
						<th >Keperluan</th>
						<th style="width : 50px;">Jangka Waktu</th>
						<th >Status</th>
						<th>Notes</th>
						<th style="width : 100px;">Files</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				foreach ($imp as $rows) 
				{ ?>
					<tr id = "tr_<?php echo $rows['id']; ?>" 
					<?php if($user['position_id'] == 83){ ?> ondblClick = "edit_imp(<?php echo $rows['id'] ?>);" <?php } ?> >
							<td><?php echo $rows['id']; ?></td>
							<td><?php echo date("d-m-Y H:i:s", strtotime($rows['date_created'])); ?></td>
							<td><?php 
								if(($pos = strpos($rows['nama'], ".")) !== FALSE)
								{
									echo substr($rows['nama'], $pos+1); 
								}else{
									echo strtok($rows['nama'], " ");
								} ?>
								<br /> 
								(<?php echo $rows['position']; ?> - <?php echo $rows['penempatan']; ?>)
							</td>
							<td><?php 
								$keperluan = $rows['keperluan'];
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
								<br />
								<?php 
								if($rows['keterangan'])
								{
									echo "<b>Ket : </b>".$rows['keterangan'];
								}
								
								 ?>	
							 </td>
							<td><?php echo $rows['hari']; ?> Hari <?php echo $rows['jam']; ?> Jam <br><br>
								<?php echo date("d-m-Y", strtotime($rows['tgl_awal'])); ?> s/d
								<?php echo date("d-m-Y", strtotime($rows['tgl_akhir']));?>
							</td>
							<td><?php if($rows['status'] == '1'){ ?>
									<span class="label label-warning" style="font-size: 11px;">Received</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif($rows['status'] == '2'){ ?>
									<span class="label label-default" style="font-size: 11px;">Not Received</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif ($rows['status'] == '3') { ?>
									<span class="label label-primary" style="font-size: 11px;">Processing</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif ($rows['status'] == '4') { ?>
									<span class="label label-success" style="font-size: 11px;">Approved</span>
									<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }elseif($rows['status'] == '5') { ?>
									<span class="label label-danger" style="font-size: 11px;">Not Approved</span>
										<p style="font-size: 10px;">Last Update : <br><?php echo date("d-m-Y H:i:s", strtotime($rows['date_modified'])); ?></p>
								<?php }else{
									echo "Waiting";
								} ?>
							</td>
							<td><?php echo $rows['notes']; ?></td>
							<td>
								<?php $sql = "SELECT id, file_name FROM tbl_upload_hrd WHERE type = 1 AND type_id = ".$rows['id']."";
								$files =  $this->db->query($sql)->result_array(); 
								
								if(!empty($files))
								{ 
									foreach($files as $val) { ?>
										<p style="line-height: 0.3cm;"><a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/'.$val['file_name'] ?>"><?php echo str_replace("_", " ", $val['file_name']) ?></a><br></p>
									<?php } 										
								}elseif(($rows['head_division'] == $user['position_id']) OR ($user['karyawan_id'] == $rows['id_karyawan'])){  ?>
								
									<center><button type="button" class="btn btn-warning btn-xs" data-target="#myModalUpload" data-toggle = "modal" id="upl" data-id = "<?php echo $rows['id'] ?>"><span class="fa fa-plus" ></span> Files</button></center>
								
								<?php } ?>
							</td>
							
								<?php 
			
				} ?>
			</tbody> 	
					<?php } ?>
		</table>
	</div>

</div>

<div class="modal fade" id="myModalUpload" role="dialog">
    <div class="modal-dialog">
     	<div class="modal-content">
      		<form class="form-horizontal" method="post" action="<?php echo site_url('c_imp/upload'); ?>" enctype="multipart/form-data">
        		<div class="modal-header">
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
          			<h4 class="modal-title">Upload Files</h4>
        		</div>
        		
        		<div class="modal-body">
        			<div class="form-group row file-row" id = "file-row-1">
        				<div class="col-sm-9">
        					<input type="file" name="userfile[]" class="controls">
        					<input type="hidden" id="imp_id" name="imp_id">
        				</div>
	        			<div class="col-sm-3">
							<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
						</div>
        			</div>
        			<div id="add-row">

					</div>
        		</div>

        		<div class="modal-footer">
       				<button type="Submit" class="btn btn-info pull-left">Submit</button>
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      	 	</form> 
      	</div>
    </div>
</div>

<!-- ############# MODAL NOTES #################################### -->
<div class="modal fade" id="modal_notes" role="dialog">
    	<div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Notes</h3>
	            </div>
	            <div class="modal-body form">
	                <form action = "<?php echo site_url('c_imp/notes'); ?>" id="form" class="form-horizontal" method = "POST">
	                    <textarea rows="3" style="width: 100%;" name="notes" id = "area"></textarea>
	                    <input type="hidden" name="imp_id" id = "imp-id">
	                
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	            </form>
	        </div>
	    </div>
	</div>

<script type="text/javascript">
  //$('select').select2();

    $('#example').DataTable({
    	 "aaSorting": [[0, "desc"]],
    	 autoWidth : false,
    	 'iDisplayLength': 100
    	 
    });

	$(document).on("change", ".select-status", function(){
		var id = $(this).data('id');
		var status = $(this).val();
		//alert(status);
		$.ajax({
			type : 'POST',
          	url : '<?php echo site_url('C_imp/change_status'); ?>',
          	data : {
            	data_id : id,
            	data_status : status,
          	},
          	//dataType : 'json',
          	success : function (data){
            	window.location = '<?php echo site_url('c_imp'); ?>';
          	},
          	error : function (xhr, status, error){
            	console.log(xhr);
          	}
		});
	});

	 $(document).on( "click", '#upl',function(e) {
        var id = $(this).data('id');
        $("#imp_id").val(id);     
    }); 

	 $(document).on( "click", '#note',function(e) {
        var id = $(this).data('id');
        $("#imp-id").val(id);     
    }); 

	function edit_imp(id)
	{
		window.location.href = ('<?php echo site_url('c_imp/edit/') ?>/' +id); 
	}

	$('body').delegate('.btn-add-file', 'click', function(){
			var id = $(this).data('id');

			var length = $('.file-row').length;

			html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
					'<div class="col-sm-9">'+
						'<input class="" type="file" name="userfile[]">'+
					'</div>'+
					'<div class="col-sm-3">'+
						'<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
						'&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+						
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

</script>
