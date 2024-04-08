<?php $pos = $_SESSION['myuser']['position_id']; ?>
<style type="text/css">
	.lbl-jadwal {
		//height: 0.1px;
	}

	.btn-detail {
		width: 63px;
	}

	.tabs{
		width: 50%;
	}
	.label{
		font-size: 10px;
	}

	.waiting{
		background-color: #ff9f72;
		//color: #000000;
	}
	.checking {
		background-color: #999999;
	}

	.qc {
		background-color: #8D20AE;
	}

	.packing {
		background-color: #eda540;
	}

	.delivering {
		background-color: #3779b2;
	}
	.finished {
		background-color: #5CB85C;
	}

	.cancel, .return {
		background-color: #D9534F;
	}
</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Table Delivery</h2>
        </div>
    </div>              
    <hr />
		  	<div class="table-responsive" style="font-size: 12px;">
		    	<table class="table table-hover" id="kodok">
		      		<thead>
				        <tr>
					        <th style = "width : 35px;">ID</th>
					        <th>No. SO</th>
					        <th>Date</th>
					        <th>Customer</th>
					        <th>Items</th>
					        <th>Transaction Value</th>
					        <th style="width: 45px;">DO Age</th>
					        <th>Sent Date</th>
					        <th>Status</th>
					 	    <th>Action</th>
				        </tr>     
		     		</thead>
		      		
				    <tbody>
				    <?php 
				    $xx = count($do_jdwl);  
				    foreach ($do_jdwl as $index => $row) {  ?>
				    		<tr>
					    		<td><?php $id = $row['id'];  echo $id; ?></td>
					    		<td><?php echo $row['no_so']; ?><br />
					    			<b style="font-size: 11px;"> By : <?php echo $row['sales']; ?> - <?php echo strtoupper($row['divisi']); ?></b>
					    		</td>
					    		<td><?php echo date('d-m-Y H:i:s', strtotime($row['date_open'])); ?></td>
					    		<td><?php echo $row['perusahaan']; ?>
					    			<?php if ( $row['pengiriman'] != '' ) { ?>
									<br>
									<font color="navy"> Sent Method : <?php echo strtoupper($row['pengiriman']); ?></font>	
									<?php } ?>
					    		</td>
					    		<td><?php $load_prd = $do_jdwl[$index]['type_id']; 
						    		foreach ($load_prd as $prd) {
						    			echo "<li>".$prd['product']."<br>";
						    		} ?>
					    		</td>
					    		<td>
									<?php echo "Rp ".number_format($row['transaksi'],'0',',','.'); ?>
								</td>
					    		<input type="hidden" id = "time_jdwl_<?php echo $xx; ?>" class="date_start_time" value="<?php echo $row['date_open']; ?>">
								<input type="hidden" name ="count_do_jdwl" id = "count_do_jdwl" class="count_do_jdwl" value="<?php echo count($do_jdwl); ?>">
					    		<?php 	$start = date('Y/m/d H:i:s', strtotime($row['date_open']));
					    				$closed = date('Y/m/d H:i:s', strtotime($row['date_close']));

					    				$total = datediff($closed, $start);

					    		if($row['date_close'] == '0000-00-00 00:00:00') { //echo "QQQQQ"; ?>
					    			<td id = "elapsed_jdwl_<?php echo $xx; ?>" class="time-elapsed"></td>
					    		<?php	}elseif($row['date_close'] != '0000-00-00 00:00:00') { //echo $row['id']."SSSSSSSS"; ?>
					    			<td><?php echo $total['days']; ?>d <?php echo $total['hours']; ?>h <?php echo $total['minutes']; ?>m</td>
					    		<?php	} ?>

					    		<td id="tgl_<?php echo $id; ?>" 
					    		<?php if(in_array($pos, array('1', '2', '19', '55', '56', '57', '58', '59', '60', '62', '75', '77'))) { ?>
					    			ondblclick="changetgl('<?php echo $id; ?>')"
					    		<?php } ?>	
					    		>
					    		<input type="hidden" name="cat" id="cat_<?php echo $id; ?>" value="<?php echo $row['category']; ?>" >

						    		<?php if($row['date_edit'] != '0000-00-00 00:00:00') { ?>
						    		<span style="color: blue;"><?php echo date('d-m-Y', strtotime($row['tgl_estimasi'])); ?></span><br>	
						    		<span style="font-size: 10px;">Last Updated: <br /><?php echo date('d-m-Y H:i:s', strtotime($row['date_edit'])); ?><br> 
						    		<b>By : <?php echo $row['user_edit']; ?></b></span>
						    		<?php	}elseif ($row['date_edit'] == '0000-00-00 00:00:00') {
						    			echo date('d-m-Y', strtotime($row['tgl_estimasi']));
						    		} ?>
					    		</td>
					    		<td id= "chg_<?php echo $id; ?>" 
					    		<?php if(in_array($pos, array('1', '2', '19', '55', '56', '57', '58', '59', '60', '62', '75', '77'))) { ?>
					    			ondblclick="changestatus('<?php echo $row['id']; ?>')"
					    		<?php } ?>	
					    		>
					    		<?php $csts = strtolower($row['status']); ?>
					    			<b><?php echo $row['user_pending']; ?></b><br/>

					    			<span class="label <?php echo $csts; ?>"><?php echo $row['status']; ?></span><br>
					    			<?php if($csts != 'waiting'){ ?>
					    			<span style="font-size: 10px;">Last Updated: <?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?><br>
					    			<b>By : <?php echo $row['nickname']; ?></b></span>
					    			<?php } ?>
					    		</td>
					    		<td><a href="<?php echo site_url('C_delivery/details/'.$row['id']); ?>" type="button" class="btn btn-default btn-sm btn-detail" title="Detail" target="_blank">Detail</a>
					    		</td>
				    	</tr>

				    	<?php --$xx; } ?>	   
				    </tbody> 
		    	</table>
		    </div>
    	</div> 
    	
    <!-- TAMPILAN MODAL UNTUK CHANGE STATUS  -->
    <div class="modal fade" id="myModalStatus" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_status" role="form" ?>
					<div class="modal-header">
						<h4>Change Status</h4>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="control-label col-sm-3">ID</label>
							<div class="col-sm-8">	
								<input id="ch_do_id" type="text" class="form-control" name="do_id" readonly="true">
							</div>	
						</div>
						
						<div class="form-group row">
							<label class="control-label col-sm-3">Change Status </label>
							&nbsp;&nbsp;&nbsp;
							<select class="form-control col-sm-8" style="width: 62%;" name="chgstatus" id = "chgstatus" >
								<option value="">-Pilih-</option>
								<option value="Checking">Checking</option>
								<option value="QC">QC</option>
								<option value="Packing">Packing</option>
								<option value="Delivering">Delivering</option>
								<option value="Canceled">Canceled</option>
							</select>		
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left'>Submit</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>	
</div>

