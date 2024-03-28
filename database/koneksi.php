<?php
$db_config = [
  'host' => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'siabeka'
];

$conn = mysqli_connect($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// ambil umur dari database menggunakan tgl_lahir berdasarkan $_SESSION['id_user']
// if (!isset($_SESSION['username'])) {
//   echo "<script>window.location.href='../login/';</script>";
//   session_destroy();
//   die();
// }
// $id_user = $_SESSION['id_user'];
// $umur = mysqli_query($conn, "SELECT YEAR(CURDATE()) - YEAR(tgl_lahir) AS umur FROM user WHERE id_user = '$id_user'");
// $umur = mysqli_fetch_array($umur);
// $umur = $umur['umur'];


if (!$conn) {
  die('Koneksi gagal: ' . mysqli_connect_error());
}
