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

if (isset($_POST['qty_tugas_penunjang'])) {
  $id_unit_kerja = $data['id_unit_kerja'];
  $id_uraian_kegiatan = $_POST['id_uraian_kegiatan'];
  $qty_tugas_penunjang = $_POST['qty_tugas_penunjang'];
  $waktu_kerja_efektif_menit = $_POST['waktu_kerja_efektif_menit'];
  $norma_waktu = $_POST['norma_waktu'];

  // Inisialisasi variabel untuk menyimpan hasil perhitungan
  $hasil_pembagian = array();
  $ftp = array();
  $ftp_tampil = array();
  $total_ftp = 0;
  $total_ftp_tampil = 0;
  $stp = 0;
  $stp_tampil = 0;

  // Iterasi untuk setiap elemen dalam array
  for ($i = 0; $i < count($qty_tugas_penunjang); $i++) {
    $hasil_pembagian[$i] = $norma_waktu[$i] * $qty_tugas_penunjang[$i];
    $ftp[$i] = $hasil_pembagian[$i] / $waktu_kerja_efektif_menit[$i];
    $ftp_tampil[$i] = number_format($ftp[$i], 4, '.', '');
    $total_ftp += $ftp[$i]; // Menambahkan nilai ftp ke total_ftp
  }

  // Menghitung nilai stp
  $stp = 1 / (1 - $total_ftp);
  $stp_tampil = number_format($stp, 6, '.', '');

  for ($i = 0; $i < count($qty_tugas_penunjang); $i++) {
    $id_uraian_kegiatan_loop = mysqli_real_escape_string($conn, $id_uraian_kegiatan[$i]); // Variabel untuk menyimpan id_uraian_kegiatan di setiap iterasi
    $qty_tugas_penunjang_loop = mysqli_real_escape_string($conn, $qty_tugas_penunjang[$i]); // Variabel untuk menyimpan qty_tugas_penunjang di setiap iterasi
    $ftp_loop = mysqli_real_escape_string($conn, $ftp[$i]); // Variabel untuk menyimpan ftp di setiap iterasi
    // Query untuk mencari apakah data dengan id_user, id_unit_kerja, dan id_uraian_kegiatan tersebut sudah ada di tabel
    $checkQuery = "SELECT * FROM norma_waktu_komponen WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$id_uraian_kegiatan_loop'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      // Jika data sudah ada, lakukan update
      $updateQuery = "UPDATE norma_waktu_komponen SET qty_tugas_penunjang = '$qty_tugas_penunjang_loop', faktor_tugas_penunjang = '$ftp_loop' WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$id_uraian_kegiatan_loop'";
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


  // Update tabel waktu_kerja_tersedia dengan data $total_ftp dan $stp
  $updateWaktuKerjaQuery = "UPDATE waktu_kerja_tersedia SET total_faktor_tugas_penunjang = ?, standar_tugas_penunjang = ? WHERE id_user = ? AND id_unit_kerja = ?";
  $stmtWaktuKerja = $conn->prepare($updateWaktuKerjaQuery);
  $stmtWaktuKerja->bind_param("ddii", $total_ftp, $stp, $id_user, $id_unit_kerja);
  $stmtWaktuKerja->execute();

  // Menampilkan pesan sukses atau error jika diperlukan
  if ($stmtWaktuKerja->affected_rows > 0) {
    echo "Data berhasil diupdate.";
  } else {
    echo "Error updating record: " . $conn->error;
  }
} else {
  for ($i = 0; $i < 2; $i++) {
    $ftp_tampil[$i] = 0;
  }
  $total_ftp_tampil = 0;
  $stp_tampil = 0;
}

?>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Standar Tugas Penunjang</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../standartugaspenunjang/">Standar Tugas Penunjang</a>
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
      <p class="text-muted mt-0 font-12">Input dengan data yang valid.</code></p>
    </div>
    <div class="col-lg-8">
      <div class="card">
        <form class="mt-3" action="" method="post">
          <div class="card-body">
            <h4 class="card-title">Tugas Penunjang</h4>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <?php
                  if ($cek_penunjang) {
                    $index = 0; // Variabel untuk indeks array hasil perhitungan
                    while ($list = mysqli_fetch_assoc($query_deskripsi_penunjang)) {
                  ?>
                      <tr>
                        <td>
                          <span class="fw-medium"><?= $list['deskripsi']; ?></span>
                          <br>
                          <div class="row">
                            <div class="col">
                              <input type="hidden" name="id_uraian_kegiatan[]" value="<?= $list['id_uraian_kegiatan']; ?>">
                              <div class="form-group">
                                <small id="menit" class="form-text text-muted">Norma Waktu</small>
                                <input type="hidden" value="<?= $list['norma_waktu']; ?>" name="norma_waktu[]">
                                <input type="text" class="form-control text-muted" id="normaWaktu" aria-describedby="menit" value="<?= $list['norma_waktu']; ?> Menit" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-muted">Berapa <?= $list['satuan']; ?></small>
                                <input name="qty_tugas_penunjang[]" type="number" class="form-control" id="satuan" aria-describedby="satuan" placeholder="Ketik Disini" required value="<?= $list['qty_tugas_penunjang']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col">
                              <div class="form-group">
                                <small id="menit" class="form-text text-muted">WKE (Waktu Kerja Efektif)</small>
                                <input type="hidden" value="<?= $list['waktu_kerja_efektif_menit']; ?>" name="waktu_kerja_efektif_menit[]">
                                <input type="text" class="form-control text-muted" id="normaWaktu" aria-describedby="menit" value="<?= $list['waktu_kerja_efektif_menit']; ?>" readonly>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <small id="satuan" class="form-text text-info">FTP (Faktor Tugas Penunjang)</small>
                                <input type="text" class="form-control text-info" id="satuan" aria-describedby="satuan" placeholder="0" value="<?= number_format($list['faktor_tugas_penunjang'], 3); ?>" readonly>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php
                      $index++; // Increment indeks array hasil perhitungan
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
          <!-- buatkan tombol hitung -->
          <div class="card-footer d-flex align-items-center justify-content-center">
            <button type="submit" class="btn btn-rounded btn-info">Hitung</button>
          </div>
          <!-- <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
        </form>
      </div>
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
                        <small id="menit" class="form-text text-info">Faktor Tugas Penunjang (FTP) dalam %</small>
                        <input type="text" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="<?= number_format($data['total_faktor_tugas_penunjang'], 3); ?>" placeholder="0" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="satuan" class="form-text text-info">Standar Tugas Penunjang (STP)</small>
                        <input type="number" class="form-control text-info" id="satuan" aria-describedby="satuan" value="<?= number_format($data['standar_tugas_penunjang'], 6); ?>" placeholder="0" readonly>
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
      <a href="../standarbebankerja/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
      <a href="../kebutuhantenaga/" class="btn btn-lg btn-rounded btn-info">Selanjutnya</a>
    </div>
  </div>

</div>
<?php include '../template/footer.php' ?>