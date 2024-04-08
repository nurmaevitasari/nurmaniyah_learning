<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>Users </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
				<div class="table-responsive">
		<table id="example" class="table table-hover">
			<thead>
				<tr>
					<th>Id.</th>
					<th>Username</th>
					<th>Login as</th>
					<?php if ($user['role_id'] == 1): ?>
					<th>Action</th>	
					<?php endif ?>
				</tr>

				<tr id="filterrow">
					<th>Id.</th>
					<th>Username</th>
					<th>Login as</th>
					<?php if ($user['role_id'] == 1): ?>
					<th>Action</th>	
					<?php endif ?>
				</tr>
		</thead>
		<tbody>
		<?php
			if($c_admin)
			{
				$x = 1;
				foreach($c_admin as $row)
			{
		?>
			<tr>
			<td><?php echo $x; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['role']; ?></td>
			<?php if ($user['role_id'] == 1): ?>
			<td><a class="btn btn-submit" href="<?php echo site_url('c_admin/delete/'.$row['id']); ?>" 
			onclick="return confirm('Anda yakin akan menghapus ?')">
			<button class="btn btn-submit" >Hapus</button></a>
			</td>
			<?php endif ?>
			</tr>
			<?php 
			$x++;
			}
			}
			?>
			
		</tbody>
		</table>
		</div>  
				 <!-- /. ROW  -->           
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
