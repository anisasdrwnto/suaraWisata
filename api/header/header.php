<?php
// Ambil dari $_GET karena session tidak jalan di Vercel
$username = $_GET['user'] ?? 'Guest';
$role     = $_GET['role'] ?? '';
$base_url = '/api/';
?>

<!-- NAVBAR -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>

<!-- SIDEBAR -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="<?= $base_url ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= $base_url ?>images/profile-pic.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a class="d-block"><?= htmlspecialchars($username); ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item menu-open">
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>dashboard/dashboard_user.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Welcome page</p>
              </a>
            </li>
          </ul>

          <?php if ($role !== 'ADMIN_MASTER' && $role !== 'ADMIN'): ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>laporKeluhan.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Laporan Keluhan Wisata</p>
              </a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if ($role !== 'USR' && $role !== 'ADMIN'): ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>Role.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Role</p>
              </a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if ($role === 'ADMIN_MASTER'): ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>ManageUser.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Manage User</p>
              </a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if ($role === 'ADMIN'): ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>periksaLaporan.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Periksa Laporan</p>
              </a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if ($role === 'USR'): ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $base_url ?>statusLaporan.php?user=<?= urlencode($username) ?>&role=<?= urlencode($role) ?>" class="nav-link">
                <p>Status Laporan</p>
              </a>
            </li>
          </ul>
          <?php endif; ?>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" id="messagelogout">
                <p>Log out</p>
              </a>
            </li>
          </ul>

        </li>
      </ul>
    </nav>
  </div>
</aside>