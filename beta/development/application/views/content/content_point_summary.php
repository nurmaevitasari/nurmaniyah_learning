<style type="text/css">
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

<?php $user = $this->session->userdata('myuser'); ?>

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Point Summary</h2>
			<p>Paid hanya dilakukan oleh bagian kompensasi</p>
		</div>
	</div>
	<hr />

	<div>
		<form class="navbar-form" role="search" method = "get" action="<?php echo site_url('c_point_summary/search'); ?>">
			<div class="form-group row">
				<label class="control-label col-sm-5" style="margin-top: 5px;">Search by month</label>
				<div class="col-sm-2 print">
					<?php 
					$bln = strtotime($month);
					
					$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
					$month = $bulan[date('n', $bln)].", ".date('Y', $bln); ?>
					<input type="text" name="month" class="form-control month" id = "bulan" value="<?php echo $month; ?>">
					<input type="hidden" name="month2" class="form-control month" id = "bulan2" >
				</div>
			</div>
		</form>	
	</div>
	<br />
        
    <div class="table-responsive print">
        <form action ="<?php echo site_url('C_point_summary/pay/'); ?>" method = "post">
        <table class="table table-hover" id = "example" style="font-size: 12px;">
            <thead>
            	<tr>
            		<th>No.</th>
            		<th>Teknisi</th>
            		<th>Total Point</th>
            		<th>Tariff</th>
            		<th>Total Bonus</th>
            		<th>
            		<?php if($user['position_id'] == '1' OR $user['position_id'] == 2) { ?>
            			<input type="checkbox" class="chx" name="pay_all" id="pay_all">&nbsp; Pay All
            		<?php }else{ ?>
            			Pay All
            		<?php	} ?>
            		</th>	
            		<th style="width: 250px;">Notes</th>
            	</tr>
            </thead>

            <tbody>
            	<?php 
            	if($show)
            	{
            		$arr = 0;
            		$no = 1;
            		foreach ($show as $row) 
            		{
			            $tariff = !empty($row['tariff']) ? $row['tariff'] : '0'; ?>
	            		
	            		<tr>
		            		
		            		<td>
		            			<?php echo $no; ?>
		            			<input type="hidden" name="po_id[]" value="<?php echo $row['id']?>">
		            		</td>
		            		<td><?php echo $row['nickname']; ?></td>
		            		<td>
		            			<?php 
		            			//$final_point = $row['point_tambahan'] + $row['total_point'];
		            			//echo $final_point; 
		            			echo $row['total_point']; ?>
		            			<input type="hidden" name="ttl_point[]" value="<?php echo $row['total_point']; ?>">
		            		</td>
		            		<td><?php echo "Rp. ".$tariff." /point"; ?></td>
		            		<td><?php 
		            			$trf = str_replace(".", "", $tariff);
		            			//$bonus = $final_point * $trf;
		            			//echo "Rp. ".number_format($bonus, "0", ",", ".");
		            			echo "Rp. ".number_format($row['ttl_bonus'], "0", ",", "."); ?>
		            			<input type="hidden" name="ttl_bonus[]" value="<?php echo $row['ttl_bonus']; ?>">	
		            		</td>
		            		<td>
		            			<?php //print_r($row['paid_status']);
		            			/* if($row['paid_status'] == 1) { ?>
		            				<center>Paid By : <?php echo $row['user_paid']; ?><br>
		            				[<?php echo date('d-m-Y H:i:s', strtotime($row['paid_date'])) ?>]</center>
		            			<?php }elseif ($user['position_id'] == '1' OR $user['position_id'] == '2') { ?>
		            				<input type="checkbox" name="chk[]" class ="chx" value="<?php echo $arr; ?>">&nbsp; Pay
		            			<?php }elseif ($user['position_id'] != '1' OR $user['position_id'] != '2') { */
		            				echo "Unpaid";
		            			//} ?>
		            		</td>
		            		<td id = "notes_<?php echo $row['id']?>" ondblclick="note(<?php echo $row['id'] ?>)">
		            		<p id = "p_<?php echo $row['id']?>"><?php echo $row['notes']; ?></p>
		            		</td>

            		<?php $no++; $arr++;
            		}
            } ?>
            </tbody>
        </table>
        <br>

        <p><b>Total All Point : </b><b style="color: navy;"><?php echo $all_point['total_point']; ?></b></p>
        <p><b>Total All Bonus : </b><b style="color: navy;"><?php echo "Rp. ".number_format($all_point['total_tariff'], "0", ",", "."); ?></b></p>
        <br>

     <?php

      if($this->uri->segment(2) == "search")
     {
     	$segment = "search";
     	} else {
     		$segment = "def";
     		}?>
       <!--  <a type="button" target="_blank" class="btn btn-default no-print" id = "pdf" href="<?php //echo site_url('C_point_summary/pdf/'.$segment.''); ?>"><i class="glyphicon glyphicon-print"></i>  Print</a> -->
        <button type="button" target="_blank" class="btn btn-default no-print" id = "pdf" ><span class="glyphicon glyphicon-print"></span>  Print</button>
     
        <button type="submit" id = "btn-pay" class="btn btn-primary" >Pay</button>
       </form>
    </div>

    <div class="modal fade" id="modal_notes" role="dialog">
    	<div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Notes</h3>
	            </div>
	            <div class="modal-body form">
	                <form action = "#" id="form" class="form-horizontal" method = "POST">
	                    <textarea rows="3" style="width: 100%;" name="notes" id = "area"></textarea>
	                    <input type="hidden" name="point_id" id = "id_point">
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" id="btnSave" onclick="save_note()" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	        </div>
	    </div>
	</div>

