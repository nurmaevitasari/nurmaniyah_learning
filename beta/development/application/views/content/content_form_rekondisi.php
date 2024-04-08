<div class="form-group">
			<label class="control-label col-sm-2">Divisi</label>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhc" required=""> DHC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dre" required=""> DRE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">	
						<input type="radio" name="divisi" value="dce" required=""> DCE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhe" required=""> DHE
					</div>
				</div>
				<div class="col-md-1">	 
					<div class="radio">
						<input type="radio" name="divisi" value="dgc" required=""> DGC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dee" required=""> DEE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dwt" required=""> DWT
					</div>
				</div>
		</div>
		
		<div class="form-group row">
			<label class="control-label col-sm-2 memo">No. Memo</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="no_sps" required>
			</div>
	
		
			<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" name="date_open" readonly="readonly" />
				<input type="hidden" name="customer_id" value="1563">
			</div> 
		</div>		
		
		<div class="form-group">
			<label class="control-label col-sm-2" >Tipe Produk </label>
				<div class="col-sm-8">
					<select class="form-control" name="product_id[]" id="product_id" required="required" data-placeholder = "ABC-123-01" multiple="true" >
						<option value="">-Pilih Produk-</option>
						<!-- <?php 
							/* if($product_id)
							{
								foreach($product_id as $row)
								{ ?>
									<option <?php if(!empty($c_new_sps['product_id'])){ 
										if($c_new_sps['product_id'] == $row['id']){
											?> selected <?php 
											}
										} ?> value="<?php echo $row['id']; ?>">
										<?php echo $row['kode']; ?> : <?php echo $row['product']; ?>
									</option>
									<?php 
								}	
							} */ ?> -->
					</select>
				</div>
		</div>

		<!-- <div class="form-group row">
			<label class="control-label col-sm-2">Nama Produk  </label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="product_name" id="product_name" readonly="readonly" >
				</div>
		</div> -->
					
		<div class="form-group row serial">
			<label class="control-label col-sm-2">S/N Produk </label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="no_serial" id="no_serial" required>
			</div>
		</div>	

		<div class="form-group row">
			<label class="control-label col-sm-2" id="area">Area Rekondisi</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="areaservis" id="areaservis" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2" id = "freq">Frekuensi Rekondisi</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="frekuensi" required><p style="font-size : 12px;">*Untuk kasus yang sama</p>
			</div>

			<label class="control-label col-sm-3" id = "schedule">Pengajuan Schedule Rekondisi</label>
			<div class="col-sm-3">
				<input type="text" name="jadwal_service" class="form-control" id="jadwal_service" placeholder="dd/mm/yyyy" required><p style="font-size : 12px;">*schedule real ditentukan admin service</p>
			</div>

		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Instruksi Rekondisi</label>
			<div class="col-sm-8">
				<textarea name="sps_notes" id="InputMessage" class="form-control" rows="4" required></textarea><p style="font-size: 11.5px;">*Instruksi wajib diisi lengkap dan jelas sehingga mudah dimegerti oleh tim pelaksana. <br /> 
				&nbsp Instruksi yang tidak jelas bisa mengakibatkan pekerjaan terhambat karena salah pemahaman. <br />
				&nbsp Gunakan bahasa Indonesia yang baik & benar agar mudah dimengerti semua orang.<br />
				&nbsp Dilarang menggunakan singkatan dan istilah-istilah bahasa pergaulan.</p>
			</div>
		</div>
		<div class="form-group row file-row" id="file-row-1">
			<label class="control-label col-sm-2">Upload Foto/File</label>
			<div class="controls col-sm-7">
				<input class="" type="file" name="userfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row">

		</div>
		
		<br>
		<br>
		<br>
		
		<div class="form-group row overto">
	     	<label class="control-label col-sm-2">Over To :</label>
	      	<div class="col-sm-8">
	        	<select class="form-control" name="overto" id="overto" required="required" data-placeholder="<?php echo $_SESSION['myuser']['nama']?>">
	                <option value="">-Pilih-</option>
	                  <?php 
	                    if($operator)
	                    {
	                    foreach($operator as $row)
	                    {
	                    ?>
	                    <option <?php if(!empty($c_new_sps['id_operator'])){ if($c_new_sps['id_operator'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>">
	                    <?php echo $row['nama']; ?>
	                    </option>
	                    <?php 
	                    } 
	                    }
	                    ?>
	            </select>
      		</div>
      	</div>	
    
    <div class="form-group row overto">
      <label class="control-label col-sm-2">Posisi :</label>
      <div class="col-sm-8">
         <input type="text" class="form-control" name="overtotype" readonly="readonly" id="overtotype">
      </div>
    </div>
		
	<div class="form-group row overto">
      <label class="control-label col-sm-2">Message :</label>
      <div class="col-sm-8">
        <textarea type="text" class="form-control" name="message" value="" required=""></textarea>
      </div>
    </div>

    <hr />
    <div class="form-group col-sm-10" style="margin-left: 5px;">
    	<h4><b>Input Bobot Job</b></h4>
    	<p style="font-size: 12px;" >Sales wajib mengisi input bobot job dengan baik dan benar agar teknisi mendapat point yang sesuai dengan pekerjaan yang dilakukan, sehingga dapat berguna untuk meningkatkan kinerja tim teknisi secara maksimal.</p>
    </div>
    
    <div class="form-group row">
    	<label class="control-label col-sm-3">Perkiraan Lama Pekerjaan</label>
			<div class="col-sm-1">
				<div class="input-group" style="width : 80px;">
					<input type="text" class="form-control" required="required" name="days">
					<div class="input-group-addon">
						<span class="control-label">D</span>
					</div>
				</div>
			</div>

			<div class="col-sm-1">
				<div class="input-group" style="width : 80px;">
					<input type="text" class="form-control" required="required" name = "hours">
					<div class="input-group-addon">
						<span class="control-label">H</span>
					</div>
				</div>
			</div>

			<div class="col-sm-1">
				<div class="input-group" style="width : 80px;">
					<input type="text" class="form-control" required="required" name = "minutes">
					<div class="input-group-addon">
						<span class="control-label">M</span>
					</div>
				</div>
			</div>
	</div>

	
	<p style="font-size: 12px; margin-left: 24%;" class="col-sm-7">** Lama pekerjaan adalah termasuk menginap (jika harus menginap). Misalnya  pekerjaan di Banjarmasin harus menginap 2 malam, maka dihitung 2 hari.</p>
	<p style="font-size: 12px; margin-left: 24%;" class="col-sm-7" >** Pekerjaan yang tidak menginap cukup diisi perkiraan lama pekerjaan dalam H (Hours) atau M (Minutes).</p>

	<div class="form-group row">
		<label class="control-label col-sm-3">Tingkat Kesulitan Job (Skala 0-10)</label>
		<div class="col-sm-1">
			<input type="text" name="hard_level" class="form-control" required="required"/>
		</div>
	</div>
	<div class="col-sm-12">	
		<p style="font-size: 12px; margin-left: 24%;" class="col-sm-7">** Tingkat kesulitan job bersifat relatif, tergantung penilaian sales sendiri. Bagi sales junior yang belum mengerti cara mengisi skala tingkat kesulitan dapat bertanya ke sales senior.
		</p>
		<br /><br /> 
	</div>