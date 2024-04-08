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

        _dataCRM: function(){
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
                        "url": options.siteURL + "Crm/ajax_list",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                    {
                        "targets": [5,10], //first column / numbering column
                       "orderable": false, //set not orderable
                    },
                    {
                        "targets": [0,1],
                       "visible":false,
                    },
                    ],

                    "iDisplayLength":50,

                });
            });
        },

        _selectData: function(){
            var self = this;
            $('#select-crm').change(function(){
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Crm/ajax_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                    if(val == 'Deal')
                    {
                        $(".date").text('Dealt Date');
                        $(".value").text('Deal Value');
                    }
                    else if(val = 'Loss') {
                        $(".date").text('Lost Date');
                        $(".value").text('Prospect Value');
                    }
                    else if(val = 'Loss') {
                        $(".date").text('Lost Date');
                        $(".value").text('Prospect Value');
                    }
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Crm/ajax_list").load();
                    TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
        }
    };

        return base;
    }
}