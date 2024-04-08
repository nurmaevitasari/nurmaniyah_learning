<style type="text/css">
	.progress-bar-Introduction {
		background-color: #447A34;
	}
	.progress-bar-Quotation {
		background-color: #2B9A21;
	}
	.progress-bar-Negotiation {
		background-color: #21B42B;
	}
	.progress-bar-Deal {
		background-color: #66DB1D;
	}
	.progress-bar-Loss {
		background-color: #000000;
	}

	.progress {
		margin-bottom: 7px;
	}
</style>
<div id="page-inner">
	<a class="btn btn-default" onclick="history.back(-1)">
        <span class="fa fa-arrow-left"></span> BACK
    </a>
	<div class="row">
		<div class="col-md-12">
			<h2>Table CRM</h2>
		</div>
	</div>
	<hr />

	<div class="table-responsive">
		<table class="table table-hover" id="tablecrm" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No</th>
					<?php if($this->uri->segment(3) == 'fin') {
						echo "<th>Deal Date</th>";
					}elseif ($this->uri->segment(3) == 'lost') {
						echo "<th>Loss Date</th>";
					} ?>
					<th>CRM ID</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Product & Prospect Description</th>					
					<th style="width: 120px;">Progress</th>
					<?php if($this->uri->segment(3) == 'fin') {
						echo "<th>Deal Value</th>";
					}elseif ($this->uri->segment(3) == 'lost') {
						echo "<th>Prospect Value</th>";
					} ?>
					<th>Last Update</th>	
					<th>Note</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if($crm) {
					$i = count($crm);
					foreach ($crm as $row) { ?>
						<tr>
							<td><?php echo $i; $i--;?></td>
							<td><span style="display : none;"><?php echo $row['date_closed']; ?></span><?php echo date('d-m-Y H:i:s', strtotime($row['date_closed'])); ?></td>
							<td class="id_crm"><?php echo $row['id']; ?></td>
							<td><span style="display : none;"><?php echo $row['date_created']; ?></span><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?><br>
							<b><?php echo strtoupper($row['divisi']); ?> - <?php echo $row['nickname']; ?></b>
							</td>
							<td><?php echo $row['perusahaan']; ?><br>
								<?php echo $row['pic']; ?>
							</td>
							<td><?php echo $row['prospect']; ?><br>
								Competitor : <?php echo $row['competitor']."<br>"; 
								if($row['link_modul'] == '2' AND $row['link_modul_id']) {
									echo "Delivery By : <a target='_blank' href='".site_url('c_delivery/details/'.$row['link_modul_id'])."'>Delivery ID ".$row['link_modul_id']."</a>";
								} ?>
							</td>
							<td>				
								<div class="progress">
									<?php 
									if($row['progress'] == 'Introduction') {
										echo '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';	

									}else if($row['progress'] == 'Quotation') {
										echo '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
									    echo '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';

									}else if($row['progress'] == 'Negotiation') {
										echo '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
									    echo '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';
									    echo '<div class="progress-bar progress-bar-Negotiation" role="progressbar" style="width:25%"></div>';
									
									}else if ($row['progress'] == 'Deal') {
										echo '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
									    echo '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';
									    echo '<div class="progress-bar progress-bar-Negotiation" role="progressbar" style="width:25%"></div>';
										echo '<div class="progress-bar progress-bar-Deal" role="progressbar" style="width:25%"></div>';
									} ?>
								</div>
								
								<?php 
									if($row['status_closed'] == 'Loss' AND $row['date_closed'] != '0000-00-00 00:00:00') {
										echo "<b style='color : red; '>Loss Stage</b>  <br>";

										$x = $row['date_closed'];
										$y = $row['date_created'];
										$diff = datediff($x, $y);
										echo $diff['days_total']." Days"; 
									}elseif($row['status_closed'] == 'Deal' AND $row['date_closed'] != '0000-00-00 00:00:00') {
										echo $row['progress']." Stage <br>";

										$x = $row['date_closed'];
										$y = $row['date_created'];
										$diff = datediff($x, $y);
										echo $diff['days_total']." Days"; 
									}else {
										echo $row['progress']." Stage <br>";

										$x = date('Y-m-d H:i:s');
										$y = $row['date_created'];
										$diff = datediff($x, $y);
										echo $diff['days_total']." Days";
									} ?>

							</td>
							<td><?php 
								if($this->uri->segment(3) == 'fin') {
									$value = $row['deal_value'];
								}elseif($this->uri->segment(3) == 'lost') {
									$value = $row['prospect_value'];
								}
								echo "Rp. ".number_format($value, "0", ",", "."); ?><br>
								Posibilities : <?php echo $row['posibilities']; ?>%
							</td>
							<td><span style="display: none;"><?php echo $row['last_followup']; ?></span><?php echo date('d-m-Y H:i:s', strtotime($row['last_followup'])); ?>
							</td>
							<td ondblclick="OpenNote(this)" id = "n_<?php echo $row['id']; ?>">
								<?php if(!empty($row['note'])) {
									echo $row['notes']."<br> <span style='font-size: 10px;'>".
									$row['date_notes']."<br> Edit By : <b>".$row['user_notes']."</b></span>";
									} ?>
							</td>
							<td>
								<center><a href="<?php echo site_url('c_crm/details/'.$row['id']); ?>" class="btn btn-default btn-sm" style="margin-bottom: 2px;"> Detail</a>	
								<!-- <a href="<?php //echo site_url('c_crm/edit/'.$row['id']); ?>" class="btn btn-primary btn-sm"> Edit</a></center> -->
							</td>
						</tr>	
					
				<?php }	} ?>
			</tbody>
		</table>
	</div>

<div class="modal fade" id="myModalNotes" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Notes</h3>
            </div>
            <div class="modal-body form">
                <form id="form_notes" class="form-horizontal">
                    <textarea rows="4" name="notes" class="form-control tx-notes"></textarea>
                    <input type="hidden" name="id_crm" id= "idcrm">
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-primary notes-save" onclick="SaveNote()">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>
  
  

<script type="text/javascript">
$(document).ready(function() {
	crm = '<?php echo $this->uri->segment(3) ?>';
	if(crm == 'fin') {
		crm = 'Dealt';
	}else {
		crm = 'Lost';
	}
	
	$('h2').html(crm + " CRM");
});	

table = $("#tablecrm").DataTable({
	"aaSorting": [[1, "desc"]],
    'iDisplayLength': 100
});


function OpenNote(e) {
	$("#myModalNotes").modal('show');
	id = $(e).closest('tr').find('td.id_crm').text();
	$("#idcrm").val(id);
}

function SaveNote()
{
	note = $(".tx-notes").val();
	$.ajax({
        url : "<?php echo site_url('C_crm/addNotes'); ?>",
        type: "POST",
        data: $('#form_notes').serialize(),
        success: function(data)
        {
        	html = note + 
        	"<br> <span style='font-size: 10px;'><?php echo date('Y-m-d H:i:s'); ?><br> Edit By : <b><?php echo $_SESSION['myuser']['nickname']; ?> </b></span>";
            $('#myModalNotes').modal('hide');
            $('#n_' + id).html(html);
            $('#form_notes')[0].reset();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        	console.log(jqXHR);
        }
    });
}


</script>
