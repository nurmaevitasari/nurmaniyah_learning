
<!-- <button id="kirim"><a href="https://eu5.chat-api.com/instance3731/message?token=yoe52c59mtg401ly">KIRIM</a></button> -->

<div id="page-inner">
  <div class="row">
    <div class="col-md-12">
      <h2>WA API</h2>
    </div>
  </div>
  <hr />




<div class="form-group">
  <label class="control-label">Pesan</label>
  <textarea rows="3" id="pesan" name="pesan" class="form-control"></textarea>
</div>
<div class="form-group">
  <label class="control-label">To (Penerima)</label>
  <input type="text" id="tlp" name="tlp" class="form-control" placeholder="(Pastikan nomor diawali dengan '62') ex : 6281399991010">
</div>

<p id="hasil"></p>

<button id="kirim" type="submit" class="btn btn-primary">KIRIM</button>
<br><br><br>
<h3>Terlampir Price List harga untuk subscribe selama bulanan dan tahunan, dari sekian banyak penyedia layanan API, API app.chat-api.com ini termasuk yang termurah</h3>
<h3>Untuk penyedia API waboxapp tidak direkomendasikan, karena secara sistem harus 24 jam terhubung ke whatsap.web perlu terhubung dengan aplikasi browser yang harus disetting dari aplikasi waboxapp, </h3>
<p>Note :<br>
- Saat ini API yang dipasang masih dalam status trial hingga tgl 03.06.2018<br>
- Secara konsep akan penerima dan pesan yang dikirim akan terhubung dengan database<br>
- Modul ini dibuat hanya untuk keperluan berjalan atau tidaknya API yang digunakan<br>
<br><br><br>
<img src="<?php echo base_url('assets/images/Harga.png'); ?>">




<script type="text/javascript">
 	$(function(){
 	$("#kirim").on('click', function(){
         var pesan = $("#pesan").val();
          var tlp = $("#tlp").val();

         
         //do ajax proses
         $.ajax({
           
           url : "https://eu5.chat-api.com/instance3731/message?token=yoe52c59mtg401ly", 
           type: "post", //form method
           dataType : "json",
           data: {
           	phone: tlp,
  			body: pesan,
           },
         
           success:function(result) {
            //alert("Pesan berhasil terkirim");
            alert("Berhasil ! " + result.message);
         
           },
           error: function(xhr, Status, err) {
             
           	console.log(xhr);
           }
           
         });
              
       return false;
     });
 });
 </script>
