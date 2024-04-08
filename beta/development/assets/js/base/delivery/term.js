var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;
    var TABLE;
		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _dataDataDelivery: function(){
        var self = this;

        TABLE = $('#data-delivery').DataTable({
            "bProcessing": true,
            "info" : true,
            //"sAjaxSource": options.siteURL + 'delivery/getDataDelivery',
            "ajax" : {
              "type" : "POST",
              "url"  : options.siteURL + 'delivery/getDataDelivery/',
              "dataSrc" : "data"
            },
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 5,
            "order": [[ 0, "desc" ]],
            "aoColumns": [
              { mData: 'ID' },
              { mData: 'NoSO' },
              { mData: 'Date' },
              { mData: 'Customer' },
              { mData: 'Items' },
              { mData: 'TransactionVal' },
              { mData: 'DOAge' },
              { mData: 'ShippingDate' },
              { mData: 'Status' } ,
              { mData: 'Actions' },
              { mData: 'Decr' },
              { mData: 'DateClose' },
              { mData: 'DateEdit' },
              { mData: 'DateOpen' },
              { mData: 'Category' },
							{ mData: 'RowsTotal' }
            ],
            "columnDefs": [
              {
                  "targets": [ 10,11,12,13,14,15 ],
                  "visible": false,
                  "searchable": false
              },
							{
                "targets": [4],
                "createdCell": function (td, cellData, rowData, row, col) {
									html = '';
									console.log(cellData);
									if(cellData != null)
									{
										var src = cellData.search('@');

										html = '<ul style="padding-left:10px;">';

										if(src > 0){

											var product = cellData.split('@');

											for(var i = 0;i<product.length;i++)
											{
												html += '<li>' + product[i] + '</li>';
											}

										}
										else
										{
											html += '<li>' + cellData + '</li>';
										}

										html += '</ul>';
									}

                  $(td).html(html);

                }
              },
              {
                "targets": [6],
                "createdCell": function (td, cellData, rowData, row, col) {
									console.log(cellData);

									if(cellData != '')
									{
										$(td).html(cellData);
									}
									else
									{
										setInterval(function () {
											var startDateTime = new Date(rowData['DateOpen']);
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
              {
                "targets": [7],
                "createdCell": function (td, cellData, rowData, row, col) {

                  var pos = $('#pos-val').val();
                  var pos_arr = [1, 2, 19, 55, 56, 57, 58, 59, 60, 62, 75, 77];

                  if($.inArray(pos, pos_arr))
                  {
                    $(td).attr('ondblclick', 'baseJs.changetgl('+ rowData['ID'] +')');
                  }
                  $(td).attr('id', 'tgl_' + rowData['ID']);

                }
              },
              {
                "targets": [8],
                "createdCell": function (td, cellData, rowData, row, col) {

                  var pos = $('#pos-val').val();
                  var pos_arr = [1, 2, 19, 55, 56, 57, 58, 59, 60, 62, 75, 77];

                  if($.inArray(pos, pos_arr))
                  {
                    $(td).attr('ondblclick', 'baseJs.changestatus('+ rowData['ID'] +')');
                  }
                  $(td).attr('id', 'chg_' + rowData['ID']);

                }
              },
            ],
        });
      },
      _refreshData: function(){
          var self = this;
          $('body').delegate('#btn-refresh', 'click', function(){
            var toshow = $(this).data('toshow');

            if(toshow == 'delivery_finished')
            {

                $('#btn-refresh').attr('disabled', 'disabled');
                $('#btn-refresh').html('<i class="fa fa-refresh fa-spin"></i> Show Finish');


                TABLE.ajax.url(options.siteURL + 'delivery/getDataDelivery/delivery_finished').load();

                setTimeout(function () {

                  $('#btn-refresh').data('toshow', 'delivery');
                  $('#btn-refresh').removeClass('btn-info');
                  $('#btn-refresh').addClass('btn-primary');
                  $('#btn-refresh').html('<i class="fa fa-flag"></i> Hide Finish');
                  $('#btn-refresh').removeAttr('disabled');
                }, 3000);
            }
            else
            {
                $('#btn-refresh').attr('disabled', 'disabled');
                $('#btn-refresh').html('<i class="fa fa-refresh fa-spin"></i> Hide Finish');


                TABLE.ajax.url(options.siteURL + 'delivery/getDataDelivery/').load();

                setTimeout(function () {
                  $('#btn-refresh').data('toshow', 'delivery_finished');
                  $('#btn-refresh').removeClass('btn-primary');
                  $('#btn-refresh').addClass('btn-info');
                  $('#btn-refresh').html('<i class="fa fa-flag"></i> Show Finish');
                  $('#btn-refresh').removeAttr('disabled');
                }, 1000);

            }

          });
      },
			changestatus: function(id){
				$('#myModalStatus').modal('show');
				document.getElementById('ch_do_id').value = id;
			},
			changetgl: function(id){
				$('#myModalTgl').modal('show');
				$('#form_tgl')[0].reset();
				document.getElementById('tgl_do_id').value = id;
			},
			_formSubmit: function(){
				$("#form_status").submit(function() {

					var id = $("#ch_do_id").val();
					var status = $('#chgstatus').val();
					//alert(status);

					$.ajax({
					type : 'POST',
					url : options.siteURL + 'C_delivery/changeStatus/',
					data : {
					id : id,
					status : status,
					},
					dataType : 'json',
					success : function(data){
					var sts = (data.status).toLowerCase();
					$('#myModalStatus').modal('hide');
					$('#chg_'+ id).html('<b>' +data.user_pending+ '</b><br />' +
					          '<span class="label ' + sts +'">' + data.status + '</span><br>' +
					          '<span style="font-size: 10px;">Last Updated: ' + data.date_created +'<br>' +
					          '<b>By : ' + data.nickname + '</b></span>' );
					//$("#sts_" + id).addClass(data.status).toLowerCase();
					},
					error: function (xhr, status, error){
					  console.log(xhr);
					}
					});

					return false;

				});
			},
			run: function(){
				var self = this;

				$("#tgl_kirim").datetimepicker({
					format: 'DD/MM/YYYY',
					useCurrent : false
				});

				$("#tgl_ket").hide();

				$('input[type="radio"]').on('click', function() {
					 if($(this).attr("value")=="0"){
					  $("#tgl_ket").show();
					  $(".text_ket").prop('required', true);
					}else if ($(this).attr("value")=="1"){
					  $("#tgl_ket").hide();
					  $(".text_ket").prop('required', false);
					}
				});

				$('#myTabs').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				});

			},
			init: function(){
				var self = this;
        self._dataDataDelivery();
        self._refreshData();
				self._formSubmit();
				self.run();
			}
		};

		return base;
	}
}
