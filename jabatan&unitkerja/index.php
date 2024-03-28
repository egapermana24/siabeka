<?php
include '../template/header.php';
include '../database/koneksi.php';
// terima id untuk menampilkan data yang akan diubah
$query = mysqli_query($conn, "SELECT * FROM unit_kerja");
?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
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
    <div class="col-5">
      <div class="customize-input float-end">
        <form>
          <input class="form-control custom-shadow custom-radius border-0 bg-white custom-lh" type="search" placeholder="Search" aria-label="Search">
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
    <div class="col-12 mt-4">
      <h4 class="mb-0 text-info">Data Kategori Unit Kerja</h4>
      <p class="text-muted mt-0 font-12">Pilih Kategori Unit Kerja yang ingin kamu hitung. Bisa kamu search dibagian kanan atas.</code></p>
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
    ?>
  </div>
</div>
<?php include '../template/footer.php' ?>