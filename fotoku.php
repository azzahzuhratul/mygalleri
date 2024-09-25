<?php
session_start();
include 'koneksi.php';

// Pastikan user_id diambil dengan benar
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo '<div class="alert alert-danger">Anda harus login untuk melihat foto.</div>';
    exit;
}

// Ambil foto dari database
$fotos = $conn->query("SELECT * FROM foto WHERE UserID='$user_id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Ganti dengan path Bootstrap Anda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>Galeri Foto Saya</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .gallery-item {
            flex: 1 0 21%; /* Ukuran item gallery */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 5px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.1); /* Zoom effect */
        }
        .gallery-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<div class="container mt-4 position-relative">
    <h2>Galeri Foto Saya</h2>
    <div class="gallery">
        <?php while ($foto = $fotos->fetch_assoc()) : ?>
            <div class="gallery-item">
                <img src="uploads/<?= htmlspecialchars($foto['NamaFile']) ?>" alt="<?= htmlspecialchars($foto['JudulFoto']) ?>">
            </div>
        <?php endwhile; ?>
    </div>
    <a href="index.php?url=profile" class="btn btn-primary" style="position: absolute; top: 20px; right: 20px;">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>

<script src="path/to/bootstrap.bundle.min.js"></script> 
</body>
</html>
