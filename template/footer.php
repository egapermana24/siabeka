<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer text-center text-muted">
  Designed and Developed by <strong>Naufal Rifqi Mubarok</strong>.
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-colored-header bg-primary">
        <h4 class="modal-title" id="primary-header-modalLabel">Konfirmasi
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <h5 class="mt-0">Apakah Anda Yakin Ingin Keluar Dari Sistem?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
        <a type="button" class="btn btn-primary" href="../login/proses_login.php?aksi=logout">Keluar</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="reset-perhitungan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reset-perhitunganLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-colored-header bg-danger">
        <h4 class="modal-title" id="reset-perhitunganLabel">Konfirmasi
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <h5 class="mt-0">Apakah kamu yakin akan menghapus semua hasil perhitungan? Kamu akan mengulang dari awal lagi!</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
        <form action="../profil/proses_reset_perhitungan.php" method="post">
          <input type="hidden" name="id_user" value="<?= $id_user; ?>">
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah alert telah ditutup sebelumnya
    if (sessionStorage.getItem('alertClosed')) {
      document.querySelector('.alert').classList.add('d-none'); // Sembunyikan alert jika sudah ditutup sebelumnya
    }

    // Tangkap klik tombol close
    document.querySelector('.btn-close').addEventListener('click', function() {
      sessionStorage.setItem('alertClosed', 'true'); // Set status alertClosed ke true ketika tombol close ditekan
    });

    // Tangkap klik tombol tampilkan alert lagi
    document.querySelector('.btn-show-alert').addEventListener('click', function() {
      sessionStorage.removeItem('alertClosed'); // Hapus status alertClosed dari sessionStorage
      document.querySelector('.alert').classList.remove('d-none'); // Tampilkan alert lagi
    });
  });
</script>

<script src="../assets/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- apps -->
<!-- apps -->
<script src="../assets/dist/js/app-style-switcher.js"></script>
<script src="../assets/dist/js/feather.min.js"></script>
<script src="../assets/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="../assets/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="../assets/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<script src="../assets/assets/extra-libs/c3/d3.min.js"></script>
<script src="../assets/assets/extra-libs/c3/c3.min.js"></script>
<script src="../assets/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="../assets/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="../assets/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
<script src="../assets/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
<script src="../assets/dist/js/pages/dashboards/dashboard1.min.js"></script>
<!--Data Tables -->
<script src="../assets/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../assets/assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script src="../assets/dist/js/pages/datatable/datatable-basic.init.js"></script>
<!-- Chart JS -->
<script src="../dist/js/pages/chartjs/chartjs.init.js"></script>
<script src="../assets/libs/chart.js/dist/Chart.min.js"></script>
</body>

</html>