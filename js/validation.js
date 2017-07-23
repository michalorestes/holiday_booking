var date;
//Add event listeners to each text box 
if(document.getElementById('addProperty') != null){
    document.getElementById ("txt_rent").addEventListener ("blur", validateRent, false);
    document.getElementById ("txt_Day").addEventListener ("blur", validateDay, false);
    document.getElementById ("txt_Month").addEventListener ("blur", validateMonth, false);
    document.getElementById ("txt_Year").addEventListener ("blur", validateYear, false);
    document.getElementById ("txt_addr").addEventListener ("blur", validateAddress, false);
    document.getElementById ("txt_postCode").addEventListener ("blur", validatePostCode, false);
    document.getElementById ("txt_title").addEventListener ("blur", validateTitle, false);
    document.getElementById ("txt_description").addEventListener ("blur", validateDescription, false);
    date = new Date();
}
//Validate the entire form
function validateForm(){
    var rent = validateRent(); 
    var day = validateDay(); 
    var month = validateMonth();
    var year = validateYear(); 
    var address = validateAddress(); 
    var postcode = validatePostCode(); 
    var title = validateTitle(); 
    var description = validateDescription(); 
    
    if(rent && day && month && year && address && postcode && title && description){
        return true;
    } else {
        return false;
    }
}
function validateRent(){
    var val = document.getElementById('txt_rent').value; 
    var errors = ''; 
    if(val === ''){
        errors = errors + ' Required';
    }
    
    if(!isNaN(parseInt(val))){
        if(parseInt(val) < 0){
        errors = errors + ' Needs to be positive value';
        }
    } else {
        errors = errors + ' only numbers accepted';
    }
    var output = document.getElementsByClassName('required');
    output[0].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}
function validateDay(){
    var val = document.getElementById('txt_Day').value; 
    var errors = ''; 
    if(val === ''){
        errors = errors + ' Required';
    }
    if(!isNaN(parseInt(val))){
        val = parseInt(val);
        if(val < 0){
            errors = errors + ' Needs to be positive value,';
        }
        
        if(val > 31 || val < 1){
            errors = errors + ' Needs to be day of the month,';
        }
        
    } else {
        errors = errors + ' only numbers accepted,';
    }
    
    var output = document.getElementsByClassName('required');
    output[1].innerHTML = errors;
    
    if(errors === ''){
        return  true;
    } else {
        return false; 
    }
}

function validateMonth(){
    var val = document.getElementById('txt_Month').value; 
    var errors = ''; 
    if(val === ''){
        errors = errors + ' Required';
    }
    
    if(!isNaN(parseInt(val))){
        val = parseInt(val);
        if(val < 0){
            errors = errors + ' Needs to be positive value';
        }
        
        if(val > 12 || val < 1){
            errors = errors + ' Needs to be month of the year';
        }
    } else {
        errors = errors + ' only numbers accepted';
    }
    
    var output = document.getElementsByClassName('required');
    output[1].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}

function validateYear(){
    var val = document.getElementById('txt_Year').value; 
    var errors = ''; 
    if(val === ''){
        errors = errors + ' Required,';
    }
    
    if(!isNaN(parseInt(val))){
        val = parseInt(val);
        if(val < 0){
            errors = errors + ' Needs to be positive value,';
        }
        
        if(val < date.getFullYear()){
            errors = errors + ' Date needs to be in the future,';
        }
        
        if(val > 9999){
            errors = errors + ' Only 4 digit year is allowed,';
        }       
    } else {
        errors = errors + ' only numbers accepted,';
    }
    
    var output = document.getElementsByClassName('required');
    output[1].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}

function validateAddress(){
    var val = document.getElementById('txt_addr').value; 
    var errors = ''; 
    
    if(val === ''){
        errors = errors + ' Required,';
    }
    
    if(val.length < 3){
        errors = errors + ' Enter correct address,';
    }
    
    if(!/[a-zA-Z0-9]/.test(val)){
        errors = errors + ' invalid character,';
    }
    
    var output = document.getElementsByClassName('required');
    output[2].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}

function validatePostCode(){
    var val = document.getElementById('txt_postCode').value; 
    var errors = ''; 
    
    if(val === ''){
        errors = errors + ' Required,';
    }
    
    if(val.length < 4 || val.length > 8){
        errors = errors + ' Enter correct post code,';
    }
    
    if(!/[a-zA-Z0-9]/.test(val)){
        errors = errors + ' invalid character,';
    }
    
    var output = document.getElementsByClassName('required');
    output[3].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}

function validateTitle(){
    var val = document.getElementById('txt_title').value; 
    var errors = ''; 
    
    if(val === ''){
        errors = errors + ' Required,';
    }
    
    if(val.length < 4){
        errors = errors + 'too short,';
    }
    
    if(val.length > 50){
        errors = errors + 'too long,';
    }
    
    if(/[`~<>;':"\/\[\]\|{}()=_+-]/.test(val)){
        errors = errors + ' invalid character,';
    }
    
    var output = document.getElementsByClassName('required');
    output[4].innerHTML = errors;
    
    if(errors === ''){
        return true;
    } else {
        return false; 
    }
}

function validateDescription(){
    var val = document.getElementById('txt_description').value; 
    var errors = ''; 
    
    if(val === ''){
        errors = errors + ' Required,';
    }
    
    if(val.length < 50){
        errors = errors + 'too short,';
    }
    
    if(val.length > 1000){
        errors = errors + 'too long,';
    }
    
    if(/[`~<>;':"\/\[\]\|{}()=_+-]/.test(val)){
        errors = errors + ' invalid character,';
    }
    
    var output = document.getElementsByClassName('required');
    output[5].innerHTML = errors;
    
    if(errors ===    ''){
        return true;
    } else {
        return false; 
    }
}