<?php $user = $this->session->userdata('myuser'); ?>


<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Project Quotation Form</h2>
        </div>
    </div>              
    <hr />
    
	<form method="post" role="form" action="<?php echo site_url('quotation/add');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
    <input type="hidden" name="crm_id" value="<?php echo $detail['id']; ?>" />
	<?php echo $this->session->flashdata('message'); ?>

	<div class="row">
    	
         <div class="col-md-6">
        	
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>To</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo $detail['pic']; ?>
                </div>
            </div> 
        
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Company</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo $detail['perusahaan']; ?>
                </div>
            </div> 
		
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Phone</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo $detail['telepon']; if ((!empty($detail['telepon'])) AND (!empty($detail['tlp_hp']))) echo " / "; echo $detail['tlp_hp'];  ?>
                </div>
            </div> 
		
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Validity</b>
                </div>
                <div class="col-sm-9">
                    : 2 weeks
                </div>
            </div> 
		
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Email</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo $detail['email']; ?>
                </div>
			</div>
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Prospect</b>
                </div>
                <div class="col-sm-9">
                    : Rp <?php echo number_format($detail['prospect_value'],0,",","."); ?>
                </div>
			</div>
            
        </div>
    
    	<div class="col-md-6">
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Sales</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo $user['nama']; ?>
                </div>
            </div> 
		
       	    <div class="form-group row">
                <div class="col-sm-3">
                    <b>Divisi</b>
                </div>
                <div class="col-sm-9">
                    : DHC
                </div>
            </div> 
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Date</b>
                </div>
                <div class="col-sm-9">
                    : <?php echo date("M d, Y"); ?>
                </div>
            </div> 
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Price Term</b>
                </div>
                <div class="col-sm-9">
                    : Loco Workshop Indotara Cikupa
                </div>
            </div> 
            
			<div class="form-group row">
                <div class="col-sm-3">
                    <b>Delivery Time</b>
                </div>
                <div class="col-sm-9">
                    : <input name="delivery_time" placeholder="" class="form-control inputnumber" style="display:inline; width:100px;" type="text"> 
                    <select name="delivery_period" class="form-control input-sm" style="display:inline; width:100px;">
                    	<option value="month">Month</option>
                    	<option value="week">Week</option>
                    </select>
                </div>
            </div> 
            

            <div class="form-group row">
                <div class="col-sm-3">
                    <b>Payment term</b>
                </div>
                <div class="col-sm-9">
                    : See Term & Condition
                </div>
            </div> 
            
        </div>
         
	</div>
    
    <hr />
    
    <div class="row">
    	<div class="col-md-12">
        	<table class="table table-striped table-condensed">
            <thead>
            	<tr><th>Project Description</th><th width="10%">Qty</th><th width="15%">Unit Price</th><th width="15%">Total Project Price</th></tr>
            </thead>
            <tbody>
				<tr style="vertical-align:middle" valign="middle">
                	<td><textarea name="project_description" id="project_description" class="form-control" required></textarea></td>
                    <td><input name="quantity" placeholder="" class="form-control inputnumber" type="text"> </td>
                    <td><input name="unit_price" placeholder="" class="form-control" type="text" readonly="readonly"> </td>
                    <td><input name="project_price" placeholder="" class="form-control" type="text" readonly="readonly"> </td>
                </tr>
            </tbody>
            </table>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addproductModal">Add Product</button>
        </div>    
    </div>
    
    <hr />
    
    <div id="quotation_items">
    
    
    </div>
    
    </form>
    
</div>


