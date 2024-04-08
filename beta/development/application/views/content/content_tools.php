<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>MY TOOLS</h2>
			<p>Self Assesment Tools Management & Report</p>
			<br>
			<p style="font-size: 12px;">** My Tools bertujuan untuk mengelola aset alat-alat kerja milik Indotara agar digunakan maksimal untuk kepentingan perusahaan.<br>
			** My Tools menitikberatkan pada tanggungjawab personal akan alat-alat kerja yang telah dititipkan kepadanya.<br>
			** Gunakan modul ini dengan konsisten agar efesiensi pengadaan tools dapat tercapai dan kelancaran operasional lebih maksimal</p>
        </div>
    </div>
    <hr />
				
 	<div class="table-responsive" >
		<table id="example" class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Position</th>
					<th>Tools in hand</th>
					<th>Last Report</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php $no = 1;
				if($holder) {
					foreach ($holder as $row) { ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $row['nickname']; ?></td>
							<td><?php echo $row['position']; ?></td>
							<td><?php if($row['jml_tools'] != '0') {
								echo "Total ".$row['jml_tools']." items / Rp. ".number_format($row['ttl_price'], "0", ",", ".");
								}else{
									echo "Total ".$row['jml_tools']." items/ Rp. 0";
								} ?>
							</td>
							<td><?php $tgl = $mtools->date_report($row['user_holder']);
							if(($tgl['tgl_rep'])) { echo date('d-m-Y H:i:s', strtotime($tgl['tgl_rep'])); }else { echo date('d-m-Y H:i:s', strtotime($row['date_tool'])); }
							?></td>
							<td><a href="<?php echo site_url('C_tools/detail_holder/'.$row['user_holder']); ?>" class="btn btn-default">Details</a></td>
							
						</tr>

					<?php $no++; }
				} ?>
				
			</tbody>
			 
		</table>
	</div>
</div>

<script type="text/javascript">
	$("#example").DataTable({
		'iDisplayLength': 100
	});
</script>
