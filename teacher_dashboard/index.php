<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../auth/teacher_login.php");
    exit;
}
require '../includes/db.php';

$teacher_id = $_SESSION['user_id'];

// Fetch courses assigned to this teacher
$query = "SELECT * FROM courses WHERE teacher_id = $teacher_id";
$courses = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>👩‍🏫 Welcome, Teacher</h2>
    <a href="../auth/logout.php" class="btn btn-danger btn-sm float-end">Logout</a>
    <h4 class="mt-4">📚 Your Courses</h4>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Course Code</th>
                <th>Title</th>
                <th>Activate</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($courses)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['course_code']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td>
                        <a href="activate.php?course_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">🔓 Activate</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
