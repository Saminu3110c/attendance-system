<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require '../includes/db.php';

// Fetch all students
$students_result = mysqli_query($conn, "SELECT id, student_id, name FROM students");
$students = [];
while ($row = mysqli_fetch_assoc($students_result)) {
    $students[$row['id']] = $row;
}

// Fetch all courses
$courses_result = mysqli_query($conn, "SELECT id, course_code, title FROM courses");
$courses = [];
while ($row = mysqli_fetch_assoc($courses_result)) {
    $courses[$row['id']] = $row;
}

// Build attendance counts
$attendance_result = mysqli_query($conn, "
    SELECT student_id, course_id, COUNT(*) as count 
    FROM attendance 
    GROUP BY student_id, course_id
");

$attendance_data = [];
while ($row = mysqli_fetch_assoc($attendance_result)) {
    $attendance_data[$row['student_id']][$row['course_id']] = $row['count'];
}

// Get total possible attendance sessions per course
$course_totals_result = mysqli_query($conn, "
    SELECT course_id, DATE(attendance_time) AS day, COUNT(DISTINCT attendance_time) 
    FROM attendance 
    GROUP BY course_id, day
");

$course_days = [];
while ($row = mysqli_fetch_assoc($course_totals_result)) {
    $course_id = $row['course_id'];
    if (!isset($course_days[$course_id])) {
        $course_days[$course_id] = 0;
    }
    $course_days[$course_id]++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">📊 Attendance Report</h2>
    <!-- Export & Filter Controls -->
    <div class="d-flex justify-content-between mb-3">
        <form method="GET" class="d-flex">
            <input type="text" name="student" placeholder="Filter by student name" class="form-control me-2"
                value="<?= htmlspecialchars($_GET['student'] ?? '') ?>">
            <input type="text" name="course" placeholder="Filter by course title" class="form-control me-2"
                value="<?= htmlspecialchars($_GET['course'] ?? '') ?>">
            <button class="btn btn-outline-primary">Filter</button>
        </form>
        <a href="export_attendance_csv.php" class="btn btn-success">⬇️ Export CSV</a>
    </div>

    <a href="../dashboard/index.php" class="btn btn-secondary btn-sm mb-3">← Back to Dashboard</a>

    <div class="table-responsive">
        <table id="attendanceTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <?php foreach ($courses as $course): ?>
                        <th><?= htmlspecialchars($course['course_code']) ?><br><?= htmlspecialchars($course['title']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <?php
                $student_filter = strtolower($_GET['student'] ?? '');
                $course_filter = strtolower($_GET['course'] ?? '');
            ?>
            <tbody>
                <?php foreach ($students as $student_id => $student): ?>
                    <?php
                    // Apply student name filter
                    if ($student_filter && strpos(strtolower($student['name']), $student_filter) === false) {
                        continue; // skip this student
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($student['student_id']) ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>

                        <?php foreach ($courses as $course_id => $course): ?>
                            <?php
                            // Apply course title filter
                            if ($course_filter && strpos(strtolower($course['title']), $course_filter) === false) {
                                continue; // skip this course column
                            }

                            $present = $attendance_data[$student_id][$course_id] ?? 0;
                            $total = $course_days[$course_id] ?? 0;
                            $percent = $total > 0 ? round(($present / $total) * 100) : 0;
                            ?>
                            <td><?= $present ?>/<?= $total ?> (<?= $percent ?>%)</td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#attendanceTable').DataTable();
        });
    </script>
</body>
</html>
