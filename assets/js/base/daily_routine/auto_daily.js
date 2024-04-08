var BaseJs = {
    createIt: function(options){
        var GLOBAL_JS = options.globalJs;

        var base = {
            _alert:function(msg){
                alert(msg);
            },
      _alljava: function(){
        var self = this;
        
      },

        _dataCRM: function(){
            var self = this;
            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "daily_routine/auto_daily_list",
                        "type": "POST"
                    },
                    "columnDefs": [
                    ],

                    "iDisplayLength":50,
                     "orderCellsTop": true,
                });
            });
        },

        _selectData: function()
        {
            var self = this;
            $('#select-crm').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "daily_routine/auto_daily_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                    if(val == 'Deal')
                    {
                        $(".date").text('Dealt Date');
                        $(".value").text('Deal Value');
                        $(".hide-show").show();
                    }
                    else if(val == 'Loss') 
                    {
                        $(".date").text('Lost Date');
                        $(".value").text('Prospect Value');
                        $(".hide-show").hide();
                    }else  
                    {
                        
                        $(".hide-show").hide();
                    }    
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "daily_routine/auto_daily_list").load();
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