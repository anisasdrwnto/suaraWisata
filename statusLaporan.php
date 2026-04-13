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
  <title>Status Laporan Saya</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    .timeline-card {
      border-left: 4px solid #dee2e6;
      padding-left: 20px;
      margin-bottom: 30px;
      position: relative;
    }
    .timeline-card::before {
      content: '';
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: #dee2e6;
      position: absolute;
      left: -9px;
      top: 6px;
    }
    .timeline-card.status-menunggu { border-left-color: #6c757d; }
    .timeline-card.status-menunggu::before { background: #6c757d; }

    .timeline-card.status-diproses { border-left-color: #ffc107; }
    .timeline-card.status-diproses::before { background: #ffc107; }

    .timeline-card.status-selesai { border-left-color: #28a745; }
    .timeline-card.status-selesai::before { background: #28a745; }

    .respons-box {
      background: #f8f9fa;
      border-left: 3px solid #007bff;
      padding: 10px 15px;
      border-radius: 4px;
      margin-top: 10px;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #adb5bd;
    }
    .empty-state i {
      font-size: 60px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php include "header/header.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1><i class="fas fa-history mr-2"></i> Status Laporan Saya</h1>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div id="timelineContainer">
              <div class="empty-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuat data...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include "footer/footer.php"; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/logout.js"></script>

<script>
  function loadTimeline() {
    $.get('proses_statusLaporan.php', { action: 'read' }, function(response) {
      var container = $('#timelineContainer');
      container.empty();

      if (!response.data || response.data.length == 0) {
        container.html(
          '<div class="empty-state">' +
            '<i class="fas fa-inbox"></i>' +
            '<p class="h5">Belum ada laporan</p>' +
            '<p>Anda belum pernah mengirimkan laporan wisata.</p>' +
          '</div>'
        );
        return;
      }

      $.each(response.data, function(i, row) {
        var status     = row.status ? row.status : 'Menunggu';
        var statusLow  = status.toLowerCase();

        // Icon per status
        var iconClass  = 'fas fa-clock text-secondary';
        if (status == 'Diproses') iconClass = 'fas fa-spinner text-warning';
        if (status == 'Selesai')  iconClass = 'fas fa-check-circle text-success';

        // Badge per status
        var badgeClass = 'badge-secondary';
        if (status == 'Diproses') badgeClass = 'badge-warning';
        if (status == 'Selesai')  badgeClass = 'badge-success';

        // Respons box
        var responsHtml = '';
        if (row.respons_admin) {
          var tgl = row.tgl_respons ? '<small class="text-muted ml-2"><i class="fas fa-calendar-alt mr-1"></i>' + row.tgl_respons + '</small>' : '';
          responsHtml =
            '<div class="respons-box mt-2">' +
              '<p class="mb-1"><strong><i class="fas fa-reply mr-1 text-primary"></i> Respons Admin</strong>' + tgl + '</p>' +
              '<p class="mb-0">' + row.respons_admin + '</p>' +
            '</div>';
        } else {
          responsHtml =
            '<div class="respons-box mt-2">' +
              '<p class="mb-0 text-muted"><i class="fas fa-hourglass-half mr-1"></i> Menunggu respons dari admin...</p>' +
            '</div>';
        }

        container.append(
          '<div class="timeline-card status-' + statusLow + '">' +
            '<div class="d-flex justify-content-between align-items-start">' +
              '<div>' +
                '<h6 class="mb-1"><i class="' + iconClass + ' mr-2"></i>' + row.id_laporan + '</h6>' +
                '<p class="mb-1 text-muted"><i class="fas fa-map-marker-alt mr-1"></i>' + row.lokasi_wisata + '</p>' +
              '</div>' +
              '<span class="badge ' + badgeClass + ' px-3 py-2">' + status + '</span>' +
            '</div>' +
            '<p class="mb-1"><strong>Isi Laporan:</strong> ' + row.isi_laporan + '</p>' +
            responsHtml +
          '</div>'
        );
      });

    }, 'json');
  }

  $(document).ready(function() {
    loadTimeline();
  });

  history.pushState(null, null, window.location.href);
  window.addEventListener('pageshow', function(e) {
    fetch('check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => { if (!data.loggedIn) window.location.replace('index.php'); })
      .catch(function() { window.location.replace('index.php'); });
  });
  window.addEventListener('popstate', function() {
    history.pushState(null, null, window.location.href);
    fetch('check_session.php', { cache: 'no-store' })
      .then(res => res.json())
      .then(data => { if (!data.loggedIn) window.location.replace('index.php'); });
  });
</script>

</body>
</html>