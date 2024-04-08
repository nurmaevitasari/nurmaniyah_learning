<?php $file_url = $this->config->item('file_url'); ?>
<style type="text/css">
	b {
		color: #3A52A1;
	}
</style>
<table class="table table-hover " style="font-size: 12px;">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th>User</th>
			<th>Descriptions</th>
			<th>Notes</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	$no = count($log);
	foreach ($log as $row) { 

		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?></td>
			<td><?php echo $row['logtype']; ?></td>
			<td><?php switch ($row['log_type']) {
				    case "5":
				        echo $row['reporter'];
				        break;
				    case "6":
				        echo $row['penerima'];
				        break;
				    case "7":
				        echo $row['user_loss'];
				        break;
				    case "8":
				        echo $row['user_kill'];
				        break;        
				    default:
				        echo "";
				} ?>			
			</td>
			<td><?php switch ($row['log_type']) {
				    case "5":
				        echo "<b>Last Condition : </b>".$row['rep_kondisi']."%<br>";
				        if($row['rep_notes']) {
				        	echo "<b>Note : </b>".$row['rep_notes']."<br>";
				    	}
				        $photos = $mtools->getPhotoTools($row['tool_id'], '5');
				        if($photos) {
					        echo "<b>Photos : </b>";
					        foreach ($photos as $val) { ?>
					        	<li class='list-unstyled'><a target = '_blank' href="<?php echo $file_url.'assets/images/upload_tools/'.$val['file_name']; ?>"><?php echo $val['file_name']; ?></a></li>
					        <?php }
					        echo "<br>";
				    	}
				        break;
				    case "6":
				        echo $row['pemberi']." <b>hand over</b> to ".$row['penerima'].". <br>";
				        $photos = $mtools->getPhotoTools($row['tool_id'], '6');
				        echo "<b>Note : </b>".$row['ho_notes'];
				        break;
				    case "7":
				        echo "<b>Tgl Kehilangan : </b>".date('d-m-Y', strtotime($row['date_loss']))."<br>";
				        echo "<b>Pengadaan Tools Baru : </b>"; 
				        	if($row['repurchased'] == '1' ) { 
				        		echo "Perlu"; 
				        	}else{ 
				        		echo "Tidak Perlu"; 
				        	} 
				        echo "<br>";
				        echo "<b>Alasan Kehilangan : </b>".$row['loss_notes']."<br>";
				        if($row['date_estimasi_tools'] != '0000-00-00') {
				        	echo "<b>Permohonan waktu pengadaan : </b>".date('d-m-Y', strtotime($row['date_estimasi_tools']))."<br>";
				        }else {
				        	echo "<b>Permohonan waktu pengadaan : - </b><br>";
				        }	
				        break;
				    case "8":
				    	echo "<b>Alasan Kill Tools : </b>".$row['kill_notes']."<br>";
				        $photos = $mtools->getPhotoTools($row['tool_id'], '8');
				        echo "<b>Photos : </b><br>";
				        foreach ($photos as $val) { ?>
				        	<li class='list-unstyled'><a target = '_blank' href="<?php echo $file_url.'assets/images/upload_tools/'.$val['file_name']; ?>"><?php echo $val['file_name']; ?></a></li>
				        <?php } 
				        break;        
				    
				} ?></td>
				<td>
				<?php $psn = $mtools->getPesan($row['id']); 
				if($psn) {
					foreach ($psn as $val) {
						echo date('d/m/Y H:i:s', strtotime($val['date_created']));
						echo " <b style='color:#177EE5;'>".$val['nickname']."</b> : ";
						echo $val['pesan'];
						echo "<br>";
					}
				}
				?>	
				<br>
				<?php if($_SESSION['myuser']['role_id'] != '15') { ?>
					<button class="btn btn-primary btn-xs" data-id = "<?php echo $row['id']; ?>" onclick="ModalMsg(this)"><span class="fa fa-plus"></span> Notes</button></td>
				<?php } ?>
		</tr>

	<?php $no--;	} ?>
		
	</tbody>

</table>
<hr />