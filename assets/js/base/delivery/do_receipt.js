var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;
		var SAVE_METHOD = '';
		//var save_note = '';

		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _dataImport: function(){
        var self = this;

        $('#data-do-receipt').DataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'delivery/getDataDoReceipt',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 100,
            "order": [[ 0, "desc" ]],
            "aoColumns": [
              { mData: 'ID' },
              { mData: 'Date'},
              { mData: 'NoDO' },
              { mData: 'Customer' },
              { mData: 'Status' },
              { mData: 'Notes' },
              //{ mData: 'Files' } ,
              { mData: 'Actions' },
            ],
            "columnDefs": [
              {
                "targets": [4],
                "createdCell": function (td, cellData, rowData, row, col) {
                  $(td).attr('id', 'id_' + rowData['ID']);
                }
              },
              {
                "targets": [5],
                "createdCell": function (td, cellData, rowData, row, col) {
                  $(td).attr('id', 'tdket_' + rowData['ID']);
                  $(td).attr('ondblclick', 'baseJs.changeNotes('+ rowData['ID'] +')');
                }
              },

            ],
            "createdRow": function( row, data, dataIndex ) {
              if ( data['StatusOri'] == 1 ) {
                $(row).addClass( 'hidethis ');
                $(row).attr('data-user', '101');
                $(row).attr('id', '#tr_' + data['ID']);
              }
              else{
                $(row).addClass( 'showthis' );
                $(row).attr('id', '#tr_' + data['ID']);
              }
            }
        });
      },
			btnShowHide: function(){
				$("#btn_hide").click(function() {
				    $.fn.dataTable.ext.search.push(
				      function(settings, data, dataIndex) {
				        return $(table.row(dataIndex).node()).attr('data-user') != 1;
				      }
				    );
				    table.draw();
				    $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
				    $("#btn_show").attr('class', 'btn btn-primary btn-sm');
				});


				$("#btn_show").click(function(){
				  $.fn.dataTable.ext.search.pop();
				     table.draw();
				     $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
				    $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
				 });
			},
			changeNotes: function(id){
				$('#form')[0].reset();
		    		$('#modal_notes').modal('show');
		    		$('#receipt_id').val(id);
		   		SAVE_METHOD = $("#tdket_"+id).html();
		    		$('#area').html(SAVE_METHOD);
			},
			/* */
			ChangeStatus: function(e){
				var str = e.id;
		    var stt = $('#'+str).attr('attr');

		    var id = str.substring(4);

		   $.ajax({
		        type : 'POST',
		        url : options.siteURL + 'C_delivery/EditReceipt/',
		        data : {
		            id : id,
		            stt : stt,

		        },
		        dataType : 'json',
		        success : function (data) {
		            if(stt == '1') {
		                $('#td_'+ id).html( '<center style="font-size: 11px;">' +
		                                    '<span class="fa fa-check-circle fa-lg" style="color: green;"></span> <b style="color: green;">Received Success</b>' +
		                                    '<br />' +
		                                    '<b> by ' +data.nickname+ '</b><br />' +
		                                    data.date_receipt +
		                                    '</center>');
		                 $('#btn_'+ id).hide();
		            } else if(stt == '2') {
		                $('#td_'+ id).html( '<center>' +
		                                    '<b  style="color: #177EE5; ">Receive</b>' +
		                                    '<br />' +
		                                    '<b> by '+data.nickname+'</b><br />' +
		                                    data.date_receipt +
		                                    '</center>');
		            }
		            $('#btn_'+ id).hide();
		        },
		        error : function (xhr, status, error){
		            console.log(xhr);
		        },
		    });
			},
			UploadReceipt: function(e){
				var receipt_id = $(e).data('id');
				$("input[name=id_receipt]").val(receipt_id);
				$("#myModalUploadDoReceipt").modal('show');
			},
			addFile: function(){
				$('body').delegate('.btn-add-file', 'click', function(){
				  var id = $(this).data('id');
				  var length = $('.file-row').length;

				  html =    '<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
				                '<div class="controls col-sm-9">'+
				                    '<input class="" type="file" name="userfile[]"> '+
				                '</div>'+
				                '<div class="row col-sm-3">'+
				                    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
				                    '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

				                '</div>'+
				            '</div>';

				  $('#add-row').append(html);
				});
			},
			removeFile: function(){
				$('body').delegate('.btn-remove-file', 'click', function(){
				  var id = $(this).data('id');
				  var length = $('.file-row').length;

				  if(length > 1)
				  {
				    $('#file-row-'+id).remove();
				  }
				});
			},
			run: function(){
				var self = this;

				self.btnShowHide();
				self.addFile();
				self.removeFile();
				//self.save_note();
				

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
