<?php include '../template/header.php' ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Menetapkan Waktu Kerja Tersedia</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="../dashboard/">Dashboard / </a><a href="../jabatan&unitkerja/">Waktu Kerja Tersedia</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="col-5">
      <div class="customize-input float-end">
        <form>
          <input class="form-control custom-shadow custom-radius border-0 bg-white custom-lh" type="search" placeholder="Search" aria-label="Search">
        </form>
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
      <h4 class="mb-0 text-info">Unit Kerja Rekam Medis (Sub Unit Penyimpanan Rekam Medis)</h4>
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
                  <td>Jam Kerja Formal Per Minggu</td>
                  <td>40 Jam</td>
                </tr>
                <tr>
                  <td>Waktu Luang (Allowance)</td>
                  <td>30%</td>
                </tr>
                <tr>
                  <td>Jam Kerja Efektif Per Minggu</td>
                  <td>28 Jam</td>
                </tr>
                <tr>
                  <td>Jam Kerja Efektif Per Hari (Pola 6 Hari)*</td>
                  <td>4.67 Jam</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- buatkan tombol hitung -->
        <div class="card-footer d-flex align-items-center justify-content-center">
          <button class="btn btn-rounded btn-info">Hitung</button>
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
                  <td>365 Hari</td>
                </tr>
                <tr>
                  <td>Jumlah Hari Libur (Minggu)</td>
                  <td>52 Hari</td>
                </tr>
                <tr>
                  <td>Libur Resmi</td>
                  <td>34 Hari</td>
                </tr>
                <tr>
                  <td>Libur Cuti</td>
                  <td>12 Hari</td>
                </tr>
                <tr>
                  <td>Hari Kerja Efektif</td>
                  <td>267 Hari</td>
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
          <h4 class="card-title">Waktu Kerja Efektif Per Tahun</h4>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>Waktu Kerja Efektif (6 Hari Kerja)*</td>
                  <td>1.246 Jam</td>
                  <td>74.760 Menit</td>
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

</div>
<?php include '../template/footer.php' ?>