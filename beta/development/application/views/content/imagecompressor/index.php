<?php $alert_success = $this->session->flashdata('alert_success'); ?>
<?php $alert_failed = $this->session->flashdata('alert_failed'); ?>

<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2><i class="fa fa-picture-o"></i> Image Compressor</h2>
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
          <h3>Upload and compress image here...</h3>
          <form action="<?php echo site_url('imagecompressor/compress') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file1" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
    				<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
            <br>
            <div id="properties">

              <div class="form-group">
                <label>File Name <span class="notes">[Nama File, Biarkan kosong untuk penamaan default : img_daymonthyearhoursminutessecond_randomnumber]</span> </label>
                <div class="row">
                  <div class="col-xs-2">
                    <input type="text" name="filename" class="form-control" placeholder="">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Quality (%) <span class="notes">[Kualitas image setelah di compress, skala 1-90]</span> </label>
                <div class="row">
                  <div class="col-xs-2">
                    <input type="text" name="quality" class="form-control" placeholder="1-90">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Width (px) <span class="notes">[width image yang diinginkan setelah di compress]</span></label>
                <div class="row">
                  <div class="col-xs-2">
                      <input type="text" name="width" class="form-control" placeholder="">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Height (px) <span class="notes">[height image yang diinginkan setelah di compress]</span></label>
                <div class="row">
                  <div class="col-xs-2">
                      <input type="text" name="height" class="form-control" placeholder="">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-2">
                  <div class="form-group">
                    <label>Maintain Ratio</label>
                    <select class="form-control" name="ratio">
                      <option value="1">Yes</option>
                      <option value="2">No</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-bottom:20px;">
                <div class="col-md-6">
                  <span class="notes">
                    Notes:
                    <br>
                    - <b>Yes</b>, image akan mengikuti rasio nilai width atau height. <br>
                    - <b>No</b>, image akan mengikuti nilai width dan height. <br>
                    - Nilai height lebih diutamakan dari nilai width.
                  </span>
                </div>
              </div>

              <button type="submit" class="btn" id="btn-compress"><i class="fa fa-picture-o"></i> Compress Image</button>

            </div>
          </form>
        </div>
        <div class="box-tbl-upload">
          <table class="table table-hover table-striped" id="tbl-compression">
            <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Original Image</th>
                <th>Created</th>
                <th>Compression</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
    </div>
  </div>
</div>
