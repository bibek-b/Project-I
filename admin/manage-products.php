<!-- manage-products.php -->
<?php
$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}


//handles add products

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_product'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    //handles the image upload
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    $imageName  = $_FILES['image']['name'];
    $imageTmpName  = $_FILES['image']['tmp_name'];
    $imageFolder = 'uploads/' . $imageName;

    if (move_uploaded_file($imageTmpName, $imageFolder)) {
        $sql = "insert into products (title,image,price,description) values('$title','$imageName','$price','$description')";
        if (mysqli_query($conn, $sql)) {
            
            echo "<script>
            alert('Product added successfully!');
            window.location.href = 'manage-products.php';
            </script>";
        } else {
            echo "<script>alert('Error adding product');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload an image');</script>";
    }
}

//handles deleting a product
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];

    $sql = "delete from products where id = '$productId'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>confirm('Are you sure? you want to delete this product!');</script>";

        header("Location: manage-products.php?status=deleted");
        exit();
    } else {
        echo "<script>alert('Error deleting product');</script>";
    }
}

//handles editing a product
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_product'])) {

    $isModified = $_POST['isModified'];

    if ($isModified === 'false') {
        header("Location: manage-products.php?status=no-change");
        exit();
    }

    $id = intval($_POST['product_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imageName = $_FILES['image']['name'];

    if (!empty($imageName)) { // Update image if new one is uploaded
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'uploads/' . $imageName;

        if (move_uploaded_file($imageTmpName, $imageFolder)) {
            $sql = "UPDATE products SET title='$title', price='$price', description='$description', image='$imageName' WHERE id=$id";
        } else {
            echo "<script>alert('Failed to upload image');</script>";
        }
    } else { // Retain the old image
        $sql = "UPDATE products SET title='$title', price='$price', description='$description' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: manage-products.php?status=updated");
        exit();
    } else {
        echo "<script>alert('Error updating product');</script>";
    }
}
?>
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
            <button class="add-product" onclick="openAddProductPopup()">+</button>

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
                    <?php
                    $sql = 'select * from products';
                    $result = mysqli_query($conn, $sql);
                    $sn = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                        <td>{$sn}</td>
                        <td><img src = 'uploads/{$row['image']}' alt='{$row['title']}' width='50'></td>
                        <td>{$row['title']}</td>
                        <td>{$row['price']}</td>
                        <td>
                            &nbsp;<button  onclick=\"openEditProductPopup(
                            {$row["id"]}, 
                            '{$row["title"]}', 
                            '{$row["price"]}', 
                            '{$row["description"]}', 
                            'uploads/{$row["image"]}',  
                            );\">&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;
                            </button>&nbsp;&nbsp;&nbsp;
                            <a  href ='javascript:void(0);' onclick='confirmDelete({$row['id']});'>
                            <button style= '
                                background-color: #e44336;
                                color: white; 
                                border: none;
                                padding: 10px 15px;
                                cursor: pointer;
                                border-radius: 5px;'>Delete</button>
                            </a>
                        </td>
                        </tr>";
                            $sn++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found</td></tr>";
                    }
                    ?>
                    <!-- Product rows will be dynamically added here -->
                </tbody>
            </table>
        </div>

        <!--  Popup  for adding and editing-->
        <div class="popup" id="product-popup">
            <div class="popup-content">
                <span class="close" onclick="closeAddProductPopup()">&times;</span>
                <h2 id="popupTitle"></h2>
                <form id="productForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editIndex" name="product_id" value="-1">
                    <input type="hidden" id="isModified" name="isModified" value="false">

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
                    <img id="imagePreview" alt="Image Preview" style="display:none; width: 100px; height: auto; margin-top: 10px;">

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <!-- Buttons for Add and Edit -->
                    <button type="submit" name="add_product" id="add-product" style="display: block;">Add Product</button>
                    <button type="submit" name="edit_product" id="edit-product" style="display: none;">Update Product</button>
                </form>
            </div>
        </div>


        <?php include 'includes/footer.php'; ?>
    </div>


    <script src="assets/js/admin-script.js"></script>

</body>

</html>