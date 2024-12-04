function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');
}

// manage-products/////////////////////////////////////////////////////////////////////////////////////////////////////////

// document.addEventListener('DOMContentLoaded', function () {
//     // Initialize an empty array to hold products
//     const products = [];
//     let editIndex = -1; // To track the product being edited

//     // Load products when the page is ready
//     loadProducts();

//     // Function to load products (initial mock data)
//     function loadProducts() {
//         // You can fetch products from an API or database here
//         const mockProducts = [
//             // { sn: 1, image: 'uploads/product1.jpg', title: 'Product 1', price: '100', description: 'Description for Product 1' },
//             // { sn: 2, image: 'uploads/product2.jpg', title: 'Product 2', price: '150', description: 'Description for Product 2' }
//         ];
//         products.push(...mockProducts);
//         renderTable();
//     }

//     // Function to handle form submission
//     function handleSubmit(event) {
//         event.preventDefault(); // Prevent default form submission
//         const title = document.getElementById('title').value;
//         const imageFile = document.getElementById('image').files[0];
//         const price = document.getElementById('price').value;
//         const description = document.getElementById('description').value; // Get description

//         if (editIndex === -1) {
//             // Add new product
//             const newProduct = {
//                 sn: products.length + 1,
//                 image: URL.createObjectURL(imageFile), // Use Object URL for preview
//                 title: title,
//                 price: price,
//                 description: description // Include description
//             };
//             products.push(newProduct);
//         } else {
//             // Edit existing product
//             products[editIndex].title = title;
//             products[editIndex].price = price;
//             products[editIndex].description = description; // Update description
//             // Update image if a new one is selected
//             if (imageFile) {
//                 products[editIndex].image = URL.createObjectURL(imageFile);
//             }
//         }
//         renderTable();
//         closePopup();
//     }

//     // Function to render the product table
//     function renderTable() {
//         const tableBody = document.getElementById('productTableBody');
//         tableBody.innerHTML = ''; // Clear existing rows

//         products.forEach((product, index) => {
//             const row = document.createElement('tr');
//             row.innerHTML = `
//                 <td>${product.sn}</td>
//                 <td><img src="${product.image}" alt="${product.title}" style="width: 50px; height: auto;"></td>
//                 <td>${product.title}</td>
//                 <td>$${product.price}</td>
//                 <td>
//                     <button onclick="editProduct(${index})">Edit</button>
//                     <button onclick="deleteProduct(${index})">Delete</button>
//                 </td>
//             `;
//             tableBody.appendChild(row);
//         });
//     }

//     // Function to edit a product
//     function editProduct(index) {
//         const product = products[index];
//         document.getElementById('popupTitle').innerText = 'Edit Product';
//         document.getElementById('title').value = product.title;
//         document.getElementById('price').value = product.price;
//         document.getElementById('description').value = product.description; // Set description
//         document.getElementById('imagePreview').src = product.image;
//         document.getElementById('imagePreview').style.display = 'block'; // Show image preview
//         editIndex = index; // Set index for editing
//         document.getElementById('productPopup').style.display = 'block'; // Show popup
//     }

//     // Function to delete a product
//     function deleteProduct(index) {
//         products.splice(index, 1); // Remove product from array
//         renderTable(); // Refresh the table
//     }

//     // Function to open the add product popup
//     function openPopup() {
//         document.getElementById('popupTitle').innerText = 'Add New Product';
//         document.getElementById('addProductForm').reset(); // Reset the form
//         document.getElementById('imagePreview').style.display = 'none'; // Hide image preview
//         editIndex = -1; // Reset edit index
//         document.getElementById('productPopup').style.display = 'block'; // Show popup
//     }

//     // Function to close the popup
//     function closePopup() {
//         document.getElementById('productPopup').style.display = 'none'; // Hide popup
//     }

//     // Preview image function
//     function previewImage(event) {
//         const file = event.target.files[0];
//         if (file) {
//             const reader = new FileReader();
//             reader.onload = function (e) {
//                 document.getElementById('imagePreview').src = e.target.result; // Set image source to preview
//                 document.getElementById('imagePreview').style.display = 'block'; // Show image preview
//             }
//             reader.readAsDataURL(file); // Read the image as a data URL
//         }
//     }

