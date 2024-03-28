<?php include '../template/header.php';
include '../database/koneksi.php';

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
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Norma Waktu Komponen Beban Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../normawaktukomponen/">Norma Waktu Komponen Beban Kerja</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- <div class="col-5 align-self-center">
      <div class="customize-input float-end">
        <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
          <option selected disabled hidden>Pilih Kategori Jabatan</option>
          <option value="1">Petugas Filing</option>
          <option value="1">Petugas Filing</option>
          <option value="1">Petugas Filing</option>
          <option value="1">Petugas Filing</option>
          <option value="1">Petugas Filing</option>
        </select>
      </div>
    </div> -->
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-4">
      <h4 class="mb-0 text-info"><?= $data['nama_unit_kerja']; ?></h4>
      <p class="text-muted mt-0 font-12">Harap di cek uraian kegiatannya apakah sudah sesuai.</code></p>
    </div>
    <div class="col-lg-7">
      <form class="mt-3" action="proses.php" method="post">
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
                        <td>
                          <span class="fw-medium"><?= $list['deskripsi']; ?></span>
                          <br>
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                                <input type="hidden" name="id_unit_kerja" value="<?= $data['id_unit_kerja']; ?>">
                                <input type="hidden" name="waktu_kerja_efektif_menit" value="<?= $data['waktu_kerja_efektif_menit']; ?>">
                                <input name="id_uraian_kegiatan[]" type="hidden" value="<?= $list['id_uraian_kegiatan']; ?>">
                                <input name="norma_waktu[]" type="number" min="1" class="form-control" id="normaWaktu" aria-describedby="menit" placeholder="0" required value="<?= $list['norma_waktu']; ?>">
                                <small id="menit" class="form-text text-muted">Norma Waktu (Menit)</small>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <input name="satuan[]" type="text" class="form-control" id="satuan" aria-describedby="satuan" placeholder="Lembar, Bendel, Berkas, dll" required value="<?= $list['satuan']; ?>">
                                <small id="satuan" class="form-text text-muted">Satuan (Lembar, Bendel, Berkas, dll)</small>
                              </div>
                            </div>
                          </div>
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
      </form>
    </div>
    <div class="card-footer d-flex align-items-center justify-content-evenly">
      <button class="btn btn-rounded btn-danger">Reset</button>
      <button class="btn btn-rounded btn-info">Simpan</button>
    </div>
  </div>
</div>
<div class="col-lg-5">
  <form class="mt-3" action="proses.php" method="post">
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
                    <td>
                      <span class="fw-medium"><?= $list['deskripsi']; ?></span>
                      <br>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                            <input type="hidden" name="id_unit_kerja" value="<?= $data['id_unit_kerja']; ?>">
                            <input type="hidden" name="waktu_kerja_efektif_menit" value="<?= $data['waktu_kerja_efektif_menit']; ?>">
                            <input name="id_uraian_kegiatan[]" type="hidden" value="<?= $list['id_uraian_kegiatan']; ?>">
                            <input name="norma_waktu[]" type="text" class="form-control" id="normaWaktu" aria-describedby="menit" placeholder="Menit" required value="<?= $list['norma_waktu']; ?>">
                            <small id="menit" class="form-text text-muted">Norma Waktu (Menit)</small>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <input name="satuan[]" type="text" class="form-control" id="satuan" aria-describedby="satuan" placeholder="Lembar, Bendel, Berkas, dll" required value="<?= $list['satuan']; ?>">
                            <small id="satuan" class="form-text text-muted">Satuan (Lembar, Bendel, Berkas, dll)</small>
                          </div>
                        </div>
                      </div>
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
      <!-- buatkan button simpan dan reset -->
      <div class="card-footer d-flex align-items-center justify-content-evenly">
        <button class="btn btn-rounded btn-danger">Reset</button>
        <button class="btn btn-rounded btn-info">Simpan</button>
      </div>
    </div>
  </form>
</div>
</div>
<div class="row">
  <div class="col-lg-12 d-flex justify-content-between">
    <a href="../komponenbebankerja/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
    <a href="../standarbebankerja/" class="btn btn-lg btn-rounded btn-info">Selanjutnya</a>
  </div>
</div>

</div>
<?php include '../template/footer.php' ?>