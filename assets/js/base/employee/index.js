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

        _dataEmployee: function(){
            var self = this;
            var val = $('#select-kar').val();

            
            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, 
                    "serverSide": true, 
                    "order": [], 
                    "ajax": {
                        "url": options.siteURL + "Employee/ajax_list/"+val,
                        "type": "POST"
                    },

                    "columnDefs": [
                    {
                        "targets": [8], 
                       "orderable": false,
                    },
                    // {
                    //    "targets": [0,1],
                    //    "visible":false,
                    // },
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

        confirm :function()
        {
            return confirm("Anda Akan Menghapus karyawan ini, Lanjutkan?");
        },

        _selectData: function()
        {
            var self = this;
            $('#select-kar').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "Employee/ajax_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                    if(val == 'Deal')
                    {
                        $(".date").text('Dealt Date');
                        $(".value").text('Deal Value');
                        // alert("show");
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
                    
                    TABLE.ajax.url(options.siteURL + "Employee/ajax_list").load();
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
            self._dataEmployee();
            self._selectData();
        }
    };

        return base;
    }
}