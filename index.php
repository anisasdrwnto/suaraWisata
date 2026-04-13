<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Suara Wisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</head>

<body>
  <!---Navbar-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Suara Wisata</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto mb-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#tentangKami">Tentang kami</a>
          </li>
        </ul>
        <div class="d-flex gap-3"> <!-- kasih jarak antar tombol -->
          <form action="login.php" method="get">
            <button type="submit" class="btn btn-dark rounded-pill">Login</button>
          </form>
          <form action="register.php" method="get">
            <button type="submit" class="btn btn-outline-success rounded-pill">Register</button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <!---Hero Section-->
  <section class="mt-5">
    <div class="container-fluid p-0">
      <div class="hero-image position-relative">
        <img src="https://images.pexels.com/photos/161293/prambanan-temple-java-hinduism-161293.jpeg"
          class="w-100 object-fit-cover" alt="Cover Image" style="height: 60vh; object-fit: cover;">
        <!-- full width, tinggi terbatas -->
        <div class="hero-text position-absolute top-50 start-50 translate-middle text-center text-light">
          <h1 class="fw-bold">Selamat Datang di Suara Wisata</h1>
          <p class="lead fw-semibold">Platform untuk menyampaikan keluhan dan mengenal pariwisata Indonesia.</p>
          <a href="#" class="btn btn-outline-light btn-lg rounded-pill mt-3" id="btnMulai">Mulai Sekarang</a>

        </div>
      </div>
    </div>
  </section>

  <!---Fitur Section-->
  <!-- Tentang Kami Section -->
  <section class="py-5 bg-white" id="tentangKami">
    <div class="container">
      <div class="row align-items-center g-4">

        <!-- Kolom teks -->
        <div class="col-12 col-md-6">
          <h2 class="fw-bold mb-3">Tentang Kami</h2>
          <p class="text-muted">
            Suara Wisata adalah platform yang hadir untuk mendukung pariwisata Indonesia dengan menyediakan ruang bagi
            masyarakat
            menyampaikan keluhan, melihat data statistik, dan mengenal lebih jauh tentang kondisi wisata di berbagai
            daerah.
            Kami berkomitmen untuk menghadirkan transparansi, keterlibatan publik, serta solusi yang lebih baik bagi
            pengembangan pariwisata.
          </p>
          <p class="text-muted">
            Melalui Suara Wisata, Anda dapat berpartisipasi aktif dalam membangun ekosistem wisata yang lebih sehat,
            nyaman, dan berkelanjutan. Visi kami adalah menjadikan pariwisata Indonesia semakin maju dengan dukungan
            masyarakat.
          </p>
        </div>

        <!-- Kolom gambar -->
        <div class="col-12 col-md-6 text-center">
          <img src="https://images.pexels.com/photos/2213443/pexels-photo-2213443.jpeg" class="img-fluid rounded shadow"
            alt="Tentang Kami">
        </div>
      </div>
    </div>
  </section>

  <!-- Laporan Terbaru Section -->
  <section class="py-5 bg-light" id="laporanTerbaru">
    <div class="container">
      <h2 class="fw-bold mb-4">Laporan Wisata Terbaru</h2>
      <div id="laporanOutput" class="border rounded p-3 bg-white shadow-sm">
        <p class="text-muted">Belum ada laporan.</p>
      </div>
    </div>
  </section>

  <!--- Footer --->
  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; 2026 Suara Wisata. All rights reserved.</p>
    </div>
  </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
</script>


</html>