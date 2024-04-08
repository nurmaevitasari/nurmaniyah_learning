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
        TABLE = $('#data-cash').DataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'cash/getDataTable',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 100,
            "aaSorting": [[2, "desc"]],
            "aoColumns": [
              { mData: 'ID' } ,
              { mData: 'Tanggal' },
              { mData: 'date_created' },
              { mData: 'Operator'},
              { mData: 'Category'},
              { mData: 'Item' },
              { mData: 'UmurCash' },
              { mData: 'Status' },
              { mData: 'Approval' },
              { mData: 'Actions' },
              { mData: 'DateStart' },
            ],
            "columnDefs": [
              {
                  "targets": [9],
                  "searchable": false,
                  "orderable": false,

              },

              {
                  "targets": [10],
                  "searchable": false,
                  "visible": false,
              },
              {
                    "targets": [2],
                    "visible": false
                    
              },

              {
                  "targets": [5],
                  "createdCell": function (td, cellData, rowData, row, col) {
                    //console.log(cellData);

                    if(cellData != '')
                    {
                      $(td).html(cellData);
                    }
                    else
                    {
                      setInterval(function () {
                        var startDateTime = new Date( rowData['DateStart'] );
                        //console.log(startDateTime);
                         startStamp = startDateTime.getTime();
                         newDate = new Date();
                         newStamp = newDate.getTime();
                         var diff = Math.round((newStamp - startStamp) / 1000);

                         var d = Math.floor(diff / (24 * 60 * 60));

                         diff = diff - (d * 24 * 60 * 60);
                         var h = Math.floor(diff / (60 * 60));
                         diff = diff - (h * 60 * 60);
                         var m = Math.floor(diff / (60));
                         diff = diff - (m * 60);
                         var s = diff;

                         $(td).html(d + "d " + h + "h " + m + "m " + s + "s");

                      }, 1000);
                    }
                  }  
              },
            ],
            "createdRow": function( row, data, dataIndex ) {
             /*  if ( data['StatusOri'] == 8 ) {
                $(row).addClass( 'hidethis ');
                $(row).attr('data-user', '8');
              }
              else{
                $(row).addClass( 'showthis' );
              } */
            }
        });
      },

      _selectCash: function(){
        var self = this;
        $('#select-cash').change(function(){
            var val = $(this).val();

            if(val != '')
            {
              $('#load-data').show();

              TABLE.ajax.url(options.siteURL + 'cash/getDataTable/'+val).load();

              setTimeout(function () {
                $('#load-data').hide();
              }, 3000);
            }
            else
            {
              $('#load-data').show();
              
              TABLE.ajax.url(options.siteURL + 'cash/getDataTable').load();

              setTimeout(function () {
               
                $('#load-data').hide();
              }, 3000);
            }
        });
      },

			init: function(){
				var self = this;
        self._dataCash();
        self._selectCash();
			}
		};

		return base;
	}
}
