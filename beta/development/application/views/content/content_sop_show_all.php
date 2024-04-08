<?php $user = $this->session->userdata('myuser'); ?>
<style type="text/css">
.dropdown-menu {
	    min-width: 0px;
	    width: 100%;
	    font-size: 12px;
	    left: 0px;
	}

	.dropdown-toggle{
		width: 113px;
	}	
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Proposal SOP</h2>
		</div>
	</div>
	<hr />

	<div>
		<a class ="btn btn-success" href="<?php echo site_url('C_sop/add/'); ?>"><i class="fa fa-plus"></i> New Proposal SOP</a>
	</div>
	<br />
	<br />

	<div class="table-responsive">
		<table id="example" class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Last Update</th>
					<th>Position</th>
					<th>SOP</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php $no = 1;
				foreach ($res as $row) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td>
							<?php echo date('d-m-Y H:i:s', strtotime($row['date_modified'])) ?><br>
							<b><?php echo "By : ".$row['nickname']; ?></b>
						</td>
						<td><?php echo $row['position']; ?></td>
						<td><?php echo $row['judul_sop']; ?></td>
						<td>
							<a target="_blank" href="<?php echo site_url('C_sop/details/'.$row['id']); ?>" type = "button" class="btn btn-default btn-sm">Detail</a>
						</td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
$('#example').DataTable({
	'iDisplayLength': 100
});
	
</script>
