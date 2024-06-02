<?php
include '../template/header.php';
include '../database/koneksi.php';


$query = mysqli_query($conn, "SELECT * FROM uraian_kegiatan");
$row = mysqli_fetch_array($query);

// mengambil unit_kerja
$unit_kerja = mysqli_query($conn, "SELECT * FROM unit_kerja");
$unit_kerja_row = mysqli_fetch_array($unit_kerja);

?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Tambah Uraian Kegiatan</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Tambah Uraian Kegiatan Baru</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 mt-2">
      <div class="card shadow-lg">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 col-lg-12 align-content-stretch">
              <div class="card shadow">
                <div class="card-body">
                  <h4 class="card-title mb-3">Tambah Uraian Kegiatan</h4>
                  <form action="proses.php" method="POST">
                    <div class="mb-2">
                      <label for="deskripsi" class="form-label">Deskripsi Uraian Kegiatan</label>
                      <input required type="text" class="form-control" id="Deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Uraian Kegiatan">
                    </div>
                    <!-- buat select untuk memilih jenis_tugas yaitu pokok atau penunjang -->
                    <div class="mb-2">
                      <label for="jenis_tugas" class="form-label">Jenis Tugas</label>
                      <select required class="form-select" id="jenis_tugas" name="jenis_tugas">
                        <option selected hidden value="">Pilih Jenis Tugas</option>
                        <option value="pokok">Pokok</option>
                        <option value="penunjang">Penunjang</option>
                      </select>
                    </div>
                    <!-- pilih unit_kerja -->
                    <div class="mb-2" id="unit_kerja">
                      <label for="id_unit_kerja" class="form-label">Unit Kerja</label>
                      <select class="form-select" name="id_unit_kerja" id="id_unit_kerja">
                        <option selected hidden value="">Pilih Unit Kerja</option>
                        <?php
                        do {
                        ?>
                          <option value="<?= $unit_kerja_row['id_unit_kerja'] ?>"><?= $unit_kerja_row['nama_unit_kerja'] ?></option>
                        <?php
                        } while ($unit_kerja_row = mysqli_fetch_array($unit_kerja));
                        ?>
                      </select>
                    </div>
                    <div class="d-flex justify-content-evenly mt-3">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <a href="../datauraiankegiatan/" class="btn btn-secondary">Kembali</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- gunakan javascript untuk menghilangkan required dan tampilan pada id unit_kerja jika pada jenis_tugas yang dipilih adalah penunjang -->
<script>
  const jenis_tugas = document.getElementById('jenis_tugas');
  const unit_kerja = document.getElementById('unit_kerja');
  const id_unit_kerja = document.getElementById('id_unit_kerja');

  document.addEventListener('DOMContentLoaded', function() {
    resetUnitKerja();
  });

  jenis_tugas.addEventListener('change', function() {
    if (jenis_tugas.value === 'pokok') {
      id_unit_kerja.required = true; // Mengatur required langsung ke true
      unit_kerja.style.display = 'block';
    } else {
      resetUnitKerja();
    }
  });

  function resetUnitKerja() {
    id_unit_kerja.required = false; // Mengatur required langsung ke false
    unit_kerja.style.display = 'none';
    id_unit_kerja.value = '';
  }
</script>




<?php
include '../template/footer.php';
?>