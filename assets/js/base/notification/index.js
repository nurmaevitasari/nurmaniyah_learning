
var BaseJs = {
    createIt: function(options){
        var GLOBAL_JS = options.globalJs;

        var base = {
            _alert:function(msg){
                alert(msg);
            },
      _alljava: function(){
        var self = this;
        //console.log(options.siteURL + 'notification/ajax_notif');
        
      },

        _dataCRM: function(){
            var self = this;
            //var table;
            //console.log(options.siteURL + "notification/ajax_notif");
            $(document).ready(function() {
                TABLE = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": options.siteURL + "notification/ajax_notif",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    /*"columnDefs": [
                    {
                        "targets": [5,10], //first column / numbering column
                       "orderable": false, //set not orderable
                    },
                    {
                        "targets": [0,1],
                       "visible":false,
                    },
                    ],*/

                    "iDisplayLength":50,

                });
            });
        },

        _selectData: function(){
            var self = this;
            $('#click-notif').click(function(){
                var val = $("#val-notif").val();

                if(val == '1')
                {
                    //$('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "notification/ajax_notif/"+val).load();
                   /* TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);*/
                   /* setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
*/
                    $("#val-notif").val("0");
                    $("#click-notif").text("SHOW UNREAD NOTIFICATION");
                    $("#click-notif").removeClass('btn-default');
                    $("#click-notif").addClass('btn-danger');
                    $("h2").text('Read Notification');

                }
                else if(val == '0')
                {
                    //$('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "notification/ajax_notif").load();
                    
                    $("#val-notif").val("1");
                    $("#click-notif").text("SHOW READ NOTIFICATION");
                    $("#click-notif").removeClass('btn-danger');
                    $("#click-notif").addClass('btn-default');
                    $("h2").text('Unread Notification');
                   /* TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);*/

                 /*   setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);*/
                }
            });
        },

        pinned: function()
        {
             return confirm("Are you sure to release the Pin?");
        },

        unpin:function()
        {
             return confirm("Are you sure to release the Unpin?");
        },



        init: function(){
            var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();

        }
    };

        return base;
    }
}





// SEBELUMNYA


// var BaseJs = {
//     createIt: function(options){
//         var GLOBAL_JS = options.globalJs;

//         var base = {
//             _alert:function(msg){
//                 alert(msg);
//             },
//       _alljava: function(){
//         var self = this;
//         //console.log(options.siteURL + 'notification/ajax_notif');
        
//       },

//         _dataCRM: function(){
//             var self = this;
//             //var table;
//             //console.log(options.siteURL + "notification/ajax_notif");
//             $(document).ready(function() {
//                 TABLE = $('#table').DataTable({

//                     "processing": true, //Feature control the processing indicator.
//                     "serverSide": true, //Feature control DataTables' server-side processing mode.
//                     "order": [], //Initial no order.

//                     // Load data for the table's content from an Ajax source
//                     "ajax": {
//                         "url": options.siteURL + "notification/ajax_notif",
//                         "type": "POST"
//                     },

//                     //Set column definition initialisation properties.
//                     /*"columnDefs": [
//                     {
//                         "targets": [5,10], //first column / numbering column
//                        "orderable": false, //set not orderable
//                     },
//                     {
//                         "targets": [0,1],
//                        "visible":false,
//                     },
//                     ],*/

//                     "iDisplayLength":50,

//                 });
//             });
//         },

//         _selectData: function(){
//             var self = this;
//             $('#click-notif').click(function(){
//                 var val = $("#val-notif").val();

//                 if(val == '1')
//                 {
//                     //$('#load-data').show();
                    
//                     TABLE.ajax.url(options.siteURL + "notification/ajax_notif/"+val).load();
//                    /* TABLE.column(0).visible(true);
//                     TABLE.column(1).visible(true);*/
//                    /* setTimeout(function () {
//                         $('#load-data').hide();
//                     }, 3000);
// */
//                     $("#val-notif").val("0");
//                     $("#click-notif").text("SHOW UNREAD NOTIFICATION");
//                     $("#click-notif").removeClass('btn-default');
//                     $("#click-notif").addClass('btn-danger');
//                     $("h2").text('Read Notification');

//                 }
//                 else if(val == '0')
//                 {
//                     //$('#load-data').show();
                    
//                     TABLE.ajax.url(options.siteURL + "notification/ajax_notif").load();
                    
//                     $("#val-notif").val("1");
//                     $("#click-notif").text("SHOW READ NOTIFICATION");
//                     $("#click-notif").removeClass('btn-danger');
//                     $("#click-notif").addClass('btn-default');
//                     $("h2").text('Unread Notification');
//                    /* TABLE.column(0).visible(false);
//                     TABLE.column(1).visible(false);*/

//                  /*   setTimeout(function () {
//                         $('#load-data').hide();
//                     }, 3000);*/
//                 }
//             });
//         },

//         init: function(){
//             var self = this;
//             self._alljava();
//             self._dataCRM();
//             self._selectData();
//         }
//     };

//         return base;
//     }
// }