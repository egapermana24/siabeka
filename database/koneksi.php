<?php
$db_config = [
  'host' => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'siabeka'
];

$conn = mysqli_connect($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if (!$conn) {
  die('Koneksi gagal: ' . mysqli_connect_error());
}
