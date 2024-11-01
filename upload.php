<?php
session_start();
include 'config.php'; // Pastikan file koneksi ke database sudah ada

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judulFoto = mysqli_real_escape_string($conn, $_POST['judulFoto']);
    $deskripsiFoto = mysqli_real_escape_string($conn, $_POST['deskripsiFoto']);
    $albumID = $_POST['albumID'];
    $userID = $_SESSION['user_id']; // ID pengguna yang login
    $uploadOk = 1;
    $error = "";

    // File upload handling
    $target_dir = "uploads/";
    $file_name = uniqid() . "_" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file yang diunggah adalah gambar
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        $error = "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        $error = "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Batasan format file
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        $error = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Proses unggah file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO gallery_foto (JudulFoto, DeskripsiFoto, LokasiFile, AlbumID, UserID, TanggalUnggah)
                      VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssii", $judulFoto, $deskripsiFoto, $file_name, $albumID, $userID);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "File berhasil diunggah.";
                header('Location: index.php');
            } else {
                $error = "Gagal menyimpan data ke database.";
            }
            $stmt->close();
        } else {
            $error = "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto ke Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Upload Foto ke Gallery</h2>

        <!-- Notifikasi pesan kesalahan atau sukses -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <!-- Form Upload -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judulFoto" class="form-label">Judul Foto</label>
                <input type="text" class="form-control" id="judulFoto" name="judulFoto" required>
            </div>
            <div class="mb-3">
                <label for="deskripsiFoto" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsiFoto" name="deskripsiFoto" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="albumID" class="form-label">Pilih Album</label>
                <select class="form-select" id="albumID" name="albumID" required>
                    <?php
                    $albumQuery = "SELECT * FROM albums";
                    $albumResult = mysqli_query($conn, $albumQuery);
                    while ($albumRow = mysqli_fetch_assoc($albumResult)) {
                        echo "<option value='{$albumRow['AlbumID']}'>{$albumRow['album_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Pilih Gambar untuk Diupload</label>
                <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah Gambar</button>
            
        </form>
    </div>
    
</body>
</html>
