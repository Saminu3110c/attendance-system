<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "attendance_system_test";

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?> 