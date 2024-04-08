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

        _dataPR: function(){
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
                        "url": options.siteURL + "Purchasing/ajax_list",
                        "type": "POST"
                    },

                    "columnDefs": [
                    {
                        "targets": [7,9],
                        "sortable": false,
                    },
                    {
                      "targets": [ 10,11,12,13,14,15],
                      "visible": false,
                      "searchable": false
                    },
              {
                  "targets": [ 7 ],
                  "width": "100px",
              },
                            
                {
                "targets": [3],
                "createdCell": function (td, cellData, rowData, row, col) {
                        html = '';
                        if(cellData != null)
                        {
                            var item = cellData.search('@');
                            var celldata = cellData;                                       

                            html = '<ul style="padding-left:10px;">';

                            if(item > 0)
                            {
                                var items = celldata.split('@');
                                var vendors = rowData["12"].split('@');
                                var qty = rowData["13"].split('@');
                                var mou = rowData["14"].split('@');

                                for(var i = 0;i<items.length;i++)
                                {
                                    html += '<li>' + '[' + vendors[i] + ']' + ' - ' + items[i] + ' ' + qty[i] + ' ' + mou[i] + '</li>';
                                }

                            }
                            else
                            {
                                html += '<li>' + '[' + rowData['11'] + ']' + ' - ' + cellData + ' ' + rowData['12'] + ' ' + rowData['13'] + '</li>';
                            }


                            html += '</ul>';
                        }

                  $(td).html(html);

                }
              },
              {
                "targets": [4],
                "createdCell": function (td, cellData, rowData, row, col) 
                {
                    setInterval(function () {
                        var startDateTime = new Date( rowData['11'] );


                        startStamp = startDateTime.getTime();
                        newDate = new Date();
                        newStamp = newDate.getTime();
                        var diff = Math.round((newStamp - startStamp) / 1000);

                        var d = Math.floor(diff / (24 * 60 * 60));
                        /* though I hope she won't be working for consecutive days :) */
                        diff = diff - (d * 24 * 60 * 60);
                        var h = Math.floor(diff / (60 * 60));
                        diff = diff - (h * 60 * 60);
                        var m = Math.floor(diff / (60));
                        diff = diff - (m * 60);
                        var s = diff;

                        $(td).html(d + "d " + h + "h " + m + "m ");
                    }, 1000);

                }
              },
                    ],

                      "createdRow": function( row, data, dataIndex ) {
                      if ( data['StatusOri'] == 'FINISHED' ) {
                        $(row).addClass( 'hidethis ');
                        $(row).attr('data-user', 'FINISHED');
                        $(row).attr('id', '#row_' + data['ID']);
                      }
                      else{
                        $(row).addClass( 'showthis' );
                        $(row).attr('id', '#row_' + data['ID']);
                      }
                    },


                    "iDisplayLength":50,

                });

                $("div.dataTables_filter input").unbind();
                $('div.dataTables_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {  
                        TABLE.search( this.value).draw();
                    }
               });   
            });

           
        },

       _selectData: function(){
            var self = this;
            $('#select-pr').change(function(){
                var val = $(this).val();


                $('#load-data').show();

                if(val != '')
                {
                    // TABLE.ajax.url(options.siteURL + "Purchasing/getDataPR/"+val).load();
                    TABLE.ajax.url(options.siteURL + "Purchasing/ajax_list/"+val).load();

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 5000);
                }
                else
                {
                    // TABLE.ajax.url(options.siteURL + "Purchasing/getDataPR").load();
                    TABLE.ajax.url(options.siteURL + "Purchasing/ajax_list").load();

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },

   

        init: function(){
            var self = this;
            self._alljava();
            self._dataPR();
            self._selectData();
            // self._showhide();
            // self._searching();
        }
    };

        return base;
    }
}