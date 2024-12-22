<?php include 'includes/navbar.php'; ?>
<?php 
$conn = mysqli_connect('localhost','root','ngg12#1','GlassGuruDB');

if(!$conn){
    die('Database connection failed: ' .mysqli_connect_error());
}

$sql = 'select * from products';
$result = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pages.css">
</head>
<body>
    <div class="wrapper">


        <div class="products-container">
            <!-- Sidebar for Product Types -->
            <!-- <aside class="product-types">
                <h2>Product Types</h2>
                <ul>
                    <li><a href="#">Type 1</a></li>
                    <li><a href="#">Type 2</a></li>
                    <li><a href="#">Type 3</a></li>
                    <li><a href="#">Type 4</a></li>
                </ul>
            </aside> -->

            <!-- Main Product List -->
            <section class="products-list">

                <!-- Product Card Example (Add dynamic product cards here) -->
                <!-- <div class="product-card">
                    <img src="assets/images/black-logo.png" alt="Product 1">
                    <h3>Product Title 1</h3>
                    <p>Price: $XX.XX</p>
                    <p>Short description of Product 1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum, illum. </p>
                </div>
                
                <div class="product-card">
                    <img src="path/to/image2.jpg" alt="Product 2">
                    <h3>Product Title 2</h3>
                    <p>Price: $XX.XX</p>
                    <p>Short description of Product 2.</p>
                </div>
                
                <div class="product-card">
                    <img src="path/to/image3.jpg" alt="Product 3">
                    <h3>Product Title 3</h3>
                    <p>Price: $XX.XX</p>
                    <p>Short description of Product 3.</p> 
                 </div> -->
                
                <!-- Add more product cards dynamically as needed -->

                <?php 
                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                               <div class='product-card'>
                    <img src='../admin/uploads/{$row['image']}' alt='{$row['title']}' class='product-image'>
                    <h3>{$row['title']}</h3>
                    <p>Price: Rs. {$row['price']}</p>
                    <p>{$row['description']}</p> 
                 </div> 
                ";
                        }
                    } else {
                        echo "<p>No products available.</p>";
                    }
                ?>
              
            </section>
        </div>

        
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>

