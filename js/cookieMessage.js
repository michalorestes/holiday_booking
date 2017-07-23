if(getCookie('acceptCookie') === 'true'){
    acceptCookies();
}

if(document.getElementById ("cookiesAccept") != null){
   document.getElementById ("cookiesAccept").addEventListener ("click", acceptCookies, false); 
}

function acceptCookies(){
    $('#coockieContainer').hide();
    setCookie('acceptCookie', 'true', 100000000000000, '/');
}