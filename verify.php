<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $credential_id = $_POST['credential_id'];

    $stmt = $pdo->prepare("SELECT id FROM students WHERE credential_id = ?");
    $stmt->execute([$credential_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $student_id = $student['id'];
        $stmt = $pdo->prepare("INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())");
        $stmt->execute([$student_id]);
        echo "Attendance marked successfully!";
    } else {
        echo "Fingerprint not recognized!";
    }
}
?>