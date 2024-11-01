<?php
session_start();
include 'config.php'; // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        echo '<script>alert("Please fill in all fields."); window.location.href = "register.php";</script>';
        exit();
    }

    // Cek apakah email sudah ada di database
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Email sudah ada
        echo '<script>alert("Email is already registered. Please use a different email."); window.location.href = "register.html";</script>';
        $checkStmt->close();
        $conn->close();
        exit();
    }

    // Hash password sebelum menyimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke database
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('sss', $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Jika registrasi berhasil, tampilkan notifikasi dan redirect ke halaman login
            $_SESSION['message'] = "Registration successful! Please login.";
            header("Location: login.html");
            exit();
        } else {
            echo '<script>alert("Registration failed. Please try again.");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("Database error. Please try again.");</script>';
    }

    $conn->close();
}
?>
