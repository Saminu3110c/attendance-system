<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../auth/login.php");
        exit;
    }
    require '../includes/db.php';

    $id = $_GET['id'] ?? null;

    if ($id) {
        // Use prepared statement to delete teacher securely
        $stmt = mysqli_prepare($conn, "DELETE FROM teachers WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: index.php");
    exit;
?>
