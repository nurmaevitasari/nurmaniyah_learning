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

        _dataCRMDetail: function(){
            var self = this;
            //var table;
            //console.log(options.siteURL + 'sps/getDataTable');

            $(document).ready(function() {

              var id = $('#id').val();


              TABLE = $('#table-details').DataTable({
                        "scrollY": "500px",
                        "scrollCollapse": true,
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        "order": [], //Initial no order.

                        "ajax": {
                            "url": options.siteURL + "sop/ajax_detail/"+id,
                            "type": "POST"
                        },

                        "columnDefs": [

                            {
                                "targets": [4], //first column / numbering column
                               "orderable": false, //set not orderable
                            },
                        ],

                        "iDisplayLength":50,
                  });

         ;

           
               //  $("div.dataTables_filter input").unbind();
               //  $('div.dataTables_filter input').bind('keyup', function(e) {
               //      if(e.keyCode == 13) {  
               //          TABLE.search( this.value).draw();
               //      }
               // });

            });
 
        },

        _selectData: function()
        {
            var self = this;
            $('#select-subject').change(function()
            {
                var val = $(this).val();
                var id = $('#id').val();

                if(val != '')
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "sop/ajax_detail/"+id+"/"+val).load();
                    TABLE.column(0).visible(true);
                    TABLE.column(1).visible(true);
                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);

                      
                }
                else
                {
                    $('#load-data').show();
                    
                    TABLE.ajax.url(options.siteURL + "sop/ajax_detail").load();
                    TABLE.column(0).visible(false);
                    TABLE.column(1).visible(false);

                    setTimeout(function () {
                        $('#load-data').hide();
                    }, 3000);
                }
            });
        },

        edit: function(e)
        {

            var id = $(e).data('id');

            // $('#form1')[0].reset(); 
            // $('.form-group').removeClass('has-error'); 
            // $('.help-block').empty(); 
         
            $.ajax({
                // url : "<?php  echo site_url('sop/get_data_subject/')?>/" +id,
                url: options.siteURL + "sop/get_data_subject/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  console.log()
               
                    $('#myModalSubjectEdit').modal('show');
                    $('[name="subject_id"]').val(data.id);
                    CKEDITOR.instances['subject'].setData(data.subject)
                    CKEDITOR.instances['remark'].setData(data.remark)
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });

        },

        save_edit_subject:function(e)
        {
            
              $('#btnSave').text('saving...'); //change button text
              $('#btnSave').attr('disabled',true); //set button disable

              url = "<?php echo site_url('employee/edit_pendidikan')?>";
           
              $.ajax({
                  url : url,
                  type: "POST",
                  data: $('#form1').serialize(),
                  dataType: "JSON",
                  success: function(data)
                  {
                      if(data.status) //if success close modal and reload ajax table
                      {
                          $('#myModalSubjectEdit').modal('hide'); 
                      }
           
                      $('#btnSave').text('save'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable   
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error adding / update data');
                      $('#btnSave').text('save'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable
                  }
              });

        },

        change_status:function(e)
        {
            var id = $(e).data('id');

    
            $.ajax({
                // url : "<?php  echo site_url('sop/get_data_subject/')?>/" +id,
                url: options.siteURL + "sop/get_data_subject/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  console.log()
               
                    $('#mymodaleditstatussubject').modal('show');

                    $("input[name='status'][value='"+data.status+"']").prop('checked', true);

                    $('[name="subject_id"]').val(data.id);
                    // CKEDITOR.instances['subject'].setData(data.subject)
                    // CKEDITOR.instances['remark'].setData(data.remark)
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        },

        filesubject: function(e)
        {
          var id = $(e).data('id');
          $("#subjct").val(id);
          $('#myModalUploadsubject').modal('show');
        },



        init: function(){
            var self = this;
            self._alljava();
            self._dataCRMDetail();
            self._selectData();
           
        }
    };

        return base;
    }
}