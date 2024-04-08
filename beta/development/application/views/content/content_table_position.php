<?php $user = $this->session->userdata('myuser'); ?>
    <div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Positions List</h2>
            </div>
        </div>
        <hr />
				
 <div class="table-responsive" >
		<table class="table table-hover">
			<thead>
				 <tr>
					<th>No.</th>
					<th>Position</th>
					<?php if (($user['role_id'] == 8) || ($user['role_id'] == 1)): ?>
					<th>Action</th>	
					<?php endif ?>
				</tr> 
				
			</thead>
			 <tbody>
			<?php
				if($c_position)
				{
					$x = 1;
					
				foreach($c_position as $row)
				
				{
			?>
				<tr>
				<td><?php echo $x; ?>
				<td><?php echo $row['position']; ?></td>
				<?php if (($user['role_id'] == 8) || ($user['role_id'] == 1)): ?>
				<td>
				<a class="btn btn-submit" href="<?php echo site_url('c_position/delete/'.$row['id']); ?>" 
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
	</div>