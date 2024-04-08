<?php 
	$user = $this->session->userdata('myuser');
	$newtool = $this->session->flashdata('newtool'); ?>

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
			<h2>Form New Tools</h2>
			<p style="font-size: 12px;">
				** Setiap tools hanya boleh dibuat per buah atau per set (kuantitas tunggal). <br /> 
				** Setiap tools secara fisik harus diberi ID yang sama dengan ID My Tools iios.
			</p>
        </div>
    </div>              
    <hr />
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_tools/new_tool');  ?>" enctype="multipart/form-data" >
			<?php if($newtool){
				echo "<div class='alert alert-success'>
						<span class='fa fa-check-circle fa-lg'></span> ".$newtool['code']." : ".$newtool['name']." berhasil ditambahkan
						<span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
					</div>";
				} ?>
				
			
		<br>
		<br>
		
		<?php 
			$count = $mtools->idTool(date('Y-m'));
			
			$cou = $count + 1;
			$co = sprintf("%06s", $cou);
			$idtools = "A".$co;
		?>
		<div class="form-group row">
			<!-- <label class="control-label col-sm-2 memo">Tools ID </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="code_tool" id="code_tool" readonly="true" value="<?php //echo $idtools; ?>">
			</div> -->
		
			<label class="control-label col-sm-2">Kode Asset</label>
			<div class="col-sm-4">
				<input type="text" name="kode_asset" class="form-control">
				<p style="font-size: 10px;">*diisi jika terdapat kode asset pada accurate.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Name </label>
			<div class="col-sm-9" >
				<input type="text" class="form-control" name="name_tool" required="true" />
			</div> 
		</div>

		<div class="form-group row file-row-pht" id="file-row-pht-1">
			<label class="control-label col-sm-2">Photo Tool</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="phtuserfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="pht" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-pht">

		</div>


		<div class="form-group row">
			<label class="control-label col-sm-2">Serial Number </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="s_num"  />
			</div> 

			<label class="control-label col-sm-1">Type </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="type"  />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Vendor </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="vendor" />
			</div> 

			<label class="control-label col-sm-1">Brand </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="brand" />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Purchased Date </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="purchased_date" id = "purchased_date" required="true" />
				<p style="font-size: 10px;">*diisi tanggal perkiraan jika data tidak ada.</p>
			</div> 

			<label class="control-label col-sm-1">Price </label>
			<div class="col-sm-4">
				<div class="input-group">
					<div class="input-group-addon">
    					<span class="control-label"> Rp</span>
					</div>
					<input type="text" class="form-control" name="harga" id = "harga"  onkeyup="splitInDots(this)" required="true">
						
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Manual Book </label>
			<div class="col-sm-1" >
				<div class="radio">
					<input type="radio" name="manual_book" value="1" required="true"> Ada
				</div>	
			</div>
			<div class="col-sm-2" >
				<div class="radio">
					<input type="radio" name="manual_book" value="0" required="true"> Tidak Ada
				</div>
			</div>
			
			<label class="control-label col-sm-2">Condition </label>
			<div class="col-sm-4" >
				<select class="form-control" name="condition" style="width: 100%;" required="true">
					<option value="">-Pilih-</option>
					<option value="100">100% - Baru</option>
					<option value="90">90% - Sangat Bagus</option>
					<option value="80">80% - Cukup Bagus</option>
					<option value="70">70% - Lumayan</option>					
					<option value="60">60% - Masih bisa dipakai</option>
					<option value="50">50% - Kurang Bagus</option>
					<option value="30">30% - Jelek</option>
					<option value="10">10% - Hancur</option>
				</select>
			</div>  
		</div>	

		<div class="form-group">
			<label class="control-label col-sm-2">Warranty Due </label>
			<div class="col-sm-2" >
				<input type="text" class="form-control" name="warranty_date" id="warranty_date"  /> 
			</div>

			<label class="control-label col-sm-3">Service Center Phone</label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="sc_phone"  /> 
			</div>  
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Quantity</label>
			<div class="col-sm-9">
				<input type="text" name="quantity" class="form-control" id="qty" required="true">
			</div>
		</div>

		<div class="form-group row file-row-warr" id="file-row-warr-1">
			<label class="control-label col-sm-2">Warranty Card</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="warruserfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="warr" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-warr">

		</div>
		<br />
		<div class="form-group row file-row-acs" id="file-row-acs-1">
			<label class="control-label col-sm-2">Accessoris</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="acsuserfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="acs" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-acs">

		</div>

		
		<div class="form-group">
			<label class="control-label col-sm-2">Note</label>
			<div class="col-sm-9">
				<textarea class="form-control" rows="4" name="notes" id="note"></textarea>
				<p style="font-size: 12px;">* Beri catatan penting mengenai tolls ini (jika ada). Misalnya perawatan atau pemakaian.</p>
			</div>
		</div>

		<div class="form-group">
			<!--<label class="control-label col-sm-2">Cabang</label>
				<div class="col-sm-4">
					<select class="form-control sel" name="cabang" id="cabang" required="required">
						<option value="">-Pilih-</option>
						<option value="Kantor Jakarta">Kantor Jakarta</option>
						<option value="Kantor Bandung">Kantor Bandung</option>
						<option value="Kantor Surabaya">Kantor Surabaya</option>
						<option value="Kantor Medan">Kantor Medan</option>
						<option value="Gudang Cikupa">Gudang Cikupa</option>
						<option value="Gudang Surabaya">Gudang Surabaya</option>
						<option value="Pusat">Pusat</option>
					</select>
				</div>	-->

				<label class="control-label col-sm-2">Holder</label>
				<div class="col-sm-9">
					<select class="form-control" name="holder" required="true">
						<option value="">-Pilih-</option>
						<?php foreach ($karyawan as $kar) { ?>
							<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
						<?php } ?>
					</select>
				</div>	
		</div>	

		
		<br>
		<button type="submit" class="btn btn-info">Submit</button>

	</form>
</div>


<script type="text/javascript">
	CKEDITOR.replace('note', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      	shiftEnterMode: CKEDITOR.ENTER_P
    });

	$("#purchased_date").datetimepicker({
		format : "DD/MM/YYYY",
	});

	function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }

	function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
      }

    var cat;
	$('body').delegate('.btn-add-file', 'click', function(){
		cat = $(this).attr('cat');

		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		html = '<div class="form-group row file-row-'+cat+'" id="file-row-'+cat+'-'+(length+1)+'">'+
				'<label class="control-label col-sm-2">&nbsp;</label>'+
				'<div class="controls col-sm-8">'+
					'<input class="" type="file" name="'+cat+'userfile[]">'+
				'</div>'+
				'<div class="col-sm-2">'+
					'<button type="button" cat="'+cat+'" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
					'&nbsp;&nbsp;<button type="button" cat="'+cat+'" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+						
				'</div>'+	
			'</div>';

		$('#add-row-'+cat).append(html);	
	});

	$('body').delegate('.btn-remove-file', 'click', function(){
		cat = $(this).attr('cat');
		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		if(length > 1)
		{
			$('#file-row-'+cat+'-'+id).remove();
		}	
	});	  
</script>
