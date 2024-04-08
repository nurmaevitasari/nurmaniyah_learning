<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Table Customer</h2>
            </div>
        </div>
        <hr />

        <div class="table-responsive">
<table id="example" class="table table-hover " style="font-size: 12px">
<thead>
  <tr>
    <th>No.</th>
	<th>ID Customer</th>
	<th>Nama Perusahaan</th>
	<th>Alamat</th>
	<th>PIC</th>
	<th>No. Telepon</th>
  <?php if (($user['role_id'] == 6) || ($user['role_id'] == 1)): ?>
  <th>Action<th>  
  <?php endif ?>
  </tr>
  </thead>
  <tbody>
  <!--Script view yang dipakai -->
<?php

        if($c_customer)

        {

          $x = 0;

          foreach($c_customer as $row)

        {

      ?>
  <tr>
    <td><?php echo ++$x;?></td>
    <td width="100px"><?php echo $row['id_customer']; ?></td>
    <td><?php echo $row['perusahaan']; ?></td>
    <td class="col-md-3"><?php echo $row['alamat']; ?></td>
    <td><?php echo $row['pic']; ?></td>
    <td class="col-md-3"><?php echo $row['telepon']; ?></td>
    <?php if (($user['role_id'] == 6) || ($user['role_id'] == 1)): ?>
    <td class="col-md-2">
      <a class="btn btn-submit" title="Hapus" href="<?php echo site_url('c_customer/delete/'.$row['id']); ?>" onclick="return confirm('Anda yakin akan menghapus ?')">
      <button class="btn btn-submit" ><span class="fa fa-trash-o"></span></button></a>
       <a class="btn btn-info" title="Edit" href= "<?php echo site_url('c_customer/update/'.$row['id']); ?>">
        <i class="fa fa-edit"></i></a> 
      </td>
        <?php endif ?>
      </tr>
  <?php } }?>
  </tbody>
</table>

</div>
</div>

  <script>
  $(document).ready(function() {
    $('#example').DataTable();

  } );
  </script>