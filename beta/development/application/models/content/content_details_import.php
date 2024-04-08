<?php $user = $this->session->userdata('myuser'); 
$file_url = $this->config->item('file_url');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
.bs-callout {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #eee;
    border-left-width: 5px;
    border-radius: 3px;
}

.bs-callout h4 {
    margin-top: 0;
    margin-bottom: 5px;
}
.bs-callout p:last-child {
    margin-bottom: 0;
}
.bs-callout code {
    border-radius: 3px;
}
.bs-callout+.bs-callout {
    margin-top: -5px;
}
.bs-callout-danger {
    border-left-color: #d9534f;
}
.bs-callout-danger h4 {
    color: #d9534f;
}

  .btn-primary.outline{
    border: 2px solid #ffffff;
     color: #ffffff;
  }

  .label-purple{
  	background: purple;
  }

  .btn-primary.purple{
  	background: purple;
  	border: 2px solid purple;
  }

  .btn-sm.disabled{
  	background: gray;
  border : 1px solid white;
  }

  .lb-sppb{
  	background: #993300;
  }

  .lb-air{
  	background: #DB8874;
  }

  th {
  	text-align : center;
  }

</style>


<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Import Detail </h2>
		</div>
	</div>              
<!-- /. ROW  -->
	<hr />
 
	<dl class="dl-horizontal" style="font-size: 14px;">
		<dt>Shipment ID</dt>
		<dd><?php echo $detail['shipment']; ?></dd>
		<?php $ship = $detail['shipment'];
			$subs = substr($ship, 0, 3);
			if($subs == 'PIS' OR $sps_imp['import_id'] == $detail['id']){ ?>
		<dt>Job ID</dt>
		<dd>
		<?php 
		foreach ($pis as $val) { ?>
			<a target="_blank" href="<?php echo site_url('c_tablesps_admin/update/'.$val['sps_id']); ?>"><?php echo $val['job_id']; ?></a> ;
		<?php } ?>
		</dd>
		<?php } ?>
		
		<dt>Tanggal</dt>
		<dd><?php $d = new DateTime($detail['date_created']);
		echo date_format($d, 'd-m-Y H:i:s'); ?></dd>
		<dt>Shipment VIA</dt>
		<dd><?php echo $detail['ship_via']; ?></dd>
		<dt>Departure Date</dt>
		<dd><?php echo $detail['dept']; ?></dd>
		<dt>Arrival Date</dt>
		<dd><?php echo $detail['arrival']; ?></dd>
		<dt>Receiver</dt>
		<dd><?php echo $detail['nickname']; ?></dd>
		<dt>Tujuan Kedatangan</dt>
		<dd><?php echo $detail['kedatangan']; ?></dd>
		<dt>Umur Shipment</dt>
		<?php 
			$min = date('Y/m/d H:i:s', strtotime($detail['date_created']));

			$max =  date('Y/m/d H:i:s', strtotime($detail['date_closed']));
			//print_r($max);exit();
			$total = datediff($max, $min);
		
		if($detail['status'] != 8){ ?>
		<dd class="time-elapsed">
		<?php }else{ ?>
		<dd><?php echo $total['months'].'m '. $total['days']. 'd ' .$total['hours']. 'h ' .$total['minutes']. 'm ' .$total['seconds']. 's '; ?>
		<?php } ?>
		</dd>
		
		<input type="hidden" class="date_start_time" value="<?php echo $min; ?>"></input>
		<dt>Status Shipment</dt>
		<dd><?php

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
            	} ?>
		</dd>
		<dt>Info Barang</dt>
		<dd><?php echo $detail['info']; ?></dd>
		<dt>Files</dt>
		<dd>
        <?php
        if(!empty($file))
          {
            foreach($file as $fs)
              {
              ?>
                <?php $date = new DateTime($fs['date_created']);
                echo date_format($date, 'd-m-Y H:i:s'); ?>
                <b style = "color : #3992b0"><?php echo $fs['nickname']; ?></b>
                <a target="_blank" href="<?php echo $file_url.'assets/images/upload_import/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
              <?php
              }
          }
          ?>    
		</dd> 
	</dl>

