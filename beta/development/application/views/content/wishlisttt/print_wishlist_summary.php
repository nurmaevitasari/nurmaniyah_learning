<html><head>
	<title>Summary Wishlist</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
				@page { margin-top: 10px; 
			@bottom {
			content: "Page " counter(page) " of " counter(pages)
    		}
      	}
		body { margin: 0px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}
		
		.items {
			font-size: 10px;
			border-collapse: collapse;
			text-align: center;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}

		.items th {
			border : 0.1px solid #636363;
			background-color: #97b8ed;
			height: 2%;
			padding: 5px 5px;

		}

		.items td {
			border : 0.1px solid #636363;
			padding: 5px 5px;
			
		}

		.table-content {
			width: 100%;
			font-size: 10px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}


		.kop{
			text-align: left;
			font-size:11px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}

		.judul{
			font-size:16px;
			text-align: right;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
			
		}
		.tn{
			text-align: left;
			font-size:9px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
			
		}

		.logo{
			text-align: right;
		}
		.indotara{
			font-size:14px;
			text-align: left;	
			font-family:"Helvetica Neue", "Helvetica", "Arial";
			
		}
		.register{
			font-size:10px;
			text-align: right;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
			margin-right: 5px;
		}
		.page-number:after { content: counter(page); 
		 	font-size:9px;
		 	text-align: left;
		}

	</style></head><body>
	<?php 
		$bln = strtotime($month);
		
		$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$month1 = $bulan[date('n', $bln)]." ".date('Y', $bln); ?>
	<div class="header">
		<table border="0" class="kop" width="700px">
			<tr>
				<th class="indotara">PT.INDOTARA PERSADA<br></th>
				<th rowspan="3" class="logo"><img src="assets/images/Indotara.png" style="width:18%; height:150%;"></th>
			</tr>
			<tr>
				<td class="tn">Graha Kencana Bulding Lt.10 Suit 10F</td>
			</tr>
			<tr>
				<td class="tn">Jl.Raya Perjuangan 88 Kebon Jeruk, Jakarta Barat 11530</td>
			</tr>
			<tr>
				<td class="tn">Phone: 021 583 55 398</td>
				<td class="judul">Point Summary Wishlist periode <?php echo $month1?></td>
			</tr>
		</table>
		<!-- <div class="register">017.00.2017</div> -->
		<hr>
	</div>

	<div align="right" style="font-size: 9px;">
		Print Date : <?php echo date('d-m-Y H:i:s');?>
	</div>

	<?php $user = $_SESSION['myuser']; ?>
	<br>
	<br>
	<br>
    	<table class="items table-content  font">
			<tr>
    			<th>No.</th>
    			<th>Nama</th>
    			<th>Total Point</th>
    			<th>Tariff</th>
    			<th>Total Tariff</th>
    			<th>Supervisi</th>
    			<th>Total Bonus</th>
    			<th>Status Pay</th>
    			<th>Notes</th>
    		</tr>

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
	    					<?php
	            			 if($row['status_paid'] == 1) { ?>
	            				<center><b style="color: green;">Paid</b> <b>By : <?php echo $row['name_paid']; ?></b><br>
	            				<?php echo date('d-m-Y H:i:s', strtotime($row['date_paid'])) ?></center>
	            			<?php }elseif ($user['position_id'] != '1' OR $user['position_id'] != '2') {
	            				echo "Unpaid";
	            			} ?>
	    				</td>
	    				<td><?php echo $row['notes']; ?></td>
	    			</tr>
				<?php $no ++; $arr++; }
			} ?>
    	</table>
    	<br>
    	<br>
    	<h5>Total All Point : Rp. <?php echo number_format($grandtotal['grand_total'], "0", ",", "."); ?></h5>
</body></html>		