<?php $user = $this->session->userdata('myuser'); 
$crm_sess = $this->session->userdata('sess_crm_id'); 
?>

<style type="text/css">
	.yellow{
		width: auto;
	}

	#dealvalue {
		display: none;
	}	


/* The actual timeline (the vertical ruler) 
.timeline {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
    
} */

/* The actual timeline (the vertical ruler)
.timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: #d6d6d6;
    top: 0;
    bottom: 0;
    left: 16px;
    margin-left: -3px;
}  */

/* Container around content */
.container {
  	padding: 0px 40px 20px 0px;
    position: relative;
    background-color: inherit;
    width: 200px;
}

/* The circles on the timeline 
.container::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    right: -9px;
    background-color: white;
    border: 4px solid #FF9F55;
    top: 25px;
    border-radius: 50%;
    z-index: 1;
} */

/* Place the container to the left */
.left {
    left: 0px;
}

/* Place the container to the right */
.right {
    left: -45px;
}

/* Add arrows to the left container (pointing right) 
.left::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 25px;
    width: 0;
    z-index: 1;
    right: 30px;
    border: medium solid white;
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent grey;
} */

/* Add arrows to the right container (pointing left) 
.right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 25px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent grey transparent transparent;
} */

/* Fix the circle for containers on the right side */
.right::after {
    left: 0px;
}

/* The actual content */
.content {
 	padding: 8px 8px 8px 8px;
    background-color: white;
    position: relative;
    border-radius: 6px;
    border: 1px solid grey;
    //box-shadow: 5px 5px 5px #888888;
    height: 80px;

}

h2 {
	font-size : 12px;
    margin : 0px 0px 10px 0px;
    text-align : center;
}

.triangle::after {
	/* width: 0;
	height: 0;
	border-style: solid;
	border-width: 45px 0 45px 60px;
	border-color: transparent transparent transparent #adadad; */

	content: " ";
    height: 0;
    position: absolute;
    top: 20px;
    width: 0;
    z-index: 1;
    right: 17px;
    border: medium solid white;
    border-width: 20px 0 20px 20px; 
    border-color: transparent transparent transparent grey;

}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media all and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
    left: 31px;
  }
  
  /* Full-width containers */
  .container {
    width: 100%;
    padding-left: 70px;
    padding-right: 20px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent grey transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
    left: 22px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
    left: 0%;
  }

  .triangle::after {
	content: " ";
    height: 0;
    position: absolute;
    top: 20px;
    width: 0;
    z-index: 1;
    right: 17px;
    border: medium solid white;
    border-width: 20px 0 20px 20px; 
    border-color: transparent transparent transparent grey;

}
}

.input-group-addon {
	font-size: 12px;
}

.same {
	background-color: yellow;
}