<div id="addproductModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Search Product</h4>
      </div>
      <div class="modal-body">
      	<form id="AddItem" action="" method="post" enctype="multipart/form-data">
	    <input type="hidden" name="crm_id" value="<?php echo $detail['id']; ?>" />
        <div class="form-group">
        	<label>Select Product</label>
            <select class="form-control" name="product_id" id="product_id" required="true" data-placeholder="Type product name..." style="width: 100%; padding:12px 8px; height:30px;">
                <option value="">-Select Product-</option>
            </select>
		</div>
        
        <div id="loading_info" style="display:none; padding:15px; text-align:center">
        	Loading product info...
        </div>
        
        <div id="product_detail_wrapper" style="display:none">
        	<div class="row form-group">
            	<div class="col-sm-6">
                   	<label>Product Image</label>
                	<img id="item_image" class="img-responsive" style="border:solid 1px #ccc;" src="https://myiios.net/no-image.jpg" />
                </div>
            	<div class="col-md-6">
                	<div class="form-group">
                    	<label>Product Price</label>
                        <input type="text" name="item_price" id="item_price" class="form-control" readonly="readonly" />
                    </div>
                	<div class="form-group">
                    	<label>Quantity</label>
                        <input type="text" name="item_quantity" id="item_quantity" class="form-control inputnumber" value="1" required />
                    </div>
                	<div class="form-group">
                    	<label>Discount</label>
                        <input type="text" name="item_discount" id="item_discount" class="form-control inputnumber"/>
                    </div>
                	<div class="form-group">
                    	<label>Best Price</label>
                        <input type="text" name="item_best_price" id="item_best_price" class="form-control" readonly="readonly" />
                    </div>
                </div>
            </div>	
            
            <div class="form-group">
        		<button type="submit" id="AddItemButton" class="btn btn-primary btn-lg btn-block">Add Product To Quotation</button>
            </div>    
        </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>





<script type="text/javascript">
$(document).ready(function() {

	getListItem();

	$(".inputnumber").on("keypress keyup blur",function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if (event.which > 31 && (event.which < 48 || event.which > 57)) {
		   event.preventDefault();
		}
	});

	$("#product_id").select2({
		//tags: true,
		ajax: {
			url: "<?php echo site_url('quotation/ajax_product'); ?>",
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
	                    'text': item.nama_produk
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
	
	$( "#product_id").change(function() {
		
		$("#loading_info").show();		
		$("#product_detail_wrapper").hide();
	
		var id = $(this).val();
		
		$.ajax({
		  	type : 'POST',
		  	url : '<?php echo site_url('quotation/ajax_product_detail'); ?>',
		  	data : {
		  		data_id : id,
		  	},
		  	dataType : 'json',
		  	success : function (data){
			  	
				$("#loading_info").hide();		
				$("#product_detail_wrapper").show();		
	  			$("#item_price").val(data.harga_produk);
	  			$("#item_image").attr("src",data.imglink);
		  			
		  	},
		  	error : function (xhr, status, error){
		  		console.log(xhr);
		  	}
		});
	});
	
	$( "#item_quantity").keyup(function() {
		var qty = $(this).val();
		
		if (qty < 1)
		{
			$('#AddItemButton').attr("disabled", "disabled");
		}
		else
		{
			$('#AddItemButton').removeAttr('disabled');
		}
	});
	
	
	$("#AddItem").on('submit',(function(e) {

		e.preventDefault();
		$("#AddItemButton").html("..adding item to quotation..");
		$('#AddItemButton').attr("disabled", "disabled");
		
		$.ajax({
			url: "<?php echo site_url('quotation/add_item_project'); ?>",
			type: "POST",             
			data: new FormData(this), 
			contentType: false,  
			cache: false,  
			processData:false, 
			success: function(data) 
			{
				getListItem();
				$('#addproductModal').modal('hide');
				$("#product_detail_wrapper").hide();		
				$("#product_id").val(null).trigger('change');
				$("#item_quantity").val("1");
				$("#item_discount").val("");
				$('#AddItemButton').removeAttr('disabled');
				$("#AddItemButton").html("Add Product To Quotation");
			}
		});
	}));
	
	CKEDITOR.instances['project_description'].destroy();
	
});

function getListItem()
{
	$.ajax({
		type: "POST",
		dataType: "json",
		data: "crm_id=<?php echo $detail['id']; ?>",			
		url: "<?php echo site_url('quotation/get_list_item'); ?>",
		success: function(result)
		{
			console.log(result);
			
			var ongoingOutput = "";
			
			for (var i in result)
			{
				ongoingOutput+= '<div class="panel panel-default"><div class="panel-body"><div class="row"><div class="col-md-6">' + result[i].keterangan + '</div><div class="col-md-6 text-right"><img src="<?php echo base_url().'test.jpg'; ?>"></div></div></div></div>';
			}
			
			$('#quotation_items').html(ongoingOutput);
			 
		},
		timeout: 5000, //5 second timeout
		error: function(jqXHR, textStatus, errorThrown) {
			if(textStatus==="timeout") {
				var ErrorMessage = "Cannot reach server";
			} 
			else {
				var ErrorMessage = textStatus;
			}
						
		}
	});
}

</script>