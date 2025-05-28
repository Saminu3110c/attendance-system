<?php
    require 'db.php';
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM students WHERE student_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // echo "Student deleted successfully!";
        header('location:admin.php');
    } 
    // mysqli_close($conn);
?>