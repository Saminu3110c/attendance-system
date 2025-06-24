<?php
require '../includes/db.php';

$step = 1;
$email = '';
$password = '';
$confirm_password = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (isset($_POST['check_email'])) {
        $stmt = mysqli_prepare($conn, "SELECT id, name FROM students WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($student = mysqli_fetch_assoc($result)) {
            $step = 2;
        } else {
            $message = "❌ No student found with that email.";
        }
    }

    if (isset($_POST['reset_password'])) {
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');

        if ($password !== $confirm_password) {
            $message = "⚠️ Passwords do not match!";
            $step = 2;
        } elseif (strlen($password) < 6) {
            $message = "⚠️ Password must be at least 6 characters.";
            $step = 2;
        } else {
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "UPDATE students SET password = ? WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "ss", $hashed_pw, $email);
            if (mysqli_stmt_execute($stmt)) {
                $message = "✅ Password has been reset. You can now log in.";
                $step = 1;
                $email = '';
            } else {
                $message = "❌ Failed to reset password. Try again.";
                $step = 2;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>🔐 Forgot Your Password?</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($step === 1): ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Enter your registered email</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
            </div>
            <button type="submit" name="check_email" class="btn btn-primary">🔍 Check Email</button>
        </form>
    <?php elseif ($step === 2): ?>
        <form method="POST">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" name="reset_password" class="btn btn-success">🔁 Reset Password</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
