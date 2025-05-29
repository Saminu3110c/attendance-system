<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$course_code = $title = $teacher_id = '';
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = trim($_POST['course_code'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $teacher_id = $_POST['teacher_id'] ?? null;
    $teacher_id = ($teacher_id === 'none') ? null : $teacher_id;

    if ($course_code && $title) {
        // Check for duplicate course code
        $check = mysqli_query($conn, "SELECT id FROM courses WHERE course_code = '$course_code'");
        if (mysqli_num_rows($check) > 0) {
            $error = "⚠️ A course with this code already exists.";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO courses (course_code, title, teacher_id) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssi", $course_code, $title, $teacher_id);
            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Course added successfully!";
                $course_code = $title = '';
                $teacher_id = null;
            } else {
                $error = "❌ Failed to add course.";
            }
        }
    } else {
        $error = "⚠️ Course Code and Title are required.";
    }
}

// Fetch teachers for dropdown
$teachers = mysqli_query($conn, "SELECT id, name FROM teachers ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">➕ Add Course</h2>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Course List</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" class="form-control" name="course_code" value="<?= htmlspecialchars($course_code) ?>" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($title) ?>" required>
        </div>
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Assign Teacher (optional)</label>
            <select name="teacher_id" class="form-select">
                <option value="none">-- No Teacher Assigned --</option>
                <?php while ($row = mysqli_fetch_assoc($teachers)): ?>
                    <option value="<?= $row['id'] ?>" <?= ($teacher_id == $row['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">➕ Add Course</button>
    </form>
</div>
</body>
</html>
