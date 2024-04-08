<div id="ketentuan" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<!-- konten modal-->
			<div class="modal-content">
			<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Ketentuan</h4>
				</div>
				<!-- body modal -->
				<form method="post" action="<?php echo site_url('c_ketentuan/simpanSOP') ?>">
					<div class="modal-body">
						<textarea type="text" id="kt" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
						<input type="hidden" value="8" name="nama_modul">
						<input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
					</div>
					<!-- footer modal -->
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFollowUp" role="dialog">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form action = "<?php echo site_url('crm/FollowUp'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Follow Up</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Date</label>
	            		<div class="col-sm-4">
	            			<input type="text" name="tgl_follow" id="tgl_follow" class="form-control">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">PIC</label>
	            		<div class="col-sm-8">
	            			<input type="text" name="pic" id="pic" class="form-control">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Follow Up Via</label>
	            		<div class="col-sm-8">
	            			<select name="via" class="form-control" style="width: 100%;">
	            				<option value="">-Pilih-</option>
	            				<option value="Email">Email</option>
	            				<option value="Kunjungan">Kunjungan / Meeting</option>
	            				<option value="Sms">SMS</option>
	            				<option value="Telepon">Telepon</option>
	            				<option value="Wa">WA</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Hasil Follow Up</label>
	            		<div class="col-sm-8">
	            			<textarea name="hasil" id="hasil" class="form-control" rows="4"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProgress" role="dialog">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
        	<form action = "<?php echo site_url('crm/UpProgress'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Update Progress</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Date</label>
	            		<div class="col-sm-4">
	            			<input type="text" name="tgl_upprgs" id="tgl_upprgs" class="form-control" required="true">
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress</label>
	            		<div class="col-sm-8">
	            			<select name="progress" class="form-control" style="width: 100%;" required="true" id="sel-progress">
	            				<option value="">-Pilih-</option>
	            				<option value="2">Introduction</option>
	            				<option value="3">Quotation</option>
	            				<option value="4">Negotiation</option>
	            				<?php if($detail['status_closed'] != 'Deal') { ?>
	            					<option value="5">Deal</option>
	            				<?php } ?>
	            				<option value="1">Loss</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group row" id="dealvalue">
						<label class="control-label col-sm-3 dealvalue">Deal Value (Rp)</label>
						<div class="col-sm-8">
							<input type="text" name="deal_value" class="form-control" onkeyup="splitInDots(this)" placeholder="Enter Integer Number" id="deal_value" value="<?php echo number_format($detail['prospect_value'], "0", ",", "."); ?>">
							<p style="font-size: 12px;" id="pdeal">Wajib diisi dengan harga final deal berikut PPn</p>
						</div>
					</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Posibilities</label>
	            		<div class="col-sm-8">
	            			<select name="posibilities" class="form-control" style="width: 100%;" required="true">
	            				<option value="">-Pilih-</option>
	            				<option value="10">10%</option>
	            				<option value="20">20%</option>
	            				<option value="30">30%</option>
	            				<option value="40">40%</option>
	            				<option value="50">50%</option>
	            				<option value="60">60%</option>
	            				<option value="70">70%</option>
	            				<option value="80">80%</option>
	            				<option value="99">99%</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group row" id="competitor">
						<label class="control-label col-sm-3">Update Competitor</label>
						<div class="col-sm-8">
							<input type="text" name="competitor" class="form-control" id="competitorid" value="<?php echo $detail['competitor']; ?>">
						</div>
					</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress Note</label>
	            		<div class="col-sm-8">
	            			<textarea name="prgs_note" id="prgs_note" class="form-control" rows="4"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="prgs_btn" class="btn btn-primary" name="submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalContributor" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('crm/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Add Contributor</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Contributor</label>
	            		<div class="col-sm-8">
	            			<select name="contributor[]" class="form-control" style="width: 100%;" multiple="true">
	            				<option value="">-Pilih-</option>
	            				<?php if($karyawan) {
	            					foreach ($karyawan as $kar) { ?>
	            						<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
	            					<?php }
	            					} ?>
	            			</select>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalMsg" role="dialog" method="post">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" method="post" action='<?php echo site_url('crm/add_pesan'); ?>'; onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Adding...'; ">
				<div class="modal-header">
					<h4>Add Message</h4>
				</div>
				<div class="modal-body">
					<br>
					<div class="form-group">
						<div class="col-md-12">
							<textarea class="form-control" rows="6" name="msg" id="msg" required=""></textarea>
							<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type='submit' class='btn btn-info pull-left' value='Add' name="submit_btn" id="add_btn">
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalUpload" role="dialog" method="post">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('crm/uploadFile/');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Uploading...'; ">
				<div class="modal-header">
					<h4>Upload Files</h4>
				</div>
				<div class="modal-body">
					<div class="form-group file-row " id="file-row-1">
						<div class="row col-sm-12">
							<div class="controls col-sm-10">
								<input class="" type="file" name="userfile[]">
							</div>
							<div class="col-sm-2">   
								<button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>
						</div>
					</div>
					<div id="add-row">

					</div>
					<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
				</div>
				<div class="modal-footer">
					<input type="submit" name="submit_btn" id="submit" value="Upload" class="btn btn-info pull-left" /> 
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!--- TAMPILAN MODAL ALASAN NOT APPROVE -->
<div class="modal fade" id="modal_notes" role="dialog">
  	<div class="modal-dialog">
      	<div class="modal-content">
          	<div class="modal-header">
              	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              	<h3 class="modal-title">Alasan</h3>
          	</div>
           	<form action = "<?php echo site_url('crm/ApprovalProgress/2/'.$detail['id'].'/0') ?>" id="form" class="form-horizontal" method = "POST">
            	<div class="modal-body form">
					<textarea rows="4" style="width: 100%;" name="notes"></textarea>
					<input type="hidden" name="progress_approval_id" id = "progress_approval_id">
					<input type="hidden" name="log_id" id = "log_id">
              	</div>
				<div class="modal-footer">
					<button type="submit" id="btnSave" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
          	</form>
      	</div>
  	</div>
	</div>

<div class="modal fade" id="modalChangeSales" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('crm/ChangeSales'); ?>" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Change Sales</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Change Sales to</label>
	            		<div class="col-sm-12">
	            			<select name="sales-new" class="form-control" style="width: 100%;">
	            				<option value="">-Pilih-</option>
	            				<?php foreach ($selKar as $kar) { ?>
	            						<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
	            				<?php } ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-1">Alasan</label>
	            		<div class="col-sm-12">
	            			<textarea rows="4" style="width: 100%;" name="alasan" id="alasan-change"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="crm_id" value="<?php echo $detail['id']; ?>">
	            	<input type="hidden" name="sales-exist" value="<?php echo $detail['sales_id'] ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="change_btn" class="btn btn-primary" name="btn_submit">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalhighlight" role="dialog" method="post">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('crm/Uploadhighlight/');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Saving...'; ">
				<div class="modal-header">
					<h4>Add Highlight</h4>
				</div>
				<div class="modal-body">
					
					<div class="form-group highlight-row" id="highlight-row-1">
						<div class="row col-sm-12">
							<div class="controls col-sm-10">
								<input type="text" name="highlight[]" class="form-control" > 
							</div>
							<div class="col-sm-2">   
								<button  type="button" class="btn btn-primary btn-add-highlight" data-id="1">+</button>
							</div>
						</div>
					</div>
					<div id="highlight">
					</div>
					<input type="hidden" name="crm_id" value="<?php echo $detail['id']; ?>"> 
				</div>
				<div class="modal-footer">
					<input type="submit" name="submit_btn" id="submit" value="Save" class="btn btn-info pull-left" /> 
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="notes_highlight" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Notes For Highlight</h3>
                  </div>
                  <div class="modal-body form">
                      <form action = "<?php echo site_url('Crm/NotesHighlight'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.text = 'Saving...'; ">
                          <textarea rows="4" style="width: 100%;" name="notes" class="form-control"></textarea>
                          <input type="hidden" class="highlight-id" name = "highlight_id"></input> 
 						 <input type="hidden" name="crm_id" value="<?php echo $detail['id']; ?>"> 
                  </div>
                  <div class="modal-footer">
                      <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>

                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                  </form>
              </div>
          </div>
      </div>
