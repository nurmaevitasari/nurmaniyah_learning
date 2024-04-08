<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="">
    <meta name="author" content="FaberNainggolan">
    <title><?=$titel?></title>
 
    <!-- Custom styles 
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    for this template -->

    <link href="<?=base_url()?>asset/css/jquery-ui.1.10.4.custom.css" rel="stylesheet">

    <!-- jquery -->

    <script src="<?=base_url()?>asset/js/jquery-1.12.1.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>asset/js/jquery-ui-1.10.4.custom.js" type="text/javascript"></script>
    <script src="<?=base_url()?>asset/js/ajax.js" type="text/javascript"></script>
   
    <script>


      //auto complete depan
         var site = "<?php echo site_url();?>"; 
         var   base_url = '<?=base_url()?>';
     $(function () {




        $("#kode").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
            minLength:0,
            delay:0,
            source:'<?php echo site_url('kota/get_allkota'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
            select:function(event, ui){
                $('#nama').val(ui.item.nama);
                $('#ibukota').val(ui.item.ibukota);
                $('#ket').val(ui.item.keterangan);
                }
            });


/*

        $("#brand").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
            minLength:0,
            delay:0,
            source:'<?php echo site_url('welcome/caribrand'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
            select:function(event, ui){
                $('#brand').val(ui.item.nama);
                $('#id_brand').val(ui.item.id_brand);
             
                }
            });




        $("#tipe").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
            minLength:0,
            delay:0,
            source:'<?php echo site_url('welcome/caritipe'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
            select:function(event, ui){
                $('#tipe').val(ui.item.name_tipe);
                $('#id_tipe').val(ui.item.id_tipe);
                }
            });

*/
        });
    </script>
  </head>
<body>
<header>
 <h1><?=$titel?> </h1>
</header>
<div class="container">
<p> <input type="text" id="kode" placeholder="Ketikan nama kota" > </p>
<p>
 Nama Kota : </br><input type="text" id="nama"></br>
 Ibu Kota : </br><input type="text" id="ibukota"></br>
 Keterangan :</br> <textarea id="ket"></textarea>
 </p>

 <br>
 <br>
nama brand: </br><input type="text" id="brand"></br>
 id brand : </br><input type="text" id="id_brand"></br>
 <br>
 <br>
nama tipe: </br><input type="text" id="tipe"></br>
 id tipe : </br><input type="text" id="id_tipe"></br>

</div>
<footer>
 by Faber Nainggolan
</footer>
</body>
</html>
