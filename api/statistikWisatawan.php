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

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-globe-asia mr-2"></i> Statistik Wisatawan Mancanegara</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Statistik Wisman</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">

        <!-- Loading State -->
        <div id="loadingState" class="text-center py-5">
          <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
          <p class="text-muted">Memuat data dari BPS...</p>
        </div>

        <!-- Error State -->
        <div id="errorState" class="d-none">
          <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <span id="errorMessage">Terjadi kesalahan.</span>
          </div>
        </div>

        <!-- Content -->
        <div id="mainContent" class="d-none">

          <!-- Info Sumber -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="callout callout-info">
                <h6 class="mb-1"><i class="fas fa-info-circle mr-1"></i> Sumber Data</h6>
                <p class="mb-0 text-sm">
                  Badan Pusat Statistik (BPS) — Wisatawan Mancanegara per Bulan Menurut Kebangsaan
                  | Tahun: <strong id="infoTahun">-</strong>
                  | Periode: <strong id="infoPeriode">-</strong>
                  | Diambil: <strong id="infoTanggal">-</strong>
                </p>
              </div>
            </div>
          </div>

          <!-- Ringkasan Cards -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3 id="cardGrandTotal">-</h3>
                  <p>Total Wisatawan</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3 id="cardNilaiTertinggi">-</h3>
                  <p>Tertinggi per Bulan</p>
                </div>
                <div class="icon"><i class="fas fa-arrow-up"></i></div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3 id="cardBulanTertinggi">-</h3>
                  <p>Bulan Tertinggi</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 id="cardRataRata">-</h3>
                  <p>Rata-rata per Bulan</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
              </div>
            </div>
          </div>

          <!-- Charts Row -->
          <div class="row">
            <!-- Bar Chart Per Bulan -->
            <div class="col-md-5">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i> Kunjungan per Bulan</h3>
                </div>
                <div class="card-body">
                  <canvas id="chartBulan" style="min-height:250px"></canvas>
                </div>
              </div>
            </div>

            <!-- Horizontal Bar Chart Top 10 Kebangsaan -->
            <div class="col-md-7">
              <div class="card card-outline card-success">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-flag mr-2"></i> Top 10 Kebangsaan</h3>
                </div>
                <div class="card-body">
                  <canvas id="chartKebangsaan" style="min-height:350px"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabel Detail Top 10 -->
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-secondary">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-table mr-2"></i> Detail Top 10 Kebangsaan</h3>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                      <thead>
                        <tr>
                          <th class="text-center" style="width:50px">No</th>
                          <th>Kebangsaan</th>
                          <th class="text-right">Total Kunjungan</th>
                          <th>Proporsi</th>
                        </tr>
                      </thead>
                      <tbody id="tabelKebangsaan"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div><!-- end #mainContent -->

      </div>
    </section>
  </div>

  <?php include __DIR__ . '/footer/footer.php'; ?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= $base_url ?>dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

  function formatAngka(n) {
    return new Intl.NumberFormat('id-ID').format(n);
  }

  function tampilError(msg) {
    $('#loadingState').addClass('d-none');
    $('#errorMessage').text(msg);
    $('#errorState').removeClass('d-none');
  }

  function buatChartBulan(labels, values) {
    const ctx = document.getElementById('chartBulan').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah Wisatawan',
          data: values,
          backgroundColor: ['rgba(60,141,188,0.8)', 'rgba(0,166,90,0.8)'],
          borderColor:     ['rgba(60,141,188,1)',   'rgba(0,166,90,1)'],
          borderWidth: 2,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => ' ' + formatAngka(ctx.parsed.y) + ' wisatawan'
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: val => formatAngka(val)
            }
          }
        }
      }
    });
  }

  function buatChartKebangsaan(labels, values) {
    const ctx = document.getElementById('chartKebangsaan').getContext('2d');
    const colors = [
      '#3c8dbc','#00a65a','#f39c12','#dd4b39','#00c0ef',
      '#605ca8','#d81b60','#001f3f','#39cccc','#01ff70'
    ];
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Total Kunjungan',
          data: values,
          backgroundColor: colors,
          borderColor: colors,
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => ' ' + formatAngka(ctx.parsed.x) + ' wisatawan'
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            ticks: { callback: val => formatAngka(val) }
          }
        }
      }
    });
  }

  function buatTabel(labels, values) {
    const total = values.reduce((a, b) => a + b, 0);
    const tbody = $('#tabelKebangsaan');
    tbody.empty();
    labels.forEach((label, i) => {
      const pct     = total > 0 ? (values[i] / total * 100).toFixed(1) : 0;
      const barW    = total > 0 ? (values[i] / values[0] * 100).toFixed(1) : 0;
      const colors  = ['bg-primary','bg-success','bg-warning','bg-danger','bg-info',
                       'bg-purple','bg-pink','bg-navy','bg-teal','bg-lime'];
      const barColor = colors[i] || 'bg-secondary';
      tbody.append(`
        <tr>
          <td class="text-center">${i + 1}</td>
          <td><strong>${label}</strong></td>
          <td class="text-right">${formatAngka(values[i])}</td>
          <td>
            <div class="d-flex align-items-center">
              <div class="progress flex-grow-1 mr-2" style="height:12px">
                <div class="progress-bar ${barColor}" style="width:${barW}%"></div>
              </div>
              <span class="text-sm text-muted" style="min-width:42px">${pct}%</span>
            </div>
          </td>
        </tr>
      `);
    });
  }

  $(document).ready(function () {
    $.get('/api/api_wisatawan.php')
      .done(function (res) {
        if (res.status !== 'success') {
          tampilError(res.message || 'Data tidak valid.');
          return;
        }

        // Info bar
        $('#infoTahun').text(res.tahun);
        $('#infoPeriode').text((res.bulan_ditampilkan || []).join(', '));
        $('#infoTanggal').text(res.meta?.diambil_pada || '-');

        // Cards ringkasan
        const r = res.ringkasan;
        $('#cardGrandTotal').text(formatAngka(r.grand_total));
        $('#cardNilaiTertinggi').text(formatAngka(r.nilai_tertinggi));
        $('#cardBulanTertinggi').text(r.bulan_tertinggi);
        $('#cardRataRata').text(formatAngka(r.rata_rata_bulan));

        // Charts
        buatChartBulan(res.per_bulan.labels, res.per_bulan.values);
        buatChartKebangsaan(res.per_kebangsaan.labels, res.per_kebangsaan.values);

        // Tabel
        buatTabel(res.per_kebangsaan.labels, res.per_kebangsaan.values);

        // Tampilkan konten
        $('#loadingState').addClass('d-none');
        $('#mainContent').removeClass('d-none');
      })
      .fail(function (xhr) {
        tampilError('Gagal memuat data: ' + (xhr.statusText || 'Unknown error'));
      });
  });
</script>

</body>
</html>