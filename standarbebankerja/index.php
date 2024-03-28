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

$query_check = mysqli_query($conn, "
    SELECT * FROM waktu_kerja_tersedia WHERE id_user = $id_user
");

// Cek apakah query berhasil dieksekusi
if ($query_check) {
  if (mysqli_num_rows($query_check) == 0) {
    // Jika id_user belum ada di tabel waktu_kerja_tersedia, kembalikan ke halaman sebelumnya
    echo '<script>alert("Anda harus memilih unit kerja terlebih dahulu.");window.history.back();</script>';
    exit; // Hentikan eksekusi script selanjutnya
  }
} else {
  echo "Error: " . mysqli_error($conn);
}

$query_deskripsi_pokok = "SELECT waktu_kerja_tersedia.*, unit_kerja.*, uraian_kegiatan.*, norma_waktu_komponen.* FROM waktu_kerja_tersedia INNER JOIN uraian_kegiatan ON waktu_kerja_tersedia.id_unit_kerja = uraian_kegiatan.id_unit_kerja INNER JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja INNER JOIN norma_waktu_komponen ON waktu_kerja_tersedia.id_unit_kerja = norma_waktu_komponen.id_unit_kerja WHERE waktu_kerja_tersedia.id_user = '$id_user' AND uraian_kegiatan.jenis_tugas = 'pokok' AND norma_waktu_komponen.id_uraian_kegiatan = uraian_kegiatan.id_uraian_kegiatan";
$result_pokok = mysqli_query($conn, $query_deskripsi_pokok);
$query_deskripsi_pokok = $result_pokok;
$cek_pokok = mysqli_num_rows($result_pokok) > 0;

$query_deskripsi_penunjang = "SELECT waktu_kerja_tersedia.*, norma_waktu_komponen.*, uraian_kegiatan.* FROM waktu_kerja_tersedia INNER JOIN norma_waktu_komponen ON waktu_kerja_tersedia.id_unit_kerja = norma_waktu_komponen.id_unit_kerja INNER JOIN uraian_kegiatan ON norma_waktu_komponen.id_uraian_kegiatan = uraian_kegiatan.id_uraian_kegiatan WHERE waktu_kerja_tersedia.id_user = '$id_user' AND uraian_kegiatan.jenis_tugas = 'penunjang' AND norma_waktu_komponen.id_uraian_kegiatan = uraian_kegiatan.id_uraian_kegiatan AND uraian_kegiatan.id_unit_kerja = 0";
$result_penunjang = mysqli_query($conn, $query_deskripsi_penunjang);
$query_deskripsi_penunjang = $result_penunjang;
$cek_penunjang = mysqli_num_rows($result_penunjang) > 0;

$query_unit = "SELECT *
    FROM waktu_kerja_tersedia
    JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja
    WHERE waktu_kerja_tersedia.id_user = '$id_user'";
$result_unit = mysqli_query($conn, $query_unit);
$data = mysqli_fetch_assoc($result_unit);
?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Standar Beban Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../standarbebankerja/">Standar Beban Kerja</a>
            </li>
          </ol>
        </nav>
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
      <h4 class="mb-0 text-info"><?= $data['nama_unit_kerja']; ?></h4>
      <p class="text-muted mt-0 font-12">Ini adalah hasil perhitungan dari inputan norma waktu.</code></p>
    </div>
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tugas Pokok</h4>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <?php
                if ($cek_pokok) {
                  while ($list = mysqli_fetch_assoc($query_deskripsi_pokok)) {
                ?>
                    <tr>
                      <td><span class="fw-medium"><?= $list['deskripsi']; ?></span>
                        <br>
                        <form class="mt-3">
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-muted">Norma Waktu (Dalam Menit)</small>
                                <input type="text" class="form-control text-muted" id="normaWaktu" aria-describedby="menit" value="<?= $list['norma_waktu']; ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-muted">Satuan</small>
                                <input type="text" class="form-control text-muted" id="satuan" aria-describedby="satuan" value="<?= $list['satuan']; ?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-info">WKE (Waktu Kerja Efektif)</small>
                                <input type="text" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="<?= number_format($list['waktu_kerja_efektif_menit']); ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-info">SBK (Standar Beban Kerja)</small>
                                <input type="text" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= number_format($list['standar_beban_kerja']); ?>" readonly>
                              </div>
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td class="text-center">Tidak ada tugas pokok</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tugas Penunjang</h4>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <?php
                if ($cek_penunjang) {
                  while ($list = mysqli_fetch_assoc($query_deskripsi_penunjang)) {
                ?>
                    <tr>
                      <td><span class="fw-medium"><?= $list['deskripsi']; ?></span>
                        <br>
                        <form class="mt-3">
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-muted">Norma Waktu (Menit)</small>
                                <input type="text" class="form-control text-muted" id="normaWaktu" aria-describedby="menit" value="<?= $list['norma_waktu']; ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-muted">Satuan</small>
                                <input type="text" class="form-control text-muted" id="satuan" aria-describedby="satuan" value="<?= $list['satuan']; ?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-info">WKE (Waktu Kerja Efektif)</small>
                                <input type="text" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="<?= number_format($list['waktu_kerja_efektif_menit']); ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-info">SBK (Standar Beban Kerja)</small>
                                <input type="text" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= number_format($list['standar_beban_kerja']); ?>" readonly>
                              </div>
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td class="text-center">Tidak ada tugas penunjang</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- buatkan button simpan dan reset
        <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 d-flex justify-content-between">
      <a href="../normawaktukomponen/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
      <a href="../standartugaspenunjang/" class="btn btn-lg btn-rounded btn-info">Selanjutnya</a>
    </div>
  </div>

</div>
<?php include '../template/footer.php' ?>