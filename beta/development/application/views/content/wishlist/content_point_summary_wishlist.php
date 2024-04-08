<?php $user = $_SESSION['myuser']; ?>
<div id="page-inner">
  	<div class="row">
    	 <div class="col-sm-12">
            <a href="<?php echo site_url('C_wishlist'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    	<div class="col-md-12">
     		<h2>Point Summary Wishlist</h2>
    	</div>
  	</div>
    <hr />

    <div >
		<form style="display: inline;" class="navbar-form search-month" role="search" method = "get" action="<?php echo site_url('C_wishlist/point_summary'); ?>">
			
				<label class="" style="margin-top: 5px; text-align: right; background-color: white;">Search by month</label>
				<span class="print">
					<?php 
					$bln = strtotime($month);
					
					$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
					$month1 = $bulan[date('n', $bln)].", ".date('Y', $bln); ?>
					<input type="text" name="month" class="form-control month" id = "bulan" value="<?php echo $month1; ?>">
					<input type="hidden" name="month2" class="form-control month" id = "bulan2" value="<?php echo $month; ?>">

				</span>
		
		</form>	

          <a href="<?php echo site_url('C_wishlist/cetak/'.$month); ?>" class="btn btn-default" style="margin-right : 50px; float : right;" > <span class="glyphicon glyphicon-print"></span> PRINT </a>
	</div>
	
	<div class="col-sm-12">
	<br>
		<b>** Double click on table row to see detail point **</b>
	</div>
	
	
    <div>
    	<form action ="<?php echo site_url('C_wishlist/pay/'); ?>" method = "post">
		    <div class="col-sm-12"><br />
		    	<table class="table table-responsive table-hover">
		    		<thead>
		    			<tr>
			    			<th>No.</th>
			    			<th>Nama</th>
			    			<th>Total Point</th>
			    			<th>Tariff</th>
			    			<th>Total Tariff</th>
			    			<th>Supervisi</th>
			    			<th>Total Bonus</th>
			    			<th>
			    			<?php if($user['position_id'] == '1' OR $user['position_id'] == 2 OR $user['position_id'] == '14') { ?>
		            			<input type="checkbox" class="chx" name="pay_all" id="pay_all">&nbsp; Pay All
		            		<?php }else{ ?>
		            			Pay All
		            		<?php	} ?>
		            		</th>
			    			<th>Notes</th>
			    		</tr>
		    		</thead>
		    		<tbody>
		    			<?php if($getSum) {
		    				$arr = 0;
		    				$no = 1;
		    				foreach ($getSum as $key => $row) { ?>
		    					<tr class="dtl">
				    				<td><?php echo $no; ?>
				    					<input type="hidden" value="<?php echo $month; ?>" name="month">
				    				</td>
				    				<td class="nickname"><?php echo $row['nickname'] ?>
				    					<input type="hidden" class="kar" value="<?php echo $row['kar_id'] ?>">
				    				</td>
				    				<td><?php echo $row['total_point'] ?></td>
				    				<td><?php echo number_format($row['tariff'], "0", ",", "."); ?></td>
				    				<td><?php echo number_format($row['total_tariff'], "0", ",", "."); ?></td>
				    				<td><?php echo number_format($row['total_supervisi'], "0", ",", "."); ?></td>
				    				<td><?php echo number_format($row['total_bonus'], "0", ",", "."); ?></td>
				    				<td>
				    					<?php //print_r($row['paid_status']);
				            			 if($row['status_paid'] == 1) { ?>
				            				<center style="font-size: 12px;"><b style="color: green;">Paid</b> <b>By : <?php echo $row['name_paid']; ?></b><br>
				            				<?php echo date('d-m-Y H:i:s', strtotime($row['date_paid'])) ?></center>
				            			<?php }elseif ($user['position_id'] == '1' OR $user['position_id'] == '2' OR $user['position_id'] == '14') { ?>
				            				<input type="checkbox" name="chk[]" class ="chx" value="<?php echo $row['kar_id']; ?>">&nbsp; Pay
				            			<?php }elseif ($user['position_id'] != '1' OR $user['position_id'] != '2') {
				            				echo "Unpaid";
				            			} ?>
				    				</td>
				    				<td><?php echo !empty($row['notes']) ? $row['notes'] : '<button type="button" class="btn btn-info btn-xs mdl-notes" data-toggle="modal" data-target="#modalNotes" > <b>+</b></button>'  ?>
				    					</td>
				    			</tr>
		    				<?php $no ++; $arr++; }
		    			} ?>
		    		</tbody>
		    	</table>
		    	<h5>TOTAL : Rp. <?php echo number_format($grandtotal['grand_total'], "0", ",", "."); ?></h5>
		    	<?php if($cekpay >= 1) { ?>
		    	<button class="btn btn-primary pull-right" type="submit">Pay</button>
		    	<?php } ?>
		    </div>
	    </form>
    </div>
