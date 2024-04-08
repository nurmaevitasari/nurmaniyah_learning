<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
<div class="modal fade" id="myModalMsg" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/add_pesan'); ?>'>
          <div class="modal-header">
            <h4>Add Discussion</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="msg" id="msg" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

<!-- TAMPILAN MODAL UNTUK ADD FILES  -->
 <div class="modal fade" id="myModalUpload" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_wishlist/uploadfiles/');  ?>" enctype="multipart/form-data">
              
          <div class="modal-header">
            <h4>Upload Files</h4>
          </div>
   
          <div class="modal-body">
            <div class="form-group file-row " id="file-row-1">
              <div class="row col-sm-12">
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfiles[]">
                </div>
                <div class="col-sm-2">   
                  <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                </div>
              </div>
            </div>
            <div id="add-row">

            </div> 
            <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3);  ?>">
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
       		<a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

     <!-- TAMPILAN MODAL UNTUK ALASAN PAUSE  -->
<div class="modal fade" id="myModalPause" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formpause" class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/3'); ?>'>
          <div class="modal-header">
            <h4>Alasan Pause</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="alasan" id="pause" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />

              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!-- TAMPILAN MODAL UNTUK ALASAN CANCEL  -->
<div class="modal fade" id="myModalCancel" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formcancel" class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/4'); ?>'>
          <div class="modal-header">
            <h4>Alasan Cancel</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="alasan" id="cancel" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

<div class="modal fade" id="modalContributor" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('c_wishlist/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
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
                          <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                        <?php }
                        } ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="wish_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHandover" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('c_wishlist/Handover'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Handover Wishlist</h3>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-3">Handover to</label>
                  <div class="col-sm-8">
                    <select name="handover" class="form-control" style="width: 100%;">
                      <option value="">-Pilih-</option>
                      <?php if($karyawan) {
                        foreach ($karyawan as $kar) { ?>
                          <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                        <?php }
                        } ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="wish_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPoint" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('c_wishlist/AddPoint'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Add Point</h3>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-2"></label>
                  <div class="col-sm-9">
                    <input class="form-control numonly" name="point"></input>
                  </div>
                </div>
                <input type="text" name="wish_id" value="<?php echo $detail['id'] ?>">
                <input type="text" name="wish_to" value="<?php echo $detail['wish_to'] ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpProgress" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action = "<?php echo site_url('C_wishlist/UpProgressModal/'.$detail['id']); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Update Progress</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-1"></label>
            <div class="col-sm-10">
              <select class="form-control" name="progress" id="progress" data-id = "<?php echo $detail['id'] ?>" style="width: 100%;">
                <option value=" "> - Pilih - </option>
                <option value="10" <?php if($detail['progress'] == '10' ) { echo "selected"; } ?>>10%</option>
                <option value="20" <?php if($detail['progress'] == '20' ) { echo "selected"; } ?>>20%</option>
                <option value="30" <?php if($detail['progress'] == '30' ) { echo "selected"; } ?>>30%</option>
                <option value="40" <?php if($detail['progress'] == '40' ) { echo "selected"; } ?>>40%</option>
                <option value="50" <?php if($detail['progress'] == '50' ) { echo "selected"; } ?>>50%</option>
                <option value="60" <?php if($detail['progress'] == '60' ) { echo "selected"; } ?>>60%</option>
                <option value="70" <?php if($detail['progress'] == '70' ) { echo "selected"; } ?>>70%</option>
                <option value="80" <?php if($detail['progress'] == '80' ) { echo "selected"; } ?>>80%</option>
                <option value="90" <?php if($detail['progress'] == '90' ) { echo "selected"; } ?>>90%</option>
                <option value="99" <?php if($detail['progress'] == '99' ) { echo "selected"; } ?>>99%</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="w_id" value="<?php echo $detail['id'] ?>">
        </div>
        <div class="modal-footer">
            <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

