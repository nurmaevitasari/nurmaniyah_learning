<?php 
Defined('witiestudio') or die("No page found."); 
include "config/connection.php";
?>
<script>
	(function($)
	{
		$(document).ready(function()
		{
			$.ajaxSetup(
			{
				cache: false,
				beforeSend: function() {
					$('#content').show();
				},
				complete: function() {
					$('#content').show();
				},
				success: function() {
					$('#content').show();
				}
			});
			var $container = $("#content");
			$container.load("chatlist.php");
			var refreshId = setInterval(function()
			{
				$container.load('chatlist.php');
			}, 5000);
		});
	})(jQuery);
</script>

<div class="page-title">
	Chat List
</div>
<div id="content" class="content">
</div>