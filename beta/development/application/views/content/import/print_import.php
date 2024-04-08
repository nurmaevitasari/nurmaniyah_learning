<html><head>
		<title> Import <?php echo $detail['shipment']; ?></title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
		 <!-- Begin emoji-picker Stylesheets -->
    <link href="../lib/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->
	</head><style type="text/css">
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
			background-color: #bfc0c1;
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

		.details
		{
			width: 70%;
			font-size: 11px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}

		.log td, .log th {
			padding: 5px;
		    text-align: left;
		    border-bottom: 1px solid #ddd;
		    vertical-align: 0px;
		    font-family:"Helvetica Neue", "Helvetica", "Arial";
		}

		.log {
			border-collapse: collapse;
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
		.logitem{
			font-size:10px;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
			
		}
		.tditems{
			text-align: left;
			font-family:"Helvetica Neue", "Helvetica", "Arial";
		}
		 .page-number:after { content: counter(page); 
		 	font-size:9px;
		 	text-align: left;
		 }
	</style><body>
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
				<td class="tn">Jl.Raya Perjuangan 88 Kebon Jeruk, Jakarta Barat 1530</td>
			</tr>
			<tr>
				<td class="tn">Phone: 021 583 55 398</td>
				<td class="judul">Laporan Import</td>
			</tr>
		</table>
		<div class="register"></div>
		<hr>
	</div>
	<div align="right" style="font-size: 9px;">
		Print Date : <?php echo date('d-m-Y H:i:s');?>
	</div>

	<table class="table-content details" border='0'>
		<tr>
		    <td>Shipment ID</td>
		    <td><?php echo $detail['shipment']; ?><br></td>
		</tr>
		<tr>
		    <td>Tanggal</td>
		    <td><?php $d = new DateTime($detail['date_created']);echo date_format($d, 'd-m-Y H:i:s'); ?></td>
		</tr>
		<tr>
		    <td>Shipment VIA</td>
		    <td><?php echo $detail['ship_via']; ?></td>
		</tr>
		<tr>
		    <td valign="top">Departure Date<br></td>
		    <td><?php echo $detail['dept']; ?></td>
		</tr>
		<tr>
		    <td>Arrival Date</td>
		    <td><?php echo $detail['arrival']; ?></td>
		</tr>
		<tr>
		    <td>Receiver</td>
		    <td><?php echo $detail['nickname']; ?></td>
		</tr>
		<tr>
		    <td>Tujuan Kedatangan</td>
		    <td><?php echo $detail['kedatangan']; ?></td>
		</tr>
		<!-- <tr>
		    <td>Umur Shipment</td>
		    <td><?php 
			//$min = date('Y/m/d H:i:s', strtotime($detail['date_created']));

			//$max =  date('Y/m/d H:i:s', strtotime($detail['date_closed']));
			//print_r($max);exit();
			//$total = datediff($max, $min);
		
		//if($detail['status'] != 8){ ?>
		<dd class="time-elapsed">
		<?php //}else{ ?>
		<?php //echo $total['months'].'m '. $total['days']. 'd ' .$total['hours']. 'h ' .$total['minutes']. 'm ' .$total['seconds']. 's '; ?>
		<?php //} ?>
		</td>
		</tr> -->
		<tr>
		    <td>Status Shipment</td>
		    <td><?php

			if($detail['status'] == 1)
			{
				echo '<span class = "label label-pill label-default ">Production</span>';
            }elseif ($detail['status'] == 2) {
				echo '<span class = "label label-pill label-info ">Ship by Sea</span>';
            }elseif ($detail['status'] == 3) {
				echo '<span class= "label label-pill label-purple">Custom Clearance</span>';
            }elseif ($detail['status'] == 4) {
				echo '<span class= "label label-pill label-primary">Customs Check</span>';
            }elseif ($detail['status'] == 5){ 
            	echo '<span class="label label-pill label-default lb-sppb">SPPB</span>';
            }elseif ($detail['status'] == 6) {
            	echo '<span class = "label label-pill label-warning">Del. by Truck</span>';
            }elseif ($detail['status'] == 7) {
            	echo '<span class = "label label-pill label-danger">Checked</span>';
            }elseif ($detail['status'] == 8) {
            	echo '<span class = "label label-pill label-success">Finished</span>';
            }else{
            	echo '<span class = "label label-pill lb-air">Ship by Air</span>';
            	} ?></td>
		</tr>
		<tr>
		    <td>Info Barang</td>
		    <td><?php echo $detail['info']; ?></td>
		</tr>
		
	</table>
		<br>
		<br>
		<br>
		<table class="table-content log">
			<tr style="font-size:10px;">
				<th align="center">No</th>
				<th align="center">Inventory ID</th>
				<th align="center">Item Description</th>
				<th align="center">Shipment Quantity</th>
				<th align="center">Indent & Booking</th>
				<th align="center">Free Quantity</th>
				<th align="center">Arrival Confirmation</th>
				<th align="center">Message</th>
			</tr>
				<?php
			
			if ($row_detail['import_id'] == $detail['id']) 
			{
			if($detail_table)
			{
				$x = 1;
				foreach($detail_table as $key => $row)
				{
						 ?>
					<tr style="font-size:9px;">
						<td><?php echo $x; ?></td>
						<td><?php echo $row['kode']; ?></td>
						<td><?php echo $row['product']; ?></td>
						<td style="text-align: center;"><?php echo $row['ship_qty']; ?><br />
						<?php if($row['received_qty'] != '0'){
							if($row['received_qty'] == $row['ship_qty']){
								echo "<b style = 'color : green;' >Qty Correct</b>";
							}elseif($row['received_qty'] < $row['ship_qty']){
								$less_qty = $row['ship_qty'] - $row['received_qty'];
								echo "<b>Received Qty : ".$row['received_qty']."</b><br />";
								echo "<b style = 'color : red;'>Less Qty : ".$less_qty."</b>";
							}elseif($row['received_qty'] > $row['ship_qty']){
								$surplus_qty = $row['received_qty'] - $row['ship_qty'];
								echo "<b>Received Qty : ".$row['received_qty']."</b><br />";
								echo "<b style = 'color : blue;'>Surplus Qty : ".$surplus_qty."</b>";
							}
						} ?>
						</td>
						<td>
						<?php
						$id_imp_prd = $row['id_imp_product'];
						

						$sql_booking = "SELECT a.booking_qty, a.booked_by, a.so_number, a.customer_id, a.import_product_id, a.import_id, b.nickname, c.perusahaan, b.nickname, d.id as sps_id, d.job_id
						FROM tbl_import_booking as a 
						LEFT JOIN tbl_loginuser as b ON a.booked_by = b.karyawan_id 
						LEFT JOIN tbl_customer as c ON a.customer_id = c.id
						LEFT JOIN tbl_sps as d ON a.sps_id = d.id
                        WHERE a.import_product_id = '$id_imp_prd' ORDER BY a.id ASC";
                    	$booking = $this->db->query($sql_booking)->result_array();

                    	
							foreach($booking as $xx){
								if(empty($xx['so_number']) AND $xx['sps_id'] == 0){
									echo $xx['booking_qty']." unit : ".$xx['nickname']." - ".$xx['perusahaan']."<br /><br />";
								}elseif($xx['sps_id'] == 0){
									echo $xx['booking_qty']." unit : ".$xx['nickname']." - ".$xx['so_number']." - ".$xx['perusahaan']."<br /><br />";
								}elseif($xx['sps_id'] != 0 AND $xx['customer_id'] != 0){
									echo $xx['booking_qty']." unit : ".$xx['nickname']." - Job ID ".$xx['job_id']." - ".$xx['perusahaan']."<br /><br />";
								}elseif($xx['sps_id'] != 0 AND $xx['customer_id'] == 0){
									echo $xx['booking_qty']." unit : ".$xx['nickname']." - Job ID ".$xx['job_id']."<br /><br />";
								}
							}	?>
						</td>
						
						<td align="center"><?php echo $row['free_qty']; ?></td>
						
						<td>
						<?php 
						if($row['status'] == 1 ){ ?>
							<font color="green">RECEIVED</font><br>
							<p style="font-size: 10px;">Confirmed By : <?php echo $detail['nickname']; ?> <br />
							<?php $d = new DateTime($row['date_received']);
							echo date_format($d, 'd-m-Y H:i:s'); ?></p>
							<?php }else{ ?>
							<span class = "label label-pill label-danger ">On Delivery</span>
							<?php } ?>
						</td>
						<td>
							<?php 
							$sql = "SELECT a.id, a.date_created, a.pesan, b.nickname
							FROM tbl_import_pesan as a JOIN tbl_loginuser as b ON a.sender = b.karyawan_id WHERE a.import_product_id = '$id_imp_prd' AND a.import_id = ".$this->uri->segment(3)." ORDER BY a.id ASC ";
							$pesan = $this->db->query($sql)->result_array();

							$sql = "SELECT file_name, a.date_created, b.nickname FROM tbl_upload_import as a 
							LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE import_id = ".$this->uri->segment(3)." AND type = 1 AND import_pd_id = '$id_imp_prd' ORDER BY a.id ASC";
							$query = $this->db->query($sql);
							$itemfile = $query->result_array();

							if ($itemfile) { ?>
								
							<?php } ?>
							<br>
							<?php foreach ($pesan as $psn)
							
							{ ?>
							<div class="<?php 
									if(isset($_SESSION['record_id'])) {
									if($_SESSION['record_id'] == $psn['id']) {
									echo 'hl';
								}
								}	?>"
								>
								<?php echo date('d-m-Y H:i:s', strtotime($psn['date_created'])). '<b style="color:#3992b0;"> '.$psn['nickname']. '</b> : '.$psn['pesan'].'<br>'; ?>
								</div>
							<?php }
		
							if(!empty($pesan)){
							echo '<br />';	
							}
							 ?>
							 
						</td>
				<?php 
				$x++;
				}
			}
			} ?>			
					</tr>
				
		</table>
<br>
<br>
<?php
if(!empty($discuss))
{?>
<h4  class="font kop">Discussion</h4>
	<div class="table-content log">
		<table class="col-sm-12 table" style="font-size: 12px;">
			<thead>
				<tr style="font-size:10px;">
					
					<th style="width: 20px; font-size:10px;" align="center">No.</th>
					<th style="width: 150px;" align="center">Tanggal</th>
					<th align="center">User</th>
					<th align="center">Discussion</th>

				</tr>
			</thead>

			<tbody>
			<?php $no = 1;
			$co = count($discuss)+1;
			foreach($discuss as $row) { ?>
				<tr style="font-size:9px;">
					<td><center><?php echo $no; ?></center></td>
					<td><center><?php echo date('d/m/Y H:i:s', strtotime($row['date_created'])); ?></td>
					<td style="color : #39B3D7;"><b><center><?php echo $row['nickname']; ?></b>	</td>
					<td data-emojiable="true"><?php echo $row['type'] == 1 ? 'Menambahkan file '.$row['discuss'] : $row['discuss']; ?></td>
				</tr>
			<?php $no++; } ?>		
			</tbody>	
		</table>
<?php } ?>

	</body></html>

