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

$query = "SELECT * FROM tb_user JOIN waktu_kerja_tersedia ON tb_user.id_user = waktu_kerja_tersedia.id_user JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja WHERE tb_user.id_user = '$id_user'";
$result = mysqli_query($conn, $query);

$selectedColumns = [
  'waktu_kerja_efektif_menit', 'total_faktor_tugas_penunjang',
  'standar_tugas_penunjang', 'jumlah_kebutuhan_tenaga_tugas_pokok',
  'total_kebutuhan_tenaga'
];

$query_user = "SELECT * FROM tb_user";
$hasil = mysqli_query($conn, $query_user);

$query_pilihan = mysqli_query($conn, "SELECT unit_kerja.*, waktu_kerja_tersedia.dipilih
FROM unit_kerja
LEFT JOIN waktu_kerja_tersedia ON unit_kerja.id_unit_kerja = waktu_kerja_tersedia.id_unit_kerja AND waktu_kerja_tersedia.id_user = '$id_user'");

// buat kondisi jika mahasiswa belum melakukan perhitungan dengan cara mencari data di tabel norma_waktu_komponen
?>

<div class="page-breadcrumb">

  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-lg-6 col-sm-12 align-self-center">
        <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Data Riwayat Perhitungan</h3>
        <div class="d-flex align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 p-0">
              <li><a class="text-muted fs-6" href="#">Data Perhitungan Unit Kerja Yang Kamu Pilih</a>
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="col-lg-6 col-sm-12 mb-3">
        <div class="customize-input float-end">
          <form class="mt-4" action="proses.php" method="POST">
            <div class="input-group">
              <select class="form-select" name="id_unit_kerja" id="inputGroupSelect04">
                <?php
                $unit_kerja_selected = false; // Variabel untuk menandai apakah sudah ada unit kerja yang dipilih
                while ($data_pilihan = mysqli_fetch_assoc($query_pilihan)) :
                  // Jika ada unit kerja yang dipilih, tandai variabel $unit_kerja_selected sebagai true
                  if ($data_pilihan['dipilih'] == 1) {
                    $unit_kerja_selected = true;
                  }
                ?>
                  <option value="<?= $data_pilihan['id_unit_kerja']; ?>" <?= ($data_pilihan['dipilih'] == 1) ? 'selected' : ''; ?>>
                    <?= $data_pilihan['nama_unit_kerja']; ?>
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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="default_order" class="table border table-striped table-bordered text-nowrap">
                <thead>
                  <tr class="text-uppercase fs-6 text-primary">
                    <th class="text-center">Aksi</th>
                    <th>Unit Kerja</th>
                    <th>Progress</th>
                    <th>Status</th>
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

                    if ($row['dipilih'] == 1) {
                      $status = "Aktif";
                      $color = "bg-success";
                    } else {
                      $status = "Tidak Aktif";
                      $color = "bg-danger";
                    }
                  ?>
                    <tr class="fs-6">
                      <!-- buatkan tombol aksi -->
                      <td>
                        <button class="badge rounded-pill text-bg-primary text-white border-0" data-bs-target="#reset-pengguna<?= $id_user; ?><?= $row['id_unit_kerja']; ?>" data-bs-toggle="modal">delete</button>
                      </td>
                      <td class="text-truncate"><?= $row['nama_unit_kerja']; ?></td>
                      <td class="text-center">
                        <div class="progress mb-2 progress-md">
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-center"><?= $percentage ?>%</small>
                      </td>
                      <td class="text-center">
                        <span class="badge rounded-pill <?= $color; ?> text-white"><?= $status; ?></span>
                      </td>
                      <td><?= $row['waktu_kerja_efektif_menit']; ?></td>
                      <td><?= $row['standar_tugas_penunjang']; ?></td>
                      <td><?= $row['jumlah_kebutuhan_tenaga_tugas_pokok']; ?></td>
                      <td><?= $row['total_kebutuhan_tenaga']; ?></td>
                    </tr>
                    <div id="reset-pengguna<?= $id_user; ?><?= $row['id_unit_kerja']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reset-penggunaLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header modal-colored-header bg-primary">
                            <h4 class="modal-title" id="reset-penggunaLabel">Konfirmasi
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                          </div>
                          <div class="modal-body">
                            <h5 class="mt-0">Apakah Anda Yakin Ingin Mereset Data <strong><?= $row['nama_unit_kerja']; ?></strong>?</h5>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                            <form action="resetpengguna.php" method="post">
                              <input type="hidden" name="id_user" value="<?= $id_user; ?>">
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