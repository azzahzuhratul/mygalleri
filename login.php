<?php 
include 'koneksi.php'; 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY GALLERY WEB</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .form-bg {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .form-container {
            font-family: 'Overpass', sans-serif;
        }

        .form-container .form-horizontal {
            background: linear-gradient(45deg, rgba(0, 123, 255, 0.5), rgba(255, 215, 0, 0.5));
            width: 350px;
            height: 350px;
            padding: 75px 55px;
            margin: 0 auto;
            border-radius: 50%;
            position: relative;
        }

        .form-container .title {
            color: #000000;
            font-family: 'Teko', sans-serif;
            font-size: 35px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 10px 0;
        }

        .form-horizontal .form-group {
            background-color: rgba(255, 255, 255, 0.15);
            font-size: 0;
            margin: 0 0 15px;
            border: 1px solid #ffffff;
            border-radius: 3px;
            position: relative;
        }

        .form-horizontal .input-icon {
            color: #000000;
            font-size: 16px;
            text-align: center;
            line-height: 48px;
            height: 45px;
            width: 40px;
            vertical-align: top;
            display: inline-block;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .form-horizontal .form-control {
            color: #000000; 
            background-color: transparent;
            font-size: 14px;
            letter-spacing: 1px;
            width: calc(100% - 55px);
            height: 45px;
            padding-left: 45px;
            box-shadow: none;
            border: none;
            border-radius: 0;
            display: inline-block;
            transition: all 0.3s;
            border-bottom: 2px solid transparent;
        }

        .form-horizontal .form-control:focus {
            border-bottom: 2px solid #00A896;
            outline: none;
            color: #000000; 
        }

        .form-horizontal .form-control::placeholder {
            color: #888888; /* Warna placeholder */
        }

        .form-horizontal .btn {
            color: rgba(255, 255, 255, 0.8);
            background: rgba(0, 150, 136, 0.95);
            font-size: 15px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 120px;
            height: 120px;
            line-height: 120px;
            margin: 0 0 15px 0;
            border: none;
            border-radius: 50%;
            display: inline-block;
            transform: translateX(30px);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .form-horizontal .btn:hover,
        .form-horizontal .btn:focus {
            color: #fff;
            letter-spacing: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            animation: none; 
        }

        .form-horizontal .forgot-pass {
            font-size: 12px;
            text-align: left;
            width: calc(100% - 125px);
            display: inline-block;
            vertical-align: top;
        }

        .form-horizontal .forgot-pass a {
            color: #000000;
            transition: all 0.3s ease;
        }

        .form-horizontal .forgot-pass a:hover {
            color: #888888;
            text-decoration: underline;
        }

        #message {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        @media only screen and (max-width: 379px) {
            .form-container .form-horizontal {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="form-bg">
        <div class="form-container">
            <form class="form-horizontal" action="login.php" method="post">
                <h3 class="title">Login</h3>
                
                <div class="form-group">
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                    <input class="form-control" type="text" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input class="form-control" type="password" placeholder="Password" name="password" required>
                </div>

                <span class="forgot-pass"><a href="daftar.php">Belum punya akun? Register</a></span>
                <button type="submit" class="btn signin" name="submit" value="Login">Login</button>

                <div id="message"></div> <!-- Pesan login muncul di sini -->
            </form>

            <?php 
            // Proses login
            $submit = @$_POST['submit'];
            if($submit == 'Login'){
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                
                $sql = mysqli_query($conn, "SELECT * FROM user WHERE Username='$username' AND Password='$password'");
                $cek = mysqli_num_rows($sql);
                if ($cek != 0) {
                    $sesi = mysqli_fetch_array($sql);
                    echo "<script>document.getElementById('message').style.color = 'green'; document.getElementById('message').innerHTML = 'Login Berhasil!';</script>";
                    $_SESSION['username'] = $sesi['Username'];
                    $_SESSION['user_id'] = $sesi['UserID'];
                    $_SESSION['email'] = $sesi['Email'];
                    $_SESSION['nama_lengkap'] = $sesi['NamaLengkap'];
                    echo '<meta http-equiv="refresh" content="1; url=./">';
                } else {
                    echo "<script>document.getElementById('message').style.color = 'red'; document.getElementById('message').innerHTML = 'Login Gagal!';</script>";
                    echo '<meta http-equiv="refresh" content="2; url=login.php">';
                }
            }
            ?>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
