<?php
session_start();
require_once '../includes/db.php'; // DB connection file

$email = $password = "";
$_SESSION['login_error'] = "";

    // Input validation
    $userRole = $_POST['userRole'];
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if($userRole == "Administrator"){
    
    

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
            // Verify password 
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role']; // e.g., admin or teacher
                $_SESSION['username'] = $user['username'];
                header("Location: ../dashboard/index.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid password.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "User not found.";
            header("Location: login.php");
            exit;
        }

        header("Location: login.php");
        exit;
    } else if($userRole == "CourseLecturer"){

        if ($email && $password) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM teachers WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_role'] = 'teacher';
                header("Location: ../teacher_dashboard/index.php");
                exit;
            } else {
                $_SESSION['login_error'] = "❌ Incorrect password.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "❌ Teacher not found.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['login_error'] = "⚠️ Please enter both email and password.";
        header("Location: login.php");
        exit;
    }

    } else if($userRole == "Student"){

        if ($email && $password) {
            $stmt = mysqli_prepare($conn, "SELECT id, password FROM students WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = 'student';
                    header("Location: ../student_dashboard/index.php");
                    exit;
                } else {
                    $_SESSION['login_error'] = "❌ Invalid email or password.";
                    header("Location: login.php");
                    exit;
                }
            } else {
                $_SESSION['login_error'] = "❌ No student found with that email.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "⚠️ Please enter both email and password.";
            header("Location: login.php");
            exit;
        }

    } else {
        $_SESSION['login_error'] = "⚠️ Please select the user role.";
        header("Location: login.php");
        exit;
    }


