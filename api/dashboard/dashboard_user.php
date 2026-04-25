<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if (!isset($_SESSION['username'])) {
    header("Location: /index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard User</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/api/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/api/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/api/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/api/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
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

  <!-- CONTENT WRAPPER -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <h1>Hello, <?= htmlspecialchars($_SESSION['username']); ?></h1>
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/api/images/Gambar 1.jpg" class="card-img-top gallery-img" alt="Gambar 1">
              <div class="card-body">
                <p class="card-text">Pariwisata 1</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/api/images/Gambar 2.jpg" class="card-img-top gallery-img" alt="Gambar 2">
              <div class="card-body">
                <p class="card-text">Pariwisata 2</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/api/images/Gambar 3.jpg" class="card-img-top gallery-img" alt="Gambar 3">
              <div class="card-body">
                <p class="card-text">Pariwisata 3</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="/api/images/Gambar 4.jpg" class="card-img-top gallery-img" alt="Gambar 4">
              <div class="card-body">
                <p class="card-text">Pariwisata 4</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php include __DIR__ . '/../footer/footer.php'; ?>

  <aside class="control-sidebar control-sidebar-dark"></aside>

</div>
<!-- /.wrapper -->

<script src="/api/plugins/jquery/jquery.min.js"></script>
<script src="/api/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="/api/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/api/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/api/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/api/js/logout.js"></script>
<script>
  history.pushState(null, null, window.location.href);

  window.addEventListener('pageshow', function(e) {
    fetch('/api/check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => {
        if (!data.loggedIn) {
          window.location.replace('/index.html');
        }
      })
      .catch(function() {
        window.location.replace('/index.html');
      });
  });

  window.addEventListener('popstate', function() {
    history.pushState(null, null, window.location.href);
    fetch('/api/check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => {
        if (!data.loggedIn) {
          window.location.replace('/index.html');
        }
      });
  });
</script>

</body>
</html>