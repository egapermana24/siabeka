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
    SELECT * FROM waktu_kerja_tersedia WHERE id_user = $id_user AND dipilih = 1
");
$query_waktu_kerja_check = mysqli_query($conn, "
  SELECT * FROM waktu_kerja_tersedia WHERE id_user = $id_user AND waktu_kerja_efektif_menit != 0 AND dipilih = 1
");
$query_norma_check = mysqli_query($conn, "
    SELECT norma_waktu_komponen.*, waktu_kerja_tersedia.* FROM norma_waktu_komponen INNER JOIN waktu_kerja_tersedia ON norma_waktu_komponen.id_user = waktu_kerja_tersedia.id_user WHERE norma_waktu_komponen.id_user = $id_user AND norma_waktu_komponen.id_unit_kerja = waktu_kerja_tersedia.id_unit_kerja AND waktu_kerja_tersedia.dipilih = 1
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
if ($query_waktu_kerja_check) {
  if (mysqli_num_rows($query_waktu_kerja_check) == 0) {
    // Jika id_user belum ada di tabel waktu_kerja_tersedia, kembalikan ke halaman sebelumnya
    echo '<script>alert("Anda harus menetapkan waktu kerja tersedia.");document.location="../waktukerjatersedia/";</script>';
    exit; // Hentikan eksekusi script selanjutnya
  }
} else {
  echo "Error: " . mysqli_error($conn);
}

$query_deskripsi_pokok = "SELECT waktu_kerja_tersedia.*, unit_kerja.*, uraian_kegiatan.* FROM waktu_kerja_tersedia INNER JOIN uraian_kegiatan ON waktu_kerja_tersedia.id_unit_kerja = uraian_kegiatan.id_unit_kerja INNER JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja WHERE waktu_kerja_tersedia.id_user = '$id_user' AND uraian_kegiatan.jenis_tugas = 'pokok' AND waktu_kerja_tersedia.dipilih = 1";
$result_pokok = mysqli_query($conn, $query_deskripsi_pokok);
$query_deskripsi_pokok = $result_pokok;
$cek_pokok = mysqli_num_rows($result_pokok) > 0;

$query_deskripsi_penunjang = "SELECT * FROM uraian_kegiatan WHERE uraian_kegiatan.jenis_tugas = 'penunjang'";
$result_penunjang = mysqli_query($conn, $query_deskripsi_penunjang);
$query_deskripsi_penunjang = $result_penunjang;
$cek_penunjang = mysqli_num_rows($result_penunjang) > 0;

$query_unit = "SELECT *
    FROM waktu_kerja_tersedia
    JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja
    WHERE waktu_kerja_tersedia.id_user = '$id_user' AND waktu_kerja_tersedia.dipilih = 1";
$result_unit = mysqli_query($conn, $query_unit);
$data = mysqli_fetch_assoc($result_unit);
?>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Komponen Beban Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../komponenbebankerja/">Komponen Beban Kerja</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12 align-self-center">
      <p class="page-title text-dark mt-1 font-14">Lakukan identifikasi kegiatan-kegiatan yang dilakukan oleh jabatan yang sedang dihitung, komponen beban kerja dikelompokkan menjadi tugas pokok dan tugas penunjang, komponen beban kerja adalah jenis tugas dan uraian tugas yang secara nyata dilaksanakan oleh SDMK tertentu sesuai dengan tugas pokok dan fungsi yang telah ditetapkan.</p>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
  <form action="proses.php" method="post">
    <div class="row">
      <div class="col-12 mt-4">
        <h4 class="mb-0 text-info"><?= $data['nama_unit_kerja']; ?></h4>
        <p class="text-muted mt-0 font-12">Harap di cek uraian kegiatannya apakah sudah sesuai.</code></p>
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
                      <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                      <input type="hidden" name="id_unit_kerja" value="<?= $data['id_unit_kerja']; ?>">
                      <input name="id_uraian_kegiatan[]" type="hidden" value="<?= $list['id_uraian_kegiatan']; ?>">
                      <tr>
                        <td><?= $list['deskripsi']; ?></td>
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
                      <input type="hidden" name="id_user2" value="<?= $id_user; ?>">
                      <input type="hidden" name="id_unit_kerja2" value="<?= $data['id_unit_kerja']; ?>">
                      <input name="id_uraian_kegiatan2[]" type="hidden" value="<?= $list['id_uraian_kegiatan']; ?>">
                      <tr>
                        <td><?= $list['deskripsi']; ?></td>
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
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-between">
        <a href="../waktukerjatersedia/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
        <?php
        if ($query_norma_check) {
          if (mysqli_num_rows($query_norma_check) == 0) {
        ?>
            <button type="submit" class="btn btn-lg btn-rounded btn-info">Simpan dan Selanjutnya</button>
          <?php
          } else {
          ?>
            <a href="../normawaktukomponen/" class="btn btn-lg btn-rounded btn-info">Selanjutnya</a>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </form>
</div>
<?php include '../template/footer.php' ?>