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
            $val = $("#select-cabang").val();
            
            $(document).ready(function() {
                TABLE = $('#table').DataTable({
            
                    "processing": true, 
                    "serverSide": true, 
                    "order": [], 
                    "ajax": {
                        "url": options.siteURL + "Pelamar/ajax_list/"+$val,
                        "type": "POST"
                    },

                    "columnDefs": [
                    {
                        "targets": [6], 
                       "orderable": false,
                    },
                    // {
                    //    "targets": [0,1],
                    //    "visible":false,
                    // },
                    ],

                    "iDisplayLength":10,

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
            $('#select-cabang').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data-cabang').show();
                    
                    TABLE.ajax.url(options.siteURL + "Pelamar/ajax_list/"+val).load();
                    /*TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);*/
                    setTimeout(function () {
                        $('#load-data-cabang').hide();
                    }, 3000);

                    /*if(val == 'Deal')
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
                    }*/
                }
                else
                {
                    $('#load-data-cabang').show();
                    
                    TABLE.ajax.url(options.siteURL + "Pelamar/ajax_list").load();
                    /*TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);*/

                    setTimeout(function () {
                        $('#load-data-cabang').hide();
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
