<?php
session_start();

if (!isset($_SESSION['id_users']) || !isset($_SESSION['role'])) {
    header("Location: /index.html");
    exit;
}

if ($_SESSION['role'] !== 'ADMIN') {
    header("Location: /index.html");
    exit;
}


$username = $_SESSION['username'];
$id_users = $_SESSION['id_users'];
$role     = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    .gallery-img {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include __DIR__ . '/../header/header.php'; ?>

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">

        <!-- ✅ Data dari session, bukan dari URL -->
        <h1>Hello, <?= htmlspecialchars($username); ?></h1>

        <div class="row">
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/images/Gambar 1.jpg" class="card-img-top gallery-img" alt="Gambar 1">
              <div class="card-body"><p class="card-text">Pariwisata 1</p></div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/images/Gambar 2.jpg" class="card-img-top gallery-img" alt="Gambar 2">
              <div class="card-body"><p class="card-text">Pariwisata 2</p></div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/images/Gambar 3.jpg" class="card-img-top gallery-img" alt="Gambar 3">
              <div class="card-body"><p class="card-text">Pariwisata 3</p></div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/images/Gambar 4.jpg" class="card-img-top gallery-img" alt="Gambar 4">
              <div class="card-body"><p class="card-text">Pariwisata 4</p></div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <?php include __DIR__ . '/../footer/footer.php'; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/js/logout.js"></script>
<script src="/js/scriptPeriksaLaporan.js"></script>

</body>
</html>