<br>
	<?php if (($_SESSION['myuser']['position_id'] == 2) OR ($_SESSION['myuser']['role_id'] == 9) AND ($detail['status'] != '8')): ?>
	<div class="col-md-12">
		<form id = "form-status" method = "post" action="<?php echo site_url('c_import/change_status/'.$this->uri->segment(3));?>"> 
		<b class="col-md-2">Change Status to :</b> 
		<div class="col-md-3">
			<select id = "chg-status" name="sel-status" class="form-control " style="width: 100%;">
				<option>-- Pilih --</option>
				<option name = "sea"	id = "sea" value = "2">Ship by Sea</option>
				<option name = "air"	id = "air"	value = "9">Ship by Air</option>
				<option name = "clear" 	id = "clear" value="3">Custom Clearance</option>
				<option name = "ccheck"	id = "ccheck" value="4">Customs Check</option>
				<option name = "sppb"	id = "sppb" value="5">SPPB</option>
				<option name = "truck"	id = "truck" value="6">Delivery by Truck</option>
				<option name = "checked" id = "checked" value="7">Checked</option>
			</select>
		</div>
		
		</form>
			<br>
	</div>
	<?php endif ?>
	<br><br>

	<div class="col-md-12">
		<a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn- btn-warning btn-files"><span class="fa fa-plus"></span> Files</a>

		<?php if($status['status'] == 1 AND $_SESSION['myuser']['position_id'] == '4'){ ?>
			<a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-primary"><span class="fa fa-plus"></span> Add Products</a>
		<?php } 
		if (($detail['ship_to'] == $_SESSION['myuser']['karyawan_id']) AND ($status['status'] == 7 ) AND ($checked > 0)): ?>
			<button data-toggle="modal" data-target="#myModalCheckItems" class="btn btn-success">Check Items</button>	
		<?php endif ?>
		  	<a target="_blank" href="<?php echo site_url('c_import/cetakimport/'.$detail['id']); ?>" class="btn btn-default "> <span class="glyphicon glyphicon-print"></span> PRINT </a>
	</div>

		<!-- MODAL UNTUK CHECK ITEMS -->
    <div class="modal fade" id="myModalCheckItems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Check Items</h4>
                </div> 
                	<form method="post" action="<?php echo site_url('c_import/check_items/'.$detail['id']);?>">  
                		<div class="modal-body">
                		<b>*** Checklist Item yang telah sesuai ***</b><br><br>
                    		<table id="lookup" class="table table-bordered table-hover table-striped">
                        		<thead>
                            		<tr>
                                		<th></th>
                                		<th>Items</th>
                                		<th>Description</th>
                                		<th style="width : 102px;">Received Qty</th>
                                		
                            		</tr>
                        		</thead>
                   				<tbody>
                   				<?php 

                   					foreach ($detail_table as $check) {
                   						if($check['status'] == 0){
                   					 ?>
        								<tr>
        									<td><input type="checkbox" name="chk[]" value="<?php echo $check['id_imp_product']; ?>">
        									<input type="hidden" name="id_imp" value="<?php echo $check['imp_id']; ?>" id="chksts">
        									</td>
        									<td><?php echo $check['kode']; ?></td>
        									<td><?php echo $check['product']; ?></td>
        									<td class = "qty" name = "qty" id = "received_qty:<?php echo $check['id_imp_product']?>" contenteditable = "true"></td>
                      			<?php }} ?>
                            			</tr>     
                    			</tbody>
                    		</table>                   
                		</div>
                	
                	<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left check-itemss ' value='Submit'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
            </div>
        </div>
    </div>

