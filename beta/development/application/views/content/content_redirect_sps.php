<div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>SPS Details </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
	
<div class="container">
 <dl class="dl-horizontal">
  <dt>No. SPS</dt>
  <dd><?= !empty($detail['no_sps']) ? $detail['no_sps'] : ''; ?></dd>
  <dt>Tanggal</dt>
  <dd><?= !empty($detail['date_open']) ? $detail['date_open'] : ''; ?></dd>
  <dt>Customer</dt>
  <dd><?= !empty($detail['nama']) ? $detail['nama'] : ''; ?></dd>
  <dt>Tipe Produk</dt>
  <dd><?= !empty($detail['product']) ? $detail['product'] : ''; ?></dd>
  <dt>Area Servis</dt>
  <dd><?= !empty($detail['areaservis']) ? $detail['areaservis'] : ''; ?></dd>
  <dt>Frekuensi</dt>
  <dd><?= !empty($detail['frekuensi']) ? $detail['frekuensi'] : ''; ?></dd>
  <dt>Complaint</dt>  
  <dd><?= !empty($detail['sps_notes']) ? $detail['sps_notes'] : ''; ?></dd>
</dl> 
</div>

  
  <div class="table-responsive" style="font-size: 12px;">
    <table class="table table-hover">
      <thead>
         <tr>
          <th>No.</th>
          <th>Date</th>
          <th>Time Log</th>
          <th>Action</th>
          <th>Operator</th>
          <th>Respon Start</th>
          <th>Time Cost</th>
          <th>Over to</th>
          <th>Message</th>
        </tr> 
        
      </thead>
       <tbody>
      <?php
        if($detail_table)
        {
          $x = 1;
          foreach($detail_table as $key => $row)
        {
      ?>
      <?php if($x == 1){ ?>
      <tr>
        <td><?php echo $x; ?>
        <td><?php echo $row['log_date']; ?></td>
        <td><?php echo $row['log_time']; ?></td>
        <td></td>
        <td><?php echo $row['nama']; ?></td>
        <td>0 days 0 hours 0 minutes 0 seconds</td>
        <td>0 days 0 hours 0 minutes 0 seconds</td> 
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['log_notes']; ?></td>
      </tr>
      <?php }else{ ?>
        <?php $start = date('Y/m/d H:i:s', strtotime($detail_table[$key-1]['date_create'])); ?>
        <?php $date = datediff($start, date('Y/m/d H:i:s')); ?>
        <tr>
          <td><?php echo $x; ?>
          <td><?php echo $row['log_date']; ?></td>
          <td><?php echo $row['log_time']; ?></td>
          <td></td>
          <td><?php echo $row['nama']; ?></td>
          <td><?php echo $date['days']; ?> days <?php echo $date['hours']; ?> hours <?php echo $date['minutes']; ?> minutes <?php echo $date['seconds']; ?> seconds</td>
          <td>0 days 0 hours 0 minutes 0 seconds</td> 
          <td><?php echo $row['username']; ?></td>
          <td><?php echo $row['log_notes']; ?></td>
        </tr>
      <?php } ?>

      <?php
        $x++;
        }
        }
      ?>
      </tbody> 
    </table>
    </div> 

</div>