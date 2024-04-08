<html><head>
		<title><?php echo "Cash ID "; ?></title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
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

		.tg  {
			border-collapse:collapse;
			border-spacing:0;
		}
		.tg td{
			font-family:Arial, sans-serif;
			font-size:11px;
			padding:15px 10px;
			border-style:solid;
			border-width:0px;
			overflow:hidden;
			word-break:normal;
			border-top-width:1px;
			border-bottom-width:1px;
		}
		.tg th{
			font-family:Arial, sans-serif;
			font-size:11px;
			font-weight:normal;
			padding:15px 10px;
			border-style:solid;
			border-width:0px;
			overflow:hidden;
			word-break:normal;
			border-top-width:1px;
			border-bottom-width:1px;
		}
		.tg .tg-yw4l{
			vertical-align:top
		}
	</style><body>
	<div class="header">
		<table border="0" class="kop" width="700px">
			<tr>
				<th class="indotara">PT.INDOTARA PERSADA<br></th>
				<th rowspan="3" class="logo"><img src="assets/images/indotara1.png" style="width:18%; height:150%;"></th>
			</tr>
			<tr>
				<td class="tn">Graha Kencana Bulding Lt.10 Suit 10F</td>
			</tr>
			<tr>
				<td class="tn">Jl.Raya Perjuangan 88 Kebon Jeruk, Jakarta Barat 1530</td>
			</tr>
			<tr>
				<td class="tn">Phone: 021 583 55 398</td>
				<td class="judul">Laporan Cash Advance /Expenses</td>
			</tr>
		</table>
		<div class="register">017.00.2017</div>
		<hr>
	</div>
	<div align="right" style="font-size: 9px;">
		Print Date : <?php echo date('d-m-Y H:i:s');?>
	</div>

	<table class="table-content details">
		<tr>
		    <td>Cash ID</td>
		    <td><?php echo $detail['id']; ?><br></td>
		</tr>
		<tr>
		    <td>CRM ID</td>
		    <td><?php echo ($detail['modul_link'] == '8') ? '<a target="_blank" href="'.site_url('crm/details/'.$detail['link_id']).'">'.$detail['link_id'].'</a>' : '-'; ?></td>
		</tr>
		<tr>
		    <td>Category</td>
		    <td><?= ($detail['type'] == 1) ? 'Advance' : 'Expenses'; ?></td>
		</tr>
		<tr>
		    <td>Tanggal</td>
		    <td><?php echo date('d-m-Y H:i:s', strtotime($detail['date_created'])); ?></td>
		</tr>
		<tr>
		    <td>Nama User</td>
		    <td><?php echo $detail['nama']; ?></td>
		</tr>
		<tr>
		    <td>Divisi<br></td>
		    <td><?= !empty($detail['divisi']) ? $detail['divisi'] : '-'; ?></td>
		</tr>
		<tr>
		    <td>Keperluan<br></td>
		    <td><?php echo $detail['alasan_pembelian']; ?></td>
		</tr>
		<tr>
		    <td>Status<br></td>
		    <td><?php $pos_sales = substr($detail['position'], -3);
        		if($detail['status'] == 0) {
          			if($detail['cabang'] == '') {
            			echo "<span style='color:#428BCA;'>Waiting for Director Approval</span>";
         			}elseif($detail['cabang'] != '') {
            			echo "<span style='color:#428BCA;'>Waiting for Kacab Approval</span>";
          			}
        		}elseif($detail['status'] != '0' AND $detail['status'] != '101') {
          			echo "<span style='color:#428BCA;'>".$detail['ov_name']."</span>";
        		}elseif($detail['status'] == '101') {
          			echo "<span style='color: #428BCA; background-color: #58f404; border-radius:5px;'><b>&nbsp;FINISHED&nbsp;</b></span>";
        		}  ?>
        	</td>
		</tr>
	</table>
	<br>
	<br>
	<h4 class="logitem">CASH ADVANCE</h4>
	<table class="items table-content  font">	  	
        	<tr>
	          	<th>No</th>
	          	<th>Keterangan</th>
	          	<th>Request Amount</th>
	          	<th class="bgcolor">Approve Amount</th>
	          	<th>Saldo Cash Advance</th>
        	</tr>
        	<?php $no = 1; ?>
          	<tr>
            	<td><?php echo $no; ?></td>
            	<td><?php echo $detail['message']; ?></td>
            	<td><?php echo number_format($detail['amount']); ?></td>
            	<td class="bgcolor">
              		<?php if($detail['approval_status'] == 0 AND $detail['amount']== 0) { ?>
               			<center><span ><?php echo number_format($detail['amount_approved']); ?></span></center>
              		<?php }elseif($detail['approval_status'] == 0 AND in_array($detail['cabang'], array('Bandung', 'Medan', 'Cikupa', 'Surabaya', ''))) { ?>
               			<center><span ><?php echo number_format($detail['amount_approved']); ?></span></center>
              		<?php }elseif ($detail['approval_status'] == 1) { ?>
                		<span id="qty_<?php echo $detail['id']; ?>" class="fontcolor"><?php echo number_format($detail['amount_approved']); ?></span>
                		<br>
                		<span style='font-size: 10px;'><?php echo date('d/m/Y H:i:s', strtotime($detail['date_approved'])) ?> <br>
               			Updated By : <b><?php echo $detail['name_approved']; ?></b><br></span>
              		<?php }else { ?>
                		<center><span ><?php echo number_format($detail['amount_approved']); ?></span></center>
              		<?php } ?>  
            	</td>          
            	<td style="text-align: right;"><strong><?php echo number_format($detail['amount_approved']); ?></strong></td>
          	</tr>
        	<?php $no++;  ?>
    </table>
	<br>
	<br>
	<br>


	<?php
	if(!empty($exp))
	{ ?>
	<h4 class="logitem">CASH EXPENSES</h4>

	<table class="items table-content font" >
	
        <tr>
          <th>No</th>
          <th>Keterangan Penggunaan Uang</th>
          <th>Exp Amount</th>
          <th>Jenis Pembelian</th>
          <th>Update By</th>
          <th></th>
          <th></th>
          <th>Receive Amount</th>
        </tr>
    
        <?php $no = 1;
          //print_r($exp);die;
          foreach ($exp as $row) {
            // print_r($row);die;
           ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $row['deskripsi']; ?></td>
           
            <td id="amount_<?php echo $row['id']?>"><?php echo number_format($row['amount_expense']); ?></td>            
           	<td><?php echo $row['jenis_pembelian'] ?></td>
            <td>
            <b><?php echo $row['nickname']; ?></b> <br><?php echo date('d/m/Y H:i:s', strtotime($row['date_created'])); ?>  
            </td>
            <td><?php echo ($row['tanggungan'] == '0') ? 'Biaya' : 'Piutang' ?></td> 
            <td id="td_<?php echo $row['id'] ?>"><center>
                  <?php switch ($row['status_approved']) {
                    case '1':
                      echo '<b style="color:green;">Received</b> By : <b>'.$row['user_approved'].'</b><br>';
                      echo date('d/m/Y H:i:s', strtotime($row['date_approved']));
                      break;
                    
                    case '2':
                      echo '<b style="color:red;">Not Received</b> By : <b>'.$row['user_approved'].'</b><br>';
                      echo date('d/m/Y H:i:s', strtotime($row['date_approved']));
                      echo '<br>Ket : '.$row['ket_notapproved'];
                      break;

                    default: ?>
                      <?php if(in_array($_SESSION['myuser']['position_id'], array('5', '18', '60', '62', '75'))) { ?>
                        <button onclick="ExpensesReceived(this)" name="btn-action" class="btn btn-success btn-sm" data-status="1" data-id="<?php echo $row['id'] ?>" id="appr_<?php echo $row['id'] ?>">Receive</button> &nbsp;
                      <button onclick="ExpensesReceived(this)" name="btn-action" class="btn btn-danger btn-sm" data-status="2" data-id="<?php echo $row['id'] ?>" id="notappr_<?php echo $row['id'] ?>">Not Receive</button>
                      <?php }else {
                        echo "Waiting Admin to Receive";
                      } ?>
                      
                      <?php break;
                  } ?>
                </center>
            </td>
            <td style="text-align: right; font-weight: bold;" id="td2_<?php echo $row['id'] ?>">
              <?php if($row['status_approved'] == '1') {
                echo number_format($row['receive_amount']);
              }else {
                echo "0";
              } ?>   
            </td>
          </tr>
         
        <?php $no++; } ?>
    </table>
    <?php } ?>


	<table class="table-content log" align="right" border="0">
 		<tr>
    		<td class="tg-031e" style="font-size:11px; width:193px; text-align:right;">Balance</td>
    		<td style="text-align:right; width:20px;" >
    	 		<?php $minus = substr($detail['total_amount'], 0,1);
      			if($minus == '-') {
        			$balance = $detail['total_amount'] + $detail['paid']; ?>
        			<label class="pull-right balance" style="font-size:11px; color:red;">  Rp. <?php echo number_format($detail['total_amount']); ?>
      			<?php }elseif($minus != '-' AND $detail['total_amount'] != '') { 
        			$balance = $detail['total_amount'] - $detail['paid']; ?>
        			<label class="pull-right balance" style="font-size:11px; color:blue;"> Rp. <?php echo number_format($detail['total_amount']); ?>
      			<?php }elseif($detail['type'] == '1' AND $detail['amount_approved'] != '0') { 
        			$balance = $detail['amount_approved']; ?>
        			<label class="pull-right balance" style="font-size:11px; color:blue;">  Rp. <?php echo number_format($detail['amount_approved']);
      			}else{ 
       				 $balance = "0"; ?>
        			<label class="pull-right balance" style="font-size:11px; color:blue;"> Rp. 0
      			<?php } ?>
    		</td>
  		</tr>
  		<tr>
    		<td class="tg-031e" style="font-size:11px; text-align:right;">Paid</td>
    		<td style="text-align:right; width:20px;">
	 			<?php if($detail['status'] != '101' AND $detail['paid'] == '0' AND $detail['status'] != '0' AND in_array($_SESSION['myuser']['position_id'], array('5', '18', '60', '62', '75')) AND !empty($exp)) { ?>
	          		<button class="btn btn-sm btn-success pull-right btn-pay" data-toggle="modal" data-target="#myModalPay"><span class="fa fa-plus"></span> Pay</button>
	        	<?php }elseif($detail['paid'] != '0') { ?>
	          		<label class="pull-right " style="font-size:11px; color:green;">  Rp. <?php echo number_format($detail['paid']);
	        	}else { ?>
	          		<label class="pull-right " style="font-size:11px; color:green;">  Rp. <?php echo number_format($detail['paid']);
	        	} ?>
			</td>
  		</tr>
		  <!-- <tr>
		    <td class="tg-yw4l" style="font-size:11px; text-align:right;">Balance</td>
		    <td style="text-align:right; width:20px;">
		    	<label class="pull-right last-balance" style="font-size:11px;">  Rp. <?php //echo number_format($balance); ?>
		    </td>
		  </tr>-->
	</table>
	<br>
	<br>

	<b  class="font kop" style="font-size: 14px;">Log & Message</b>
	<br />
  	<b style="color: purple; font-size: 12px;">Contributor : </b>
  	<span class="details">
  		<?php if($loadContrib) {
        	foreach ($loadContrib as $con) 
        	{ ?>
           		<?php echo $con['nickname']; ?>; 
        	<?php }
     	} ?>
     	</span>
    <br />
    <br /> 	
	<table class="table-content log">
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Operator</th>
				<th>Messages</th>
			</tr>
			<?php $no = 1; 
				foreach ($pesan as $key => $lg)	
				{ ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo date('d/m/Y H:i:s', strtotime($lg['date_created'])); ?></td>
						<td><?php echo $lg['nickname']; ?><br>
							<?php echo ($lg['nickname'] != 'IIOS') ? '('.$lg['position'].')' : ' '; ?>
						</td>
						<td><?php echo $lg['pesan']; ?></td>
					</tr>
			<?php $no++; } ?>
	</table>
</body></html>