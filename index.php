<?php include 'koneksi.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY GALLERY WEB</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Navbar vertikal di samping kiri */
        .navbar-vertical {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            font-family: 'Arial', sans-serif;
        }

        /* Teks pada navbar */
        .navbar-vertical a.nav-link {
            color: #fff;
            padding: 15px 20px;
            width: 100%;
            text-align: left;
            font-size: 18px;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 5px 0;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        /* Ikon di sebelah teks */
        .navbar-vertical a.nav-link i {
            margin-right: 10px;
        }

        /* Efek hover yang lebih smooth */
        .navbar-vertical a.nav-link:hover {
            background-color: #f1c40f;
            color: #333;
        }

        /* Link yang sedang aktif */
        .navbar-vertical a.nav-link.active {
            background-color: #444;
            color: #fff;
        }

        /* Konten utama */
        .content {
            margin-left: 260px;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        /* Brand styling */
        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 30px;
            padding: 0 20px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <!-- Navbar vertikal -->
    <nav class="navbar-vertical">
        <a class="navbar-brand" href="?url=home">MYGALLERI</a>
        <a class="nav-link <?= $url == 'home' ? 'active' : '' ?>" href="?url=home">
            <i class="fas fa-home"></i> Home
        </a>
        <?php if(isset($_SESSION['user_id'])): ?>
        <a class="nav-link <?= $url == 'upload' ? 'active' : '' ?>" href="?url=upload">
            <i class="fas fa-upload"></i> Upload
        </a>
        <a class="nav-link <?= $url == 'album' ? 'active' : '' ?>" href="?url=album">
            <i class="fas fa-images"></i> Album
        </a>
        <a class="nav-link <?= $url == 'profile' ? 'active' : '' ?>" href="?url=profile">
            <i class="fas fa-user"></i> <?= ucwords($_SESSION['username']) ?>
        </a>
        <a class="nav-link <?= $url == 'logout' ? 'active' : '' ?>" href="?url=logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <?php else: ?>
        <a class="nav-link <?= $url == 'login' ? 'active' : '' ?>" href="login.php">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
        <?php endif; ?>
    </nav>

    <!-- Konten utama -->
    <div class="content">
        <?php 
            $url=@$_GET["url"];
            if($url=='home'){
                include 'page/home.php';
            }elseif($url=='profile'){
                include 'page/profil.php';
            }else if($url=='upload'){
                include 'page/upload.php';
            }else if($url=='album'){
                include 'page/album.php';
            }else if($url=='like'){
                include 'page/like.php';
            }else if($url=='komentar'){
                include 'page/komentar.php';
            }else if($url=='detail'){
                include 'page/detail.php';
            }else if($url=='kategori'){
                include 'page/kategori.php';
            }else if($url=='logout'){
                session_destroy();
                header("Location: login.php"); 
                exit(); 
            }else{
                include 'page/home.php';
            }
        ?>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
