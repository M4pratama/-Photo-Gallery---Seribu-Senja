<?php
session_start();
include 'config.php';

if (isset($_POST['foto_id']) && isset($_SESSION['user_id'])) {
    $foto_id = $_POST['foto_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user has already liked this photo
    $check_like = $conn->prepare("SELECT * FROM likes WHERE UserID = ? AND FotoID = ?");
    $check_like->bind_param("ii", $user_id, $foto_id);
    $check_like->execute();
    $result = $check_like->get_result();

    if ($result->num_rows === 0) {
        // Add like if not already liked
        $add_like = $conn->prepare("INSERT INTO likes (UserID, FotoID) VALUES (?, ?)");
        $add_like->bind_param("ii", $user_id, $foto_id);
        if ($add_like->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'already_liked';
    }
} else {
    echo 'not_logged_in';
}
?>x