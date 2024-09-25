<?php

$foto_id = @$_GET['id'];
$user_id = @$_SESSION['user_id'];


$cek = mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID='$foto_id' AND UserID='$user_id'");
if (mysqli_num_rows($cek) == 0) {
   
    $tanggal = date('Y-m-d');
    $like = mysqli_query($conn, "INSERT INTO likefoto (FotoID, UserID, Tanggal) VALUES ('$foto_id', '$user_id', '$tanggal')");
    if ($like) {
        header("Location: ?url=detail&&id=$foto_id");
    } else {
       
        echo "Terjadi kesalahan saat menyimpan data.";
    }
} else {
   
    $dislike = mysqli_query($conn, "DELETE FROM likefoto WHERE FotoID='$foto_id' AND UserID='$user_id'");
    if ($dislike) {
        header("Location: ?url=detail&&id=$foto_id");
    } else {
      
        echo "Terjadi kesalahan saat menghapus data.";
    }
}
?>
