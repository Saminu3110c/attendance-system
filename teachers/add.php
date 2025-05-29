<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$teacher_id = $name = $email = $password = '';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($teacher_id && $name && $email && $password) {
        // Check for duplicate teacher ID or email
        $check = mysqli_query($conn, "SELECT id FROM teachers WHERE teacher_id = '$teacher_id' OR email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "❌ A teacher with this ID or email already exists!";
        } else {
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO teachers (teacher_id, name, email, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $teacher_id, $name, $email, $hashed_pw);
            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Teacher added successfully!";
                $teacher_id = $name = $email = $password = '';
            } else {
                $error = "❌ Failed to add teacher.";
            }
        }
    } else {
        $error = "⚠️ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">➕ Add Teacher</h2>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Teacher List</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Teacher ID</label>
            <input type="text" class="form-control" name="teacher_id" value="<?= htmlspecialchars($teacher_id) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher Name</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Temporary Password</label>
            <input type="password" class="form-control" name="password" value="<?= htmlspecialchars($password) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">➕ Add Teacher</button>
    </form>
</div>
</body>
</html>
