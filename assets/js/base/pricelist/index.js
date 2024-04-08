var BaseJs = {
  createIt: function(options){
    var GLOBAL_JS = options.globalJs;
    var TABLE;

    var base = {
      _alert:function(msg){
        alert(msg);
      },
      _dataCash: function(){
        var self = this;
        //console.log(options.siteURL + 'cash/getDataTable');
        TABLE = $('#table').DataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'pricelist/getDataTable',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 10,
            "aoColumns": [
              { mData: 'ID' } ,
              { mData: 'Divisi' },
              { mData: 'Product_name'},
              { mData: 'Specification'},
              { mData: 'Currency' },
              { mData: 'Price' },
              { mData: 'rupiah_price' },
              { mData: 'Last_update' },
              { mData: 'Last' },
            ],
            "columnDefs": [
              {
                  "targets": [3],
                  "searchable": false,
                  "orderable": false,
              },
              {
                    "targets": [8],
                    "visible": false
                    
              },
              {
                  "targets": [3],
                  "createdCell": function (td, cellData, rowData, row, col) 
                    {

                      console.log(rowData);
                      var x = rowData['ID'];

                      $(td).attr('onclick', 'baseJs.lookspec("'+ x +'")');
                   } 
              },
            ],
        });
      },

      lookspec: function(id)
        {
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
        self._dataCash();
      }
    };

    return base;
  }
}
