<?php
    require 'db.php';
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('admin', '$password', 'admin')");
?>