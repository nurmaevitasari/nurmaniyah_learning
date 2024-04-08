<?php $user = $this->session->userdata('myuser'); 
		$file_url = $this->config->item('file_url');
?>


<style type="text/css">
	dl{
		text-align:  center;
	}

	dt {
		float: left;
  		width: 60%;
  		/* adjust the width; make sure the total of both is 100% */
  		padding: 0;
 	 	margin: 0;
	}
	dd {
	  float: left;
	  width: 10%;
	  /* adjust the width; make sure the total of both is 100% */
	  padding: 0;
	  margin: 0;
}
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-9">
			<h2>Artikel</h2>
			<p>Untuk Prosedur Artikel klik Panduan berikut ini <span class="fa fa-long-arrow-right"></span> <a target="_blank" href="<?php echo $file_url.'assets/images/upload_artikel/Prosedur Materi Artikel Mingguan.pdf'; ?>">Prosedur Materi Artikel Mingguan.pdf</a></p>
			<p>Untuk petunjuk penggunaan modul klik <span class="fa fa-long-arrow-right"></span> <a target="_blank" href="<?php echo $file_url.'assets/images/upload_artikel/Petunjuk penggunaan modul Artikel IIOS.pdf'; ?>">Petunjuk penggunaan modul Artikel IIOS.pdf</a></p>
		</div>
		
		<?php if($_SESSION['myuser']['position_id'] == 13){ ?>
		<div class="col-md-2">
		
		<dl>
			<dt >DHC</dt>
			<dd><?php echo $dhc; ?></dd>
			<dt style="color: grey;">DRE</dt>
			<dd style="color: grey;"><?php echo $dre; ?></dd>
			<dt style="color: blue;">DCE</dt>
			<dd style="color: blue;"><?php echo $dce; ?></dd>
			<dt style="color: red;">DHE</dt>
			<dd style="color: red;"><?php echo $dhe; ?></dd>
			<dt style="color: purple;">DGC</dt>
			<dd style="color: purple;"><?php echo $dgc; ?></dd>
			<dt style="color: orange;">DEE</dt>
			<dd style="color: orange;"><?php echo $dee; ?></dd>
		</dl>
		</div>
		<?php } ?>
		
	</div>              
<!-- /. ROW  -->
	<hr />
	
	<?php if ($_SESSION['myuser']['position_id'] == 13 OR $_SESSION['myuser']['position_id'] == 1){ ?>
		<div>
			<a href="javascript:;" data-toggle="modal" data-target="#myModalArtikel" class="btn btn-danger"><i class="fa fa-plus"></i> Artikel</a><br><br>	
		</div>
	<?php	}?>	

	<div class="table-responsive">
		<table class="table table-hover" id = "artikel_tbl" style="font-size: 12px;">
			<thead>
				<tr>
					<th >ID</th>
					<th >Judul</th>
					<th>Keyword</th>
					<th>Divisi</th>
					<th>Post</th>
					<th>Booking By</th>
					<th>Tanggal Upload</th>
					<th style="width: 58px;">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				if($artikel){
					foreach($artikel as $rows){ 
					
						?>

						<tr>
						<td><?php echo $rows['id']; ?></td>
						<td><?php echo $rows['judul']?><br /><br />
						<?php echo $rows['keterangan']?>
						</td>
						<td><?php echo $rows['keyword']?></td>
						<td><?php echo $rows['divisi'] ?></td>

						<td><?php if ($rows['month'] AND $rows['weeks']): ?>
							<b style="color: #39B3D7;" ><?php echo $rows['month']; ?>&nbsp; <?php echo $rows['weeks'];?></b>
						<?php else: ?>
							
						<?php endif ?>
						</td>
			
							<?php if($rows['published'] == 0){
								echo "<td>".$rows['nickname']."<br />".$rows['tgl_booking']."</td>";

								//$sql = "SELECT date_created FROM tbl_artikel_booking where artikel_id = ".$rows['id']."";
								//$cek = $this->db->query($sql)->row_array();

								$exp = date(strtotime('1 week', strtotime($rows['tgl_booking'])));
								$now = date('Y-m-d H:i:s');
								$today = strtotime($now);
	
								if($today >= $exp AND $rows['id'] == $rows['artikel_book']){ 
									redirect('c_artikel/cancel_book/'.$rows['id']);
								}else{
									//echo "else";

								}
							}elseif($rows['published'] == 1){
								echo "<td>".$rows['nickname']."<br />".$rows['tgl_booking']."</td>";
							}else{
								echo "<td></td>";
							}
	
						 ?>
						<td>
							<?php
							
							if($rows['published'] == 1){
								echo $rows['tgl_upload'];
							}
							
							?>
						</td>
						<td>
						<?php if($rows['id'] == $rows['artikel_book']){
						if(($_SESSION['myuser']['position_id'] == 13 OR $_SESSION['myuser']['position_id'] == 1) AND $rows['published'] == 1){ ?>
								<a target="_blank" href="<?php echo $file_url.'assets/images/upload_artikel/'.$rows['file_name']; ?>" class="btn btn-xs btn-success" title="Download"><i class="fa fa-download fa-lg"></i></a>
							<?php }elseif ($_SESSION['myuser']['karyawan_id'] == $rows['booked_by'] AND $rows['published'] == 0){ ?>
								
										<a href="<?php echo site_url('C_artikel/cancel_book/'.$rows['id'])?>" class = "btn btn-xs btn-default" title = "Cancel Booking" onclick="return confirm('Apakah Anda yakin membatalkan booking dengan judul artikel <?php echo $rows['judul'] ?> ?')">Cancel</a>
										<a class="btn btn-xs btn-warning upload" data-toggle = "modal" data-target="#myModalUpload" title = "Upload" data-id = <?php echo $rows['id']; ?>><i class="fa fa-upload fa-lg"></i></a>
							<?php } ?>
						<?php 
						}elseif ((strpos($_SESSION['myuser']['position'], 'KA CAB' ) !== false OR strpos($_SESSION['myuser']['position'], 'Sales' ) !== false) AND $rows['artikel_book'] == null){ ?>
							<a class = "btn btn-xs btn-info" onclick="return confirm('Apakah Anda akan booking artikel dengan judul <?php echo $rows['judul'] ?> ?')" href="<?php echo site_url('c_artikel/booking/'.$rows['id'])?>">&nbsp Book&nbsp</a>
						<?php } ?>
						
						</td>
					<?php	
					 }
					}?>
					</tr>
				
				
			</tbody>
		</table>
	</div>

