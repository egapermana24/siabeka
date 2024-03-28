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

$query_unit = "SELECT *
    FROM waktu_kerja_tersedia
    JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja
    WHERE waktu_kerja_tersedia.id_user = '$id_user'";
$result_unit = mysqli_query($conn, $query_unit);
$data = mysqli_fetch_assoc($result_unit);

if (isset($_POST['frekuensi_kegiatan'])) {
  $id_unit_kerja = $data['id_unit_kerja'];
  $standar_tugas_penunjang = $data['standar_tugas_penunjang'];
  $id_uraian_kegiatan = $_POST['id_uraian_kegiatan'];
  $frekuensi_kegiatan = $_POST['frekuensi_kegiatan'];
  $standar_beban_kerja = $_POST['standar_beban_kerja'];

  // Inisialisasi variabel untuk menyimpan hasil perhitungan
  $hasil_pembagian = array();
  $jbk = array();
  $jbk_tampil = array();
  $total_jbk = 0;
  $total_jbk_tampil = 0;

  // Iterasi untuk setiap elemen dalam array
  for ($i = 0; $i < count($frekuensi_kegiatan); $i++) {
    $jbk[$i] = $frekuensi_kegiatan[$i] / $standar_beban_kerja[$i];
    $jbk_tampil[$i] = number_format($jbk[$i], 4, '.', '');
    $total_jbk = array_sum($jbk);
  }

  $tkt = $standar_tugas_penunjang * $total_jbk;

  for ($i = 0; $i < count($frekuensi_kegiatan); $i++) {
    $id_uraian_kegiatan_loop = mysqli_real_escape_string($conn, $id_uraian_kegiatan[$i]); // Variabel untuk menyimpan id_uraian_kegiatan di setiap iterasi
    $frekuensi_kegiatan_loop = mysqli_real_escape_string($conn, $frekuensi_kegiatan[$i]); // Variabel untuk menyimpan frekuensi_kegiatan di setiap iterasi
    $jbk_loop = mysqli_real_escape_string($conn, $jbk[$i]); // Variabel untuk menyimpan jbk di setiap iterasi
    // Query untuk mencari apakah data dengan id_user, id_unit_kerja, dan id_uraian_kegiatan tersebut sudah ada di tabel
    $checkQuery = "SELECT * FROM norma_waktu_komponen WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$id_uraian_kegiatan_loop'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      // Jika data sudah ada, lakukan update
      $updateQuery = "UPDATE norma_waktu_komponen SET frekuensi_kegiatan = '$frekuensi_kegiatan_loop', jumlah_beban_kerja = '$jbk_loop' WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$id_uraian_kegiatan_loop'";
      if (mysqli_query($conn, $updateQuery)) {
        // echo "Data berhasil diupdate.";
        echo '<script>document.location="index.php";</script>';
      } else {
        echo "Error updating record: " . mysqli_error($conn);
      }
    } else {
      echo "Data belum ada.";
    }
  }


  // Update tabel waktu_kerja_tersedia dengan data $total_jbk dan $stp
  $updateWaktuKerjaQuery = "UPDATE waktu_kerja_tersedia SET jumlah_kebutuhan_tenaga_tugas_pokok = ?, total_kebutuhan_tenaga = ? WHERE id_user = ? AND id_unit_kerja = ?";
  $stmtWaktuKerja = $conn->prepare($updateWaktuKerjaQuery);
  $stmtWaktuKerja->bind_param("ddii", $total_jbk, $tkt, $id_user, $id_unit_kerja);
  $stmtWaktuKerja->execute();

  // Menampilkan pesan sukses atau error jika diperlukan
  if ($stmtWaktuKerja->affected_rows > 0) {
    echo "Data berhasil diupdate.";
  } else {
    echo "Error updating record: " . $conn->error;
  }
} else {
  for ($i = 0; $i < 2; $i++) {
    $jbk_tampil[$i] = 0;
  }
  $total_jbk_tampil = 0;
  $tkt_tampil = 0;
}
?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Kebutuhan Tenaga</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../kebutuhantenaga/">Kebutuhan Tenaga</a>
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
      <p class="text-muted mt-0 font-12">Input dengan data yang valid.</code></p>
    </div>
    <div class="col-lg-8">
      <form class="mt-3" action="" method="post">
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
                          <input type="hidden" name="id_uraian_kegiatan[]" value="<?= $list['id_uraian_kegiatan']; ?>">
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-muted">SBK (Standar Beban Kerja)</small>
                                <input name="standar_beban_kerja[]" placeholder="0" type="text" class="form-control text-muted" id="standar_beban_kerja" aria-describedby="menit" value="<?= $list['standar_beban_kerja']; ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-muted">Frekuensi Kegiatan (Jumlah Hasil Kerja)</small>
                                <input name="frekuensi_kegiatan[]" type="number" class="form-control" id="satuan" aria-describedby="satuan" placeholder="Ketik disini" value="<?= $list['frekuensi_kegiatan']; ?>">
                                <small id="satuan" class="form-text text-muted fst-italic">*Berapa <?= $list['satuan']; ?></small>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <!-- <div class="col">
                          <div class="form-group">
                            <small id="menit" class="form-text text-info">WKE (Waktu Kerja Efektif)</small>
                            <input type="text" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="74760" readonly>
                          </div>
                        </div> -->
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-info">Jumlah Beban Kerja</small>
                                <input name="jumlah_beban_kerja" type="text" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= $list['jumlah_beban_kerja']; ?>" placeholder="0" readonly disabled>
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
          </div>
          <!-- buatkan tombol hitung -->
          <div class="card-footer d-flex align-items-center justify-content-center">
            <button type="submit" class="btn btn-rounded btn-info">Hitung</button>
          </div>
          <!-- <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
        </div>
      </form>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Total</h4>
          <table class="table">
            <tbody>
              <tr>
                <form class="mt-3">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="menit" class="form-text text-info">Jumlah Kebutuhan Tenaga Tugas Pokok</small>
                        <input type="number" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="<?= $data['jumlah_kebutuhan_tenaga_tugas_pokok']; ?>" placeholder="0" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="satuan" class="form-text text-info">Standar Tugas Penunjang</small>
                        <input type="number" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= $data['standar_tugas_penunjang']; ?>" placeholder="0" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="satuan" class="form-text text-info">Total Kebutuhan Tenaga (JKT x STP)</small>
                        <input type="number" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= $data['total_kebutuhan_tenaga']; ?>" placeholder="0" readonly>
                      </div>
                    </div>
                  </div>
                </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 d-flex justify-content-between">
      <a href="../standartugaspenunjang/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
      <a href="../dashboard/" class="btn btn-lg btn-rounded btn-info">Selesai</a>
    </div>
  </div>

</div>
<?php include '../template/footer.php' ?>