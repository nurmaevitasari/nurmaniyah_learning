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
                TABLE = $('#table').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "statistik/ajax_list",
                        "type": "POST"
                    },

                    "createdRow": function(row, data, dataIndex) {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(2)').attr('id', "notif_rate_day_" + a);
                            

                            $(row).find('td:eq(3)').attr('style','display:none');
                            $(row).find('td:eq(5)').attr('style','display:none');
                            $(row).find('td:eq(7)').attr('style','display:none');
                            $(row).find('td:eq(9)').attr('style','display:none');
                            $(row).find('td:eq(11)').attr('style','display:none');

                            var total = $(row).find('td:eq(3)').html();
                            if (total >100) {
                              $(row).find('td:eq(2)').attr('style','background-color:red');
                            } 
                            else if (total >= 70 && total <= 100 ) {
                              $(row).find('td:eq(2)').attr('style','background-color:yellow');
                            }

                            var total1 = $(row).find('td:eq(5)').html();
                            if (total1 >100) {
                              $(row).find('td:eq(4)').attr('style','background-color:red');
                            } 
                            else if (total1 >= 70 && total <= 100 ) {
                              $(row).find('td:eq(4)').attr('style','background-color:yellow');
                            }

                            var total2 = $(row).find('td:eq(7)').html();
                            if (total2 >100) {
                              $(row).find('td:eq(6)').attr('style','background-color:red');
                            } 
                            else if (total2 >= 70 && total <= 100 ) {
                              $(row).find('td:eq(6)').attr('style','background-color:yellow');
                            }


                            var total3 = $(row).find('td:eq(9)').html();
                            if (total3 >100) {
                              $(row).find('td:eq(8)').attr('style','background-color:red');
                            } 
                            else if (total3 >= 70 && total <= 100 ) {
                              $(row).find('td:eq(8)').attr('style','background-color:yellow');
                            }

                            var total4 = $(row).find('td:eq(11)').html();
                            if (total4 >100) {
                              $(row).find('td:eq(10)').attr('style','background-color:red');
                            } 
                            else if (total4 >= 70 && total <= 100 ) {
                              $(row).find('td:eq(10)').attr('style','background-color:yellow');
                            }


                    },


                    //Set column definition initialisation properties.
                    "columnDefs": [
                    {
                        "targets": [2,3,4,5,6,7], //first column / numbering column
                       "orderable": false, //set not orderable
                    },

                    // {
                    //         "targets": [3,5,7,9,11], //first column / numbering column
                    //         "visible": false, //set not orderable
                    // },
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

               //   $("#table thead input").unbind();
               //   $('#table thead input').bind('keyup', function(e) {
               //      if(e.keyCode == 13) {  
               //          TABLE.search( this.value).draw();
               //      }
               // });
               

   

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
                    
                    TABLE.ajax.url(options.siteURL + "stistik/ajax_list/"+val).load();
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
                    
                    TABLE.ajax.url(options.siteURL + "statistik/ajax_list").load();
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
                    
                    TABLE.ajax.url(options.siteURL + "statistik/ajax_list/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);   

                    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
                    $("#btn_show").attr('class', 'btn btn-primary btn-sm');               
            });

            $("#btn_show").click(function(){

                var val ="Deal";
                var ket ="show";
                    
                TABLE.ajax.url(options.siteURL + "statistik/ajax_list/"+val+"/"+ket).load();
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

                $(this).html( '<input type="text" class="form-control" style = "overflow-x : auto; width : 100%;" placeholder="Search '+title+'" />' );
                });
        },

        setting:function()
        {
            
             $.ajax({
                type : 'POST',
                url : options.siteURL + "statistik/get_setting_general/",
                dataType: "JSON",
                success : 
                function (data)
                {   
                   
                    $('#myModal').modal('show');
                    $('[name="notif_rate_day"]').val(data.notif_rate_day);
                    $('[name="notif_lag_rate"]').val(data.notif_lag_rate);
                    $('[name="days_lag_rate"]').val(data.days_lag_rate);
                    $('[name="open_rate_day"]').val(data.open_rate_day);
                    $('[name="current_day_lag"]').val(data.current_day_lag);

                },
                error : function (xhr, status, error)
                {
                    alert('Error get data from ajax');
                }
            });
        },

        setting_personal:function()
        {

              $.ajax({
                type : 'POST',
                url : options.siteURL + "statistik/get_setting_general_personal/",
                dataType: "JSON",
                success : 
                function (data)
                {   
                   
                    $('#myModal_general_personal').modal('show');
                    $('[name="notif_rate_day"]').val(data.notif_rate_day);
                    $('[name="notif_lag_rate"]').val(data.notif_lag_rate);
                    $('[name="days_lag_rate"]').val(data.days_lag_rate);
                    $('[name="open_rate_day"]').val(data.open_rate_day);
                    $('[name="current_day_lag"]').val(data.current_day_lag);

                },
                error : function (xhr, status, error)
                {
                    alert('Error get data from ajax');
                }
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