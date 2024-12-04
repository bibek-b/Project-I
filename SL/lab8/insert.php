<?php 
    $server = "localhost";
    $dbuser = "root";
    $dbpass = 'ngg12#1';
    $dbname = "bca4th";

    //connection string 

    $conn = mysqli_connect($server, $dbuser, $dbpass,$dbname);

    if($conn == true) {
        $sql = "insert into student(Roll,stdName, stdAddress,stdFaculty, stdPhone) 
            values (110,'bibek','bhkt','bca',9865632526),
                (2,'chandan','bhkt','bca',9865652526),
                (3,'manju','bhkt','bca',9865632526),
               (4,'bishal','bhkt','bca',9856352526),
                (5,'bidh','bhkt','bca',9865635252);";

        if($conn->query($sql)==true){
            echo 'Student table created successfully';
        } else{
            echo $conn->error;
        }
    }
?> 