    <?php 
    $conn = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Fetch all orders
    $query = 'SELECT * FROM orders';
    $result = mysqli_query($conn, $query);
    $orders = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row; // Stores the order data in the orders array
        } 
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/admin-style.css">
        <link rel="stylesheet" href="assets/css/order-page.css">
        <title>Order Receive</title>
    </head>
    <body>

    <?php include 'includes/navbar.php'; ?>

    <div id="wrapper">
        <div class="container">
            <h1>Order Details</h1>

            <!-- Order Summary Table -->
            <table class="order-receive">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Total Square Footage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="order-summary">
                    <?php
                    $sn = 1;
                    foreach ($orders as $order) {
                        // Calculates total square footage for each order
                        $totalSquareFootage = $order['length'] * $order['breadth'] / 144; // in inches
                        $status = ucfirst($order['status']);
                        echo "<tr>
                            <td>{$sn}</td>
                            <td>{$order['username']}</td>
                            <td>{$order['address']}</td>
                            <td>{$order['phone']}</td>
                            <td>{$order['email']}</td>
                            <td>". number_format($totalSquareFootage, 2) . " sq. ft.</td>
                            <td class='order-actions'>";
                        if ($status === 'Pending') {
                            echo "<button class='btn btn-accept' onclick='updateOrderStatus({$order['order_id']}, \"accepted\")'>Accept</button>
                                <button class='btn btn-decline' onclick='updateOrderStatus({$order['order_id']}, \"declined\")'>Decline</button>
                            ";
                        } else {
                            echo "<span>{$status}</span>
                                <button class='btn show-details' onclick='showDetails({$order['order_id']})'>Details</button>";
                            
                        }
                        echo "</td>
                        </tr>";
                        $sn++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Order Details -->
    <div id="details-modal" class="details-container">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Order Details</h2>
            <div id="show-details"></div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>


    </body>
    <script>
        
    async function updateOrderStatus(order_id, status) {
        console.log("Fetching order details...");
console.log("Order ID:", order_id);
        const response =  await fetch("../business/calculate.php", { 
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ order_id: order_id, status: status })
        
        });
        const data = await response.json();
        
    
        if(data.success === true){

            
            confirm(data.message);
        } else {
            alert(data.message);
        }
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }


    async function showDetails(order_id) {
        const modal = document.getElementById("details-modal");
        const detailsContainer = document.getElementById("show-details");

        // Hide all orders except the one clicked
        const allOrders = document.querySelectorAll('#order-summary tr');
        allOrders.forEach(orderRow => {
            if (!orderRow.id.includes(order_id)) {
                orderRow.style.display = 'none'; // Hide the order row
            }
        });

        detailsContainer.innerHTML = "Loading...";

        try {
            const response = await fetch("../business/calculate.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ order_id: order_id })
            });

            const data = await response.json();
            
            if (data.success) {
                const order = data.data;
                detailsContainer.innerHTML = `
                    <p><strong>Order ID:</strong> ${order.order_id}</p>
                    <p><strong>Thickness:</strong> ${order.thickness}</p>
                    <p><strong>Color:</strong> ${order.color}</p>
                    <p><strong>Length:</strong> ${order.length}</p>
                    <p><strong>Breadth:</strong> ${order.breadth}</p>
                    <p><strong>Total Square Footage:</strong> ${(order.length * order.breadth / 144).toFixed(2)} sq. ft.</p>
                `;
            } else {
                detailsContainer.innerHTML = `<p>${data.message}</p>`;
            }

            modal.classList.add("active");
        } catch (error) {
            detailsContainer.innerHTML = `<p>Error loading details. Please try again.</p>`;
            console.error("Error fetching order details:", error);
        }
    }

    function closeModal() {
        const modal = document.getElementById("details-modal");
        modal.classList.remove("active");

        // Show all orders again when modal is closed
        const allOrders = document.querySelectorAll('#order-summary tr');
        allOrders.forEach(orderRow => {
            orderRow.style.display = ''; // Reset to default display
        });
    }

    </script>
    </html>

    <!-- <script>
    // Function to calculate square footage
    function calculateSquareFootage(length, breadth) {
        return ((length * breadth) / 144).toFixed(2); // Result in sq. ft.
    }

    // Populate the Order Summary table
    function populateOrderSummary(orders) {
        const orderSummary = document.getElementById("order-summary");
        orders.forEach((order, index) => {
            const totalSquareFootage = order.glassOrders.reduce((total, item) => {
                return total + parseFloat(calculateSquareFootage(item.length, item.breadth));
            }, 0);

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${order.name}</td>
                <td>${order.address}</td>
                <td>${order.phone}</td>
                <td>${order.email}</td>
                <td>${totalSquareFootage} sq. ft.</td>
                <td class="order-actions">
                    <button class='btn btn-accept' onclick=acceptOrder(${order.id})">Accept</button>
                    <button class="btn btn-decline" onclick="declineOrder(${order.id})">Decline</button>
                    <span class="show-details" onclick="showDetails(${order.id})">View Details</span>
                </td>
            `;
            orderSummary.appendChild(row);
        });
    }

    // Show glass order details
    function showDetails(orderId) {
        const detailsContainer = document.getElementById("details-container");
        const glassDetails = document.getElementById("glass-details");

        // Clear previous details
        glassDetails.innerHTML = "";

        // Find the order by ID
        const order = orders.find(o => o.id === orderId);
        if (order) {
            order.glassOrders.forEach((item, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.thickness}</td>
                    <td>${item.color}</td>
                    <td>${item.length}</td>
                    <td>${item.breadth}</td>
                    <td>${calculateSquareFootage(item.length, item.breadth)} sq. ft.</td>
                `;
                glassDetails.appendChild(row);
            });

            detailsContainer.style.display = "block";
        }
    }

    // Handle Accept Order
    function acceptOrder(orderId) {
        alert(`Order ${orderId} has been accepted!`);
        // Add your logic here to mark the order as accepted in the database
    }

    // Handle Decline Order
    function declineOrder(orderId) {
        alert(`Order ${orderId} has been declined.`);
        // Add your logic here to mark the order as declined in the database
    }

    // Clear all form data when necessary (e.g., after placing an order)
    function clearForm() {
        // Clear inputs and other form data
        const form = document.getElementById("order-form");
        form.reset();
        document.getElementById("order-summary").innerHTML = ''; // Clear the order summary table
        document.getElementById("glass-details").innerHTML = ''; // Clear the glass details table
        document.getElementById("details-container").style.display = "none"; // Hide the details container
    }

    </body>
    </html> -->