<!-- MODAL UNTUK ADD PRODUCT IMPORT -->
	<div class="modal fade" id="myModal" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action="<?php echo site_url('C_import/add_product'); ?>" id="userForm">
					<div class="modal-header">
						<h4>Add Products</h4>
					</div>
 
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-md-3 control-label">Shipment ID</label>
						<div class="col-md-6">
							<input class="form-control col-md-5" type="text" name ="shipment" value="<?php echo $detail['shipment']; ?>" readonly>
							<input type="hidden" name = "import_id" value="<?php echo $detail['id']; ?>"  >
						</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3" >Product </label>
						<div class="col-md-6">
							<select style="width: 265px;" class="form-control" name="product_id" id="product_id">
								<option>-Pilih-</option>
								<?php 

								if($product_id)
								{
									foreach($product_id as $p_id)
									{ ?>
										<option value="<?php echo $p_id['id']; ?>">
										<?php echo $p_id['kode']; ?>
										</option>
									<?php 
									} 
								} ?>
							</select>
						</div>
						</div>
    
	 <div class="form-group row">
      <label class="control-label col-md-3">Nama Produk</label>
      <div class="col-sm-6">
        <textarea class="form-control" name="product_name" readonly="readonly" id="product_name"></textarea>
      </div>
    </div>

    <div class="form-group row">
		<label class="col-md-3 control-label">Quantity</label>
		<div class="col-md-6">
			<input class="form-control col-md-5" type="text" name ="ship_qty" required="">
		</div>
	</div>
	</div>

	<div class="modal-footer">
		<input type='submit' class='btn btn-info pull-left' value='Add'>
		<a class="btn btn-default" data-dismiss="modal">Close</a>
	</div>
				</form>
			</div>
		</div>
	</div>

