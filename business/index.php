<!-- index.php -->
<?php

$conn = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

if (!$conn) {
    echo 'Error connecting database.' . $mysql->error;
}

$sql =  'select product_id, title, image, description from products where product_id = 26';

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo 'Error fetching products: ' . mysqli_error($conn);
    exit;
}
$row = mysqli_fetch_assoc($result);

$sql1 =  'select product_id, title, image, description from products where product_id = 27';

$result1 = mysqli_query($conn, $sql1);
if (!$result1) {
    echo 'Error fetching products: ' . mysqli_error($conn);
    exit;
}
$row1 = mysqli_fetch_assoc($result1);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Business Website</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Content of the landing page goes here -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Our Business</h1>
            <p>Welcome to Nepal Glass Guru – Your Trusted Partner for Premium Glass Solutions!

                At Nepal Glass Guru, we specialize in providing top-quality glass products and services tailored to your unique needs. Whether you're looking for custom-cut glass, stylish mirrors, or expert installations, we've got you covered.<br>

                Your vision, our expertise. Together, let's create something extraordinary!

                Visit us today and discover why we are Nepal's go-to glass experts.</p>
            <button onclick="window.location.href='services.php'">Explore Our Services</button>
        </div>
    </section>


    <!-- Services Section -->
    <section class="services">
        <h2>Our Services</h2>
        <div class="service-container">
            <div class="service-item">
                <img src="assets/images/cut.png" alt="Service 1">
                <h3> Glass Cutting and Customization</h3>
                <p>Custom-sized glass cutting for windows, doors, tables, and shelves.
                    Options for specific thickness, shapes (rectangular, circular, etc.), and edge finishes (beveled, polished, etc.).Glass drilling for hardware fittings (e.g., hinges, knobs).
                </p>
            </div>
            <div class="service-item">
                <img src="assets/images/custom.png" alt="Service 2">
                <h3>Decorative Glass Services</h3>
                <p>Custom designs for decorative purposes, such as etched, frosted, or stained glass.
                    Glass panels for cabinets, display cases, or wall art.</p>
            </div>
            <div class="service-item">
                <img src="assets/images/deliver.png" alt="Service 3">
                <h3>Delivery Services</h3>
                <p>Safe transportation of glass products to the customer’s location.</p>
            </div>
            <div class="service-item">
                <img src="assets/images/installation.png" alt="Service 4">
                <h3>Glass Repair and Replacement</h3>
                <p>Repair of broken or damaged glass panels for windows, doors, or furniture.
                    Replacement services for cracked or old glass with new and durable options..</p>
            </div>
        </div>
    </section>

    <section class="featured-product">
        <h2>Featured Products</h2>

        <!-- First Product -->
        <div class="product-content" id="product-<?php echo htmlspecialchars($row['product_id']); ?>">
            <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
            <div class="product-details">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <button onclick="window.location.href='product.php?product_id=<?php echo htmlspecialchars($row['product_id']); ?>'">Learn More</button>
            </div>
        </div>

        <!-- Second Product -->
        <div class="product-content" id="product-<?php echo htmlspecialchars($row1['product_id']); ?>">
            <div class="product-details">
                <h3><?php echo htmlspecialchars($row1['title']); ?></h3>
                <p><?php echo htmlspecialchars($row1['description']); ?></p>
                <button onclick="window.location.href='product.php?product_id=<?php echo htmlspecialchars($row1['product_id']); ?>'">Learn More</button>
            </div>
            <img src="assets/images/<?php echo htmlspecialchars($row1['image']); ?>" alt="<?php echo htmlspecialchars($row1['title']); ?>">
        </div>
    </section>





    <!-- About Section -->
    <section class="about">
        <h2>About Us</h2>
        <p>We are a local business specializing in glass products. Our mission is to provide customers with trusthworthy, high quality glass materials for their homes, office, etc . With a commitment to excellence and customer satisfaction, we strive to deliver the best products and services. Our mission is to revolutionize the way glass products are purchased and customized, offering both value and convenience to our customers..</p>
    </section>




    <!-- Members Section -->
    <section class="members">
        <h2>Our Development Team</h2>
        <div class="member-container">
            <div class="member-item">
                <img src="assets/images/ceetoo.png" alt="Member 1">
                <h3>Chandan Chaudhary</h3>
                <p>Co-founder of Nepal Glass Guru. Front end developer of the project. </p>
            </div>
            <div class="member-item">
                <img src="assets/images/bibek.png" alt="Member 2">
                <h3>Bibek B.K</h3>
                <p>Co-Founder of Nepal Glass Guru. Back end developer of the project.</p>
            </div>
        </div>
    </section>



    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>




    <script src="assets/js/script.js"></script>
</body>

</html>