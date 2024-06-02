<?php
include '../template/header.php';
include '../database/koneksi.php';
// FOR DEBUGGING
// session_start();
// // jika tidak ada session maka diharuskan login dulu
// if (!isset($_SESSION['username'])) {
//   echo "<script>window.location.href='../login/';</script>";
//   die();
// } else {
//   $id_user = $_SESSION['id_user'];
//   $username = $_SESSION['username'];
//   $nama = $_SESSION['nama'];
//   $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username'");
//   $row = mysqli_fetch_array($query);
// }
// terima id untuk menampilkan data yang akan diubah
$query = mysqli_query($conn, "SELECT unit_kerja.*, waktu_kerja_tersedia.dipilih
                              FROM unit_kerja
                              LEFT JOIN waktu_kerja_tersedia ON unit_kerja.id_unit_kerja = waktu_kerja_tersedia.id_unit_kerja AND waktu_kerja_tersedia.id_user = '$id_user'");

$cek_user = mysqli_query($conn, "SELECT unit_kerja.*, waktu_kerja_tersedia.* FROM unit_kerja 
              INNER JOIN waktu_kerja_tersedia ON unit_kerja.id_unit_kerja = waktu_kerja_tersedia.id_unit_kerja 
              WHERE waktu_kerja_tersedia.id_user = $id_user AND waktu_kerja_tersedia.dipilih = 1");

?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-lg-6 col-sm-12 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Unit Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../jabatan&unitkerja/">Kategori Unit Kerja</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="col-lg-6 col-sm-12">
      <div class="customize-input float-end">
        <form class="mt-4" action="proses.php" method="POST">
          <div class="input-group">
            <select class="form-select" name="id_unit_kerja" id="inputGroupSelect04">
              <?php
              $unit_kerja_selected = false; // Variabel untuk menandai apakah sudah ada unit kerja yang dipilih
              while ($data = mysqli_fetch_assoc($query)) :
                // Jika ada unit kerja yang dipilih, tandai variabel $unit_kerja_selected sebagai true
                if ($data['dipilih'] == 1) {
                  $unit_kerja_selected = true;
                }
              ?>
                <option value="<?= $data['id_unit_kerja']; ?>" <?= ($data['dipilih'] == 1) ? 'selected' : ''; ?>>
                  <?= $data['nama_unit_kerja']; ?>
                </option>
              <?php endwhile; ?>

              <!-- Menambahkan opsi default jika tidak ada unit kerja yang dipilih -->
              <?php if (!$unit_kerja_selected) : ?>
                <option hidden selected value="">Pilih Unit Kerja</option>
              <?php endif; ?>
            </select>
            <input type="hidden" name="id_user" value="<?= $id_user; ?>">
            <input type="hidden" name="dipilih" value="1">
            <button class="btn btn-primary" type="submit">
              Simpan
            </button>
          </div>
          <small id="name1" class="badge badge-default text-bg-warning">Pilihan Unit Kerja Untuk dihitung</small>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
  <div class="row">
    <?php
    if (mysqli_num_rows($cek_user) > 0) {
      while ($user = mysqli_fetch_assoc($cek_user)) {
    ?>
        <div class="col-12 mt-4">
          <h4 class="mb-0 text-info">Data Kategori Unit Kerja</h4>
          <p class="text-muted mt-0 font-12">Ini adalah Unit Kerja Yang Kamu Pilih.</code></p>
        </div>
        <div class="col-md-6">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h3 class="card-title text-white">UNIT KERJA</h3>
              <p class="card-text"><?= $user['nama_unit_kerja']; ?></p>
              <a href="../waktukerjatersedia/" class="btn btn-dark">Lanjutkan/Edit Perhitungan</a>
            </div>
          </div>
        </div>
      <?php
      }
    } else { ?>

      <div class="col-12 mt-4">
        <h4 class="mb-0 text-info">Data Kategori Unit Kerja</h4>
        <p class="text-muted mt-0 font-12">Pilih Kategori Unit Kerja yang ingin kamu hitung!</code></p>
      </div>
      <?php
      while ($data = mysqli_fetch_assoc($query)) {
      ?>
        <div class="col-md-6">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h3 class="card-title text-white">UNIT KERJA</h3>
              <p class="card-text"><?= $data['nama_unit_kerja']; ?></p>
              <form action="proses.php" method="post">
                <input type="hidden" name="id_unit_kerja" value="<?= $data['id_unit_kerja']; ?>">
                <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                <button type="submit" class="btn btn-dark">Mulai Hitung</button>
              </form>
            </div>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>
</div>
<?php include '../template/footer.php' ?>