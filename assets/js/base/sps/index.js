var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;
		var TABLE;
		var base = {
			_alert:function(msg){
				alert(msg);
			},


      _dataSps: function(){
            var self = this;
            $(document).ready(function() {
                TABLE = $('#data-sps').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    "ajax": {
                        "url": options.siteURL + "sps/getDataTable",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": 
                    [
											{
				                  "targets": [ 11,12,13],
				                  "visible": false,
				                  "searchable": false
				              },

											{
				                "targets": [4],
				                "createdCell": function (td, cellData, rowData, row, col) {
													html = '';
													//console.log(cellData);
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
				                "targets": [5],
				                "createdCell": function (td, cellData, rowData, row, col) {
													console.log(cellData);

													if(cellData != '')
													{
														$(td).html(cellData);
													}
													else
													{
														setInterval(function () {
															var startDateTime = new Date( rowData['DateOpen'] );
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

												       $(td).html(d + "d " + h + "h " + m + "m ");

														}, 1000);
													}
				                }
				              },
											{
				                "targets": [9],
				                "createdCell": function (td, cellData, rowData, row, col) {



													var karyawan_id = $('#karyawan_id').val();
													var html = '';

													var now = new Date();
													var schedule = new Date(cellData);

													if(karyawan_id == 140 && cellData == '0000-00-00' && rowData['StatusOri'] != 101)
													{
														$(td).attr('id', 'schedule_' + rowData['SPSID']);

														html += '<button class="btn btn-info btn-xs" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "'+ rowData['SPSID'] +'"><span class="fa fa-plus"></span> Add</button>';

														//$(td).html(html);
													}
													else if(karyawan_id == 140 && cellData != '0000-00-00' && rowData['StatusOri'] != 101)
													{
														if(schedule > now)
														{
																$(td).attr('id', 'schedule_' + rowData['SPSID']);
																$(td).css('color', '#0024AE');

																html += '<div style="width : 100px;">';
																html += schedule.getDate() + '-' + (schedule.getMonth() + 1) + '-' + schedule.getFullYear();
																html += '<button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle="modal" data-target="#myModalSchedule" id="schedule" data-id = "'+ rowData['SPSID'] +'"></button>'
																html += '</div>';

																//$(td).html(html);
														}
														else if(schedule < now)
														{
																$(td).attr('id', 'schedule_' + rowData['SPSID']);
																$(td).css('color', '#ff0000');

																html += '<div style="width : 100px;">';
																html += schedule.getDate() + '-' + (schedule.getMonth() + 1) + '-' + schedule.getFullYear();
																html += '<button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle="modal" data-target="#myModalSchedule" id="schedule" data-id = "'+ rowData['SPSID'] +'"></button>'
																html += '</div>';
														}
														else if(schedule == now)
														{
																$(td).attr('id', 'schedule_' + rowData['SPSID']);
																$(td).css('color', '#218A25');

																html += '<div style="width : 100px;">';
																html += schedule.getDate() + '-' + (schedule.getMonth() + 1) + '-' + schedule.getFullYear();
																html += '<button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle="modal" data-target="#myModalSchedule" id="schedule" data-id = "'+ rowData['SPSID'] +'"></button>'
																html += '</div>';
														}
													}
													else
													{
															if(karyawan_id == 140 && rowData['StatusOri'] == 101)
															{
																html = '';
															}
													}

													$(td).html(html);

				                }
				              },

										],

                    "iDisplayLength":50,
                     "orderCellsTop": true,

                });
           
                $("div.dataTables_filter input").unbind();
                $('div.dataTables_filter input').bind('keyup', function(e) {
                    if(e.keyCode == 13) {  
                        TABLE.search( this.value).draw();
                    } 
               });


                    var filterColumns = [2, 6, 8, 10];
                    TABLE.column(filterColumns).every(function () {
                        var that = this;
                        $('input', this.header()).on('keyup', function (e) {
                            if (that.search() != this.value && e.keyCode == 13) {
                                filterColumns.map(function (key, value) {
                                    table = TABLE.column(key).search($(".filterrow" + key).val());
                                })
                                TABLE.draw();
                            }
                        });
                    });
            });
        },
			_selectSPS: function(){
				var self = this;
				$('#select-sps').change(function(){
						var val = $(this).val();

						if(val != '')
						{
							//$('#select-sps').attr('disabled', 'disabled');
							$('#load-data').show();

							TABLE.ajax.url(options.siteURL + 'sps/getDataTable/'+val).load();
							
							setTimeout(function () {
								//$('#select-sps').removeAttr('disabled');
								$('#load-data').hide();
							}, 3000);
						}
						else
						{
							//$('#select-sps').attr('disabled', 'disabled');
							$('#load-data').show();

							TABLE.ajax.url(options.siteURL + 'sps/getDataTable/').load();

							setTimeout(function () {
								//$('#select-sps').removeAttr('disabled');
								$('#load-data').hide();
							}, 3000);
						}
				});
			},
			btnHideShow: function(){
				$("#btn_hide").click(function() {
				   $.fn.dataTable.ext.search.push(
				     function(settings, data, dataIndex) {
				       return $(table.row(dataIndex).node()).attr('data-user') != 101;
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
			job: function(idsps){
				var id = idsps;
			  var status = $("#" + id).data('status');
			  var square = $("#" + id).hasClass('fa-square-o');
				var d_job = (square == true) ? 1 : 0;

				$.ajax({
					type : 'POST',
					url : options.siteURL + 'c_tablesps/check_job/',
					data : {
						data_id : id,
						data_job : d_job,
						data_status : status,
					},
					success : function(data){
						$('#' + id).removeClass('fa-square-o').addClass('fa-check-square-o');
					},
					error : function(){
						alert('failure');
					},
				});

			},
			submitForm: function(){
				$("#form").submit(function() {

				   var tgl = $("#tanggal").val();
				   var id = $("#hidden_id").val();
				   var teknisi = $('#sel_teknisi').val();

				 $.ajax({
				   type : 'POST',
				   url : options.siteURL + 'c_tablesps/schedule/',
				   data : {
				   tgl : tgl,
				   id : id,
				   teknisi : teknisi
				   },
				   dataType : 'json',
				   success : function(data){
				     $('#myModalSchedule').modal('hide');
				     $('#schedule_'+id).load('c_execution/load_data/' + id);
				     $('#status_'+id+' .update').html(data.nickname.toUpperCase());

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
				self.submitForm();

				$(document).on("click", "#schedule", function(){
				   var id = $(this).data('id');
				   $("#hidden_id").val(id);
				   $('#form')[0].reset();
				});

				$("#tanggal").datetimepicker({
				   format: 'DD/MM/YYYY',
				   useCurrent : false
				 });

			},
			init: function(){
				var self = this;
        self._dataSps();
				self._selectSPS();
				self.run();
			}
		};

		return base;
	}
}
