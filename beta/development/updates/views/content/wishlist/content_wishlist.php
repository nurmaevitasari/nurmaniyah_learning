<style type="text/css">
.center {
	position: center;
}

.btn-finish {
	background-color : #d9d9d9;
	border : 1px solid #d9d9d9;
}

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-9">
			<h2>Wishlist</h2>
		</div>

		<div class="col-md-3" style="margin-top: 22px;">
			<div class="btn-group">
				<input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
				<input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm  disabled ">
			</div>
		</div>
	</div>
	<hr />
	<a href="<?php echo site_url('C_wishlist/add_wishlist'); ?>" class="btn btn-danger"><i class="fa fa-plus"></i> New Wishlist</a>
	<?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '14'))) { ?>
		<a href="<?php echo site_url('C_wishlist/point_tariff'); ?>" class="btn btn-info"> Tariff Point Wishlist</a>
		<a href="<?php echo site_url('C_wishlist/point_summary'); ?>" class="btn btn-success"> Point Summary Wishlist</a>
	<?php	} ?>
	
	<br><br>
	<div class="table-responsive">
		<table class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Name</th>
					<th>Wish</th>
					<th>Receiver</th>
					<?php if(in_array($_SESSION['myuser']['position_id'], array('1','2','14'))) {
						echo "<th>Priority</th>";
					} ?>
					<th>Approval</th>
					<th>Progress (%)</th>
					<th>Status</th>
					<th>Details</th>
				</tr>
			</thead>
		<tbody> 
			<?php if($wishlist) {
				foreach ($wishlist as $wish) { 
					if ($wish['status'] == 2 OR $wish['status'] == '4') { ?>
						<tr class = "hidethis" data-user = "2">
					<?php	}elseif ($wish['status'] != 2) { ?>
						<tr class = "showthis">
					<?php	} ?>
					
						<td><?php echo $wish['id']; ?></td>
						<td><?php echo date('d/m/Y H:i:s', strtotime($wish['date_created'])); ?></td>
						<td><?php echo $wish['user']; ?></td>
						<td><?php echo $wish['title']; ?></td>
						<td><?php echo $wish['wish_name']; ?></td>
						<?php if(in_array($_SESSION['myuser']['position_id'], array('1','2','14'))) { ?>
						<td id = "priority<?php echo $wish['id']?>" 
							<?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '14')) AND $wish['status'] != '2') { ?>
								ondblclick="edit('<?php echo $wish['id']?>', '<?php echo $wish['priority']?>' )"
							<?php } ?> >
							<?php if($wish['status'] == '2' AND $wish['priority'] == '0') {
								echo "-";
							}else {
								echo $wish['priority'];
							} ?></td>
						<?php } ?>	
						<td><?php 
							if($wish['position_id'] == '14') {
								if($wish['approval'] == 0 AND in_array($_SESSION['myuser']['position_id'], array('1', '2'))) { ?>
									<center><a href="<?php echo site_url('C_wishlist/Approval/1/'.$wish['id'].'/') ?>" type="button" name="yes" class="btn btn-xs btn-success" title="Approve" onclick="return confirm('Anda akan menyetujui Wish ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i></a>&nbsp;&nbsp;
										<button type="button" name="no" class="btn btn-xs btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $wish['id']; ?>"><span class="glyphicon glyphicon-remove"></span></button> </center>
								<?php }elseif($wish['approval'] == '1') { ?>
									<span style="font-size: 10px; ">
										<?php echo date('d/m/Y H:i:s', strtotime($wish['date_appr'])); ?> <br>
										Approved By : <?php echo $wish['name_appr']; ?>
									</span>
								<?php }elseif ($wish['approval'] == '2') { ?>
									<span style="font-size: 10px; ">
										<?php echo date('d/m/Y H:i:s', strtotime($wish['date_appr'])); ?> <br>
										Not Approved By : <?php echo $wish['name_appr']; ?> <br>
										Ket : <?php echo $wish['note_appr']; ?>
									</span>
								<?php }else {
									echo "Waiting for Approval";
									}
							}else {
								echo "-";
							} ?>
						</td>
						<td>
						<?php if($wish['wish_name'] == $_SESSION['myuser']['nickname'] AND in_array($wish['status'], array('0', '1'))) { ?>
							<select class="form-control" name="progress" id="progress" data-id = "<?php echo $wish['id'] ?>" onChange="Progress(this)">
								<option value=" "> - Pilih - </option>
								<option value="10" <?php if($wish['progress'] == '10' ) { echo "selected"; } ?>>10%</option>
								<option value="20" <?php if($wish['progress'] == '20' ) { echo "selected"; } ?>>20%</option>
								<option value="30" <?php if($wish['progress'] == '30' ) { echo "selected"; } ?>>30%</option>
								<option value="40" <?php if($wish['progress'] == '40' ) { echo "selected"; } ?>>40%</option>
								<option value="50" <?php if($wish['progress'] == '50' ) { echo "selected"; } ?>>50%</option>
								<option value="60" <?php if($wish['progress'] == '60' ) { echo "selected"; } ?>>60%</option>
								<option value="70" <?php if($wish['progress'] == '70' ) { echo "selected"; } ?>>70%</option>
								<option value="80" <?php if($wish['progress'] == '80' ) { echo "selected"; } ?>>80%</option>
								<option value="90" <?php if($wish['progress'] == '90' ) { echo "selected"; } ?>>90%</option>
								<option value="99" <?php if($wish['progress'] == '99' ) { echo "selected"; } ?>>99%</option>
							</select>
						<?php }else{
							echo $wish['progress']."%";
							}  ?>
						<td id="status_<?php echo $wish['id']?>">
							<?php 
								if($wish['status'] == '0') {
									echo "Waiting";
								}elseif ($wish['status'] == '1') { ?>
									<label class="label label-primary"> EXECUTE</label><br>
									<?php if($wish['name_status'] != NULL) { ?>
										<span style="font-size: 10px;"><?php echo date('d/m/Y H:i:s', strtotime($wish['dt_created']))." By : ".$wish['name_status']; ?> </span>
									<?php } ?>
								<?php	}elseif ($wish['status'] == '2') { ?>
									<label class=" label label-success"> COMPLETED</label><br>
									<?php if($wish['name_status'] != NULL) { ?>
										<span style="font-size: 10px;" ><?php echo date('d/m/Y H:i:s', strtotime($wish['dt_created']))." By : ".$wish['name_status']; ?> </span>
									<?php } ?>
								<?php }elseif ($wish['status'] == '3') { ?>
									<label class=" label label-warning" style="background-color: black; color: white;"> PAUSED</label><br>
									<?php if($wish['name_status'] != NULL) { ?>
										<span style="font-size: 10px;" ><?php echo date('d/m/Y H:i:s', strtotime($wish['dt_created']))." By : ".$wish['name_status']; ?> </span>
									<?php } ?>
								<?php }elseif ($wish['status'] == '4') { ?>
									<label class=" label label-danger"> CANCELED</label><br>
									<?php if($wish['name_status'] != NULL) { ?>
										<span style="font-size: 10px;" ><?php echo date('d/m/Y H:i:s', strtotime($wish['dt_created']))." By : ".$wish['name_status']; ?> </span>
									<?php }
								} ?>
							</td>
						<td><a href="<?php echo site_url('C_wishlist/detail/'.$wish['id']); ?>" target="_blank" class = "btn btn-default">Detail</a></td>
					</tr>
				<?php }
			} ?>
			
		</tbody>
	</table>
	</div>
