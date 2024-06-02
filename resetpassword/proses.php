<?php
include '../database/koneksi.php';

// Tangkap data yang dikirim melalui form
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$conf_new_password = $_POST['conf_new_password'];
$id_user = $_POST['id_user'];

// Validasi jika field kosong
if (empty($old_password) || empty($new_password) || empty($conf_new_password)) {
  // ubah menjadi alert javascript
  echo "<script>alert('Semua field harus diisi.'); document.location='index.php';</script>";
  exit;
}

// Validasi jika password baru tidak sama dengan konfirmasi password
if ($new_password !== $conf_new_password) {
  echo "<script>alert('Konfirmasi Password Tidak Sama'); document.location='index.php';</script>";

  exit;
}

// Validasi jika password lama sesuai dengan password di database
$checkQuery = "SELECT * FROM tb_user WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $checkQuery);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $hashed_password = $row['password']; // Ambil password terenkripsi dari database

  // Periksa apakah password lama cocok dengan password di database
  if (password_verify($old_password, $hashed_password)) {
    // Enkripsi password baru sebelum menyimpan ke database
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password baru ke dalam database
    $updateQuery = "UPDATE tb_user SET password = '$hashed_new_password' WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $updateQuery)) {
      echo '<script>alert("Password berhasil diubah."); document.location="../profil/";</script>';
      exit;
    } else {
      echo "Error: " . mysqli_error($conn);
      exit;
    }
  } else {
    echo "<script>alert('Password Lama Salah'); document.location='index.php';</script>";
    exit;
  }
} else {
  echo "Error: " . mysqli_error($conn);
  exit;
}
