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
            <section class="products-list">
                <?php 
                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $product_id = $row['product_id'];
                            echo "
                            <div class='product-card' onclick= 'window.location.href=\"product.php?product_id={$product_id}\"'>
                    <img src='../admin/uploads/{$row['image']}' alt='{$row['title']}' class='product-image'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['description']}</p> 
                    <p style='color: orangered;'>Price: Rs. {$row['price']}</p>
                    
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

