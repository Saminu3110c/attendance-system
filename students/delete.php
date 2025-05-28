<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Prepare and execute delete query
    $stmt = mysqli_prepare($conn, "DELETE FROM students WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?deleted=1");
        exit;
    } else {
        header("Location: index.php?error=delete_failed");
        exit;
    }
} else {
    header("Location: index.php?error=missing_id");
    exit;
}
