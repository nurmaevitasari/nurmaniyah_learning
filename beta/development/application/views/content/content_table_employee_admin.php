    <div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Table Employees</h2>
            </div>
        </div>
        <hr />
				
 <div class="table-responsive" >
		<table class="table table-hover" id="example">
			<thead>
				 <tr>
					<th>No.</th>
					<th>NIK</th>
					<th>Name</th>
					<th>Position</th>
					<th>Action</th>
				</tr> 
				
			</thead>
			 <tbody>
			<?php
				if($c_employee)
				{
					$x = 1;
					foreach($c_employee as $row)
				{
			?>
				<tr>
				<td><?php echo $x; ?>
				<td><?php echo $row['nik']; ?></td>
				<td><?php echo $row['nama']; ?></td>
				<td><?php echo $row['position']; ?></td>		
				<td>
				<a class="btn btn-submit" href="<?php echo site_url('c_employee_admin/delete/'.$row['id']); ?>" 
			onclick="return confirm('Anda yakin akan menghapus ?')">
			<button class="btn btn-submit" >Hapus</button></a>
			 <a class="btn btn-info" href= "<?php echo site_url('c_employee_admin/update/'.$row['id']); ?>">
				<i class="icon-edit icon-white"></i> Edit </a> 
			</td>
			
				</tr>
			<?php
				$x++;
				}
				}
			?>
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
