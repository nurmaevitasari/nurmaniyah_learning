<?php $user = $this->session->userdata('myuser'); 
?>
<style type="text/css">
	.yellow{
		//background-color: yellow;
		width: auto;
	}	

	#dealvalue {
		display: none;
	}	
</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>FORM New CRM</h2>
        </div>
    </div>              
    <hr />
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('crm/add');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
		<?php echo $this->session->flashdata('message'); ?>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama Sales</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="disabledInput" name="sales_name" readonly="readonly" value="<?php echo $user['nama']; ?>">
				</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-sm-2">Divisi</label>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhc" required="true"> DHC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dre" required="true"> DRE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">	
						<input type="radio" name="divisi" value="dce" required="true"> DCE & DGC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhe" required="true"> DHE
					</div>
				</div>
				<!-- <div class="col-md-1">	 
					<div class="radio">
						<input type="radio" name="divisi" value="dgc" required="true"> DGC
					</div>
				</div> -->
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dee" required="true"> DEE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dwt" required="true"> DWT
					</div>
				</div>
		</div>
		
		<div class="form-group row">
			<label class="control-label col-sm-2">Customer  </label>
				<div class="col-sm-1">	 
					<div class="radio">
						<input type="radio" name="cust_type" value="0" required="true"> New
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="cust_type" value="1" required="true"> Existing
					</div>
				</div>

				<div class="col-sm-7" style="color:green; padding-top: 0.7%;">
					<span id="msg-done"></span>
				</div>
				<input type="hidden" name="non_cust_id" id="non_cust_id" value="0">		
		</div>

		<div class="new-customer">
			<hr />
	        <div class="form-group row new-customer">
                <label class="control-label col-sm-2">Company Name</label>
                <div class="col-sm-4">
                    <input name="nama_cust" placeholder="Company Name" class="form-control req" type="text">
                </div>
                <label class="control-label col-sm-1">Customer Name</label>
                <div class="col-sm-4">
                    <input name="pic_name" placeholder="Customer Name" class="form-control req" type="text">  
                </div>
            </div>
            <div class="form-group row new-customer">
                <label class="control-label col-sm-2">Alamat</label>
                <div class="col-sm-9">
                    <textarea name="alamat_cust" placeholder="Alamat" class="form-control req" id="alamat_cust"></textarea>
                </div>
            </div>           
            <div class="form-group new-customer">
                <label class="control-label col-sm-2">Telepon PSTN</label>
                <div class="col-sm-3">
                    <input name="telepon_pstn" placeholder="Telepon" class = "form-control" type="text"> 
                </div>
                <label class="control-label col-sm-1" style="width: 4%;">Fax</label>
                <div class="col-sm-2">
                    <input name="fax" placeholder="Fax" class = "form-control" type="text"> 
                </div>
                <label class="control-label col-sm-1" style="width: 4%;">HP</label>
                <div class="col-sm-3">
                    <input name="tlp_hp" placeholder="HP" class = "form-control req" type="text"> 
                </div>
            </div>
            <div class="form-group row new-customer">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="email" placeholder="example@email.com" class="form-control">
                </div>
            </div> 
            <div class="form-group row new-customer">
                <label class="control-label col-sm-2">Notes</label>
                <div class="col-sm-9">
                    <textarea name="note" placeholder="Notes" class="form-control"></textarea>
                </div>
            </div>
            <hr />
		</div>
		
		<div class="form-group row customer">
			<label class="control-label col-sm-2">&nbsp;</label>
			<div class="col-sm-9">
				<select class="form-control" name="customer_id" id="customer_id" required="true" data-placeholder="Masukkan ID atau Nama Customer..." style="width: 100%;">
				<option value="">-Pilih Customer-</option>
					<!-- <?php 
						/*  if($customer)
						{
							foreach($customer as $row)
							{ ?>
								<option value="<?php echo $row['id']; ?>">
										<?php echo $row['id_customer'] ?> : <?php echo $row['perusahaan']?>
								</option>
							<?php 
							}	
						} */ ?>	-->
				</select>
			</div> 
		</div>
		

		<div class="form-group row customer">
			<label class="control-label col-sm-2">PIC  </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="pic" id="pic" readonly="true">
				</div>

			<label class="control-label col-sm-1">Telepon  </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="telepon" id="telepon" readonly="true">
				</div>
		</div>

		<div class="form-group row customer">
			<label class="control-label col-sm-2">Alamat  </label>
				<div class="col-sm-9">
					<textarea type="text" class="form-control" name="alamat" id="alamat" readonly="readonly"></textarea>
				</div>
		</div>		
		
		<div class="form-group row">
			<label class="control-label col-sm-2">Inquiry Source</label>
			<div class="col-sm-4">
				<select class="form-control" style="width: 100%;" name="source" required="true" id="sel-source">
					<option value="" disabled selected>Wajib diisi sesuai pengakuan customer</option>
					<option value="Blibli">Blibli</option>
					<option value="Brosur">Brosur</option>
					<option value="Bukalapak">Bukalapak</option>
					<option value="Customer Existing">Customer Existing</option>
					<option value="Elevania">Elevania</option>
					<option value="Google">Google</option>
					<option value="Kunjungan Sales">Kunjungan Sales</option>
					<option value="Lain-lain">Lain-lain</option>
					<option value="Lazada">Lazada</option>
					<option value="Mataharimall">Mataharimall</option>
					<option value="OLX">OLX</option>
					<option value="Pameran">Pameran</option>
					<option value="Qoo10">Qoo10</option>
					<option value="Referensi/Referral">Referensi/Referral</option>
					<option value="Shopee">Shopee</option>
					<option value="Tokopedia">Tokopedia</option>
					<option value="Zalora">Zalora</option>
				</select>
				<input type="hidden" class="form-control col-sm-4" id="lain" name="lain">
			</div>

			<label class="control-label col-sm-1">Client Location</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="site" required="true">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Prospect Value (Rp)</label>
			<div class="col-sm-4">
				<input type="text" name="prospect_value" class="form-control" onkeyup="splitInDots(this)" required="true" >
			</div>

			<label class="control-label col-sm-1">Competitor</label>
			<div class="col-sm-4">
				<input type="text" name="competitor" class="form-control" required="true">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Product & Prospect Description</label>
				<div class="col-sm-9">
					<textarea type="text" id="tx1" class="form-control" name="prospect_desc" rows="4" required></textarea>
				</div>
		</div>	
					
		<div class="form-group row">
			<label class="control-label col-sm-2">Progress</label>
			<div class="col-sm-4">
				<select class="form-control" name="progress" required style="width: 100%;" required="true" id="progress">
					<option value="">-Pilih-</option>
					<option value="Introduction">Introduction Stage</option>
					<option value="Quotation">Quotation Stage</option>
					<option value="Negotiation">Negotiation Stage</option>
					<option value="Deal">Deal Stage</option>
				</select>
			</div>

			<label class="control-label col-sm-1">Posibilities</label>
			<div class="col-sm-4">
				<select class="form-control" name="posibilities" required style="width: 100%;" required="true">
					<option value="">-Pilih-</option>
					<option value="10">10%</option>
					<option value="20">20%</option>
					<option value="30">30%</option>
					<option value="40">40%</option>
					<option value="50">50%</option>
					<option value="60">60%</option>
					<option value="70">70%</option>
					<option value="80">80%</option>
					<option value="90">90%</option>
					<option value="99">99%</option>
				</select>
			</div>
		</div>

		<div class="form-group row" id="dealvalue">
			<label class="control-label col-sm-2">Deal Value (Rp)</label>
			<div class="col-sm-4">
				<input type="text" name="deal_value" class="form-control" onkeyup="splitInDots(this)" placeholder="Enter Integer Number" >
				<p style="font-size: 12px;">Wajib diisi dengan harga final deal berikut PPn</p>
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Progress Note</label>
				<div class="col-sm-9">
					<textarea type="text" id="tx2" class="form-control" name="progress_note" rows="4" required></textarea>
				</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Special Note</label>
				<div class="col-sm-9">
					<textarea type="text" id="tx3" class="form-control" name="special_note" rows="4" required></textarea>
				</div>
		</div>

		<div class="form-group">
    		<label class="control-label col-sm-2">Add Contributor</label>
    		<div class="col-sm-9">
    			<select name="contributor[]" class="form-control" style="width: 100%;" multiple="true">
    				<option value="">-Pilih-</option>
    				<?php if($employee) {
    					foreach ($employee as $kar) { ?>
    						<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
    					<?php }
    					} ?>
    			</select>
    		</div>
    	</div>
		
		<div class="form-group row file-row" id="file-row-1">
			<label class="control-label col-sm-2">Upload Files</label>
			<div class="controls col-sm-8" style="width:68.5%;">
				<input class="" type="file" name="userfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row">

		</div>

		<input type="submit" name="submit_btn" id="submit" value="Save" class="btn btn-info" id="crm-save" />	
		
    </form>	
