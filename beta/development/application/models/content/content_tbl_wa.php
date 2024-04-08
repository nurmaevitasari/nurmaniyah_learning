<?php $file_url = $this->config->item('file_url'); ?>
<div id="page-inner"> 
	<div class="row">
		<div class="col-md-12">
				<h2>WA Material</h2>
		</div>
	</div>
	
	<hr>
	<?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '13', '102'))) { ?>
		<a href="c_tbl_wa/add" class="btn btn-danger">+ Add</a>
	<?php 	} ?>
	
	<br>
	<br>
	 <div class="table-responsive" >
        <table class="table table-hover" style="font-size: 12px;">
          <thead>
			<tr>
	            <th>ID</th>
	            <th>Divisi</th>
				<th>Product</th>
				<th>File</th>
          </tr>
		  </thead>
		<tbody>
		<?php if($wa) {
			foreach($wa as $row ) { ?>
			<tr>
				<td><?php echo $row['id'] ?></td>
				<td><?php echo strtoupper($row['divisi']); ?></td>
				<td><?php echo $row['product'] ?></td>
				<td><a href="<?php echo $file_url.'/assets/images/upload_wa/'.$row['file']; ?>" target="_blank"><?php echo $row['file'] ?></a></td>
			</tr>
		
		<?php	}
		 } ?>
		 </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	$("table").DataTable();
</script>