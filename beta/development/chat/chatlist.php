<?php
session_start();
include "config/connection.php";
include "config/function.php";

if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password'])))
{
	$karyawan_id = $_SESSION['chat']['karyawan_id'];
		
	$qry_chat = mysqli_query($conn,"SELECT a.*, b.nama AS nama_user_1, c.nama AS nama_user_2 
	FROM chat a 
	JOIN tbl_karyawan b ON b.id = a.user_1
	JOIN tbl_karyawan c ON c.id = a.user_2
	WHERE a.user_1 = '$karyawan_id' OR a.user_2 = '$karyawan_id' 
	GROUP BY a.id
	ORDER BY a.last_update DESC");
	while ($list = mysqli_fetch_array($qry_chat))
	{
		if ($list['user_1'] == $karyawan_id)
		{
			$friend_id = $list['user_2'];
			$friend_name = $list['nama_user_2'];
		}
		elseif ($list['user_2'] == $karyawan_id)
		{
			$friend_id = $list['user_1'];
			$friend_name = $list['nama_user_1'];
		}
		
		$last_update_date = substr($list['last_update'],0,10);
		if ($last_update_date == date("Y-m-d"))
		$last_update = substr($list['last_update'],10,6);
		else
		$last_update = tgl_short($list['last_update']);
		?>
        
        <a href="?menu=chat&f=<?php echo $friend_id; ?>">
            <div class="chatlist">
                <div class="row">
                    <div class="text-center col-xs-2 col-sm-1 col-md-1">
                        <img src="img/user.png" class="img-responsive" />
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <b><?php echo $friend_name; ?></b><br/>
                        <span class="excerpt">
                        	<?php if ($list['last_sender']==$karyawan_id) { 
							if ($list['total_unread'] > 0) { ?><img src="img/unread.png"/> <?php } else { ?><img src="img/read.png"/> <?php }} ?>
							<?php echo $list['last_message_excerpt']; ?>
                    	</span>
                    </div>
                    <div class="col-xs-2 text-right">
                        <small class="text-primary"><?php echo $last_update; ?></small><br />
                        <?php if (($list['last_sender']!=$karyawan_id) AND ($list['total_unread'] > 0)) { ?><span class='label label-danger'><?php echo $list['total_unread']; ?></span> <?php } ?>
                    </div>
                </div>
            </div>
		</a>
		<?php
	}
}
?>	
<!---	
<audio id="myAudio" controls autoplay style="display:none;">
  <source src="sound/to-the-point.ogg" type="audio/ogg">
  <source src="sound/to-the-point.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>	

<script>
function myFunction() {
    var x = document.getElementById("myAudio").autoplay;
    document.getElementById("demo").innerHTML = x;
}
</script>
-->