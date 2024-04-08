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

      	_dataProject: function(){
	        var self = this;
	        //console.log(options.siteURL + 'sps/getDataTable');
	        TABLE = $('#tbl-project').DataTable({
	            "bProcessing": true,
	            "sAjaxSource": options.siteURL + 'Project_dwt/getDataTable',
	            "bPaginate":true,
	            "sPaginationType":"full_numbers",
	            "iDisplayLength": 100,
	            "aaSorting": [[4, "desc"]],
	            "aoColumns": [
	              { mData: 'ProjectID' } ,
	              { mData: 'Customer' },
	              { mData: 'DPdate' },
	              { mData: 'PaidDate' },
	              { mData: 'date_closed' },
	              { mData: 'ProjectDesc' },
	              { mData: 'ProjectAging' },
	              { mData: 'Progress' },
	              { mData: 'Status' },
	              { mData: 'Execution'},
	              { mData: 'Action' },
	            ],
				"columnDefs": [
					{
		                "targets": [5,7],
		                "searchable": false

		            },

		            {
		                "targets": [3],
		                "visible": false
		                
		            },
		            {
		                "targets": [4],
		                "visible": false
		                
		            },
				],
	        });
      	},

      	_selectData: function(){
            var self = this;
            $('#select-project').change(function(){
                var val = $(this).val();

                $('#load-data').show();

                if(val != '')
                {

                	
                    TABLE.ajax.url(options.siteURL + "Project_dwt/getDataTable/"+val).load();
                     TABLE.column(3).visible(true);

                }
                else
                {
                
                    TABLE.ajax.url(options.siteURL + "Project_dwt/getDataTable").load();
                    TABLE.column(3).visible(false);


                }

                setTimeout(function () {
                    $('#load-data').hide();
                }, 3000);
            });
        },

		init: function(){
			var self = this;
        	self._alljava();
        	self._dataProject();
        	self._selectData();
		}
	};

		return base;
	}
}
