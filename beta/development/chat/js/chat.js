	function updateChat(friend_id,firstload) {

		var displayList = $('#conversationlist');			
		var chatOutput = "";

		$.ajax({
			type: 'GET',
			dataType: "json",
			data: "friend_id=" + friend_id,								
			url: 'getchatdetail.php',
			success: function(result)
			{
				console.log(result);
								
				var ListStatus = result.ListStatus;
				var ListStatusMessage = result.ListStatusMessage;
							
				if (ListStatus == '0')
				{	
					var chatOutput = "";

					for (var i in result.Listconversation)
					{
						if (result.Listconversation[i].sender == friend_id)
						{
							chatOutput += '<div class="msg-wrapper"><div class="sender-msg">' + result.Listconversation[i].message + '<br/><span class="send-date">' + result.Listconversation[i].message_time + '</span></div></div>';
						}
						else
						{
							chatOutput += '<div class="msg-wrapper" style="text-align:right"><div class="my-msg">' + result.Listconversation[i].message + '<br/>';
							
							if (result.Listconversation[i].read_status == 'read')
							chatOutput += '<img src="img/read.png"/>';
							else
							chatOutput += '<img src="img/unread.png"/>';
							
							chatOutput += '<span class="send-date">' + result.Listconversation[i].message_time + '</span></div></div>';
						}
					}					
					
					displayList.html(chatOutput);	
					
					if (firstload == 'yes')
					window.scroll(0, document.body.scrollHeight + 1000000);
					
					
				}
				else
				{
					//displayList.html(ListStatusMessage);
				}				
			},
			timeout: 5000, //5 second timeout
			error: function(jqXHR, textStatus, errorThrown) {
				if(textStatus==="timeout") {
					//displayList.html('<div class="alert alert-danger">Tidak dapat tersambung ke server!</div>');
				} 
				else
				{
					//displayList.html('<div class="alert alert-danger">Tidak dapat tersambung ke server!</div>');
				}
			}
		});
	}
	
	function sendChat(message,friend_id) {

		$.ajax({
			type: 'POST',
			data: "friend_id=" + friend_id + "&message=" + message,
			url: 'sendchat.php',
			success: function(data){
				updateChat(friend_id,"yes");
			},
			timeout: 15000, //5 second timeout
			error: function(jqXHR, textStatus, errorThrown) {
				if(textStatus==="timeout") {
					$("#errorMsg").html("Cannot reach server");
				} 
				else
				{
					$("#errorMsg").html(textStatus);
				}
			}
		});
	}
	
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
	
			reader.onload = function (e) {
				$('#image_upload_preview').attr('src', e.target.result);
			}
	
			reader.readAsDataURL(input.files[0]);
		}
	}