<!-- TAMPILAN MODAL UNTUK TANGGAL  -->
    <div class="modal fade" id="myModalTgl" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_tgl" role="form" ?>
					<div class="modal-header">
						<h4>Sent Date</h4>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="control-label class col-sm-3">ID</label>
							<div class="col-sm-8">
								<input class="form-control" id="tgl_do_id" type="text" name="do_id" readonly="true">
							</div>
						</div> 
						<div class="form-group row">
							<label class="control-label col-sm-3">Date</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="tgl_kirim" id="tgl_kirim">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-sm-3">Category</label>
							
							<div class="col-md-2 col-sm-3">
								<div class="radio">
									<input type="radio" name="category" value="0" required="true"> Pending
								</div>
							</div>
							<div class="col-md-2 col-sm-3">
								<div class="radio">
									<input type="radio" name="category" value="1" required="true"> Fix
								</div>
							</div>
						</div>

						<div id = "tgl_ket" class="form-group row">
							<label class="control-label col-sm-3">Keterangan</label>
							<div class="col-sm-8 col-md-8">
								<textarea id ="ket" class="form-control text_ket" rows="4" name="tgl_txa" placeholder="Pengiriman ditunda karena..."></textarea>
							</div>
						</div>
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left submit-tgl'>Submit</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>	
</div>

<script type="text/javascript">
  
var table = $('#kodok, #kodok2').DataTable({
	"aaSorting": [[0, "desc"]],
    	 autoWidth : false,
    	 'iDisplayLength': 100
});

 $("#tgl_kirim").datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent : false
  });

