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
	            "sAjaxSource": options.siteURL + 'project/getDataTable',
	            "bPaginate":true,
	            "sPaginationType":"full_numbers",
	            "iDisplayLength": 100,
	            "aaSorting": [[0, "desc"]],
	            "aoColumns": [
	              { mData: 'ProjectID' } ,
	              { mData: 'Customer' },
	              { mData: 'DPdate' },
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
				],
	        });
      	},

      	_selectData: function(){ 
            var self = this;
            $('#select-project').change(function(){ 
                var val = $(this).val();
                console.log(val);
                $('#load-data').show();

                if(val != '')
                {
                    TABLE.ajax.url(options.siteURL + "project/getDataTable/"+val).load();
                }
                else
                {
                    TABLE.ajax.url(options.siteURL + "project/getDataTable").load();
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
