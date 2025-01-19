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

if(password.length < 8){
    eMsg.style.display='block';
    eMsg.innerHTML="Password must be 8 characters long.";
    return;
}

if(password !== confirmPassword){
    eMsg.style.display='block';
    eMsg.innerHTML="Password doesn't match.";
    return;
    
} else{
    eMsg.style.display='none';
    document.querySelector('form').submit();
}


}

document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', async event => {
        event.preventDefault();
        const form = event.target.closest('form');
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const userConfirmation = confirm("Are you sure ? You want to add this product to the cart!")
                if(userConfirmation){
                    setTimeout(() => {
                        window.location.href = 'cart_details.php';
                    }, 1000);
                } 
            } else {
                console.error('Error:', response.statusText);
                alert('Failed to add product to cart. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        }
    });
});

document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', async (event) => {
        event.preventDefault();
        const form = event.target.closest('form');
        const formData = new FormData(form);
        formData.append('remove_btn', 'true'); 

        const userChoice = confirm("Are you sure? you want to remove this product from the cart!");
       
        if(userChoice){
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });
    
                if (response.ok) {
                        
                        if (userChoice) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                } 
            } catch (error) {
                console.log("Error: ", error);
            }
        } else{
            console.log("Removal cancel by user!");
        }
    });
});

document.querySelectorAll('.place-all-order-btn').forEach(button => {
    button.addEventListener('click', async (event) => {
        event.preventDefault();
        const form = event.target.closest('form');
        const formData = new FormData(form);
        formData.append('place_all_order_btn', 'true'); 

        const userChoice = confirm("Are You Sure? You Want To Place All Order!");
       
        if(userChoice){
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });
    
                if (response.ok) {
                    
                        
                        if (userChoice) {
                            setTimeout(() => {
                                alert("All Order Placed Successfully!");
                                window.location.reload();
                            }, 1000);
                        }
                } 
            } catch (error) {
                console.log("Error: ", error);
            }
        } else{
            console.log("Order cancel by user!");
        }
    });
});


// document.querySelectorAll('.order-btn').forEach(button => {
//     button.addEventListener('click', async (event) => {
//         event.preventDefault();
//         const form = event.target.closest('form');
//         const formData = new FormData(form);
//         formData.append('place_order_btn', 'true'); 

//         const userChoice = confirm("Are You Sure? You Want To Place Order!");
       
//         if(userChoice){
//             try {
//                 const response = await fetch(form.action, {
//                     method: 'POST',
//                     body: formData,
//                 });
    
//                 if (response.ok) {
                    
                        
//                         if (userChoice) {
//                             setTimeout(() => {
//                                 alert("Order Placed Successfully!");
//                                 window.location.reload();
//                             }, 1000);
//                         }
//                 } 
//             } catch (error) {
//                 console.log("Error: ", error);
//             }
//         } else{
//             console.log("Order cancel by user!");
//         }
//     });
// });