<div>

<div class="modal fade" id="modal_notes" role="dialog">
    	<div class="modal-dialog">
	        <div class="modal-content">
	        <form action = "<?php echo site_url('C_wishlist/Approval/2/0'); ?>" id="form" class="form-horizontal" method = "POST">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Alasan</h3>
	            </div>
	            <div class="modal-body form">
	                
	                    <textarea rows="4" style="width: 100%;" name="notes" required="true" id="notapprove"></textarea>
	                    <input type="hidden" name="w_id" >   
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	            </form>
	        </div>
	    </div>
	</div>

<script type="text/javascript">
	var table = $("table").DataTable({
		"aaSorting": [[0, "desc"]],
		'iDisplayLength': 100
	});

	$("#btn_hide").click(function() {
    	$.fn.dataTable.ext.search.push(
      		function(settings, data, dataIndex) {
        		return $(table.row(dataIndex).node()).attr('data-user') != 2;
      		}
    	);
	    
	    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
	    $("#btn_show").attr('class', 'btn btn-primary btn-sm');  
	    table.draw(); 
	});

	$("#btn_show").click(function(){
		$.fn.dataTable.ext.search.pop();
	    
	    $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
	    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
	    table.draw();
	});

	$("button[name='no']").on('click', function() {
		var id = $(this).data('id');
		$("input[name='w_id']").val(id);
	});

	function Progress(e)  { 
		//alert();
		var id = $(e).data('id');
		var progress = $(e).val();
		
		//alert(id);
		$.ajax({
          type : 'POST',
          url : '<?php echo site_url('C_wishlist/UpProgress'); ?>',
          data : {
            w_id : id,
            progress : progress,
          },
          dataType : 'json',
          success : function (data){
            $(progress).attr('selected');
            if(progress == 100) { 
            	$("#status_" + id).html('<label class=" label label-success"> COMPLETED</label><br>' +
											'<span style="font-size: 10px;" >' + data.date_created +' By : ' + 
											data.user + '</span>');
            }else if (progress < 100 && progress >= 10) { 
            	$("#status_" + id).html('<label class=" label label-primary"> EXECUTE</label><br>' +
											'<span style="font-size: 10px;" >' + data.date_created +' By : ' + 
											data.user + '</span>');
            }
          },
          error : function (xhr, status, error){
            console.log(xhr);
          },
      });
		
	}

	function edit(id, pri)
	{ 
       	html = '<div class="col-md-3">'+
                '<form method = "post" enctype="multipart/form-data" action="<?php echo site_url('c_wishlist/UpPriority')?>">'+
                    '<div class="input-group">'+
					 '<input type="hidden" name="id" value="'+id+'">'+
                        '<input id = "priority'+id+'" type="text" name="priority" style="width : 100px; height: 28px;" class="form-control priority" value="'+pri+'">'+
                        '<span class="input-group-btn">'+
                            '<button class="btn btn-warning fa fa-save" type="submit" title="Edit"></button>'+
                        '</span>' +    
                    '</div>' +
                    '</form>'+
                '</div>';
           
        document.getElementById('priority'+id).innerHTML = html;

        $("#priority"+id).keypress(function (e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		       	alert("Number Only !");
		        return false;
	    	}
   		});	
    }
</script>
