<?php $user = $this->session->userdata('myuser');
		$file_url = $this->config->item('file_url');
 ?>
<style type="text/css">
.thumbnail {
	max-width: 170px;
}

.btn-xs {
	 margin-top : 4px;
}

.thumb-report{
	max-height: 150px;
}

.form-horizontal .label-loss {
	text-align: left;
}

.lbl-loss {
	//background-color: grey;
	width: 320px;
}

.inp {
	width: 95%;
}

.thumb-kill {
	
}

.btn-edit {
	background-color: #47A447;
}

.killed {
	background-color: #FAD2D0;
}


</style>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>LIST TOOLS</h2>
        </div>
    </div>
    <hr />
				
 	<div class="table-responsive" >
		<table id="example" class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th style="width: 150px;">Photo</th>
					<th>ID Tools</th>
					<th>Name</th>		
					<th>Tool Holder</th>
					<th>Quantity</th>
					<th>Notes</th>
					<th>Status</th>
					<th style="width: 50px;">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if($listTools) {
					foreach ($listTools as $row) { ?>
						<tr class="<?php if($row['status'] == '9' ) { echo 'killed'; }  ?>">
							<td class="id-tool"><?php 
								$id = $row['id'];
							echo $id; ?></td>
							<td>
								<div >
							      <a href = "<?php echo $file_url.'assets/images/upload_tools/'.$row['file_name']; ?>" class = "thumbnail" target="_blank">
							         <img src = "<?php echo $file_url.'assets/images/upload_tools/thumb_tools/'.$row['file_name']; ?>" class="img-responsive" alt = "<?php echo $row['file_name']; ?>">
							      </a>
							   </div>
							<!-- <img src="<?php //echo base_url('assets/images/upload_tools/'.$row['file_name']); ?>"> -->
							</td>
							<td class="code-tool"><?php echo $row['code']; ?></td>
							<input type="hidden" name="price" value="<?php echo 'Rp. '.number_format($row['price'],'0',',','.'); ?>">
								<input type="hidden" name="tipe" value="<?php echo $row['type']; ?>">
								<input type="hidden" name="brand" value="<?php echo $row['brand']; ?>">
							<td class="name-tool"><?php echo $row['name']; ?></td>
							<td><?php if($row['nickname']) { echo $row['nickname']; }else{ echo "Available"; } ?></td>
							<td><?php echo $row['quantity']; ?></td>
							<td><?php echo $row['notes']; ?></td>
							<td><?php echo $row['st_type']; ?></td>
							<td>
								<center>
									<a href="<?php echo site_url('C_tools/detail_tool/'.$id); ?>" class="btn btn-default btn-xs" title="Details" target="_blank" >Details</a><br>
									<?php if(in_array($user['position_id'], array('1', '2', '55', '56', '57', '58', '59', '95', '9', '77', '18')) OR $user['karyawan_id'] == $row['user_holder'] OR $user['karyawan_id'] == '16' ) { ?>
										<a href="<?php echo site_url('C_tools/editTool/'.$id); ?>" class="btn btn-success btn-edit btn-xs" title="Edit">Edit</a>
										<button class="btn btn-info btn-xs" title="Tool Report" onclick="openModal(this)" data-btn="report">Tool Report</button> <br>
										
										<button class="btn btn-primary btn-xs" title="Hand-Over" onclick="openModal(this)" data-btn="handover">Hand-Over</button><br>
										
										<button class="btn btn-warning btn-xs" title="Loss Report" onclick="openModal(this)" data-btn="loss">Loss Report</button> <br>
										<?php if($row['status'] != '8' AND $user['position_id'] != '77') { 	?>
											<button class="btn btn-danger btn-xs" title="Kill Tool" onclick="openModal(this)" data-btn="kill">Kill Tool</button> <br>
										<?php } ?>
									<?php } elseif(in_array($_SESSION['myuser']['position_id'], array('60', '62', '75', '83')) OR $row['nickname'] == $_SESSION['myuser']['nickname'] AND $row['status'] != '7' AND empty($row['sts_kill'])) { ?>
										
										<button class="btn btn-info btn-xs" title="Tool Report" onclick="openModal(this)" data-btn="report">Tool Report</button> <br>
										
										<button class="btn btn-primary btn-xs" title="Hand-Over" onclick="openModal(this)" data-btn="handover">Hand-Over</button><br>
										
										<button class="btn btn-warning btn-xs" title="Loss Report" onclick="openModal(this)" data-btn="loss">Loss Report</button> <br>
										<?php if($row['status'] != '8' AND $user['position_id'] != '77') { 	?>
											<button class="btn btn-danger btn-xs" title="Kill Tool" onclick="openModal(this)" data-btn="kill">Kill Tool</button> <br>
										<?php } ?>		
									<?php } ?>
									<?php if($_SESSION['myuser']['position_id'] == '77' AND $row['sts_kill'] != '1') { ?>
											<a href="<?php echo site_url('C_tools/acc_kill/'.$id); ?>" class="btn btn-danger btn-xs" title="ACC Kill Tool" onclick="return confirm('<?php echo $row['name']." ini akan di Kill. Lanjutkan ?" ?>')">ACC Kill Tool</a><br>
										<?php } ?>			
								</center>
							</td>
        				</tr>
				<?php	}
					} ?>
			</tbody>
		</table>
	</div>
