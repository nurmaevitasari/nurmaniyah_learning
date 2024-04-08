<html><head>
		<title><?php echo "Purchasing ID "; ?></title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

	</head><style type="text/css">
		@page { margin-top: 15px; }
		body { margin: 0px;
			font-family: 'Helvetica';
		 }

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
			font-size: 9px;
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
		.emergency{
		  color:red;
		  font-size:15px;
		}
		.urgent{
		  color: #8F00FF;
		  font-size:15px;
		}
		.normal{
		  color: #00FFFF;
		  font-size:15px;
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
			<!-- <thead> -->
		  		<tr style="outline: 1px solid black;">
				    <th width="20px">No</th>
				    <th width="80px">Vendor</th>
				    <th width="100px">Items</th>
				    <th width="100px">Qty Receive</th>
				    <th>priority</th>
				    <th>QTY to Purchase</th>
				    <th>Qty Approved<br></th>
				    <th>Stock On Hand<br></th>
				    <th>MOU</th>
				    <th>Notes</th>
				    <th>Date Approved</th>
		  		</tr> 
		  		<!-- </thead>
		  		<tbody>  -->
		  			<?php
						$no = 1;
		  					if($items) {
								foreach($items as $row) { ?>
							<tr>
								<td width="20px"><?php echo $no++ ?></td>
								<td width="80px">
									
									<?php echo $row['vendor']; ?> <br>(ID Item : <?php echo $row['id']; ?> ) <br>
					                <?php 
					              if($row['jenis']=='Tool' AND $row['status_receiver']=='1'){
					                echo "<b style='color:#0CB754; font-size:8px;'>Assets/Tools</b> <br> Tools Holder : <b>".$row['nama']."</b><br><br>";
					                ?>
					              <?php if(!empty($row['tool_id']) AND $row['jenis']=='Tool' AND $row['status_receiver']=='1'){
					                echo "<span style='color:#F7F7F7;background-color:#0DE208; border-radius:5px;'><b>&nbsp; Transfered &nbsp; </b></span></br>";
					                echo "<span style='font-size:8px;'>".date('d/m/Y H:i:s',strtotime($detail['date_created']));
					                echo "&nbsp;<By: <b>".$detail['name']."</b><br>";
					                echo "Tools ID :";?>
					                <a target="_blank" href="<?php echo site_url('c_tools/detail_tool/'.$row['tool_id']);?>">
					                <?php echo $row['tool_id']?></a>
					                <?php }?>

					                <?php

					              }elseif( $row['jenis']=='Consumable'){
					                echo "<b style='color:#0CB754'>Consumable</b>";
					              }elseif( $row['jenis']=='jasa'){
					                echo "<b style='color:#0CB754'>jasa</b>";
					              }elseif( $row['jenis']=='Tool'){
					                echo "<b style='color:#0CB754'>Tools</b>";
					              }elseif( $row['jenis']=='Modal'){
					                echo "<b style='color:#0CB754'>Barang Modal</b>";
					              }
					              ?>

								</td>
								<td width="100px">

											<?php echo $row['items']; ?>
			               		 <br> Deadline: <?php echo date('d F Y', strtotime($row['deadline'])); ?>
			                    <?php

			                     $dateNow = date_create( date('Y-m-d'));
			                     $deadlineDate = date_create(date('y-m-d',strtotime($row['deadline'])));
			                     $day = date_diff($dateNow,$deadlineDate);

			                     if($deadlineDate < $dateNow){
			                       echo "<b style='color :#dc143c'> ( D Day"."-".$day->days.")</b>";
			                     }elseif ($deadlineDate > $dateNow){
			                       echo "<b style='color :#6495ed'> ( D Day"."+".$day->days.")</b>";
			                     }
			                     ?>
			               		 <br>
			                	 <br>
			                    <?php 
			                        if ($row['status_purchaser']== '1')
			                          {
			                            echo "<span style='color: #F7F7F7; background-color: #58f404; border-radius:5px;'><b>&nbsp;Finished &nbsp; </b></span><br>";
			                            echo "<span style='font-size:8px;'>". date('d/m/Y H:i:s',strtotime($row['date_created']))."<br>";
			                            echo "<b style='color :#0CB754'>Purchase Finish </b> By : <b>".$detail['nickname']."</br><br>";
			                          }
			                        if($row['status_receiver']=='1')
			                          {
			                            echo "<span style='color: #F7F7F7; background-color: #FCA51C; border-radius:5px;'><b>&nbsp;Finished &nbsp; </b></span><br>";
			                            echo "<span style='font-size:8px;'>". date('d/m/Y H:i:s',strtotime($row['date_created']))."<br>";
			                            echo "<b style='color :#0CB754'>Purchase Received </b> By : <b>".$detail['nama']."<br>";
			                            echo "<b style='color :#0CB754'>harga Beli </b> : <b>".$row['harga_beli']."";
			                          }
			                    ?>

			     

								</td>
								<td width="100px"> 
									
									<?php 
			                      if($row['qty_received'] == '0') 
			                        {
			                          echo "0";
			                        }
			                      else 
			                        {  
			                          $received = $pr->loadReceived($row['id']);
			                          $total = $pr->total($row['id']); 

			                          echo "<b style='color: #0000FF; font-size:8px;'>Total Received : ".$total['total']."</b><br><br>" ; 

			                          foreach ($received as $rec => $key)
			                            {  
			                              $z = $rec+1;
			                              if(!empty($key['item_id']))
			                                { 
			                                  echo "<span style='color: #F7F7F7; background-color: #FCA51C; border-radius:5px;'><b>&nbsp;Received &nbsp; </b></span><br>";
			                                  echo "<span style='font-size:8px;'>". date('d/m/Y H:i:s',strtotime($key['date_created']))."<br>";
			                                  echo "<b style='font-size:8px;'>Receive #".$z." = ".$key['qty_received']." </b>";
			                                  echo "<b style='font-size:8px;'>".$row['mou']." </b><br>";
			                                  echo "<b style='color :#0CB754'>Item Received </b> By : <b>".$key ['nickname']."</b><br>";
			                                }     
			                            }
			                        } 
			                  ?>
                  

								</td>

								<td>
									
										<?php 
					            if($row['priority']=='emergency')
					                {
					                ?>
					                 <span style="color:red;"> Emergency </span>
					            <?php 
					                }
					            elseif($row['priority']=='urgent')
					                {
					              ?>
					            <span style="color:#8F00FF;"> urgent </span>
					            <?php }
					            elseif($row['priority']=='normal')
					            {?>
					            <span style="color:#00FFFF;"> Normal </span>
					            <?php }?>


								</td>
								<td> <?php echo $row['qty']; ?></td>
								<td ><?php echo $row['qty_approved']?></td>
								<td ><?php echo $row['stock']?></td>
								<td ><?php echo $row['mou']?></td>
								<td >

								<?php $notes = $pr->loadItemNotes($row['id']);
					              foreach ($notes as $key => $nt) {
					                echo date('d-m-Y H:i:s', strtotime($nt['date_created']));
					                echo "<br>";
					                echo "By : <b>".$nt['nickname']."</b>";
					                echo "<br>";
					                echo $nt['notes'];
					                echo "<br><br>";

              						}
              						 ?>

								</td>
								<td ><?php if($row['date_approved'] != '0000-00-00 00:00:00') {
									echo $row['date_approved'];
									echo "<br>";
									echo "Update by : <b>".$row['nickname'];
								} ?>
									
								</td>
							 </tr>
						<?php }
					}?>
					<!-- </tbody> -->

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