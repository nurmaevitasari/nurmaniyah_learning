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
				<form method="post" action="<?php echo site_url('C_ketentuan/simpanSOP') ?>" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Saving...'; ">
					<div class="modal-body">
						<textarea type="text" id="kt" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
						<input type="hidden" value="9" name="nama_modul">
						<input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
					</div>
					<!-- footer modal -->
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Save" name="submit_btn">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFollowUp" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('Project/Updates'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.html = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Update</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Execution</label>
	            		<div class="col-sm-8">
	            			<select name="execution" class="form-control" style="width: 100%;" id="exec">
	            				<option value="">-Pilih-</option>
	            				<option value="0">Queue</option>
	            				<option value="1">Worked-On</option>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Execution Note</label>
	            		<div class="col-sm-8">
	            			<textarea class="form-control" name="exec_note" id = "exec_note"></textarea>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress</label>
	            		<div class="col-sm-8">
	            			<select name="progress" class="form-control" style="width: 100%;" id="listprogress">
	            				<option value="">-Pilih-</option>
	            				<?php if($listProgress)
	            				{
	            					foreach ($listProgress as $prog) { ?>
	            						<option value="<?php echo $prog['id'] ?>"><?php echo $prog['progress_name'] ?></option>
	            				<?php	}
	            				} ?>
	            			</select>
	            		</div>
	            	</div>
	            	<div class="form-group">
	            		<label class="control-label col-sm-3">Progress Note</label>
	            		<div class="col-sm-8">
	            			<textarea class="form-control" name="listprogress_note" id = "listprogress_note"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalContributor" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('Project/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
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
	            	<input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>">
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
			<form class="form-horizontal" method="post" action='<?php echo site_url('Project/add_pesan'); ?>'; onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Saving...'; ">
				<div class="modal-header">
					<h4>Add Message</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="col-md-12">
							<textarea class="form-control" rows="6" name="msg" id="msg" required=""></textarea>
							<input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>"> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type='submit' class='btn btn-info pull-left' value='Save' name="submit_btn" id="add_btn">
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalUpload" role="dialog" method="post">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('Project/UploadFiles/');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Uploading...'; ">
				<div class="modal-header">
					<h4>Upload Files</h4>
				</div>
				<div class="modal-body">
					<?php if($countfiles != '2'  AND $detail['last_progress'] >= '4' AND $detail['project_type'] == '1') { ?>
						<div class="form-group row">
							<div class="col-sm-5">
								<select class="form-control" style="width: 100%;" name="tipefile" id="tipefile">
									<option value="" disabled="true" selected="true" required="true">-Pilih ACC File-</option>
									<option value="4">ACC Customer</option>
									<option value="5">ACC Salesman</option>
								</select>
							</div>
						</div>	
					<?php }elseif(in_array($_SESSION['myuser']['position_id'], array('1', '2', '88', '14'))) { ?>
						<div class="form-group row">
						<div class="col-sm-5">
							<select class="form-control" style="width: 100%;" name="tipefile" id="tipefile">
								<option value="" disabled="true" selected="true" required="true">-Pilih Tipe File-</option>
								<option value="0">Files</option>
								<option value="1">Technical Files</option>
								<option value="6">Confidential Files</option>
							</select>
						</div>
					</div>
					<?php }elseif(in_array($_SESSION['myuser']['position_id'], array('1', '2', '88', '14','73'))) { ?>
						<div class="form-group row">
						<div class="col-sm-5">
							<select class="form-control" style="width: 100%;" name="tipefile" id="tipefile">
								<option value="" disabled="true" selected="true" required="true">-Pilih Tipe File-</option>
								<option value="0">Files</option>
								<option value="1">Technical Files</option>
							</select>
						</div>
					</div>
					<?php }else { ?>
						<input type="hidden" name="tipefile" value="0">
					<?php } ?> 
					
					<div class="form-group file-row " id="file-row-1">
						<div class="row col-sm-12">
							<div class="controls col-sm-9">
								<input class="" type="file" name="userfile[]">
							</div>
							<div class="col-sm-3">   
								&nbsp; &nbsp; &nbsp;<button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>
						</div>
					</div>
					<div id="add-row">

					</div>
					<input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>"> 
				</div>
				<div class="modal-footer">
					<input type="submit" name="submit_btn" id="submit" value="Upload" class="btn btn-info pull-left" /> 
					<a class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalReminder" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
        	<form action = "<?php echo site_url('Project/AddReminder'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                	<span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Reminder</h3>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group row">
	            		<label class="control-label col-sm-2">Reminder</label>
	            		<div class="col-sm-9">
	            			<input type="text" name="reminder" class="form-control" id="reminder">
	            		</div>
	            	</div>
	            	<div class="form-group row">
	            		<label class="control-label col-sm-2">Keterangan</label>
	            		<div class="col-sm-9">
	            			<textarea type="text" name="about" class="form-control" id="about" rows="3"></textarea>
	            		</div>
	            	</div>
	            	<input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>">
	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalhighlight" role="dialog" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('Project/Uploadhighlight/');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.value = 'Adding...'; ">
                <div class="modal-header">
                    <h4>Add Highlight</h4>
                </div>
                <div class="modal-body">
                     
                    <div class="form-group highlight-row" id="highlight-row-1">
                        <div class="row col-sm-12">
                            <div class="controls col-sm-9">
                                <input type="text" name="highlight[]" class="form-control" > 
                            </div>
                            <div class="col-sm-3">   
                                <button  type="button" class="btn btn-primary btn-add-highlight" data-id="1">+</button>
                            </div>
                        </div>
                    </div>
                    <div id="highlight">
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>"> 
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit_btn" id="submit" value="Add" class="btn btn-info pull-left" /> 
                    <a class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Modal Notes-->
<div class="modal fade" id="modal_notes" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Notes</h3>
                  </div>
                 	<form action = "<?php echo site_url('Project/AddNotes'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit_btn.disabled = true; this.submit_btn.html = 'Saving...'; ">
                  <div class="modal-body form">
                        <textarea rows="4" style="width: 100%;" name="notes" class="form-control"></textarea>
                        <input type="hidden" class="highlight-id" name = "highlight_id">
                        <input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3); ?>"> 
                  </div>
                  <div class="modal-footer">
                      <button type="submit" id="btnSave" class="btn btn-primary" name="submit_btn">Save</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                  </form>
              </div>
          </div>
      </div>

