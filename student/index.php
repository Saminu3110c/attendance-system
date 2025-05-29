<?php
session_start();

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../auth/student_login.php");
    exit;
}

require '../includes/db.php';

// Fetch student name
$student_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT name FROM students WHERE id = $student_id");
$student = mysqli_fetch_assoc($result);
$name = $student['name'] ?? 'Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🎓 Welcome, <?= htmlspecialchars($name) ?>!</h2>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">🚪 Logout</a>
        </div>

        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">📌 Student Actions</h5>
            <a href="mark_attendance.php" class="btn btn-primary mb-2">📝 Mark Attendance</a>
            <!-- Add more actions as needed in the future -->
        </div>
    </div>
</body>
</html>
