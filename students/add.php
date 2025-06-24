<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $level = trim($_POST['level'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($student_id) || empty($name) || empty($department) ||empty($level) ||empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO students (student_id, name, department, level, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $student_id, $name, $department, $level, $email, $hashed_pw);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?success=1");
            exit;
        } else {
            $errors[] = "Failed to add student. Possibly duplicate student ID.";
        }
    }
}

if (isset($_POST['upload_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
        $filename = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($filename, 'r');

        // Skip header row
        fgetcsv($handle);

        $success_count = 0;
        $fail_count = 0;
        $fail_rows = [];

        while (($data = fgetcsv($handle)) !== false) {
            // Assuming CSV columns: student_id, name, department, level, email
            list($student_id, $name, $department, $level, $email) = array_map('trim', $data);

            // Insert into DB
            $stmt = mysqli_prepare($conn, "INSERT INTO students (student_id, name, department, level, email, password) VALUES (?, ?, ?, ?, ?, NULL)");
            mysqli_stmt_bind_param($stmt, "sssss", $student_id, $name, $department, $level, $email);
            if (mysqli_stmt_execute($stmt)) {
                $success_count++;
            } else {
                $fail_count++;
                $fail_rows[] = $student_id;
            }
        }

        fclose($handle);

        if ($success_count) {
            $errors[] = "✅ $success_count students uploaded successfully.";
        }
        if ($fail_count) {
            $errors[] = "❌ $fail_count failed to upload: " . implode(', ', $fail_rows);
        }
    } else {
        $errors[] = "⚠️ Failed to upload file.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>➕ Add New Student</h3>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Back to List</a>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?= implode("<br>", $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Student ID</label>
            <input type="text" name="student_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Level</label>
            <input type="text" name="level" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">💾 Save</button>
    </form>
    <hr class="my-5">
    <h4>📁 Bulk Upload via CSV</h4>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="csv_file" class="form-label">Choose CSV File</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
        </div>
        <button type="submit" name="upload_csv" class="btn btn-primary">📤 Upload Students</button>
    </form>

</div>
</body>
</html>
