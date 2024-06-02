            <?php include '../template/header.php';
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
            // jika yang login bukan level admin maka tendang ke halaman sebelumnya
            if ($row['level'] != 'admin') {
              echo "<script>document.location='../dashboard/';</script>";
            }

            // mengambil data total user yang level 'user' pada tabel tb_user
            $query_user = mysqli_query($conn, "SELECT * FROM tb_user WHERE level='user'");
            $total_user = mysqli_num_rows($query_user);
            if ($total_user < 10) {
              $total_user = '0' . $total_user;
            }

            // mencari data yang sudah di hitung dari total_kebutuhan_tenaga di tabel waktu_kerja_tersedia
            $query_selesai = mysqli_query($conn, "SELECT * FROM waktu_kerja_tersedia WHERE total_kebutuhan_tenaga != 0 OR total_kebutuhan_tenaga != NULL");
            $total_selesai = mysqli_num_rows($query_selesai);
            if ($total_selesai < 10) {
              $total_selesai = '0' . $total_selesai;
            }

            // mencari data yang belum dihitung dari total_kebutuhan_tenaga di tabel waktu_kerja_tersedia
            $query_belum = mysqli_query($conn, "SELECT * FROM waktu_kerja_tersedia WHERE total_kebutuhan_tenaga IS NULL");
            $total_belum = mysqli_num_rows($query_belum);
            if ($total_belum < 10) {
              $total_belum = '0' . $total_belum;
            }

            $query_total = mysqli_query($conn, "SELECT * FROM waktu_kerja_tersedia");
            $total = mysqli_num_rows($query_total);
            if ($total < 10) {
              $total = '0' . $total;
            }


            // mencari total kebutuhan tenaga terbesar
            $query_tkt = mysqli_query($conn, "SELECT MAX(total_kebutuhan_tenaga) AS total_kebutuhan FROM waktu_kerja_tersedia");
            $tkt = mysqli_fetch_array($query_tkt);

            $query = "SELECT tb_user.*, MAX(login.tgl_login) AS tgl_login
            FROM tb_user
            JOIN login ON tb_user.id_user = login.id_user  
            WHERE tb_user.level='user' 
            GROUP BY tb_user.id_user
            ORDER BY tgl_login DESC 
            LIMIT 10";



            $result = mysqli_query($conn, $query);

            // Query SQL untuk mengambil data login berdasarkan hari dengan batasan 7 hari terbaru
            $sql = "SELECT DAYNAME(tgl_login) as hari, COUNT(*) as jumlah_login FROM login GROUP BY DAYNAME(tgl_login) ORDER BY tgl_login DESC LIMIT 7";
            $result_chart = mysqli_query($conn, $sql);

            // Inisialisasi array untuk menyimpan data label dan data jumlah login
            $labels = [];
            $jumlahLogin = [];

            // Loop untuk mengambil data dari hasil query
            while ($row_chart = mysqli_fetch_assoc($result_chart)) {
              $labels[] = $row_chart['hari'];
              $jumlahLogin[] = $row_chart['jumlah_login'];
            }
            ?>
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
              <div class="row">
                <div class="col-lg-6 col-sm-9 align-self-center">
                  <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"> <?= $ucapan,  $row['nama']; ?>!</h3>
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
                <div class="col-sm-6 col-lg-3">
                  <div class="card border-end">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $total_user; ?></h2>
                          </div>
                          <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Mahasiswa
                          </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                          <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
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
                          <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><?= $total_belum; ?></h2>
                          <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Belum dihitung
                          </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                          <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
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
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $total_selesai; ?></h2>
                          </div>
                          <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Data Selesai dihitung
                          </h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                          <span class="opacity-7 text-muted"><i data-feather="file-plus"></i></span>
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
                          <h2 class="text-dark mb-1 font-weight-medium"><?= number_format($tkt['total_kebutuhan'], 2); ?></h2>
                          <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Kebutuhan Tenaga Terbesar</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                          <span class="opacity-7 text-muted"><i data-feather="globe"></i></span>
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
                <div class="col-lg-4 col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Total Data Perhitungan Unit Kerja</h4>
                      <!-- <div id="campaign-oke" class="mt-2" style="height:283px; width:100%;"></div> -->

                      <div>
                        <canvas id="pie-chart" height="150"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8 col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Data Pengguna Login</h4>
                      <div>
                        <canvas id="line-chart" height="150"></canvas>
                      </div>
                      <!-- <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                      <ul class="list-inline text-center mt-5 mb-2">
                        <li class="list-inline-item text-muted fst-italic">12</li>
                      </ul> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Data Mahasiswa</h4>
                        <div class="ms-auto">
                          <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                              <a class="dropdown-item" href="../semuapengguna/">Lihat Selengkapnya</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                          <thead>
                            <tr class="border-0">
                              <th class="border-0 font-14 font-weight-medium text-muted">Mahasiswa</th>
                              <th class="border-0 font-14 font-weight-medium text-muted">NIM</th>
                              <th class="border-0 font-14 font-weight-medium text-muted">Tanggal Lahir</th>
                              <th class="border-0 font-14 font-weight-medium text-muted">Terakhir Aktif</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) :
                              $tgl_login = strtotime($row['tgl_login']);
                              $now = time();

                              // Hitung selisih waktu dalam detik
                              $selisih = $now - $tgl_login;

                              // Konversi ke format yang diinginkan
                              if ($selisih < 60) {
                                $hasil = 'Semenit lalu';
                              } elseif ($selisih < 3600) {
                                $hasil = round($selisih / 60) . ' Menit lalu';
                              } elseif ($selisih < 86400) {
                                $hasil = round($selisih / 3600) . ' Jam lalu';
                              } elseif ($selisih < 172800) {
                                $hasil = 'Kemarin';
                              } elseif ($selisih < 604800) {
                                $hasil = round($selisih / 86400) . ' Hari lalu';
                              } elseif ($selisih < 2592000) {
                                $hasil = round($selisih / 604800) . ' Minggu lalu';
                              } else {
                                $hasil = round($selisih / 2592000) . ' Bulan lalu';
                              }
                            ?>
                              <tr>
                                <td class="border-top-0 px-2 py-4">
                                  <div class="d-flex no-block align-items-center">
                                    <div class="me-3">
                                      <img src="../assets/img/<?= !empty($row['foto']) ? $row['foto'] : 'user.png'; ?>" alt="user" class="rounded-circle" width="45" height="45" />
                                    </div>

                                    <div class="">
                                      <h5 class="text-dark mb-0 font-16 font-weight-medium"><?= $row['nama']; ?></h5>
                                      <span class="text-muted font-14"><?= $row['username']; ?></span>
                                    </div>
                                  </div>
                                </td>
                                <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row['username']; ?></td>
                                <td class="font-weight-medium text-dark border-top-0 px-2 py-4"><?= $row['tanggal_lahir']; ?></td>
                                <td class="border-top-0 px-2 py-4"><?= $hasil; ?></td>
                              </tr>
                            <?php endwhile; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- *************************************************************** -->
              <!-- End Top Leader Table -->
              <!-- *************************************************************** -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <script>
              new Chart(document.getElementById("pie-chart"), {
                type: 'pie',
                data: {
                  labels: ["Total Selesai", "Total Belum"],
                  datasets: [{
                    label: "Data Perhitungan Unit Kerja",
                    backgroundColor: ["#5e73da", "#b1bdfa"],
                    data: [<?= $total_selesai; ?>, <?= $total_belum; ?>]
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'Total Data Perhitungan Unit Kerja'
                  },
                  legend: {
                    position: 'bottom', // Posisi legenda di bagian bawah
                    labels: {
                      fontColor: 'black' // Warna teks legenda
                    }
                  }
                }
              });

              new Chart(document.getElementById("line-chart"), {
                type: 'line',
                data: {
                  labels: <?php echo json_encode(array_reverse($labels));
                          ?>,
                  datasets: [{
                    data: <?php echo json_encode(array_reverse($jumlahLogin));
                          ?>,
                    label: "Data Pengguna Login",
                    borderColor: "#5f76e8",
                    fill: false
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'Jumlah Login Per Hari (7 Hari Terbaru)'
                  }
                }
              });
            </script>




            <?php include '../template/footer.php' ?>