<script type="text/javascript">
	var save_method;

	$('table').DataTable({
		"paging" : false,
		"info" : false,
		"searching" : false,
	});

	$(document).ready(function() {
		$("#btn-pay").hide();

		buttonchecked();
	});

	function buttonchecked()
	{
		$(':checkbox').on('click', function() {
			if(this.checked == true)
			{
				$("#btn-pay").show();
			}else if (this.checked == false){
				$("#btn-pay").hide();
			}
		});
	} 

	$('#bulan').datepicker({
		format: "MM, yyyy",
	    minViewMode: 1,
	    maxViewMode: 3,
	    //language: "id",
	    autoclose: true,
	});

	$("#bulan").on('change', function() {
		var bln = $('#bulan').val().split(",")[0];
		var thn = $('#bulan').val().split(" ")[1];
		var mo = ("0" + (new Date(Date.parse(bln +" 1, " + thn)).getMonth()+1)).slice(-2);
		var chFormat = thn + '-' + mo;
		document.getElementById('bulan2').value = chFormat;

		$('.navbar-form').submit();
	});

	$("#pay_all").on('click', function(e) {
		if(this.checked) {
        // Iterate each checkbox
	        $(':checkbox').each(function() {
	            this.checked = true;                        
	        });
    	}else{
	    	$(':checkbox').each(function() {
	            this.checked = false;                        
	        });
    	}
	});

	function note(id)
	{		
		var ket = $("#p_"+id).html();
		
		if(ket == '')
		{
			save_method = 'add';
		} else {
			save_method = 'update';
		}
		
		$("#modal_notes").modal('show');
		$('#id_point').val(id);
		$('#area').val(ket);
	}

	function save_note() 
	{
		if(save_method == 'add')
		{
			url = "<?php echo site_url('C_point_summary/add_notes/add'); ?>";
		}else {
			url = "<?php echo site_url('C_point_summary/add_notes/edit'); ?>";
		}
		
		$.ajax({
			type : 'POST',
          	url : url,
          	data : $("#form").serialize(),
          	dataType : 'json',
          	success : function (data){
            	$("#modal_notes").modal('hide');
            	 document.getElementById('notes_'+data.point_id).innerHTML = data.notes;
          	},
          	error : function (xhr, status, error){
            	console.log(xhr);
          	}
		});	
	}

	$("#pdf").on('click', function() {
		var bln = window.location.href.split("=")[2];
		var date = new Date();
		var mon = date.getFullYear() +'-'+ ("0" + (date.getMonth() + 1)).slice(-2);
		
		if(!bln){
			var bulan = mon;
		}else{
			var bulan = bln;
		}
		location.href = "<?php echo site_url('C_point_summary/pdf'); ?>" +"/"+ bulan;

	});
</script>

</script>


