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

            //var table;

            //console.log(options.siteURL + 'sps/getDataTable');

            $(document).ready(function() {

                var pos = $("#sess-pos").val();



                if(pos == 1 || pos == 2 || pos == 14) {

                    TABLE = $('#table').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source

                        "ajax": {
                            "url": options.siteURL + "wishlist/ajax_list",
                            "type": "POST"
                        },

                        "createdRow": function(row, data, dataIndex) {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(9)').attr('id', "status_" + a);
                            $(row).find('td:eq(6)').attr('id', "pri_" + a);    
                        },

                        //Set column definition initialisation properties.

                        "columnDefs": [

                            {
                                "targets": [10], //first column / numbering column
                               "orderable": false, //set not orderable
                            },

                            {

                             "targets": [7],

                                "createdCell": function (td, cellData, rowData, row, col) {

                                   id = rowData[0];

                                    pr = rowData[6];

                                  var pos = $('#pos-val').val();

                                  var pos_arr = [1, 2, 19, 55, 56, 57, 58, 59, 60, 62, 75, 77];



                                  if($.inArray(pos, pos_arr))

                                  {

                                   $(td).attr('ondblclick', 'baseJs.priority('+id+', '+pr+')');

                                  }

                                 /* }

                                  $(td).attr('id', 'tgl_' + rowData['ID']);*/



                                } 

                              }, 

                        ],



                        "iDisplayLength":50,



                    });

                

                }else {

                    TABLE = $('#table').DataTable({

                        "processing": true, //Feature control the processing indicator.

                        "serverSide": true, //Feature control DataTables' server-side processing mode.

                        "order": [], //Initial no order.



                        // Load data for the table's content from an Ajax source

                        "ajax": {

                            "url": options.siteURL + "wishlist/ajax_list",

                            "type": "POST"

                        },



                        "createdRow": function(row, data, dataIndex) {

                       

                           /* var a = $(row).find('td:eq(0)').html();

                            $(row).find('td:eq(8)').attr('id', "status_" + a);*/

                              

                        },



                        //Set column definition initialisation properties.

                        "columnDefs": [
                          {
                            "targets": [10], //first column / numbering column
                            "orderable": false, //set not orderable
                          },
                          {
                            "targets": [6], //first column / numbering column
                            "visible": false, //set not orderable
                          },
                            /*{
                                "targets": [0], //first column / numbering column
                               "visible": false, //set not orderable
                            },*/
                            /*{
                                "targets": [10], //first column / numbering column
                               "orderable": false, //set not orderable
                            },

                            {

                                "targets": [6],

                                "visible": false,

                            },*/

                        ],



                        "iDisplayLength":50,



                    });

                }



            });

        },



        _selectData: function(){

            var self = this;

            $('#select-wishlist').change(function(){

                var val = $(this).val();

                if(val != '')

                {

                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "wishlist/ajax_list/"+val).load();
                    setTimeout(function () 
                    {
                        $('#load-data').hide();

                    }, 3000);



                    if(val == 'Execute')
                    {

                        $(".date").text('Execute Date');

                        $(".value").text('Execute');

                        $("h2").html('Wishlist Execute');
                    }

                    else if(val == 'Complete') {

                        $(".date").text('Complete Date');

                        $(".value").text('Complete');

                        $("h2").html('Wishlist Complete');
                    }

                }

                else
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "wishlist/ajax_list").load();
                    setTimeout(function () {

                        $('#load-data').hide();
                    }, 3000);

                    $("h2").html('Table Wishlist');
                }

            });

        },





        priority: function(id,pr)
        {
            $("input[name=id]").val(id);
            $("input[name=priority]").val(pr);
            $("#myModalpriority").modal('show');
        },



        _prioritySubmit : function() {
            $("#form").submit(function() {
                var id = $("input[name=id]").val();
                var pri = $("input[name=priority]").val();
                $.ajax({
                  type : 'POST',
                  url : options.siteURL + 'wishlist/UpPriority/',
                  data : 
                  {
                    id : id,
                    priority : pri,
                  },
                  dataType : 'json',
                  success : function (data)
                  {
                    $("#myModalpriority").modal('hide');
                    $("#pri_"+id).html(data);
                  },
                  error : function (xhr, status, error)

                  {
                    console.log(xhr);
                  },
                }); 
                return false;
            });
        },



       progress:function(e) 
       { 

         var id = $(e).data('id');
         var progress = $(e).val();
        $.ajax

        ({

          type : 'POST',

          url : options.siteURL + 'wishlist/UpProgress/',

          data : 

          {

            w_id : id,

            progress : progress,

          },

          dataType : 'json',



          success : function (data)

          {

            // console.log(data);



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

            self.progress();

            self._prioritySubmit();

        },

    };

    return base;

    }

}



