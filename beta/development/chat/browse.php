<?php 
Defined('witiestudio') or die("No page found."); 
include "config/connection.php";

$karyawan_id = $_SESSION['chat']['karyawan_id'];
?>
<script>
function searchPeople() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myFriend");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>

	<div class="page-title">
    	<div class="row">
        	<div class="col-xs-10">
				Browse People
			</div>
            <a href="index.php">
                <div class="col-xs-2 text-right">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </div>
			</a>
        </div>
    </div>

	<div class="content">
        <input type="text" class="form-control input-lg" id="searchInput" onkeyup="searchPeople()" placeholder="Search for names..">
    
        <ul id="myFriend">
          <?php
		  $qry = mysqli_query($conn,"SELECT a.*, b.position FROM tbl_karyawan a 
		  JOIN tbl_position b ON b.id = a.position_id 
		  WHERE a.published = '1' AND a.id != '$karyawan_id'
		  ORDER BY a.nama");
		  while ($list = mysqli_fetch_array($qry))
		  {
		  ?>
          <li>
          	<a href="?menu=chat&f=<?php echo $list['id']; ?>">
		  		<b><?php echo $list['nama']; ?></b><br />
                <?php echo $list['position']; ?>
            </a>
          </li>
          <?php
		  }
		  ?>
        </ul> 	
    </div>