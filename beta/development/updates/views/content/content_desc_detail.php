<?php $file_url = $this->config->item('file_url'); ?>
<style type="text/css">

.dl-horizontal dt{
	width : 23%;
}

.dl-horizontal dd{
	margin-left: 25%;
}

.dl-horizontal > dd:after {
  display: table;
  content: "";
  clear: both;
}
	
</style>
<div class="col-md-12">
<dl class="dl-horizontal" >
	<dt>Job ID</dt>
	<dd><?php echo $detail['job_id']?></dd>
	<?php if($link_modul) {
		echo "<dt>CRM ID</dt>";
		echo "<dd>";
			foreach ($link_modul as $val) {
				if(in_array($_SESSION['myuser']['role_id'], array('1','2'))) { ?>
					<a target="_blank" href="<?php echo site_url('crm/details/'.$val['link_from_id']); ?>"><?php echo $val['link_from_id'] ?></a> ;
				<?php }else {
					echo $val['link_from_id']." ;";
					} 
			}
		echo "</dd>";
	}
	
	if ($detail['jenis_pekerjaan'] != 0){ ?>
	<dt>Job Type</dt>
	<?php } ?>
	<?php $jenis = $detail['jenis_pekerjaan'];
	
//////////////////////// SERVIS /////////////////////////////
	if($jenis == 1){ ?>
		<dd>Service</dd>
		<dt >No. SO</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
			<?php $a = new dateTime($detail['date_open']); 
  			echo date_format($a, 'd-m-Y H:i:s'); ?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Purchase Date</dt>
		<dd>
			<?php if($detail['tgl_beli'] != '0000-00-00')
				{
				$jadwal = new DateTime($detail['tgl_beli']);
				echo date_format($jadwal, 'd-m-Y'); 
			}elseif ($detail['tgl_beli'] == '0000-00-00') {
				echo '0000-00-00';
			}?>	
		</dd>
		<dt>Service Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Visit Frequency</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Service Schedule</dt>
		<dd><?php 
		if($detail['tgl_jadwal'] != '0000-00-00'){
		$jadwal = new DateTime($detail['tgl_jadwal']);
		echo date_format($jadwal, 'd-m-Y'); 
		}else{
			echo '00-00-0000';
		} ?>
		</dd>
		<dt>Job descriptions</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>
	
<!-- ///////////////////// INSTALASI ///////////////////// -->
	<?php }elseif ($jenis == 2) { ?>
		<dd>Installation</dd>
		<dt >No. SO</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Purchase Date</dt>
		<dd><?php 
			if($detail['tgl_beli'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_beli']);
				echo date_format($jadwal, 'd-m-Y'); ?>
			<?php }else{
				echo '00-00-0000';
				} ?>
		</dd>
		<dt>Installation Area</dt> 
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Frequency of Installation</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt class="dt">Installation Schedule</dt>
		<dd><?php if($detail['tgl_jadwal'] != '0000-00-00'){
		$jadwal = new DateTime($detail['tgl_jadwal']);
		echo date_format($jadwal, 'd-m-Y'); 
		}else{
			echo '00-00-0000';
		} ?>
		</dd>
		<dt>Installation Instructions</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- ////////////////////// SURVEY //////////////////////////// -->
	<?php }elseif ($jenis == 3) { ?>
		<dd>Survey</dd>
		<dt>No. Memo</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>Survey Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Frekuensi of Survey</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Survey Schedule</dt>
		<dd>
			<?php if($detail['tgl_jadwal'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_jadwal']);
				echo date_format($jadwal, 'd-m-Y'); 
			}else{
				echo '00-00-0000';
			} ?>
		</dd>
		<dt>Survey Instructions</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- //////////////// REKONDISI /////////////////////////// -->
	<?php }elseif ($jenis == 4) { ?>
		<dd>Recondition</dd>
		<dt>No. Memo</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Recondition Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Frekuensi of Recondition</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Recondition Schedule</dt>
		<dd>
			<?php if($detail['tgl_jadwal'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_jadwal']);
				echo date_format($jadwal, 'd-m-Y'); 
			}else{
				echo '00-00-0000';
			} ?>
		</dd>
		<dt>Recondition Instructions</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- //////////// MAINTENANCE //////////////////////////// -->
	<?php }elseif ($jenis == 5) { ?>
		<dd>Maintenance</dd>
		<dt >No. SO</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Purchase Date</dt>
		<dd><?php 
			if($detail['tgl_beli'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_beli']);
				echo date_format($jadwal, 'd-m-Y'); ?>
			<?php }else{
				echo '00-00-0000';
			} ?>
		</dd>
		<dt>Maintenance Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Number of Maintenance</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Maintenance Schedule</dt>
		<dd>
			<?php if($detail['tgl_jadwal'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_jadwal']);
				echo date_format($jadwal, 'd-m-Y'); 
			}else{
				echo '00-00-0000';
			} ?>
		</dd>
		<dt>Maintenance Instructions</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- //////////////// TRAINING ////////////////////////////////// -->
	<?php }elseif ($jenis == 6) { ?>
		<dd>Training</dd>
		<dt >No. SO</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Purchase Date</dt>
		<dd>
		<?php 
			if($detail['tgl_beli'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_beli']);
				echo date_format($jadwal, 'd-m-Y'); ?>
		<?php }else{
			echo '00-00-0000';
		} ?>
		</dd>
		<dt>Training Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Frequency of Training</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Training Schedule</dt>
		<dd>
			<?php if($detail['tgl_jadwal'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_jadwal']);
				echo date_format($jadwal, 'd-m-Y'); 
			}else{
				echo '00-00-0000';
			} ?>
		<dt>Instruksi Training</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- //////////////// PERAKITAN ////////////////////// -->
	<?php }elseif ($jenis == 7) { ?>
		<dd>Perakitan</dd>
		<dt>No. Memo/SPPB</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>Cabang Pelaksana</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Pengajuan Schedule Perakitan</dt>
		<dd><?php if($detail['tgl_jadwal'] != '0000-00-00'){
		$jadwal = new DateTime($detail['tgl_jadwal']);
		echo date_format($jadwal, 'd-m-Y'); 
		}else{
			echo '00-00-0000';
		} ?>
		</dd>
		<dt>Instruksi Perakitan</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- //////////// PERSIAPAN BARANG ///////////////////////-->
	<?php }elseif ($jenis == 8) { ?>
		<dd>Persiapan Barang</dd>
		<dt>No. Memo/SPPB</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>Gudang Pelaksana</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Deadline</dt>
		<dd>
			<?php if($detail['tgl_jadwal'] != '0000-00-00'){
				$jadwal = new DateTime($detail['tgl_jadwal']);
				echo date_format($jadwal, 'd-m-Y'); 
			}else{
				echo '00-00-0000';
			} ?>
		</dd>
		<dt>Instruksi Persiapan Barang</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>

<!-- ////////////////// KANIBAL //////////////////////// -->
	<?php }elseif ($jenis == 9) { ?>
		<dd>Canibal</dd>
		<dt>No. Memo</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
		<?php 
			$a = new dateTime($detail['date_open']); 
	  		echo date_format($a, 'd-m-Y H:i:s');
		?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Komponen untuk Job ID</dt>
		<dd><?= $detail['link_job_id']; ?>
		<dt>Cabang Pelaksana</dt>
		<dd><?= !empty($detail['areaservis']) ? $detail['areaservis'] : ''; ?></dd>
		<dt>Deadline</dt>
		<dd><?php 
		if($detail['tgl_jadwal'] != '0000-00-00'){
		$jadwal = new DateTime($detail['tgl_jadwal']);
		echo date_format($jadwal, 'd-m-Y'); 
		}else{
			echo '00-00-0000';
		} ?>
		<dt>Instruksi Kanibal</dt>  
		<dd><?= !empty($detail['sps_notes']) ? $detail['sps_notes'] : ''; ?></dd>
		<dt>Foto Sebelum Kanibal</dt>
		<dd>
		<?php if(!empty($file)){
			foreach ($file as $value) {
				if($value['type'] == 1){
					$a = new DateTime($value['date_created']);
        			echo date_format($a, 'd-m-Y H:i:s');
         		?>
        			<b style="color: #3992b0;"><?php echo $value['nickname']; ?></b> : 
        			<a target="_blank" href="<?php echo $file_url.'assets/images/upload/'.$value['file_name']; ?>"><?php echo str_replace("_", " ", $value['file_name']); ?></a> <br>
				<?php }
			}
		} ?>
		</dd>
		<dt>Foto Setelah Kanibal</dt>
		<dd>
		<?php if(!empty($file)){
			foreach ($file as $value) {
				if($value['type'] == 2){
					$a = new DateTime($value['date_created']);
        			echo date_format($a, 'd-m-Y H:i:s');
         		?>
        			<b style="color: #3992b0;"><?php echo $value['nickname']; ?></b> : 
        			<a target="_blank" href="<?php echo $file_url.'assets/images/upload/'.$value['file_name']; ?>"><?php echo str_replace("_", " ", $value['file_name']); ?></a> <br>
				<?php }
			}
		} ?>
		</dd>
		<dt>Foto Barang yang dikanibal</dt>
		<dd>
		<?php if(!empty($file)){
			foreach ($file as $value) {
				if($value['type'] == 3){
					$a = new DateTime($value['date_created']);
        			echo date_format($a, 'd-m-Y H:i:s');
         		?>
        			<b style="color: #3992b0;"><?php echo $value['nickname']; ?></b> : 
        			<a target="_blank" href="<?php echo $file_url.'assets/images/upload/'.$value['file_name']; ?>"><?php echo str_replace("_", " ", $value['file_name']); ?></a> <br>
				<?php }
			}
		} ?>
		</dd>
		<dt>Foto Setelah dilengkapi</dt>
		<dd>
		<?php if(!empty($file)){
			foreach ($file as $value) {
				if($value['type'] == 4){
					$a = new DateTime($value['date_created']);
        			echo date_format($a, 'd-m-Y H:i:s');
         		?>
        			<b style="color: #3992b0;"><?php echo $value['nickname']; ?></b> : 
        			<a target="_blank" href="<?php echo $file_url.'assets/images/upload/'.$value['file_name']; ?>"><?php echo str_replace("_", " ", $value['file_name']); ?></a> <br>
				<?php }
			}
		} ?>
		</dd>
	
	<?php }else{ ?>
		<dt >No. SO</dt>
		<dd><?= $detail['no_sps']; ?></dd>
		<dt>Date</dt>
		<dd>
			<?php $a = new dateTime($detail['date_open']); 
  			echo date_format($a, 'd-m-Y H:i:s'); ?>
		</dd>
		<dt>Customer</dt>
		<dd><?= $detail['perusahaan']; ?></dd>
		<dt>PIC</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['pic']; 
		}else{
			echo $detail['pic'];
		} ?>
		</dd>
		<dt>Phone</dt>
		<dd>
		<?php if ($non_cus){ 
			echo $non_cus['telepon']; 
		}else{
			echo $detail['telepon'];
		} ?>
		</dd>
		<dt>Product</dt>
		<dd><?php 
			if ($prod) {
				foreach ($prod as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?></dd>
		<dt>No. Serial</dt>
		<dd><?= $detail['no_serial']; ?></dd>
		<dt>Purchase Date</dt>
		<dd>
			<?php if($detail['tgl_beli'] != '0000-00-00')
				{
				$jadwal = new DateTime($detail['tgl_beli']);
				echo date_format($jadwal, 'd-m-Y'); 
			}elseif ($detail['tgl_beli'] == '0000-00-00') {
				echo '0000-00-00';
			}?>	
		</dd>
		<dt>Service Area</dt>
		<dd><?= $detail['areaservis']; ?></dd>
		<dt>Google Map</dt>
		<dd>
			<?php if(!empty($file))
  			{
    			foreach($file as $fs)
      			{
       				if($fs['file_name'] != '' AND $fs['type'] == '5') {

	        		echo date('d-m-Y H:i:s', strtotime($fs['date_created']));  ?>
	        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
	        		<a target="_blank" href="<?php echo $fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
        	 		<?php 
        			}
      			}
  			}  ?>    
		</dd>
		<dt>Frekuensi Kunjungan</dt>
		<dd><?= $detail['frekuensi']; ?></dd>
		<dt>Pengajuan Schedule Servis</dt>
		<dd><?php 
		if($detail['tgl_jadwal'] != '0000-00-00'){
		$jadwal = new DateTime($detail['tgl_jadwal']);
		echo date_format($jadwal, 'd-m-Y'); 
		}else{
			echo '00-00-0000';
		} ?>
		</dd>
		<dt>Uraian Pekerjaan</dt>  
		<dd><?= $detail['sps_notes']; ?></dd>
	<?php } ?>

<dt>Files</dt>  
<dd>
<?php

if(!empty($file))
  {
  	
    foreach($file as $fs)
      {
      ?>
        <?php 
        
        if($fs['file_name'] != '' AND $fs['type'] != '5'){
        	//if(strpos($fs['file_name'], 'xls') OR strpos($fs['file_name'], 'xlsx')){
        		//$a = new DateTime($fs['date_created']);
        		//echo date_format($a, 'd-m-Y H:i:s'); ?>

        		<!-- <b style="color: #3992b0;"><?php //echo $fs['nickname']; ?></b> : 
        		 <a target="_blank" href="#" onclick="window.open('<?php //echo site_url('test/load_excel/'.$fs['file_name']) ?>')"><?php //echo $fs['file_name']; ?></a><br> -->
        	<?php //}else{ 
        		$a = new DateTime($fs['date_created']);
        		echo date_format($a, 'd-m-Y H:i:s'); ?>

        		<b style="color: #3992b0;"><?php echo $fs['nickname']; ?></b> : 
        		<a target="_blank" href="<?php echo $file_url.'assets/images/upload/'.$fs['file_name']; ?>"><?php echo str_replace("_", " ", $fs['file_name']); ?></a> <br>
        	 <?php //}
        
        }
        
      
      }
  }
  ?>    
</dd>
    </dl>
</div>
    <br><br> 