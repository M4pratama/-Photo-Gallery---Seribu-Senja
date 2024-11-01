<?php
// Include your database connection
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $albumName = mysqli_real_escape_string($conn, $_POST['albumName']);
    $albumDescription = mysqli_real_escape_string($conn, $_POST['albumDescription']);

    // SQL query to insert the album
    $query = "INSERT INTO albums (album_name, album_description) VALUES ('$albumName', '$albumDescription')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect to the index page with success message
        echo "<script>alert('Album added successfully!'); window.location.href='index.php';</script>";
    } else {
        // Redirect to the index page with an error message
        echo "<script>alert('Error adding album. Please try again.'); window.location.href='index.php';</script>";
    }
}

mysqli_close($conn);
?>
