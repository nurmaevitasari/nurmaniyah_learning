<?php $user = $this->session->userdata('myuser'); ?>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>FORM EDIT IMP </h2>
        </div>
    </div>              
    <hr />
	
	<form class="form-horizontal" method="POST" role="form" action="<?php echo site_url($action);  ?>" enctype="multipart/form-data">
		<h4><?php echo $this->session->flashdata('message'); ?></h4>
		<br /><br />
	
		<div class="form-group row">
			<label class="control-label col-sm-2">Penempatan</label>
			<div class="col-sm-4">
				<select class="form-control" name="penempatan" id="penempatan">
					<option value="">-Pilih-</option>
					<option value="Cabang Bandung" <?php if($edit['penempatan'] == "Cabang Bandung"){ ?> selected <?php } ?> >Cabang Bandung</option>
					<option value="Cabang Medan" <?php if($edit['penempatan'] == "Cabang Medan"){ ?> selected <?php } ?>>Cabang Medan</option>
					<option value="Cabang Surabaya" <?php if($edit['penempatan'] == "Cabang Surabaya"){ ?> selected <?php } ?>>Cabang Surabaya</option>
					<option value="Gudang Dadap" <?php if($edit['penempatan'] == "Gudang Dadap"){ ?> selected <?php } ?>>Gudang Dadap</option>
					<option value="Gudang Surabaya" <?php if($edit['penempatan'] == "Gudang Surabaya"){ ?> selected <?php } ?>>Gudang Surabaya</option>
					<option value="Pusat" <?php if($edit['penempatan'] == "Pusat"){ ?> selected <?php } ?>>Pusat</option>
				</select> 
			</div>
		

			<label class="control-label col-sm-1">Nama</label>
			<div class="col-sm-4">
				<select class="form-control" name="nama" id="nama">
					<option value="">-Pilih-</option>
						<?php if($karyawan)
						{
							foreach ($karyawan as $employee) 
							{ ?>
								<option  value="<?php echo $employee['id']; ?>" 
								<?php if(!empty($edit['id_karyawan']))
								{ 
									if($edit['id_karyawan'] == $employee['id'])
									{ ?> selected 
								<?php }
								} ?> > <?php echo $employee['nama']; ?></option>	
						<?php	}
							} ?>
				</select>
			</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-sm-2">Keperluan</label>
			<div class="col-sm-9">
				<select class="form-control" name="keperluan" id="keperluan" required="required">
					<option value="">-Pilih-</option>
					<option value="1" <?php if($edit['keperluan'] == "1"){ ?> selected <?php } ?>>Cuti Tahunan</option>
					<option value="2" <?php if($edit['keperluan'] == "2"){ ?> selected <?php } ?>>Hutang Cuti</option>
					<option value="3" <?php if($edit['keperluan'] == "3"){ ?> selected <?php } ?>>Izin</option>
					<option value="4" <?php if($edit['keperluan'] == "4"){ ?> selected <?php } ?>>Sakit</option>
					<option value="5" <?php if($edit['keperluan'] == "5"){ ?> selected <?php } ?>>Tugas Luar Kota</option>
				</select>
			</div>
		</div>

		<div class="form-group" id="tgl_wkt">
			<label class="control-label col-sm-2">Jangka Waktu</label>
				<div class="col-sm-2">
					<div class="input-group" style="width : 141px;">
    					<input type="text" class="form-control" name="hari" id = "hari" value="<?= !empty($edit['hari']) ? $edit['hari'] : '0'; ?>">

    						<div class="input-group-addon">
        						<span class="control-label"> Hari</span>
    						</div>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="input-group" style="width : 141px;">
    					<input type="text" class="form-control" name="jam" id="jam" value="<?= !empty($edit['jam']) ? $edit['jam'] : '0'; ?>">
    						<div class="input-group-addon">
        						<span class="control-label"> Jam</span>
    						</div>
					</div>
				</div>	
			
			<label class="control-label col-sm-1" >Tanggal</label>
			<div class="col-sm-4">
				<div class="input-group">
					<input type="text" class="form-control col-sm-1" name="tgl_awal" id="tgl_awal" value="<?php if(!empty($edit['tgl_awal'])){ echo date("d/m/Y", strtotime($edit['tgl_awal'])); } ?>">
						<div class="input-group-addon">
							<span class="control-label">sampai</span>
						</div>
					<input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control col-sm-1" value="<?php if(!empty($edit['tgl_akhir'])){ echo date("d/m/Y", strtotime($edit['tgl_akhir'])); } ?>">	
				</div>
			</div>
		</div>	

		<div class="form-group row file-row">
			<label class="control-label col-sm-2">Keterangan</label>
			<div class="controls col-sm-9 ">
				<textarea class="form-control" type="text" name="keterangan" id = "ket" rows="3" ><?= !empty($edit['keterangan']) ? $edit['keterangan'] : ''; ?></textarea> 
			</div>		
		</div>

		<div class="form-group row file-row">
			<label class="control-label col-sm-2">Notes</label>
			<div class="controls col-sm-9 ">
				<textarea class="form-control" type="text" name="notes" id = "note" rows="3" ><?= !empty($edit['notes']) ? $edit['notes'] : ''; ?></textarea> 
			</div>		
		</div>		


		<br />	
	
			<span class="col-sm-2"></span>&nbsp;<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />
			<a href="<?php echo site_url('c_imp');?>" type="button" name="back" class="btn btn-default">Back</a>
    </form>	
</div> 

<script type="text/javascript">
	
	$('#tgl_awal, #tgl_akhir').datetimepicker({
		format: 'DD/MM/YYYY',
	});

	$( "#nama" ).change(function() {
  		var id = $(this).val();
 		$.ajax({
      		type : 'POST',
      		url : '<?php echo site_url('c_imp/getKaryawan'); ?>',
      		data : {
        		data_id : id,
      	},
      	dataType : 'json',
      	success : function (data){
        	$('#posisi').val(data.position);       
      	},
      	error : function (xhr, status, error){
        	console.log(xhr);
      	}
  		});
	});

	$(document).ready

</script>
