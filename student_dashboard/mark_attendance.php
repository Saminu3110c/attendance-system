<?php
session_start();

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit;
}

require '../includes/db.php';

$student_id = $_SESSION['user_id'];
$success = $error = '';

// Get active courses (joined with course title)
// $now = date('Y-m-d H:i:s');

$query = "
    SELECT ac.id AS activation_id, c.id AS course_id, c.title, ac.start_time, ac.end_time
    FROM course_activations ac
    JOIN courses c ON ac.course_id = c.id
    WHERE ac.start_time <= NOW() AND ac.end_time >= NOW()
";

$result = mysqli_query($conn, $query);
$active_courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle attendance marking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];
    $today = date('Y-m-d');

    // Prevent multiple attendance entries per day
    $check = mysqli_query($conn, "
        SELECT id FROM attendance 
        WHERE student_id = $student_id AND course_id = $course_id AND attendance_date = '$today'
    ");
    
    if (mysqli_num_rows($check) > 0) {
        $error = "⚠️ You already marked attendance for this course today.";
    } else {
        $stmt = mysqli_prepare($conn, "
            INSERT INTO attendance (student_id, course_id) 
            VALUES (?, ?)
        ");
        mysqli_stmt_bind_param($stmt, 'ii', $student_id, $course_id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Attendance marked successfully!";
        } else {
            $error = "❌ Failed to mark attendance.";
        }
    }
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
<div class="container mt-4">
    <h2 class="mb-4">📝 Mark Attendance</h2>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (count($active_courses) > 0): ?>
        <form method="POST">
            <div class="mb-3">
                <label for="course_id" class="form-label">Select Active Course</label>
                <select name="course_id" class="form-select" required>
                    <option value="" disabled selected>-- Choose a course --</option>
                    <?php foreach ($active_courses as $course): ?>
                        <option value="<?= $course['course_id'] ?>">
                            <?= htmlspecialchars($course['title']) ?> 
                            (<?= date('H:i', strtotime($course['start_time'])) ?> - 
                             <?= date('H:i', strtotime($course['end_time'])) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">✅ Mark Attendance</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info">ℹ️ No active courses at this time. Please check back later.</div>
    <?php endif; ?>
</div>
</body>
</html>
