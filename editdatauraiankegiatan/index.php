<?php
include '../template/header.php';
include '../database/koneksi.php';

if (isset($_POST['id_uraian_kegiatan'])) {
  $id_uraian_kegiatan_edit = $_POST['id_uraian_kegiatan'];
  $query = mysqli_query($conn, "SELECT uraian_kegiatan.*, unit_kerja.nama_unit_kerja 
                                FROM uraian_kegiatan 
                                LEFT JOIN unit_kerja 
                                ON uraian_kegiatan.id_unit_kerja = unit_kerja.id_unit_kerja 
                                WHERE uraian_kegiatan.id_uraian_kegiatan='$id_uraian_kegiatan_edit'");
  $row = mysqli_fetch_array($query);
} else {
  echo '<script>document.location="../datauraiankegiatan/";</script>';
}


?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Edit Uraian Kegiatan</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Edit Uraian Kegiatan</a>
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
                  <h4 class="card-title mb-3">Edit Uraian Kegiatan</h4>
                  <form action="proses.php" method="POST">
                    <!-- Menambahkan hidden input untuk mengirimkan ID user yang akan diedit -->
                    <input type="hidden" name="id_uraian_kegiatan" value="<?= $row['id_uraian_kegiatan']; ?>">
                    <div class="mb-2">
                      <label for="deskripsi" class="form-label">Deskripsi Uraian Kegiatan</label>
                      <!-- Mengisi nilai default pada input deskripsi dengan data pengguna yang sedang login -->
                      <input required type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi Uraian Kegiatan" value="<?= $row['deskripsi']; ?>">
                    </div>
                    <div class="mb-2">
                      <label for="jenis_tugas" class="form-label">Jenis Tugas</label>
                      <select required class="form-select" id="jenis_tugas" name="jenis_tugas">
                        <option selected hidden value="">Pilih Jenis Tugas</option>
                        <option value="pokok" <?php if ($row['jenis_tugas'] == 'pokok') echo 'selected'; ?>>Pokok</option>
                        <option value="penunjang" <?php if ($row['jenis_tugas'] == 'penunjang') echo 'selected'; ?>>Penunjang</option>
                      </select>
                    </div>
                    <div class="mb-2" id="unit_kerja">
                      <label for="id_unit_kerja" class="form-label">Unit Kerja</label>
                      <select class="form-select" name="id_unit_kerja" id="id_unit_kerja">
                        <option selected hidden value="">Pilih Unit Kerja</option>
                        <?php
                        $unit_kerja = mysqli_query($conn, "SELECT * FROM unit_kerja");
                        while ($unit_kerja_row = mysqli_fetch_array($unit_kerja)) {
                        ?>
                          <option value="<?= $unit_kerja_row['id_unit_kerja']; ?>" <?php if ($row['id_unit_kerja'] == $unit_kerja_row['id_unit_kerja']) echo 'selected'; ?>><?= $unit_kerja_row['nama_unit_kerja']; ?></option>
                        <?php
                        }
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

<script>
  const jenis_tugas = document.getElementById('jenis_tugas');
  const unit_kerja = document.getElementById('unit_kerja');
  const id_unit_kerja = document.getElementById('id_unit_kerja');

  document.addEventListener('DOMContentLoaded', function() {
    resetUnitKerja();
    jenis_tugas.addEventListener('change', function() {
      if (jenis_tugas.value === 'pokok') {
        id_unit_kerja.required = true;
        unit_kerja.style.display = 'block';
      } else if (jenis_tugas.value === 'penunjang') {
        id_unit_kerja.required = false;
        unit_kerja.style.display = 'none';
        id_unit_kerja.value = '';
      }
    });
  });

  function resetUnitKerja() {
    if (jenis_tugas.value === 'penunjang') {
      id_unit_kerja.required = false;
      unit_kerja.style.display = 'none';
      id_unit_kerja.value = '';
    }
  }
</script>

<?php
include '../template/footer.php';
?>