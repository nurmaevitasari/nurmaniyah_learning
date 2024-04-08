<?php $this->load->view("iheader");  ?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading"><b>Daftar Pegawai</b>
		</div>
		<div class="panel-body">
			<p><?php $this->session->flashdata('pesan');  ?></p>
			<a href="<?php echo site_url('c_home/add');  ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i></a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode Pegawai</th>
						<th>Nama Pegawai</th>
						<th>Alamat</th>
						<th>No Tlp</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($query)) { ?>
					<tr>
						<td colspan="6"> Data Tidak Ditemukan</td>
					</tr>
					<?php }else{
						$no=0;
						foreach ($query as $rquery) {
							$no++;
					 ?>
					 <tr>
					 	<td><?php echo $no; ?></td>
					 	<td><?php echo $rquery->kd_pegawai; ?></td>
					 	<td><?php echo $rquery->nm_pegawai; ?></td>
					 	<td><?php echo $rquery->alamat; ?>, <?php $rquery->kota; ?>, <?php $rquery->provinsi; ?></td>
					 	<td><?php $rquery->no_telp; ?></td>
					 	<td>
					 		<div class="btn-group">
					 			<a href="c_home/edit/<?php $rquery->kd_pegawai; ?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
					 			<a href="c_home/aksi/del/<?php $rquery->kd_pegawai; ?>" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin menghapus data ini ?')"><i class="glyphicon glyphicon-trash"></i></a>
					 		</div>
					 	</td>
					 </tr>
					 <?php }} ?>
				</tbody>
			</table>			
		</div>
	</div>
</div>
<?php $this->load->view('ifooter'); ?>