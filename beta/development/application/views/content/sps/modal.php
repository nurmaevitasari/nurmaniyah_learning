<div class="modal fade" id="myModalSchedule" role="dialog" method="post">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <form class="form-horizontal" method="post" role="form" id="form">

         <div class="modal-header">
           <h4>Add New Scedule</h4>
         </div>

         <div class="modal-body">
           <div class="form-group error">
                   <input type="text" class="form-control tanggal" id = "tanggal" placeholder=" Pilih Tanggal" val="" name="tanggal" required>
                   <input type="hidden" id="hidden_id" val="" name="idsps" >
               </div>
               <div class="form-group error">
                 <select class="form-control" style="width: 287px;" id="sel_teknisi" name="sel_teknisi" required>
                     <option value="">-- Pilih Teknisi --</option>
                       <!-- <?php if($teknisi)
                       {
                         foreach ($teknisi as $val)
                         { ?>
                             <option value="<?php echo $val['karyawan_id']; ?>"><?php echo $val['nickname']; ?></option>
                         <?php }
                       } ?> -->
                   </select>
                 </div>
         </div>

         <div class="modal-footer">
           <button type="submit" name="submit" id="submit" class="btn btn-info pull-left">Submit </button>
           <a class="btn btn-default" data-dismiss="modal">Close</a>
         </div>
         </form>
     </div>
   </div>
   </div>
