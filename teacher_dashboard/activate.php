<?php
session_start();
require '../includes/db.php';

// Only allow logged-in teachers
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../auth/teacher_login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$success = $error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';

    if ($course_id && $start_time && $end_time) {
        // Optional: Validate times
        if (strtotime($end_time) <= strtotime($start_time)) {
            $error = "⚠️ End time must be after start time.";
        } else {
            // Insert into active_courses
            $stmt = mysqli_prepare($conn, "INSERT INTO course_activations (course_id, teacher_id, start_time, end_time) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iiss", $course_id, $teacher_id, $start_time, $end_time);
            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Course activated successfully!";
            } else {
                $error = "❌ Failed to activate course.";
            }
        }
    } else {
        $error = "⚠️ All fields are required.";
    }
}

// Get teacher's assigned courses
$courses = [];
$result = mysqli_query($conn, "SELECT id, course_code, title FROM courses WHERE teacher_id = $teacher_id");
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activate Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📢 Activate Course for Attendance</h2>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Course</label>
            <select name="course_id" class="form-select" required>
                <option value="">-- Choose a course --</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_code']) ?> - <?= htmlspecialchars($course['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" name="start_time" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" name="end_time" required>
        </div>

        <button type="submit" class="btn btn-primary">🚀 Activate</button>
    </form>
</div>
</body>
</html>
