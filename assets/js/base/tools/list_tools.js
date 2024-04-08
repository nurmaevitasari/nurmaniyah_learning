var BaseJs = {
  createIt: function(options){
    var GLOBAL_JS = options.globalJs;

    var base = {
      _alert:function(msg){
        alert(msg);
      },
       _dataTools: function(){
        var self = this;

        $(document).ready(function() 
        {
            var pos = $("#pos").val();
            var kar = $('#kar_id').val();

                if(pos == 1 || pos == 2 || pos == 14 || pos == 83 || kar ==688 || pos==168)
                {

                   TABLE = $('#data-tools').DataTable(
                   {

                      "processing": true, 
                      "serverSide": true,
                      "order": [],
                      "ajax": {
                          "url": options.siteURL + 'tools/getDataTools',
                          "type": "POST"
                      },
                      "columnDefs": [
                        { className: "id-tool", "targets": [ 0 ] },
                        { className: "code-tool", "targets": [ 2 ] },
                        { className: "name-tool", "targets": [ 3 ] },
                        {
                          "targets": [1], 
                          "orderable": false, 
                        },
                      ],

                      "iDisplayLength":10,
                    });

                }else
                {
                  TABLE = $('#data-tools').DataTable(
                   {

                      "processing": true, 
                      "serverSide": true,
                      "order": [],
                      "ajax": {
                          "url": options.siteURL + 'tools/getDataTools',
                          "type": "POST"
                      },
                      "columnDefs": [
                        { className: "id-tool", "targets": [ 0 ] },
                        { className: "code-tool", "targets": [ 2 ] },
                        { className: "name-tool", "targets": [ 3 ] },
                        {
                          "targets": [1,8], 
                          "orderable": false, 
                        },
                        {
                          "targets": [4,8],
                         "visible":false,
                        },
                      ],

                      "iDisplayLength":10,
                    });

                }

        });
 
      },


         _selectData: function()
        {
            var self = this;
            $('#select-crm').change(function()
            {
                var val = $(this).val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "tools/getDataTools/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
   
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "tools/getDataTools").load();
                    TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },


      init: function(){
        var self = this;
        self._dataTools();
        self._selectData();
      }
    };

    return base;
  }
}
