<?php
session_start();
require '../includes/db.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../auth/student_login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$success = $error = "";

// Current time
$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'] ?? '';

    if ($course_id) {
        // Ensure course is currently active
        $checkActive = mysqli_query($conn, "SELECT * FROM active_courses 
                                            WHERE course_id = $course_id 
                                            AND start_time <= '$now' AND end_time >= '$now' 
                                            LIMIT 1");

        if (mysqli_num_rows($checkActive) === 1) {
            
            $stmt = mysqli_prepare($conn, "INSERT INTO attendance (student_id, course_id, attendance_date) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iis", $student_id, $course_id, $today);

            if (mysqli_stmt_execute($stmt)) {
                $success = "✅ Attendance marked successfully!";
            } else {
                $error = "⚠️ You’ve already marked attendance for this course today.";
            }
        } else {
            $error = "⚠️ Course is not active for attendance.";
        }
    } else {
        $error = "⚠️ Please select a course.";
    }
}

// Get currently active courses
$active_courses = [];
$result = mysqli_query($conn, "SELECT ca.course_id, c.course_code, c.title, ca.start_time, ca.end_time 
                               FROM course_activations ca 
                               JOIN courses c ON ca.course_id = c.id 
                               WHERE ca.start_time <= '$now' AND ca.end_time >= '$now'");
while ($row = mysqli_fetch_assoc($result)) {
    $active_courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">🎯 Mark Attendance</h2>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (empty($active_courses)): ?>
        <div class="alert alert-warning">📌 No active courses available right now.</div>
    <?php else: ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Select Active Course</label>
                <select name="course_id" class="form-select" required>
                    <option value="">-- Choose a course --</option>
                    <?php foreach ($active_courses as $course): ?>
                        <option value="<?= $course['course_id'] ?>">
                            <?= htmlspecialchars($course['course_code']) ?> - <?= htmlspecialchars($course['title']) ?>
                            (<?= date('H:i', strtotime($course['start_time'])) ?> to <?= date('H:i', strtotime($course['end_time'])) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">📝 Mark Attendance</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
