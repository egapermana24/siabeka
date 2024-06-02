<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_user']) && isset($_POST['id_unit_kerja'])) {
  $id_user = $_POST['id_user'];
  $id_unit_kerja = $_POST['id_unit_kerja'];

  // Hapus data pengguna dari tabel waktu_kerja_tersedia
  $deleteWaktuQuery = "DELETE FROM waktu_kerja_tersedia WHERE id_user='$id_user' AND id_unit_kerja = '$id_unit_kerja'";

  if (mysqli_query($conn, $deleteWaktuQuery)) {
    // Hapus data pengguna dari tabel norma_waktu_komponen
    $deleteNormaQuery = "DELETE FROM norma_waktu_komponen WHERE id_user='$id_user' AND id_unit_kerja = '$id_unit_kerja'";
    if (mysqli_query($conn, $deleteNormaQuery)) {
      // Redirect ke halaman dataunitkerjauser setelah sukses menghapus
      echo '<script>document.location="../dataunitkerjauser/";</script>';
    } else {
      echo "Error: " . $deleteNormaQuery . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "Error: " . $deleteWaktuQuery . "<br>" . mysqli_error($conn);
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST atau id_user tidak tersedia, redirect ke halaman dataunitkerjauser
  echo '<script>alert("Akses tidak sah.");document.location="../dataunitkerjauser/";</script>';
}
