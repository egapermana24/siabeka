<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_unit_kerja'])) {
  $id_unit_kerja = $_POST['id_unit_kerja'];

  // Hapus data pengguna dari tabel tb_user
  $deleteUnitQuery = "DELETE FROM unit_kerja WHERE id_unit_kerja='$id_unit_kerja'";
  if (mysqli_query($conn, $deleteUnitQuery)) {
    echo '<script>alert("Data Unit Kerja berhasil dihapus.");document.location="../dataunitkerja/";</script>';
  } else {
    echo "Error: " . $deleteUnitQuery . "<br>" . mysqli_error($conn);
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST atau id_unit_kerja tidak tersedia, redirect ke halaman dataunitkerja
  echo '<script>alert("Akses tidak sah.");document.location="../dataunitkerja/";</script>';
}
