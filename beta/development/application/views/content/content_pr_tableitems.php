<?php $file_url = $this->config->item('file_url'); ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>No</th>
			<th>Vendor</th>
			<th>Items</th>
			<th>Qty to Purchase</th>
			<th>Stock on Hand</th>
			<th>MOU</th>
			<th>Files</th>
		</tr>
	</thead>

	<tbody>
		<?php $no = 1; 
		foreach ($loadItems as $row) { ?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $row['vendor']; ?></td>
				<td><?php echo $row['items']; ?></td>
				<td><?php echo $row['qty']; ?></td>
				<td><?php echo $row['stock']; ?></td>
				<td><?php echo $row['mou']; ?></td>
				<td><?php $files = $pr->getFiles($row['pr_id'], $row['id'], '0'); 
					foreach ($files as $fs) { ?>
						<a href="<?php echo $file_url.'assets/images/upload_pr/'.$fs['file_name']; ?>" target="_blank"><?php echo $fs['file_name'] ?></a><br>
					<?php } ?>
				</td>
			</tr>
		<?php $no++; } ?>
	</tbody>
</table>
<br>
<br>
<br>
<br>