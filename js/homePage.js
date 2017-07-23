

if(document.getElementById ("memberArea") != null){
   document.getElementById ("memberArea").addEventListener ("click", accountClick, false);
}

if(document.getElementById ("resetFilter") != null){
   document.getElementById ("resetFilter").addEventListener ("click", resetFilter, false); 
}



function accountClick(){
   $('#memberNavigationCont').slideToggle(200);
}

function sideBarToggle(){
	$('#memberNavigationCont').slideToggle(200);
}

function resetFilter(){
    var type = document.getElementsByName('radioType'); 
    var area = document.getElementsByName('radioArea'); 
    var beds = document.getElementsByName('radioBeds'); 
    type.setAttribute('selected', 'selected');
    area.setAttribute('selected', 'selected');
    beds.setAttribute('selected', 'selected');
    
    var searchBtn = document.getElementById('filterResults').submit();
}

