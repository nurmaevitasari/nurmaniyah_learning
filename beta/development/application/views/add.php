<!DOCTYPE html>
<html lang="en">
<head>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js" ></script>
	<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" type="text/css" /> -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" type="text/css" />
</head>
<body>
	<?php if($this->session->flashdata('warning')) : ?>
<h1><?php echo $this->session->flashdata('warning'); ?></h1>
<?php endif; ?>
	 <?php echo form_open_multipart('upload/proses') ?>
<div class="form-group">
    <div class="copy">
        <div class=" col-lg-3">
           <a href="javascript:void(1);" class="glyphicon glyphicon-plus" id="add">Tambah</a>
        </div>
    </div>
</div>
 <div class="count" id="1"></div>
  <div class="form-group col-lg-12">
         <div class="form-group col-lg-6">
            <input type="file" name="image_1" > 
        </div>
    <div class="paste" >
    </div>              
</div> 
<div class="form-group col-lg-5">
                <button type="submit" class="btn btn-default">Submit</button>
</div>
<?php echo form_close(); ?>
<script>
$(document).ready(function(){
    $( "#add" ).click(function() {
        var count = $('.count').attr('id');
            count = parseInt(count) + 1;
    $('.count').attr('id',count)
            var html   =  ' <div class="form-group col-lg-6">';
                html  +=   '<input type="file" name="image_'+count+'" >';
                html  += '</div>';
            $('.paste').append(html);
        });

})
</script>
</body>
</html>