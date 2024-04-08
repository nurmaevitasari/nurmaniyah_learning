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
	            "sAjaxSource": options.siteURL + 'Project/getDataTable',
	            "bPaginate":true,
	            "sPaginationType":"full_numbers",
	            "iDisplayLength": 10,
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

		init: function(){
			var self = this;
        	self._alljava();
        	self._dataProject();
		}
	};

		return base;
	}
}
