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

        _dataCRM: function()
         {
            var self = this;
            $(document).ready(function() {
                TABLE = $('#table').DataTable(
                {
            
                    'bProcessing': true, //Feature control the processing indicator.
                    'bServerSide': true, //Feature control DataTables' server-side processing mode.
                    //Initial no order.
                     "bProcessing": true,
                     "bPaginate":true,
                     "sPaginationType":"full_numbers",
                     "iDisplayLength": 100,
                     "aaSorting": [[0, "desc"]],
                      "ajax": 
                      {
                          "url": options.siteURL + "pricelist/ajax_list",
                          "type": "POST"
                      },
                    "iDisplayLength":50,

                     "columnDefs": [
                    {
                    "orderable": false,
                    "targets": [4],

                    "createdCell": function (td, cellData, rowData, row, col) 
                    {

                      // console.log(rowData);
                      var x = rowData[1];

                      $(td).attr('onclick', 'baseJs.lookspec("'+ x +'")');
                  }
              },
            ],
           });           

               //  $("div.dataTables_filter input").unbind();
               //  $('div.dataTables_filter input').bind('keyup', function(e) 
               //  {
               //      if(e.keyCode == 13) 
               //      {  
               //          TABLE.search( this.value).draw();
               //  }
               // });   
            });

        },

        lookspec: function(id)
        {
      // alert(id);
          $.ajax({
          type : 'GET',
          url : options.siteURL + 'pricelist/lookspec/'+id,
          dataType: 'JSON',
          success : function(data)
          {
                $('#modallookspec').modal('show'); 
                $('.modal-title').html(data.nama_produk); 
                $('.spec').html(data.keterangan); 
                $('.gambar').html('<img src="' + data.gambar +' " style="width: 300px;height: 400px;">');
          },
              error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(jqXHR);
            }
          });
        },

        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();
            // self.look();
        }
    };

        return base;
    }
}

