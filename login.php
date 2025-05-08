<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['success'] = "<h2 align = 'center'>Welcome back, {$user['username']}!</h2>";
        header("Location: admin.php");
        exit;
    } else {
        $_SESSION['error'] = "<h2 align = 'center'>Invalid username or password!</h2>";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-3xl font-bold text-center mb-6">Admin Login</h2>
        <?php
        if (isset($_SESSION['success'])) {
            echo "<div class='alert success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert error'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form id="loginForm" method="POST">
            <div class="mb-6">
                <label for="username" class="block text-lg font-semibold mb-2">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your Username"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit" id="submitBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg w-full">
                Login
            </button>
        </form>
        
    </div>
</body>

</html>