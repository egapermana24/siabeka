<?php
include '../template/header.php';
include '../database/koneksi.php';

if (isset($_POST['id_unit_kerja'])) {
  $id_unit_kerja_edit = $_POST['id_unit_kerja'];
  $query = mysqli_query($conn, "SELECT * FROM unit_kerja WHERE id_unit_kerja='$id_unit_kerja_edit'");
  $row = mysqli_fetch_array($query);
} else {
  echo '<script>document.location="../dataunitkerja/";</script>';
}

?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Edit Unit Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Edit Unit Kerja</a>
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
                  <h4 class="card-title mb-3">Edit Unit Kerja</h4>
                  <form action="proses.php" method="POST">
                    <!-- Menambahkan hidden input untuk mengirimkan ID user yang akan diedit -->
                    <input type="hidden" name="id_unit_kerja" value="<?= $row['id_unit_kerja']; ?>">
                    <div class="mb-2">
                      <label for="nama" class="form-label">Nama Unit Kerja</label>
                      <!-- Mengisi nilai default pada input nama dengan data pengguna yang sedang login -->
                      <input required type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="Masukkan Nama Unit Kerja" value="<?= $row['nama_unit_kerja']; ?>">
                    </div>
                    <div class="d-flex justify-content-evenly mt-3">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <a href="../dataunitkerja/" class="btn btn-secondary">Kembali</a>
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
<?php
include '../template/footer.php';
?>