<?php
include '../template/header.php';
include '../database/koneksi.php';

// menampilkan data user yang sedang login
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user='$id_user'");
$row = mysqli_fetch_array($query);

?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Ubah Password</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Ubah Password <?= $row['nama']; ?></a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4 mt-2">
      <div class="card shadow-lg">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 col-lg-12 d-flex align-content-stretch">
              <div class="card shadow">
                <div class="card-body">
                  <h4 class="card-title mb-3">Ubah Password</h4>
                  <!-- buatkan inputan untuk mengubah nama, username dan tanggal lahir -->
                  <form action="proses.php" method="POST">
                    <div class="mb-2">
                      <label for="old_password" class="form-label">Password Lama</label>
                      <input type="password" class="form-control" id="old_password" name="old_password" placeholder="********">
                    </div>
                    <div class="mb-2">
                      <label for="new_password" class="form-label">Password Baru</label>
                      <input type="password" class="form-control" id="new_password" name="new_password" placeholder="********">
                    </div>
                    <div class="mb-2">
                      <label for="conf_new_password" class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" id="conf_new_password" name="conf_new_password" placeholder="********">
                      <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                    </div>
                    <div class="d-flex justify-content-evenly">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <a href="../profil/" class="btn btn-secondary">Kembali</a>
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