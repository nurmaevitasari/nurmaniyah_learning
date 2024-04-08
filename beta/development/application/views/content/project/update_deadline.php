<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<style type="text/css">
.container {
  	padding: 0px 40px 20px 0px;
    position: relative;
    background-color: inherit;
    width: 200px;
}

/* Place the container to the left */
.left {
    left: 0px;
}

/* Place the container to the right */
.right {
    left: -45px;
}

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
		<a class="btn btn-default" href= "<?php echo site_url('Project/details/'.$this->uri->segment(3)); ?>">
        	<span class="fa fa-arrow-left"></span> BACK
    	</a>
			<h3>Update Deadline BAST</h3>
		</div>
	</div>
	<hr />

	<form id="form-project" class="form-horizontal" enctype="multipart/form-data" method="post" role="form" onsubmit=" checkDays(event);">
		<?php echo $this->session->flashdata('message'); ?>
		<div class="form-group row">
			<label class="col-sm-2 control-label">DP Date</label>
			<div class="col-sm-4">
				<input type="text" name="dp" class="form-control diff" id="dp_date" readonly="true" value="<?php echo date('d/m/Y', strtotime($detail['dp_date'])); ?>">
			</div>
			<label class="control-label col-sm-2">Last Deadline BAST</label>
			<div class="col-sm-4">
				<input type="text" name="last-deadline" class="form-control" value="<?php echo date('d/m/Y', strtotime($detail['deadline_date'])); ?>" readonly="true">
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 control-label"><span class="same">Project Time (Days)</span></label>
			<div class="col-sm-4">
				<input type="text" name="calc-date" class="form-control calc-date" id="calc-date" readonly="true" value="<?php echo $detail['days_deadline']; ?>">
			</div>
			<label class="control-label col-sm-2">New Deadline BAST</label>
			<div class="col-sm-4">
				<input type="text" name="deadline" class="form-control diff" id="deadline_date" required="true">
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
			 
			    <?php foreach ($getDays as $key => $val) { ?>
			    	<div class="container col-sm-2 triangle">
			    		<div class="content">
			    			<h2><?php echo $val['progress_name'] ?></h2>
			    			<div class="input-group" style="width : 141px;">
								<input type="text" class="form-control pp" name="d-<?php echo $val['progress_name'] ?>" id = "d-<?php echo $val['progress_name'] ?>" required="required" onchange="total()" value="<?php echo $val['days']; ?>">
								<div class="input-group-addon">
	    							<span class="control-label"> Day(s)</span>
								</div>
							</div>
						</div>
					</div>
			    <?php } ?>
			     
				<div class="container col-sm-2">
				    <div class="content">
				    	<h4 style="text-align: center; margin-top: 20px;">Finished BAST</h4>
				    </div>
				</div>
			</div>
		</div>	

		<div class="form-group row">
			<label class="control-label col-sm-2"><span class="same">Total Days</span></label>
			<div class="col-sm-4">
				<input type="text" name="d-total" class="form-control" id="d-total" readonly="true" value="<?php echo $detail['days_deadline']; ?>">
				<p style="font-size: 12px;">*Project Time dan Total Days harus bernilai sama*</p>
			</div>
			<label class="control-label col-sm-2">Alasan mengubah Deadline BAST</label>
			<div class="col-sm-4">
				<textarea class="form-control" name="dline_note" id="dline_note" rows="5" required="true"></textarea>
			</div>
			
		</div>
		<input type="hidden" name="project_id" value="<?php echo $detail['id']; ?>">
		<input type="submit" name="submit_btn" id="save" value="Save" class="btn btn-info"  />
</form>

<script type="text/javascript">
	$("#deadline_date").click(function(e) {
	    $('#deadline_date').data('datepicker').setDate(null);
	});

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

		$("#d-survey, #d-kick, #d-material, #d-production, #d-delivery, #d-install").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        alert("Number Only !");
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
    	}
   	});	
</script>