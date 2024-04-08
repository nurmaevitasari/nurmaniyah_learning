<?php $user = $this->session->userdata('myuser'); ?>
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
			<h2>Table Cash Advance Expense</h2>
		</div>
		
		
		<div class="col-md-3" style="margin-top: 22px;">
			<div class="btn-group">
				<input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
				<input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm  disabled ">
			</div>
		</div>	
	</div>

    <hr />

    <div class="table table-responsive">
    	<?php if($_SESSION['myuser']['role_id'] != '15') { ?>
    		<a href="<?php echo site_url('Cash/addcash'); ?>" type="button" class = "btn btn-danger"><i class="fa fa-plus"></i> New Cash Expenses</a><br><br>
    	<?php } ?>
		<table class="table table-hover" id="tablepr" style="font-size: 12px;">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tanggal</th>
					<th>Operator</th>
					<th>Item</th>
					<th>Umur Cash</th>
					<th>Deadline</th>
					<th>Status</th>
					<th style="width: 100px;">Approval</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				
				foreach ($tablecash as $row) { 
					$appr = $cash->getApproval($row['id']);
					$co = count($appr);	
					if(!empty($co)) {
						$arr = $appr['0'];
					}
					if($row['nextto'] == 101 ) { ?>
							<tr class = "hidethis" data-user = "101" id = "#row_<?php echo $row['id']; ?>">
						<?php }elseif($row['nextto'] != 101){ ?>
							<tr class = "showthis" id = "#row_<?php echo $row['id']; ?>">
						<?php  } ?>

						<td><?php echo $row['id']; ?></td>
						<td><?php echo date('d/m/Y H:i:s', strtotime($row['date_created'])); ?></td>
						<td><?php echo $row['nickname']; ?><br />
							(<?php echo $row['position']; ?>)
						</td>
						<td><?php $items = $cash->loadItems($row['id']); 
							foreach ($items as $val) {
								// print_r($val);
							echo "<li>".$val['deskripsi']."<br>";
							} ?>
						</td>

						<?php if($row['nextto'] != '101') {?>
							<td class="time-elapsed"></td>
						<input type="hidden" class="date_start_time" value="<?php echo $row['date_created']; ?>">
							
						<?php	}elseif ($row['nextto'] == '101') { 
							$start = date('Y/m/d H:i:s', strtotime($row['date_created']));
							$closed = date('Y/m/d H:i:s', strtotime($row['date_closed']));
							$fin = datediff($closed, $start); ?>
							
							<td><?php echo $fin['days_total']."d ".$fin['hours']."h ".$fin['minutes']."m "; ?></td>
						<?php } ?>
						
						<td><?php echo date('d/m/Y', strtotime($row['date_deadline'])); ?></td>
						<td> <?php 
					        $pos_sales = substr($detail['position'], -3);
					        if($detail['status'] == 0) {

					          if(empty($detail['level_approval']) AND $detail['cabang'] != '' AND $detail['cabang'] != 'Cikupa' AND !in_array($detail['position_id'], array('55','56', '57', '58', '95'))) {
					            echo "<span style='color:#f76935;'>Waiting for Kacab ".$detail['cabang']." Approval</span>";
					          }elseif(empty($detail['level_approval']) AND $detail['cabang'] == 'Cikupa' AND $detail['position_id'] != '58') {
					            echo "<span style='color:#f76935;'>Waiting for Warehouse Manager Approval</span>";
					          }elseif(((empty($detail['level_approval']) AND (in_array($detail['position_id'], array('65','66','67','68','71','72')) AND $detail['cabang'] == '')) OR ($detail['divisi'] AND ($detail['level_approval'] != 'Kadiv' AND $detail['level_approval'] != 'Dir'))) AND !in_array($detail['position_id'], array('88','89','90','91','93'))) {
					            echo "<span style='color:#b70000;'>Waiting for Kadiv Approval</span>";
					          }elseif((empty($detail['level_approval']) AND ($detail['cabang'] == '' OR in_array($detail['position_id'], array('55','56', '57', '58', '95')))) OR ($detail['level_approval'] == 'Kacab' AND empty($detail['divisi'])) OR ($detail['level_approval'] == 'Kadiv')) {
					            echo "<span style='color:#428BCA;'>Waiting for Director Approval</span>";
					          }

					        }elseif($detail['status'] == '101') {
					          echo "<span style='color: #428BCA; background-color: #58f404; border-radius:5px;'><b>&nbsp;FINISHED&nbsp;</b></span>";
					        }else{
					          echo "<span style='color: #428BCA'><b>".$detail['ov_name']."</b></span>";
					        }  ?>

					       	
						</td>
					<td> 
							<?php foreach ($appr as $key => $val) {
								if($val['status_approval'] == '1') {
									echo "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
									echo "<b style='color:#0CB754'>Approved </b> By : <b>".$val['nickname']."</b><br>";
								}elseif ($val['status_approval'] == '2') {
									echo "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
									echo "<b style='color:#CD0000'>Not Approved </b> By : <b>".$val['nickname']."</b><br>";
									echo "Ket : ".$val['alasan']."<br>";
							}else{
							
								
									if($val['status_approval'] == '1' OR $val['status_approval'] == '3' OR $val['status_approval'] == '5') { 
										echo "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
										echo "<b style='color:#0CB754'>Approved </b> By : <b>".$val['nickname']."</b><br>";
									}elseif ($val['status_approval'] == '2' OR $val['status_approval'] == '4') {
										echo "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
										echo "<b style='color:#CD0000'>Not Approved </b> By : <b>".$val['nickname']."</b><br>";
										echo "Ket : ".$val['alasan']."<br>";
									}
								 }
							} ?>
						</td>
						
						<td>
							<a href="<?php echo site_url('Cash/details/'.$row['id']); ?>" class="btn btn-sm btn-default" target="_blank">Detail</a>
						</td>
					</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div>
</div>  

<script type="text/javascript">
	var table = $("#tablepr").DataTable({
		"aaSorting": [[0, "desc"]],
		'iDisplayLength': 100
	});

	$("#btn_hide").click(function() {
    	$.fn.dataTable.ext.search.push(
      		function(settings, data, dataIndex) {
        		return $(table.row(dataIndex).node()).attr('data-user') != 101;
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

	function updateClock() {
	    $('.date_start_time').each(function() {
	       var startDateTime = new Date( $(this).attr('value') );
	       console.log(startDateTime);
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

	        $(this).parent().find("td.time-elapsed").html(d + "d " + h + "h " + m + "m ");
	    });   
	} 
	setInterval(updateClock, 1000);

	$("button[name='no']").on('click', function() {
		var id = $(this).data('id');
		$("input[name='pr_id']").val(id);
	});


	
</script>   