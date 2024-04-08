var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;

		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _dataImport: function(){
        var self = this;
        //console.log(options.siteURL + 'sps/getDataTable');
        $('#data-purchasing').dataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'purchasing/getDataPR',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 5,
            "order": [[ 0, "desc" ]],
            "aoColumns": [
              { mData: 'ID' } ,
              { mData: 'Date' },
              { mData: 'Operator'},
              { mData: 'Item' },
              { mData: 'PRAge' },
              { mData: 'Deadline' },
              { mData: 'Status' },
              { mData: 'Approval' },
              { mData: 'Actions' },
              { mData: 'StatusOri' },
							{ mData: 'DateCreated' },
							{ mData: 'Vendors' },
							{ mData: 'Qty' },
							{ mData: 'Mou' }
            ],
            "columnDefs": [
              {
                  "targets": [ 9,10,11,12,13 ],
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
									console.log(cellData);
									if(cellData != null)
									{
										var item = cellData.search('@');

										html = '<ul style="padding-left:10px;">';

										if(item > 0)
										{
											var items = cellData.split('@');
											var vendors = rowData['Vendors'].split('@');
											var qty = rowData['Qty'].split('@');
											var mou = rowData['Mou'].split('@');

											for(var i = 0;i<items.length;i++)
											{
												html += '<li>' + '[' + vendors[i] + ']' + ' - ' + items[i] + ' ' + qty[i] + ' ' + mou[i] + '</li>';
											}

										}
										else
										{
											html += '<li>' + '[' + rowData['Vendors'] + ']' + ' - ' + cellData + ' ' + rowData['Qty'] + ' ' + rowData['Mou'] + '</li>';
										}


										html += '</ul>';
									}

                  $(td).html(html);

                }
              },
              {
                "targets": [4],
                "createdCell": function (td, cellData, rowData, row, col) {

									if(cellData != '')
									{
										$(td).html(cellData);
									}
									else
									{
										setInterval(function () {
											var startDateTime = new Date( rowData['DateCreated'] );
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

                }
              },
            ],
            "createdRow": function( row, data, dataIndex ) {
              if ( data['StatusOri'] == 101 ) {
                $(row).addClass( 'hidethis ');
                $(row).attr('data-user', '101');
                $(row).attr('id', '#row_' + data['ID']);
              }
              else{
                $(row).addClass( 'showthis' );
                $(row).attr('id', '#row_' + data['ID']);
              }
            }
        });
      },
			btnShowHide: function(){
				$("#btn_hide").click(function() {
			    	$.fn.dataTable.ext.search.push(
			      		function(settings, data, dataIndex) {
			        		return $(table.row(dataIndex).node()).attr('data-user') != 101;
			      		}
			    	);

				    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
				    $("#btn_show").attr('class', 'btn btn-primary btn-sm');
				    table.draw();
				});

				$("#btn_show").click(function(){
					$.fn.dataTable.ext.search.pop();

				    $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
				    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
				    table.draw();
				});
			},
			run: function(){
				$("button[name='no']").on('click', function() {
					var id = $(this).data('id');
					$("input[name='pr_id']").val(id);
				});
			},
			init: function(){
				var self = this;
        self._dataImport();
				self.run();
			}
		};

		return base;
	}
}
