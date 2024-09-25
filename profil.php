
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Profil Pengguna</h2>
                    <?php
                    // Ambil data user dari database
                    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE UserID='{$_SESSION['user_id']}'"));

                    // Proses update profil 
                    if (isset($_POST['editprofile'])) {
                        $ubah = false;
                        $nama = $_POST['nama'];
                        $email = $_POST['email'];
                        $username = $_POST['username'];
                        $alamat = $_POST['alamat'];
                        $profile_picture = $_FILES['profile_picture']['name'];

                        // Proses upload foto profil jika ada
                        if (!empty($profile_picture)) {
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($profile_picture);
                            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                                // Update kolom profile_picture
                                $ubah = mysqli_query($conn, "UPDATE user SET profile_picture='$profile_picture' WHERE UserID='{$_SESSION['user_id']}'");
                            }
                        }

                        // Update data profil lainnya jika ada perubahan
                        if ($nama !== $user['NamaLengkap']) {
                            $ubah = mysqli_query($conn, "UPDATE user SET NamaLengkap='$nama' WHERE UserID='{$_SESSION['user_id']}'");
                        }
                        if ($email !== $user['Email']) {
                            $ubah = mysqli_query($conn, "UPDATE user SET Email='$email' WHERE UserID='{$_SESSION['user_id']}'");
                        }
                        if ($username !== $user['Username']) {
                            $ubah = mysqli_query($conn, "UPDATE user SET Username='$username' WHERE UserID='{$_SESSION['user_id']}'");
                        }
                        if ($alamat !== $user['Alamat']) {
                            $ubah = mysqli_query($conn, "UPDATE user SET Alamat='$alamat' WHERE UserID='{$_SESSION['user_id']}'");
                        }

                        // Update session data jika ada perubahan
                        if ($ubah) {
                            $session = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE UserID='{$_SESSION['user_id']}'"));
                            $_SESSION['userid'] = $session['UserID'];
                            $_SESSION['username'] = $session['Username'];
                            $_SESSION['namalengkap'] = $session['NamaLengkap'];
                            $_SESSION['email'] = $session['Email'];

                            echo '<div class="alert alert-success">Ubah profil berhasil</div>';
                            echo '<meta http-equiv="refresh" content="0.8; url=?url=profile&&proses=editprofile">';
                        } else {
                            echo '<div class="alert alert-danger">Ubah profil gagal</div>';
                        }
                    }
                    ?>

                    <?php if (@$_GET['proses'] == 'editprofile') : ?>
                        <form action="?url=profile&&proses=editprofile" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label"><i class="fa-solid fa-image"></i> Foto Profil</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                <?php if (!empty($user['profile_picture'])) : ?>
                                    <img src="uploads/<?= $user['profile_picture'] ?>" alt="Foto Profil" class="img-thumbnail mt-2 rounded-circle profile-img" width="150">
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label"><i class="fa-solid fa-circle-user"></i> Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['NamaLengkap'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['Email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label"><i class="fa-solid fa-user"></i> Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $user['Username'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><i class="fa-solid fa-location-dot"></i> Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $user['Alamat'] ?>" required>
                            </div>
                            <a href="?url=profile" class="btn btn-dark">Kembali</a>
                            <button type="submit" name="editprofile" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    <?php else : ?>
                        <!-- Tampilkan Profil -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="profile-details">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-circle-user"></i> Nama </th>
                                            <td><?= $user['NamaLengkap'] ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-envelope"></i> Email</th>
                                            <td><?= $user['Email'] ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-user"></i> Username</th>
                                            <td><?= $user['Username'] ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-location-dot"></i> Alamat</th>
                                            <td><?= $user['Alamat'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="profile-img-container">
                                <?php if (!empty($user['profile_picture'])) : ?>
                                    <img src="uploads/<?= $user['profile_picture'] ?>" alt="Foto Profil" class="img-thumbnail profile-img rounded-circle shadow">
                                <?php else : ?>
                                    <span>Belum ada foto profil</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <a href="?url=profile&&proses=editprofile" class="btn btn-danger">Edit Profil</a>
                            <a href="fotoku.php" class="btn btn-success">My Foto</a> <!-- Tombol My Foto -->
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk tampilan lebih menarik -->
<style>
body {
    background-color: #f4f6f9;
    font-family: 'Poppins', sans-serif;
}
.card {
    background-color: #fff;
    border-radius: 12px;
    padding: 20px;
}
.table-borderless th {
    width: 150px;
}
.profile-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}
.profile-img:hover {
    transform: scale(1.1);
}
.profile-details th {
    font-weight: bold;
    font-size: 1.1em;
}
.btn {
    padding: 10px 20px;
    font-size: 1em;
    border-radius: 50px;
    transition: background-color 0.3s ease;
}
.btn:hover {
    background-color: #495057;
    color: #fff;
}
</style>

<!-- JavaScript untuk zoom gambar -->
<script>
var modal = document.getElementById("zoomModal");
var img = document.querySelector(".profile-img");
var modalImg = document.getElementById("zoomedImage");
var captionText = document.getElementById("caption");

img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
    modal.style.display = "none";
}
</script>
