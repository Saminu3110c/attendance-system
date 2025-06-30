<?php session_start(); ?>
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
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
        <div class="form-group">
            <label for="userRole" class="form-label">User Role</label>
            <select required name="userRole" class="form-control mb-3">
                <option value="">--Select User Roles--</option>
                <option value="Administrator">Administrator</option>
                <option value="CourseLecturer">CourseLecturer</option>
                <option value="Student">Student</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">🔓 Login</button>
        <div class="mt-3">
            <a href="forgot_password.php">🔑 Forgot your password?</a>
        </div>
    </form>
</div>
</body>
</html>






<!-- <!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Login - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                <h4>Admin/User Login</h4>
                </div>
                <div class="card-body">

                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
                <?php endif; ?>

                <form action="login_process.php" method="POST">
                    <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                </div>
            </div>
            </div>
        </div>
        </div>

    </body>
</html> -->