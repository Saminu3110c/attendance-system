<?php 
    include 'db.php';
    if(isset($_GET['delete_id'])){
        $id = $_GET['delete_id'];

        $stmt = $pdo->prepare("delete from `students` where student_id = :id");

        $stmt->execute(['id' => $id]);
        echo "Student deleted successfully!";

    }

?>


<!-- $sql = "DELETE FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]); -->
