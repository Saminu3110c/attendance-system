<?php
    require 'db.php'

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student_id = $_POST['student_id'];
        $password = $_POST['password']; 

        $sql = "SELECT * FROM students WHERE student_id = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $student_id, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $student = mysqli_fetch_assoc($result);

        if ($student) {
            $student_id_real = $student['id'];
            $insert_sql = "INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "i", $student_id_real);
            if (mysqli_stmt_execute($insert_stmt)) {
                echo "Attendance marked successfully!";
            } else {
                echo "Failed to mark attendance.";
            }
        } else {
            echo "Fingerprint not recognized!";
        }
    }
?>


<?php
// require 'db.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $student_id = $_POST['student_id'];
//     $password = $_POST['passward'];

//     $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ? AND password = ?");
//     $stmt->execute([$student_id, $password]);
//     $student = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($student) {
//         $student_id = $student['id'];
//         $stmt = $pdo->prepare("INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())");
//         $stmt->execute([$student_id]);
//         echo "Attendance marked successfully!";
//     } else {
//         echo "Fingerprint not recognized!";
//     }
// }
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $credential_id = $_POST['credential_id'];

//     $stmt = $pdo->prepare("SELECT id FROM students WHERE credential_id = ?");
//     $stmt->execute([$credential_id]);
//     $student = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($student) {
//         $student_id = $student['id'];
//         $stmt = $pdo->prepare("INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())");
//         $stmt->execute([$student_id]);
//         echo "Attendance marked successfully!";
//     } else {
//         echo "Fingerprint not recognized!";
//     }
// }
?>