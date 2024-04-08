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

        _dataCashTopUp: function(){
            var self = this;
            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    "ajax": {
                        "url": options.siteURL + "CashTopUp/ajax_list",
                        "type": "POST"
                    },
                    "columnDefs": [
                        {
                            "targets": [8,4,5], //first column / numbering column
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

        setting: function(e)
        {
            var id      = $(e).data('id');
            var limit   = $(e).data('limit');
            var idle    = $(e).data('idle');
        
            $("#mymodalsetting").modal('show');
            $("input[name=id]").val(id);
            $("input[name=idle]").val(idle);
            $("input[name=limit]").val(limit);
        },

        _selectData: function()
        {
            var self = this;
            $('#select-cash').change(function()
            {

                // console.log(url);
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "CashTopUp/ajax_list/"+val).load();
                   
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "CashTopUp/ajax_list").load();
                   

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataCashTopUp();
            self._selectData();
        }
    };

        return base;
    }
}