<!-- TAMPILAN TABLE DETAIL PRODUCT IMPORT -->
	<div class="table table-responsive">
		<table class="table table-hover" style="font-size: 11px;">
			<thead>
				<tr>
					<th>No. </th>
					<th>Inventory ID</th>
					<th>Item Description</th>
					<th style="width : 127px; ">Shipment Quantity</th>
					<th style="width : 62px; ">Indent &<br />Booking</th>
					<th style="width : 1px; ">Free Quantity</th>
					<th >Action</th>
					<th style="width : 111px; ">Arrival Confirmation</th>
					<th style="width : 350px;">Message</th>
				</tr> 
			</thead>
			
			<tbody>
			<?php
			
			if ($row_detail['import_id'] == $detail['id']) 
			{
			if($detail_table)
			{
				$x = 1;
				foreach($detail_table as $key => $row)
				{
						 ?>
					<tr>
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
						
						<td><?php echo $row['free_qty']; ?></td>
						<td>
						<?php
						if($_SESSION['myuser']['role_id'] != '15') { 
						 if($row['status'] != 1){ 

						 	?>
							<div class="text-center">
								<a href="javascript:;" data-toggle="modal" data-target="#myModalBook" class="btn btn-primary btn-sm outline data-record" data-id = "<?php echo $row['id_imp_product']; ?>" data-kode = "<?php echo $row['kode']; ?>">Book</a>
							</div>

							<?php if (empty($xx['import_product_id'])) {
								# code...
							}elseif (($xx['import_product_id'] == $row['id_imp_product']) AND ($xx['booked_by'] == $_SESSION['myuser']['karyawan_id'])) { ?>
								<div class="text-center">
								<a href="javascript:;" data-toggle="modal" data-target="#myModalCancel" class="btn btn-danger btn-sm outline data-cancel" data-unit = "<?php echo $xx['booking_qty']; ?>" data-so = "<?php echo $xx['so_number']; ?>">Cancel</a>
							</div>
							<?php } ?>

							<?php }else{ ?>
							<div class="text-center">
								<a href="javascript:;" data-toggle="modal" data-target="#myModalBook" class="btn btn-primary btn-sm disabled outline data-record" data-id = "<?php echo $row['id_imp_product']; ?>" data-kode = "<?php echo $row['kode']; ?>">Book</a>
							</div>
							<div class="text-center">
								<a href="javascript:;" data-toggle="modal" data-target="#myModalCancel" class="btn btn-danger btn-sm disabled outline data-cancel">Cancel</a>
							</div>						
			
						<?php }
						} ?>
						</td>

						<td>
						<?php 
						if($row['status'] == 1 ){ ?>
							<span class = "label label-pill label-success ">RECEIVED</span><br>
							<p style="font-size: 10px;">Confirmed By : <?php echo $detail['nickname']; ?> <br />
							<?php $d = new DateTime($row['date_received']);
							echo date_format($d, 'd-m-Y H:i:s'); ?></p>
							<?php }else{ ?>
							<span class = "label label-pill label-danger ">On Delivery</span>
							<?php } ?>
						</td>
						<td>
							<?php 
							$sql = "SELECT a.date_created, a.pesan, b.nickname
							FROM tbl_import_pesan as a JOIN tbl_loginuser as b ON a.sender = b.karyawan_id WHERE a.import_product_id = '$id_imp_prd' AND a.import_id = ".$this->uri->segment(3)." ORDER BY a.id ASC ";
							$pesan = $this->db->query($sql)->result_array();

							$sql = "SELECT file_name, a.date_created, b.nickname FROM tbl_upload_import as a 
							LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE import_id = ".$this->uri->segment(3)." AND type = 1 AND import_pd_id = '$id_imp_prd' ORDER BY a.id ASC";
							$query = $this->db->query($sql);
							$itemfile = $query->result_array();

							if ($itemfile) { ?>
								<div class="row">
									<?php foreach ($itemfile as $val) { ?>
									  	<div class="col-md-2">
										    <div class="thumbnail">			    	
										        <?php 
										        $sub = substr($val['file_name'], -4);
										        $fname = substr($val['file_name'], 0, -4);

										        if(stristr($sub, '.') !== FALSE) {
										        	$subs = substr($val['file_name'], -3);  //echo $subs;
										        	 ?>
										        	<a href="<?php echo $file_url.'assets/images/upload_import/'.$val['file_name']; ?>" title="<?php echo $val['file_name']; ?>" target="_blank">
										        	<?php if($subs == 'pdf') { ?>
										        		<img src="<?php echo $file_url.'assets/images/logo-pdf.png'; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
										       	 	<?php  }elseif($subs == 'jpg') { ?>
										        		<img src="<?php echo $file_url.'assets/images/upload_import/thumb_import/'.$fname.'_thumb.'.$subs; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
										        	<?php }else{ ?>
										        		<img src="<?php echo $file_url.'assets/images/no-image.png'; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
										        	<?php } 
										        }else { 
										        	$fname = substr($val['file_name'], 0, -5); 

										        	if($sub == 'jpeg') { ?>
										        		<a href="<?php echo $file_url.'assets/images/upload_import/'.$val['file_name']; ?>" title="<?php echo $val['file_name']; ?>" target="_blank">
										        		<img src="<?php echo $file_url.'assets/images/upload_import/thumb_import/'.$fname.'_thumb.'.$sub; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
										        	<?php }else { ?>
										        		<img src="<?php echo $file_url.'assets/images/logo-pdf.png'; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
										        	<?php	} 		
										        } ?>
										        </a>
										       <!--  <div class="caption">
										          <p style="font-size: 11px;"><?php //echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?></p> 
										        </div> -->
										    </div>
									  	</div>
									<?php } ?>	
								</div>
							<?php } ?>
							<br>

							<?php foreach ($pesan as $psn) {
								$d = new DateTime($psn['date_created']);
								echo date_format($d, 'd-m-Y H:i:s'). '<b style="color:#3992b0;"> '.$psn['nickname']. '</b> : '.$psn['pesan'].'<br>';
							}

							if(!empty($pesan)){
							echo '<br />';	
							}

							if($_SESSION['myuser']['role_id'] != '15') { ?>
							 <a href="javascript:;" data-toggle="modal" data-target="#myModalPesan" class="btn btn-xs btn-info data-record" data-id = "<?php echo $row['id_imp_product']; ?>">
							 <span class="fa fa-plus"></span> Message</a>
							 <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-xs btn-warning btn-files" data-id = "<?php echo $id_imp_prd; ?>"><span class="fa fa-plus"></span> Files</a>
							<?php } ?>	 
						</td>
				<?php 
				$x++;
				}
			}
			} ?>
					<tr>
		</table>
	</div>

	<div class="bs-callout bs-callout-danger" >
      <div style="overflow: hidden;">
        <div style="float: left;">
          <h4>Ketentuan SOP Import : </h4>     
        </div>  
        <?php if(in_array($_SESSION['myuser']['position_id'], array('1','2', '14', '77'))) {
          echo '&nbsp; &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ketentuan" title="Edit"><span class="fa fa-edit"></span></button>';
        } ?>
      </div>  
        <div>
          <?php if ($ketentuan)
      { ?>
        <div style="font-size: 10px;">
          Last Update  : <?php $format = date('d-m-Y H:i:s', strtotime($ketentuan["date_created"] )); echo $format;?>
          <br>
          By   : <b> <?php echo $ketentuan["nickname"];?></b>
        </div>
        <br>
        <div style="font-size: 12.5px;">
          <?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?>
        </div>
        
        <?php  } ?>
        </div>
    </div>

  <div id="ketentuan" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- konten modal-->
      <div class="modal-content">
      <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Ketentuan</h4>
        </div>
        <!-- body modal -->
        <form method="post" action="<?php echo site_url('c_ketentuan/simpanSOP') ?>">
          <div class="modal-body">
            <textarea type="text" id="kt" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
            <input type="hidden" value="6" name="nama_modul">
            <input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
          </div>
          <!-- footer modal -->
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Simpan">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
          </div>
        </form>
      </div>
    </div>
  </div>

	<!-- MODAL UNTUK CANCEL -->
    <div class="modal fade" id="myModalCancel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Booked Table</h4>
                </div> 
                	<form method="post" action="<?php echo site_url('c_import/cancel_booking/');?>">  
                		<div class="modal-body">
                    		<table id="lookup" class="table table-bordered table-hover table-striped">
                        		<thead>
                            		<tr>
                                		<th></th>
                                		<th>Items</th>
                                		<th>Description</th>
                                		<th>Booked Quantity</th>
                                		<th>No. SO</th>
                                		<th>Customer</th>
                            		</tr>
                        		</thead>
                   				<tbody>
                   				<?php 
                   					foreach ($batal as $cancel) { ?>
        								<tr>
        									<td><input type="checkbox" name="mltcancel[]" value="<?php echo $cancel['id_book']; ?>">
        										<input type="hidden" name="id_imp" value="<?php echo $cancel['import_id']; ?>"></input>
        									</td>
        									<td><?php echo $cancel['kode']; ?></td>
        									<td><?php echo $cancel['product']; ?></td>                                	
                                			<td><?php echo $cancel['booking_qty']; ?></td>
                                			<td><?php echo $cancel['so_number']; ?></td>
                                			<td><?php echo $cancel['perusahaan']; ?></td>
                      			<?php } ?>
                            			</tr>     
                    			</tbody>
                    		</table>                   
                		</div>
                	
                	<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left' value='Submit'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
            </div>
        </div>
    </div>


  <!-- MODAL UNTUK FORM BOOK -->

	<div class="modal fade" id="myModalBook" method="post" data-focus-on = "input:first" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action="<?php echo site_url('C_import/booking'); ?>">
					<div class="modal-header">
						<h4>Booking</h4>
					</div>
 
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-md-3 control-label">Inventory ID</label>
						<div class="col-md-7">	
							<input class="form-control col-md-5 inventory-kode" type="text" name ="kode" id="kode" readonly="" />
							<input type="hidden" name="id" id="id" class="inventory-id"></input>
							<input type="hidden" name="imp_id" value="<?php echo $row['imp_id']; ?>" />
							<input type="hidden" name="product" id="product" value="<?php echo $p_id['id']; ?>" />
						</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 control-label">No. SO</label>
						<div class="col-md-7">
							<input class="form-control col-md-5" type="text" name ="no_so">
						</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3" >Link to Job ID </label>
						<div class="col-md-8">
							<select style="width: 312px;" class="form-control" name="job_id" id="job_id">
								<option value = "">-Pilih Job ID-</option>
								<?php 
									foreach($job_id as $jb_id)
									{ ?>
										<option value="<?php echo $jb_id['id']; ?>">
										<?php echo $jb_id['job_id']; ?>
										</option>
									<?php 
									} 
								 ?>
							</select>
							<p style="font-size: 11px;"><span class="fa fa-warning fa-lg text-danger"></span>
						Hanya untuk link ke Job ID, tidak berlaku untuk book biasa</p>
						</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3" >Customer </label>
						<div class="col-md-7">
							<select style="width: 312px;" class="form-control" name="customer_id" id="customer_id">
								<option>-Pilih Customer-</option>
								<?php 
								if($customer_id)
								{
									foreach($customer_id as $row)
									{ ?>
										<option value="<?php echo $row['id']; ?>">
										<?php echo $row['perusahaan']; ?>
										</option>
									<?php 
									} 
								} ?>
							</select>
						</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 control-label">Booked By</label>
						<div class="col-md-7">
							<input class="form-control col-md-5" type="text" name ="booked_by" readonly="" value="<?php echo $_SESSION['myuser']['nama']; ?>">
						</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 control-label">Book Quantity</label>
						<div class="col-md-7">
							<input class="form-control col-md-5" type="text" name ="book_qty" id="book_qty">
						</div>
						</div>
					
					<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left' value='Add'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
					</div>
				</form>
			</div>
		</div>
    </div>


    <!-- MODAL UNTUK MENAMBAHKAN PESAN -->
	<div class="modal fade" id="myModalPesan" role="dialog" method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="post" action='<?php echo site_url('c_import/add_pesan'); ?>'>
            <div class="modal-header">
              <h4>Message</h4>
            </div>
 
            <div class="modal-body">
              <div class="form-group">
                <label for="contact-msg" class="col-lg-2 control-label">Pesan :</label>
                <div class="col-lg-10">
                  <textarea class="form-control" rows="5" name="msg" id="msg" required=""></textarea>
                  <input type="hidden" name ="id_import" value="<?php echo $detail['id']; ?>"></input>
                  <input type="hidden" class="pesan-id" name = "id_import_product"></input>
                </div>
              </div>
            </div>
 
            <div class="modal-footer">
              <input type='submit' class='btn btn-info pull-left' value='Add'>
              <a class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
          </form>
        </div>
      </div>
	</div>  

	<!-- TAMPILAN MODAL UNTUK ADD FILES  -->
    <div class="modal fade" id="myModalUpload" role="dialog" method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_upload/free_add_import');  ?>" enctype="multipart/form-data">
              
            <div class="modal-header">
              <h4>Upload Files</h4>
            </div>
 
            <div class="modal-body">   
              <div class="form-group row file-row" id="file-row-1" enctype="multipart/form-data">
                <label class="control-label col-sm-2">Upload Foto/File</label>
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfile[]">
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                </div> 
                <input type="text" name ="id_import" value="<?php echo $detail['id']; ?>"> 
                <input type="text" name="tipe" value="1">
                <input type="text" name="import_pd_id" class="import_pd">      
              </div>
            
              <div id="add-row">

              </div>

            </div>
 
            <div class="modal-footer">
              <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
              <a class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
          </form>
        </div>
      </div>
    </div>





