<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id_input = trim($_POST['student_id'] ?? '');
    $password_input = trim($_POST['password'] ?? '');

    if (empty($student_id_input) || empty($password_input)) {
        echo "❌ Please enter both Student ID and Password.";
        exit;
    }

    // Look up student
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $student_id_input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $student = mysqli_fetch_assoc($result)) {

        // Use this if password is stored as plaintext (not recommended)
        if ($password_input === $student['password']) {

            $student_real_id = $student['id'];

            $insert_sql = "INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "i", $student_real_id);

            if (mysqli_stmt_execute($insert_stmt)) {
                echo "✅ Attendance marked successfully!";
            } else {
                echo "❌ Failed to mark attendance.";
            }

        } else {
            echo "⚠️ Incorrect password.";
        }

    } else {
        echo "⚠️ Student not found with that ID.";
    }
}
?>



<?php
    // require 'db.php';

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     // Safely get inputs
    //     $student_id_input = trim($_POST['student_id'] ?? '');
    //     $password_input = trim($_POST['password'] ?? '');

    //     // $student_id_input = $_POST['student_id'];
    //     // $password_input = $_POST['password'];


    //     if (empty($student_id_input) || empty($password_input)) {
    //         echo "Please provide both student ID and password.";
    //         exit;
    //     }

    //     // Prepare query
    //     $sql = "SELECT * FROM students WHERE student_id = ?";
    //     $stmt = mysqli_prepare($conn, $sql);
    //     mysqli_stmt_bind_param($stmt, "s", $student_id_input);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);
    //     $student = mysqli_fetch_assoc($result);

    //     // Check student & verify password
    //     // if ($student && password_verify($password_input, $student['password']))
    //     if ($student && $password_input === $student['password']) {
    //         $student_real_id = $student['id'];

    //         $insert_sql = "INSERT INTO attendance (student_id, attendance_date) VALUES (?, CURDATE())";
    //         $insert_stmt = mysqli_prepare($conn, $insert_sql);
    //         mysqli_stmt_bind_param($insert_stmt, "i", $student_real_id);

    //         if (mysqli_stmt_execute($insert_stmt)) {
    //             echo "✅ Attendance marked successfully!";
    //         } else {
    //             echo "❌ Failed to mark attendance.";
    //         }
    //     } else {
    //         echo "⚠️ Fingerprint or password not recognized.";
    //     }
    // }
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