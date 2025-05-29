<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require '../includes/db.php';

$course_id = $_GET['id'] ?? null;

if ($course_id && is_numeric($course_id)) {
    $stmt = mysqli_prepare($conn, "DELETE FROM courses WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $course_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "✅ Course deleted successfully!";
    } else {
        $_SESSION['message'] = "❌ Failed to delete course.";
    }
} else {
    $_SESSION['message'] = "⚠️ Invalid course ID.";
}

header("Location: index.php");
exit;
