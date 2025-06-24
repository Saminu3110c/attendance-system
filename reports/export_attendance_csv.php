<?php
require '../includes/db.php';

// Set headers for CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendance_report.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write header row
fputcsv($output, ['Student ID', 'Student Name', 'Course Code', 'Course Title', 'Total Attended', 'Total Sessions', 'Percentage']);

// Fetch all students
$students = mysqli_query($conn, "SELECT id, student_id, name FROM students");

// Fetch all courses
$courses = mysqli_query($conn, "SELECT id, course_code, title FROM courses");

// Map course session totals
$course_days = [];
$course_totals = mysqli_query($conn, "
    SELECT course_id, DATE(attendance_time) AS day 
    FROM attendance 
    GROUP BY course_id, day
");
while ($row = mysqli_fetch_assoc($course_totals)) {
    $course_days[$row['course_id']] = ($course_days[$row['course_id']] ?? 0) + 1;
}

// Attendance counts
$attendance_counts = [];
$att = mysqli_query($conn, "
    SELECT student_id, course_id, COUNT(*) as count 
    FROM attendance 
    GROUP BY student_id, course_id
");
while ($row = mysqli_fetch_assoc($att)) {
    $attendance_counts[$row['student_id']][$row['course_id']] = $row['count'];
}

// Write rows
while ($student = mysqli_fetch_assoc($students)) {
    $student_id = $student['id'];
    $student_name = $student['name'];
    $student_code = $student['student_id'];

    mysqli_data_seek($courses, 0); // Reset pointer
    while ($course = mysqli_fetch_assoc($courses)) {
        $course_id = $course['id'];
        $title = $course['title'];
        $code = $course['course_code'];
        $attended = $attendance_counts[$student_id][$course_id] ?? 0;
        $total = $course_days[$course_id] ?? 0;
        $percent = $total > 0 ? round(($attended / $total) * 100) : 0;

        fputcsv($output, [$student_code, $student_name, $code, $title, $attended, $total, "$percent%"]);
    }
}

fclose($output);
exit;
