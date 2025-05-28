<?php session_start(); ?>
<!DOCTYPE html>
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
</html>