</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h3>FORM New Project</h3>
        </div>
    </div>              
    <hr />
	<form id="form-project" class="form-horizontal" enctype="multipart/form-data" method="post" role="form" onsubmit=" checkDays(event);">
		<?php echo $this->session->flashdata('message'); ?>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama Sales</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="disabledInput" name="sales_name" readonly="readonly" value="<?php echo $user['nama']; ?>">
				</div>
			<label class="control-label col-sm-2">Project Type</label>
			<div class="col-sm-2">
				<div class="radio">
					<input type="radio" name="tipe" value="0" required="true"> Semi Project
				</div>
			</div>
			<div class="col-sm-2">
				<div class="radio">
					<input type="radio" name="tipe" value="1" required="true"> Full Project
				</div>
			</div>	
		</div> 
		<input type="hidden" name="crm_id" value="<?php echo $crm_sess['id']; ?>">
		<div class="form-group row">
			<label class="col-sm-2 control-label">Project Description</label>
			<div class="col-sm-10">
				<textarea name="description" class="form-control" placeholder="Contoh : LG GantryCrane 10T Span 22m x Long 60m x 2 Lot" required="true"></textarea>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-6">
				<div class="form-group row">
					<label class="col-sm-4 control-label">Project Address</label>
					<div class="col-sm-8">
						<textarea name="adrs" class="form-control" placeholder="Alamat Lengkap Project" style="height: 83px;" required="true"></textarea>
					</div>
				</div>
				<div class="form-group row">	
					<label class="col-sm-4 control-label">Google Maps Link</label>
					<div class="col-sm-8">
						<input type="text" name="glink" class="form-control" placeholder="Contoh : https://goo.gl/maps/Ci96mFdUmAp" required="true">
					</div>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group row">
					<label class="col-sm-4 control-label">CP</label>
					<div class="col-sm-8">
						<input type="text" name="siteCP" class="form-control" required="true">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 control-label">No HP</label>
					<div class="col-sm-8">
						<input type="text" name="noHP" class="form-control" required="true">
					</div>
				</div>	
				<div class="form-group row">
					<label class="col-sm-4 control-label">Email CP</label>
					<div class="col-sm-8">
						<input type="text" name="emailCP" class="form-control" placeholder="example@email.com" required="true">
					</div>
				</div>
			</div>

		</div>
		
		<div class="form-group row">
			<label class="control-label col-sm-2">Customer</label>
			<div class="col-sm-10">
				<select class="form-control" name="customer_id" id="customer_id" required="true" data-placeholder="Masukkan ID atau Nama Customer..." style="width: 100%;">
					<option value="">-Pilih Customer-</option>
				</select>
			</div> 
		</div>
		

		<div class="form-group row">
			<label class="control-label col-sm-2">PIC  </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="pic" id="pic" readonly="true">
				</div>

			<label class="control-label col-sm-2">Telepon  </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="telepon" id="telepon" readonly="true">
				</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Alamat  </label>
				<div class="col-sm-10">
					<textarea type="text" class="form-control" name="alamat" id="alamat" readonly="true"></textarea>
				</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Email  </label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="email" id="email" readonly="true">
				</div>
		</div>
		
		<div class="form-group">
    		<label class="control-label col-sm-2">Lampiran QC</label>
    		<div class="col-sm-4">
    			<select name="fileqc[]" class="form-control" style="width: 100%;" multiple="true">
    				<option value="">-Pilih-</option>
    				<?php if($qc) {
    					foreach ($qc as $fl) { ?>
    						<option value="<?php echo $fl['file_name']; ?>"><?php echo $fl['file_name']; ?></option>
    					<?php }
    					} ?>
    			</select>
    		</div>
    		<label class="control-label col-sm-2">Add Contributor</label>
    		<div class="col-sm-4">
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

		<div class="form-group row"> 
			<label class="col-sm-2 control-label">DP Date</label>
			<div class="col-sm-4">
				<input type="text" name="dp" class="form-control diff" id="dp_date" required="true">
			</div>

			<label class="control-label col-sm-2">Deadline BAST</label>
			<div class="col-sm-4">
				<input type="text" name="deadline" class="form-control diff" id="deadline_date" required="true">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 control-label"><span class="same">Project Time (Days)</span></label>
			<div class="col-sm-10">
				<input type="text" name="calc-date" class="form-control calc-date" id="calc-date" readonly="true" value="0">
			</div>
		</div>

	<div class="form-group row">
		<label class="control-label col-sm-2">Project Progress Planning</label>
		<div class="timeline col-sm-10">
		  <div class="container col-sm-2 triangle">
		    <div class="content" >
		     <h3 style="text-align: center; margin-top: 15px;">DP</h3>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>Survey</h2>
				<div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-survey" id = "d-survey" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>KickOff</h2>
		     <div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-kick" id = "d-kick" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>Material</h2>
		      <div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-material" id = "d-material" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>Production</h2>
		      <div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-production" id = "d-production" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>Delivery</h2>
		      <div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-delivery" id = "d-delivery" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2 triangle">
		    <div class="content">
		      <h2>Installation</h2>
		      <div class="input-group" style="width : 141px;">
					<input type="text" class="form-control pp" name="d-install" id = "d-install" required="required" onchange="total()">
						<div class="input-group-addon">
    						<span class="control-label"> Day(s)</span>
						</div>
				</div>
		    </div>
		  </div>
		  <div class="container col-sm-2">
		    <div class="content">
		      <h4 style="text-align: center; margin-top: 20px;">Finished BAST</h4>
		    </div>
		  </div>
		</div>
	</div>	

	<div class="form-group row">
		<label class="control-label col-sm-2"><span class="same">Total Days</span></label>
		<div class="col-sm-10">
			<input type="text" name="d-total" class="form-control" id="d-total" readonly="true">
			<p >*Project Time dan Total Days harus bernilai sama*</p>
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

		<input type="submit" name="submit_btn" id="save" value="Save" class="btn btn-info"  />	
		
    </form>	
