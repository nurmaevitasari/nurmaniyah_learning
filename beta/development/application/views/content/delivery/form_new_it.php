<?php $user = $this->session->userdata('myuser'); 
?>
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
			<h2>Delivery Khusus Transfer</h2>
			<p>( Hanya digunakan untuk Item Transfer antar Gudang Indotara. Tidak untuk pengiriman ke customer )</p>
        </div>
    </div>              
    <hr />
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_delivery/add/it');  ?>" enctype="multipart/form-data" onsubmit="this.btn_save.disabled = true; this.btn_save.val = 'Saving...'; ">
			<h4><?php echo $this->session->flashdata('message'); ?></h4>
			<label>** Diisi Sesuai dengan Accurate **</label>
		<br>
		<br>
		<input type="hidden" name="jenis" value="<?php echo $this->uri->segment(2); ?>">

		<div class="form-group">
			<label for="InputDate" class="control-label col-sm-2">Tanggal </label>
			<div class="col-sm-2" >
				<input type="text" class="form-control"	 value="<?php echo date('d-m-Y'); ?>" name="date_created" readonly="true" />
			</div> 
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama Karyawan</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="disabledInput" name="sales_name" readonly="readonly" value="<?php echo $user['nama']; ?>">
					<input type="hidden" class="form-control" id="disabledInput" name="sales_id" value="<?php echo $user['karyawan_id']; ?>">	
				</div>
		</div> 

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
		
		<div class="form-group">
			<label class="control-label col-sm-2">Memo</label>
			<div class="col-sm-4">
					<input type="text" name="no_memo" class="form-control cl-memo" id="no_memo" required="true">
				</div>
			<!-- <div class="col-md-1">	 
					<div class="radio">
						<input type="radio" name="rad" value="so" class="rad"> SO
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="rad" value="memo" class="rad"> Memo
					</div>
				</div> -->


			<!-- <span class="no so">
			<label class="control-label col-sm-2">SO</label>
				<div class="col-sm-1">
					<input type="text" class="form-control cl-so" name="no_so1" id="no_so1">
				</div>
				<p style="font-size: 20px; width: 10px;" class="col-sm-1">/</p>
				<div class="col-sm-1">
					<input type="text" class="form-control cl-so" name="no_so2" id="no_so2">
				</div>
				<p style="font-size: 20px; width: 10px;" class="col-sm-1">/</p>
				<div class="col-sm-1" style="width: 110px;">
					<input  type="text" class="form-control cl-so" name="no_so3" id="no_so3">
				</div>
			</span> -->

			<!-- <span class="no memo">
			<label class="control-label col-sm-2">Memo</label>
				<div class="col-sm-4">
					<input type="text" name="no_memo" class="form-control cl-memo" id="no_memo">
				</div>
			</span> -->
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Item Transfer / IT</label>
			<div class="col-sm-1">
				<input type="text" class="form-control" name="it1" id="it1">
			</div>
			<p style="font-size: 20px; width: 10px;" class="col-sm-1" >/</p>
			<div class="col-sm-1">
				<input type="text" class="form-control" name="it2" id="it2">
			</div>
			<p style="font-size: 20px; width: 10px;" class="col-sm-1">/</p>
			<div class="col-sm-1" style="width: 110px;">
				<input  type="text" class="form-control" name="it3" id="it3">
			</div>
			<!-- <div class="col-sm-4" style="font-size: 12px;">
				** Diisi jika diperlukan **
			</div> -->
		</div>	
		
		<!-- <div class= "form-group">
			<label class="control-label col-sm-2" >Lampiran Form QC</label>
			<div class="col-sm-8">
				<select name="qcfile[]" id="qcfile" class="form-control" multiple="true">
					<option value="">-Pilih-</option>
									
				</select>
			</div>
		</div> -->

		<div class= "form-group">
            <label class="control-label col-sm-2" >Lampiran Form QC</label>
            <div class="col-sm-8">
                <select name="qcfile[]" class="form-control" id="qcfile" multiple="true">
                     <option value="">-Pilih-</option>
                </select>
            </div>
        </div>

		<div class="form-group" >
			<label class="control-label col-sm-2" >Metode Kirim</label>
			<div class="col-sm-8">
				<select name="pengiriman" class="form-control" id="pengiriman">
					<option value="">-Pilih-</option>							
					<option value="customer">Customer Jemput</option>								
					<option value="dhl">DHL</option>																	
					<option value="ekspedisi">Ekspedisi</option>
					<option value="gobox">GoBox</option>
					<option value="gocar">GoCar</option>
					<option value="gosent">GoSent</option>
					<option value="grabbike">GrabBike</option>
					<option value="indotara">Indotara</option>
					<option value="jne">JNE</option>
					<option value="j&t">J&T </option>
					<option value="pos">Pos Indonesia</option>
					<option value="tiki">TIKI</option>
					<option value="titip Indotara">Titip Indotara</option>
					<option value="wahana">Wahana</option>
				</select>
				<span style="font-size: 11px;">note : "Titip Indotara adalah pengiriman yang sifatnya titipan ke tim driver indotara, hanya akan dikirim jika ada arah yang sama & berdekatan (tidak ada jadwal pasti)</span>
				<input id="eksp" type="hidden" class="form-control" name="ekspedisi" placeholder="Masukan Jenis Ekspedisi..">
			</div>						
		</div>
		
		<!-- <div class="form-group customer">
			<label class="control-label col-sm-2">Customer  </label>
				<div class="col-sm-8">
					<select class="form-control" name="customer_id" id="customer_id" required="true" data-placeholder="C-0784-IDR : PT. INDOTARA PERSADA">
					<option value="">-Pilih Customer-</option>
						<?php 
							/*  if($customer)
							{
								foreach($customer as $row)
								{ ?>
									<option value="<?php echo $row['id']; ?>">
											<?php echo $row['id_customer'] ?> : <?php echo $row['perusahaan']?>
									</option>
								<?php 
								}	
							} */ ?>
					</select>
				</div>
		</div> -->

		<div class="form-group customer">
			<label class="control-label col-sm-2">Tujuan  </label>
				<div class="col-sm-8">
					<input class="form-control" disabled="true" value="C-0784-IDR : PT. INDOTARA PERSADA">
					<input type="hidden" value="1563" name="customer_id" id="customer_id">
				</div>
		</div> 

		<div class="form-group row">
			<label class="control-label col-sm-2">PIC  </label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="pic" id="pic" required="true">
				</div>

			<label class="control-label col-sm-2">Telepon  </label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="telepon" id="telepon" required="true">
				</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Alamat  </label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="alamat" id="alamat" required="true"></textarea>
				</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2" >Tipe Produk </label>
			<div class="col-sm-8">
				<select class="form-control" name="product[]" id="product_id" required="true" data-placeholder = "MH-0001" multiple="true">
					<option value="">-Pilih Produk-</option>
					<?php 
						 if($product)
						{
							foreach($product as $row)
							{ ?>
								<option value="<?php echo $row['id']; ?>">
									<?php echo $row['kode']; ?> : <?php echo $row['product']; ?>
								</option>
								<?php 
							}	
						}  ?> 
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Tanggal Kirim</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="tgl_estimasi" id="tgl_estimasi" required="true">
			</div>
			<label class="control-label col-sm-2" style="padding-top: 0px;">Nilai Transaksi (include PPn) (RP)</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="transaksi" id="transaksi" required="true" onkeyup="splitInDots(this)">
			</div>
		</div>
					
		<div class="form-group row">
			<label class="control-label col-sm-2">Catatan</label>
			<div class="col-sm-8">
				<textarea name="notes" id="InputMessage" class="form-control" rows="4" required></textarea>
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
		<hr />
		
		<div class="form-group row overto">
	     	<label class="control-label col-sm-2">Over To :</label>
	      	<div class="col-sm-8">
	        	<select class="form-control" name="overto" id="overto" required="true">
	                <option value="">-Pilih-</option>
                  	<?php 
                    if($operator)
                    {
                    	foreach($operator as $row)
                    	{ ?>
                    	<option value="<?= $row['id']; ?>"><?php echo $row['nama']; ?></option>
                    	<?php 
                    	} 
                    } ?>
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
        <textarea type="text" id="msg" class="form-control" name="message" required="true"></textarea>
      </div>
    </div>

    <hr />
    <h3>Reminder Service</h3>
    <p style="font-size: 12px;">*Reminder service bersifat opsional. Diisi apabila item perlu dilakukan service secara berkala dalam jangka waktu tertentu.*<br /> *Sistem secara otomatis mengirim email ke customer.*</p><br />
    <div class="form-group">
    	<label class="control-label col-sm-2">Email Customer</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="email_cust">
		</div>

      	<label class="control-label col-sm-2">Jangka Waktu</label>
    	<div class="col-sm-2">
    		<div class="input-group">
    			<input type="text" class="form-control" name="jangka_wkt">
    			<div class="input-group-addon">
        			<span class="control-label"> Hari</span>
    			</div>
    		</div>
    	</div>
    </div>
   
    	
   


		<input type="submit" name="btn_save" id="submit" value="Save" class="btn btn-info" />	
		
    </form>	
