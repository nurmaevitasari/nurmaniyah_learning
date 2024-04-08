<?php $user = $this->session->userdata('myuser'); 
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style>

@media screen and (max-width: 767px;) {
  .alt-table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: auto;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    //border: 1px solid #dddddd;
    -webkit-overflow-scrolling: touch;
    
  }
  
  .alt-th{
  width: 70px;
  }

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

}

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


</style>

<div id="page-inner">
  <div class="row">
    <div class="col-md-12">
			<h2>SPS Details </h2>
    </div>
  </div>              
<!-- /. ROW  -->
<hr />

	<!-- tampilan untuk info detail sps di baris atas -->
    <div id = "desc">

    </div>

<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
    <div class="modal fade" id="myModal" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" 
					<?php if(($_SESSION['myuser']['role_id'] == 1) || ($_SESSION['myuser']['role_id'] == 2)){ ?>
						action='<?php echo site_url('c_tablesps_admin/add_pesan'); ?>'
					<?php }else{ ?>
						action='<?php echo site_url('c_tablesps/add_pesan'); ?>'
					<?php } ?>>
				  
					<div class="modal-header">
						<h4>Message</h4>
					</div>
		 
					<div class="modal-body">
						<div class="form-group">
							<div class="col-lg-12">
								<textarea class="form-control" rows="5" name="msg" id="msg" required=""></textarea>
								<input type="hidden" name ="id_sps" value="<?php echo $detail['id_sps']; ?>" />
							</div>
						</div>
					</div>
		 
					<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left submit_btn' value='Add'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>

<!-- TAMPILAN MODAL UNTUK ADD FILES  -->
    <div class="modal fade" id="myModalUpload" role="dialog" method="post">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_upload/free_add');  ?>" enctype="multipart/form-data">
              
					<div class="modal-header">
					  <h4>Upload Files</h4>
					</div>
	 
					<div class="modal-body">   
						<?php if($detail['jenis_pekerjaan'] == 9){ ?>
							<div class="form-group row">
								<label class="control-label col-sm-2">Type Upload</label>
								&nbsp;&nbsp;&nbsp;&nbsp;<select required class="form-control col-sm-10" name ="type" style="width: 200px; display: inline-block !important;" >
									<option value="">-Pilih-</option>
									<option value="0">Foto / Files</option>
									<option value="1">Foto Sebelum Kanibal</option>
									<option value="2">Foto Setelah Kanibal</option>
									<option value="3">Foto Barang yang dikanibal</option>
									<option value="4">Foto Setelah dilengkapi</option>
								</select>
							</div>
							<div class="form-group row file-row" id="file-row-1">
								<label class="control-label col-sm-2">Upload Foto/File</label>
								<div class="controls col-sm-8">
									<input class="" type="file" name="userfile[]">
								</div>
								<div class="col-sm-2">
									<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
								</div>
							</div>
							<div id="add-row">

							</div> 
							<input type="hidden" name ="id_sps" value="<?php echo $detail['id_sps']; ?>">
							<input type="hidden" name="jenis_pekerjaan" value="9">
						<?php	}else{ ?>
							<div class="form-group row file-row" id="file-row-1">
								<label class="control-label col-sm-2">Upload Foto/File</label>
								<div class="controls col-sm-8">
									<input class="" type="file" name="userfile[]">
								</div>
								<div class="col-sm-1">
									<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
								</div>
							</div>
							<div id="add-row">

							</div> 
							<input type="hidden" name ="id_sps" value="<?php echo $detail['id_sps']; ?>">
						<?php	} ?>     
					</div>
	 
					<div class="modal-footer">
						<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>

