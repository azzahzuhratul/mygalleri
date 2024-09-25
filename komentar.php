<?php
// Koneksi database sudah di sini

$foto_id = @$_GET["id"];
$user_id = @$_SESSION["user_id"];
$komen_id = @$_GET['komentar_id'];

// Mengecek apakah pengguna memiliki hak untuk menghapus komentar
$cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM komentarfoto WHERE UserID='$user_id' AND FotoID='$foto_id' AND KomentarID='$komen_id'"));

if ($cek > 0) {
    $delete = mysqli_query($conn, "DELETE FROM komentarfoto WHERE KomentarID='$komen_id'");
    echo '<script>alert("Anda berhasil menghapus komentar ini");</script>';
    echo '<meta http-equiv="refresh" content="0; url=?url=detail&&id=' . @$foto_id . '">';
} else {
    // User tidak berhak menghapus komentar
    echo '<script>alert("Anda tidak berhak menghapus komentar ini");</script>';
    echo '<meta http-equiv="refresh" content="0; url=?url=detail&&id=' . @$foto_id . '">';
}

// Ambil data foto untuk ditampilkan di halaman
$foto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM foto WHERE FotoID='$foto_id'"));

// Ambil semua komentar terkait foto ini
$komentar_query = mysqli_query($conn, "SELECT k.*, u.Username FROM komentarfoto k JOIN user u ON k.UserID = u.UserID WHERE k.FotoID = '$foto_id' ORDER BY k.TanggalKomentar DESC");
?>

<!-- HTML untuk menampilkan detail foto -->
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8">
            <img src="uploads/<?= $foto['LokasiFile'] ?>" alt="<?= $foto['JudulFoto'] ?>" class="img-fluid">
            <h3><?= $foto['JudulFoto'] ?></h3>
            <p><?= $foto['DeskripsiFoto'] ?></p>
        </div>
        <div class="col-12 col-md-4">
            <h4>Komentar</h4>
           
            <form action="komen.php" method="post">
                <input type="hidden" name="foto_id" value="<?= $foto_id ?>">
                <div class="form-group">
                    <textarea name="isi_komentar" class="form-control" placeholder="Tulis komentar Anda..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
           
            <div class="list-komentar mt-4">
                <?php while ($komentar = mysqli_fetch_assoc($komentar_query)) : ?>
                    <div class="komentar">
                        <strong><?= $komentar['Username'] ?></strong> <small><?= $komentar['TanggalKomentar'] ?></small>
                        <p><?= $komentar['IsiKomentar'] ?></p>
                        <!-- Tampilkan tombol hapus hanya jika komentar dibuat oleh pengguna yang sedang login -->
                        <?php if ($komentar['UserID'] == $user_id) : ?>
                            <a href="?url=detail&id=<?= $foto_id ?>&komentar_id=<?= $komentar['KomentarID'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                        <?php endif; ?>
                    </div>
                    <hr>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
