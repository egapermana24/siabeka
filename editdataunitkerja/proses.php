<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_unit_kerja = $_POST['id_unit_kerja'];
  $nama_unit_kerja = $_POST['nama_unit_kerja'];

  // Validasi data (contoh: pastikan tidak ada field yang kosong)

  if (empty($nama_unit_kerja)) {
    echo '<script>alert("Nama Unit Kerja Tidak Boleh Kosong!"); document.location="index.php";</script>';
  } else {
    // Query untuk melakukan update data pengguna
    $query = "UPDATE unit_kerja SET nama_unit_kerja='$nama_unit_kerja' WHERE id_unit_kerja='$id_unit_kerja'";

    if (mysqli_query($conn, $query)) {
      // Jika update berhasil, redirect ke halaman dataunitkerja
      echo '<script>alert("Data unit kerja berhasil diupdate.");document.location="../dataunitkerja/";</script>';
    } else {
      // Jika update gagal, tampilkan pesan error
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  }
} else {
  // Jika tidak ada data yang dikirim melalui POST, redirect ke halaman dataunitkerja
  echo '<script>alert("Akses tidak sah.");document.location="../dataunitkerja/";</script>';
}
?>
