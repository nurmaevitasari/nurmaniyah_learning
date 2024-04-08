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
                        "url": options.siteURL + "Imp/ajax_list",
                        "type": "POST"
                    },

                    "createdRow": function(row, data, dataIndex) {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(5)').attr('id', "status_" + a);
                            $(row).find('td:eq(6)').attr('id', "notes_" + a);
                            // $(row).find('td:eq(6)').attr('id', "pri_" + a);    
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [

                    {
                       "targets": [7,8,9],
                        "orderable": false, //set not orderable
                    },
                  
                    ],

                    "iDisplayLength":50,
                     "orderCellsTop": true,

                });

           
              
            });

           
        },

    add_notes: function()
    {
        var id = document.getElementById("imp-id").value;
        var notes = CKEDITOR.instances['area'].getData();
       $.ajax
         ({
          type : 'POST',
          url : options.siteURL + 'Imp/notes/',
          data : 
          {
                id     : id,
                notes  : notes,
          },
          dataType : 'json',
          success : function (data)
          {

            $('#modal_notes').modal('hide');
             
            $("#notes_"+id).html(data.notes);

         

          },

          error : function (xhr, status, error)
          {

            console.log(xhr);
           
          },

      });

    },


    status:function(e) 
    { 

         var id = $(e).data('id');
         var status = $(e).val();

         $.ajax
         ({
          type : 'POST',
          url : options.siteURL + 'Imp/change_status/'+id+'/'+status,
          data : 
          {
                id : id,
                status : status,
          },
          dataType : 'json',
          success : function (data)
          {

            $(status).attr('selected');

            
            if(status == 1) 
            { 
            $("#status_"+id).html('<span class="label label-warning" style="font-size: 11px;">Received</span><p style="font-size: 10px;">Last Update : <br>'
                            +data.date_created+'</p>');

            }else if(status == 2) 
            { 

            $("#status_"+id).html('<span class="label label-default" style="font-size: 11px;">Not Received</span> <p style="font-size: 10px;">Last Update : <br>'
                            +data.date_created+'</p>');

            }else if(status == 3) 
            { 
            $("#status_"+id).html('<span class="label label-primary" style="font-size: 11px;">Processing</span><p style="font-size: 10px;">Last Update : <br>'
                                    +data.date_created+'</p>');
            }else if(status == 4) 
            { 

            $("#status_"+id).html('<span class="label label-success" style="font-size: 11px;">Approved</span><p style="font-size: 10px;">Last Update : <br>'
                +data.date_created+'</p>');
            }
            else if(status == 5) 
            { 

            $("#status_" + id).html('<span class="label label-danger" style="font-size: 11px;">Not Approved</span><p style="font-size: 10px;">Last Update : <br>'
                +data.date_created+'</p>');
            }else{
                $("#status_"+id).html('Waiting');
            }


          },

          error : function (xhr, status, error)
          {

            console.log(xhr);
           
          },

      });

    },



        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();

           
        }
    };

        return base;
    }
}