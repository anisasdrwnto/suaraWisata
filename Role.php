<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$base_url = "/suaraWisata/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Role</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
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
                  <i class="fas fa-list mr-2"></i> Data Role
                </h3>
                <div class="card-tools">
                  <button class="btn btn-primary btn-sm" id="btnAddRole">
                    <i class="fas fa-plus"></i> Add Role
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                  <thead>
                    <tr>
                      <th class="text-center">ID Role</th>
                      <th>Code Role</th>
                      <th>Nama Role</th>
                      <th>Is Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyRole"></tbody>
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

<div class="modal fade" id="modalAddRole" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Form Role</h4>
        <input type="hidden" id="id_role" name="id_role">
        <div class="form-group">
            <label>Code Role</label>
            <input type="text" id="code_role" class="form-control">
            <small class="text-danger d-none" id="err_nama">Code role wajib diisi</small>
        </div>
        <div class="form-group">
          <label>Nama Role</label>
          <input type="text" id="nama_role" class="form-control">
          <small class="text-danger d-none" id="err_nama">Nama role wajib diisi</small>
        </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSimpanRole">Save</button>
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
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/scriptRole.js"></script>
<script src="js/logout.js"></script>

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