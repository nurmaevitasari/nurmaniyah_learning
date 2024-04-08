<?php $user = $this->session->userdata('myuser'); 
    $position_id = $user['position_id'];
?>
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    //border: 1px solid #ddd;
    font-size: 12px;
}

th, td {
    border: none;
    text-align: left;
    padding: 8px;
}

input::-webkit-input-placeholder {
    font-size: 10px;
    line-height: 2;
}

tr:nth-child(even) {
	//background-color: #f2f2f2;
	
}
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Table Point Teknisi</h2>
		</div>
	</div>
	<hr />

    <?php if($position_id == 1 OR $position_id == 2 OR $position_id == 14 OR $position_id == 77 ){ ?>
    <div> 
        <a target="_blank" href="<?php echo site_url('c_point_summary'); ?>" type="button" class="btn btn-warning">POINT SUMMARY</a><br /><br />
    </div>
    <?php }  ?>

        <div style=" overflow-x: auto;" class="table table-responsive">
        <table class="table table-hover" id = "example">
            <thead>
                <?php if(in_array($position_id, array('1','2','77','65', '66', '67', '68', '71', '72', '55', '56', '57', '58', '14', '88', '89', '90', '91', '92', '93' )))
                { ?>
                    <tr>
                        <th style="width : 20px;">Point ID</th>
                        <th style="width: 100px;">Teknisi</th>
                        <th>Job ID</th>
                        <th>Bobot Job</th> 
                        <th>Process Time</th>
                        <th style="width: 50px;">Finish Date</th>
                        <th>Point</th>
                        <th style="width: 30px;">Point Tambahan</th>
                        <th style="width: 20px;">Total Point</th>
                    </tr>
                    <tr class="filterrow">
                        <th style="width : 20px;"></th>
                        <th class="filterrow">Teknisi</th>
                        <th class="filterrow" style="width : 74px;">Job ID</th>
                        <th></th>  
                        <th></th>  
                        <th class="filterrow" style="width: 100px;">Finish Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
            </thead>

            <tbody>
                <?php if($point)
                {
                    foreach ($point as $p_row) 
                    { 
                        if($p_row['point_tambahan']) 
                        {
                            $point_tambahan = $p_row['point_tambahan'];
                        }else {
                            $point_tambahan = '0';
                        }
                        ?>
                        <tr>
                            <td><?php echo $p_row['id']; ?></td>
                            <td><?php echo $p_row['nickname'];  ?> 
                            </td>
                            <td><a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$p_row['sps_id'])?>"><?php echo $p_row['job_id']; ?></a></td>
                            <td>
                                Perkiraan Lama Pekerjaan : <?php 
                                $range = $p_row['range_time'];
                                $dtF = new DateTime("@0");
                                $dtT = new DateTime("@$range");

                                echo $dtF->diff($dtT)->format('%aD %hH %iM');?><br />
                                Tingkat Kesulitan : <?php echo $p_row['hard_level'] ?>
                            </td>  
                            
                            <?php if($p_row['status'] == 2)
                            {
                                $a = strtotime($p_row['date_created']);
                                $b = strtotime($p_row['date_closed']);
                                $dtF = new DateTime("@$a");
                                $dtT = new DateTime("@$b");

                                echo "<td>".$dtF->diff($dtT)->format('%aD %hH %iM')."</td>";
                                echo "<td>".date('d-M-y', $b)."</td>";
                            }else{
                                echo "<td></td>";
                                echo "<td></td>";
                            }  ?>
                                    
                            <td><center><?php echo $p_row['point_teknisi']; ?></center></td>
                            <td id = "edit_point_<?php echo $p_row['id']?>" ondblclick="ajax_edit(<?php echo $p_row['id']; ?>, <?php echo $point_tambahan; ?>)" >
                                <center><?php echo $point_tambahan; ?>
                                <?php if($p_row['edit_by'])
                                {
                                    echo "<br>";
                                    echo "<span style= 'font-size: 10px;'>";
                                    echo date('d-m-Y H:i:s', strtotime($p_row['edit_date']));
                                    echo "<br>";
                                    echo "Edit By : <b>".$p_row['edit_user']."</b>";
                                    echo "</span>";    
                                } ?></center>
                            </td>
                            <td>
                                <center><?php echo ($p_row['point_teknisi'] + $point_tambahan); ?></center>
                            </td>
                        </tr>
                    <?php } 
                }?>
            </tbody>
            
            <?php }else { ?>
                <tr>
                    <th>Point ID</th>
                    <th>Teknisi</th>
                    <th>Job ID</th>
                    <th>Process Time</th>
                    <th>Finish Date</th>
                    <th>Total Point</th>
                </tr>
                <tr class="filterrow">
                    <th style="width : 20px;"></th>
                    <th class="filterrow">Teknisi</th>
                    <th class="filterrow">Job ID</th>  
                    <th></th>  
                    <th class="filterrow">Finish Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php if($point)
                {
                    foreach ($point as $p_row) 
                    { 
                        if($p_row['point_tambahan']) 
                        {
                            $point_tambahan = $p_row['point_tambahan'];
                        }else {
                            $point_tambahan = '0';
                        } ?>
                        
                        <tr>
                            <td><?php echo $p_row['id']; ?></td>
                            <td><?php echo $p_row['nickname'];  ?> 
                            </td>
                            <td><a target="_blank" href="<?php echo site_url('c_tablesps/update/'.$p_row['sps_id'])?>"><?php echo $p_row['job_id']; ?></a></td> 
                      
                            <?php if($p_row['status'] == 2)
                            {
                                $a = strtotime($p_row['date_created']);
                                $b = strtotime($p_row['date_closed']);
                                $dtF = new DateTime("@$a");
                                $dtT = new DateTime("@$b");

                                echo "<td>".$dtF->diff($dtT)->format('%aD %hH %iM')."</td>";
                                echo "<td>".date('d-M-y', $b)."</td>";
                            }else{
                                echo "<td></td>";
                                echo "<td></td>";
                            }  ?>         
                            <td>
                                <center><?php echo ($p_row['point_teknisi'] + $point_tambahan); ?></center>
                            </td>
                        </tr>
                    <?php } 
                }?>
            </tbody>
            <?php } ?>
        </table>
        </div>

<script type="text/javascript">
$('#example thead tr.filterrow th.filterrow').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input style = "overflow-x : auto; width : 80%;" type="text" onclick="stopPropagation(event);" class="form-control" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable( {
        orderCellsTop: true,
        // "aaSorting": [[0, "desc"]]  
        'iDisplayLength': 100
    } );
     
    // Apply the filter
    $("#example thead input").on( 'keyup change', function () {
        table
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
    } );

    function stopPropagation(evt) {
		if (evt.stopPropagation !== undefined) {
			evt.stopPropagation();
		} else {
			evt.cancelBubble = true;
		}
	}

    function ajax_edit(id, value){
        
        html = '<div class="col-md-3">'+
                '<form method = "post" enctype="multipart/form-data" action="<?php echo site_url('c_point/update')?>/'+id+'/edit_point">'+
                    '<div class="input-group">'+
                        '<input id = "edit_input_'+id+'" type="text" name="points" style="width : 50px; height: 28px;" class="form-control" value="'+value+'">'+
                        '<span class="input-group-btn">'+
                            '<button class="btn btn-info fa fa-save" type="submit" title="Save"></button>'+
                        '</span>' +    
                    '</div>' +
                    '</form>'+
                '</div>';
            
        document.getElementById('edit_point_'+id).innerHTML = html;
    }
        </script>