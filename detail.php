<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $foto_id = $_GET['id'];

    $details = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID WHERE foto.FotoID='$foto_id'");
    $data = mysqli_fetch_array($details);
    $likes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID='$foto_id'"));
    $cek = 0;
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID='$foto_id' AND UserID='$user_id'"));
    }
} else {
    header("Location: page/detail.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $komentar = $_POST['komentar'];
    $foto_id = $_POST['foto_id'];
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');

    $komen = mysqli_query($conn, "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES ('$foto_id', '$user_id', '$komentar', '$tanggal')");
    
    header("Location: ?url=detail&&id=$foto_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container {
            max-width: 700px; /* Mengurangi lebar container untuk tampilan lebih kecil */
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            object-fit: cover;
            height: 400px; /* Sesuaikan ukuran sesuai keinginan */
            width: 100%;
            max-height: 500px; /* Batasi tinggi gambar */
        }
        .like-icon {
            color: red;
        }
        .comment-icon {
            color: gray;
        }
        .comment-form {
            display: none;
            margin-top: 15px;
        }
        .comment-form input {
            border-radius: 20px 0 0 20px;
        }
        .comment-form button {
            border-radius: 0 20px 20px 0;
        }
        .comment {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($data['NamaFile']) ?>" alt="<?= htmlspecialchars($data['JudulFoto']) ?>" class="card-img-top">
            <div class="card-body">
                <h3 class="card-title mb-0"><?= htmlspecialchars($data['JudulFoto']) ?></h3>
                <div class="d-flex align-items-center mb-2">
                    <a href="<?php if (isset($_SESSION['user_id'])) { echo '?url=like&&id=' . htmlspecialchars($data['FotoID']); } else { echo 'login.php'; } ?>" class="btn btn-link text-decoration-none <?php if ($cek == 0) { echo "text-secondary"; } else { echo "like-icon"; } ?>">
                        <i class="fa-solid fa-heart"></i> <?= $likes ?>
                    </a>
                    <a href="#" id="comment-icon" class="btn btn-link text-decoration-none comment-icon ms-3">
                        <i class="fa-solid fa-comment"></i>
                    </a>
                </div>
                <small class="text-muted mb-3 d-block">by: <?= htmlspecialchars($data['Username']) ?>, <?= htmlspecialchars($data['TanggalUnggah']) ?></small>
                <p><?= htmlspecialchars($data['DeskripsiFoto']) ?></p>

                <form id="comment-form" action="?url=detail&&id=<?= $foto_id ?>" method="post" class="comment-form">
                    <input type="hidden" name="foto_id" value="<?= htmlspecialchars($data['FotoID']) ?>">
                    <div class="input-group">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <input type="text" class="form-control" name="komentar" required placeholder="Masukkan komentar...">
                            <button type="submit" value="Kirim" name="submit" class="btn btn-primary">Kirim</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <?php 
            $komen = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.UserID=user.UserID WHERE komentarfoto.FotoID='$foto_id'");
            while ($komens = mysqli_fetch_array($komen)): ?>
                <div class="comment">
                    <p class="mb-0 fw-bold"><?= htmlspecialchars($komens['Username']) ?></p>
                    <p class="mb-1"><?= htmlspecialchars($komens['IsiKomentar']) ?></p>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($komens['TanggalKomentar']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('comment-icon').addEventListener('click', function(event) {
            event.preventDefault();
            var commentForm = document.getElementById('comment-form');
            if (commentForm.style.display === 'none' || commentForm.style.display === '') {
                commentForm.style.display = 'block';
            } else {
                commentForm.style.display = 'none';
            }
        });
    </script>
</body>
</html>
