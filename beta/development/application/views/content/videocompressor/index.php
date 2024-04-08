<?php $alert_success = $this->session->flashdata('alert_success'); ?>
<?php $alert_failed = $this->session->flashdata('alert_failed'); ?>

<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2><i class="fa fa-picture-o"></i> Video Compressor</h2>
    </div>

  </div>
  <hr />
  <div class="row">
    <div class="col-md-12">
        <?php if(!empty($alert_success)): ?>
          <div class="alert alert-success" role="alert"><?php echo $alert_success; ?></div>
        <?php  endif; ?>

        <?php if(!empty($alert_failed)): ?>
          <div class="alert alert-danger" role="alert"><?php echo $alert_failed; ?></div>
        <?php  endif; ?>

        <div class="box-upload">
          <h3>Upload and compress video here...</h3>
          <form action="<?php echo site_url('videocompressor/compress') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file1" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
    				<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
            <br>
            <div id="properties">

              <div class="form-group">
                <label>File Name <span class="notes">[Nama File, Biarkan kosong untuk penamaan default : vid_daymonthyearhoursminutessecond_randomnumber]</span> </label>
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" name="filename" class="form-control" placeholder="">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Change video format to</label>
                    <select class="form-control" name="video_format">
                      <option value="mp4">mp4</option>
                      <option value="avi">avi</option>
                      <option value="mpeg">mpeg</option>
                      <option value="mov">mov</option>
                      <option value="wmv">wmv</option>
                    </select>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-info" id="btn-compress"> Compress Video</button>

            </div>
          </form>
        </div>
        <div class="box-tbl-upload">
          <table class="table table-hover table-striped" id="tbl-compression">
            <thead>
              <tr>
                <th>#</th>
                <th>Compression</th>
                <th>Created</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
    </div>
  </div>
</div>
