<style type="text/css">
	.label-purple{
		background: purple;
	}
	#sppb {
		background : #993300;
	}
	.lb-air{
		background : #DB8874;
	}

	.btn-finish{
    	background-color : #d9d9d9;
    	border : 1px solid #d9d9d9;
   	}
</style>
	<div id="page-inner">
	    <div class="row">
	        <div class="col-md-9">
				<h2>Import </h2>
	        </div>
	        <div class="col-md-3">
	        <div class="btn-group" style="margin-top: 22px;">
			     <input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
			     <input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm disabled ">
			</div>
			</div>
	    </div>
		<hr />
				<div class="table-responsive">
				<table class="table table-hover" style="font-size: 12px;" id = "datatbl">
				<thead>
					<tr>
						<th>No</th>
						<th>Shipment ID</th>
						<th>Date Created</th>
						<th>Shipment Via</th>
						<th>Departure & Arrival</th>
						<th>Destination</th>
						<th>Shipment Age</th>
						<th>Item Info</th>
						<th>Notes</th>
						<th>Status</th>
						<th style="width : 50px;">Detail</th>
					</tr>
					</thead>
					<tbody>
					<?php if($c_import){
						$no = 1;
						foreach ($c_import as $row) { 
							if($row['status'] == 8){ ?>
								<tr class = "hidethis" data-user = "8">
							<?php }elseif ($row['status'] != 8){?>
								<tr class = "showthis">
							<?php } ?>	
							<td><?php echo $no; ?></td>
							<td><?php echo $row['shipment']; ?></td>
							<td><?php $date = new DateTime($row['date_created']); echo date_format($date, 'd-m-Y H:i:s'); ?></td>
							<td><?php echo $row['ship_via']; ?><br>
								To : <?php echo $row['nickname']; ?>
							</td>
							<td>Dept : <?php $d = new DateTime($row['dept']); echo date_format($d, 'd-m-Y'); ?><br>
								Arr  : <?php $a = new DateTime($row['arrival']); echo date_format($a, 'd-m-Y'); ?>
							</td>
							<td><?php echo $row['kedatangan']; ?></td>
						
						<?php 
  $id_import = $row['id'];
  $info = $row['info'];
  $ket = $row['notes'];
  $a = "SELECT date_created FROM tbl_import WHERE id = '$id_import'";
  $b = $this->db->query($a);
  $c = $b->row_array();
  $coba = implode('', $c);
  $min = date('Y/m/d H:i:s', strtotime($coba));

  $a = "SELECT date_closed FROM tbl_import WHERE id = '$id_import'";
  $b = $this->db->query($a);
  $c = $b->row_array();
  $coba2 = implode('', $c);
  $max = date('Y/m/d H:i:s', strtotime($coba2));

  $total = datediff($max, $min);

  //$date = datediff($coba, date('Y/m/d H:i:s'));
     
  $sql = "SELECT status FROM tbl_import WHERE id = $id_import";
  $que = $this->db->query($sql);
  $row = $que->row_array();
  $implode = implode(" ", $row);

  if ($implode != 8) { ?>
    <td class="time-elapsed"></td><input type="hidden" class="date_start_time" value="<?php echo $min; ?>"></input>
<?php  } else { ?>
    <td><?php echo $total['days']; ?>d <?php echo $total['hours']; ?>h <?php echo $total['minutes']; ?>m <?php echo $total['seconds']; ?>s</td>
<?php } ?>
							<td><?php echo $info; ?></td>
							<td id = "td_notes_<?php echo $id_import; ?>">
							<?php 
							if($_SESSION['myuser']['role_id'] != '15') {
							if(!empty($ket)) {
								echo $ket;
							}else { ?>
								<button class="btn btn-primary btn-notes btn-xs" data-id = "<?php echo $id_import; ?>"><span class="fa fa-plus"></span></button>
							<?php } 
							} ?>
								 </td>
							<td>
								<?php if($implode == 1){ ?>
									<span class= "label label-default">Production</span>
									<?php }elseif ($implode == 2) {
										echo '<span class= "label label-info">Ship by Sea</span>';
									}elseif ($implode == 3) {
										echo '<span class= "label label-purple">Custom Clearance</span>';
									}elseif ($implode == 4){
										echo '<span class= "label label-primary">Customs Check</span>';
									}elseif($implode == 5){
										echo '<span class="label label-default " id = "sppb"> SPPB</span>';
									}elseif($implode == 6){
										echo '<span class = "label label-warning">Del. by Truck</span>';
									}elseif ($implode == 7) {
										echo '<span class = "label label-danger">Checked</span>';
									}elseif ($implode == 8 ){
										echo '<span class = "label label-success">Finished</span>';
									}else{
										echo '<span class = "label label-default lb-air">Ship by Air</span>';
									} ?>
							</td>
							<td>
							<?php if($_SESSION['myuser']['position_id'] == '1' OR $_SESSION['myuser']['position_id'] == '2' OR $_SESSION['myuser']['position_id'] == '4' ){ ?>
								<a href = "<?php echo site_url('C_new_import/edit/'.$id_import); ?>" class = "btn btn-info btn-sm "><i class = "fa fa-edit"></i></a>
								<a href="<?php echo site_url('c_import/details/'.$id_import); ?>" class="btn btn-default btn-sm"><i class = "fa fa-list"></i></a>
							<?php }else{ ?>
							<a href="<?php echo site_url('c_import/details/'.$id_import); ?>" class="btn btn-default btn-sm">Details</a></td>
							<?php 
						}
							$no++; 
							}} ?>
						</tr>
					</tbody>
				</table>

				</div>
				</div>

				<!-- ############# MODAL NOTES #################################### -->
