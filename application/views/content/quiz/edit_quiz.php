<?php $user = $this->session->userdata('myuser'); ?>



<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">


<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            <h2>Update Quiz</h2>

          </div>
        </div>
        <hr />

        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('quiz/save_quiz');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
        <?php echo $this->session->flashdata('message'); ?>



        <div class="col-sm-12">

            <?php 
            if($soal)
            {
            foreach ($soal as $key => $value) 
            {?>

            <div class="form-group file-row-soal" id="file-row-soal-1">

                <div class="form-group row">
                    <label class="control-label col-sm-2">Soal</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"  name="soal[]" value="<?php echo $value['soal'];?>">
                        </div>
                        <div class="col-sm-2">

                            <button type="button" class="btn btn-primary btn-add-file-soal btn-md" data-id="1">+</button>
                            <?php 

                            if($key !='0')
                            {?>
                                <button type="button" class="btn btn-danger btn-remove-file-soal" data-id="1">-</button>
                            <?php }?>
                        </div>
                </div> 

                <div class="form-group row">
                    <label class="control-label col-sm-2">Jawaban</label>
                       
                    <div class="col-sm-2">
                            <b>A.</b> <input type="text" class="form-control"  name="jawaban_a[]" >
                            <input type="checkbox" name="jawab[]" value="A">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>B.</b> <input type="text" class="form-control"  name="jawaban_b[]" >
                            <input type="checkbox"  name="jawab[]" value="B">Jadikan Jawaban
                            <br>

                    </div>

                    <div class="col-sm-2">
                            <b>C.</b> <input type="text" class="form-control"  name="jawaban_c[]" >
                            <input type="checkbox"  name="jawab[]" value="C">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>D.</b> <input type="text" class="form-control"  name="jawaban_d[]" >
                             <input type="checkbox"  name="jawab[]" value="D">Jadikan Jawaban
                            <br>

                    </div>

                </div> 
            </div>

            <?php } }?>


        </div>



        </form>
</div>
