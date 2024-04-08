<?php $file_url = $this->config->item('file_url');
function secondsToTime($seconds) {
    //$dtF = new DateTime('@0');
    //$dtT = new DateTime("@$seconds");
    //return $dtF->diff($dtT)->format('%yY %mM %aD');

    $min = date('1970/01/01'); 
    $max = date('Y/m/d', $seconds);

    $ttl = datediff($min, $max);
    return $ttl['years']."Y ".$ttl['months']."M ".$ttl['days']."D";

}

function aging($datetime) {
    $min = date('Y-m-d H:i:s'); 
    $max = date($datetime);

    $ttl = datediff($min, $max);
    return $ttl['years']."Y ".$ttl['months']."M ".$ttl['days']."D ";
    //print_r($ttl);    
   	} ?>

<style type="text/css">
	.thumbnail {
	max-width: 170px;
}


.tbls dt {
	font-weight: normal;
	text-align: left;
	width: 70px;
}

.tbls dd {
	margin-left: 80px;
}

.lbl-5 {
	background-color: #EF711D;
}

.lbl-7 {
	background-color: black;
}

.lbl-8 {
	background-color: red;
}

.lbl-9 {
	background-color: #51504f;
}

.killed {
	background-color: #FAD2D0;
}

</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Detail Tool</h2>
        </div>
    </div>
    <hr />
	<dl class="dl-horizontal" >
		<dt>Nama</dt>
		<dd><?php echo $holder['nama']; ?></dd>
		<dt>Jumlah Tools</dt>
		<dd><?php echo $holder['jml_tools']." items"; ?></dd>
		<dt>Total Harga Tools</dt>
		<dd><?php echo "Rp. ".number_format($holder['total_harga'], "0", ",", "."); ?></dd>
		<dt>Umur Rata-rata Tools</dt>
		<dd><?php echo secondsToTime($holder['umur']); ?></dd>
		<dt>Kehilangan Tools</dt>
		<dd><?php echo $holder['tool_loss'].' items'; ?></dd>
		<dt>Total Kehilangan</dt>
		<dd><?php echo "Rp. ".number_format($holder['price_loss'], "0", ",", "."); ?></dd>
		<dt>Tools Rusak</dt>
		<dd><?php echo $holder['tool_kill']; ?></dd>
		<dt>Total Kerusakan</dt>
		<dd><?php echo "Rp. ".number_format($holder['price_kill'], "0", ",", "."); ?></dd>
	</dl>
	<br>
	<br>
	<div class="table-responsive">
		<table class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Photo</th>
					<th>Handover Descriptions</th>
					<th>Tools Aging</th>
					<th>Handover</th>
					<th>Reporting & Status</th>
					<th>Details</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$co = count($tbl_holder); //print_r($co);
				foreach ($tbl_holder as $row) { 
					$rep = $mtools->lastReportStatus($row['id']);
					?>
					<tr class="<?php if($rep['status'] == '9') { echo 'killed'; } ?>">
						<td><?php echo $no; ?></td>
						<td>
							<div >
							      <a href = "<?php echo $file_url.'assets/images/upload_tools/'.$row['file_name']; ?>" class = "thumbnail" target="_blank">
							         <img src = "<?php echo $file_url.'assets/images/upload_tools/'.$row['file_name']; ?>" class="img-responsive" alt = "<?php echo $row['file_name']; ?>">
							      </a>
							   </div>
						</td>
						<td>
							<dl class="tbls dl-horizontal">
								<dt>Tool ID</dt>
								<dd><?= !empty($row['code']) ? $row['code'] : '-'; ?></dd>
								<dt>Code Asset</dt>
								<dd><?= !empty($row['code_asset']) ? $row['code_asset'] : '-'; ?></dd>
								<dt>Name</dt>
								<dd><?= !empty($row['name']) ? $row['name'] : '-'; ?></dd>
								<dt>Type</dt>
								<dd><?= !empty($row['type']) ? $row['type'] : '-'; ?></dd>
								<dt>Brand</dt>
								<dd><?= !empty($row['brand']) ? $row['brand'] : '-'; ?></dd>
								<dt>S.N</dt>
								<dd><?= !empty($row['serial_number']) ? $row['serial_number'] : '-'; ?></dd>
								<dt>Condition</dt>
								<dd><?= !empty($row['tool_condition']) ? $row['tool_condition'] : '0'; ?>%</dd>
								<dt>Price</dt>
								<dd><?php echo "Rp. ".number_format($row['price'], "0", ",", "."); ?></dd>
								<dt>Qty</dt>
								<dd><?= !empty($row['quantity']) ? $row['quantity'] : '0'; ?></dd>
							</dl>
						</td>
						<td>
							<?php
							/*  "<input type='hidden' value='".$co."' id='co'>";
							echo "Tools Age : <input type='hidden' class='aging_tools_".$no."' value='".$row['date_created']."'><span name='aging_tools_".$no."'></span>";
							echo "<br>";
							echo "On Hand Age :<input type='hidden' class='aging_onhand_".$no."' value='".$row['date_holder']."'><span name='aging_onhand_".$no."'></span>"; */
							echo "Tools Age : <br>".aging($row['date_created']);
							echo "<br>";
							echo "On Hand Age : <br>".aging($row['date_holder']);
							 ?>
						</td>
						<td>
							<?php $handover = $mtools->lastHandOver($row['id']);
							if($handover) {
								echo date('d-m-Y H:i:s', strtotime($handover['date_created']))."<br>";
								echo "Hand Over By : ".$handover['nama_pemberi']."<br>";
								echo "Accepted By : ".$handover['nama_penerima']."<br>";
							}else {
								echo "-";
							} ?>
						</td>
						<td>
							<?php 
							if($rep) {
								echo "Status : <span class = 'label lbl-".$rep['status']."'>".$rep['type_status']."</span><br>";
								echo "Last Report : ".date('d-m-Y H:i:s', strtotime($rep['date_created']))."<br>";
								echo "Condition : ".$rep['kondisi']."%<br>";
								if($rep['status'] == '8') {
									echo "<br>";
									echo date('d-m-Y H:i:s', strtotime($rep['date_kill']));
									echo "<br>";
									echo $rep['user_kill']." Propose to Kill";
									echo "<br>";
								}elseif($rep['status'] == '9') {
									echo "<br>";
									echo date('d-m-Y H:i:s', strtotime($rep['date_kill']));
									echo "<br>";
									echo $rep['user_kill']." Propose to Kill";
									echo "<br>";
									echo date('d-m-Y H:i:s', strtotime($rep['date_acc']));
									echo "<br>";
									echo " Killed By ".$rep['user_acc'];
									echo "<br>";

								}
								
							} ?>
							
						</td>
						<td><a href="<?php echo site_url('c_tools/detail_tool/'.$row['id']); ?>" class="btn btn-default btn-sm">Tool Details</a></td>
					</tr>
				<?php 
				$no++;
				} ?>
				
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
$(".table-hover").dataTable({
	'iDisplayLength': 100
});
function updateClock() {
	var co = document.getElementById( 'co' ).value;
	//alert(co);
		for (var ii = 1; ii <= co; ii++) {
			//alert(ii);
	    $('.aging_tools_'+ ii).each(function() {
	     // var proses = document.getElementById("proses");
	       var startDateTime = new Date( $(this).attr('value') );
	     
	        startStamp = startDateTime.getTime();
	        newDate = new Date();
	        newStamp = newDate.getTime();
	        var diff = Math.round((newStamp - startStamp) / 1000);
	        var d = Math.floor(diff / (24 * 60 * 60));
	       /* though I hope she won't be working for consecutive days :) */
	      diff = diff - (d * 24 * 60 * 60);
	        var h = Math.floor(diff / (60 * 60));
	        diff = diff - (h * 60 * 60);
	        var m = Math.floor(diff / (60));
	        diff = diff - (m * 60);
	        var s = diff;
	 
	        var xxx = d + "D " + h + "H " + m + "M ";
	        document.getElementsByName("aging_tools_"+ ii)[0].innerHTML=xxx;
	    });

	    $('.aging_onhand_' + ii).each(function() {
	     // var proses = document.getElementById("proses");
	       var startDateTime = new Date( $(this).attr('value') );
	      
	        startStamp = startDateTime.getTime();
	        newDate = new Date();
	        newStamp = newDate.getTime();
	        var diff = Math.round((newStamp - startStamp) / 1000);
	        var d = Math.floor(diff / (24 * 60 * 60));
	       /* though I hope she won't be working for consecutive days :) */
	      diff = diff - (d * 24 * 60 * 60);
	        var h = Math.floor(diff / (60 * 60));
	        diff = diff - (h * 60 * 60);
	        var m = Math.floor(diff / (60));
	        diff = diff - (m * 60);
	        var s = diff;
	 
	        var xxx = d + "D " + h + "H " + m + "M ";
	        document.getElementsByName("aging_onhand_" + ii)[0].innerHTML=xxx;
	    });
	}
	}
setInterval(updateClock, 1000);	    
</script>		    