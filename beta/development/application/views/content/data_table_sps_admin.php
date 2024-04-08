		<table class="table table-hover">
			 <thead>
				 <tr>
					<th>No.</th>
					<th>No. SPS</th>
					<th>Tanggal</th>
					<th>Customer</th>
					<th>Nama Produk</th>
					<th>Area Service</th> 
					<th>Umur SPS</th>
					<th>Status</th>
					<th>Action</th>
				</tr> 
				
			</thead>
			 <tbody>
			<?php
				if($c_tablesps_admin)
				{
					$x = 1;
					foreach($c_tablesps_admin as $row)
				{
			?>
				<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $row['no_sps']; ?></td>
				<td><?php echo $row['date_open']; ?></td>
				<td><?php echo $row['perusahaan']; ?></td>
				<td><?php echo $row['product']; ?></td>
				<td><?php echo $row['areaservis']; ?></td>
					
					<?php 
	$idSPS = $row['id'];
	$nama = $row['nama'];
	$a = "SELECT date_open FROM tbl_sps WHERE id = '$idSPS'";
	$b = $this->db->query($a);
	$c = $b->row_array();
	$coba = implode('', $c);
	$min = date('Y/m/d H:i:s', strtotime($coba));

	$a = "SELECT date_close FROM tbl_sps WHERE id = '$idSPS'";
	$b = $this->db->query($a);
	$c = $b->row_array();
	$coba2 = implode('', $c);
	$max = date('Y/m/d H:i:s', strtotime($coba2));

	$total = datediff($max, $min);

	$date = datediff($coba, date('Y/m/d H:i:s'));
     
 	$sql = "SELECT status FROM tbl_sps WHERE id = $idSPS";
 	$que = $this->db->query($sql);
 	$row = $que->row_array();
 	$implode = implode(" ", $row);

  if ($implode != 101) { ?>
    <td><?php echo $date['days']; ?> days <?php echo $date['hours']; ?> hours <?php echo $date['minutes']; ?> minutes <?php echo $date['seconds']; ?> seconds</td>
<?php  } else { ?>
    <td><?php echo $total['days']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes <?php echo $total['seconds']; ?> seconds</td>
<?php } ?>

				<?php if ($row['status'] == '101'){ ?>
				<td><span class="label label-success">FINISHED</span></td>
				<?php }else{?>
				<td><span class="label label-danger"><?php echo $nama; ?></span></td>
				<?php } ?>

				<?php 
					$karyawanID = $_SESSION['myuser']['karyawan_id'];
					$sql = "SELECT id_sps, overto, time_login FROM tbl_sps_log WHERE id_sps = '$idSPS' AND overto = '$karyawanID' AND time_login = '0000-00-00 00:00:00'";
					$query = $this->db->query($sql);
					$a = $query->row_array();  ?>
				<?php if ($a == TRUE) { 
					?>
				    <td><a href="<?php echo site_url('c_tablesps_admin/savetime/'.$idSPS); ?>" >
				<button class="btn btn-info" >Action</button></a></td>
				<?php }else{ ?>
				 <td><a href="<?php echo site_url('c_tablesps_admin/update/'.$idSPS); ?>" >
				<button class="btn btn-default" >Detail</button></a></td>
			<?php	} ?>
				
				
				</div>
				</tr>
			<?php
				$x++;
				}
				}
			?>
			</tbody> 
		</table>