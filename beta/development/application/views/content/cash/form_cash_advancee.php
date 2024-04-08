<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<?php $user = $this->session->userdata('myuser'); ?>
<style type="text/css">
	#table-items thead th {
		text-align: center;
	}
	#table-items {
		max-width: 1020px;
    	//width: 100% !important;
	}

	.table > tbody > tr > td {
		vertical-align: center;
		padding: 8px 2px;
	}

	.items {
		font-size: 12px;
	}

	.form-control-input {
		display: block;
		width: 225px;
		height: 34px;
		padding: 1px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	.fileUpload {
	position: relative;
	overflow: hidden;
	max-width: 220px;

}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}

.btn-item {
	width: 30px;
	margin-bottom: 2px;
}

.txa {
	height: 70px;
	width:300px;
}
/* .amount {
	width:200px;
} */


</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>New Cash Advance</h2>
        </div>
    </div>              
    <hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('Cash/addcash'); ?>" onsubmit="this.btn_submit.disabled = true; this.btn_submit.val = 'Saving...'; " enctype="multipart/form-data" >
		<h4><?php echo $this->session->flashdata('message'); ?> </h4>
			 
		<div class="form-group row">
			<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" value="<?php echo "",date("d-m-Y"); ?>" name="tanggal" disabled />
			</div> 
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="namasales" readonly="true" value="<?php echo $user['nama']; ?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Divisi</label>
				<div class="col-sm-1">
					<div class="radio">	
						<input type="radio" name="divisi" value="DCE" required="true" > DCE
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DEE" required="true" > DEE
					</div>
				</div>
			
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DHC" required="true" > DHC
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DHE" required="true" > DHE
					</div>
				</div>

				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DRE" required="true" > DRE
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DWT" required="true" > DWT
					</div>
				</div>
				<div class="col-sm-2">
					<div class="radio">
						<input type="radio" name="divisi" value="" required="true" > Lain-lain
					</div>
				</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Jenis</label>
			<div class="col-sm-2">
				<div class="radio">
					<input type="radio" name="type" value="1" required="true" class="rad"> Advance (Pinjam Uang)
				</div>
			</div>
			<div class="col-sm-2">	 
				<div class="radio">
					<input type="radio" name="type" value="2" required="true" class="rad"> Expenses (Penggunaan Uang)
				</div>
			</div>

			<div class="col-sm-7" style="color:green; padding-top: 0.7%;">
				<span id="msg-done"></span>
			</div>
			<br>
			<br>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Judul</label>
	      	<div class="col-sm-9">
	        	<input  type="text" class="form-control" name="keterangan" rows="4" required="true">
	      	</div>
		</div>
		
		<div class="form-group row ket">
	      <label class="control-label col-sm-2">Keterangan</label>
	      <div class="col-sm-7">
	        <textarea type="text" id="tx1" class="form-control" name="message" rows="3"></textarea>
	      </div>
	    </div>

    <hr />

   	<div class="form-group row amnt">
   		<label class="control-label col-sm-2">Amount </label>
		<div class="col-sm-4">
			<div class="input-group">
				<div class="input-group-addon">
					<span class="control-label"> Rp</span>
				</div>
					<!-- <input name="amount" type="text"  class="form-control" required="true" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"> -->
					<input type="text" class="form-control amount" name="amount" id="amount" value="0" onkeyup="splitInDots(this)">
			</div>
		</div>
	</div>

	<div class="form-group row overto">
     	<label class="control-label col-sm-2">Admin / Kasir </label>
      	<div class="col-sm-7">
        	<select class="form-control" name="nextto" id="nextto" required="true" style="width: 100%; margin-top: 3px;">
                <option value="">-Pilih-</option>
              	<?php 
                if($admin)
                {
                	foreach($admin as $row)
                	{ ?>
                	<option value="<?= $row['id']; ?>"><?php echo $row['nama']; ?>- <?php echo $row['position']; ?></option>
                	<?php 
                	} 
                } ?>
            </select>
  		</div>
  	</div>

    <hr />
    <div class="form-group">
    	<div class="col-sm-12">
    
    	<!-- <div class="table-responsive expenses">
    	 <h3>Expenses / Adjustment Report</h3><br>   		
			<table class=" table table-hover col-sm-12 expenses" id="table-items" style="font-size: 12px;">
				<thead>
					<tr>
						<th style="width: 30%;">Keterangan Penggunaan Uang</th>
						<th style="width: 30%">Amount (Rp)</th>
						<th style="width: 30%">Nota</th>
						<th style="width: 10%"></th>
					</tr>
				</thead>
				<tbody>
					<tr id="tr-row-1" class="tr-row expenses">
						<td>
							<textarea type="text" name="deskripsi[]" class="form-control-input items txa" placeholder="Deskripsi"></textarea>
						</td>
						<td >
							<center><input name="amount_expense[]" type="text" class="form-control amount" onkeyup="splitInDots(this)"></center>
						</td>
						<td>
							<center>
								<div class="form-group row file-row expenses" id="file-row-1">
									<div class="fileUpload btn btn-default btn-sm">
									    <span class="flname">Upload</span>
									    <input type="file" class="upload uploadBtn" data-id="1" name="nota[]" />
									</div>
								</div>
							</center>
						</td>							
						<td>
							 <button type="button" class="btn btn-primary btn-tr-input btn-sm btn-item" data-id="1">+</button>
							 <button type="button" class="btn btn-danger  btn-tr-remove btn-sm btn-item" data-id="1">-</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div> -->
		<br />
		<div class="col-sm-12">
			<input type="submit" name="btn_submit" id="submit" value="Save" class="btn btn-info" />
		</div>				
	</form>	
