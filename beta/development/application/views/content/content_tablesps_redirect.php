 
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
					<th>Tanggal Kembali</th>
					<!-- <th>Umur SPS</th> -->
					<th>Customer</th>
					<th>Tipe Produk</th>
					<!-- <th>Nama Produk</th> --> 
					<th>No. Serial</th> 
					<th>Area Service</th>
					<th>Status</th>
					<th>Action</th>
				</tr> 
				
			</thead>
			 <tbody>
			<?php
				if($c_tablesps)
				{
					$x = 1;
					foreach($c_tablesps as $row)
				{
			?>
				<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $row['no_sps']; ?><input type=hidden name="idSPS" value="<?php echo $idSPS;?>"></td>
				<td><?php echo $row['date_open']; ?></td>
				<td><?php echo $row['date_close']; ?></td>
				<td><?php echo $row['nama']; ?></td>
				<td><?php echo $row['kode']; ?></td>
				<td><?php echo $row['no_serial']; ?></td>
				<td><?php echo $row['areaservis']; ?></td>
				<td><span class="label label-danger"><?php echo $row['status']; ?></span></td>
				<div>
				<td><a href="<?php echo site_url('c_redirect_sps/update/'.$row['id']); ?>" >
				<button class="btn btn-default" >Detail</button></a></td></div>
			
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