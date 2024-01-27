<?php include '../template/header.php' ?>
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
      <h4 class="mb-0 text-info">Menghitung Kebutuhan Tenaga</h4>
      <p class="text-muted mt-0 font-12">Input dengan data yang valid.</code></p>
    </div>
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tugas Pokok</h4>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>Mengece logistic percetakan lembar rekam medis dan menata di rak penyimpanan sesuai kotak lembar
                    <br>
                    <form class="mt-3">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <small id="menit" class="form-text text-muted">SBK (Standar Beban Kerja)</small>
                            <input type="text" class="form-control" id="normaWaktu" aria-describedby="menit" value="14952" readonly>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small id="satuan" class="form-text text-muted">Frekuensi Kegiatan (Jumlah Hasil Kerja)</small>
                            <input type="number" class="form-control" id="satuan" aria-describedby="satuan" placeholder="Berapa Lembar">
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
                            <input type="text" class="form-control text-info" id="satuan" aria-describedby="satuan" value="0.0134" readonly>
                          </div>
                        </div>
                      </div>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- buatkan tombol hitung -->
        <div class="card-footer d-flex align-items-center justify-content-center">
          <button class="btn btn-rounded btn-info">Hitung</button>
        </div>
        <!-- <div class="card-footer d-flex align-items-center justify-content-evenly">
          <button class="btn btn-rounded btn-danger">Reset</button>
          <button class="btn btn-rounded btn-info">Simpan</button>
        </div> -->
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
                        <small id="menit" class="form-text text-info">Jumlah Kebutuhan Tenaga Tugas Pokok</small>
                        <input type="text" class="form-control text-info" id="normaWaktu" aria-describedby="menit" value="1.640" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="satuan" class="form-text text-info">Standar Tugas Penunjang</small>
                        <input type="number" class="form-control text-info" id="satuan" aria-describedby="satuan" value="1.02" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <small id="satuan" class="form-text text-info">Total Kebutuhan Tenaga (JKT x STP)</small>
                        <input type="number" class="form-control text-info" id="satuan" aria-describedby="satuan" value="1.675" readonly>
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