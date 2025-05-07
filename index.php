<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-3xl font-bold text-center mb-6">Mark Attendance</h2>
        <!-- <p class="text-gray-600 text-center mb-4">Scan your fingerprint to record attendance</p> -->

        <form id="attendanceForm" method="POST" action="verify.php">
            <div class="mb-6">
                <label for="student_id" class="block text-lg font-semibold mb-2">Matric No.</label>
                <input type="text" id="student_id" name="student_id" required placeholder="Enter your Matric number"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit" id="verifyBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg w-full">
                Mark Attendance
            </button>
            <p class="text-center mt-6 text-gray-600">Not Registered? <a href="register.php" class="text-blue-500 hover:underline">Registered here</a></p>
        </form>
        <!-- <form id="attendanceForm" method="POST" action="verify.php">
            <input type="hidden" name="credential_id" id="credential_id">
            <button type="button" id="verifyBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg w-full">
                Scan Fingerprint
            </button>
        </form> -->
    </div>

    <!-- <script>
        const verifyBtn = document.getElementById('verifyBtn');
        async function verifyFingerprint() 
            try {
                const publicKey = { challenge: new Uint8Array(32) };
                const credential = await navigator.credentials.get({ publicKey });

                document.getElementById('credential_id').value = btoa(String.fromCharCode(...new Uint8Array(credential.rawId)));
                document.getElementById('attendanceForm').submit();
            } catch (error) {
                alert("Fingerprint scan failed: " + error);
            }
        }
        verifyBtn.addEventListener('click', verifyFingerprint);
    </script> -->
</body>

</html>