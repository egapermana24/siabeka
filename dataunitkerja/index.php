<?php
include '../template/header.php';
include '../database/koneksi.php';

$query = "SELECT * FROM unit_kerja";
$result = mysqli_query($conn, $query);

// buat kondisi jika mahasiswa belum melakukan perhitungan dengan cara mencari data di tabel norma_waktu_komponen
?>

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-7 align-self-center">
      <h3 class="page-title text-truncate text-primary font-weight-medium mb-1">Data Unit Kerja</h3>
      <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="#">Data Seluruh Unit Kerja</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="col-5 align-self-center">
      <div class="customize-input float-end">
        <!-- buatkan button tambah data -->
        <a type="button" class="btn btn-primary" href="../tambahdataunitkerja/">Tambah Data</a>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
              <thead>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">No</th>
                  <th>Nama Unit Kerja</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($unit = mysqli_fetch_assoc($result)) {
                ?>
                  <tr class="fs-6">
                    <td><?= $no++; ?></td>
                    <td><?= $unit['nama_unit_kerja']; ?></td>
                    <td>
                      <button class="badge rounded-pill text-bg-danger text-white border-0" data-bs-target="#delete-unitkerja<?= $unit['id_unit_kerja']; ?>" data-bs-toggle="modal">delete</button>
                      <form action="../editdataunitkerja/" method="post">
                        <input type="hidden" name="id_unit_kerja" value="<?= $unit['id_unit_kerja']; ?>">
                        <button type="submit" class="badge rounded-pill text-bg-primary text-white border-0">edit</button>
                      </form>
                    </td>
                  </tr>
                  <div id="delete-unitkerja<?= $unit['id_unit_kerja']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-unitkerjaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-danger">
                          <h4 class="modal-title" id="delete-unitkerjaLabel">Konfirmasi
                          </h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                          <h5 class="mt-0">Apakah Anda Yakin Ingin Menghapus <strong><?= $unit['nama_unit_kerja']; ?></strong>?</h5>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                          <form action="deleteunitkerja.php" method="post">
                            <input type="hidden" name="id_unit_kerja" value="<?= $unit['id_unit_kerja']; ?>">
                            <button type="submit" class="btn btn-danger text-white border-0">Hapus</button>
                          </form>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                <?php
                }
                ?>
              </tbody>

              <!-- <tfoot>
                <tr class="text-uppercase fs-6 text-primary">
                  <th class="text-center">Aksi</th>
                  <th>Nama</th>
                  <th>NIM</th>
                  <th>Tanggal Lahir</th>
                  <th>Level</th>
                  <th>Kondisi</th>
                </tr>
              </tfoot> -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include '../template/footer.php';
?>