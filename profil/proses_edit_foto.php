<?php
include '../database/koneksi.php';
require_once '../vendor/autoload.php'; // Load library Imagine

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Gd\Imagine;

$id_user = $_POST['id_user'];
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$fotobaru = date('dmYHis') . $foto;
$path = "../assets/img/" . $fotobaru;

// Validasi folder
if (!file_exists('../assets/img/')) {
  // Jika folder belum ada, buat folder baru
  mkdir('../assets/img/', 0777, true);
}

if (move_uploaded_file($tmp, $path)) {
  // Load gambar yang diupload
  $imagine = new Imagine();
  $image = $imagine->open($path);

  // Mengambil dimensi gambar
  $width = $image->getSize()->getWidth();
  $height = $image->getSize()->getHeight();

  // Tentukan ukuran persegi yang diinginkan (misalnya 300x300)
  $squareSize = min($width, $height);

  // Crop gambar menjadi persegi
  $image->crop(new Point(($width - $squareSize) / 2, ($height - $squareSize) / 2), new Box($squareSize, $squareSize))
    ->save($path);

  // Validasi apakah foto lama sudah ada
  $queryFotoLama = mysqli_query($conn, "SELECT foto FROM tb_user WHERE id_user = '$id_user'");
  if ($queryFotoLama && mysqli_num_rows($queryFotoLama) > 0) {
    $row = mysqli_fetch_array($queryFotoLama);
    $fotoLama = $row['foto'];
    // Hapus foto lama jika ada
    if (!empty($fotoLama) && file_exists("../assets/img/" . $fotoLama)) {
      unlink("../assets/img/" . $fotoLama);
    }
  }

  $query = "UPDATE tb_user SET foto = '$fotobaru' WHERE id_user = '$id_user'";
  if (mysqli_query($conn, $query)) {
    echo '<script>document.location="index.php";</script>';
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
} else {
  // alert dan kembali ke halaman sebelumnya
  echo '<script>alert("Maaf, Gambar gagal untuk diupload.");document.location="index.php";</script>';
}
?>
