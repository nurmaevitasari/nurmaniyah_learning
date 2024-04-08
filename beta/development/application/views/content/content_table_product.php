<?php $user = $this->session->userdata('myuser'); ?>
    <div id="page-inner">

		<div class="row">

			<div class="col-md-12">

				<h2>Products and Spareparts List</h2>

            </div>

        </div>

        <hr />

				

 <div class="table-responsive" >

		<table class="table table-hover" id="example">

			<thead>

				 <tr>

					<th>No.</th>

					<th>Kode</th>

					<th>Product</th>
 <?php if (($user['role_id'] == 1) || ($user['role_id'] == 6) || ($user['role_id'] == 9)): ?>
					 <th>Action</th>
<?php endif ?>
				</tr>

				<tr id="filterrow">

					<th>No.</th>

					<th>Kode</th>

					<th>Product</th>
 <?php if (($user['role_id'] == 1) || ($user['role_id'] == 6) || ($user['role_id'] == 9)): ?>
					 <th>Action</th>
<?php endif ?>
				</tr> 

			</thead>

			 <tbody>

			
      <?php  if($c_product)

        {

          $x = 0;

          foreach($c_product as $row)

        {

      ?>
				<tr>

				<td><?php echo ++$x;?></td>
    <td><?php echo $row['kode']; ?></td>
    <td><?php echo $row['product']; ?></td>	

<?php if (($user['role_id'] == 1) || ($user['role_id'] == 6) || ($user['role_id'] == 9)): ?>
	<td>
				<a class="btn btn-submit" href="<?php echo site_url('c_product/delete/'.$row['id']); ?>" 

			onclick="return confirm('Anda yakin akan menghapus ?')">

			<button class="btn btn-submit" >Hapus</button></a>

			 <a class="btn btn-info" href= "<?php echo site_url('c_product/update/'.$row['id']); ?>">

				<i class="icon-edit icon-white"></i> Edit </a> 

			</td>
<?php endif ?>
				</tr>

			<?php } }?>

			</tbody> 

		</table>

		</div>
		</div>

<script type="text/javascript">
$('#example thead tr#filterrow th').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" onclick="stopPropagation(event);" class="form-control" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
var table = $('#example').DataTable( {
    orderCellsTop: true  
} );
     
    // Apply the filter
    $("#example thead input").on( 'keyup change', function () {
        table
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
    } );

  function stopPropagation(evt) {
		if (evt.stopPropagation !== undefined) {
			evt.stopPropagation();
		} else {
			evt.cancelBubble = true;
		}
	}
	</script>