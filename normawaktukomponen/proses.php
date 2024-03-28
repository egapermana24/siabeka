<?php
include '../database/koneksi.php';

$id_user = $_POST['id_user'];
$id_unit_kerja = $_POST['id_unit_kerja'];
$id_uraian_kegiatan = $_POST['id_uraian_kegiatan'];
$waktu_kerja_efektif_menit = $_POST['waktu_kerja_efektif_menit'];
$norma_waktu = $_POST['norma_waktu'];
$satuan = $_POST['satuan'];

// Lakukan iterasi untuk memasukkan atau mengupdate data ke dalam tabel
for ($i = 0; $i < count($id_uraian_kegiatan); $i++) {
  $idUraian = mysqli_real_escape_string($conn, $id_uraian_kegiatan[$i]);
  $normaWaktu = mysqli_real_escape_string($conn, $norma_waktu[$i]);
  $satuanValue = mysqli_real_escape_string($conn, $satuan[$i]);

  // Hitung hasil pembagian dan simpan ke dalam variabel
  $hasilPembagian = $waktu_kerja_efektif_menit / $normaWaktu;

  // Query untuk mencari apakah data dengan id_user, id_unit_kerja, dan id_uraian_kegiatan tersebut sudah ada di tabel
  $checkQuery = "SELECT * FROM norma_waktu_komponen WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$idUraian'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
      // Jika data sudah ada, lakukan update
      $updateQuery = "UPDATE norma_waktu_komponen SET norma_waktu = '$normaWaktu', satuan = '$satuanValue', standar_beban_kerja = '$hasilPembagian' WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$idUraian'";
      if (mysqli_query($conn, $updateQuery)) {
          // echo "Data berhasil diupdate.";
          echo '<script>document.location="index.php";</script>';
      } else {
          echo "Error updating record: " . mysqli_error($conn);
      }
  } else {
      // Jika data belum ada, lakukan insert
      $insertQuery = "INSERT INTO norma_waktu_komponen (id_user, id_unit_kerja, id_uraian_kegiatan, norma_waktu, satuan, standar_beban_kerja) VALUES ('$id_user', '$id_unit_kerja', '$idUraian', '$normaWaktu', '$satuanValue', '$hasilPembagian')";
      if (mysqli_query($conn, $insertQuery)) {
        echo '<script>document.location="index.php";</script>';
      } else {
          echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      }
  }
}
