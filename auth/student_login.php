<?php
session_start();
require '../includes/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'student') {
    header("Location: ../student/index.php");
    exit;
}

$email = $password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email && $password) {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM students WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = 'student';
                header("Location: ../student/index.php");
                exit;
            } else {
                $error = "❌ Invalid email or password.";
            }
        } else {
            $error = "❌ No student found with that email.";
        }
    } else {
        $error = "⚠️ Please enter both email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">🎓 Student Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">🔓 Login</button>
    </form>
</div>
</body>
</html>
