<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MY GALLERY WEB</title>
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">
   <style>
      body {
          background-color: #f8f9fa; 
          font-family: Arial, sans-serif;
      }
      .container {
          margin-top: 5rem;
      }
      .card {
          border-radius: 10px;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }
      .card-body {
          padding: 2rem;
      }
      .card-title {
          margin-bottom: 1.5rem;
          font-weight: bold;
          color: #343a40;
          text-align: center;
      }
      .form-control {
          border-radius: 5px;
          border: 1px solid #ced4da;
          transition: border-color 0.3s;
      }
      .form-control:focus {
          border-color: #007bff;
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      }
      .btn-danger {
          background-color: #007bff; 
          border-color: #007bff;
          width: 100%;
          padding: 10px;
      }
      .btn-danger:hover {
          background-color: #0056b3;
          border-color: #004085;
      }
      .link-danger {
          color: #007bff;
          text-decoration: underline;
      }
      .link-danger:hover {
          color: #0056b3;
      }
      @media (max-width: 576px) {
          .col-5 {
              width: 90%;
          }
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
         <div class="col-5">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title">DAFTARKAN AKUN ANDA</h4>
                  
                  <?php
                  //ambil data yang di kirim kan oleh <form> dengan method post
                  $submit = @$_POST['submit'];
                  if ($submit == 'Daftar') {
                     $username = @$_POST['username'];
                     $password = md5(@$_POST['password']);
                     $email = @$_POST['email'];
                     $nama_lengkap = @$_POST['nama_lengkap'];
                     $alamat = @$_POST['alamat'];
                     
                     $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE Username='$username' OR Email='$email' "));
                     if ($cek == 0) {
                        mysqli_query($conn, "INSERT INTO user (Username, Password, Email, NamaLengkap, Alamat) VALUES ('$username', '$password', '$email', '$nama_lengkap', '$alamat')");
                        echo 'Daftar Berhasil, Silahkan Login!!';
                        echo '<meta http-equiv="refresh" content="0.8; url=login.php">';
                     } else {
                        echo 'Maaf Akun Sudah Ada';
                        echo '<meta http-equiv="refresh" content="0.8; url=daftar.php">';
                     }
                  }
                  ?>
                  <form action="daftar.php" method="post">
                     <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                     </div>
                     <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                     </div>
                     <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" required>
                     </div>
                     <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" required>
                     </div>
                     <input type="submit" value="Daftar" class="btn btn-danger my-3" name="submit">
                     <p>Sudah Punya Akun? <a href="login.php" class="link-danger">Login Sekarang</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
