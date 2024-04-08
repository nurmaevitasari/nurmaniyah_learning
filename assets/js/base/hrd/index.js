var BaseJs = {
    createIt: function(options){
        var GLOBAL_JS = options.globalJs;

        var base = {
            _alert:function(msg){
                alert(msg);
            },
      _alljava: function(){
        var self = this;
        //console.log(options.siteURL + 'sps/getDataTable');
        
      },

        _dataHRD: function(){
            var self = this;
            //var table;
            //console.log(options.siteURL + 'sps/getDataTable');
            $(document).ready(function() {
                TABLE = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "Hrd/ajax_list_hrd",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    {
                        "targets": [0,4], //first column / numbering column
                       "orderable": false, //set not orderable
                    },
                    {
                        "targets": [4],
                       "visible":false,
                    },
                    ],

                    "iDisplayLength":50,

                });
            });
        },

        _selectData: function(){
            var self = this;
            $('#type').change(function(){
                var val = $(this).val();

                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Hrd/ajax_list_hrd/"+val).load();
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
        
            });
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataHRD();
            self._selectData();
        }
    };

        return base;
    }
}