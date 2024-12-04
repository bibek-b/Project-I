function toggleMenu() {
    const navLinks = document.getElementById("navLinks");
    navLinks.classList.toggle("show");
}

// validation for displaying error msg if confirm password doesnot match with password

function validateSignup(event){ 
event.preventDefault();
const password = document.getElementById('password').value;
const confirmPassword = document.getElementById('confirm_password').value;
let eMsg = document.getElementById('error-msg');


if(password !== confirmPassword){
    eMsg.style.display='block';
    eMsg.innerHTML="Password doesn't match.";
} else{
    eMsg.style.display='none';
    document.querySelector('form').submit();
}

}

// function validateLogin(e){
//     e.preventDefault();
   
//     const email 
//     const lErrmsg = document.getElementById("error-msg");

// }