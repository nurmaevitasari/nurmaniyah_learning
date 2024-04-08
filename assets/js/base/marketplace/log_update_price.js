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
                TABLE = $('#table_log').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "Marketplace/ajax_update_price",
                        "type": "POST"
                    },
                  
                    "iDisplayLength":50,
                     "orderCellsTop": true,

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
            $('#select-divisi').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Marketplace/ajax_update_price/"+val).load();
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
    
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Marketplace/ajax_update_price").load();
                  

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },


        _showhide: function()
        {
             var self = this;
            $("#btn_hide").click(function() 
            {
                    var val ="Deal";
                    
                    TABLE.ajax.url(options.siteURL + "Marketplace/ajax_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);   

                    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
                    $("#btn_show").attr('class', 'btn btn-primary btn-sm');               
            });

            $("#btn_show").click(function(){

                var val ="Deal";
                var ket ="show";
                    
                TABLE.ajax.url(options.siteURL + "Marketplace/ajax_list/"+val+"/"+ket).load();
                // console.log(options.siteURL + "Crm/ajax_list/"+val+"/"+ket);

                TABLE.column(0).visible(true);
                TABLE.column(1).visible(true);   
              
                $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
                $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
            });


        },

        _filter: function()
        {

            $('#table thead tr th.filterrow').each( function () 
            {
                var title = $('#table thead th').eq( $(this).index() ).text();

                $(this).html( '<input type="text" class="form-control col-search-input" style = "overflow-x : auto; width : 100%;" placeholder="Search '+title+'" />');
                });
           },

   

        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
            self._showhide();
            self._filter();
        }
    };

        return base;
    }
}