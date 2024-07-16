let checkpassword = document.getElementById('checkpassword');
let password = document.getElementById('password');
let repeatpassword = document.getElementById('repeatpassword');

checkpassword.onclick = function(){
    if(checkpassword.checked){
        password.setAttribute('type', 'text');

        if(repeatpassword){
            repeatpassword.setAttribute('type', 'text');
        }
    }
    else{
        password.setAttribute('type', 'password');

        if(repeatpassword){
            repeatpassword.setAttribute('type', 'password');
        }
    }
}