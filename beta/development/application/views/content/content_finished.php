    <div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Table SPS</h2>
            </div>
        </div>
        <hr />
				
 <div class="table-responsive" >
		<table class="table table-hover">
			 <thead>
				 <tr>
					<th>No.</th>
					<th>No. SPS</th>
					<th>Tanggal</th>
					<!-- <th>Tanggal Kembali</th>
					 <th>Umur SPS</th> -->
					<th>Customer</th>
					<th>Tipe Produk</th>
					<th>Nama Produk</th>
					<th>No. Serial</th> 
					<th>Area Service</th>
					<th>Status</th>
					<th>Action</th>
				</tr> 
				
			</thead>
			 <tbody>
			<?php
				if($c_finished)
				{
					$x = 1;
					foreach($c_finished as $row)
				{
			?>
				<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $row['no_sps']; ?></td>
				<td><?php echo $row['date_open']; ?></td>
				<!-- <td><?php echo $row['date_close']; ?></td> -->
				<td><?php echo $row['perusahaan']; ?></td>
				<td><?php echo $row['kode']; ?></td>
				<td><?php echo $row['product']; ?></td>
				<td><?php echo $row['no_serial']; ?></td>
				<td><?php echo $row['areaservis']; ?></td>
				<?php if ($row['status'] == 'FINISHED'){ ?>
				<td><span class="label label-success">FINISHED</span></td>
				<?php }else{?>
				<td><span class="label label-danger"><?php echo $row['nama']; ?></span></td>
				<?php } ?>

				<td><a href="<?php echo site_url('c_tablesps_admin/update/'.$row['id']); ?>" >
				<button class="btn btn-default" >Detail</button></a>
				<a onclick="return confirm('Anda yakin akan menghapus ?')" href="<?php echo site_url('c_tablesps_admin/delete/'.$row['id']); ?>" >
				<button class="btn btn-info" >Hapus</button></a></td>
				</div>
				</tr>
			<?php
				$x++;
				}
				}
			?>
			</tbody> 
		</table>
		</div>
                
            <!-- /. PAGE INNER  -->
	</div>