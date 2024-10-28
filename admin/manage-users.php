<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/user.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div id="wrapper">
    <div class="admin-content">
        <h1>Manage Users</h1>
        <button class="add-user" onclick="openPopup()">+ Add User</button>
        
        <table class="user-table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- User rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Popup for adding or editing a user -->
    <div class="popup" id="userPopup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Add/Edit User</h2>
            <form id="addUserForm">
                <input type="hidden" id="userId"> <!-- Hidden input to track the user ID for editing -->
                <label for="username">Username:</label>
                <input type="text" id="username" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" required>
                
                <label for="role">Role:</label>
                <select id="role" required>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
                
                <button type="submit">Save User</button>
            </form>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>
</div>
<script src="assets/js/admin-script.js"></script>

</body>
</html>
