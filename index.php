<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery - Seribu Senja</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .navbar-nav .nav-link {
            color: #333;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background-color: #fff;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .like-btn, .comment-toggle {
            cursor: pointer;
            color: #007bff;
        }

        .like-btn:hover, .comment-toggle:hover {
            color: #0056b3;
        }

        .collapse {
            padding-top: 10px;
        }

        footer {
            background-color: #ffffff;
            color: #333;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Seribu Senja Gallery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
        Add Album
    </button>
</li>
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="upload.php">Upload</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <li class="nav-item">
</li>
            </ul>
        </div>
    </div>
</nav>


<!-- Add Album Modal -->
<div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlbumModalLabel">Create New Album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="add_album.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="albumName" class="form-label">Album Name</label>
                        <input type="text" name="albumName" class="form-control" id="albumName" required>
                    </div>
                    <div class="mb-3">
                        <label for="albumDescription" class="form-label">Album Description</label>
                        <textarea name="albumDescription" class="form-control" id="albumDescription" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Album</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Gallery Section -->
<div class="container">
    <h1>Photo Gallery</h1>
    <div class="gallery-grid">
        <?php
        include 'config.php'; // Connect to DB

        $query = "SELECT * FROM gallery_foto";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $fotoID = $row['FotoID'];

            // Count likes
            $likeQuery = "SELECT COUNT(*) AS likes_count FROM likes WHERE FotoID = $fotoID";
            $likeResult = mysqli_query($conn, $likeQuery);
            $likeRow = mysqli_fetch_assoc($likeResult);

            // Fetch comments
            $commentQuery = "SELECT c.comment, u.username 
                             FROM comments c 
                             JOIN users u ON c.UserID = u.id
                             WHERE c.FotoID = $fotoID 
                             ORDER BY c.created_at DESC";
            $commentResult = mysqli_query($conn, $commentQuery);

            echo '
            <div class="card">
                <img src="uploads/' . $row['LokasiFile'] . '" alt="' . htmlspecialchars($row['JudulFoto']) . '">
                <div class="card-body">
                    <p class="card-text">' . htmlspecialchars($row['DeskripsiFoto']) . '</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="like-btn" data-id="' . $fotoID . '">❤️ Like (' . $likeRow['likes_count'] . ')</span>
                        <button class="btn btn-link comment-toggle" data-bs-toggle="collapse" data-bs-target="#comments-' . $fotoID . '">Show Comments</button>
                    </div>
                    <div id="comments-' . $fotoID . '" class="collapse">';
                    if (mysqli_num_rows($commentResult) > 0) {
                        while ($commentRow = mysqli_fetch_assoc($commentResult)) {
                            echo '<p><strong>' . htmlspecialchars($commentRow['username']) . ':</strong> ' . htmlspecialchars($commentRow['comment']) . '</p>';
                        }
                    } else {
                        echo '<p>No comments yet.</p>';
                    }
                    echo '
                        <form action="add_comment.php" method="POST" class="mt-2">
                            <input type="hidden" name="foto_id" value="' . $fotoID . '">
                            <textarea name="comment" class="form-control mb-2" placeholder="Add a comment" required></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Like Button AJAX
document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function() {
        const fotoID = this.getAttribute('data-id');
        fetch('like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'foto_id=' + fotoID
        }).then(response => response.text()).then(data => {
            if (data === 'success') {
                const currentCount = parseInt(this.innerText.match(/\d+/)[0]);
                this.innerText = '❤️ Like (' + (currentCount + 1) + ')';
            }
        });
    });
});
</script>
</body>
</html>
