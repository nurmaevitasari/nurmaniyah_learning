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
            
            var startTime = performance.now();

            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "Inquiry/ajax_list",
                        "type": "POST",
                        "dataSrc": function ( json ) 
                        {
           
                            var endTime = performance.now();
                            var times =endTime - startTime;
                            var seconds = ((times % 60000) / 1000).toFixed(2);

                            var load = seconds +' Second';

                            $('.times').text(load);
                            return json.data;
                          }
                    },

                  
                    "columnDefs": [
                    {
                        "targets": [6], //first column / numbering column
                       "orderable": false, //set not orderable
                    },
                    {
                       "targets": [0],
                       "visible":false,
                    },
                    
                    ],

                    "iDisplayLength":100,

                });

                $("div.dataTables_filter input").unbind();
                $('div.dataTables_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {  
                        TABLE.search( this.value).draw();
                    }
               });   
            });

           
        },

        _selectData: function(){
            var self = this;
            $('#select-crm').change(function(){

                var val = $(this).val();

                $('#load-data').show();

                if(val != '')
                {
                    
                    TABLE.ajax.url(options.siteURL + "Inquiry/ajax_list/"+val).load();
                     
                }
                else
                {
                    TABLE.ajax.url(options.siteURL + "Inquiry/ajax_list").load();
                    
                }

                setTimeout(function () {
                    $('#load-data').hide();
                }, 3000);
            });
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
            // self._searching();
        }
    };

        return base;
    }
}