<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

// Fetch all teachers
$result = mysqli_query($conn, "SELECT * FROM teachers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">👩‍🏫 Manage Teachers</h2>

    <a href="../dashboard/index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>
    <a href="add.php" class="btn btn-primary btn-sm mb-3 float-end">➕ Add Teacher</a>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Teacher deleted successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">❌ An error occurred!</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($teacher = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $teacher['id'] ?></td>
                <td><?= htmlspecialchars($teacher['teacher_id']) ?></td>
                <td><?= htmlspecialchars($teacher['name']) ?></td>
                <td><?= htmlspecialchars($teacher['email']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-warning">✏ Edit</a>
                    <a href="delete.php?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')">🗑 Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
