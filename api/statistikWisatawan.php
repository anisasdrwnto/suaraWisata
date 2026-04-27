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
  <title>Statistik Wisatawan</title>
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
 
  
  <?php include __DIR__ . '/footer/footer.php'; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
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
<!-- <script src="<?= $base_url ?>js/scriptPeriksaLaporan.js"></script> -->
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