<!-- ######## MODAL ADD ARTIKEL ############################### -->
	
	<div class="modal fade" id="myModalArtikel" role="dialog" method="post">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action="<?php echo site_url('C_artikel/add_artikel'); ?>">
					<div class="modal-header">
						<h4>Add Article</h4>
					</div>
 
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-md-2 control-label">Judul</label>
							<div class="col-md-9">
								<input class="form-control col-md-5" type="text" name ="judul" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2" >Keyword </label>
							<div class="col-md-9">
								<input type="text" name="keyword" class="form-control col-md-5" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2" >Keterangan </label>
							<div class="col-md-9">
								<textarea type="text" name="keterangan" class="form-control col-md-5" row = "3"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2" >Divisi </label>
								<div class="col-md-8">
									<select style="width: 250px;" class="form-control" name="divisi" id="divisi" required="required">
										<option value="">-Pilih Divisi-</option>
										<option value="DHC">DHC</option>
										<option value="DRE">DRE</option>
										<option value="DCE">DCE</option>
										<option value="DHE">DHE</option>
										<option value="DGC">DGC</option>
										<option value="DEE">DEE</option>
									</select>
								</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left check-itemss ' value='Submit'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>	
			</div>
		</div>
	</div>

<!-- ########## MODAL UNTUK ADD FILES/UPLOAD ARTIKEL ############################ -->
	
	<div class="modal fade" id="myModalUpload" role="dialog" method="post">
      	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_artikel/upload'); ?>" enctype="multipart/form-data">
            		
            		<div class="modal-header">
              			<h4>Upload Files</h4>
            		</div>
 
            		<div class="modal-body">   
              			<div class="form-group row file-row" id="file-row-1" enctype="multipart/form-data">
                			<label class="control-label col-sm-3">Upload File</label>
                			<div class="controls col-sm-8">
                  				<input type="file" name="userfile">
                  				<input type="hidden" name = "artikel_id" id="artikel_id">
                			</div>      
              			</div>

              			<div class="form-group row">
              				<label class="control-label col-sm-3">Artikel Bulan</label>
              				<select class="form-control" name="bulan" required="required">
              					<option value="">-Pilih-</option>
              					<option value="Jan">Januari</option>
              					<option value="Feb">Februari</option>
              					<option value="Mar">Maret</option>
              					<option value="Apr">April</option>
              					<option value="Mei">Mei</option>
              					<option value="Jun">Juni</option>
              					<option value="Jul">Juli</option>
              					<option value="Agt">Agustus</option>
              					<option value="Sep">September</option>
              					<option value="Okt">Oktober</option>
              					<option value="Nov">November</option>
              					<option value="Des">Desember</option>
              				</select>
              				
              				<label class="control-label">&nbsp &nbsp Minggu ke</label>
              				<select class="form-control" name="minggu" required="required">
              					<option value="">-Pilih-</option>
              					<option value="1">1</option>
              					<option value="2">2</option>
              					<option value="3">3</option>
              					<option value="4">4</option>
              				</select>
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

<!-- ################################################################################################### -->    	

</div>

<script type="text/javascript">
	$("#artikel_tbl").DataTable({
		"aaSorting": [[0, "desc"]]
	});

	$(document).on("click", '.upload', function(){
		var id_art = $(this).data('id');
		//alert(id_art);
		$("#artikel_id").val(id_art);

	});
</script>
