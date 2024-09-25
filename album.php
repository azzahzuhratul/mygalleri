<div class="container my-4 p-4 bg-light rounded shadow">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Kelola Album</h4>
                    <?php 
                   
                    $submit = @$_POST['submit'];
                    $albumID = @$_GET['albumid'];
                    
                    if ($submit == 'Simpan') {
                        $nama_album = @$_POST['nama_album'];
                        $deskripsi_album = @$_POST['deskripsi_album'];
                        $tanggal = date('Y-m-d');
                        $user_id = @$_SESSION['user_id'];
                        $insert = mysqli_query($conn, "INSERT INTO album VALUES('', '$nama_album', '$deskripsi_album', '$tanggal', '$user_id')");
                        if ($insert) {
                            echo '<div class="alert alert-success">Berhasil Membuat Album</div>';
                            echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                        } else {
                            echo '<div class="alert alert-danger">Gagal Membuat Album</div>';
                            echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                        }
                    } elseif (isset($_GET['edit'])) {
                        if ($submit == 'Ubah') {
                            $nama_album = @$_POST['nama_album'];
                            $deskripsi_album = @$_POST['deskripsi_album'];
                            $update = mysqli_query($conn, "UPDATE album SET NamaAlbum='$nama_album', Deskripsi='$deskripsi_album' WHERE AlbumID='$albumID'");
                            if ($update) {
                                echo '<div class="alert alert-success">Berhasil Mengubah Album</div>';
                                echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                            } else {
                                echo '<div class="alert alert-danger">Gagal Mengubah Album</div>';
                                echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                            }
                        }
                    } elseif (isset($_GET['hapus'])) {
                        $hapus = mysqli_query($conn, "DELETE FROM album WHERE AlbumID='$albumID'");
                        if ($hapus) {
                            echo '<div class="alert alert-success">Berhasil Hapus Album</div>';
                            echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                        } else {
                            echo '<div class="alert alert-danger">Gagal Hapus Album</div>';
                            echo '<meta http-equiv="refresh" content="1; url=?url=album">';
                        }
                    }
                    $val = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM album WHERE AlbumID='$albumID'"));
                    ?>

                    <?php if (!isset($_GET['edit'])): ?>
                    <form action="?url=album" method="post">
                        <div class="form-group">
                            <label for="nama_album">Nama Album</label>
                            <input type="text" id="nama_album" class="form-control" required name="nama_album">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_album">Deskripsi Album</label>
                            <textarea id="deskripsi_album" name="deskripsi_album" class="form-control" required cols="30" rows="3"></textarea>
                        </div>
                        <button type="submit" value="Simpan" name="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                    <?php elseif (isset($_GET['edit'])): ?>
                    <form action="?url=album&&edit&&albumid=<?= $val['AlbumID'] ?>" method="post">
                        <div class="form-group">
                            <label for="nama_album">Nama Album</label>
                            <input type="text" id="nama_album" class="form-control" value="<?= $val['NamaAlbum'] ?>" required name="nama_album">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_album">Deskripsi Album</label>
                            <textarea id="deskripsi_album" name="deskripsi_album" class="form-control" required cols="30" rows="3"><?= $val['Deskripsi'] ?></textarea>
                        </div>
                        <button type="submit" value="Ubah" name="submit" class="btn btn-primary mt-3">Ubah</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bagian Tabel Album -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Daftar Album</h5>
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Album</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $userid = @$_SESSION['user_id'];
                            $albums = mysqli_query($conn, "SELECT * FROM album WHERE UserID='$userid'");
                            foreach ($albums as $album): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $album['NamaAlbum'] ?></td>
                                <td><?= $album['Deskripsi'] ?></td>
                                <td><?= $album['TanggalDibuat'] ?></td>
                                <td>
                                    <a href="?url=album&&edit&&albumid=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?url=album&&hapus&&albumid=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                                    <a href="?url=kategori&&albumid=<?= $album['AlbumID'] ?>" class="btn btn-sm btn-success">Lihat Foto</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</style>
