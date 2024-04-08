<!-- TAMPILAN MODAL UNTUK CHANGE STATUS  -->
<div class="modal fade" id="myModalStatus" role="dialog" method="post">
<div class="modal-dialog">
  <div class="modal-content">
    <form class="form-horizontal" method="post" id="form_status" role="form" ?>
      <div class="modal-header">
        <h4>Change Status</h4>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label class="control-label col-sm-3">ID</label>
          <div class="col-sm-8">
            <input id="ch_do_id" type="text" class="form-control" name="do_id" readonly="true">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3">Change Status </label>
          &nbsp;&nbsp;&nbsp;
          <select class="form-control col-sm-8" style="width: 62%;" name="chgstatus" id = "chgstatus" >
            <option value="">-Pilih-</option>
            <option value="Checking">Checking</option>
            <option value="QC">QC</option>
            <option value="Packing">Packing</option>
            <option value="Delivering">Delivering</option>
            <option value="Canceled">Canceled</option>
          </select>
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
</div>

<!-- TAMPILAN MODAL UNTUK TANGGAL  -->
<div class="modal fade" id="myModalTgl" role="dialog" method="post">
<div class="modal-dialog">
  <div class="modal-content">
    <form class="form-horizontal" method="post" id="form_tgl" role="form" ?>
      <div class="modal-header">
        <h4>Tanggal Kirim</h4>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label class="control-label class col-sm-3">ID</label>
          <div class="col-sm-8">
            <input class="form-control" id="tgl_do_id" type="text" name="do_id" readonly="true">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-3">Tanggal</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="tgl_kirim" id="tgl_kirim">
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3">Category</label>

          <div class="col-md-2 col-sm-3">
            <div class="radio">
              <input type="radio" name="category" value="0" required="true"> Pending
            </div>
          </div>
          <div class="col-md-2 col-sm-3">
            <div class="radio">
              <input type="radio" name="category" value="1" required="true"> Fix
            </div>
          </div>
        </div>

        <div id = "tgl_ket" class="form-group row">
          <label class="control-label col-sm-3">Keterangan</label>
          <div class="col-sm-8 col-md-8">
            <textarea class="form-control text_ket" rows="4" name="tgl_txa" placeholder="Pengiriman ditunda karena..."></textarea>
          </div>
        </div>
      <div class="modal-footer">
        <button type="submit" class='btn btn-info pull-left submit-tgl'>Submit</button>
        <a class="btn btn-default" data-dismiss="modal">Close</a>
      </div>
    </form>
  </div>
</div>
</div>
</div>
