<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
     <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- AdminLTE CSS (sudah include Bootstrap 4) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const BASE_URL = "/api/";
    </script>
    <!--- Script Register --->
    <script src="/js/scriptLogin.js"></script>
    <!--Swal-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   <body class="login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="index.php" class="h1"><b>Login</b>Page</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Login to start your session</p>
        <form>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" id="idUsername" name="username">
            
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <span id="errorUsername" class="error invalid-feedback"></span>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" id="idPassword" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <span id="errorPassword" class="error invalid-feedback"></span>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-block" id="btnLogin" name="login">Login</button>
            </div>
          </div>
        </form>
        <p class="mb-0 mt-3 text-center">
          <a href="register.php" class="text-center">Register a new membership</a>
        </p>
      </div>
    </div>
  </div>
</body>
</div>
</body>
</html>