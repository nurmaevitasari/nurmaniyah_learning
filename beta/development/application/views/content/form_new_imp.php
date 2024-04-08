<?php $user = $this->session->userdata('myuser'); ?>

<style type="text/css">

 @media screen and (max-width: 767px) {
    .select2 {
        width: 100% !important;
    }
} 

</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Form New IMP </h2>
        </div>
    </div>              
    <hr />
	
	<form class="form-horizontal" method="POST" role="form" action="<?php echo site_url('C_imp/add');  ?>" enctype="multipart/form-data">
		<h4><?php echo $this->session->flashdata('message'); ?></h4>
		<br /><br />
	
		<div class="form-group row">
			<label class="control-label col-sm-2">Penempatan</label>
			<div class="col-sm-9">
				<select class="form-control sel" name="penempatan" id="penempatan" required="required">
					<option value="">-Pilih-</option>
					<option value="Cabang Bandung">Cabang Bandung</option>
					<option value="Cabang Medan">Cabang Medan</option>
					<option value="Cabang Surabaya">Cabang Surabaya</option>
					<option value="Gudang Cikupa">Gudang Cikupa</option>
					<option value="Pusat">Pusat</option>
				</select>
			</div>
		</div> 

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama</label>
			<div class="col-sm-4">
				<select class="form-control" name="nama" id="nama" required="required">
					<option value="">-Pilih-</option>
						<?php if($karyawan){
							foreach ($karyawan as $employee) { ?>
								<option value="<?php echo $employee['id']; ?>"><?php echo $employee['nama']; ?></option>	
						<?php	}
							} ?>
				</select>
			</div>

			<label class="control-label col-sm-1">Posisi</label>
			<div class="col-sm-4">
				<input type="text" name="posisi" readonly="readonly" id="posisi" class="form-control">
			</div>
		</div>

		<div class="form-group row"> 
			<label class="control-label col-sm-2">Keperluan</label>
			<div class="col-sm-9">
				<select class="form-control sel" name="keperluan" id="keperluan" required="required">
					<option value="">-Pilih-</option>
					<option value="1">Cuti Tahunan</option>
					<option value="2">Hutang Cuti</option>
					<option value="3">Izin</option>
					<option value="4">Sakit</option>
					<option value="5">Tugas Luar Kota</option>
				</select>
			</div>
		</div>

		<div class="form-group" id="tgl_wkt">
			<label class="control-label col-sm-2">Jangka Waktu</label>
				<div class="col-sm-2">
					<div class="input-group" style="width : 141px;">
    					<input type="text" class="form-control" name="hari" id = "hari" required="required">
    						<div class="input-group-addon">
        						<span class="control-label"> Hari</span>
    						</div>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="input-group" style="width : 141px;">
    					<input type="text" class="form-control" name="jam" id="jam" required="required">
    						<div class="input-group-addon">
        						<span class="control-label"> Jam</span>
    						</div>
					</div>
				</div>	
			
			<label class="control-label col-sm-1" >Tanggal</label>
			<div class="col-sm-4">
				<div class="input-group">
					<input type="text" class="form-control col-sm-1" name="tgl_awal" id="tgl_awal" required="required">
						<div class="input-group-addon">
							<span class="control-label">sampai</span>
						</div>
					<input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control col-sm-1" required="required">	
				</div>
			</div>
		</div>	

		<div class="form-group row file-row" id="file-row-1">
			<label class="control-label col-sm-2">Upload File</label>
			<div class="controls col-sm-8 ">
				<input  type="file" name="userfile[]" id = "files">
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row">

		</div>

		<div class="form-group row file-row">
			<label class="control-label col-sm-2">Keterangan</label>
			<div class="controls col-sm-9 ">
				<textarea class="form-control" type="text" name="keterangan" id = "ket" rows="3"></textarea> 
			</div>		
		</div>
		<br />	

		<div class="form-group" style="font-size : 13px;">
		<label class="control-label col-sm-2"></label>
		<ul class="list-unstyled col-sm-10">
		<li><b>Keterangan : </b></li>
			<ul >
				<li>Hutang Cuti akan memotong gaji proporsional per gaji 1 hari.</li>
				<li>Hutang Cuti diperuntukan kondisi mendesak saja.</li>
				<li>Karyawan yang belum memiliki jatah cuti, apabila mengajukan cuti akan dianggap hutang cuti.</li>
				<li>Izin hanya diberikan dengan catatan karyawan bekerja di kantor minimal 4 jam.</li>
				<li>Sakit harus upload surat sakit (scan dalam format pdf).</li>
				<li>Tugas luar kota harus upload scan surat perintah service dalam format pdf.</li>

			</ul>
		</ul>
		</div>	
	
			<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info" />
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

	 $('body').delegate('.btn-add-file', 'click', function(){
			var id = $(this).data('id');

			var length = $('.file-row').length;

			html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
					'<label class="control-label col-sm-2">&nbsp;</label>'+
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

</script>
