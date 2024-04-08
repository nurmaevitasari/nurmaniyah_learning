var GlobalJs = {
    createIt: function (options) {
        var TIME_TO_LOAD = 1000;

        var base = {
            _alert: function (msg) {
                alert(msg);
            },
            _ajaxFileJsonFeedBack: function (toLoad, varData, callback) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: toLoad,
                    data: varData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data, status, xhr) {
                        callback(data);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                    }
                });
            },
            _ajaxJsonFeedBack: function (toLoad, varData, callback) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: toLoad,
                    data: varData,
                    dataType: 'json',
                    success: function (data) {
                        callback(data);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                    }
                });
            },

            _datePickerQuo: function (start, end) {
				        //console.log('today:'+start);
                var date = new Date();
                var firstDay = new Date(date.getFullYear(), date.getMonth(), 01);
                //var lastDay = new Date(date.getFullYear(), date.getMonth(), 0+1);

                var date1 = new Date(), y = date.getFullYear(), m = date.getMonth();
                var firstDay1 = new Date(y, m, 1);
                var lastDay1 = new Date(y, m + 1, 0);

                //console.log(firstDay1);
                //console.log(lastDay1);


                var month = date.getMonth() + 1;
                if (month = 11) {
                  //console.log('november');
                }

                var startDate = '';
                var endDate = '';

                if (start != '' && typeof start !== "undefined")
                {
                    var date = new Date(start);
                    startDate = new Date(date.getFullYear(), date.getMonth(), 01);
                } else
                {
                    startDate = firstDay ;
                }

                if (end != '' && typeof end !== "undefined")
                {
                    var date = new Date(end);
                    endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                } else
                {
                    endDate = lastDay1;
                }

                $('.date-picker').datepicker({
                    orientation: "left",
                    autoclose: true,
                    startDate: startDate,
                    //todayHighlight: true,
                    endDate: endDate,
                    //startDate:
                });
            },

            _datePicker: function (start, end) {
				//console.log('today:'+start);
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                var startDate = '';
                var endDate = '';

                if (start != '' && typeof start !== "undefined")
                {
                    var date = new Date(start);
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                } else
                {
                    startDate = today;
                }

                if (end != '' && typeof end !== "undefined")
                {
                    var date = new Date(end);
                    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                    // endDate = new Date(date.getFullYear(), date.getMonth(), 30);
                } else
                {
                    endDate = 0;
                }

                $('.date-picker').datepicker({
                    orientation: "left",
                    autoclose: true,
                    startDate: startDate,
                    //todayHighlight: true,
                    endDate: endDate,
                    //startDate:
                });
            },
            _getDate: function ( element ) {
			      var date;
			      try {
			        date = $.datepicker.parseDate( dateFormat, element.value );
			      } catch( error ) {
			        date = null;
			      }

			      return date;
			},
			_datePickerBillcomPeriod: function ( element ) {
				$('#billcom-period').daterangepicker({
					locale : {
						format : 'D MMMM, YYYY'
					} 
				}, function(start, end, label) {
					period = $('#payment-type :selected').val();

	                $.ajax({
	                    type: 'POST', 
	                    url: options.baseUrl+'billcom/getpaymentperiode',
	                    data: {period: period, start: start.format('YYYY-MM-DD'), end: end.format('YYYY-MM-DD')},
	                    dataType: 'json',
	                    success: function (data) {
	                        $('#payment-add-element').html(data.html);
	                    },
	                    error: function (xhr, status, error) {
	                        console.log(xhr);
	                    }
	                });

					$("input[name='start']").val(start.format('YYYY-MM-DD'));
					$("input[name='end']").val(end.format('YYYY-MM-DD'));
				});
			},
            _datePickerQuo3: function () {
            	// check was on step 3 ?
            	$.get( options.baseUrl + 'quotation/get_current_step', function( on_step ) {
            		console.log(on_step);
					if(on_step == "step3"){
						var start_rows = [];
						var end_rows = [];
						$("input[name='start_date\\[\\]']").map(function(){
							start_rows.push($(this).val());
						}).get();

						$("input[name='end_date\\[\\]']").map(function(){
							end_rows.push($(this).val());
						}).get();

						$.ajaxSetup({async:false});

						for (i = 0; i < start_rows.length; i++) {
							var id = i + 1;
							var product_partner = $('#product-partner-'+id).find(":selected").val();
							var bill_id = $('#bill_id').val();

							$.post( options.baseUrl + 'quotation/getdataproductpartner', {product_partner: product_partner, bill_id: bill_id}, function( data ) {
								$('#date-picker-range-'+id).daterangepicker({
									locale: { format: 'D MMMM, YYYY' },
									"startDate": moment(start_rows[i], "YYYY-MM-DD").format('D MMMM, YYYY'),
									"minDate": moment(data.bill_start_date, "YYYY-MM-DD").format('D MMMM, YYYY'),
									"endDate": moment(end_rows[i], "YYYY-MM-DD").format('D MMMM, YYYY'),
									"maxDate": moment(data.bill_end_date, "YYYY-MM-DD").format('D MMMM, YYYY')
								}, function(start, end, label) {
									$('#start-date-' + id).val(start.format('YYYY-MM-DD'));
									$('#end-date-' + id).val(end.format('YYYY-MM-DD'));
									$('#date-picker-range-' + id).val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
								});
							}, "json");
						}
					}else{
		            	// $(".date-picker-range").prop('disabled', true);
						$( ".product-partner" ).change(function() {
			            	var id = $(this).data('id');
		                    var val = $(this).val();
		                    // var number = $(this).attr("id").split("-");
		                    var number = $(this).attr("data-id");

		                    $.post( options.baseUrl + 'quotation/getdataproductpartner', {product_partner: val, bill_id:$('#bill_id').val()}, function( data ) {
							  	$("#date-picker-range-"+parseInt(number)).prop('disabled', false);

		                        $('#product-price-' + id).val(data.price);
		                        $('#product-selling-' + id).val(data.selling_price);
		                        $('#discount-' + id).val(data.discount);
								$('#sla-' + id).val(data.sla);
								$('#billcom-start-date').val(data.bill_start_date);
								$('#billcom-end-date').val(data.bill_end_date);
								$('#diff').val(data.diff);

								if(data.bill_start_date != null){
									var startDate = data.bill_start_date;
								}else{
									var startDate = moment(data.quotation_date, "MM/DD/YYYY").add(parseInt(data.sla), 'days').format('YYYY-MM-DD');
								}

								if(data.bill_end_date != null){
									var endDate = data.bill_end_date;
								}else{
									var endDate = moment(data.quotation_date, "MM/DD/YYYY").add(parseInt(data.sla), 'days').endOf('month').format('YYYY-MM-DD');
								}
								// sementara di hide untuk backdate
								$('#date-picker-range-'+parseInt(number)).daterangepicker({
									locale: { format: 'D MMMM, YYYY' },
								    // "startDate": moment(startDate, "YYYY-MM-DD").format('D MMMM, YYYY'),
								    // "minDate": moment(startDate, "YYYY-MM-DD").format('D MMMM, YYYY'),
								    // "endDate": moment(endDate, "YYYY-MM-DD").format('D MMMM, YYYY'),
								    // "maxDate": moment(endDate, "YYYY-MM-DD").format('D MMMM, YYYY')
								}, function(start, end, label) {
									$('#start-date-' + parseInt(number)).val(start.format('YYYY-MM-DD'));
									$('#end-date-' + parseInt(number)).val(end.format('YYYY-MM-DD'));
									$('#date-picker-range-'+parseInt(number)).val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
								});
							  }, "json");
						});
					}
                }, "json");

            },
            _dateTimePicker: function (start, end) {

                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                var startDate = '';
                var endDate = '';

                if (start != '' && typeof start !== "undefined")
                {
                    var date = new Date(start);
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                } else
                {
                    startDate = today;
                }

                if (end != '' && typeof end !== "undefined")
                {
                    var date = new Date(end);
                    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                } else
                {
                    endDate = 0;
                }

                $(".date-time-picker").datetimepicker({
                    autoclose: true,
                    isRTL: App.isRTL(),
                    format: "dd-mm-yyyy hh:ii",
                    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
                    startDate: startDate,
                    endDate: endDate,
                });
            },
            _select2: function (placeholder) {
                $('.input-select2').select2({
                    placeholder: placeholder,
                    width: null
                });
            }, /*
             _select2Ajax:function(url){
             $('.input-select2-ajax').select2({
             ajax: {
             url: url,
             dataType: 'json',
             delay: 250,
             data: function(params) {
             return {
             id: params.id, // search term
             name: params.name
             };
             },
             processResults: function(data, page) {
             // parse the results into the format expected by Select2.
             // since we are using custom formatting functions we do not need to
             // alter the remote JSON data
             return {
             results: data.items
             };
             },
             cache: true
             },
             });
             },	*/
            _basicDataTable: function () {
                $('.basic-data-tables').DataTable();
            }, /*
             _textAreaMaxLength: function(maxLength){
             $('.text-area-max-length').maxlength({
             max : maxLength,
             //truncate: false,
             feedbackText: '{r} karakter tersisa (maksimal {m} karakter)',

             });
             },*/
            _textAreaMaxLength: function (maxLength) {
                $('.text-area-max-length').maxlength({
                    limitReachedClass: "label label-danger",
                    alwaysShow: true,
                    placement: 'top-left'
                });
            },
            _globalValidation: function(){
                var self = this;
                jQuery.validator.addMethod("greaterThanZero", function(value, element) {
				    return this.optional(element) || (parseInt(value) > 0);
				}, "Nilai harus lebih besar dari 0");

            },
            init: function () {
                var self = this;
                //self._select2();
            }
        };

        return base;
    }
}
