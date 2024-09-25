<div class="container my-4 p-5 bg-hero rounded position-relative">
    <!-- SVG Hiasan -->
    <svg class="position-absolute top-0 end-0 m-3" width="48" height="48" viewBox="0 0 24 24">
        <path d="M12 0L15.09 8.26H23.636L16.637 13.62L19.728 21.88L12 16.52L4.272 21.88L7.364 13.62L0.364 8.26H8.91L12 0Z" fill="rgba(255, 215, 0, 0.3)"/>
    </svg>

    <div class="py-5 text-black text-center">
        <p class="display-5 fw-bold font-latin" style="letter-spacing: 2px;">Galeri Foto</p>
        <p class="fs-4 col-md-8 mx-auto">Galeri Foto ini adalah kumpulan momen berharga yang tertangkap oleh lensa, setiap gambar bercerita tentang keindahan, emosi, dan kenangan yang tak terlupakan</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php 
        $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID");
        foreach($tampil as $tampils):
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card shadow-lg rounded-lg hover-zoom position-relative overflow-hidden border border-secondary">
                <img src="uploads/<?= $tampils['NamaFile'] ?>" class="object-fit-cover rounded-top img-fluid" style="aspect-ratio: 16/9;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?= $tampils['JudulFoto'] ?></h5>
                    <p class="card-text text-muted">by: <?= $tampils['Username'] ?></p>
                </div>
                <!-- Overlay -->
                <div class="overlay d-flex justify-content-center align-items-center">
                    <div class="text-white text-center">
                        <h5 class="card-title"><?= $tampils['JudulFoto'] ?></h5>
                        <p class="card-text">by: <?= $tampils['Username'] ?></p>
                        <a href="?url=detail&&id=<?= $tampils['FotoID'] ?>" class="btn btn-outline-light">Lihat foto</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- CSS -->
<style>
    .bg-hero {
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.5), rgba(255, 215, 0, 0.5));
        color: white;
    }

    .font-latin {
        font-family: 'Georgia', 'Times New Roman', Times, serif;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .hover-zoom img {
        transition: transform 0.3s ease, filter 0.3s ease;
        filter: brightness(80%);
    }

    .hover-zoom:hover img {
        transform: scale(1.05);
        filter: brightness(100%);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card:hover .overlay {
        opacity: 1;
    }

    .overlay .btn {
        margin-top: 10px;
    }

    .border-secondary {
        border: 2px solid #ddd;
        padding: 5px;
        border-radius: 12px;
    }

    .card-body {
        padding: 15px;
    }

    .card-title {
        margin-bottom: 10px;
    }

    .card-text.text-muted {
        color: white; 
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
