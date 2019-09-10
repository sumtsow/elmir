$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendForm('sendResult', 'commentSender', 'save.php');
			return false; 
		}
	);
});
 
function sendForm(sendResult, commentSender, url) {
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: $("#"+commentSender).serialize(),
        success: function(response) {
        	result = $.parseJSON(response);
        	$('#sendResult').html('Комментарий пользователя "'+result.author+'" отправлен');
    	},
    	error: function(response) {
            $('#sendResult').html('Ошибка. Комментарий не отправлен');
    	}
 	});
}


