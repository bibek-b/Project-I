<!-- manage-products.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/product.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div id="wrapper">
    <div class="admin-content">
        <h1>Manage Products</h1>
        <button class="add-product" onclick="openPopup()">+</button>
        
        <table class="product-table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <!-- Product rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Popup for adding/editing a new product -->
    <div class="popup" id="productPopup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2 id="popupTitle">Add New Product</h2>
            <form id="addProductForm" onsubmit="handleSubmit(event)">
                <input type="hidden" id="editIndex" value="-1">
                
                <label for="title">Title:</label>
                <input type="text" id="title" required>
                
                <label for="image">Image:</label>
                <input type="file" id="image" accept="image/png, image/jpeg" required onchange="previewImage(event)">
                <img id="imagePreview" alt="Image Preview" style="display:none; width: 100px; height: auto; margin-top: 10px;">
                
                <label for="price">Price:</label>
                <input type="number" id="price" required>

                <label for="description">Description:</label>
                <textarea id="description" required></textarea>

                
                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>


<script src="assets/js/admin-script.js"></script>

</body>
</html>
