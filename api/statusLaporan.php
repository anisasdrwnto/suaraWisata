<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if($_SESSION['ROLE'] !== 'USR'){
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
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
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
          <div class="col-md-12">
            <div class="timeline" id="timelineContainer">
              <!-- loading spinner -->
              <div id="loadingSpinner" class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                <p class="text-muted mt-2">Memuat data...</p>
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
<script>
    const BASE_URL = "/suaraWisata/";
</script>
<script src="js/logout.js"></script>

<script>
   function loadTimeline() {
    $.get(BASE_URL + 'proses/proses_statusLaporan.php', { action: 'read' }, function(response) {
        var container = $('#timelineContainer');
        $('#loadingSpinner').remove();

        if (!response.data || response.data.length == 0) {
            container.html(
                '<div class="text-center py-5">' +
                    '<i class="fas fa-inbox fa-3x text-muted mb-3"></i>' +
                    '<p class="h5 text-muted">Belum ada laporan</p>' +
                    '<p class="text-muted">Anda belum pernah mengirimkan laporan wisata.</p>' +
                '</div>'
            );
            return;
        }

        $.each(response.data, function(i, row) {
            var status = row.status ? row.status : 'Menunggu';
            var tahap  = 1;
            if (status == 'Diproses') tahap = 2;
            if (status == 'Selesai')  tahap = 3;

            // Time label per laporan
            container.append(
                '<div class="time-label">' +
                    '<span class="bg-primary">' + row.id_laporan + '</span>' +
                '</div>'
            );

            // Tahap 1 - Menunggu (selalu ada)
            container.append(
                '<div>' +
                    '<i class="fas fa-clock bg-secondary"></i>' +
                    '<div class="timeline-item">' +
                        '<h3 class="timeline-header">' +
                            '<span class="badge badge-secondary">Menunggu</span> Laporan diterima' +
                        '</h3>' +
                        '<div class="timeline-body">' +
                            '<i class="fas fa-map-marker-alt mr-1 text-muted"></i>' + row.lokasi_wisata + '<br>' +
                            '<strong>Isi Laporan:</strong> ' + row.isi_laporan +
                        '</div>' +
                    '</div>' +
                '</div>'
            );

            // Tahap 2 - Diproses
            if (tahap >= 2) {
                container.append(
                    '<div>' +
                        '<i class="fas fa-spinner bg-warning"></i>' +
                        '<div class="timeline-item">' +
                            '<h3 class="timeline-header">' +
                                '<span class="badge badge-warning">Diproses</span> Laporan sedang diproses admin' +
                            '</h3>' +
                            (row.respons_admin && tahap == 2 ?
                                '<div class="timeline-body">' +
                                    '<div class="callout callout-warning">' +
                                        '<p class="mb-1"><strong><i class="fas fa-reply mr-1"></i> Respons Admin</strong>' +
                                        (row.tgl_respons ? ' <small class="text-muted"><i class="fas fa-calendar-alt mr-1"></i>' + row.tgl_respons + '</small>' : '') + '</p>' +
                                        '<p class="mb-0">' + row.respons_admin + '</p>' +
                                    '</div>' +
                                '</div>' : ''
                            ) +
                        '</div>' +
                    '</div>'
                );
            } else {
                container.append(
                    '<div>' +
                        '<i class="fas fa-spinner bg-gray"></i>' +
                        '<div class="timeline-item">' +
                            '<h3 class="timeline-header text-muted">' +
                                '<span class="badge badge-secondary">Diproses</span> Menunggu diproses admin...' +
                            '</h3>' +
                        '</div>' +
                    '</div>'
                );
            }

            // Tahap 3 - Selesai
            if (tahap >= 3) {
                container.append(
                    '<div>' +
                        '<i class="fas fa-check bg-success"></i>' +
                        '<div class="timeline-item">' +
                            '<h3 class="timeline-header">' +
                                '<span class="badge badge-success">Selesai</span> Laporan selesai ditangani' +
                            '</h3>' +
                            (row.respons_admin ?
                                '<div class="timeline-body">' +
                                    '<div class="callout callout-success">' +
                                        '<p class="mb-1"><strong><i class="fas fa-reply mr-1"></i> Respons Admin</strong>' +
                                        (row.tgl_respons ? ' <small class="text-muted"><i class="fas fa-calendar-alt mr-1"></i>' + row.tgl_respons + '</small>' : '') + '</p>' +
                                        '<p class="mb-0">' + row.respons_admin + '</p>' +
                                    '</div>' +
                                '</div>' : ''
                            ) +
                        '</div>' +
                    '</div>'
                );
            } else {
                container.append(
                    '<div>' +
                        '<i class="fas fa-check bg-gray"></i>' +
                        '<div class="timeline-item">' +
                            '<h3 class="timeline-header text-muted">' +
                                '<span class="badge badge-secondary">Selesai</span> Belum selesai...' +
                            '</h3>' +
                        '</div>' +
                    '</div>'
                );
            }
        });

        container.append('<div><i class="fas fa-clock bg-gray"></i></div>');

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