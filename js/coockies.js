if(document.getElementById('loginForm') !== null){
    //display user name login cookie 
	var txtLogin = document.getElementById('txtLogin');
    txtLogin.value = getCookie('loginCookie');
    //assign event listener to submit button 
    document.getElementById('btnLogin').addEventListener('click', storeLoginCookies, false); 
}

//load search and filter cookies 
if(document.getElementById('searchForm') !== null){

    //assign event listeners to submit buttons 
    document.getElementById('btnSearch').addEventListener('click', storeSearchCookies, false);
    document.getElementById('btnFilterSearch').addEventListener('click', storeFilterCookies, false);
    document.getElementById('resetFilter').addEventListener('click', resetFilter, false);
    
	//Load stored cookies in to search/filter form 
	var txtSearch = document.getElementById('txtSearch'); 
	txtSearch.value = getCookie('searchCookie');
	
	var type = document.getElementsByName('radioType'); 
	var typeCookie = getCookie('filterTypeCookie');
	for(var i = 0; i < type.length; i++){
		if(type[i].value === typeCookie){
			type[i].checked = true;
		}
	}

	var area = document.getElementsByName('radioArea'); 
	var areaCookie = getCookie('filterAreaCookie');
	for(var i = 0; i < area.length; i++){
		if(area[i].value === areaCookie){
			area[i].checked = true;
		}
	}

	var beds = document.getElementsByName('radioBeds'); 
	var bedsCookie = getCookie('filterBedsCookie');
	for(var i = 0; i < beds.length; i++){
		if(beds[i].value === bedsCookie){
			beds[i].checked = true;
		}
	}
}

function resetFilter(){
    document.getElementsByName('radioType')[0].checked = true;
    document.getElementsByName('radioArea')[0].checked = true;
    document.getElementsByName('radioBeds')[0].checked = true;
    storeFilterCookies();
}

function storeSearchCookies(){
    var txtSearch = document.getElementById('txtSearch').value;
	setCookie('searchCookie', txtSearch); 

}
	
function storeLoginCookies(){
	var txtLogin = document.getElementById('txtLogin').value;
	setCookie('loginCookie', txtLogin); 
}

function storeFilterCookies(){
    var type = document.querySelector('input[name = "radioType"]:checked').value;
    var area = document.querySelector('input[name = "radioArea"]:checked').value;
    var beds = document.querySelector('input[name = "radioBeds"]:checked').value;
    
	setCookie('filterTypeCookie', type); 
	setCookie('filterAreaCookie', area); 
	setCookie('filterBedsCookie', beds); 
}
	

//The functions below have been adapted from w3schools 
//http://www.w3schools.com/js/js_cookies.asp
function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (7*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}