<!-- TAMPILAN MODAL UNTUK PAUSE   -->
    <div class="modal fade" id="myModalPause" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" 
					<?php if(($_SESSION['myuser']['role_id'] == 1) || ($_SESSION['myuser']['role_id'] == 2)){ ?>
						action='<?php echo site_url('c_tablesps_admin/pause'); ?>'
					<?php }else{ ?>
						action='<?php echo site_url('c_tablesps/pause'); ?>'
					<?php } ?>>
              
					<div class="modal-header">
					  <h4>Pause / Tunda</h4>
					  <p style="font-size : 11px;">
						** Perhatian : Pause harus dilakukan dengan alasan yang jelas.<br>
						** Pause yang sengaja dilakukan untuk menutupi kesalahan/kelalaian adalah pelanggaran kode etik.<br>
						** Pause harus segera ditutup jika memang sudah saatnya, dilarang menunda-nunda.
					  </p>
					</div>
 
					<div class="modal-body">
						<label class="control-label">Pilih alasan pause : </label>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Sedang menawarkan jasa servis & komponen, mengunggu ACC customer" >Sedang menawarkan jasa servis & komponen, mengunggu ACC customer.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Menunggu konfirmasi jadwal pelaksanaan dari customer">Menunggu konfirmasi jadwal pelaksanaan dari customer.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Menunggu pengiriman produk/komponen sampai ke lokasi">Menunggu pengiriman produk/komponen sampai ke lokasi.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Sedang menunggu import komponen masuk">Sedang menunggu import komponen masuk.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Sedang libur/hari besar">Sedang libur/hari besar.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Teknisi berhalangan/sakit dan tidak ada pengganti">Teknisi berhalangan/sakit dan tidak ada pengganti.
						</div>
						<div class="checkbox">
							<input type="checkbox" name="chk[]" value="Sales berhalangan/sakit dan tidak ada pengganti">Sales berhalangan/sakit dan tidak ada pengganti.
						</div>
						<div class="checkbox">
							<input type="checkbox">Alasan lain :
							<textarea class="form-control" rows="5" name="chk[]"></textarea>
						</div>
						<input type="hidden" name="id_sps" value="<?php echo $detail['id_sps']; ?>">
					</div>
 
					<div class="modal-footer">
					  <input type='submit' class='btn btn-info pull-left' value='Pause'>
					  <a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>

<!-- TAMPILAN MODAL CANCEL EXECUTION -->
    <div class="modal fade" id="myModalExec" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action='<?php echo site_url('c_execution/cancel_exec/'); ?>'>
              
					<div class="modal-header">
						<h4>Cancel Execution</h4>
					</div>
 
					<div class="modal-body">
						<div class="form-group">
							<label for="contact-msg" class="col-lg-2 control-label">Alasan :</label>
							<div class="col-lg-9">
								<textarea class="form-control" rows="5" name="msg" id="msg" required=""></textarea>
								<input type="hidden" name ="id_sps" value="<?php echo $detail['id_sps']; ?>">
							</div>
						</div>
					</div>
 
					<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left submit_btn' value='Add'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>   

     <!-- TAMPILAN MODAL UNTUK ADD LINK  -->
     <div class="modal fade" id="myModalLink" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_tablesps_admin/uploadlink/');  ?>" enctype="multipart/form-data">
              
          <div class="modal-header">
            <h4>Google Map Link</h4>
          </div>
   
          <div class="modal-body">
          <div class="form-group">
	      <label class="control-label col-sm-2"> Link</label>
	      <div class="col-sm-8">
	      <input type="text" name="file_name" class="form-control" placeholder="Contoh : https://goo.gl/maps/jzRgPvZHLNQ2">
	      </div>
	      </div>
            <input type="hidden" name ="sps_id" value="<?php echo $detail['id_sps'];  ?>">
            <input type="hidden" name="segment" value="<?php echo $this->uri->segment(1) ?>">
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>     
  
<!-- TAMPILAN UNTUK TABLE DETAIL SPS / SPS LOG -->
	<div class="table-responsive" style="font-size: 12px;" id='data_time'>
  
	</div> 

