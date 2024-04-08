<div id="page-inner">
  	<div class="row">
    	<div class="col-md-12">
     		<h2>Point</h2>
    	</div>
  	</div>
    <hr />

    <div class="col-md-4">
        <h4>Table Tariff Point Teknisi</h4>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Teknisi</th>
                    <th>Tariff per Point (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if($p_tariff){
                    foreach ($p_tariff as $trf_row) { ?>
                        <tr>
                            <td><?php echo $trf_row['nickname']?></td>
                            <td id = "tariff_<?php echo $trf_row['id']?>" 
                                <?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77', '14'))) { ?>
                                    ondblclick="ajax_edit(<?php echo $trf_row['id']?>, 'tariff', '<?php echo $trf_row['tariff']?>' )"
                                <?php } ?>    
                                ><?php echo $trf_row['tariff']?>
                                
                            </td>
                        </tr>
                    <?php } 
                }?>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <h4>Table Point Job</h4>
        <table class="table table-bordered table-hover">
        	<thead>
        		<tr>
        			<th style="width : 120px;">Jenis Job</th>
        			<th>Point</th>
        		</tr>
        	</thead>
        	<tbody>
                <?php if($p_job){
                    foreach ($p_job as $job_row) { ?>
                        <tr>
                            <td><?php echo $job_row['pekerjaan']?></td>
                            <td id = "job_<?php echo $job_row['id']?>" 
                                <?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77', '14'))) { ?>
                                    ondblclick="ajax_edit(<?php echo $job_row['id']?>, 'job', <?php echo $job_row['point'] ?>)"
                                <?php } ?>    
                                    ><?php echo $job_row['point']?>
                            </td>
                        </tr>
                    <?php }
                } ?>
        	</tbody>
        </table>
    </div>

    <div class="col-md-4">
        <h4>Table Koefisien Point</h4>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width : 100px;">Koefisien</th>
                    <th>Point</th>
                </tr>
            </thead>
            <tbody>
                <?php if($p_koefisien){
                    foreach ($p_koefisien as $ko_row) { ?>
                        <tr>
                            <td><?php echo $ko_row['koefisien_type'] ?></td>
                            <td id = "koef_<?php echo $ko_row['id']?>" 
                                <?php if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77', '14'))) { ?>
                                    ondblclick="ajax_edit(<?php echo $ko_row['id']?>, 'koef', <?php echo $ko_row['nilai']?>)"
                                 <?php } ?>    
                                    ><?php echo $ko_row['nilai']?>
                            </td>
                        </tr>  
                    <?php }
                } ?>
                
            </tbody>
        </table>
        <b style="font-size: 12px;">Point = (Point Job) x D (days) x A <br />
        Point = (Point Job) x B</b>
    </div>

</div>

<script type="text/javascript">
    function ajax_edit(id, type, value){
        
        html = '<div class="col-md-3">'+
                '<form method = "post" enctype="multipart/form-data" action="<?php echo site_url('c_point/update')?>/'+id+'/'+type+'">'+
                    '<div class="input-group">'+
                        '<input id = "'+type+'-'+id+'" type="text" name="points" style="width : 100px; height: 28px;" class="form-control" value="'+value+'">'+
                        '<span class="input-group-btn">'+
                            '<button class="btn btn-info glyphicon glyphicon-floppy-disk" type="submit" title="Save"></button>'+
                        '</span>' +    
                    '</div>' +
                    '</form>'+
                '</div>';
            
        document.getElementById(type+'_'+id).innerHTML = html;
    }

</script>