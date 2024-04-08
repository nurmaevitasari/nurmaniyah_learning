 <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_test_upload/add');  ?>" enctype="multipart/form-data">
<div class="form-group row file-row" id="file-row-1" action="<?php echo site_url('C_test_upload/add');  ?>" enctype="multipart/form-data">
                <label class="control-label col-sm-2">Upload Foto/File</label>
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfile[]">
                </div>

                </div>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
                </form>
      