<!-- TAMPILAN UNTUK TOMBOL FINISHED -->
	<div>
  <input type="hidden" class="form-control" id="disabledInput" name="op_id" value="<?php echo $user['karyawan_id']; ?>">
    <?php
    $karyawanID = $_SESSION['myuser']['karyawan_id'];
    $roleID = $_SESSION['myuser']['role_id'];
    $idSPS = $this->uri->segment(3);

    //$sql = "SELECT status FROM tbl_sps WHERE id = '$idSPS' AND status = '101'";
    //$query = $this->db->query($sql);
    //$a = $query->row_array();
    //print_r($a);
    $sql2 =  "SELECT sales_id, divisi,status, jenis_pekerjaan, kanibal_fin, free_servis FROM tbl_sps WHERE id = '$idSPS'";
    $que2 = $this->db->query($sql2);
    $value = $que2->row_array();
 
   $position = strtolower($_SESSION['myuser']['position']);
   $subs_pos = substr($position, -3);
   
  if(stripos($position, "sales") !== FALSE){
   	$sales = "sales";
	}else{
		$sales = "";
	}
   
    if($karyawanID == $value['sales_id'] AND $value['status'] != '101' AND ($value['jenis_pekerjaan'] != '4' AND $value['jenis_pekerjaan'] != '9')) { ?>
      <a href="<?php echo site_url('c_tablesps_admin/selesai/'.$idSPS); ?>" >
        <button class="btn btn-info" >Service Finished</button></a>
    <?php }elseif($value['divisi'] == $subs_pos AND $sales == 'sales' AND $value['status'] != '101' AND ($value['jenis_pekerjaan'] != '4' AND $value['jenis_pekerjaan'] != '9')){  ?>
      <a href="<?php echo site_url('c_tablesps_admin/selesai/'.$idSPS); ?>" >
        <button class="btn btn-info" >Service Finished</button></a>
    <?php }elseif($value['jenis_pekerjaan'] == '4' AND $position == 'admin gudang' AND $value['status'] != '101'){ ?>
      <a href="<?php echo site_url('c_tablesps_admin/selesai/'.$idSPS); ?>" >
        <button class="btn btn-info" >Service Finished</button></a>    
    <?php }elseif ($value['jenis_pekerjaan'] == '9' AND $position == 'admin gudang' AND $value['status'] != '101' AND $value['kanibal_fin'] == '1') { ?>
      <table>
      <td><a href="<?php echo site_url('c_tablesps_admin/selesai/'.$idSPS); ?>" onclick="return confirm('Apakah anda yakin sudah melakukan QC, Job Costing & Item Transfer Accurate ?')"> 
        <button class="btn btn-info" >Total Finished</button></a></td> 
      <td style="padding: 10px; font-size: 12px;"><b>Tombol "Total Finish" ditekan ketika barang yang dikanibal sudah dilengkapi kembali, rapi, packing seperti semula (siap dijual kembali) dan sudah di-job costing & item transfer. Sehingga stock accurate akan kembali seperti semula dan sesuai fisik barangnya.</b></td></table>
   
  <?php }else{ 
      echo '<input type= "hidden">';
    } ?>
 

