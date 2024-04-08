<?php 
Defined('witiestudio') or die("No page found."); 
include "config/connection.php";

$id = abs((int)$_GET['f']);
$karyawan_id = $_SESSION['chat']['karyawan_id'];
$qry = mysqli_query($conn,"SELECT * FROM tbl_karyawan WHERE id = '$id' AND id != '$karyawan_id'");
$count = mysqli_num_rows($qry);

if ($count > 0)
{
	$friend = mysqli_fetch_array($qry);

	?>
	<script>
	function sendEmoji(value)
	{
		var message = '<img src="emoji/' + value + '" width="50" />';
		var friend_id = <?php echo $id; ?>;
		
		sendChat(message,friend_id);
		$('#emojiWindow').modal('hide');
	}
	
	$(document).ready(function(e) {		
		
		updateChat("<?php echo $id; ?>","yes");
		setInterval(updateChat,5000,<?php echo $id; ?>,"no");
		
		$("#sendMessage").click(function(){
		
			var message = $("#message").val();
			var friend_id = <?php echo $id; ?>;

			if ($.trim($("#message").val()).length != 0) {
			sendChat(message,friend_id);
			}
			
			$("#message").val("");
		});
		
		
		
		$("#imgFile").change(function() {
			var file = this.files[0];
			var fileType = file["type"];
			var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
				alert("File yang anda pilih bukan image");
				$('#image_upload_preview').attr('src', '');
				$("#uploadButton").hide();
			}
			else
			{
				readURL(this);
				$("#uploadButton").show();
			}
		});
		
		
		$("#uploadimage").on('submit',(function(e) {
			e.preventDefault();
			$("#uploadButton").html("uploading...");
			$.ajax({
				url: "upload_image.php", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$('#uploadWindow').modal('hide');
					$("#imgFile").val("");
					$("#uploadButton").html("Send Image");
					$("#uploadButton").hide();
					$('#image_upload_preview').attr('src', '');
					updateChat("<?php echo $id; ?>","yes");
				}
			});
		}));
		
		
		$("#docFile").change(function() {
			var file = this.files[0];
			var fileType = file["type"];
			var ValidImageTypes = ["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
				alert("File yang anda pilih tidak dapat dikirim");
				$("#uploadFileButton").hide();
			}
			else
			{
				readURL(this);
				$("#uploadFileButton").show();
			}
		});
		
		
		$("#uploadfile").on('submit',(function(e) {
			e.preventDefault();
			$("#uploadFileButton").html("uploading...");
			$.ajax({
				url: "upload_file.php", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$('#fileWindow').modal('hide');
					$("#docFile").val("");
					$("#uploadFileButton").html("Send File");
					$("#uploadFileButton").hide();
					updateChat("<?php echo $id; ?>","yes");
				}
			});
		}));
		
	});
	
	$(document).keyup(function(event) {
		if ($("#message").is(":focus") && event.key == "Enter") {

			var message = $("#message").val();
			var friend_id = <?php echo $id; ?>;

			if ($.trim($("#message").val()).length != 0) {
			sendChat(message,friend_id);
			}
			
			$("#message").val("");

		}
	});
	</script>
    
    <!-- Modal -->
    <div id="uploadWindow" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload Image</h4>
          </div>
          <div class="modal-body">
          	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="friend_id" value="<?php echo $id; ?>" />
			<input type="file" name="imgFile" id="imgFile" />
            <img id="image_upload_preview" width="100%" />
            <br /><br />
            <button class="btn btn-primary" type="submit" id="uploadButton" style="display:none">Send Image</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
    
      </div>
    </div>
    
    <div id="emojiWindow" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Select Emoji</h4>
          </div>
          <div class="modal-body">
          	<form id="setemoji" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="friend_id" value="<?php echo $id; ?>" />

          	<?php
			//Open images directory
			$dir = dir("emoji");
			$kolom = 6;
			$no = 1;
			//List files in images directory
			echo "<div class='row'>";
			while (($file = $dir->read()) !== false)
			{
				if (strlen($file) > 2)
				{
					?>
					<div class="col-xs-2" style="margin-bottom:30px;">
						<div class="img-wrap">
							<img src="emoji/<?php echo $file; ?>" title="<?php echo $file; ?>" width="100%" height="100%" onclick="sendEmoji(this.title)">
						</div>
					</div>
					<?php
					
					if ($no%6 == 0)
					echo "</div>
					<div class='row'>";
					
					$no++;
				}
				
				
				
			}
			echo "</div>";
			$dir->close();
			?> 
            
            
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
    
      </div>
    </div>
    
    <div id="fileWindow" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload File</h4><br/>
          </div>
          <div class="modal-body">
            <small class="text-primary">File yang dapat diupload : Word, Excel, Power Point, dan PDF</small><br />
          	<form id="uploadfile" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="friend_id" value="<?php echo $id; ?>" />
			<input type="file" name="docFile" id="docFile" />
            <br /><br />
            <button class="btn btn-primary" type="submit" id="uploadFileButton" style="display:none">Send File</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
    
      </div>
    </div>
    
    
    <!----END OF MODAL---->
	
	<div class="page-title">
    	<div class="row">
        	<div class="col-xs-10">
				<?php echo $friend['nama']; ?>
			</div>
            <a href="index.php">
                <div class="col-xs-2 text-right">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </div>
			</a>
        </div>
    </div>
    <div class="content">
        <div id="conversationlist" class="conversationlist">
        </div>
	</div>
        
    <div class="writer">
		<div class="input-group">


			<!---
          <span class="input-group-addon" id="basic-addon1" data-toggle="modal" data-target="#uploadWindow"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
          <span class="input-group-addon" id="basic-addon1" data-toggle="modal" data-target="#emojiWindow"><i class="fa fa-smile-o" aria-hidden="true"></i></span>--->
          
          <span class="input-group-addon dropup" style="padding:0;">
            <button class="dropdown-toggle" style="border:none; font-size:20px;" type="button" id="about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-smile-o" aria-hidden="true"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="about-us" style="width:50px;">
            <li><a href="#" data-toggle="modal" data-target="#uploadWindow"><i class="fa fa-file-image-o" aria-hidden="true"></i> Send Image</a></li>
            <li><a href="#" data-toggle="modal" data-target="#emojiWindow"><i class="fa fa-smile-o" aria-hidden="true"></i> Send Emoji</a></li>
            <li><a href="#" data-toggle="modal" data-target="#fileWindow"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Send File</a></li>
            </ul>
          </span>
          
          
          <input type="text" class="form-control input-lg" id="message" placeholder="Write message here...">        
          <span class="input-group-btn">
            <button class="btn btn-primary btn-lg" type="button" id="sendMessage"><span class="glyphicon glyphicon-play"></span></button>
          </span>

        </div>
    </div>	
    
	<?php
}
else
{
	?>
    <div class="alert alert-danger">
 		Page not available
    </div>
	<?php
}
?>