<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance System</title>
</head>
<body>
    <h2>Mark Attendance</h2>
    <form id="attendanceForm" method="POST" action="verify.php">
        <input type="hidden" name="credential_id" id="credential_id">
        <button type="button" id="verifyBtn">Scan Fingerprint</button>
    </form>

    <script>
        const verifyBtn = document.getElementById('verifyBtn');

        async function verifyFingerprint() {
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
    </script>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white shadow-xl rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-3xl font-bold text-center mb-6">Mark Attendance</h2>
        <p class="text-gray-600 text-center mb-4">Scan your fingerprint to record attendance</p>

        <form id="attendanceForm" method="POST" action="verify.php">
            <input type="hidden" name="credential_id" id="credential_id">
            <button type="button" id="verifyBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg w-full">
                Scan Fingerprint
            </button>
        </form>
    </div>

    <script>
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
    </script>
</body>

</html>