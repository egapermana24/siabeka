<?php
include '../template/header.php';
include '../database/koneksi.php';

if (isset($_POST['id_user'])) {
  $id_user_edit = $_POST['id_user'];
  $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user='$id_user_edit'");
  $row = mysqli_fetch_array($query);
} else {
  echo '<script>document.location="../semuapengguna/";</script>';
}

?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Edit Pengguna</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Edit Pengguna</a>
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
                  <h4 class="card-title mb-3">Edit Pengguna</h4>
                  <form action="proses.php" method="POST">
                    <!-- Menambahkan hidden input untuk mengirimkan ID user yang akan diedit -->
                    <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                    <div class="mb-2">
                      <label for="nama" class="form-label">Nama</label>
                      <!-- Mengisi nilai default pada input nama dengan data pengguna yang sedang login -->
                      <input required type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $row['nama']; ?>">
                    </div>
                    <div class="mb-2">
                      <label for="username" class="form-label">Username</label>
                      <!-- Mengisi nilai default pada input username dengan data pengguna yang sedang login -->
                      <input required type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?= $row['username']; ?>">
                    </div>
                    <!-- <div class="mb-2">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="********">
                    </div>
                    <div class="mb-2">
                      <label for="conf_password" class="form-label">Konfirmasi Password</label>
                      <input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="********">
                    </div> -->
                    <!-- Menambahkan opsi untuk memilih level antara user atau admin -->
                    <div class="mb-2">
                      <label for="level" class="form-label">Level</label>
                      <select required class="form-select" id="level" name="level">
                        <option value="user" <?php if ($row['level'] == 'user') echo 'selected'; ?>>User</option>
                        <option value="admin" <?php if ($row['level'] == 'admin') echo 'selected'; ?>>Admin</option>
                      </select>
                    </div>
                    <div class="d-flex justify-content-evenly mt-3">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <a href="../semuapengguna/" class="btn btn-secondary">Kembali</a>
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