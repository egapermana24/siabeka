<?php
include '../database/koneksi.php';

$id_user = $_POST['id_user'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$tanggal_lahir = $_POST['tanggal_lahir'];

// Periksa apakah username sudah ada di database untuk user lain
$checkUsernameQuery = "SELECT * FROM tb_user WHERE username = '$username' AND id_user != '$id_user'";
$result = mysqli_query($conn, $checkUsernameQuery);

if (mysqli_num_rows($result) > 0) {
  echo '<script>alert("Username sudah digunakan.");document.location="index.php";</script>';
} else {
  // Username belum digunakan, lanjutkan dengan proses update
  $query = "UPDATE tb_user SET nama = '$nama', username = '$username', tanggal_lahir = '$tanggal_lahir' WHERE id_user = '$id_user'";
  if (mysqli_query($conn, $query)) {
    echo '<script>document.location="index.php";</script>';
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
}
?>
