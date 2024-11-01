<?php
session_start();
include 'config.php'; // Hubungkan dengan database

if (isset($_POST['action'])) {
    $photo_id = $_POST['photo_id'];

    if ($_POST['action'] == 'view') {
        $query = "UPDATE gallery_foto SET views = views + 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $photo_id);
        $stmt->execute();
    }

    if ($_POST['action'] == 'like') {
        $query = "UPDATE gallery_foto SET likes = likes + 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $photo_id);
        $stmt->execute();
    }

    if ($_POST['action'] == 'comment' && !empty($_POST['comment'])) {
        $comment = $_POST['comment'];
        $user_id = $_SESSION['user_id'];
        
        // Sesuaikan dengan nama kolom yang ada di tabel Anda
        $query = "INSERT INTO comments (FotoID, UserID, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iis', $photo_id, $user_id, $comment);
        $stmt->execute();
    }
}
?>
