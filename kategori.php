<div class="container my-4">
    <div class="row">
        <div class="col-12 py-3">
            <a href="?url=album" class="btn btn-dark">Kembali</a>
        </div>
        <?php 
        $kategori = mysqli_query($conn, "SELECT * FROM foto INNER JOIN album ON foto.AlbumID=album.AlbumID WHERE foto.AlbumID='{$_GET['albumid']}'");
        foreach($kategori as $kat):
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card shadow-lg rounded-lg border-0 position-relative overflow-hidden">
                <img src="uploads/<?= $kat['NamaFile'] ?>" class="object-fit-cover img-fluid" style="aspect-ratio: 16/9; height: 250px;">
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center text-white text-center p-3">
                    <div>
                        <h5 class="card-title mb-2 text-white"><?= $kat['JudulFoto'] ?></h5>
                        <p class="card-text mb-3 text-white">Album: <span class="text-white"><?= $kat['NamaAlbum'] ?></span></p>
                        <a href="?url=detail&&id=<?= $kat['FotoID'] ?>" class="btn btn-outline-light">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- CSS -->
<style>
    .card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        border: 2px solid #ddd;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .img-fluid {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .overlay {
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
        border-radius: 12px;
    }

    .card:hover .overlay {
        opacity: 1;
    }

    .overlay .btn {
        margin-top: 10px;
    }

    .card-title,
    .card-text,
    .text-dark {
        color: white; /* Set semua teks menjadi putih */
    }
</style>
