<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_uraian_kegiatan = $_POST['id_uraian_kegiatan']; // Ambil ID uraian kegiatan dari form

  if ($_POST['jenis_tugas'] == 'pokok') {
    $id_unit_kerja = $_POST['id_unit_kerja'];
  } else {
    $id_unit_kerja = 0; // Atur nilai default untuk id_unit_kerja jika jenis tugas bukan 'pokok'
  }

  $jenis_tugas = $_POST['jenis_tugas'];
  $deskripsi = $_POST['deskripsi'];

  // Validasi bahwa semua field harus diisi
  if (empty($jenis_tugas) || empty($deskripsi)) {
    echo '<script>alert("Semua field harus diisi."); document.location="index.php";</script>';
  } else {
    // Query untuk memperbarui data pengguna di tabel
    $updateQuery = "UPDATE uraian_kegiatan SET id_unit_kerja='$id_unit_kerja', jenis_tugas='$jenis_tugas', deskripsi='$deskripsi' WHERE id_uraian_kegiatan='$id_uraian_kegiatan'";
    if (mysqli_query($conn, $updateQuery)) {
      echo '<script>document.location="../datauraiankegiatan/";</script>';
    } else {
      echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
  }
} else {
  // Redirect jika halaman diakses secara langsung tanpa melalui form
  header("Location: ../datauraiankegiatan/");
}