</div> 

<!-- <div class="modal fade" id="ModalNewCust" role="dialog" method="post">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" action='#' id="form_cust">
				<div class="modal-header">
					<h4>New Customer</h4>
				</div>

				<div class="modal-body">
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Company Name</label>
                        <div class="col-sm-4">
                            <input name="nama_cust" placeholder="Nama Perusahaan" class="form-control" type="text" required="true">
                        </div>
                        <label class="control-label col-sm-2">Customer Name</label>
                        <div class="col-sm-4">
                            <input name="pic" placeholder="Nama Customer" class="form-control" type="text" required="true">  
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Alamat</label>
                        <div class="col-sm-10">
                            <textarea name="alamat" placeholder="Alamat" class="form-control" required="true" id="alamat"></textarea>
                        </div>
                    </div>           
                    <div class="form-group">
                        <label class="control-label col-sm-2">Telepon PSTN</label>
                        <div class="col-sm-3">
                            <input name="telepon" placeholder="Telepon" class = "form-control" type="text"> 
                        </div>
                        <label class="control-label col-sm-1" style="width: 4%;">Fax</label>
                        <div class="col-sm-3">
                            <input name="fax" placeholder="Fax" class = "form-control" type="text"> 
                        </div>
                        <label class="control-label col-sm-1" style="width: 4%;">HP</label>
                        <div class="col-sm-3">
                            <input name="tlp_hp" placeholder="HP" class = "form-control" type="text"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" placeholder="example@email.com" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Notes</label>
                        <div class="col-sm-10">
                            <textarea name="note" placeholder="Notes" class="form-control"></textarea>
                        </div>
                    </div>
                    
				</div>

				<div class="modal-footer">
					<input type='button' class='btn btn-info pull-left btn-submit' value='Save' id="btnSave" onclick="add_cust()">
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
				</form>
		</div>
	</div>
