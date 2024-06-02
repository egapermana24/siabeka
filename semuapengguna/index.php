<?php
include '../template/header.php';
include '../database/koneksi.php';
// // FOR DEBUGGING
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

$query = "SELECT * FROM tb_user JOIN waktu_kerja_tersedia ON tb_user.id_user = waktu_kerja_tersedia.id_user JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja";
$result = mysqli_query($conn, $query);

$selectedColumns = [
  'waktu_kerja_efektif_menit', 'total_faktor_tugas_penunjang',
  'standar_tugas_penunjang', 'jumlah_kebutuhan_tenaga_tugas_pokok',
  'total_kebutuhan_tenaga'
];

$query_user = "SELECT * FROM tb_user";
$hasil = mysqli_query($conn, $query_user);

// buat kondisi jika mahasiswa belum melakukan perhitungan dengan cara mencari data di tabel norma_waktu_komponen
?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Data Pengguna</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Data Seluruh Pengguna Yang Menggunakan Sistem</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="col-5 align-self-center">
      <div class="customize-input float-end">
        <!-- buatkan button tambah data -->
        <a type="button" class="btn btn-primary" href="../tambahpengguna/">Tambah Data</a>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
              <thead>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">Aksi</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Tanggal Lahir</th>
                  <th>Level</th>
                  <!-- <th>Kondisi</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                while ($user = mysqli_fetch_assoc($hasil)) {
                  $id_user = $user['id_user'];

                  // Cek apakah id_user ada di tabel norma_waktu_komponen
                  $cekNormaQuery = "SELECT * FROM norma_waktu_komponen WHERE id_user = '$id_user'";
                  $cekNormaResult = mysqli_query($conn, $cekNormaQuery);

                  if (mysqli_num_rows($cekNormaResult) > 0) {
                    // Cek total_kebutuhan_tenaga pada tabel waktu_kerja_tersedia
                    $cekWaktuQuery = "SELECT total_kebutuhan_tenaga FROM waktu_kerja_tersedia WHERE id_user = '$id_user'";
                    $cekWaktuResult = mysqli_query($conn, $cekWaktuQuery);
                    $cekWaktuData = mysqli_fetch_assoc($cekWaktuResult);

                    if ($cekWaktuData['total_kebutuhan_tenaga'] != NULL && $cekWaktuData['total_kebutuhan_tenaga'] != 0) {
                      $color = "success";
                      $status = "Selesai Menghitung";
                    } else {
                      $color = "warning";
                      $status = "Sedang Menghitung";
                    }
                  } else {
                    $color = "danger";
                    $status = "Belum Menghitung";
                  }
                ?>
                  <tr class="fs-6">
                    <td>
                      <button class="badge rounded-pill text-bg-danger text-white border-0" data-bs-target="#delete-pengguna<?= $user['id_user']; ?>" data-bs-toggle="modal">delete</button>
                      <form action="../editpengguna/" method="post">
                        <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                        <button type="submit" class="badge rounded-pill text-bg-primary text-white border-0">edit</button>
                      </form>
                    </td>
                    <td><?= $user['nama']; ?></td>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['tanggal_lahir']; ?></td>
                    <td><?= $user['level']; ?></td>
                    <!-- <td><button type="button" class="btn btn-<?= $color; ?> text-white btn-rounded btn-sm"><?= $status; ?></button></td> -->
                  </tr>
                  <div id="delete-pengguna<?= $user['id_user']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-penggunaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-danger">
                          <h4 class="modal-title" id="delete-penggunaLabel">Konfirmasi
                          </h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                          <h5 class="mt-0">Apakah Anda Yakin Ingin Menghapus User bernama <strong><?= $user['nama']; ?></strong>?</h5>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                          <form action="deletepengguna.php" method="post">
                            <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                            <button type="submit" class="btn btn-danger text-white border-0">Hapus</button>
                          </form>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                <?php
                }
                ?>
              </tbody>

              <!-- <tfoot>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">Aksi</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Tanggal Lahir</th>
                  <th>Level</th>
                  <th>Kondisi</th>
                </tr>
              </tfoot> -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Data Mahasiswa</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li><a class="text-muted fs-6" href="#">Data Seluruh Mahasiswa Yang Sudah Melakukan Perhitungan</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="default_order" class="table border table-striped table-bordered text-nowrap">
              <thead>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">Aksi</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Unit Kerja</th>
                  <th>Progress</th>
                  <th>Waktu Kerja <br> Efektif</th>
                  <th>Standar Tugas <br> Penunjang</th>
                  <th>Jumlah Kebutuhan <br> Tenaga Tugas Pokok</th>
                  <th>Total Kebutuhan <br> Tenaga</th>
                </tr>
              </thead>
              <tbody>
                <?php

                while ($row = mysqli_fetch_assoc($result)) {
                  // Hitung jumlah kolom yang tidak 0 atau NULL
                  $totalColumns = count($selectedColumns);
                  $filledColumns = 0;

                  if ($row['waktu_kerja_efektif_menit'] != 0 && $row['waktu_kerja_efektif_menit'] != NULL) {
                    $filledColumns += 1;
                  }
                  if ($row['total_faktor_tugas_penunjang'] != 0 && $row['total_faktor_tugas_penunjang'] != NULL) {
                    $filledColumns += 1;
                  }
                  if ($row['standar_tugas_penunjang'] != 0 && $row['standar_tugas_penunjang'] != NULL) {
                    $filledColumns += 1;
                  }
                  if ($row['jumlah_kebutuhan_tenaga_tugas_pokok'] != 0 && $row['jumlah_kebutuhan_tenaga_tugas_pokok'] != NULL) {
                    $filledColumns += 1;
                  }
                  if ($row['total_kebutuhan_tenaga'] != 0 && $row['total_kebutuhan_tenaga'] != NULL) {
                    $filledColumns += 1;
                  }


                  // Hitung persentase data yang diisi untuk baris saat ini
                  $percentage = ($filledColumns / $totalColumns) * 100;
                ?>
                  <tr class="fs-6">
                    <!-- buatkan tombol aksi -->
                    <td>
                      <button class="badge rounded-pill text-bg-primary text-white border-0" data-bs-target="#reset-pengguna<?= $row['id_user']; ?><?= $row['id_unit_kerja']; ?>" data-bs-toggle="modal">delete</button>
                    </td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td class="text-truncate"><?= $row['nama_unit_kerja']; ?></td>
                    <td class="text-center">
                      <div class="progress mb-2 progress-md">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="text-center"><?= $percentage ?>%</small>
                    </td>
                    <td><?= $row['waktu_kerja_efektif_menit']; ?></td>
                    <td><?= $row['standar_tugas_penunjang']; ?></td>
                    <td><?= $row['jumlah_kebutuhan_tenaga_tugas_pokok']; ?></td>
                    <td><?= $row['total_kebutuhan_tenaga']; ?></td>
                  </tr>
                  <div id="reset-pengguna<?= $row['id_user']; ?><?= $row['id_unit_kerja']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reset-penggunaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                          <h4 class="modal-title" id="reset-penggunaLabel">Konfirmasi
                          </h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                          <h5 class="mt-0">Apakah Anda Yakin Ingin Mereset Data User bernama <strong><?= $row['nama']; ?></strong>, dengan <strong><?= $row['nama_unit_kerja']; ?></strong>?</h5>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                          <form action="resetpengguna.php" method="post">
                            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                            <input type="hidden" name="id_unit_kerja" value="<?= $row['id_unit_kerja']; ?>">
                            <button type="submit" class="btn btn-primary text-white border-0">Reset</button>
                          </form>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                <?php
                }
                ?>
              </tbody>
              <!-- <tfoot>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">Aksi</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Waktu Kerja <br> Efektif</th>
                  <th>Standar Tugas <br> Penunjang</th>
                  <th>Jumlah Kebutuhan <br> Tenaga Tugas Pokok</th>
                  <th>Total Kebutuhan <br> Tenaga</th>
                  <th>Unit Kerja</th>
                </tr>
              </tfoot> -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include '../template/footer.php';
?>