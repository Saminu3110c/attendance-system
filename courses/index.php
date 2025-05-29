<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$result = mysqli_query($conn, "
    SELECT courses.*, teachers.name AS teacher_name 
    FROM courses 
    LEFT JOIN teachers ON courses.teacher_id = teachers.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">📘 Manage Courses</h2>
    <a href="../dashboard/index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>
    <a href="add.php" class="btn btn-primary btn-sm mb-3 float-end">➕ Add New Course</a>
    

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Assigned Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($course = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td><?= htmlspecialchars($course['course_code']) ?></td>
                <td><?= htmlspecialchars($course['title']) ?></td>
                <td><?= htmlspecialchars($course['teacher_name'] ?? 'Unassigned') ?></td>
                <td>
                    <a href="edit.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                    <a href="delete.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?');">🗑️ Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="assign.php" class="btn btn-success btn-sm mb-3">📚 Assign Course to Teacher</a>
</div>
</body>
</html>
