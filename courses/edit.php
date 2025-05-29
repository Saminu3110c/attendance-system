<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require '../includes/db.php';

// Validate course ID from query string
$course_id = $_GET['id'] ?? null;
if (!$course_id || !is_numeric($course_id)) {
    header("Location: index.php");
    exit;
}

// Fetch course details
$result = mysqli_query($conn, "SELECT * FROM courses WHERE id = $course_id");
$course = mysqli_fetch_assoc($result);

if (!$course) {
    header("Location: index.php");
    exit;
}

$course_code = $course['course_code'];
$title = $course['title'];
$teacher_id = $course['teacher_id'];

$success = $error = '';

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = trim($_POST['course_code'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $teacher_id = $_POST['teacher_id'] ?? null;
    $teacher_id = ($teacher_id === 'none') ? null : $teacher_id;

    if ($course_code && $title) {
        // Check for duplicate course code (excluding current)
        $check = mysqli_query($conn, "SELECT id FROM courses WHERE course_code = '$course_code' AND id != $course_id");
        if (mysqli_num_rows($check) > 0) {
            $error = "⚠️ Another course with this code already exists.";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE courses SET course_code = ?, title = ?, teacher_id = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssii", $course_code, $title, $teacher_id, $course_id);
            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Course updated successfully!";
            } else {
                $error = "❌ Failed to update course.";
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
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Course</h2>
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
        <button type="submit" class="btn btn-primary">💾 Update Course</button>
    </form>
</div>
</body>
</html>
