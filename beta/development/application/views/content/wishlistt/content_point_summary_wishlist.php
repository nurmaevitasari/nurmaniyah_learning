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

    <div>
    	<form action ="<?php echo site_url('C_wishlist/pay/'); ?>" method = "post">
		    <div class="col-sm-12">
		    	<table class="table table-responsive table-hover">
		    		<thead>
		    			<tr>
			    			<th>No.</th>
			    			<th>Nama</th>
			    			<th>Total Point</th>
			    			<th>Tariff</th>
			    			<th>Total Bonus</th>
			    			<th>
			    			<?php if($user['position_id'] == '1' OR $user['position_id'] == 2 OR $user['position_id'] == '14'	) { ?>
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
		    					<tr>
				    				<td><?php echo $no; ?>
				    				<input type="text" value="<?php echo $row['wish_id'] ?>"></input>
				    				<input type="text" value="<?php echo date('Y-m'); ?>"></input>
				    				</td>
				    				<td><?php echo $row['nickname'] ?></td>
				    				<td><?php echo $row['total_point'] ?></td>
				    				<td><?php echo $row['tariff'] ?></td>
				    				<td><?php echo $row['total_bonus'] ?></td>
				    				<td>
				    					<?php //print_r($row['paid_status']);
				            			 if($row['status_paid'] == 1) { ?>
				            				<center>Paid By : <?php echo $row['user_paid']; ?><br>
				            				[<?php echo date('d-m-Y H:i:s', strtotime($row['paid_date'])) ?>]</center>
				            			<?php }elseif ($user['position_id'] == '1' OR $user['position_id'] == '2' OR $user['position_id'] == '14') { ?>
				            				<input type="checkbox" name="chk[]" class ="chx" value="<?php echo $arr; ?>">&nbsp; Pay
				            			<?php }elseif ($user['position_id'] != '1' OR $user['position_id'] != '2') {
				            				echo "Unpaid";
				            			} ?>
				    				</td>
				    				<td></td>
				    			</tr>
		    				<?php $no ++; $arr++; }
		    			} ?>
		    			
		    		</tbody>
		    	</table>
		    	<button class="btn btn-primary pull-right" type="submit">Pay</button>
		    </div>
	    </form>
    </div>
</div>   

<script type="text/javascript">
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
</script> 