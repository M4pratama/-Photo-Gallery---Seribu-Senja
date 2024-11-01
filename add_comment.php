<?php
session_start();
include 'config.php';

if (isset($_POST['foto_id']) && isset($_POST['comment']) && isset($_SESSION['user_id'])) {
    $foto_id = $_POST['foto_id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $add_comment = $conn->prepare("INSERT INTO comments (UserID, FotoID, comment) VALUES (?, ?, ?)");
    $add_comment->bind_param("iis", $user_id, $foto_id, $comment);

    if ($add_comment->execute()) {
        header("Location: index.php"); // Redirect back to the gallery page
    } else {
        echo 'Failed to add comment';
    }
} else {
    echo 'Invalid input or not logged in';
}
?>
