<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$base_url = "/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Keluhan Wisata</title>
  <link rel="stylesheet" href="<?= $base_url ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include "header/header.php"; ?>

  <!-- CONTENT WRAPPER -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list mr-2"></i> Data Laporan Wisata
                </h3>
                <div class="card-tools">
                  <button class="btn btn-primary btn-sm" id="btnAddLaporan">
                    <i class="fas fa-plus"></i> Add Laporan
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th>ID Laporan</th>
                      <th>Nama Pelapor</th>
                      <th>Nomer Telepon</th>
                      <th>Email</th>
                      <th>Lokasi (Provinsi, Kab/Kota)</th>
                      <th>Lokasi Wisata</th>
                      <th>Isi Laporan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyLaporan"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- FOOTER -->
  <?php include "footer/footer.php"; ?>

  <!-- CONTROL SIDEBAR -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

</div>
<!-- /.wrapper -->

<div class="modal fade" id="modalAddLaporan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Form Laporan Keluhan Wisata</h4>
          <input type="hidden" id="id_laporan" name="id_laporan">

        <div class="form-group">
          <label>Nama Pelapor</label>
          <input type="text" id="nama_pelapor" class="form-control">
          <span id="errorNama" class="error invalid-feedback"></span>
        </div>

        <div class="form-group">
          <label>No Telepon</label>
          <input type="text" id="nomer_telp" class="form-control">
          <span id="errorNoTelepon" class="error invalid-feedback"></span>
        </div>
        
        <div class="form-group">
          <label>Email</label>
          <input type="text" id="email" class="form-control">
          <span id="errorEmail" class="error invalid-feedback"></span>
        </div>

        <div class="form-group">
          <label>Provinsi</label>
          <select id="provinsi" class="form-control">
            <option value="">-- Pilih Provinsi --</option>
          </select>
          <span id="errorProvinsi" class="error invalid-feedback"></span>
        </div>

        <div class="form-group">
          <label>Kabupaten / Kota</label>
          <select id="kabkota" class="form-control" disabled>
            <option value="">-- Pilih Kabupaten/Kota --</option>
          </select>
          <span id="errorKabkota" class="error invalid-feedback"></span>
        </div>

        <div class="form-group" id="lokasiReadonly" style="display:none;">
            <label>Lokasi (Provinsi, Kab/Kota)</label>
            <input type="text" class="form-control" id="lokasiReadonlyText" readonly>
        </div>

        <!-- Hidden field — yang dikirim ke PHP & disimpan ke DB -->
        <input type="hidden" id="lokasi_wisata" name="lokasi_wisata">

        <div class="form-group">
          <label>Lokasi Wisata</label>
          <input type="text" id="info_lokasi" class="form-control">
          <span id="errorInfoLokasi" class="error invalid-feedback"></span>
        </div>

        <div class="form-group">
          <label>Isi Laporan</label>
          <textarea id="isi_laporan" class="form-control" rows="4"></textarea>
          <span id="err_isi" class="error invalid-feedback"></span>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSimpanLaporan">Save</button>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= $base_url ?>dist/js/adminlte.js"></script>
<script src="<?= $base_url ?>js/scriptLaporan.js"></script>
<script src="<?= $base_url ?>js/logout.js"></script>
<!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/scriptLaporan.js"></script>
<script src="js/logout.js"></script> -->

<script>
  history.pushState(null, null, window.location.href);

  window.addEventListener('pageshow', function(e) {
    fetch('check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => {
        if (!data.loggedIn) {
          window.location.replace('index.php');
        }
      })
      .catch(function() {
        window.location.replace('index.php');
      });
  });

  window.addEventListener('popstate', function() {
    history.pushState(null, null, window.location.href);
    fetch('check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => {
        if (!data.loggedIn) {
          window.location.replace('index.php');
        }
      });
  });
</script>

</body>
</html>