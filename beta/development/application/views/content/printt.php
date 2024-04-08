<html><head>
		<title><?php echo "Purchasing ID "; ?></title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
	</head><style type="text/css">
		@page { margin-top: 15px; }
		body { margin: 0px;
			font-family: 'Helvetica';
		 }
		/* .tg  {
			border-collapse:collapse;
			border-spacing:0;
		}
		.tg td {
			font-family:helvetica;
		
			padding:10px 5px;
			border-style:solid;
			border-width:1px;
			overflow:hidden;
			word-break:normal;
		}
		.tg th {
			font-family:Helvetica;
			
			font-weight: normal;
			padding: 10px 5px;
			border-style: solid;
			border-width: 1px;
			overflow: hidden;
			word-break: normal;
		}
		.tg .tg-yw4l {
			vertical-align:top
		} */

		.items {
			font-size: 10px;
			border-collapse: collapse;
			text-align: center;
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
		}

		.details
		{
			width: 70%;
			font-size: 11px;
		}

		.log td, .log th {
			padding: 5px;
		    text-align: left;
		    border-bottom: 1px solid #ddd;
		    vertical-align: 0px;
		}

		.log {
			border-collapse: collapse;
    		width: 100%;
    		font-size: 10px;

		}

		.kop{
			text-align: left;
			font-size:11px;
		}

		.judul{
			font-size:16px;
			text-align: right;
			
		}
		.tn{
			text-align: left;
			font-size:9px;
			
		}

		.logo{
			text-align: right;
		}
		.indotara{
			font-size:14px;
			text-align: left;	
			
		}
		.register{
			font-size:10px;
			text-align: right;
			
			margin-right: 5px;
		}
		.logitem{
			font-size:10px;
			
		}
	</style><body>
	<div class="header">
		<table border="0" class="kop" width="700px">
			<tr>
				<th class="indotara">PT.INDOTARA PERSADA<br></th>
				<th rowspan="4" class="logo"><img src="assets/images/indotara1.png" style="width:27%; height:150%;"></th>
			</tr>
			<tr>
				<td class="tn">Graha Kencana Bulding Lt.10 Suit 10F</td>
			</tr>
			<tr>
				<td class="tn">Jl.Raya Perjuangan 88 Kebon Jeruk, Jakarta Barat 1530</td>
			</tr>
			<tr>
				<td class="tn">Phone: 021 583 55 398</td>
			</tr>
			<tr>
				<td></td>
				<td class="judul">Laporan Purchase Requisition</td>
			</tr>
		</table>
		<div class="register">017.00.2017</div>
	</div>
		<br>
		<hr>
		<br>
	<div align="right" style="font-size: 9px;">
		Print Date : <?php echo date('d-m-Y H:i:s');?>
	</div>

	<table class="table-content details">
		<tr>
		    <td>PR ID</td>
		    <td><?php echo $detail['id']; ?><br></td>
		</tr>
		<tr>
			<td>CRM ID</td>
			<td><?= $detail['modul_link'] == 8 ? '<a href="'.site_url("crm/details/".$detail['link_id']).'" target="_blank">'.$detail['link_id'].'</a>' : '-'; ?></td>   
		</tr>
		<tr>
		    <td>Tanggal</td>
		    <td><?php echo date('d-m-Y H:i:s', strtotime($detail['date_created'])); ?></td>
		</tr>
		<tr>
		    <td>Purchaser</td>
		    <td><?php echo $detail['nickname']; ?></td>
		</tr>
		<tr>
		    <td valign="top">Alasan Pembelian<br></td>
		    <td><?php echo $detail['alasan_pembelian']; ?></td>
		</tr>
		<tr>
		    <td>Deadline</td>
		    <td><?php echo date('d-m-Y', strtotime($detail['date_deadline'])); ?></td>
		</tr>
		<tr>
			<td>Biaya / Piutang</td>
      		<td><?= $detail['biaya_piutang'] == '2' ? 'Piutang' : 'Biaya'; ?></td>
		</tr>
		<tr>
			<td>Potong Omset</td>
      		<td><?= $detail['ptg_omset'] == '1' ? 'Ya' : 'Tidak'; ?></td>
		</tr>
	</table>
		<br>
		<br>
	<h4 class="logitem">ITEMS</h4>
		<center>
			<table class="items table-content font">
		  		<tr style="outline: 1px solid black;">
				    <th>No</th>
				    <th>Vendor</th>
				    <th>Items</th>
				    <th>Qty</th>
				    <th>Qty Approved<br></th>
				    <th>Stock On Hand<br></th>
				    <th>MOU</th>
				    <th>Date Approved</th>
		  		</tr>  
		  			<?php
						$no = 1;
		  					if($items) {
								foreach($items as $row) { ?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td ><?php echo $row['vendor']?></td>
								<td ><?php echo $row['items']?></td>
								<td ><?php echo $row['qty']?></td>
								<td ><?php echo $row['qty_approved']?></td>
								<td ><?php echo $row['stock']?></td>
								<td ><?php echo $row['mou']?></td>
								<td ><?php if($row['date_approved'] != '0000-00-00 00:00:00') {
									echo $row['date_approved'];
									echo "<br>";
									echo "Update by : <b>".$row['nickname'];
								} ?>
									
								</td>
							 </tr>
						<?php }
					}?>
			</table>
		</center>
			<br>
			<br>
	<h4  class="font kop">LOG</h4>
		<table class="table-content log">
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Operator</th>
				<th>Messages</th>
			</tr>
				<?php $no = 1; 
					foreach ($logpr as $key => $lg) { ?>
					<tr >
						<td><?php echo $no++; ?></td>
						<td><?php echo date('d/m/Y H:i:s', strtotime($lg['date_created'])); ?></td>
						<td><?php echo $lg['nickname']; ?>
							<br>(<?php echo $lg['position']; ?>)
						</td>
						<td>
							<?php $pr_log_pesan = $pr->load_pesan($lg['pr_id'], $lg['id']);
								foreach ($pr_log_pesan as $psn) { ?>
									<?php echo date('d/m/Y H:i:s', strtotime($psn['date_created'])); ?> 
									<b style="color: #3992b0;"><?php echo $psn['nickname']; ?> : </b> <?php echo $psn['pesan']."<br>"; 
								} ?>
						</font>
						</td>				
					</tr>
				<?php } ?>
		</table>
	</body></html>