</div>  

<div class="modal fade" id="modalDetailPoint" role="dialog">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail Point</h3>
            </div>
            <div class="modal-body">
            	<table class="table tbl-responsive tbl-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Nama</th>
							<th>Wishlist ID</th>
							<th>Point</th>
							<th>Tariff</th>
							<th>Total Tariff</th>
							<th>Supervisi</th>
							<th>Total Supervisi</th>
						</tr>
					</thead>
					<tbody id="detailPoint">

					</tbody>
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotes" role="dialog" method="post">
    <div class="modal-dialog">
      	<div class="modal-content">
        	<form id="formnotes" class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/Notes/'); ?>'>
         		<div class="modal-header">
            		<h3>Notes</h3>
          		</div>
     
	          	<div class="modal-body">
	            	<div class="form-group">
	              		<div class="col-md-12">
	                		<textarea class="form-control" rows="3" name="notes" id="nt"></textarea>
	                		<input type="hidden" id="kar-id" value="" name="kar_id">
	                		<input type="hidden" id="month" value="" name="month">

	              		</div>
	           		</div>
	          	</div>
     
          		<div class="modal-footer">
            		<input type='submit' class='btn btn-info pull-left submit_btn' value='Save'>
            		<a class="btn btn-default" data-dismiss="modal">Close</a>
          		</div>
        	</form>
      	</div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#btn-pay").hide();

		buttonchecked();

		$("#modalDetailPoint").on("hidden.bs.modal", function() {
			$("#detailPoint tr").remove();
		});
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

		$('.search-month').submit();
	});

	$("#searchpaid").on('change', function() {

		$('#formstatus').submit();
	});

	$(".dtl").on("dblclick", function() {
		
		var kar = $(this).closest("tr").find(".kar").val();
		var bulan = $("#bulan2").val();
	
		$.ajax({
			url : "<?php echo site_url('C_wishlist/getDetailPoint') ?>",
			type : "POST",
			data : {
				data_kar : kar,
				data_month : bulan,
			}, 
			dataType : "json",
			success : function(data) {
				$("#modalDetailPoint").modal('show');
				var row = '';
				$.each(data, function(i, arr) {
					row +=
					'<tr>' +
						'<td>' + arr.date_created + '</td>' +
						'<td>' + arr.nickname + '</td>' +
						'<td>' + arr.wish_id + '</td>' +
						'<td>' + arr.point + '</td>' +
						'<td>' + arr.tariff + '</td>' +
						'<td>' + arr.total_tariff + '</td>' +
						'<td>' + arr.tariff_supervisi + '</td>' +
						'<td>' + arr.total_supervisi + '</td>' +
					'</tr>';
				});

				$("#detailPoint").append(row);
			},
			error : function (xhr, status, error){
            console.log(xhr);
          }

		});
	});

	$(".mdl-notes").on("click", function() {
		var kar = $(this).closest("tr").find(".kar").val();
		var bln = $("#bulan2").val();
		
		$("#kar-id").val(kar);
		$("#month").val(bln);


	});

</script> 