<?php 
    include 'db.php';
    if(isset($_GET['delete_id'])){
        $id = $_GET['delete_id'];

        $stmt = $pdo->prepare("delete from `students` where student_id = $id");

        $stmt->execute();
        echo "Student registered successfully!";

    }

?>