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
        $('#data-import').dataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'import/getDataImport',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 5,
            "aoColumns": [
              { mData: 'No' } ,
              { mData: 'ShipmentID' },
              { mData: 'Date'},
              { mData: 'ShipmentVia' },
              { mData: 'DeptArr' },
              { mData: 'ArrDest' },
              { mData: 'ShiptAge' },
              { mData: 'GoodsInfo' },
              { mData: 'Notes' },
              { mData: 'Status' },
              { mData: 'Actions' },
              { mData: 'IDImport' } ,
              { mData: 'StatusOri' },
							{ mData: 'DateCreated' }
            ],
            "columnDefs": [
              {
                  "targets": [ 11,12,13 ],
                  "visible": false,
                  "searchable": false
              },
              {
                "targets": [6],
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

											$(td).html(d + "d " + h + "h " + m + "m " + s + "s ");
										}, 1000);
									}

                }
              },
              {
                "targets": [8],
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('id', 'td_notes_' + rowData['IDImport']);

                }
              }
            ],
            "createdRow": function( row, data, dataIndex ) {
              if ( data['StatusOri'] == 8 ) {
                $(row).addClass( 'hidethis ');
                $(row).attr('data-user', '8');
              }
              else{
                $(row).addClass( 'showthis' );
              }
            }
        });
      },
			btnShowHide: function(){
				$("#btn_hide").click(function() {
				$.fn.dataTable.ext.search.push(
				function(settings, data, dataIndex) {
				  //alert();
				  return $(table.row(dataIndex).node()).attr('data-user') != 8;
				  }
				);
				$("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
				$("#btn_show").attr('class', 'btn btn-primary btn-sm');
				table.draw();
				});

				$("#btn_show").click(function(){
					$.fn.dataTable.ext.search.pop();
					table.draw();
					$("#btn_hide").attr('class', 'btn btn-primary btn-sm');
					$("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
					});

			},
			modalNotes: function(){
				$('body').delegate('.btn-notes', 'click', function(){
					//alert('tes');
					$("#form_notes")[0].reset();
					$("#mymodalNotes").modal('show');
					var import_id = $(this).data('id');

					$("input[name='import_id']").val(import_id);
				});
			},
			notesSubmit: function(){
				$("#form_notes").submit(function() {

					var notes = $(".tx-notes").val();
					var id = $("input[name='import_id").val();

					$.ajax({
					type : 'POST',
					url : options.siteURL + 'C_import/AddNotes/',
					data : {
					id : id,
					notes : notes
					},
					dataType : 'json',
					success : function(data){
						$('#mymodalNotes').modal('hide');
						$('#td_notes_'+id).html(data.notes);
					},
					error: function (jqXHR, textStatus, errorThrown){
						console.log(jqXHR);
					},
					});
					return false;
				});
			},
			run: function(){
				var self = this;

				self.modalNotes();
				self.notesSubmit();

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
