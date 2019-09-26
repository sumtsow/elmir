function sendForm() {
    let request = new XMLHttpRequest();
    request.onload = commentRequest;
    request.open('POST', 'save.php');
    request.send(new FormData(document.querySelector('#commentSender')));
}

function commentRequest () {
    if(this.status !== 200) {
        document.querySelector('#sendResult').innerHTML = 'Ошибка. Комментарий не отправлен. - ' + this.status + ': ' + this.statusText;
        document.querySelector('#sendResult').setAttribute('class', 'alert alert-danger');     
    }
    else {
        jsonObj = JSON.parse(this.responseText);
        
        if(typeof jsonObj.errorInfo === "undefined") {
            document.querySelector('#sendResult').innerHTML = 'Комментарий пользователя "'+jsonObj.author+'" отправлен';
            document.querySelector('#sendResult').setAttribute('class', 'alert alert-success');
            document.querySelector('#empty').innerHTML = '<div class="card border-dark mb-3"><div class="card-header bg-dark text-light"><span class="font-weight-bold">'+jsonObj.author+'</span> в '+jsonObj.created_at+' ( с IP: '+jsonObj.ip+' )</div><div class="card-body"><p class="card-text">'+jsonObj.text+'</p></div></div>' + document.querySelector('#empty').innerHTML;
            let length = document.querySelector('#commentsNum').innerHTML.length-1;
            let digits = document.querySelector('#commentsNum').innerHTML.lastIndexOf('#20');
            let counter = Number(document.querySelector('#commentsNum').innerHTML.substr(digits)) + 1;
            document.querySelector('#commentsNum').innerHTML = document.querySelector('#commentsNum').innerHTML.substr(0, length) + counter;
        }
        else {
            document.querySelector('#sendResult').innerHTML = jsonObj.errorInfo;            
            document.querySelector('#sendResult').setAttribute('class', 'alert alert-danger');
        }
    }
}