//     // Make functions available globally
//     window.openPopup = openPopup;
//     window.closePopup = closePopup;
//     window.handleSubmit = handleSubmit;
//     window.previewImage = previewImage;
//     window.editProduct = editProduct;
//     window.deleteProduct = deleteProduct;
// });

    //add products
    function openAddProductPopup() {
        document.getElementById('product-popup').style.display = 'block';
        document.getElementById('popupTitle').innerText = 'Add New Product';

    }
    function closeAddProductPopup() {
        document.getElementById('product-popup').style.display = 'none';
    }

    function previewImage(evt){
        const imagePreview = document.getElementById('imagePreview');
        const file = evt.target.files[0];
        if(file){
        document.getElementById('id').value = id;
        imagePreview.src = URL.createObjectURL(file); //creates a temprorary url 
            imagePreview.style.display = 'block';
        }
    }

    //delete products
    function confirmDelete(productId){
        var isConfrimed = confirm("Are you sure you want to delete this product?");

        if(isConfrimed){
            window.location.href = "manage-products.php?delete=" + productId;
        }
    }

    //edit products
    function openEditProductPopup(id, title, price, description, image) {
     document.getElementById('product-popup').style.display = 'block';
        document.getElementById('popupTitle').innerText = 'Edit Product';
    
        document.getElementById('add-product').style.display = 'none';
        document.getElementById('edit-product').style.display = 'block';
    
        // Populates form fields with product data
        document.getElementById('editIndex').value = id;
        document.getElementById('title').value = title;
        document.getElementById('price').value = price;
        document.getElementById('description').value = description;
    
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = image;
        imagePreview.style.display = 'block';
    }
    
    function closeAddProductPopup() {
        const popup = document.getElementById('product-popup');
        popup.style.display = 'none';
    
        // Reset form fields
        document.getElementById('productForm').reset();
        document.getElementById('imagePreview').style.display = 'none';
    
        // Reset button visibility
        document.getElementById('add-product').style.display = 'block';
        document.getElementById('edit-product').style.display = 'none';
        document.getElementById('popupTitle').innerText = '';
    }

    //displays an alert msg when editing product is successfull
    document.addEventListener('DOMContentLoaded', () => {
      const formElements = document.querySelectorAll('#productForm input,#productForm textarea');
      const isModifiedField = document.getElementById('isModified');

      formElements.forEach(element => {
        element.addEventListener('input', () => {
            isModifiedField.value = 'true';
        });
      });

      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');

      if(status === 'updated'){
        alert('Product updated successfully!');
      }else if(status ==='no-change'){
        alert('No changes were made to the product.');

      }

      if(status){
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({},document.title,newUrl);
      }
    });
    


// manage users/////////////////////////////////////////////

//edit popup

function openEditPopup(userId, currentRole) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('editRole').value = currentRole;
    document.getElementById('editRolePopup').style.display = 'block';
    document.getElementsByClassName('popup').style.padding = '50px';

}

function closeEditPopup() {
    document.getElementById('editRolePopup').style.display = 'none';

}

//add user popup
function addUserPopup(){
    document.getElementById('addUserPopup').style.display = 'block';
}

function closeAddPopup(){
    document.getElementById('addUserPopup').style.display = 'none';
    window.location.href='manage-users.php';
}





// manage calculator/////////////////////////////////////////////////////////////////////////////////////////////////////////
// script.js
const priceForm = document.getElementById('price-form');
const priceList = document.getElementById('price-list');
const saveRoundOffBtn = document.getElementById('save-round-off');

// Function to handle saving prices
document.querySelector('.save-price').addEventListener('click', () => {
    const color = priceForm.color.value.trim();
    const price = parseFloat(priceForm.price.value);
    if (color && !isNaN(price)) {
        // Add to the price list (or update logic)
        const priceItem = document.createElement('div');
        priceItem.innerHTML = `<strong>${color}:</strong> $${price.toFixed(2)} <button class="edit-price">Edit</button>`;
        priceList.appendChild(priceItem);
        
        // Clear the form
        priceForm.reset();
    }
});

// Function to save round-off values
saveRoundOffBtn.addEventListener('click', () => {
    const roundOffValue = parseFloat(document.getElementById('round-off').value);
    if (!isNaN(roundOffValue)) {
        // Save round-off value logic
        alert(`Round-off value saved: ${roundOffValue}`);
    }
});

// Function to handle editing prices
priceList.addEventListener('click', (event) => {
    if (event.target.classList.contains('edit-price')) {
        const priceItem = event.target.parentElement;
        const [colorPart, pricePart] = priceItem.innerText.split(': $');
        const color = colorPart.replace('strong', '').trim();
        const price = parseFloat(pricePart);

        // Populate the form with existing values for editing
        priceForm.color.value = color;
        priceForm.price.value = price.toFixed(2);
        
        // Optionally remove the item from the list after editing
        priceItem.remove();
    }
});

// Function to round off values
function roundOff(value, roundOffValue) {
    return Math.round(value / roundOffValue) * roundOffValue;
}

//function to prevent from refreshing while navigating 

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const target = this.dataset.target; //gets the php file to upload
        const content = document.getElementById('content');

        if(!content) {
            console.log('id name not found');
            return;
            
        }

         //fetch api to load content dynamically
        fetch(target)
        .then(response => {
            if(!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text(); //gets the content as plain text(html)
        })
        .then(data => {
            content.innerHTML = data; //updates content area
            
        })
        .catch(error => {
            console.log('Error loading the page:',error);
            content.innerHTML = `<p>Failed to load content. Please try again.</p>`;
            
        });
    });
});

   
    
