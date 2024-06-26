<?php
include '../database/koneksi.php';
session_start();
// jika tidak ada session maka diharuskan login dulu
if (!isset($_SESSION['username'])) {
  echo "<script>window.location.href='../login/';</script>";
  die();
} else {
  $id_user = $_SESSION['id_user'];
  $username = $_SESSION['username'];
  $nama = $_SESSION['nama'];
  $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user='$id_user'");
  $row = mysqli_fetch_array($query);
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" href="../assets/img/logo_poltekkes.png">
  <title>SIABEKA</title>
  <!-- Custom CSS -->
  <link href="../assets/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
  <link href="../assets/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
  <link href="../assets/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <!-- <link href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="../assets/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../assets/assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css">
  <!-- Custom CSS -->
  <link href="../assets/dist/css/style.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


    <?php include 'topbar.php'; ?>

    <?php include 'sidebar.php'; ?>

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">