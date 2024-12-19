<?php 
    $server = "localhost";
    $dbuser = "root";
    $dbpass = 'ngg12#1';
    $dbname = "bca4th";

    //connection string

    $conn = mysqli_connect($server, $dbuser, $dbpass,$dbname);

    if($conn == true) {
        $sql = "create table student(Roll int primary key,
        stdName varchar(30), stdAddress varchar(30),
        stdFaculty varchar(30), stdPhone varchar(10));";

        if($conn->query($sql)==true){
            echo 'Student table created successfully';
        } else{
            echo $conn->error;
        }
    }
?>