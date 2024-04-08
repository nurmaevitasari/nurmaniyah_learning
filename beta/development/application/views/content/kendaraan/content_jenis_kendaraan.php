<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
	<div class="row">
	    <div class="col-md-12">
		<h2>Users </h2>
	    </div>
	</div>              

	<hr />

<div class="table-responsive">
	<table id="example" class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Category</th>
				<th>Jenis</th>
				<th>Plat Nomor</th>
				<th>Action</th>
			</tr>

			<tr id="filterrow">
				<th>ID</th>
				<th>Username</th>
				<th>Category</th>
				<th>Jenis</th>
				<th>Plat Nomor</th>
				<th>Action</th>
			</tr>
		</thead>
		
		<tbody>
		<?php if($kendaraan)
		{
			foreach($kendaraan as $row)
			{ ?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['karyawan_id']; ?></td>
					<td><?php echo $row['kendaraan']; ?></td>
					<td><?php echo $row['jenis']; ?></td>
					<td></td>
				</tr>
			<?php 
			}
		} ?>

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
    orderCellsTop: true,
    'iDisplayLength': 100
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
