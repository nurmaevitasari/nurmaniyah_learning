<div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Log Akses</h2>
            </div>
        </div>
        <hr />

        <div class="table-responsive">
        <table id="table" class="table table-hover col-md-12" cellspacing="0" style="font-size : 12px">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Nama User</th>
                    <th>URL</th>
                    <th>Referrer</th>
                    <th>Browser</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
                <tr>
                    <th>Timestamp</th>
                    <th>Nama User</th>
                    <th>URL</th>
                    <th>Referrer</th>
                    <th>Browser</th>
                    <th>IP Address</th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
 
 
<script type="text/javascript">
 
var save_method;
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('user_log/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
});


</script>

 
</body>
</html>