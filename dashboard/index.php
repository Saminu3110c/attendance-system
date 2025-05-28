<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?= htmlspecialchars($username) ?> (<?= ucfirst($role) ?>)</h2>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>

    <?php if ($role === 'admin'): ?>
        <div class="row">
            <div class="col-md-4">
                <a href="../students/" class="btn btn-primary w-100 mb-3">Manage Students</a>
            </div>
            <div class="col-md-4">
                <a href="../teachers/" class="btn btn-success w-100 mb-3">Manage Teachers</a>
            </div>
            <div class="col-md-4">
                <a href="../courses/" class="btn btn-info w-100 mb-3">Manage Courses</a>
            </div>
            <div class="col-md-4">
                <a href="../reports/" class="btn btn-dark w-100 mb-3">View Attendance Report</a>
            </div>
        </div>
    <?php elseif ($role === 'teacher'): ?>
        <a href="../courses/activate.php" class="btn btn-warning">Activate Course</a>
    <?php endif; ?>
</div>

</body>
</html>
