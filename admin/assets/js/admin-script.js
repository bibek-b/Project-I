function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');
}

// manage-products/////////////////////////////////////////////////////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    // Initialize an empty array to hold products
    const products = [];
    let editIndex = -1; // To track the product being edited

    // Load products when the page is ready
    loadProducts();

    // Function to load products (initial mock data)
    function loadProducts() {
        // You can fetch products from an API or database here
        const mockProducts = [
            // { sn: 1, image: 'uploads/product1.jpg', title: 'Product 1', price: '100', description: 'Description for Product 1' },
            // { sn: 2, image: 'uploads/product2.jpg', title: 'Product 2', price: '150', description: 'Description for Product 2' }
        ];
        products.push(...mockProducts);
        renderTable();
    }

    // Function to handle form submission
    function handleSubmit(event) {
        event.preventDefault(); // Prevent default form submission
        const title = document.getElementById('title').value;
        const imageFile = document.getElementById('image').files[0];
        const price = document.getElementById('price').value;
        const description = document.getElementById('description').value; // Get description

        if (editIndex === -1) {
            // Add new product
            const newProduct = {
                sn: products.length + 1,
                image: URL.createObjectURL(imageFile), // Use Object URL for preview
                title: title,
                price: price,
                description: description // Include description
            };
            products.push(newProduct);
        } else {
            // Edit existing product
            products[editIndex].title = title;
            products[editIndex].price = price;
            products[editIndex].description = description; // Update description
            // Update image if a new one is selected
            if (imageFile) {
                products[editIndex].image = URL.createObjectURL(imageFile);
            }
        }
        renderTable();
        closePopup();
    }

    // Function to render the product table
    function renderTable() {
        const tableBody = document.getElementById('productTableBody');
        tableBody.innerHTML = ''; // Clear existing rows

        products.forEach((product, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.sn}</td>
                <td><img src="${product.image}" alt="${product.title}" style="width: 50px; height: auto;"></td>
                <td>${product.title}</td>
                <td>$${product.price}</td>
                <td>
                    <button onclick="editProduct(${index})">Edit</button>
                    <button onclick="deleteProduct(${index})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Function to edit a product
    function editProduct(index) {
        const product = products[index];
        document.getElementById('popupTitle').innerText = 'Edit Product';
        document.getElementById('title').value = product.title;
        document.getElementById('price').value = product.price;
        document.getElementById('description').value = product.description; // Set description
        document.getElementById('imagePreview').src = product.image;
        document.getElementById('imagePreview').style.display = 'block'; // Show image preview
        editIndex = index; // Set index for editing
        document.getElementById('productPopup').style.display = 'block'; // Show popup
    }

    // Function to delete a product
    function deleteProduct(index) {
        products.splice(index, 1); // Remove product from array
        renderTable(); // Refresh the table
    }

    // Function to open the add product popup
    function openPopup() {
        document.getElementById('popupTitle').innerText = 'Add New Product';
        document.getElementById('addProductForm').reset(); // Reset the form
        document.getElementById('imagePreview').style.display = 'none'; // Hide image preview
        editIndex = -1; // Reset edit index
        document.getElementById('productPopup').style.display = 'block'; // Show popup
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('productPopup').style.display = 'none'; // Hide popup
    }

    // Preview image function
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result; // Set image source to preview
                document.getElementById('imagePreview').style.display = 'block'; // Show image preview
            }
            reader.readAsDataURL(file); // Read the image as a data URL
        }
    }

    // Make functions available globally
    window.openPopup = openPopup;
    window.closePopup = closePopup;
    window.handleSubmit = handleSubmit;
    window.previewImage = previewImage;
    window.editProduct = editProduct;
    window.deleteProduct = deleteProduct;
});





// mnage useres///////////////////////////////////////////////////////////////////////////////////////////////////////////////


document.addEventListener('DOMContentLoaded', function () {
    // Fetch users and render them in the table
    loadUsers();
});

// Store user data (you would typically fetch this from a database)
let users = [
    { sn: 1, username: 'Chandan Chauhdary', email: 'chaudhary10cn@gmail.com', role: 'Admin' },
    { sn: 2, username: 'user2', email: 'user2@example.com', role: 'User' }
];

// Load users when the document is ready
document.addEventListener('DOMContentLoaded', function () {
    loadUsers();
});

// Function to load users into the table
function loadUsers() {
    const tableBody = document.getElementById('userTableBody');
    tableBody.innerHTML = ''; // Clear existing rows

    users.forEach((user) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.sn}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td>
                <button onclick="openEditPopup(${user.sn})">Edit</button>
                <button onclick="deleteUser(${user.sn})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Function to open the add user popup
function openPopup() {
    document.getElementById('userPopup').style.display = 'block';
    document.getElementById('addUserForm').reset(); // Reset the form for adding new user
    document.getElementById('userId').value = ''; // Clear the hidden ID for new user
}

// Function to open the edit user popup
function openEditPopup(sn) {
    const user = users.find(u => u.sn === sn);
    if (user) {
        document.getElementById('username').value = user.username;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        document.getElementById('userId').value = user.sn; // Set the ID of the user being edited
        document.getElementById('userPopup').style.display = 'block';
    }
}

// Function to delete a user
function deleteUser(sn) {
    users = users.filter(user => user.sn !== sn);
    loadUsers();
}

// Function to close the popup
function closePopup() {
    document.getElementById('userPopup').style.display = 'none';
}

// Function to add or edit a user
document.getElementById('addUserForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;

    const userId = document.getElementById('userId').value; // Get the ID from the hidden input

    if (userId) {
        // Update existing user
        const userIndex = users.findIndex(user => user.sn === parseInt(userId));
        users[userIndex] = { sn: parseInt(userId), username, email, role };
    } else {
        // Add new user
        const newSn = users.length ? users[users.length - 1].sn + 1 : 1;
        users.push({ sn: newSn, username, email, role });
    }

    closePopup();
    loadUsers();
});





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
