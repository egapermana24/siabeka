<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_user'])) {
  $id_user = $_POST['id_user'];

  // Hapus data pengguna dari tabel tb_user
  $deleteUserQuery = "DELETE FROM tb_user WHERE id_user='$id_user'";
  if (mysqli_query($conn, $deleteUserQuery)) {
    // Hapus data pengguna dari tabel waktu_kerja_tersedia
    $deleteWaktuQuery = "DELETE FROM waktu_kerja_tersedia WHERE id_user='$id_user'";
    mysqli_query($conn, $deleteWaktuQuery); // Tidak memerlukan penanganan khusus jika query ini gagal, karena data tidak wajib ada di tabel ini

    // Hapus data pengguna dari tabel norma_waktu_komponen
    $deleteNormaQuery = "DELETE FROM norma_waktu_komponen WHERE id_user='$id_user'";
    mysqli_query($conn, $deleteNormaQuery); // Tidak memerlukan penanganan khusus jika query ini gagal, karena data tidak wajib ada di tabel ini

    // Redirect ke halaman semuapengguna setelah sukses menghapus
    echo '<script>alert("Data pengguna berhasil dihapus.");document.location="../semuapengguna/";</script>';
  } else {
    echo "Error: " . $deleteUserQuery . "<br>" . mysqli_error($conn);
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST atau id_user tidak tersedia, redirect ke halaman semuapengguna
  echo '<script>alert("Akses tidak sah.");document.location="../semuapengguna/";</script>';
}
?>
