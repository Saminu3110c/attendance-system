<?php
session_start();
require_once '../includes/db.php'; // DB connection file

// Input validation
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Please enter both username and password.";
    header("Location: login.php");
    exit;
}

// Prepare and execute SQL query
$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $user = mysqli_fetch_assoc($result)) {
    // Verify password (assuming plain text; recommend hashing in production)
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role']; // e.g., admin or teacher
        $_SESSION['username'] = $user['username'];
        header("Location: ../dashboard/index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid password.";
    }
} else {
    $_SESSION['login_error'] = "User not found.";
}

header("Location: login.php");
exit;