</div> 



<script type="text/javascript">

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

$(document).ready(function() {

	CKEDITOR.instances['alamat'].destroy();
	$('#product_id, #overto').select2({
	    minimumInputLength : 2
	});

	/* $("#customer_id").select2({
		tags: true,
		ajax: {
			url: "<?php //echo site_url('c_new_sps/ajax_cust'); ?>",
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
	                    'text': item.id_customer + " : " + item.perusahaan
	                });
	            });
	            return {
	                results: myResults
	            };	
			},
			cache: true
		},
		minimumInputLength: 3
	}); */

	//$(".no").hide();

    $('input[name="rad"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".no").not(targetBox).hide();
        $(targetBox).show();
        $(".cl-"+inputValue).toUpperCase();
        $(".cl-"+inputValue).prop("required", true);
    });

	$( "#customer_id" ).change(function() {
		var id = $(this).val();
		$.ajax({
		  	type : 'POST',
		  	url : '<?php echo site_url('c_new_sps/getCustomer'); ?>',
		  	data : {
		  		data_id : id,
		  	},
		  	dataType : 'json',
		  	success : function (data){
			  			
	  		if(data.pic == '' && data.telepon == '' && data.alamat == ''){
	  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
	  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
	  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
	  		}else if(data.telepon == '' && data.alamat == ''){
	  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
	  			$('#pic').val(data.pic).prop('readonly', true);
	  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
	  		}else if (data.pic == '' && data.alamat == ''){
	  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
	  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
	  			$('#telepon').val(data.telepon).prop('readonly', true);
	  		}else if(data.pic == '' && data.telepon == ''){
	  			$('#alamat').val(data.alamat).prop('readonly', true);
	  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
	  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
	  		}else if(data.alamat == ''){
	  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
	  			$('#pic').val(data.pic).prop('readonly', true);
	  			$('#telepon').val(data.telepon).prop('readonly', true);		
	  		}else if(data.telepon == ''){
	  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
	  			$('#pic').val(data.pic).prop('readonly', true);
	  			$('#alamat').val(data.alamat).prop('readonly', true);
	  		}else if(data.pic == ''){
	  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
	  			$('#alamat').val(data.alamat).prop('readonly', true);
	  			$('#telepon').val(data.telepon).prop('readonly', true);	
	  		}else{
	  			$('#telepon').val(data.telepon).prop('readonly', true);;
	  			$('#pic').val(data.pic).prop('readonly', true);;
	  			$('#alamat').val(data.alamat).prop('readonly', true);;
	  		}	
		  			
		  	},
		  	error : function (xhr, status, error){
		  		console.log(xhr);
		  	}
		});
	});

	$( "#overto" ).change(function() {
  		var id = $(this).val();
 		$.ajax({
      		type : 'POST',
      		url : '<?php echo site_url('c_new_sps/getOverTo'); ?>',
      		data : {
        		data_id : id,
      	},
      	dataType : 'json',
      	success : function (data){
        	//console.log(data);
        	$('#overtotype').val(data.role);       
      	},
      	error : function (xhr, status, error){
        	console.log(xhr);
      	}
  		});
	});

	$("#tgl_estimasi").datetimepicker({
  		format: 'DD/MM/YYYY',
  		useCurrent : false
	});

	$('body').delegate('.btn-add-file', 'click', function(){
		var id = $(this).data('id');

		var length = $('.file-row').length;

		html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
				'<label class="control-label col-sm-2">&nbsp;</label>'+
				'<div class="controls col-sm-7">'+
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

	//called when key is pressed in textbox
  	$("#no_so1, #no_so2, #no_so3, #it1, #it2, #it3, #transaksi").keypress(function (e) {
	  	length_so =   $("#no_so1, #no_so2, #no_so3, #it1, #it2, #it3").length;
	     //if the letter is not digit then display error and don't type anything
	    
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        alert("Number Only !");
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
    	}
   	});	

   	$( "input[name='divisi']" ).click(function() {
		var div = $(this).val();
		$.ajax({
		  	type : 'POST',
		  	url : '<?php echo site_url('c_delivery/getQC'); ?>',
		  	data : {
		  		divisi : div,
		  	},
		  	dataType : 'json',
		  	success : function (data){
			$('#qcfile').empty();
				$.each(data, function(i, value) {
					$('#qcfile').append($('<option>').text(value.file_name).attr('value', value.file_name)); 	
				});
		  	},
		  	error : function (xhr, status, error){
		  		console.log(xhr);

		  	}
		});
		
	});

	$("#pengiriman").change(function() {

		if($(this).val() == 'ekspedisi') {
			$("#eksp").attr('type', 'text');
			$("#eksp").attr('required', true);
		}else {
			$("#eksp").attr('type', 'hidden');
			$("#eksp").attr('required', false);
		}

	});	
});

</script>