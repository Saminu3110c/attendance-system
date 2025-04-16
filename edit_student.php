<?php

    // $id = 1;
    // $newEmail = 'john.doe@example.com';

    // $sql = "UPDATE users SET email = :email WHERE id = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['email' => $newEmail, 'id' => $id]);

    // echo "User updated successfully!";



?>

<?php
require 'db.php';
$id = $_GET['edit_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE students SET student_id = :student_id, name = :name, department = :department, level = :level, email = :email WHERE student_id = :id");
    $stmt->execute(['student_id' => $student_id, 'name' => $name, 'department' => $department, 'level' => $level, 'email' => $email, 'id' => $id]);
    echo "Student registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Student Record</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-8 max-w-2xl w-full">
        <h2 class="text-4xl font-extrabold text-center text-blue-600 mb-8">Edit Student Record</h2>

        <form id="registerForm" method="POST" action="edit_student.php">
            <!-- Matric No. --> 
            <div class="mb-6">
                <label for="student_id" class="block text-lg font-semibold mb-2">Matric No.</label>
                <input type="text" id="student_id" name="student_id" required placeholder="Enter your Matric number"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <!-- Full Name -->
            <div class="mb-6">
                <label for="name" class="block text-lg font-semibold mb-2">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name" 
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <!-- Department --> 
            <div class="mb-6">
                <label for="department" class="block text-lg font-semibold mb-2">Department</label>
                <input type="text" id="department" name="department" required placeholder="Enter your department"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <!-- Level --> 
            <div class="mb-6">
                <label for="level" class="block text-lg font-semibold mb-2">Level</label>
                <input type="text" id="level" name="level" required placeholder="Enter your level"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-lg font-semibold mb-2">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            

            <!-- Submit Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-600 w-full text-white font-semibold py-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-green-300">
                Update Student
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center mt-6 text-gray-600">Already registered? <a href="index.php" class="text-blue-500 hover:underline">Login here</a></p>
    </div>

</body>

</html>
