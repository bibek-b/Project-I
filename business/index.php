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



    <!-- Featured Product Section -->
    <section class="featured-product">
        <h2>Featured Product</h2>
        <div class="product-content">
            <img src="assets/images/rectangle-mirror.jpg" alt="Rectangle Mirror">
            <div class="product-details">
                <h3>Led Rectangle Mirror(2ft * 5ft)</h3>
                <p>This is a premium 2feet wide and 4feet tall rectangular mirror. This mirror is frameless mirror with LED lights installed into it, which makes it attractive and makes your mirror experience even more nice with proper lighting.</p>
                <!-- <button onclick="window.location.href='product-details.php'">Buy</button> -->
            </div>
        </div>
        
        <div class="product-content">
            
            <div class="product-details">
                <h3>Glass Book Shelf</h3>
                <p>This is a glass book shelf which is 6feet tall and 4feet wide. This give your home a premium look and feel. This book shelf is strong and durable. You do not need to worry about the safety as it is made from lamninated glass and the edges are polished(which avoids cuts and ensures smooth edge).</p>
                <button onclick="window.location.href='product-details.php'">Learn More</button>
            </div>
            <img src="assets/images/book-shelf.jpg" alt="Book Shelf">
        </div>
    </section>




    <!-- About Section -->
    <section class="about">
        <h2>About Us</h2>
        <p>We are a local business specializing in glass products. Our mission is to provide customers with trusthworthy, high quality glass materials for their homes, office, etc . With a commitment to excellence and customer satisfaction, we strive to deliver the best products and services.  Our mission is to revolutionize the way glass products are purchased and customized, offering both value and convenience to our customers..</p>
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
                <img src="assets/images/member2.jpg" alt="Member 2">
                <h3>Bibek BK</h3>
                <p>Co-Founder of Nepal Glass Guru. Back end developer of the project.</p>
            </div>
        </div>
    </section>



    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>




    <script src="assets/js/script.js"></script>
</body>