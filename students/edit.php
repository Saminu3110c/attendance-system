<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$errors = [];
$student = null;

// Fetch current student data
$stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    header("Location: index.php");
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $level = trim($_POST['level'] ?? '');
    $email = trim($_POST['email'] ?? '');
    // $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($student_id) || empty($name) || empty($department) ||empty($level) ||empty($email)) {
        $errors[] = "All fields are required.";
    }


    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "UPDATE students SET student_id = ?, name = ?, department = ?, level = ?, email = ?, WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssi", $student_id, $name, $department, $level, $email, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?updated=1");
            exit;
        } else {
            $errors[] = "Failed to update student.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>✏️ Edit Student</h3>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Back to List</a>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?= implode("<br>", $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" value="<?= htmlspecialchars($student['student_id']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($student['department']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Level</label>
            <input type="text" name="level" class="form-control" value="<?= htmlspecialchars($student['level']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="class" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">🔄 Update</button>
    </form>
</div>
</body>
</html>
