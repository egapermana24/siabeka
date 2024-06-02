            <?php
            include '../template/header.php';
            include '../database/koneksi.php';
            date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu sesuai dengan lokasi Anda

            $waktu = date('H'); // Ambil jam saat ini dalam format 24 jam

            if ($waktu >= 0 && $waktu < 10) {
              $ucapan = 'Selamat Pagi ';
            } elseif ($waktu >= 10 && $waktu < 15) {
              $ucapan = 'Selamat Siang ';
            } elseif ($waktu >= 15 && $waktu < 18) {
              $ucapan = 'Selamat Sore ';
            } else {
              $ucapan = 'Selamat Malam ';
            }

            $query = mysqli_query($conn, "SELECT * FROM unit_kerja");

            $cek_user = "SELECT waktu_kerja_tersedia.*, unit_kerja.*, uraian_kegiatan.deskripsi FROM waktu_kerja_tersedia INNER JOIN uraian_kegiatan ON waktu_kerja_tersedia.id_unit_kerja = uraian_kegiatan.id_unit_kerja INNER JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja WHERE waktu_kerja_tersedia.id_user = '$id_user' AND uraian_kegiatan.jenis_tugas = 'pokok' AND waktu_kerja_tersedia.dipilih = 1";
            $result_pokok = mysqli_query($conn, $cek_user);
            $cek_user = $result_pokok;
            $cek_pokok = mysqli_num_rows($result_pokok) > 0;

            $query_unit = "SELECT *
            FROM waktu_kerja_tersedia
            JOIN unit_kerja ON waktu_kerja_tersedia.id_unit_kerja = unit_kerja.id_unit_kerja
            WHERE waktu_kerja_tersedia.id_user = '$id_user' AND waktu_kerja_tersedia.dipilih = 1";
            $result_unit = mysqli_query($conn, $query_unit);
            $data = mysqli_fetch_assoc($result_unit);

            $query_pilihan = mysqli_query($conn, "SELECT unit_kerja.*, waktu_kerja_tersedia.dipilih
                              FROM unit_kerja
                              LEFT JOIN waktu_kerja_tersedia ON unit_kerja.id_unit_kerja = waktu_kerja_tersedia.id_unit_kerja AND waktu_kerja_tersedia.id_user = '$id_user'");
            ?>
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
              <div class="row">
                <div class="col-lg-6 col-sm-9 align-self-center">
                  <h3 class="page-title text-truncate text-primary font-weight-medium mb-1"> <?= $ucapan,  $row['nama']; ?>!</h3>
                  <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                        </li>
                      </ol>
                    </nav>
                  </div>
                </div>
                <div class="col-lg-6 col-sm-3 align-self-center mt-3">
                  <!-- buat untuk menampilkan gmabar -->
                  <img src="../assets/img/logo_wisn.png" alt="logo-wisn" class="float-end" width="150" style="background-color: transparent;">
                </div>
              </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <!-- *************************************************************** -->
              <!-- Start First Cards -->
              <!-- *************************************************************** -->
              <div class="row">
                <?php
                // menampilkan hanya jika id_user ada di tabel waktu_kerja_tersedia
                if (mysqli_num_rows($result_unit) > 0) {
                ?>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card border-end">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div>
                            <div class="d-inline-flex align-items-center">
                              <h2 class="text-dark mb-1 font-weight-medium"><?= number_format($data['waktu_kerja_efektif_menit']); ?></h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">WKE (Menit)
                            </h6>
                          </div>
                          <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card border-end ">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><?= number_format($data['jumlah_kebutuhan_tenaga_tugas_pokok'], 3); ?></h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">JKT
                            </h6>
                          </div>
                          <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card border-end ">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div>
                            <div class="d-inline-flex align-items-center">
                              <h2 class="text-dark mb-1 font-weight-medium"><?= number_format($data['standar_tugas_penunjang'], 2); ?></h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">STP
                            </h6>
                          </div>
                          <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card ">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div>
                            <h2 class="text-dark mb-1 font-weight-medium"><?= number_format($data['total_kebutuhan_tenaga'], 3); ?></h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">TKT</h6>
                          </div>
                          <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <!-- *************************************************************** -->
              <!-- End First Cards -->
              <!-- *************************************************************** -->
              <!-- *************************************************************** -->
              <!-- Start Sales Charts Section -->
              <!-- *************************************************************** -->
              <div class="row">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
                      <h4 class="mb-0 text-info">Data Kategori Unit Kerja</h4>
                      <p class="text-muted mt-0 font-12">Ini adalah Unit Kerja Yang Kamu Pilih.</code></p>
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
                    <div class="col-md-12">
                      <div class="card text-white bg-primary">
                        <div class="card-body">
                          <h3 class="card-title text-white">UNIT KERJA</h3>
                          <p class="card-text"><?= $data['nama_unit_kerja']; ?></p>
                          <a href="../waktukerjatersedia/" class="btn btn-dark">Lanjutkan/Edit Perhitungan</a>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="card text-white bg-primary">
                        <div class="card-body">
                          <h4 class="card-title text-white">Tugas Pokok</h4>
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>

                                <?php
                                while ($user = mysqli_fetch_assoc($cek_user)) {
                                ?>
                                  <tr>
                                    <td class="text-white"><?= $user['deskripsi']; ?></td>
                                  </tr>
                                <?php
                                } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                } else { ?>
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
                            <form action="../jabatan&unitkerja/proses.php" method="post">
                              <input type="hidden" name="id_unit_kerja" value="<?= $data['id_unit_kerja']; ?>">
                              <input type="hidden" name="dipilih" value="1">
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
              </div>

              <?php include '../template/footer.php' ?>