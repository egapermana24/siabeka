<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama_unit_kerja'];

  // Validasi bahwa semua field harus diisi
  if (empty($nama)) {
    echo '<script>alert("Semua field harus diisi."); document.location="index.php";</script>';
  } else {
    // Query untuk memasukkan data pengguna ke dalam tabel
    $insertQuery = "INSERT INTO unit_kerja (nama_unit_kerja) VALUES ('$nama')";
    if (mysqli_query($conn, $insertQuery)) {
      echo '<script>document.location="../dataunitkerja/";</script>';
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
  }
} else {
  // Redirect jika halaman diakses secara langsung tanpa melalui form
  header("Location: ../dataunitkerja/");
}