<!-- TAMPILAN UNTUK TOMBOL NEXT TO -->
		<?php 
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$roleID = $_SESSION['myuser']['role_id'];
		$position = $_SESSION['myuser']['position_id'];
		$idSPS = $this->uri->segment(3);

	   $sql = "SELECT a.sales_id, a.status, b.karyawan_id, c.overto, c.overto_type, d.pause, a.free_servis, a.status_free FROM tbl_sps as a JOIN tbl_loginuser as b ON a.status = b.karyawan_id
		JOIN tbl_sps_overto as c ON c.sps_id = a.id 
		JOIN tbl_sps_log as d ON d.id_sps = a.id WHERE a.id = $idSPS ORDER BY d.id DESC";
		$query = $this->db->query($sql);
		$a = $query->row_array();

		if(($a['status'] != '101') AND ($a['pause'] != 1 )){ 
			//if($a['status_free'] != '2') {
				if($roleID == 3 OR $position == 58 OR $a['sales_id'] == $karyawanID OR ($karyawanID == $a['status'] AND ($roleID == '1' OR $roleID == '2'))){  ?>
					<a href="<?php echo site_url('c_tablesps/overto/'.$this->uri->segment(3).'  '); ?>"><input type="button" class="btn btn-info" value="Next to"></a>
				<?php }elseif(($a['status'] == $karyawanID) && ($roleID != 2)) {  ?>
					<a href="<?php echo site_url('c_tablesps/overto/'.$this->uri->segment(3).'  '); ?>"><input type="button" class="btn btn-info" value="Next to"></input></a>
				<?php }else{  ?>
					<input type ="hidden" >
				<?php }
			//}elseif($position == '9' AND $a['status_free'] == '0') { ?>
				<!-- <a href="<?php //echo site_url('c_tablesps/apprv_servis/1/'.$idSPS); ?>" class="btn btn-success" onclick="return confirm('Anda menekan Tombol Approved. Lanjutkan ?')">Approved</a>&nbsp; &nbsp;
				<button class="btn btn-danger" data-toggle="modal" data-target="#myModalNotAppr">Not Approved</button> -->
			<?php // }
		} ?>
	</div>

	<div class="modal fade" id="myModalNotAppr" role="dialog" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" method="post" action="<?php echo site_url('c_tablesps/apprv_servis/2/'.$idSPS); ?>">
					<div class="modal-header">
						<h4>Alasan Not Approved</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-12">
								<textarea class="form-control" rows="4" name="ket_notappr" required="true" id="not_approve"></textarea>
							</div>
						</div>
					</div>
		 
					<div class="modal-footer">
						<input type='submit' class='btn btn-info pull-left submit_btn' value='Submit'>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>

    <div class="bs-callout bs-callout-danger" >
		<div style="overflow: hidden;">
			<div style="float: left;">
				<h4>Ketentuan SOP SPS : </h4>			
			</div>	
			<?php if(in_array($_SESSION['myuser']['position_id'], array('1','2', '14', '77'))) {
				echo '&nbsp; &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ketentuan" title="Edit"><span class="fa fa-edit"></span></button>';
			} ?>
		</div>	
	  	<div>
      	<?php if ($ketentuan)
		{ ?>
			<div style="font-size: 10px;">
				Last Update  : <?php $format = date('d-m-Y H:i:s', strtotime($ketentuan["date_created"] ));	echo $format;?>
				<br>
				By	 : <b> <?php echo $ketentuan["nickname"];?></b>
			</div>
			<br>
			<div style="font-size: 13px;">
				<?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?>
			</div>
			
			<?php  } ?>
    	</div>
	</div>
	<!-- modal ketentuan -->
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
             			<textarea type="text" id="fr2" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
			 			<input type="hidden" value="3" name="nama_modul">
			 			<input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
            		</div>
           <!-- footer modal -->
            		<div class="modal-footer">
              			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              			<input type="submit" class="btn btn-primary" value="simpan">
                    </div>
            	</form>
          	</div>
        </div>
      </div>
	
</div>

 
<script type="text/javascript">
  $( document ).ready(function() {
    
    $("#data_time").load("<?php echo site_url('c_tablesps/data/'.$idSPS.''); ?>");
 
    $("#desc").load("<?php echo site_url('c_tablesps_admin/description/'.$idSPS.'') ?>");

    $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          		'<label class="control-label col-sm-2"></label>'+
          		'<div class="controls col-sm-8">'+
            		'<input class="" type="file" name="userfile[]">'+
          		'</div>'+
          		'<div class="col-sm-2">'+
            		'<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
            		'&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+  
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

  });
        </script>