<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - Seribu Senja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS */
        body { background-color: #f4f4f9; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 10px; transition: transform 0.2s ease; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); }
        .card-img-top { height: 225px; object-fit: cover; }
        .btn-group .btn { color: #2c3e50; }
        .btn-group .btn:hover { background-color: #ff9900; color: #fff; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-warning" href="#">Seribu Senja Gallery</a>
        </div>
    </nav>

    <!-- Gallery Section -->
    <div class="container">
        <h1 class="text-center my-4">Photo Gallery</h1>
        <div class="row">
            <?php
            include 'config.php';
            $query = "SELECT * FROM gallery_foto";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="uploads/' . $row['LokasiFile'] . '" class="card-img-top" alt="' . $row['JudulFoto'] . '">
                        <div class="card-body">
                            <p class="card-text">' . $row['DeskripsiFoto'] . '</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary view-btn" data-id="' . $row['id'] . '">Views ' . $row['views'] . '</button>
                                    <button class="btn btn-sm btn-outline-secondary like-btn" data-id="' . $row['id'] . '">Likes ' . $row['likes'] . '</button>
                                </div>
                                <small class="text-muted">' . $row['TanggalUnggah'] . '</small>
                            </div>
                            <div class="mt-3">
                                <form class="comment-form" data-id="' . $row['id'] . '">
                                    <input type="text" class="form-control mb-2" name="comment" placeholder="Add a comment..." required>
                                    <button class="btn btn-primary btn-sm w-100">Submit</button>
                                </form>
                                <div class="comments mt-3">
                                    <h6>Comments:</h6>';
                                    $comments = mysqli_query($conn, "SELECT * FROM comments WHERE FotoID = {$row['id']} ORDER BY created_at DESC LIMIT 3");
                                    while ($comment = mysqli_fetch_assoc($comments)) {
                                        echo '<p><strong>User:</strong> ' . htmlspecialchars($comment['comment']) . '</p>';
                                    }
                                echo '</div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-center text-light p-3 mt-5">
        &copy; 2024 Seribu Senja Gallery - All Rights Reserved
    </footer>

    <!-- Bootstrap and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle views
            $('.view-btn').on('click', function() {
                let photo_id = $(this).data('id');
                $.post('actions.php', { action: 'view', photo_id: photo_id });
                let views = $(this).text().match(/\d+/);
                $(this).text(`Views ${++views}`);
            });

            // Handle likes
            $('.like-btn').on('click', function() {
                let photo_id = $(this).data('id');
                $.post('actions.php', { action: 'like', photo_id: photo_id });
                let likes = $(this).text().match(/\d+/);
                $(this).text(`Likes ${++likes}`);
            });

            // Handle comments
            $('.comment-form').on('submit', function(e) {
                e.preventDefault();
                let photo_id = $(this).data('id');
                let comment = $(this).find('input[name="comment"]').val();
                $.post('actions.php', { action: 'comment', photo_id: photo_id, comment: comment }, function() {
                    alert("Comment added!");
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>