</div>

<!-- ######### REPORT TOOL ####### -->
    <div class="modal fade" id="myModalReport" role="dialog" method="post">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_status" role="form" action="<?php echo site_url('C_tools/listTools'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<h4>Tool Report</h4>
						<p style="font-size: 12px;">** Laporan Tool wajib dilakukan tepat waktu demi kelancaran operasional<br>
						** Sistem laporan ini adalah "Self Assesment" yaitu penilaian sendiri & swalayan.<br>
						** Melaporkan Tool dengan jujur & tepat waktu akan membantu kinerja diri sendiri.
						</p>
					</div>
					<div class="modal-body">
						<div class="row">
						<div class="col-sm-8">
						<div class="form-group">
								<input type="hidden" name="id_tool" class="form-control idtool">
								<input type="hidden" name="report" class="form-control idtool" value="report">
							<label class="control-label col-sm-3">ID Tool</label>
							<div class="col-sm-9">
								<input type="text" class="form-control codetool" readonly="true">
							</div>
						</div>	
						<div class="form-group">	
							<label class="control-label col-sm-3">Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control nametool" readonly="true">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Last Condition</label>
							<div class="col-sm-9" >
								<select class="form-control" name="condition" style="width: 100%;" required="true">
									<option value="">-Pilih-</option>
									<option value="100">100% - Baru</option>
									<option value="90">90% - Sangat Bagus</option>
									<option value="80">80% - Cukup Bagus</option>
									<option value="70">70% - Lumayan</option>					
									<option value="60">60% - Masih bisa dipakai</option>
									<option value="50">50% - Kurang Bagus</option>
									<option value="30">30% - Jelek</option>
									<option value="10">10% - Hancur</option>
								</select>
							</div>  
						</div>
						</div>
						<div class="col-sm-4">
							<div class="thumbnail">
							      <a href = "" target="_blank" class="report">
							         <img class="gambar thumb-report" src = "" class="img-responsive" alt = "<?php echo $row['file_name']; ?>">
							      </a>
							   </div>
						</div>

						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Notes</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="notes" rows="3"></textarea>
							</div>
						</div>
						<div class="form-group row file-row-rep" id="file-row-rep-1">
							<label class="control-label col-sm-2">Last Photo</label>
							<div class="controls col-sm-8">
								<input class="" type="file" name="repuserfile[]">
							</div>
							<div class="col-sm-1">
								<button type="button" cat="rep" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>			
						</div>
						<div id="add-row-rep">

						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left'>Submit</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>
<!-- ############## HAND OVER ############-->
    <div class="modal fade" id="myModalHandOver" role="dialog" method="post">
		<div class="modal-dialog ">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_status" role="form" action="<?php echo site_url('C_tools/listTools'); ?>">
					<div class="modal-header">
						<h4>Hand-Over Tools</h4>
						<p style="font-size: 12px;">** Hand-Over Tools dilakukan oleh masing-masing leader kepada anggota tim.<br>
						** Hand-Over harus sah diketahui pihak penerima dan pemberi. <br>
						** Tools yang telah di Hand-Over otomatis akan berpindah secara fisik & tanggung jawabnya.
						</p>
					</div>
					<div class="modal-body">
						<div class="form-group">
								<input type="hidden" name="id_tool" class="form-control idtool">
								<input type="hidden" name="handover" class="form-control idtool" value="handover">
							<label class="control-label col-sm-2">ID Tool</label>
							<div class="col-sm-10">
								<input type="text" class="form-control codetool" readonly="true">
							</div>
						</div>	
						<div class="form-group">	
							<label class="control-label col-sm-2">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control nametool" readonly="true">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-sm-2">Penerima</label>
							<div class="col-sm-10">
								<select class="form-control" name="penerima" style="width: 100%;">
									<option value="">-Pilih-</option>
									<?php foreach ($employee as $emp) { 
										if ($emp['id'] != $user['karyawan_id']) { ?>
											<option value="<?php echo $emp['id']; ?>"><?php echo $emp['nama']; ?></option>
										
										<?php } 
									} ?>
								</select>
							</div>		
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Notes</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="notes" rows="3"></textarea>
								<p style="font-size: 10px;">** Diisi catatan penting ketika tools akan diserahterimakan. Misalnya perawatan tools. Contoh : pergantian oli, kampas, filter, pelumasan, pembersihan, kalibrasi, setting, peggantian consumable, penggantian baterai berkala, service berkala, dll.</p>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left'>Submit</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>
<!-- ######## KILL TOOLS ############# -->
    <div class="modal fade" id="myModalKill" role="dialog" method="post">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_status" role="form" action="<?php echo site_url('C_tools/listTools'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<h4>Kill Tools</h4>
						<p style="font-size: 12px;">** Kill Tools adalah prosedur untuk mematikan tools selamanya dari daftar tools.<br>
						** Kill Tools diajukan oleh leader dengan alasan yang dapat dipertanggungjawabkan beserta bukti-bukti bahwa tools tersebut layak untuk di Kill demi kelancaran operasional.<br>
						** Kill Tools hanya dapat di ACC oleh Direktur Keuangan setelah mempelajari pengajuan Kill Tools ini.
						</p>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
										<input type="hidden" name="id_tool" class="form-control idtool">
										<input type="hidden" name="kill" class="form-control idtool" value="kill">
									<label class="control-label col-sm-3">ID Tool</label>
									<div class="col-sm-9">
										<input type="text" class="form-control codetool" readonly="true">
									</div>
								</div>	
								<div class="form-group">	
									<label class="control-label col-sm-3">Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control nametool" readonly="true">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="thumbnail">
								      <a href = "" target="_blank" class="thumb-kill">
								         <img class="gambar thumb-kill" src = "" class="img-responsive" alt = "<?php echo $row['file_name']; ?>">
								      </a>
								   </div>
							</div>

						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Alasan Kill Tools</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="notes" rows="4"></textarea>
							</div>
						</div>
						<div class="form-group row file-row-kill" id="file-row-kill-1">
							<label class="control-label col-sm-2">Foto alasan Kill Tools</label>
							<div class="controls col-sm-8">
								<input class="" type="file" name="killuserfile[]">
							</div>
							<div class="col-sm-1">
								<button type="button" cat="kill" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>			
						</div>
						<div id="add-row-kill">

						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left'>Submit</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>
<!-- ########## LOSS REPORT ############ -->
    <div class="modal fade" id="myModalLoss" role="dialog" method="post">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" method="post" id="form_status" role="form" action="<?php echo site_url('C_tools/listTools'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<h4>Loss Report</h4>
						<p style="font-size: 12px;">** Kehilangan tools harus dilaporkan secepat mungkin agar tidak mengganggu operasional.<br>
						** Harus dilaporkan dengan jujur ditanggulangi dikemudian hari.<br>
						** Kehilangan tools yang dilaporkan dengan benar akan segera diganti oleh perusahaan.
						</p>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-3">
								<div class="thumbnail">
								    <a href = "" target="_blank" class="report gambar">
								        <img class="gambar thumb-report" src = "" class="img-responsive" alt = "<?php echo $row['file_name']; ?>">
								    </a>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="form-group">
										<input type="hidden" name="id_tool" class="form-control idtool">
										<input type="hidden" name="loss" class="form-control idtool" value="loss">
									<label class="control-label col-sm-2 label-loss">ID Tool</label>
									<div class="col-sm-10">
										<input type="text" class="form-control codetool" readonly="true">
									</div>
								</div>	
								<div class="form-group">	
									<label class="control-label col-sm-2 label-loss">Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control nametool" readonly="true">
									</div>
								</div>
								<div class="form-group">	
									<label class="control-label col-sm-2 label-loss">Type</label>
									<div class="col-sm-10">
										<input type="text" class="form-control typetool" readonly="true">
									</div>
								</div>
								<div class="form-group">	
									<label class="control-label col-sm-2 label-loss">Brand</label>
									<div class="col-sm-10">
										<input type="text" class="form-control brandtool" readonly="true">
									</div>
								</div>
								<div class="form-group">	
									<label class="control-label col-sm-2 label-loss">Price</label>
									<div class="col-sm-10">
										<input type="text" class="form-control pricetool" readonly="true" value="">
									</div>
								</div>
							</div>
							
							
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4 lbl-loss">Tanggal Kehilangan</label>
							<div class="col-sm-7">
								<input type="text" name="tgl_hilang" class="form-control inp">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4 lbl-loss">Tools Baru </label>
							<div class="col-sm-1" >
								<div class="radio">
									<input type="radio" name="tools_baru" value="1" required="true"> Perlu
								</div>	
							</div>
							<div class="col-sm-2" >
								<div class="radio">
									<input type="radio" name="tools_baru" value="0" required="true"> Tidak Perlu
								</div>
							</div>
							
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label lbl-loss">Permohonan Waktu Pengadaan</label>
							<div class="col-sm-7">
								<input type="text" name="tgl_pengadaan" class="form-control inp">
							</div>
						</div>
 
						<div class="form-group">
							<label class="control-label col-sm-4 lbl-loss">Alasan Kehilangan</label>
							<div class="col-sm-7">
								<textarea class="form-control inp" name="notes" rows="4"></textarea>
							</div>
						</div>	
				
					<div class="modal-footer">
						<button type="submit" class='btn btn-info pull-left'>Report</button>
						<a class="btn btn-default" data-dismiss="modal">Close</a>
					</div>
				</form>
			</div>
		</div>
    </div>


<script type="text/javascript">
	$("#example").DataTable({
		'iDisplayLength': 100
	});

	$("input[name='tgl_hilang'], input[name='tgl_pengadaan']").datetimepicker({
		format : "DD/MM/YYYY",
	});

	function openModal(e) {
		
		var btn = $(e).data('btn');
		var name = $(e).closest("tr").find("td.name-tool").html();
	    var code = $(e).closest("tr").find("td.code-tool").html();
	    var id = $(e).closest("tr").find("td.id-tool").html();
	    var photo = $(e).closest("tr").find("td img").attr('src');
	    var price = $(e).closest("tr").find("input[name='price']").val();
	    var brand = $(e).closest("tr").find("input[name='brand']").val();
	    var tipe = $(e).closest("tr").find("input[name='tipe']").val();
	    

	    var mdlid = $(".idtool").val(id);
	   	var mdlname = $(".nametool").val(name);
	   	var mdlcode = $(".codetool").val(code);

		if(btn == 'take') {
			mdlid.val(id);
			mdlname.val(name);
			mdlcode.val(code);

	    	$("#myModalHolder").modal('show');

		}else if (btn == 'report') {

			$("#myModalReport").modal('show');
			//alert(photo);
			$(".report").attr("href", photo);
			$(".gambar").attr("src", photo);
			
		}else if (btn == 'loss') {
			$("#myModalLoss").modal('show');
			$(".typetool").val(tipe);
			$(".brandtool").val(brand);
			$(".pricetool").val(price);
			$(".gambar").attr("src", photo);
			$(".gambar").attr("href", photo);					


		}else if (btn == 'kill') {

			$(".thumb-kill").attr("href", photo);
			$(".thumb-kill").attr("src", photo);
			$("#myModalKill").modal('show');

		}else if (btn == 'handover') {
			mdlid.val(id);
			mdlname.val(name);
			mdlcode.val(code);

	    	$("#myModalHandOver").modal('show');
		}   	
	}

	$('body').delegate('.btn-add-file', 'click', function(){
		cat = $(this).attr('cat');

		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		html = '<div class="form-group row file-row-'+cat+'" id="file-row-'+cat+'-'+(length+1)+'">'+
				'<label class="control-label col-sm-2">&nbsp;</label>'+
				'<div class="controls col-sm-8">'+
					'<input class="" type="file" name="'+cat+'userfile[]">'+
				'</div>'+
				'<div class="col-sm-2">'+
					'<button type="button" cat="'+cat+'" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
					'&nbsp;&nbsp;<button type="button" cat="'+cat+'" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+						
				'</div>'+	
			'</div>';

		$('#add-row-'+cat).append(html);	
	});

	$('body').delegate('.btn-remove-file', 'click', function(){
		cat = $(this).attr('cat');
		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		if(length > 1)
		{
			$('#file-row-'+cat+'-'+id).remove();
		}	
	});	  
</script>
