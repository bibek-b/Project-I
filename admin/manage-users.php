<?php
$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}


$error_msg = '';
$show_add_user_popup = false;

//handles delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    if (!empty($user_id)) {
        $stmt = $conn->prepare('delete from users where user_id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

//handles edit role request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    if (!empty($user_id) && !empty($new_role)) {
        $stmt = $conn->prepare('update users set role = ? where user_id = ?');
        $stmt->bind_param('si', $new_role, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

//handles add user request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_Password = $_POST['confirm_Password'];
    $role = $_POST['role'];

    //validates inputs
    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_Password) && !empty($role)) {
        $checkStmt = $conn->prepare('select email from users where email = ?');
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // echo "<script>alert('Email already exists');</script>";
            $error_msg = 'Email already exists';
            $show_add_user_popup = true;
        } else if ($password !== $confirm_Password) {
            // echo "<script>alert('Password doesnot match');</script>";
            $error_msg = 'Password doesnot match';
            $show_add_user_popup = true;
        } else {
            $stmt = $conn->prepare('insert into users (username,email,password,confirm_Password,role) values (?, ?, ?, ?,?)');
            $stmt->bind_param('sssss', $username, $email, $password, $confirm_Password, $role);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('User added successfully');</script>";
        }
    }
    $checkStmt->close();
}

// Fetch users from the database
$sql = "SELECT user_id, username, email, role FROM users";
$result = $conn->query($sql);


?>

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

    <?php include './includes/navbar.php'; ?>

    <div id="wrapper">
        <div class="admin-content">
            <h1>Manage Users</h1>
            <button class="add-user" onclick="addUserPopup()">+ Add User</button>

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
                <tbody id="user-table-body">
                    <!-- User rows will be dynamically added here -->
                    <?php if ($result->num_rows > 0): ?>
                        <?php $sn = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr id="user-row-<?php echo $row['user_id']; ?>">
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <button style="
                                                   background-color: #e44336;
                                                   color: white;  color: #fff;
                                                   border: none;
                                                   padding: 10px 15px;
                                                   cursor: pointer;
                                                   border-radius: 5px;" name="delete_user">
                                                   Delete
                                                </button>
                                    </form>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <button type="submit" onclick="openEditPopup('<?php echo $row['user_id']; ?>','<?php echo $row['role']; ?>')">Edit Role</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found</td>
                        </tr>
                    <?php endif; ?>


                </tbody>
            </table>
        </div>


        <!-- Popup for  editing a user -->

        <div class="popup" id="editRolePopup">
            <div class="popup-content">
                <span class="close" onclick="closeEditPopup()">X</span>
                <h2>Edit User Role</h2>
                <form id="editRoleForm" method="post">
                    <input type="hidden" id="editUserId" name="user_id"> <!-- Hidden input to track the user ID for editing -->

                    <label for="role">
                        Sn: <span><?php echo $sn ?></span>
                        <br>
                        Role:

                    </label>
                    <select id="editRole" name="role">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>

                    <button type="submit" name="edit_role" class="update-btn">Update Role</button>
                </form>
            </div>
        </div>

        <!-- Popup for  adding a user -->
        <div class="popup" id="addUserPopup" style="<?php echo $show_add_user_popup ? 'display: block' : 'display: none'; ?>">
            <div class="popup-content">
                <span class="close" onclick="closeAddPopup()">X</span>
                <h2>Add User</h2>
                <?php if (!empty($error_msg)): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error_msg); ?></p>
                <?php endif; ?>
                <form id="addUserForm" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_Password">Confrim Password:</label>
                    <input type="password" id="confirm_password" name="confirm_Password" required>

                    <label for="role">Role:</label>
                    <select id="role" name="role">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>

                    <button type="submit" name="add_user" class="save-btn">Add User</button>
                </form>
            </div>
        </div>


        <?php include './includes/footer.php'; ?>
    </div>

    <script src="assets/js/admin-script.js"></script>

</body>

</html>