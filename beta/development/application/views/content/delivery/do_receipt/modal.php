<div class="modal fade" id="modal_notes" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Keterangan</h3>
            </div>
            <div class="modal-body form">
                <form action = "#" id="form" class="form-horizontal" method = "POST">
                    <textarea rows="4" style="width: 100%;" name="notes" id = "area"></textarea>
                    <input type="hidden" name="receipt_id" id = "receipt_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_note()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- TAMPILAN MODAL UNTUK ADD FILES  -->
<div class="modal fade" id="myModalUploadDoReceipt" role="dialog" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id = "form_upload" class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_delivery/UploadDOReceipt') ?>" enctype="multipart/form-data">

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
                            <input type="hidden" name="id_receipt" value="">
                        </div>
                    </div>
                    <div id="add-row">
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" />
                    <a class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </form>
        </div>
    </div>
</div>
