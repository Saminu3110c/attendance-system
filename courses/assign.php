<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
require '../includes/db.php';

$success = $error = '';
$selected_course = $selected_teacher = '';

// Fetch all courses and teachers
$courses = mysqli_query($conn, "SELECT id, course_code, title FROM courses ORDER BY course_code");
$teachers = mysqli_query($conn, "SELECT id, name FROM teachers ORDER BY name");

// Handle assignment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_course = $_POST['course_id'] ?? '';
    $selected_teacher = $_POST['teacher_id'] ?? '';

    if ($selected_course && $selected_teacher) {
        $stmt = mysqli_prepare($conn, "UPDATE courses SET teacher_id = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $selected_teacher, $selected_course);

        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Course assigned to teacher successfully!";
        } else {
            $error = "❌ Failed to assign course.";
        }
    } else {
        $error = "⚠️ Please select both course and teacher.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Course to Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-3">📚 Assign Course to Teacher</h3>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Course List</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="course_id" class="form-label">Select Course</label>
            <select name="course_id" class="form-select" required>
                <option value="">-- Select Course --</option>
                <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                    <option value="<?= $course['id'] ?>" <?= ($selected_course == $course['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course['course_code'] . ' - ' . $course['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Assign to Teacher</label>
            <select name="teacher_id" class="form-select" required>
                <option value="">-- Select Teacher --</option>
                <?php while ($teacher = mysqli_fetch_assoc($teachers)): ?>
                    <option value="<?= $teacher['id'] ?>" <?= ($selected_teacher == $teacher['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($teacher['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">🔗 Assign</button>
    </form>
</div>
</body>
</html>
