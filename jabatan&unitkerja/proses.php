<?php
// Include file koneksi.php
include '../database/koneksi.php';

// Mendapatkan nilai dari $_POST
$id_unit_kerja = $_POST['id_unit_kerja'];
$id_user = $_POST['id_user'];

// Cek apakah data dengan id_user tersebut sudah ada dalam tabel
$sql_check = "SELECT id_unit_kerja FROM waktu_kerja_tersedia WHERE id_user = $id_user";
$result_check = $conn->query($sql_check);

$sql_check2 = "SELECT id_unit_kerja FROM norma_waktu_komponen WHERE id_user = $id_user";
$result_check2 = $conn->query($sql_check2);

if ($result_check->num_rows > 0 && $result_check2->num_rows > 0) {
  // Jika sudah ada, lakukan operasi UPDATE
  $sql_update = "UPDATE waktu_kerja_tersedia SET id_unit_kerja = $id_unit_kerja WHERE id_user = $id_user";
  $sql_update2 = "UPDATE norma_waktu_komponen SET id_unit_kerja = $id_unit_kerja WHERE id_user = $id_user";
  if ($conn->query($sql_update) === TRUE && $conn->query($sql_update2) === TRUE){
    echo '<script>document.location="../waktukerjatersedia/";</script>';
  } else {
    echo "Error: " . $sql_update . "<br>" . $conn->error;
  }
} else {
  // Jika belum ada, lakukan operasi INSERT
  $sql_insert = "INSERT INTO waktu_kerja_tersedia (id_unit_kerja, id_user) VALUES ($id_unit_kerja, $id_user)";
  $sql_insert2 = "INSERT INTO norma_waktu_komponen (id_unit_kerja, id_user) VALUES ($id_unit_kerja, $id_user)";
  if ($conn->query($sql_insert) === TRUE && $conn->query($sql_insert2) === TRUE) {
    echo '<script>document.location="../waktukerjatersedia/";</script>';
  } else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
  }
}

$conn->close(); // Tutup koneksi ke database
