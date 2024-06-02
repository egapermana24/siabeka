<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_user = $_POST['id_user'];
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $level = $_POST['level'];

  // Validasi data (contoh: pastikan tidak ada field yang kosong)

  if (empty($nama) || empty($username) || empty($level)) {
    echo '<script>alert("Nama, Username, dan Level tidak boleh kosong!"); document.location="index.php";</script>';
  } else {
    // Query untuk melakukan update data pengguna
    $query = "UPDATE tb_user SET nama='$nama', username='$username', level='$level' WHERE id_user='$id_user'";

    if (mysqli_query($conn, $query)) {
      // Jika update berhasil, redirect ke halaman semuapengguna
      echo '<script>alert("Data pengguna berhasil diupdate.");document.location="../semuapengguna/";</script>';
    } else {
      // Jika update gagal, tampilkan pesan error
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST, redirect ke halaman semuapengguna
  echo '<script>alert("Akses tidak sah.");document.location="../semuapengguna/";</script>';
}
?>
