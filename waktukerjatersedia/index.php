<?php
include '../template/header.php';
include '../database/koneksi.php';

$query_check = mysqli_query($conn, "
    SELECT * FROM waktu_kerja_tersedia WHERE id_user = $id_user AND dipilih = 1
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

$query = mysqli_query($conn, "
    SELECT *
    FROM waktu_kerja_tersedia
    JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja
    WHERE waktu_kerja_tersedia.id_user = $id_user AND waktu_kerja_tersedia.dipilih = 1
");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['jam_kerja'])) {
  $id_unit_kerja = $data['id_unit_kerja'];
  $jam_kerja = $_POST['jam_kerja'];
  $waktu_luang = $_POST['waktu_luang'];
  $pola_hari_kerja = $_POST['pola_hari_kerja'];
  $hari_tahun = $_POST['hari_tahun'];
  $jumlah_hari_minggu = $_POST['jumlah_hari_minggu'];
  $libur_resmi = $_POST['libur_resmi'];
  $libur_cuti = $_POST['libur_cuti'];
  // buat perhitungan untuk jam_kerja_efektif
  $perminggu = $jam_kerja * $waktu_luang;
  $jam_kerja_perminggu = $jam_kerja - $perminggu;
  $jam_kerja_efektif = $jam_kerja_perminggu / $pola_hari_kerja;
  $jam_kerja_efektif_tampil = number_format($jam_kerja_efektif, 2);

  // buat perhitungan untuk hari_kerja_efektif
  $hari_kerja_efektif = $hari_tahun - ($jumlah_hari_minggu + $libur_resmi + $libur_cuti);

  $waktu_kerja_efektif_jam_def = (($jam_kerja_efektif * $hari_kerja_efektif) / 100) * 100;
  $waktu_kerja_efektif_menit_def = $waktu_kerja_efektif_jam_def * 60;
  $waktu_kerja_efektif_jam = number_format($waktu_kerja_efektif_jam_def);
  $waktu_kerja_efektif_menit = number_format($waktu_kerja_efektif_menit_def);

  if (isset($id_user) && $id_user != '') {
    // Jika sudah ada, lakukan operasi UPDATE
    $sql_update = "UPDATE waktu_kerja_tersedia SET
                      jam_kerja = '$jam_kerja',
                      waktu_luang = '$waktu_luang',
                      pola_hari_kerja = '$pola_hari_kerja',
                      hari_tahun = '$hari_tahun',
                      jumlah_hari_minggu = '$jumlah_hari_minggu',
                      libur_resmi = '$libur_resmi',
                      libur_cuti = '$libur_cuti',
                      jam_kerja_efektif_perminggu = '$jam_kerja_perminggu',
                      jam_kerja_efektif_perhari = '$jam_kerja_efektif',
                      hari_kerja_efektif = '$hari_kerja_efektif',
                      waktu_kerja_efektif_jam = '$waktu_kerja_efektif_jam_def',
                      waktu_kerja_efektif_menit = '$waktu_kerja_efektif_menit_def'
                  WHERE id_user = $id_user AND dipilih = 1";
    if ($conn->query($sql_update) === TRUE) {
      echo '<script>document.location="../waktukerjatersedia/";</script>';
    } else {
      echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
  } else {
    // Jika belum ada, lakukan operasi INSERT
    $sql_insert = "INSERT INTO waktu_kerja_tersedia (id_user, id_unit_kerja, jam_kerja, waktu_luang, pola_hari_kerja, hari_tahun, jumlah_hari_minggu, libur_resmi, libur_cuti, jam_kerja_efektif_perminggu, jam_kerja_efektif_perhari, hari_kerja_efektif, waktu_kerja_efektif_jam, waktu_kerja_efektif_menit)
                      VALUES ('$id_user', '$id_unit_kerja', '$jam_kerja', '$waktu_luang', '$pola_hari_kerja', '$hari_tahun', '$jumlah_hari_minggu', '$libur_resmi', '$libur_cuti', '$jam_kerja_efektif_perminggu', '$jam_kerja_efektif_perhari', '$hari_kerja_efektif', '$waktu_kerja_efektif_jam_def', '$waktu_kerja_efektif_menit_def')";
    if ($conn->query($sql_insert) === TRUE) {
      echo '<script>document.location="../waktukerjatersedia/";</script>';
    } else {
      echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
  }
} else {
  $jam_kerja = $data['jam_kerja'];
  $waktu_luang = $data['waktu_luang'];
  $pola_hari_kerja = $data['pola_hari_kerja'];
  $hari_tahun = $data['hari_tahun'];
  $jumlah_hari_minggu = $data['jumlah_hari_minggu'];
  $libur_resmi = $data['libur_resmi'];
  $libur_cuti = $data['libur_cuti'];
  $jam_kerja_perminggu = 0;
  $hari_kerja_efektif = 0;
  $waktu_kerja_efektif_jam = 0;
  $waktu_kerja_efektif_menit = 0;
  $jumlah_hari_minggu = "";
  $libur_resmi = "";
  $libur_cuti = "";
}
?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Waktu Kerja Efektif (Tersedia) </h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../jabatan&unitkerja/">Waktu Kerja Tersedia</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12 align-self-center">
      <p class="page-title text-dark mt-1 font-14">Waktu yang dipergunakan oleh SDMK untuk melaksanakan tugas dan kegiatannya dalam kurun waktu satu tahun, hitung jumlah hari kerja setahun perkirakan jumlah libur umum, cuti tahunan dan ketidakhadiran dalam setahun, kurangkan hari kerja setahun dengan jumlah hari masuk kerja. <br> <i>Sumber: kalender, kebijakan tentang hari dan jam kerja</i></p>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
  <form action="" method="post">
    <div class="row">
      <div class="col-12 mt-1">
        <h4 class="mb-0 text-info"><?= $data['nama_unit_kerja']; ?></h4>
        <p class="text-muted mt-0 font-12">Silahkan dihitung berdasarkan kebutuhan.</code></p>
      </div>
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Jam Kerja</h4>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Jam Kerja Formal Per Minggu
                      <br>
                      <br>
                      <!-- menambahkan keterangan -->
                      <small id="ket" class="text-muted">Keterangan:</small>
                      <br>
                      <small id="ket1" class="text-muted font-12">Berdasarkan Keppres No.68/1995 (37,5 jam)</small>
                      <br>
                      <small id="ket2" class="text-muted font-12 ">Berdasarkan UU No.13 Tahun 2003 (40 jam)</small>


                    </td>
                    <td>
                      <div class="customize-input">
                        <select required name="jam_kerja" class="custom-select custom-select-set form-control bg-white border-1 custom-shadow custom-radius">
                          <option hidden value="">Pilih</option>
                          <?php
                          if (isset($jam_kerja)) :
                          ?>
                            <option value=40 <?= ($jam_kerja == 40) ? 'selected' : ''; ?>>40 Jam</option>
                            <option value=37.5 <?= ($jam_kerja == 37.5) ? 'selected' : ''; ?>>37.5 Jam</option>
                          <?php else : ?>
                            <option value=40>40 Jam</option>
                            <option value=37.5>37.5 Jam</option>
                          <?php endif ?>
                        </select>
                      </div>
                      <br>

                    </td>
                  </tr>
                  <tr>
                    <td>Waktu Luang (Allowance)</td>
                    <td>
                      <div class="customize-input">
                        <select required name="waktu_luang" class="custom-select custom-select-set form-control bg-white border-1 custom-shadow custom-radius">
                          <option hidden value="">Pilih</option>
                          <?php
                          if (isset($waktu_luang)) :
                          ?>
                            <option value=0.2 <?= ($waktu_luang == 0.2) ? 'selected' : ''; ?>>20%</option>
                            <option value=0.25 <?= ($waktu_luang == 0.25) ? 'selected' : ''; ?>>25%</option>
                            <option value=0.3 <?= ($waktu_luang == 0.3) ? 'selected' : ''; ?>>30%</option>
                          <?php else : ?>
                            <option value=0.2>20%</option>
                            <option value=0.25>25%</option>
                            <option value=0.3>30%</option>
                          <?php endif ?>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Pola Kerja (Berapa Hari)</td>
                    <td>
                      <div class="customize-input">
                        <select required name="pola_hari_kerja" class="custom-select custom-select-set form-control bg-white border-1 custom-shadow custom-radius">
                          <option hidden value="">Pilih</option>
                          <?php
                          if (isset($pola_hari_kerja)) :
                          ?>
                            <option value=5 <?= ($pola_hari_kerja == 5) ? 'selected' : ''; ?>>5 Hari</option>
                            <option value=6 <?= ($pola_hari_kerja == 6) ? 'selected' : ''; ?>>6 Hari</option>
                          <?php else : ?>
                            <option value=5>5 Hari</option>
                            <option value=6>6 Hari</option>
                          <?php endif ?>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Jam Kerja Efektif Per Minggu</td>
                    <td><?= $data['jam_kerja_efektif_perminggu']; ?> Jam</td>
                  </tr>
                  <tr>
                    <td>Jam Kerja Efektif Per Hari (Pola 6 Hari)*</td>
                    <td><?= number_format($data['jam_kerja_efektif_perhari'], 2); ?> Jam</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Hari Kerja</h4>
            <h6 class="card-subtitle">(Hari Kerja Efektif/Pola 6 Hari Kerja)
            </h6>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Jumlah Hari per Tahun</td>
                    <td>
                      <div class="customize-input">
                        <select required name="hari_tahun" class="custom-select custom-select-set form-control bg-white border-1 custom-shadow custom-radius">
                          <option hidden value="">Pilih</option>
                          <?php
                          if (isset($hari_tahun)) :
                          ?>
                            <option value=365 <?= ($hari_tahun == 365) ? 'selected' : ''; ?>>365 Hari</option>
                            <option value=366 <?= ($hari_tahun == 366) ? 'selected' : ''; ?>>366 Hari</option>
                          <?php else : ?>
                            <option value=365>365 Hari</option>
                            <option value=366>366 Hari</option>
                          <?php endif ?>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Jumlah Hari Libur (Minggu)</td>
                    <td>
                      <div class="form-group">
                        <input name="jumlah_hari_minggu" type="number" class="form-control" min="1" aria-label="Jumlah hari" aria-describedby="basic-addon2" placeholder="52 Hari" value="<?= $data['jumlah_hari_minggu']; ?>" required>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Libur Resmi</td>
                    <td>
                      <div class="form-group">
                        <input name="libur_resmi" type="number" class="form-control" min="1" aria-label="Jumlah hari" aria-describedby="basic-addon2" placeholder="34 Hari" value="<?= $data['libur_resmi']; ?>" required>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Libur Cuti</td>
                    <td>
                      <div class="form-group">
                        <input name="libur_cuti" type="number" class="form-control" min="0" aria-label="Jumlah hari" aria-describedby="basic-addon2" placeholder="12 Hari" value="<?= $data['libur_cuti']; ?>" required>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Hari Kerja Efektif</td>
                    <td><?= $data['hari_kerja_efektif']; ?> Hari</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <!-- buatkan tombol hitung -->
            <div class="card-footer d-flex align-items-center justify-content-evenly">
              <button type="submit" class="btn btn-lg btn-rounded btn-info">Hitung</button>
              <!-- <button type="reset" class="btn btn-lg btn-rounded btn-secondary">Reset</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Waktu Kerja Efektif Per Tahun</h4>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Waktu Kerja Efektif (6 Hari Kerja)*</td>
                    <td><?= number_format($data['waktu_kerja_efektif_jam']); ?> Jam</td>
                    <td><?= number_format($data['waktu_kerja_efektif_menit']); ?> Menit</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>(Dalam Jam)</td>
                    <td>(Dalam Menit)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-between">
        <a href="../jabatan&unitkerja/" class="btn btn-lg btn-rounded btn-secondary">Kembali</a>
        <a href="../komponenbebankerja/" class="btn btn-lg btn-rounded btn-info">Selanjutnya</a>
      </div>
    </div>
  </form>
</div>
<?php include '../template/footer.php' ?>