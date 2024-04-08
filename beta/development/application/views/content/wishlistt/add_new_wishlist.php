<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>New Wishlist</h2>
		</div>
	</div>
	<hr />

	<?php if($this->session->flashdata('message')){
				echo "<div class='alert alert-success'>
						<span class='fa fa-check-circle fa-lg'></span> Data berhasil ditambahkan
						<span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
					</div>";
				} ?>

	<form method="post" action="<?php echo site_url('c_wishlist/add_wishlist'); ?>" enctype = "multipart/form-data">
		<div class="form-group">
			<label>Date</label>
			<input type="text" name="tgl" class="form-control" value="<?php echo date('d/m/Y'); ?>" disabled="true">
		</div>
		<div class="form-group">
			<label>Wish To</label>
			<select class="form-control" name="wish_to" required="true">
				<option value="">- Pilih -</option>
				<?php foreach ($karyawan  as $kar) { ?>
					<option value="<?php echo $kar['id']; ?>"><?php echo $kar['nama']; ?> - <?php echo $kar['position']; ?></option>
				<?php	} ?>
			</select>
		</div>
		<div class="form-group">
			<label >Title</label>
			<input type="text" name="title" class="form-control" required="true">
		</div>
		<div class="form-group">
			<label>Descriptions</label>
			<textarea rows="5" name ="txt" id="fr"></textarea>
		</div>
		<div class="form-group file-row" id="file-row-1">
			<label class="col-sm-12">Files</label>
			<div class="col-sm-10">
				<input type="file" name="userfiles[]">
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>
		</div>
		<div id="add-row">

		</div>
		

		<div>
		<br />
		<br />
		<br />
    		<input type="submit" name="submit" value="Submit" class="btn btn-info">
    	</div>
    </form>
</div>	
  
<script> 
	
	CKEDITOR.replace('fr', {
		 customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js'); ?>'
	});
	

	$('body').delegate('.btn-add-file', 'click', function(){
			var id = $(this).data('id');

			var length = $('.file-row').length;

			html = 	'<div class="form-group file-row" id="file-row-'+(length+1)+'">' +
						'<label class="col-sm-12">&nbsp;</label>'+
						'<div class="col-sm-10">' +
							'<input type="file" name="userfiles[]">' +
						'</div>' +
						'<div class="col-sm-2">' +
							'<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>' +
							'&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>' +
						'</div>' +
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

