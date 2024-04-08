var BaseJs = {

    createIt: function(options){

        var GLOBAL_JS = options.globalJs;
        var base = {
            _alert:function(msg){
                alert(msg);
            },

      _alljava: function(){

        var self = this;

      },
        _dataCRM: function(){
            var self = this;

            //var table;

            //console.log(options.siteURL + 'sps/getDataTable');

            $(document).ready(function() {


                    TABLE = $('#tbl-point').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.
                        // Load data for the table's content from an Ajax source

                        "ajax": {
                            "url": options.siteURL + "point/ajax_list",
                            "type": "POST"
                        },

                        "createdRow": function(row, data, dataIndex) {

                            var a = $(row).find('td:eq(0)').html();
                            $(row).find('td:eq(9)').attr('id', "status_" + a);
                            $(row).find('td:eq(6)').attr('id', "pri_" + a);    
                        },

                        "columnDefs": [

                            {
                                "targets": [10,12], //first column / numbering column
                                "orderable": false, //set not orderable
                            },

                            {

                              }, 

                        ],

                        "iDisplayLength":50,
                    });
                
            });

        },


        _selectData: function(){

            var self = this;
            $('#bulan').change(function(){

            
                var val = $('#bulan2').val();

                if(val != '')
                {

                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "point/ajax_list/"+val).load();
                    setTimeout(function () 
                    {
                        $('#load-data').hide();

                    }, 3000);


                }
                else
                {
                    $('#load-data').show();
                    TABLE.ajax.url(options.siteURL + "point/ajax_list").load();
                    setTimeout(function () {

                        $('#load-data').hide();
                    }, 3000);

                   
                }

            });

        },
        pay:function()
        {

               // Handle click on "Select all" control
               $('#pay_all').on('click', function(){
                  // Check/uncheck all checkboxes in the table
                  var rows = TABLE.rows({ 'search': 'applied' }).nodes();
                  $('input[type="checkbox"]', rows).prop('checked', this.checked);
               });

               // Handle click on checkbox to set state of "Select all" control
               $('#tbl-point tbody').on('change', 'input[type="checkbox"]', function(){
                  // If checkbox is not checked
                  if(!this.checked){
                     var el = $('#pay_all').get(0);
                     // If "Select all" control is checked and has 'indeterminate' property
                     if(el && el.checked && ('indeterminate' in el)){
                        // Set visual state of "Select all" control 
                        // as 'indeterminate'
                        el.indeterminate = true;
                     }
                  }
               });
        },

        dtl:function()
        {

              // $('#modalDetailPoint')[0].reset(); 
              $("#tbl-point").on("click",".dtl", function() 
              { 
    
                    var kar = $(this).closest("tr").find(".kar").val();
                    var bulan = $("#bulan2").val();

                    $.ajax({
                      url : options.siteURL + 'Point/getDetailPoint/',
                      type : "POST",
                      data : {
                        data_kar : kar,
                        data_month : bulan,
                      }, 
                      dataType : "json",
                      success : function(data) 
                      {
                        console.log(data);
                        $("#modalDetailPoint").modal('show');
                        var row = '';
                        $.each(data, function(i, arr) 
                        {
                          var total = data.length;
                          $('#total').text(total);

                          switch (arr.modul)
                          {
                            case "2": // WL 36739
                            modul  ="Delivery";
                            modul_id = arr.modul_id; 
                            link1 = options.siteURL + 'c_delivery/details/'+modul_id;
                            link = '<a href="'+link1+'" target="blank_">'+modul_id+'</a>';
                            break;

                            case "3":
                            modul  ="SPS";
                            job_id = arr.modul_id; 

                            getJobId(arr.modul_id);
                            link1 = options.siteURL + 'c_tablesps_admin/update/'+job_id;
                            link = '<a href="'+link1+'" id="sps_'+job_id+'"></a>';
                            break;

                            case "6":
                            modul  ="Import";
                            modul_id = arr.modul_id; 
                            link1 = options.siteURL +'c_import/details/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;

                            case "7":
                            modul="Wishlist";
                            modul_id = arr.modul_id;
                            link1 = options.siteURL + modul+'/detail/'+modul_id;
                            link = '<a href="'+link1+'" target="blank_">'+modul_id+'</a>';
                            break;

                            case "8":
                            modul = 'CRM';
                            modul1 = 'crm'; // pipit 09032020
                            modul_id = arr.modul_id;
                            link1 = options.siteURL+modul1+'/details/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;

                            case "9":
                            modul = 'Project';
                            modul_id = arr.modul_id;
                            link1 = options.siteURL + modul+'/details/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;

                            case "19":
                            modul = 'CashTopUp';
                            modul_id = arr.modul_id;
                            link = modul_id; // pipit 17012020
                            break;

                            case "15":
                            modul = 'Overtime';
                            modul_id = arr.modul_id;
                            link1 = options.siteURL + modul+'/details/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;

                            case "21":
                            modul = 'Auto Point';
                            modul1 = 'auto_point';
                            modul_id = arr.modul_id;
                            link1 = options.siteURL + modul1+'/details/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;

                            case "22":
                            modul = 'Absensi';
                            modul1 = 'auto_point';
                            modul_id = arr.modul_id;
                            link = modul_id;
                            break;

                            case "44":
                            modul = 'Tax Invoicing';
                            modul1 = 'tax_invoicing';
                            modul_id = arr.modul_id;
                            link1 = options.siteURL + modul1+'/detail/'+modul_id;
                            link = '<a href="'+link1+'">'+modul_id+'</a>';
                            break;



                            default:
                            modul = arr.modul;
                            break;
                          }
                          row +=
                          '<tr>' +
                            '<td>' + arr.date_created + '</td>' +
                            '<td>' + arr.nickname + '</td>' +
                            '<td>' + modul + '</td>' +
                            '<td id= "td_'+arr.modul_id+'">'+link+'</td>' +
                            '<td>' + arr.point + '</td>' +
                            '<td>' + arr.tariff_point + '</td>' +
                            '<td>' + arr.total_tariff + '</td>' +
                            '<td>' + arr.tariff_supervisi + '</td>' +
                            '<td>' + arr.total_supervisi + '</td>' +
                          '</tr>';


                        });

                        $("#detailPoint").html(row);
                      
                      },

                      error : function (xhr, status, error){
                            console.log(xhr);
                          }

                    });
            });
        },

      


    init: function()
    {
            var self = this;
            self._alljava();
            self._dataCRM();
            self._selectData();
            self.pay();
            self.dtl();

    },

    };

    return base;

    }

}



