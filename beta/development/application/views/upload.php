<!DOCTYPE html>
<html lang="en">
<head>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js" ></script>
</head>
<body>
 <a href="<?php echo site_url('upload/add'); ?>" class="btn btn-default">Tambah</a><br>
<div id="container">
<?php echo 'test'; ?>
         <!-- cek apakah $list ada datanya -->
	 <?php if(is_array($list)) : 	 ?>

         <!-- jika ada di looping sebanyak data yang di database -->
            <?php foreach($list as $row) : ?>
            <img src="<?php echo base_url('assets/'.$row); ?>
			<?php echo $row['nama']; ?>" alt="Responsive image" class="img-rounded"  height="200" width="200">
            <?php endforeach; ?>
       <?php endif; ?>
</div>

</body>
</html>