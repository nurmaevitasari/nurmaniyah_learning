<?php $user = $this->session->userdata('myuser'); ?>
<?php $file_url = site_url();?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">
<link href="<?php echo site_url('assets/css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">


<style type="text/css">
	.scroll2
	{
		height:400px;
	  	display: block;
	  	overflow-y: scroll;
	  	scroll-behavior: smooth;
	  	width: auto;
	}

	.badge-active {
	  background-color: green;
	  color: white;
	  padding: 4px 8px;
	  text-align: center;
	  border-radius: 5px;
	}

	.badge-non-active {
	  background-color: red;
	  color: white;
	  padding: 4px 8px;
	  text-align: center;
	  border-radius: 5px;
	}

</style>


<div id="page-inner">
		<div class="row">
			   <div class="col-md-12 row">

			   	<div class='col-sm-6'>
				   	<button class='btn btn-default btn-sm' style='background-color: grey;'> <span class="glyphicon glyphicon-step-backward"></span>Back</button> 
					<h1>Detail Materi</h1>
				</div>

				<div class='col-sm-6'>

					<a class='btn btn-warning btn-sm pull-right' href="<?php echo site_url('Modul_materi/edit/'.$detail['id']);?>"> <span class="glyphicon glyphicon-pencil"></span>Update</a>

					<?php 

					if($detail['status_modul'] =='Active')
					{?>
						<a class='btn btn-danger btn-sm pull-right' href="<?php echo site_url('Modul_materi/update_status_nonactive/'.$detail['id']);?>">Non Active</a>

					<?php }else
					{?>
						<a class='btn btn-success btn-sm pull-right' href="<?php echo site_url('Modul_materi/update_status_active/'.$detail['id']);?>">Active</a>


					<?php }?>
				</div>

          </div>
        </div>
        <hr />

 		<div class="col-sm-12 row">
	        <div class="col-sm-6">
	        	<table class="table table-hover">
	        		<tr>
	        			<th>ID</th>
	        			<td><?php echo $detail['id'];?></td>
	        		</tr>

	        		<tr>
	        			<th>Date Created</th>
	        			<td><?php echo $detail['date_created'];?></td>
	        		</tr>

	        		<tr>
	        			<th>Kode Materi</th>
	        			<td><?php echo $detail['kode_modul'];?></td>
	        		</tr>

	        		<tr>
	        			<th>Nama Materi</th>
	        			<td><?php echo $detail['nama_materi'];?></td>
	        		</tr>

	        		<tr>
	        			<th>User Created</th>
	        			<td><?php echo $detail['username'];?></td>
	        		</tr>


	        		<tr>
	        			<th>Status</th>
	        			<td>
	        				<?php 

	        				if($detail['status_modul']=='Active')
	        				{
	        					echo '<span class="badge-active">Active</span>';
	        				}else
	        				{
	        					echo '<span class="badge-non-active">Non Active</span>';
	        				}?>
	        			</td>
	        		</tr>


	        		<tr>
	        			<th>Views</th>
	        			<td><?php echo $detail['views'];?></td>
	        		</tr>

	        	</table>
	        </div>
	    </div>




        <div class="col-sm-12">

    		<div <?= (count($files) >= '5') ? "class='scroll2'" : ''; ?> >
		    <div class="row">
		    	<div>
			    	<?php foreach ($files as $gallery ) 
			    	{
			    		$pathinfo = pathinfo($gallery['file_name']); 
						$ext      = strtolower($pathinfo["extension"]);


			    	 ?>
			    		<div style="margin-left:5px; margin-right: 99px;">
				        	<div class="col-md-2">

				        	<?php 

				        	if($ext == 'pdf'){ ?>
				        		<div style="margin-top: 30px;">
							        <a target = "_blank" href="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>">
							          <img src="<?php echo base_url('assets/images/logo-pdf.png'); ?>" class="img-responsive img-thumbnail" style="width: 130px;height: 100px;margin-top: 0px;">
							        </a>
							    </div>
							<?php }elseif (in_array($ext, array('avi','mpeg','mp4','3gp','m4v','flv'))) {?>
								<div style="margin-top: 30px;">
							        <a target = "_blank" href="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>">
							          <img src="<?php echo base_url('assets/images/logo-video.png'); ?>" class="img-responsive img-thumbnail" style="width: 130px;height: 100px;margin-top: 0px;">
							        </a>
							    </div>
							<?php }elseif (in_array($ext, array('docx', 'doc'))) {?>
								<div style="margin-top: 30px;">
							        <a target = "_blank" href="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>">
							          <img src="<?php echo base_url('assets/images/word.png'); ?>" class="img-responsive img-thumbnail" style="width: 130px;height: 100px;margin-top: 0px;">
							        </a>
							    </div>
							<?php }elseif (in_array($ext, array('xlsx', 'xls'))) {?>
								<div style="margin-top: 30px;">
							        <a target = "_blank" href="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>">
							          <img src="<?php echo base_url('assets/images/excel.png'); ?>" class="img-responsive img-thumbnail" style="width: 130px;height: 100px;margin-top: 0px;">
							        </a>
							    </div>
				        	<?php }else{ ?>


				        		<div class="popup-gallery" style="margin-top: 30px;">

							        <a  href="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>">
							          <img src="<?php echo $file_url.'assets/images/upload_foto_materi/'.$gallery['file_name']; ?>" class="img-responsive img-thumbnail" style="width: 500px;height: 150px;margin-top: 0px;">
							        </a>


							    	</div>
							<?php } ?>
							</div>
				        </div>
					<?php } ?>
				</div>
		    </div>
			</div>
			    <br><br><br>
        </div>

        <br><br><br>
        <h3>Isi Materi <button class='btn btn-primary btn-sm pull-right'><span class="glyphicon glyphicon-pencil"></span> Update Materi</button></h3>
        <div style="border:solid 1px #ccc; padding:10px; height:400px; overflow:auto; color:black;">
        	<?php echo $text['materi'];?>
        </div>


</div>

<script type="text/javascript">
	
  $('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			
		}
	});

</script>