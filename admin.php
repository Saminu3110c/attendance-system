<?php
    require 'db.php';
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white p-6">
        <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
        <nav>
            <ul class="space-y-4">
                <li><a href="#" class="hover:text-blue-300">Dashboard</a></li>
                <li><a href="#" class="hover:text-blue-300">Manage Students</a></li>
                <li><a href="#" class="hover:text-blue-300">Reports</a></li>
                <li><a href="#" class="hover:text-blue-300">Settings</a></li>
                <li><a href="logout.php" class="hover:text-blue-300">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h2 class="text-4xl font-bold mb-8 text-blue-600">Manage Students</h2>

        <!-- Student Table -->
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Matric No.</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Department</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Level</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="px-6 py-4"><?= htmlspecialchars($student['student_id']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($student['name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($student['department']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($student['level']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($student['email']) ?></td>
                            <td class="px-6 py-4">
                                <a href="edit_student.php?edit_id=<?= $student['student_id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                                <a href="delete_student.php?delete_id=<?= $student['student_id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')" class="text-red-600 hover:underline">Delete</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Student Button -->
        <a href="register.php" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">Add New Student</a>
    </main>
</body>

</html>
