<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['jenis_tugas'] == 'pokok') {
    $id_unit_kerja = $_POST['id_unit_kerja'];
  } else {
    $id_unit_kerja = 0;
  }
  $unit_kerja = $id_unit_kerja;
  $jenis_tugas = $_POST['jenis_tugas'];
  $deskripsi = $_POST['deskripsi'];

  // Validasi bahwa semua field harus diisi
  // var_dump($jenis_tugas, $unit_kerja, $deskripsi); die;
  if (empty($jenis_tugas) || empty($deskripsi)) {
    echo '<script>alert("Semua field harus diisi."); document.location="index.php";</script>';
  } else {
    // Query untuk memasukkan data pengguna ke dalam tabel
    $insertQuery = "INSERT INTO uraian_kegiatan (id_unit_kerja, jenis_tugas, deskripsi) VALUES ('$unit_kerja', '$jenis_tugas', '$deskripsi')";
    if (mysqli_query($conn, $insertQuery)) {
      echo '<script>document.location="../datauraiankegiatan/";</script>';
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
  }
} else {
  // Redirect jika halaman diakses secara langsung tanpa melalui form
  header("Location: ../datauraiankegiatan/");
}
