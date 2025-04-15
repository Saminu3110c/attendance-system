<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Using Password to represent biometric feature for testing

    // $credential_id = $_POST['credential_id'];
    // $public_key = $_POST['public_key'];

    // $stmt = $pdo->prepare("INSERT INTO students (name, email, class, credential_id, public_key) VALUES (?, ?, ?, ?, ?)");
    // $stmt->execute([$name, $email, $class, $credential_id, $public_key]);

    $stmt = $pdo->prepare("INSERT INTO students (student_id, name, department, level, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$student_id, $name, $department, $level, $email, $password]);
    echo "Student registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-8 max-w-2xl w-full">
        <h2 class="text-4xl font-extrabold text-center text-blue-600 mb-8">Student Registration</h2>

        <!-- <form id="registerForm" method="POST" action="register_handler.php"> -->
        <form id="registerForm" method="POST" action="register.php">
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
            <!-- Password --> 
            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                <input type="text" id="password" name="password" required placeholder="Enter your password"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            <!-- Fingerprint Button -->
            <!-- <div class="mb-8 text-center">
                <button type="button" id="registerBtn" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Scan Fingerprint
                </button>
                <input type="hidden" id="credential_id" name="credential_id">
            </div> -->

            <!-- Submit Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-600 w-full text-white font-semibold py-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-green-300">
                Register Student
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center mt-6 text-gray-600">Already registered? <a href="index.php" class="text-blue-500 hover:underline">Login here</a></p>
    </div>

    <!-- WebAuthn Fingerprint Handling -->
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