//function detail_do(id)
//{
//	window.open("<?php //echo site_url('C_delivery/details') ?>/" + id, "_blank");
//}

$(document).ready(function() {
	$("#tgl_ket").hide();
	 CKEDITOR.instances['ket'].destroy();
});
	 $('input[type="radio"]').on('click', function() {
		 if($(this).attr("value")=="0"){
			$("#tgl_ket").show();
			$(".text_ket").prop('required', true);
		}else if ($(this).attr("value")=="1"){
			$("#tgl_ket").hide();
			$(".text_ket").prop('required', false);
		}
	});


function changestatus(id)
{
	$('#myModalStatus').modal('show');
	document.getElementById('ch_do_id').value = id;
}

$("#form_status").submit(function() {
	
  	var id = $("#ch_do_id").val();
  	var status = $('#chgstatus').val();
  	//alert(status);

   $.ajax({
    type : 'POST',
    url : '<?php echo site_url('C_delivery/changeStatus/'); ?>',
    data : {
    id : id,
    status : status,
    },
    dataType : 'json',
    success : function(data){
    var sts = (data.status).toLowerCase();	
    $('#myModalStatus').modal('hide');
    $('#chg_'+ id).html('<b>' +data.user_pending+ '</b><br />' +
    					'<span class="label ' + sts +'">' + data.status + '</span><br>' +
    					'<span style="font-size: 10px;">Last Updated: ' + data.date_created +'<br>' +
					    '<b>By : ' + data.nickname + '</b></span>' );
    //$("#sts_" + id).addClass(data.status).toLowerCase();
    },
    error: function (xhr, status, error){
      console.log(xhr);
    }
  }); 
	return false; 
 }); 

function changetgl(id)
{
	$('#myModalTgl').modal('show');
	$('#form_tgl')[0].reset();
	document.getElementById('tgl_do_id').value = id;
	
}

$("#form_tgl").submit(function() {
	//var radios = document.getElementsByName('category');
	var id = $("#tgl_do_id").val();
  	var tgl_kirim = $('#tgl_kirim').val();
  	var category = $('input[name="category"]:checked').val();
  	var ket = $('.text_ket').val();
  	var oldcat = $("#cat_" + id).val();
  	//alert(oldcat);
	//for (var i = 0, length = radios.length; i < length; i++) {
	    //if (radios[i].checked) {
	       //var category = radios[i].value;
	       
	        $.ajax({	
			    type : 'POST',
			    url : '<?php echo site_url('C_delivery/delivDate/'); ?>',
			    data : {
			    do_id : id,
			    tgl_kirim : tgl_kirim,
			    tgl_txa : ket,
			    category : category,
			    },
			    dataType : 'json',
			    success : function(data){
			    $('#myModalTgl').modal('hide');
			    $('#tgl_'+ id).html('<span style="color: blue;">' + data.tgl_estimasi + '</span><br>' +
			    					'<span style="font-size: 10px;">Last Updated: ' + data.date_edit +'<br>' +
								    '<b>By : ' + data.nickname + '</b></span>' );
				if(oldcat != data.kategori) {
					window.location=window.location;
				}				    	
			    },
			    error: function (xhr, status, error){
			      console.log(xhr);
			    },
		  	});
	       return false;  
		  	//break;
		  	
	    //}
	//} 
 }); 

	
function updateClock() {

  	var co = document.getElementById( 'count_do' );
  	var co2 = document.getElementById( 'count_do_jdwl' );
  	
	if(co) {
		var co = co.value;
		for (var ii = 1; ii <= co; ii++) {
	    	$("#time_" + ii).each(function(i) {
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
		       	
		       	$('#elapsed_'+ ii).html(d + "d " + h + "h " + m + "m " + s + "s");
	    	}); 
	    }
	}

	if(co2) {
		var co2 = co2.value;
		for (var ii = 1; ii <= co2; ii++) {
	    	$("#time_jdwl_" + ii).each(function(i) {
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
		       	
		       	$('#elapsed_jdwl_'+ ii).html(d + "d " + h + "h " + m + "m " + s + "s");
	   	 	});
	   	}
	}
} 
setInterval(updateClock, 1000);

$('#myTabs').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

</script>
