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

        _dataprospecting: function(){
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
                        "url": options.siteURL + "prospecting/ajax_list",
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
                     "orderCellsTop": true,

                });
           
                $("div.dataTables_filter input").unbind();
                $('div.dataTables_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {  
                        TABLE.search( this.value).draw();
                    } 
               });


                    var filterColumns = [2, 6, 8, 10];
                    TABLE.column(filterColumns).every(function () {
                        var that = this;
                        $('input', this.header()).on('keyup', function (e) {
                            if (that.search() != this.value && e.keyCode == 13) {
                                filterColumns.map(function (key, value) {
                                    table = TABLE.column(key).search($(".filterrow" + key).val());
                                })
                                TABLE.draw();
                            }
                        });
                    });

              

            });

           
        },

        _selectData: function()
        {
            var self = this;
            $('#select-prospecting').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "prospecting/ajax_list/"+val).load();
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
                    
                    TABLE.ajax.url(options.siteURL + "prospecting/ajax_list").load();
                    TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);

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
                    
                    TABLE.ajax.url(options.siteURL + "prospecting/ajax_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);   

                    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
                    $("#btn_show").attr('class', 'btn btn-primary btn-sm');               
            });

            $("btn_show").click(function(){

                var val ="Deal";
                var ket ="show";
                    
                TABLE.ajax.url(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket).load();
                // console.log(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket);

                TABLE.column(0).visible(true);
                TABLE.column(1).visible(true);   
              
                $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
                $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
            });

        },

        _checkmarketplace: function()
        {
             $("#show_mt").change(function(){

                var checked= $(this).is(':checked');

                console.log(checked);

                if(checked == false)
                {
                    var mt = checked;

                    var val ="Deal";
                    var ket ="show";

                    TABLE.ajax.url(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket+"/"+mt).load();
                    // console.log(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket);

                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);   
                      
                    $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
                    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
                }
                
                if(checked == true)
                {
                    var mt = checked;
                    
                    var val ="Deal";
                    var ket ="show";

                    TABLE.ajax.url(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket).load();
                    // console.log(options.siteURL + "prospecting/ajax_list/"+val+"/"+ket);

                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);   
                      
                    $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
                    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
                }
                   
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
            self._dataprospecting();
            self._selectData();
            self._showhide();
            self._checkmarketplace();
            self._filter();
        }
    };

        return base;
    }
}