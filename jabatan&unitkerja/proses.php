<?php
// Include file koneksi.php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dipilih']) && $_POST['dipilih'] == 1) {
  // Tangkap data yang dikirim dari formulir
  $id_unit_kerja = $_POST['id_unit_kerja'];
  $id_user = $_POST['id_user'];

  // Periksa apakah pengguna sudah memiliki id_unit_kerja di tabel waktu_kerja_tersedia
  $checkQuery = "SELECT id_unit_kerja FROM waktu_kerja_tersedia WHERE id_unit_kerja = '$id_unit_kerja' AND id_user = '$id_user'";
  $result = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($result) > 0) {
    // Jika pengguna sudah memiliki id_unit_kerja, lakukan update pada kolom "dipilih"
    $updateQuery = "UPDATE waktu_kerja_tersedia SET dipilih = 1 WHERE id_unit_kerja = '$id_unit_kerja' AND id_user = '$id_user'";

    if (mysqli_query($conn, $updateQuery)) {
      // Update kolom "dipilih" untuk id_unit_kerja yang lain dalam baris yang sama dengan id_user
      $updateOtherQuery = "UPDATE waktu_kerja_tersedia SET dipilih = 0 WHERE id_unit_kerja != '$id_unit_kerja' AND id_user = '$id_user'";

      if (mysqli_query($conn, $updateOtherQuery)) {
        echo '<script>document.location="/siabeka/jabatan&unitkerja";</script>';
      } else {
        echo "Error: " . $updateOtherQuery . "<br>" . mysqli_error($conn);
      }
    } else {
      echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
  } else {
    // Jika pengguna belum memiliki id_unit_kerja, lakukan operasi insert
    $insertQuery = "INSERT INTO waktu_kerja_tersedia (id_unit_kerja, id_user, dipilih) VALUES ('$id_unit_kerja', '$id_user', 1)";

    if (mysqli_query($conn, $insertQuery)) {
      // Update kolom "dipilih" untuk id_unit_kerja yang lain dalam baris yang sama dengan id_user
      $updateOtherQuery = "UPDATE waktu_kerja_tersedia SET dipilih = 0 WHERE id_unit_kerja != '$id_unit_kerja' AND id_user = '$id_user' AND dipilih = 1";

      if (mysqli_query($conn, $updateOtherQuery)) {
        echo '<script>document.location="/siabeka/jabatan&unitkerja";</script>';
      } else {
        echo "Error: " . $updateOtherQuery . "<br>" . mysqli_error($conn);
      }
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
  }
}

// Mendapatkan nilai dari $_POST
// $id_unit_kerja = $_POST['id_unit_kerja'];
// $id_user = $_POST['id_user'];

// // Cek apakah data dengan id_user tersebut sudah ada dalam tabel
// $sql_check = "SELECT id_unit_kerja FROM waktu_kerja_tersedia WHERE id_user = $id_user";
// $result_check = $conn->query($sql_check);

// // $sql_check2 = "SELECT id_unit_kerja FROM norma_waktu_komponen WHERE id_user = $id_user";
// // $result_check2 = $conn->query($sql_check2);

// if ($result_check->num_rows > 0) {
//   // Jika sudah ada, lakukan operasi UPDATE
//   $sql_update = "UPDATE waktu_kerja_tersedia SET id_unit_kerja = $id_unit_kerja WHERE id_user = $id_user";
//   // $sql_update2 = "UPDATE norma_waktu_komponen SET id_unit_kerja = $id_unit_kerja WHERE id_user = $id_user";
//   if ($conn->query($sql_update) === TRUE) {
//     echo '<script>document.location="../waktukerjatersedia/";</script>';
//   } else {
//     echo "Error: " . $sql_update . "<br>" . $conn->error;
//   }
// } else {
//   // Jika belum ada, lakukan operasi INSERT
//   $sql_insert = "INSERT INTO waktu_kerja_tersedia (id_unit_kerja, id_user) VALUES ($id_unit_kerja, $id_user)";
//   // $sql_insert2 = "INSERT INTO norma_waktu_komponen (id_unit_kerja, id_user) VALUES ($id_unit_kerja, $id_user)";
//   if ($conn->query($sql_insert) === TRUE) {
//     echo '<script>document.location="../waktukerjatersedia/";</script>';
//   } else {
//     echo "Error: " . $sql_insert . "<br>" . $conn->error;
//   }
// }

$conn->close(); // Tutup koneksi ke database
