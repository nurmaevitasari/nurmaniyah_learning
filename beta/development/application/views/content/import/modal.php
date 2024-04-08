<!-- ############# MODAL NOTES #################################### -->
<div class="modal fade" id="mymodalNotes" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Notes</h3>
      </div>
      <div class="modal-body form">
          <form action = "#" id="form_notes" class="form-horizontal" method = "POST">
              <textarea rows="4" name="notes" class="form-control tx-notes"></textarea>
              <input type="hidden" name="import_id">

      </div>
      <div class="modal-footer">
          <button type="submit" id="btnSave" class="btn btn-primary notes-save">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      </form>
  </div>
</div>
</div>

<script type="text/javascript">





// function updateClock() {
// $('.date_start_time').each(function() {
// var startDateTime = new Date( $(this).attr('value') );
// startStamp = startDateTime.getTime();
// newDate = new Date();
// newStamp = newDate.getTime();
// var diff = Math.round((newStamp - startStamp) / 1000);
//
// var d = Math.floor(diff / (24 * 60 * 60));
// /* though I hope she won't be working for consecutive days :) */
// diff = diff - (d * 24 * 60 * 60);
// var h = Math.floor(diff / (60 * 60));
// diff = diff - (h * 60 * 60);
// var m = Math.floor(diff / (60));
// diff = diff - (m * 60);
// var s = diff;
//
// $(this).parent().find("td.time-elapsed").html(d + "d " + h + "h " + m + "m " + s + "s ");
// });
// }
//
// setInterval(updateClock, 1000);

</script>
