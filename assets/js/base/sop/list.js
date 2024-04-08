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

        _dataList: function(){

            var self = this;

            $(document).ready(function() {

              TABLE = $('#table-list').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        "ajax": {
                            "url": options.siteURL + "sop/ajax_table_list/",
                            "type": "POST"
                        },
                        "columnDefs": [

                            {
                                "targets": [4], //first column / numbering column
                               "orderable": false, //set not orderable
                            },
                        ],
                        "iDisplayLength":50,
                  });
           
               //  $("div.dataTables_filter input").unbind();
               //  $('div.dataTables_filter input').bind('keyup', function(e) {
               //      if(e.keyCode == 13) {  
               //          TABLE.search( this.value).draw();
               //      }
               // });

            });
 
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataList();
     
           
        }
    };

        return base;
    }
}