var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;

		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _dataTools: function(){
        var self = this;
        //console.log(options.siteURL + 'sps/getDataTable');
        $('#data-tools').dataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'tools/getDataTools',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 5,
            "aoColumns": [
              { mData: 'No' } ,
              { mData: 'Photo' },
              { mData: 'IDTool'},
              { mData: 'Name' },
              { mData: 'ToolHolder' },
              { mData: 'Quantity' },
              { mData: 'Notes' },
              { mData: 'Status' },
              { mData: 'Actions' }
            ],
            "columnDefs": [
              { className: "id-tool", "targets": [ 0 ] },
              { className: "code-tool", "targets": [ 2 ] },
              { className: "name-tool", "targets": [ 3 ] },
            ],
            "order": [[ 0, "desc" ]]
        });
      },
			init: function(){
				var self = this;
        self._dataTools();
			}
		};

		return base;
	}
}
