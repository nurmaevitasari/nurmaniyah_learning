var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;

		var base = {
			_alert:function(msg){
				alert(msg);
			},

		_dataImport: function(){
            var self = this;
            var divisi = $('#select-divisi').val();
            var val = $('#select-import').val();

            var startTime = performance.now();

            $(document).ready(function() {
                TABLE = $('#data-import').DataTable({
            
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "Import/getDataImport/"+val+"/"+divisi,
                        "type": "POST",
                        "dataSrc": function ( json ) 
                        {
           
			                var endTime = performance.now();
						    var times =endTime - startTime;
						    var seconds = ((times % 60000) / 1000).toFixed(2);

						    var load = seconds +' Second';

						    $('.times').text(load);
			                return json.data;
			            } 
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
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
									var startDateTime = new Date(rowData[10] );
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

									$(td).html(d + "d " + h + "h " + m + "m " + s + "s");
								}, 1000);
							}
		                }
		            },
		            {
		                "targets": [7],
		                "createdCell": function (td, cellData, rowData, row, col) 
		                {
		                    //console.log(rowData[11]);
		                    $(td).attr('id', 'td_notes_' + rowData[10]);

		                }
		            },
                    {
                        "targets": [9], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [10,11], //first column / numbering column
                        "visible": false, //set not orderable
                    },
                   
                    ],

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

        _selectData: function()
        {
            var self = this;

            var startTime = performance.now();
    	    
            $('#select-import').change(function()
            {	

                var val = $(this).val();

                var divisi = $('#select-divisi').val();


                $('#load-data').show();
                TABLE.ajax.url(options.siteURL + "import/getDataImport/"+val+"/"+divisi).load();
           
                setTimeout(function () {
                    $('#load-data').hide();
                }, 3000);

            });


            var endTime = performance.now();
		    var times =endTime - startTime;
		    var seconds = ((times % 60000) / 1000).toFixed(2);

		    var load = seconds +' Second';

		    $('.times').text(load);

        },

         _selectDivisi: function()
        {
            var self = this;

            var startTime = performance.now();

            $('#select-divisi').change(function()
            {
                var divisi = $(this).val();
                var val = $('#select-import').val();
           
                $('#load-data').show();
                TABLE.ajax.url(options.siteURL + "import/getDataImport/"+val+"/"+divisi).load();
           
                setTimeout(function () {
                    $('#load-data').hide();
                }, 3000);
                
            });


            var endTime = performance.now();
		    var times =endTime - startTime;
		    var seconds = ((times % 60000) / 1000).toFixed(2);

		    var load = seconds +' Second';

		    $('.times').text(load);

        },

        modalNotes: function()
        {
			$('body').delegate('.btn-notes', 'click', function(){

				CKEDITOR.instances['tx-notes'].destroy();
			
				$("#form_notes")[0].reset();
				$("#mymodalNotes").modal('show');
				var import_id = $(this).data('id');

				$("input[name='import_id']").val(import_id);
			});
		},
		
		notesSubmit: function()
		{
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
				self._selectData();
				self._selectDivisi();
			}
		};

		return base;
	}
}
