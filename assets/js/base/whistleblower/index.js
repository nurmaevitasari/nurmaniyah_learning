var BaseJs = {

    createIt: function(options){

        var GLOBAL_JS = options.globalJs;
        var base = {

            _alert:function(msg){
                alert(msg);
            },

      _alljava: function()
      {
        var self = this;
      },



        _dataCRM: function()
        {
            var self = this;
            $(document).ready(function()
             {
                
                  TABLE = $('#table').DataTable
                  ({
                          "processing": true, //Feature control the processing indicator.
                          "serverSide": true, //Feature control DataTables' server-side processing mode.
                          "order": [], //Initial no order.
                          "ajax": 
                           {
                              "url": options.siteURL + "whistleblower/ajax_list",
                              "type": "POST"
                            },
                        "createdRow": function(row, data, dataIndex) {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(9)').attr('id', "status_" + a);
                            $(row).find('td:eq(6)').attr('id', "pri_" + a);    
                        },
                        "columnDefs": 
                        [
                          {
                              "targets": [8], //first column / numbering column
                              "orderable": false, //set not orderable
                          },
 
                        ],
                        "iDisplayLength":50,


                    });

                


            });

        },



        _selectData: function(){

            var self = this;

            $('#select-wishlist').change(function(){

                var val = $(this).val();

                if(val != '')

                {

                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "whistleblower/ajax_list/"+val).load();
                    setTimeout(function () 
                    {
                        $('#load-data').hide();

                    }, 3000);



                    if(val == 'Execute')
                    {

                        $(".date").text('Execute Date');

                        $(".value").text('Execute');

                        $("h2").html('WhistleBlower Execute');
                    }

                    else if(val == 'Complete') {

                        $(".date").text('Complete Date');

                        $(".value").text('Complete');

                        $("h2").html('WhistleBlower Complete');
                    }

                }

                else
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "whistleblower/ajax_list").load();
                    setTimeout(function () {

                        $('#load-data').hide();
                    }, 3000);

                    $("h2").html('Table Whistleblower');
                }

            });

        },


        appr:function(e)
        {
            var id = $(e).data('id');
            $('#modal_notes').modal('show');
            $('[name="id"]').val(id);
        },



       progress:function(e) 
       { 
         var id = $(e).data('id');
         var progress = $(e).val();

         // alert(id);

        $.ajax
        ({
          type : 'POST',
          url : options.siteURL + 'whistleblower/UpProgress/'+id,
          data : 
          {
            w_id : id,
            progress : progress,
          },

          dataType : 'json',
          success : function (data)

          {
            console.log(data);
            $(progress).attr('selected');
            if(progress == 100) 
            { 
              $("#status_" + id).html('<label class=" label label-success"> COMPLETED</label><br>' +
                                      '<span style="font-size: 10px;" >' + data.date_created +' By : ' + 
                                        data.user + '</span>');

            }else if (progress < 100 && progress >= 10) 
            { 

              $("#status_" + id).html('<label class=" label label-primary"> EXECUTE</label><br>' +
                                        '<span style="font-size: 10px;" >' + data.date_created +' By : ' + 
                                          data.user + '</span>');
            }
          },
          error : function (xhr, status, error)
          {
            console.log(xhr);
          },

      });  
    },





    init: function()
    {
        var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
            // self.appr();
            self.progress();

        },

    };

    return base;

    }

}



