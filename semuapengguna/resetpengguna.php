<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_user']) && isset($_POST['id_unit_kerja'])) {
  $id_user = $_POST['id_user'];
  $id_unit_kerja = $_POST['id_unit_kerja'];

  // Hapus data pengguna dari tabel waktu_kerja_tersedia
  $deleteWaktuQuery = "DELETE FROM waktu_kerja_tersedia WHERE id_user='$id_user' AND id_unit_kerja = '$id_unit_kerja'";

  if (mysqli_query($conn, $deleteWaktuQuery)) {
    // $checkQuery = "SELECT COUNT(*) AS total FROM waktu_kerja_tersedia WHERE id_user = '$id_user' AND dipilih = 0";
    // $result = mysqli_query($conn, $checkQuery);
    // $row = mysqli_fetch_assoc($result);
    // $totalDipilih0 = $row['total'];

    // if ($totalDipilih0 > 0) {
    //   // Ambil semua 'id_unit_kerja' yang belum dipilih
    //   $availableUnitsQuery = "SELECT id_unit_kerja FROM waktu_kerja_tersedia WHERE id_user = '$id_user' AND dipilih = 0";
    //   $unitsResult = mysqli_query($conn, $availableUnitsQuery);
    //   $units = mysqli_fetch_all($unitsResult, MYSQLI_ASSOC);

    //   // Pilih secara acak salah satu 'id_unit_kerja' yang belum dipilih
    //   $randomUnitIndex = array_rand($units);
    //   $randomUnitId = $units[$randomUnitIndex]['id_unit_kerja'];

    //   // Perbarui 'dipilih' untuk 'id_unit_kerja' yang dipilih secara acak
    //   $updateQuery = "UPDATE waktu_kerja_tersedia SET dipilih = 1 WHERE id_user = '$id_user' AND id_unit_kerja = '$randomUnitId'";
    //   mysqli_query($conn, $updateQuery);
    // }
    // Hapus data pengguna dari tabel norma_waktu_komponen
    $deleteNormaQuery = "DELETE FROM norma_waktu_komponen WHERE id_user='$id_user' AND id_unit_kerja = '$id_unit_kerja'";
    if (mysqli_query($conn, $deleteNormaQuery)) {
      // Redirect ke halaman semuapengguna setelah sukses menghapus
      echo '<script>alert("Data pengguna berhasil direset.");document.location="../semuapengguna/";</script>';
    } else {
      echo "Error: " . $deleteNormaQuery . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "Error: " . $deleteWaktuQuery . "<br>" . mysqli_error($conn);
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST atau id_user tidak tersedia, redirect ke halaman semuapengguna
  echo '<script>alert("Akses tidak sah.");document.location="../semuapengguna/";</script>';
}
