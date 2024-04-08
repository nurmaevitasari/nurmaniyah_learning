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

        _dataCRMDetail: function(){
            var self = this;
            //var table;
            //console.log(options.siteURL + 'sps/getDataTable');

            $(document).ready(function() {

              var id = $('#id').val();


              TABLE = $('#table-detail-list').DataTable({
                        "scrollY": "500px",
                        "scrollCollapse": true,
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        "ajax": {
                            "url": options.siteURL + "sop/ajax_detail_list/"+id,
                            "type": "POST"
                        },

                        "columnDefs": [

                            
                        ],

                        "iDisplayLength":50,
                  });

            });
 
        },


        init: function(){
            var self = this;
            self._alljava();
            self._dataCRMDetail();
            self._selectData();
           
        }
    };

        return base;
    }
}