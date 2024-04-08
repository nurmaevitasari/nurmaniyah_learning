<?php $file_url = $this->config->item('file_url'); ?>
<div id="page-inner"> 
	<div class="row">
		<div class="col-md-12">
				<h2>Files QC</h2>	
		</div>
	</div>

	<hr>

	<?php if($_SESSION['myuser']['role_id'] != '15') { ?>
		<button type="submit" name="simpan" class="btn btn-danger" data-toggle="modal" data-target="#myModalUpload" style="margin-bottom:20px">+ Add</button>
	<?php } ?>
	

	<div class="table-responsive">
        <table class="table table-hover" style="font-size: 12px;">
          <thead>
			<tr>
            <th>No</th>
            <th>Tanggal Upload</th>
			<th>Nama File</th>
			<th>Upload By </th>
			<th>Status</th>
			<th>Action</th>
          </tr>
		  </thead>
		<tbody>
		<?php if($qc) {
			$no = 1;
			foreach($qc as $row ) {  ?>
			<tr>
				<td class="cls-id"><?php echo $no; ?>
					<input type="hidden" name="id_upload" value="<?php echo $row['id']; ?>">
				</td>

				<td><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?></td>
				<td><a href="<?php echo $file_url.'assets/images/upload_do/'.$row['file_name']); ?>" target="_blank"><?php echo $row['file_name'] ?></a></td>
				<td><?php echo $row['nickname'] ?></td>
				<td class = "td-status" id="s_<?php echo $row['id'] ?>"><?php echo $row['status'] ?></td>
				<td >
					<?php 
					if($_SESSION['myuser']['role_id'] != '15') {
						if($row['status'] == 'Show') { ?>
							<button id="btn-<?php echo $row['id'] ?>" class="btn btn-action btn-sm btn-warning" name="action" onclick="Change(this)">Hide</button>
						<?php }elseif($row['status'] == 'Hide') { ?>
							<button id="btn-<?php echo $row['id'] ?>" class="btn btn-action btn-sm btn-primary" name="action" onclick="Change(this)">Show</button>
					<?php } 
					} ?>
					
				</td>
			</tr>
		
		<?php	$no++;}
		 } ?>
        </table>
	<!-- modal input -->

<div class="modal fade" id="myModalUpload" role="dialog" method="post">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_upload_qc/Add/');  ?>" enctype="multipart/form-data">
				<div class="modal-header">
					<h4>Upload Files</h4>
				</div>
				<div class="modal-body">
					<div class= "form-group">
					<label class="control-label col-sm-2" >Divisi</label>
					<div class="col-sm-9">
						<select name="divisi" class="form-control">
							<option value="">-Pilih-</option>							
							<option value="dhe">DHE</option>								
							<option value="dee">DEE</option>					
							<option value="dce">DCE</option>
							<option value="dhc">DHC</option>
							<option value="dre">DRE</option>
						</select>
					</div>
				</div>
					<div class="form-group file-row " id="file-row-1">
						<div class="row col-sm-12">
							<label class="control-label col-sm-2" >Files</label>
							<div class="controls col-sm-8">
								<input class="" type="file" name="userfile[]">
							</div>
							<div class="col-sm-2">   
								<button  type="button" class="btn btn-primary btn-add-file" data-id="1">+<tton>
							</div>
						</div>
					</div>
					<div id="add-row">

					</div>
					<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
				</div>
				<div class="modal-footer">
					<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>


</div>
<script>

$("table").DataTable({
	orderCellsTop: true,
    'iDisplayLength': 100  
});
	
	//$(document).ready(function() {
	//UpStatus();
	//});
	
/* 	$(".btn-action").click(function() {	
	var id = $(this).closest('tr').find("input[name='id_upload']").val();
	var status =$(this).val();
	alert(id);
	$.ajax({
		url : "<?php //echo site_url('C_upload_qc/changests'); ?>",
		type: "POST",
		data: {
			id : id,
			status : status,
		},
		success: function(data)
		{
			$("#s_" + id).html(status);
			UpStatus();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			console.log(jqXHR);
		}
	});
});  */

function Change(e)
{
	var id = $(e).closest('tr').find("input[name='id_upload']").val();
	var status =$(e).html();

	$.ajax({
		url : "<?php echo site_url('C_upload_qc/changests'); ?>",
		type: "POST",
		data: {
			id : id,
			status : status,
		},
		success: function(data)
		{
			$("#s_" + id).html(status);
			
			if(status == 'Hide') { 
			$("#btn-" + id).html('Show');
			$("#btn-" + id).addClass('btn-primary');
			$("#btn-" + id).removeClass('btn-warning');
		}else if (status == 'Show' ) {
			$("#btn-" + id).html('Hide');
			$("#btn-" + id).addClass('btn-warning');
			$("#btn-" + id).removeClass('btn-primary');
		}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			console.log(jqXHR);
		}
	});
	
}

$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
      				'<div class="row col-sm-12">'+
					'<label class="control-label col-sm-2" >&nbsp;</label>'+
		        	'<div class="controls col-sm-7">'+
		        		'<input class="" type="file" name="userfile[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+
		          	'</div>'+ 
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