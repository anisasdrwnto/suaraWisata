<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', '1');
session_start();
// DEBUG — hapus setelah fix
error_log("SESSION di dashboard_user: " . json_encode($_SESSION));
var_dump($_SESSION); // lihat di browser sementara
die();
if (!isset($_SESSION['id_users']) || !isset($_SESSION['role'])) {
    header("Location: /index.html");
    exit;
}

if ($_SESSION['role'] !== 'USR') {
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
  <title>Dashboard User</title>
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
    /* Padding atas supaya konten tidak ketutupan navbar di HP */
    .content-wrapper {
      padding-top: 1rem;
    }
    /* Greeting lebih kecil di HP */
    @media (max-width: 576px) {
      h1 {
        font-size: 1.4rem;
      }
    }
  </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

  <?php include __DIR__ . '/../header/header.php'; ?>

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">

        <h1 class="mt-2 mb-3">Hello, <?= htmlspecialchars($username); ?></h1>

        <div class="row">
          <div class="col-6 col-md-3 mb-4">
            <div class="card h-100">
              <img src="/images/Gambar 1.jpg" class="card-img-top gallery-img" alt="Gambar 1">
              <div class="card-body p-2"><p class="card-text small">Pariwisata 1</p></div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-4">
            <div class="card h-100">
              <img src="/images/Gambar 2.jpg" class="card-img-top gallery-img" alt="Gambar 2">
              <div class="card-body p-2"><p class="card-text small">Pariwisata 2</p></div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-4">
            <div class="card h-100">
              <img src="/images/Gambar 3.jpg" class="card-img-top gallery-img" alt="Gambar 3">
              <div class="card-body p-2"><p class="card-text small">Pariwisata 3</p></div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-4">
            <div class="card h-100">
              <img src="/images/Gambar 4.jpg" class="card-img-top gallery-img" alt="Gambar 4">
              <div class="card-body p-2"><p class="card-text small">Pariwisata 4</p></div>
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
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/js/logout.js"></script>
<!-- <script>
  var urlParams = new URLSearchParams(window.location.search);
  var user = urlParams.get('user');

  if(!user){
    window.location.replace('/index.html');
  }

  history.pushState(null, null, window.location.href);

  window.addEventListener('popstate', function() {
    history.pushState(null, null, window.location.href);
    var u = new URLSearchParams(window.location.search).get('user');
    if(!u) window.location.replace('/index.html');
  });
</script> -->

</body>
</html>