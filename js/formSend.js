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
                $('#empty').html('<div class="card border-dark mb-3"><div class="card-header bg-dark text-light"><span class="font-weight-bold">'+result.author+'</span> в '+result.created_at+' ( с IP: '+result.ip+' )</div><div class="card-body"><p class="card-text">'+result.text+'</p></div></div>' + $('#empty').html());
                var length = $('#commentsNum').text().length-1;
                var digits = $('#commentsNum').text().lastIndexOf('#20');
                var counter = Number($('#commentsNum').text().substr(digits)) + 1;
                var newText = $('#commentsNum').text().substr(0, length) + counter;
                $('#commentsNum').html(newText);
    	},
    	error: function(response) {
            $('#sendResult').html('Ошибка. Комментарий не отправлен');
    	}
 	});
}


