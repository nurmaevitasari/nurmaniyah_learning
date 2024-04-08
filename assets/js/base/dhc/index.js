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

        _dataDHC: function(){
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
                        "url": options.siteURL + "dhc/ajax_list",
                        "type": "POST"
                    },

                    "createdRow": function(row, data, dataIndex) 
                    {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(5)').attr('id', "s_" + a);
                            $(row).find('td:eq(5)').attr('class', "td-status" );

   
                    },

                    "columnDefs":
                    [
                        
                        {
                           "targets": [1,3], 
                           "visible": false, 
                        },
                    ],

                    "iDisplayLength":50,

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
                    
                    TABLE.ajax.url(options.siteURL + "dhc/ajax_list/"+val).load();
                    
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                   
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "dhc/ajax_list").load();
                
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },


        file:function()
        {
            $('body').delegate('.btn-add-file', 'click', function()
            {

              var id = $(this).data('id');
              var length = $('.file-row').length;

              html =    '<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
                            '<div class="row col-sm-12">'+
                            '<label class="control-label col-sm-2" >&nbsp;</label>'+
                            '<div class="controls col-sm-7">'+
                                '<input class="" type="file" name="userfile[]"> '+
                            '</div>'+
                            '<div class="row col-sm-3">'+
                                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+
                                '&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
                            '</div>'+ 
                            '</div>'+
                        '</div>';

              $('#add-row').append(html); 
            });

            $('body').delegate('.btn-remove-file', 'click', function(){
              var id = $(this).data('id');
              var length = $('.file-row').length;
              
              if(length > 1)
              {
                $('#file-row-'+id).remove();
              }
            });
        },


        change:function(e)
        {
  

                var id = $(e).data('id');
                var status =$(e).html();     
      

                    $.ajax({
                        type : 'POST',
                        url : options.siteURL + 'Dhc/changests',
                        data: 
                        {
                            id : id,
                            status : status, 
                        }, 
                        success: function(data)
                        {                           

                            
                            console.log(status);
                            
                            $("#s_" + id).html(status);
            
                            if(status == 'Hide') 
                            { 
                                $("#btn-" + id).html('Show');
                                $("#btn-" + id).addClass('btn-primary');
                                $("#btn-" + id).removeClass('btn-warning');
                            }else if (status == 'Show' ) {
                                $("#btn-" + id).html('Hide');
                                $("#btn-" + id).addClass('btn-warning');
                                $("#btn-" + id).removeClass('btn-primary');
                            }                                  
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            console.log(jqXHR);
                        }
                    });

                // });


        },



        init: function(){
            var self = this;
            self._alljava();
            self._dataDHC();
            self._selectData();
            self.file();
            self.change();
            // self._showhide();
            // self._searching();
        }
    };

        return base;
    }
}