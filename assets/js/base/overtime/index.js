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

        _dataOvertime: function(){
            var self = this;
            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    "ajax": {
                        "url": options.siteURL + "Overtime/ajax_list",
                        "type": "POST"
                    },
                     "columnDefs": [
                    {
                       "targets": [8], //first column / numbering column
                       "orderable": false, //set not orderable
                    },
                    ],

                    "iDisplayLength":50,

                });

                $("div.dataTables_filter input").unbind();
                $('div.dataTables_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {  
                        TABLE.search( this.value).draw();
                    }
               });   
            });
           
        },

        _selectData: function()
        {
            var self = this;
            $('#select-overtime').change(function()
            {

                var val = $(this).val();

        

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Overtime/ajax_list/"+val).load();
                    // TABLE.column(0).visible(true);
                    // TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Overtime/ajax_list").load();
                    // TABLE.column(0).visible(false);
                    // TABLE.column(1).visible(false);

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },


      
        init: function(){
            var self = this;
            self._alljava();
            self._dataOvertime();
            self._selectData();
            // self._searching();
        }
    };

        return base;
    }
}