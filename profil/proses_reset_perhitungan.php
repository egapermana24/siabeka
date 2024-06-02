<?php
include '../database/koneksi.php';

function reset_perhitungan($id_user)
{
  global $conn;

  $deleteNormaWaktuQuery = "DELETE FROM norma_waktu_komponen WHERE id_user = '$id_user' AND EXISTS (SELECT 1 FROM waktu_kerja_tersedia WHERE id_user = '$id_user' AND dipilih = 1)";
  $deleteWaktuKerjaQuery = "DELETE FROM waktu_kerja_tersedia WHERE id_user = '$id_user' AND dipilih = 1";
  if (mysqli_query($conn, $deleteWaktuKerjaQuery) && mysqli_query($conn, $deleteNormaWaktuQuery)) {
    // gunakan alert untuk memberitahu user bahwa data berhasil dihapus
    // pindahkan value 1 ke row random untuk user yang bersangkutan, tapi jika tidak ada pun tidak apa apa
    $moveRandomValue = "UPDATE waktu_kerja_tersedia SET dipilih = 1 WHERE id_user = '$id_user' ORDER BY RAND() LIMIT 1";
    mysqli_query($conn, $moveRandomValue);
    echo '<script>alert("Data berhasil dihapus.");document.location="../profil/";</script>';
  } else {
    echo "Error: " . $deleteNormaWaktuQuery . "<br>" . mysqli_error($conn);
    echo "Error: " . $deleteWaktuKerjaQuery . "<br>" . mysqli_error($conn);
  }
}

// Contoh penggunaan fungsi reset_perhitungan
$id_user_login = $_POST['id_user'];
reset_perhitungan($id_user_login);
