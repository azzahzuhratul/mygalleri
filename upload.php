<?php

include 'koneksi.php';

if (isset($_GET['delete'])) {
    $fotoid = $_GET['fotoid'];

    $result = $conn->prepare("SELECT NamaFile FROM foto WHERE FotoID=?");
    $result->bind_param('i', $fotoid);
    $result->execute();
    $file_data = $result->get_result()->fetch_assoc();
    $file_name = $file_data['NamaFile'];

    $delete = $conn->prepare("DELETE FROM foto WHERE FotoID=?");
    $delete->bind_param('i', $fotoid);

    if ($delete->execute()) {
        if (file_exists('uploads/' . $file_name)) {
            unlink('uploads/' . $file_name);
        }
        $alert = 'Gambar berhasil dihapus';
    } else {
        $alert = 'Gambar gagal dihapus';
    }
    echo '<div class="alert alert-info">' . $alert . '</div>';
    echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
}
if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    $fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : '';
    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $album_id = $_POST['album_id'];
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');

    if ($submit == 'Simpan') {
        $nama_file = $_FILES['namafile']['name'];
        $tmp_foto = $_FILES['namafile']['tmp_name'];

        // Validasi jenis file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($nama_file, PATHINFO_EXTENSION);
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($tmp_foto, 'uploads/' . $nama_file)) {
                $insert = $conn->prepare("INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, NamaFile, AlbumID, UserID) VALUES (?, ?, ?, ?, ?, ?)");
                $insert->bind_param('ssssii', $judul_foto, $deskripsi_foto, $tanggal, $nama_file, $album_id, $user_id);

                if ($insert->execute()) {
                    $alert = 'Gambar berhasil disimpan';
                } else {
                    $alert = 'Gambar gagal disimpan';
                }
            } else {
                $alert = 'Gambar gagal disimpan';
            }
        } else {
            $alert = 'File harus berupa: *.jpg, *.png, *.gif';
        }
        echo '<div class="alert alert-info">' . $alert . '</div>';
        echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
    } elseif (isset($_GET['edit'])) {
        if ($submit == "Ubah") {
            $nama_file = $_FILES['namafile']['name'];
            $tmp_foto = $_FILES['namafile']['tmp_name'];

            if (strlen($nama_file) == 0) {
                $update = $conn->prepare("UPDATE foto SET JudulFoto=?, DeskripsiFoto=?, TanggalUnggah=?, AlbumID=? WHERE FotoID=?");
                $update->bind_param('sssii', $judul_foto, $deskripsi_foto, $tanggal, $album_id, $fotoid);
            } else {
                // Validasi jenis file
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $file_extension = pathinfo($nama_file, PATHINFO_EXTENSION);
                if (in_array($file_extension, $allowed_types)) {
                    if (move_uploaded_file($tmp_foto, "uploads/" . $nama_file)) {
                        $update = $conn->prepare("UPDATE foto SET JudulFoto=?, DeskripsiFoto=?, NamaFile=?, TanggalUnggah=?, AlbumID=? WHERE FotoID=?");
                        $update->bind_param('ssssii', $judul_foto, $deskripsi_foto, $nama_file, $tanggal, $album_id, $fotoid);
                    } else {
                        $alert = 'Gambar gagal disimpan';
                        echo '<div class="alert alert-danger">' . $alert . '</div>';
                    }
                } else {
                    $alert = 'File harus berupa: *.jpg, *.png, *.gif';
                    echo '<div class="alert alert-danger">' . $alert . '</div>';
                }
            }
            if (isset($update) && $update->execute()) {
                $alert = 'Gambar berhasil diubah';
            } else {
                $alert = 'Gambar gagal diubah';
            }
            echo '<div class="alert alert-info">' . $alert . '</div>';
            echo '<meta http-equiv="refresh" content="0.8; url=?url=upload">';
        }
    }
}

// Ambil data album dan foto
$album = $conn->query("SELECT * FROM album WHERE UserID='" . $_SESSION['user_id'] . "'");
$val = isset($_GET['fotoid']) ? $conn->query("SELECT * FROM foto WHERE FotoID='" . $_GET['fotoid'] . "'")->fetch_assoc() : null;
?>

<div class="container">
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <h4>Halaman Upload</h4>
                    <?php if (!isset($_GET['edit'])) : ?>
                        <form action="?url=upload" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" required name="judul_foto">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control" required>
                                <small class="text-danger">File harus berupa: *.jpg, *.png, *.gif</small>
                            </div>
                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select">
                                    <?php foreach ($album as $albums) : ?>
                                        <option value="<?= $albums['AlbumID'] ?>"><?= htmlspecialchars($albums['NamaAlbum']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="submit" value="Simpan" name="submit" class="btn btn-danger my-3">
                        </form>
                    <?php elseif (isset($_GET['edit'])) : ?>
                        <form action="?url=upload&&edit&&fotoid=<?= $val['FotoID'] ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul Foto</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($val['JudulFoto']) ?>" required name="judul_foto">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Foto</label>
                                <textarea name="deskripsi_foto" class="form-control" required cols="30" rows="5"><?= htmlspecialchars($val['DeskripsiFoto']) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" name="namafile" class="form-control">
                                <small class="text-danger">File hanya berupa: *.jpg, *.png, *.gif</small>
                            </div>
                            <div class="form-group">
                                <label>Pilih Album</label>
                                <select name="album_id" class="form-select">
                                    <?php foreach ($album as $albums) : ?>
                                        <option value="<?= $albums['AlbumID'] ?>" <?= $albums['AlbumID'] == $val['AlbumID'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($albums['NamaAlbum']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="submit" value="Ubah" name="submit" class="btn btn-danger my-3">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="row">
                <?php
                $fotos = $conn->query("SELECT * FROM foto WHERE UserID='" . $_SESSION['user_id'] . "'");
                foreach ($fotos as $foto) :
                ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="card">
                            <img src="uploads/<?= htmlspecialchars($foto['NamaFile']) ?>" class="object-fit-cover" style="aspect-ratio: 16/9;">
                            <div class="card-body">
                                <p class="small"><?= htmlspecialchars($foto['JudulFoto']) ?></p>
                                <a href="?url=upload&&edit&&fotoid=<?= $foto['FotoID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?url=upload&&delete&&fotoid=<?= $foto['FotoID'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
