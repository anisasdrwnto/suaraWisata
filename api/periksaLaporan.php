<?php
$username = $_GET['user'] ?? '';
$role     = $_GET['role'] ?? '';

if (empty($username)) {
    header("Location: /index.html");
    exit;
}

$base_url = "/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Periksa Laporan</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
 
  <?php include __DIR__ . '/header/header.php'; ?>
 
  <!-- CONTENT WRAPPER -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  Periksa Laporan Wisata
                </h3>
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
                      <th>Lokasi Wisata</th>
                      <th>Isi Laporan</th>
                      <th>Status</th>
                      <th>Respons Admin</th>
                      <th>Tgl Respons</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyPeriksa"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
 
  <?php include __DIR__ . '/footer/footer.php'; ?>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
 
<!-- MODAL DETAIL & RESPONS -->
<div class="modal fade" id="modalRespons" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">
          <i class="fas fa-clipboard-check mr-2"></i> Detail & Respons Laporan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_laporan">
 
        <!-- Detail Laporan (readonly) -->
        <div class="card card-secondary card-outline mb-3">
          <div class="card-header"><h6 class="mb-0"><i class="fas fa-info-circle mr-1"></i> Detail Laporan</h6></div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>ID Laporan</label>
                  <input type="text" id="detail_id_laporan" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Nama Pelapor</label>
                  <input type="text" id="detail_nama_pelapor" class="form-control" readonly>
                </div>
                 <div class="form-group">
                  <label>Nomer Telepon</label>
                  <input type="text" id="detail_nomer_telp" class="form-control" readonly>
                </div>
                 <div class="form-group">
                  <label>Email</label>
                  <input type="text" id="detail_email" class="form-control" readonly>
                </div>

              
                <div class="form-group">
                  <label>Lokasi Wisata</label>
                  <input type="text" id="detail_lokasi_wisata" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Isi Laporan</label>
                  <textarea id="detail_isi_laporan" class="form-control" rows="3" readonly></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
 
        <!-- Form Respons Admin -->
        <div class="card card-primary card-outline">
          <div class="card-header"><h6 class="mb-0"><i class="fas fa-reply mr-1"></i> Respons Admin</h6></div>
          <div class="card-body">
            <div class="form-group">
              <label>Status</label>
              <select id="status" class="form-control">
                <option value="Menunggu">Menunggu</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
              </select>
            </div>
            <div class="form-group">
              <label>Respons Admin</label>
              <textarea id="respons_admin" class="form-control" rows="4" placeholder="Tulis respons untuk pelapor..."></textarea>
            </div>
          </div>
        </div>
 
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSimpanRespons">
          <i class="fas fa-save mr-1"></i> Simpan Respons
        </button>
      </div>
    </div>
  </div>
</div>
 
<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= $base_url ?>dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= $base_url ?>js/scriptPeriksaLaporan.js"></script>
<script src="<?= $base_url ?>js/logout.js"></script>
 
<script>
  if (!new URLSearchParams(window.location.search).get('user')) {
    window.location.replace('/index.html');
  }

  history.pushState(null, null, window.location.href);
  window.addEventListener('popstate', function() {
    history.pushState(null, null, window.location.href);
    if (!new URLSearchParams(window.location.search).get('user')) {
      window.location.replace('/index.html');
    }
  });
</script>
 
</body>
</html>
 