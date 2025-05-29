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

// Fetch teacher info
$result = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
$teacher = mysqli_fetch_assoc($result);
if (!$teacher) {
    header("Location: index.php");
    exit;
}

$teacher_id = $teacher['teacher_id'];
$name = $teacher['name'];
$email = $teacher['email'];
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($teacher_id && $name && $email) {
        // Check for duplicate teacher_id or email (excluding current record)
        $check = mysqli_query($conn, "SELECT id FROM teachers WHERE (teacher_id = '$teacher_id' OR email = '$email') AND id != $id");
        if (mysqli_num_rows($check) > 0) {
            $error = "❌ Teacher ID or Email already in use!";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE teachers SET teacher_id = ?, name = ?, email = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $teacher_id, $name, $email, $id);
            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Teacher updated successfully!";
                // Reload updated data
                $teacher['teacher_id'] = $teacher_id;
                $teacher['name'] = $name;
                $teacher['email'] = $email;
            } else {
                $error = "❌ Failed to update teacher.";
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
    <title>Edit Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Teacher</h2>
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
        <button type="submit" class="btn btn-primary">💾 Update Teacher</button>
    </form>
</div>
</body>
</html>
