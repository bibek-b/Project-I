
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data insert from form</title>
</head>

<body>
    <center>
        <form action="" method="post">
            <h1>Student Registration Form</h1>
            Roll Number: <input type="text" name="txtRoll" /><br /><br />
            Student Name: <input type="text" name="txtName" /><br /><br />
            Student Address: <input type="text" name="txtAddress" /><br /><br />
            Student Faculty : <input type="text" name="txtFaculty" /><br /><br />
            Student Phone: <input type="text" name="txtPhone" /><br /><br />

            <input type="submit" value="Save Data" name="btnSave"> &nbsp
            <input type="submit" value="Display Data" name="btnDisplay">
            <input type="submit" value="Update Data" name="btnUpdate">

        </form>
    </center>

    <?php

    $serverName = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'ngg12#1';
    $dbName = 'bca4th';

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        echo 'Database cannot be connected' . $conn->error;
    } else {
        if (isset($_POST['btnSave'])) {
            $stdRoll = $_POST['txtRoll'];
            $stdName = $_POST['txtName'];
            $stdAddress = $_POST['txtAddress'];
            $stdFaculty = $_POST['txtFaculty'];
            $stdPhone = $_POST['txtPhone'];

            echo $stdRoll . $stdName . $stdAddress . $stdFaculty . $stdPhone;

            //sql query for data insert
            $sql = "insert into student values('$stdRoll','$stdName','$stdAddress','$stdFaculty','$stdPhone')";

            if ($conn->query($sql) == true) {
                echo '<script>
                alert("Data has been saved in database")
                </script>';
            }
        }
    }

    if (isset($_POST['btnDisplay'])) {
        $sqlShowData = 'select * from student';
        $result = $conn->query($sqlShowData);

        if ($result->num_rows > 0) {
            echo "<br/>
            <center>
            <table border='1'>
                    <tr>
                    <th>Roll no</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Faculty</th>
                    <th>Phone</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "
                        <tr>
                            <td>" . $row['Roll'] . "</td>
                            <td>" . $row['stdName'] . "</td>
                            <td>" . $row['stdAddress'] . "</td>
                            <td>" . $row['stdFaculty'] . "</td>
                            <td>" . $row['stdPhone'] . "</td>
                            </tr>";

            }
            echo "</table>
                    </center>";
        }
    }

    //update data
    
    if (isset($_POST['btnUpdate'])) {

        // Collect input data
        $stdRoll = $_POST['txtRoll'];
        $stdName = $_POST['txtName'];
        $stdAddress = $_POST['txtAddress'];
        $stdFaculty = $_POST['txtFaculty'];
        $stdPhone = $_POST['txtPhone'];

        // Use prepared statements to prevent SQL injection
        $sqlUpdateData = "UPDATE student SET stdName = ?, stdAddress = ?, stdFaculty = ?, stdPhone = ? WHERE Roll = ?";

        // Prepare the query
        if ($stmt = $conn->prepare($sqlUpdateData)) {

            // Bind the parameters to the query (use 's' for string and 'i' for integer types)
            $stmt->bind_param("ssssi", $stdName, $stdAddress, $stdFaculty, $stdPhone, $stdRoll);

            // Execute the query
            if ($stmt->execute()) {
                echo '<script>
                        alert("Data has been updated in the database");
                      </script>';
            } else {
                echo '<script>
                        alert("Data update failed");
                      </script>';
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo '<script>
                    alert("Failed to prepare the query");
                  </script>';
        }
    }
    ?>
</body>
</html>