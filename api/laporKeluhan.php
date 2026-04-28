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
  <title>Laporan Keluhan Wisata</title>
  <link rel="stylesheet" href="<?= $base_url ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= $base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    /* Supaya tabel bisa scroll horizontal di HP */
    .card-body.p-0 {
      overflow-x: auto;
    }
    /* Minimal lebar tabel supaya tidak terlalu mepet */
    .table {
      min-width: 700px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

  <?php include __DIR__ . '/header/header.php'; ?>
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
                <div class="table-responsive">
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
      </div>
    </section>
  </div>

  <?php include __DIR__ . '/footer/footer.php'; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>

</div>

<!-- Modal -->
<div class="modal fade" id="modalAddLaporan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
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
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= $base_url ?>dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= $base_url ?>js/scriptLaporan.js"></script>
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