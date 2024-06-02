<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $conf_password = $_POST['conf_password'];
  $level = $_POST['level'];

  // Validasi bahwa semua field harus diisi
  if (empty($nama) || empty($username) || empty($password) || empty($conf_password) || empty($level)) {
    echo '<script>alert("Semua field harus diisi."); document.location="index.php";</script>';
  } else {
    // Validasi bahwa password dan konfirmasi password harus sama
    if ($password != $conf_password) {
      echo '<script>alert("Password dan konfirmasi password tidak sama."); document.location="index.php";</script>';
    } else {
      // Query untuk mengecek apakah username sudah digunakan
      $checkUsernameQuery = "SELECT * FROM tb_user WHERE username = '$username'";
      $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
      if (mysqli_num_rows($checkUsernameResult) > 0) {
        echo '<script>alert("Username sudah digunakan. Harap pilih username lain."); document.location="index.php";</script>';
      } else {
        // Hash password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk memasukkan data pengguna ke dalam tabel
        $insertQuery = "INSERT INTO tb_user (nama, username, password, level) VALUES ('$nama', '$username', '$hashed_password', '$level')";
        if (mysqli_query($conn, $insertQuery)) {
          echo '<script>document.location="../semuapengguna/";</script>';
        } else {
          echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
      }
    }
  }
} else {
  // Redirect jika halaman diakses secara langsung tanpa melalui form
  header("Location: ../semuapengguna/");
}
?>