<?php $id_import = $detail['id'];?>

</div>

<script type="text/javascript">

  $( document ).ready(function() {

  	$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<label class="control-label col-sm-2">&nbsp;</label>'+
          '<div class="controls col-sm-6">'+
            '<input class="" type="file" name="userfile[]">'+
          '</div>'+
          '<div class="row col-sm-8">'+
            '<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+
            '<div class= col-sm-2>'+
            
            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+           
          '</div>'+ 
          '</div>'+ 
        '</div>';

      $('#add-row').append(html); 
    });

    $('body').delegate('.btn-remove-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;
      
      if(length > 1)
      {
        $('#file-row-'+id).remove();
      }
    }); 

  	$("#chg-status").change(function(){
    	$("#form-status").submit();
    });

    
      $( "#product_id" ).change(function() {
      var id = $(this).val();
      $.ajax({
          type : 'POST',
          url : '<?php echo site_url('C_import/getProduct'); ?>',
          data : {
            data_id : id,
          },
          dataType : 'json',
          success : function (data){
            $('#product_name').val(data.product);     
          },
          error : function (xhr, status, error){
            console.log(xhr);
          }
      });
    });

      $("#product_id").select2({
		//tags: true,
		ajax: {
			url: "<?php echo site_url('c_import/ajax_product'); ?>",
			type: "post",
			dataType: "json",
			delay: 250,
			data: function(params){
				return { q: params.term };
			},
			processResults: function(data){
				var myResults = [];
	            $.each(data, function (index, item) {
	                myResults.push({
	                    'id': item.id,
	                    'text': item.kode + " : " + item.product
	                });
	            });
	            return {
	                results: myResults
	            };	
			},
			cache: true
		},
		minimumInputLength: 3
	});
      	
    }); 

      $(document).on( "click", '.data-record',function(e) {

        var id = $(this).data('id');
        var kode = $(this).data('kode');

        $(".inventory-id").val(id);
        $(".inventory-kode").val(kode);
        $(".pesan-id").val(id);
     
    }); 

    

  function updateClock() {
    $('.date_start_time').each(function() {
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

        $(this).parent().find("dd.time-elapsed").html(d + "d " + h + "h " + m + "m " + s + "s ");
    });
} 

