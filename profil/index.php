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
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Profil</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Profil <?= $row['nama']; ?></a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 mt-2">
      <div class="card shadow-lg">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6 col-lg-4 d-flex align-content-stretch">
              <div class="card shadow">
                <!-- beri kondisi jika user belum memiliki foto maka arahkan ke /user.png -->
                <img class="card-img-top img-fluid" src="../assets/img/<?= !empty($row['foto']) ? $row['foto'] : 'user.png'; ?>" alt="Card image cap">
                <div class="card-body">
                  <h4 class="card-title"><?= $row['nama']; ?></h4>
                  <p class="card-text">Username: <?= $row['username']; ?></p>
                  <p class="card-text"><small class="text-muted">Tanggal lahir: <?= $row['tanggal_lahir']; ?></small></p>
                </div>
              </div>
            </div> 
            <div class="col-sm-12 col-lg-4 d-flex align-content-stretch">
              <div class="card shadow">
                <div class="card-body">
                  <h4 class="card-title">Edit Profil</h4>
                  <!-- buatkan inputan untuk mengubah nama, username dan tanggal lahir -->
                  <form action="proses_edit_profil.php" method="POST">
                    <div class="mb-2">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama']; ?>">
                    </div>
                    <div class="mb-2">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?= $row['username']; ?>">
                    </div>
                    <div class="mb-2">
                      <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $row['tanggal_lahir']; ?>">
                      <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 d-flex align-content-stretch">
              <div class="card shadow">
                <div class="card-body">
                  <!-- tambahkan inputan untuk ganti foto -->
                  <form action="proses_edit_foto.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-0">
                      <h4 class="card-title">Ganti Foto</h4>
                      <input required type="file" class="form-control" id="foto" name="foto">
                      <!-- beri text peringatan bahwa foto sebaiknya memiliki rasio 1:1 -->
                      <small class="text-danger fs-6 mb-2">*Foto sebaiknya memiliki rasio 1:1</small>
                      <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mb-1">Simpan</button>
                  </form>
                  <h4 class="card-title mt-2">Pengaturan</h4>
                  <!-- buatkan tombol untuk reset perhitungan -->
                  <a href="#" data-bs-target="#reset-perhitungan" data-bs-toggle="modal" class="btn btn-danger mb-1">Reset Perhitungan</a>
                  <a href="../resetpassword/" class="btn btn-primary mb-1">Ubah Kata Sandi</a>
                  <a href="#" data-bs-target="#primary-header-modal" data-bs-toggle="modal" class="btn btn-primary mb-1">Logout</a>
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