</div> -->



<script type="text/javascript">


	function add_cust() {

	$('#btnSave').val('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
		$.ajax({
		  	type : 'POST',
		  	url : '<?php echo site_url('crm/add_customer'); ?>',
		  	data : $('#form_cust').serialize(),
		  	dataType : 'json',
		  	success : function (data){
		  		$("input[name='non_cust_id']").val(data.non_cust_id);
		  		$("#msg-done").html('<b>Customer ' +data.nama_cust+ ' berhasil ditambahkan !</b>');
		  		$('input[name="cust_type"]').attr("disabled", true);
		  		$('#ModalNewCust').modal('hide');

		  		 $('#btnSave').val('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
		  		
		  	},
		  	error : function (xhr, status, error){
        		console.log(xhr);
      		},
		});
	}

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

    function showInput()
    {
    	//$("#lain").attr('type', 'text');
    	//$("#lain").attr('required', true);
    	alert();
    }

$(document).ready(function() {
	$('.customer').hide();
	$('.new-customer').hide();

	CKEDITOR.instances['alamat_cust'].destroy();
CKEDITOR.instances['alamat'].destroy();

	$('body').delegate('.btn-add-file', 'click', function(){
		var id = $(this).data('id');

		var length = $('.file-row').length;

		html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
				'<label class="control-label col-sm-2">&nbsp;</label>'+
				'<div class="controls col-sm-8" style="width:65%;">'+
					'<input class="" type="file" name="userfile[]">'+
				'</div>'+
				'<div class="col-sm-2">'+
					'<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+
					'&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+						
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

	$('input[name="cust_type"]').click(function() {
		
	   if($(this).is(':checked') && $(this).val() == '0') {
	        $('.customer').hide();
	        $('.new-customer').show();
	        $('#customer_id').prop('required', false);
	        $('.req').prop('required', true);
	        //CKEDITOR.instances['alamat'].destroy();
			
	   }else if ($(this).is(':checked') && $(this).val() == '1') {
	   		$('.customer').show();
	   		$('.new-customer').hide();
	   		$('#customer_id').prop('required', true);
	   		$('.req').prop('required', false);
	   		
			//CKEDITOR.instances['alamat_cust'].destroy();
	   }


	});

	

    $("input[name='prospect_value'], input[name='deal_value']").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {    
	        alert("Number Only !");
	    	return false;
    	}
   	});	

   	$("#customer_id").select2({
		//tags: true,
		ajax: {
			url: "<?php echo site_url('c_new_sps/ajax_cust'); ?>",
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
			  			//CKEDITOR.instances['alamat'].destroy();
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

	$("#progress").change(function() {
		val = $(this).val();
		if(val == 'Deal') {
			$("#dealvalue").css({'display' : 'block'});
			$("input[name='deal_value']").attr('required', true);
		}else {
			$("#dealvalue").css({'display' : 'none'});
			$("input[name='deal_value']").attr('required', false);
		}
	});

	$("#sel-source").change(function() {
		if ($(this).val() == 'Lain-lain') 
		{
			$("#lain").attr('type', 'text');
			$("#lain").attr('required', true);
		}else {
			$("#lain").attr('type', 'hidden');
			$("#lain").attr('required', false);
		}
	});

});

/* $(document).ready(function() {
	$('#product_id, #overto').select2({
	    minimumInputLength : 2
	});

	$("#customer_id").select2({
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
	});

	$(".no").hide();

    $('input[name="rad"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".no").not(targetBox).hide();
        $(targetBox).show();
        $(".cl-"+inputValue).toUpperCase();
        $(".cl-"+inputValue).prop("required", true);
    });

	

	$( "#overto" ).change(function() {
  		var id = $(this).val();
 		$.ajax({
      		type : 'POST',
      		url : '<?php //echo site_url('c_new_sps/getOverTo'); ?>',
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

	//called when key is pressed in textbox
  	$("#no_so1, #no_so2, #no_so3, #it1, #it2, #it3").keypress(function (e) {
	  	length_so =   $("#no_so1, #no_so2, #no_so3, #it1, #it2, #it3").length;
	     //if the letter is not digit then display error and don't type anything
	    alert(e.which);
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        alert("Number Only !");
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
    	}
   	});	
}); */


</script>