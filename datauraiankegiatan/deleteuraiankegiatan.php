<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_uraian_kegiatan'])) {
  $id_uraian_kegiatan = $_POST['id_uraian_kegiatan'];

  // Hapus data pengguna dari tabel tb_user
  $deleteUnitQuery = "DELETE FROM uraian_kegiatan WHERE id_uraian_kegiatan='$id_uraian_kegiatan'";
  if (mysqli_query($conn, $deleteUnitQuery)) {
    echo '<script>alert("Data Unit Kerja berhasil dihapus.");document.location="../datauraiankegiatan/";</script>';
  } else {
    echo "Error: " . $deleteUnitQuery . "<br>" . mysqli_error($conn);
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST atau id_uraian_kegiatan tidak tersedia, redirect ke halaman datauraiankegiatan
  echo '<script>alert("Akses tidak sah.");document.location="../datauraiankegiatan/";</script>';
}
