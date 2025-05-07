
<?php
    require 'db.php';
    $id = $_GET['edit_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $level = $_POST['level'];
        $email = $_POST['email'];

        $stmt = mysqli_prepare($conn, "UPDATE students SET student_id=?, name=?, department=?, level=?, email=? WHERE student_id=?");
        mysqli_stmt_bind_param($stmt, "ssssss", $student_id, $name, $department, $level, $email, $id);
        mysqli_stmt_execute($stmt);
        // echo "Student updated successfully!";
        header('location:admin.php');
        // exit;
    }

    // $result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$id'");
    // $student = mysqli_fetch_assoc($result);
    // mysqli_close($conn);

    $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Student Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Edit Student</h2>
        <label class="block mb-4">Matric No.:
            <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Full Name:
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Department:
            <input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Level:
            <input type="text" name="level" value="<?= htmlspecialchars($student['level']) ?>" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Email:
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required class="w-full border p-2 rounded">
        </label>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update Student</button>
    </form>
</body>
</html>
