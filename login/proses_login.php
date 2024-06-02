<?php
include "../database/koneksi.php";
date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

$aksi = $_GET['aksi'];
if ($aksi == "login") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username'");
  if (mysqli_num_rows($query) == 0) {
    echo "<script language='JavaScript'>
    alert('Username atau Password Anda Salah!');
    window.location.href='index.php';
    </script>";
  }
  $row = mysqli_fetch_array($query);
  $nama = $row['nama'];
  $id_user = $row['id_user'];
  $level = $row['level'];
  $foto = $row['foto'];

  $hashedPassword = $row['password']; // Password di-hash yang ada di database

  if (password_verify($password, $hashedPassword)) {
    $cek = mysqli_num_rows($query);
    if ($cek > 0) {
      // input id_user dan tanggal saat login ke tabel login
      $tgl_login = date('Y-m-d H:i:s');
      mysqli_query($conn, "INSERT INTO login (id_user, tgl_login) VALUES ('$id_user', '$tgl_login')");

      session_start();
      $_SESSION['id_user'] = $id_user;
      $_SESSION['username'] = $username;
      $_SESSION['nama'] = $nama;
      $_SESSION['level'] = $level;
      $_SESSION['foto'] = $foto;
      // redirect tanpa alert
      if ($level == "admin") {
        header("Location: ../dashadmin/");
      } else {
        header("Location: ../dashboard/");
      }
    } else {
      echo "<script language='JavaScript'>
      alert('Username atau Password Anda Salah!');
      window.location.href='index.php';
      </script>";
    }
  } else {
    echo "<script language='JavaScript'>
    alert('Username atau Password Anda Salah!');
    window.location.href='index.php';
    </script>";
  }
} else if ($aksi == "logout") {
  session_start();
  $_SESSION['username'] = "";
  session_unset();
  session_destroy();
  // redirect tanpa alert
  header("Location: ../login/");
} else {
  echo "<script language='JavaScript'>
    alert('Anda Tidak Memiliki Akses!');
    window.location.href='../login/';
    </script>";
}
