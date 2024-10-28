<!-- index.php -->
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
            <p>Your one-stop solution for [brief description of what your business does] Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam maxime aliquam iste! Eius at totam repudiandae voluptate nisi, numquam cupiditate a error quidem, corporis officia doloribus, eaque officiis laborum fugit?</p>
            <button onclick="window.location.href='services.php'">Explore Our Services</button>
        </div>
    </section>


    <!-- Services Section -->
    <section class="services">
        <h2>Our Services</h2>
        <div class="service-container">
            <div class="service-item">
                <img src="assets/images/black-logo.png" alt="Service 1 Image">
                <h3>Service 1</h3>
                <p>Short description of Service 1.</p>
            </div>
            <div class="service-item">
                <img src="assets/images/service2.jpg" alt="Service 2 Image">
                <h3>Service 2</h3>
                <p>Short description of Service 2.</p>
            </div>
            <div class="service-item">
                <img src="assets/images/service3.jpg" alt="Service 3 Image">
                <h3>Service 3</h3>
                <p>Short description of Service 3.</p>
            </div>
            <div class="service-item">
                <img src="assets/images/service4.jpg" alt="Service 4 Image">
                <h3>Service 4</h3>
                <p>Short description of Service 4.</p>
            </div>
        </div>
    </section>



    <!-- Featured Product Section -->
    <section class="featured-product">
        <h2>Featured Product</h2>
        <div class="product-content">
            <img src="assets/images/featured-product.jpg" alt="Featured Product">
            <div class="product-details">
                <h3>Product Name</h3>
                <p>Short description of the featured product, highlighting its main benefits and features in a few sentences. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci, blanditiis? Dolor voluptate nostrum nihil similique dolorem, sapiente asperiores incidunt sequi itaque, nulla quasi minima eius est deserunt illo dignissimos. Minima?</p>
                <button onclick="window.location.href='product-details.php'">Learn More</button>
            </div>
        </div>
        
        <div class="product-content">
            
            <div class="product-details">
                <h3>Product Name</h3>
                <p>Short description of the featured product, highlighting its main benefits and features in a few sentences.</p>
                <button onclick="window.location.href='product-details.php'">Learn More</button>
            </div>
            <img src="assets/images/black-logo.png" alt="Featured Product">
        </div>
    </section>




    <!-- About Section -->
    <section class="about">
        <h2>About Us</h2>
        <p>We are a local business specializing in glass products. Our mission is to provide customers with trusthworthy, high quality glass materials for their homes, office, etc . With a commitment to excellence and customer satisfaction, we strive to deliver the best products and services. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate harum, consequuntur saepe perferendis explicabo nemo. In aperiam aspernatur autem voluptatem! .</p>
    </section>




    <!-- Members Section -->
    <section class="members">
        <h2>Our Development Team</h2>
        <div class="member-container">
            <div class="member-item">
                <img src="assets/images/black-logo.png" alt="Member 1">
                <h3>Member 1</h3>
                <p>Short description about Member 1's role and contributions.</p>
            </div>
            <div class="member-item">
                <img src="assets/images/member2.jpg" alt="Member 2">
                <h3>Member 2</h3>
                <p>Short description about Member 2's role and contributions.</p>
            </div>
        </div>
    </section>



    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>




    <script src="assets/js/script.js"></script>
</body>
</html>
