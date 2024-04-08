var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;

		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _dataHolderTools: function(){
        var self = this;
        //console.log(options.siteURL + 'sps/getDataTable');
        $('#data-holder-tools').dataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'tools/getDataHolderTools',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 5,
            "aoColumns": [
              { mData: 'No' } ,
              { mData: 'Name' },
              { mData: 'Position'},
              { mData: 'ToolsInHand' },
              { mData: 'LastReport' },
              { mData: 'Actions' }
            ],
        });
      },
			init: function(){
				var self = this;
        self._dataHolderTools();
			}
		};

		return base;
	}
}
