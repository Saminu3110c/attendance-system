<?php
    session_start();
    require 'db.php';
    require 'flash.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $level = $_POST['level'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        $stmt = mysqli_prepare($conn, "INSERT INTO students (student_id, name, department, level, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $student_id, $name, $department, $level, $email, $password);
        // mysqli_stmt_execute($stmt);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Student registered successfully!";
        } else {
            $_SESSION['error'] = "Registration failed: " . mysqli_error($conn);
        }
        // echo "Student registered successfully!";
        // header('location:admin.php');
        // mysqli_close($conn);
        
        
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form id="registerForm" method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Student Registration</h2>
        <?php // flash('success'); flash('error'); ?>
        <label class="block mb-4">Matric No.:
            <input type="text" name="student_id" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Full Name:
            <input type="text" name="name" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Department:
            <input type="text" name="department" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Level:
            <input type="text" name="level" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Email:
            <input type="email" name="email" required class="w-full border p-2 rounded">
        </label>
        <label class="block mb-4">Password:
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </label>
        <!-- <input type="hidden" name="credential_id" id="credential_id">
        <input type="hidden" name="public_key" id="public_key"> -->
        <button type="submit" id="registerBtn" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register Fingerprint</button>
        <p class="text-center mt-6 text-gray-600">Already registered? <a href="index.php" class="text-blue-500 hover:underline">Mark Attendance</a></p>
    </form>

    <!-- <script>
        const registerBtn = document.getElementById('registerBtn');
        async function registerFingerprint() {
            try {
                const publicKey = {
                    challenge: new Uint8Array(32),
                    rp: { name: "Attendance System" },
                    user: {
                        id: new Uint8Array(16),
                        name: document.querySelector('input[name="email"]').value,
                        displayName: document.querySelector('input[name="name"]').value
                    },
                    pubKeyCredParams: [{ type: "public-key", alg: -7 }]
                };
                const credential = await navigator.credentials.create({ publicKey });
                document.getElementById('credential_id').value = btoa(String.fromCharCode(...new Uint8Array(credential.rawId)));
                document.getElementById('public_key').value = btoa(String.fromCharCode(...new Uint8Array(credential.response.attestationObject)));
                document.getElementById('registerForm').submit();
            } catch (error) {
                alert("Fingerprint registration failed: " + error);
            }
        }
        registerBtn.addEventListener('click', registerFingerprint);
    </script> -->
</body>
</html>