setInterval(updateClock, 1000);


/* $(function () {
    $(".qty").dblclick(function (e) {
        e.stopPropagation();
        var id_imp = $(this).data('imp');
        var currentEle = $(this);
        var value = $(this).html();
        updateVal(currentEle, value, id_imp);
    });
});

function updateVal(currentEle, value, id_imp) {
    $(document).off('click');
    $(currentEle).html('<input style="width : 82px;" class="thVal" type="text" value="' + value + '" />');
    //recv = $(currentEle).html($(".thVal").val().trim());
    $(".thVal").focus();
    $(".thVal").keyup(function (event) {
        if (event.keyCode == 13) {
            $(currentEle).html($(".thVal").val().trim());
        }
    });

    $(document).click(function () {
    	$(currentEle).html($(".thVal").val().trim());
    	var a = $(currentEle).val().trim();
    	alert(a);
    	//ajax_recv(id_imp);
    	//$(currentEle).html($(".thVal").val().trim());
    	
    	 /* $.ajax({
		    type : 'POST',
		    url : '<?php //echo site_url('c_import/received_qty/')?>',
		    data : {
		    data_id : id_imp,
		    data_recv : recv,

		    },
		    success : function(data){
		    
		    },
		    error : function(){
		      alert('failure');
		    },
		}); 
    }); 
}*/

/* var oriVal;
$(".qty").on('dblclick', function () {
    oriVal = $(this).text();
    $(this).text("");
    $("<input type='text'>").appendTo(this).focus();
});

$(document).click(function() {
//$(".qty").on('focusout', 'td > input', function () {
    var $this = $(this);
    $this.parent().text($this.val() || oriVal);
    $this.remove(); // Don't just hide, remove the element.
//});
}); */

$(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("td[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('<?php echo site_url('C_import/received_qty') ?>' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				message_status.show();
				message_status.text(data);
				//hide the message
				setTimeout(function(){message_status.hide()},3000);
			}
        });
    });
});

$(".btn-files").on('click', function() {
	var imp_pd_id = $(this).data('id');
	$(".import_pd").val(imp_pd_id);
});

    CKEDITOR.replace('kt', {
      customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
      height : 200,
      enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });

</script>