</div> 

<script type="text/javascript">

	function add_cust() { 
	
	$('#btnSave').val('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
		$.ajax({
		  	type : 'POST',
		  	url : '<?php echo site_url('c_crm/add_customer'); ?>',
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

    function total()
    {
    	var add = 0;
    	$(".pp").each(function() {
    		add += Number($(this).val());
    	});

    	$("#d-total").val(add);
    	
    }

    function checkDays(event)
    {
    	ttl = $("#d-total").val();
    	calc = $(".calc-date").val();

    	$("input[name='submit_btn']").disabled = true;
    	$("input[name='submit_btn']").val = 'Saving...';

    	if (calc == ttl) {
			return true;
	    }
	    else
	    {
	       selisih = calc - ttl;
	       selisihD = ((selisih < 0) ? selisih * -1 : selisih);	
	       alert("\t Total Days dan Project Time selisih " + selisihD + " hari. \t");
	       event.preventDefault();
	       return false;
	    }
	   
    }
    	$('#dp_date').datepicker({
    		format: "dd/mm/yyyy",
		    todayHighlight:'TRUE',
		    autoclose: true,
		    minDate: 0,
		    showButtonPanel: true
		   
    	}).on('changeDate', function(e){ 
    		if($('#deadline_date').val() != '') {
    			var start = $("#dp_date").val();
				var startD = new Date(start.split("/").reverse().join("-"));
		        console.log(startD);
		        var end = $("#deadline_date").val();
		        var endD =  new Date(end.split("/").reverse().join("-"));
		        var diff = parseInt((endD.getTime()-startD.getTime())/(24*3600*1000));
		        console.log(diff+1);
		        $(".calc-date").val(diff+1);
    		}else {
    			$('#deadline_date').datepicker('setStartDate', $("#dp_date").val());
    		}
		    
		});

		$('#deadline_date').datepicker({
		    format: "dd/mm/yyyy",
		    todayHighlight:'TRUE',
		    autoclose: true,
		    minDate: '0',
		    showButtonPanel: true
		}).on('changeDate', function (ev) {
		        var start = $("#dp_date").val();
				var startD = new Date(start.split("/").reverse().join("-"));
		        console.log(startD);
		        var end = $("#deadline_date").val();
		        var endD =  new Date(end.split("/").reverse().join("-"));
		        var diff = parseInt((endD.getTime()-startD.getTime())/(24*3600*1000));
		        console.log(diff+1);
		        $(".calc-date").val(diff+1);
		});

    	

$(document).ready(function() {


	$('.customer').hide();

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
		  	success : function (data){ console.log(data);

		  		$('#telepon').val(data.telepon).prop('readonly', true);
	  			$('#pic').val(data.pic).prop('readonly', true);
	  			$('#alamat').val(data.alamat).prop('readonly', true);
	  			$('#email').val(data.email).prop('readonly', true);

		  		if(data.pic == '') {
		  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
		  		}

		  		if(data.telepon == '') {
		  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
		  		}

		  		if(data.alamat == '') {
		  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
		  		}

		  		if(data.email == '') {
		  			$('#email').val(data.email).prop('readonly', false).attr("required", "required");
		  		}
		  			
		  	},
		  	error : function (xhr, status, error){
		  		console.log(xhr);
		  	}
		});
	});

	$("#d-survey, #d-kick, #d-material, #d-production, #d-delivery, #d-install").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        alert("Number Only !");
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
    	}
   	});	
}); 
</script>