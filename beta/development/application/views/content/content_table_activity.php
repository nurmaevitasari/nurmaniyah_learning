<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Daily Activity</h2>
		</div>
	</div>
	<hr />
	
	<a class="btn btn-danger" href="<?php echo site_url('C_wishlist/add_activity'); ?>"><i class="fa fa-plus"></i> Activity</a>
	<br />
	<br />

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tanggal</th>
					<th>Nama</th>
					<th>Descriptions</th>					
					<th>Remarks</th>	
				</tr>
			</thead>
			<tbody>
				<?php if($activity) {
					foreach ($activity as $act) { ?>
					 	<tr>
							<td><?php echo $act['id']; ?></td>
							<td><span style="display: none;"><?php echo $act['date_created'] ?></span>
								<?php echo date('d/m/Y', strtotime($act['date_created'])); ?>
							</td>
							<td><?php echo $act['nama']; ?></td>
							<td><?php echo $act['description']; ?></td>
							<td><?php echo $act['remarks'] ?></td>
						</tr>	
					<?php } 
				} ?>	
			</tbody>
		</table>
	</div>

</div>	

<script type="text/javascript">
	$("table").dataTable({
		"aaSorting": [[1, "desc"]],
		'iDisplayLength': 100
	});
</script>