<div class="modal fade" id="mymodalNotes" role="dialog">
    	<div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Notes</h3>
	            </div>
	            <div class="modal-body form">
	                <form action = "#" id="form_notes" class="form-horizontal" method = "POST">
	                    <textarea rows="4" name="notes" class="form-control tx-notes"></textarea>
	                    <input type="hidden" name="import_id">
	                
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary notes-save">Submit</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	            </form>
	        </div>
	    </div>
	</div>

<script type="text/javascript">
$(document).ready(function(){

var table = $("#datatbl").DataTable({
  	"aaSorting": [[0, "desc"]],
  	'iDisplayLength': 100
  });

  	$("#btn_hide").click(function() {
    	$.fn.dataTable.ext.search.push(
     		function(settings, data, dataIndex) {
      		//alert();
        	return $(table.row(dataIndex).node()).attr('data-user') != 8;
      		}
    	);
    	$("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
    	$("#btn_show").attr('class', 'btn btn-primary btn-sm');  
  		table.draw();
	});

	$("#btn_show").click(function(){
  		$.fn.dataTable.ext.search.pop();
     	table.draw();
     	$("#btn_hide").attr('class', 'btn btn-primary btn-sm');
    	$("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
 	});
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

        $(this).parent().find("td.time-elapsed").html(d + "d " + h + "h " + m + "m " + s + "s ");
    });
} 

setInterval(updateClock, 1000); 

$(".btn-notes").on("click", function() {
	$("#form_notes")[0].reset();
	$("#mymodalNotes").modal('show');
	var import_id = $(this).data('id');

	$("input[name='import_id']").val(import_id);
});

 $("#form_notes").submit(function() {

 	var notes = $(".tx-notes").val();
  	var id = $("input[name='import_id").val();

  $.ajax({
    type : 'POST',
    url : '<?php echo site_url('C_import/AddNotes/')?>',
    data : {
	    id : id,
	    notes : notes
    },
    dataType : 'json',
    success : function(data){
	    $('#mymodalNotes').modal('hide');
	    $('#td_notes_'+id).html(data.notes);

    },
    error: function (jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
    },  
  }); 
	return false;
 });
</script>