</div>			  
</div>
</form>
</div>
</div>

    



<script type="text/javascript">
	
    CKEDITOR.replace('tx1', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200
    });

    $('#lookup-1').DataTable();

	$('input[name="type"]').click(function() {
		if($(this).is(':checked') && $(this).val() == '2') {
	        $('#amount').prop('readonly', true);
	        $('#amount').prop('required', false);
	        $('#amount').val("0");
	        $('.amnt').hide('hide');
	         $('.ket').hide('hide');
	   }else if ($(this).is(':checked') && $(this).val() == '1') {
	   		$('#amount').prop('required', true);
	   		$('#amount').prop('readonly', false);
	   		$('#amount').val("");
	   		$('.amnt').show('show');
	   		$('.ket').show('show');
	   }
	});

	


	$('body').delegate('.btn-mdl', 'click', function(){
       $("#myModal").modal('show');
    });	

	$('body').delegate('.pilih', 'click', function(){
		var length = $('.input-row').length;

		if(length >= 1)
		{
			//alert(length);
			document.getElementById("produk-" + length).value = $(this).data('produk');
			document.getElementById("prd-id-" + length).value = $(this).data('input');
        	$('#myModal').modal('hide');
		}
       
    });
	

   	 $('body').delegate('.btn-tr-input', 'click', function() {
   	 	var id = $(this).data('id');
   	 	
		var length = $('.tr-row').length;

   	 	html = '<tr id="tr-row-'+(length+1)+'" class="tr-row">'+
						'<td><textarea type="text" name="deskripsi[]" class="form-control-input items txa" placeholder="Deskripsi"></textarea>'+
						'</td>'+
						'<td>'+

							'<center><input name="amount_expense[]" type="text"  class="form-control amount" required="true" onkeyup="splitInDots(this)"></center>'+
						'</td>'	+			
						'<td>'+
							'<center>'+
								'<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
									'<div class="fileUpload btn btn-default btn-sm">'+
									    '<span class="flname">Upload</span>'+
									    '<input type="file" class="upload uploadBtn" data-id="'+(length+1)+'" name="nota[]" />'+
									'</div>'+
								'</div>'+
							'</center>'+
						'</td>'+	
						'<td>'+
							 '<button type="button" class="btn btn-primary btn-tr-input btn-sm btn-item" data-id="'+(length+1)+'">+</button>'+
							' <button type="button" class="btn btn-danger  btn-tr-remove btn-sm btn-item" data-id="'+(length+1)+'">-</button>'+
					'</td>'+
					'</tr>';

		$('#table-items').find('tbody').append(html);				
   	 });

   	 $('body').delegate('.btn-tr-remove', 'click', function(){
		var id = $(this).data('id');

		var length = $('.tr-row').length;

		if(length > 1)
		{
			$('#tr-row-'+id).remove();
		}
	});

   	$('body').delegate('.uploadBtn', 'change', function() {
   		//alert($(this).data('id'));
    	$(this).closest("tr").find(".flname").html(this.files.item(0).name);
	});


	function isNumberKey(evt)
	{
	 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {    
	        alert("Number Only !");
	    	return false;
    	}
   	};	
	
$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
		        	'<div class="controls col-sm-9">'+
		        		'<input class="" type="file" name="nota[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

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

    $(".amount").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {    
	        alert("Number Only !");
	    	return false;
    	}
   	});	


</script>		  

