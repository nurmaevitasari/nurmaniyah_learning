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
                    TABLE = $('#table').DataTable({
                        "processing": true, //Feature control the processing indicator.

                        "serverSide": true, //Feature control DataTables' server-side processing mode.

                        "order": [], //Initial no order.

                        "ajax": {
                            "url": options.siteURL + "auto_point/ajax_list",
                            "type": "POST"
                        },

                        "createdRow": function(row, data, dataIndex) {     
                        },
                        
                        "columnDefs": [
                          {
                            "targets": [8], //first column / numbering column
                            "orderable": false, //set not orderable
                          },
                        ],

                        "iDisplayLength":50,
                    });
            });

        },

        // update


        _selectData: function(){

            var self = this;

            $('#select-wishlist').change(function(){

                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "auto_point/ajax_list/"+val).load();
                    setTimeout(function () 
                    {
                        $('#load-data').hide();

                    }, 3000);
                    $("h2").html('Auto Point Finished');


                }

                else
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "auto_point/ajax_list").load();
                    setTimeout(function () {

                        $('#load-data').hide();
                    }, 3000);

                    $("h2").html('Auto Point');
                }

            });

        },



      init: function()
      {

        var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
  
          },

      };

    return base;

    }

}



