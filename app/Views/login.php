<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
    content=" T Inventory Management System is a simple and efficient inventory management system designed to help businesses manage their products, sales, and stock levels effectively.">
  <meta name="author" content="Dev Tarak">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Login - T Inventory Management System</title>
  <!-- Bootstrap core CSS -->
  <link href="<?= base_url('include/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="<?= base_url('include/css/login.css') ?>" rel="stylesheet">
</head>

<body>
  <?php if (session()->getFlashdata('message')): ?>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('message') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>
  <div class="text-center body1">
  <main class="form-signin">
    <form action="<?= base_url('login') ?>" method="post" class="form-signin">
      <h1 class="h3 mb-3 fw-normal">Please Login</h1>

      <div class="form-floating">
        <input type="username" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
        <label for="floatingPassword">Password</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2024–2025</p>
    </form>
  </main>
  <script src="<?= base_url('include/bootstrap/bootstrap.bundle.min.js') ?>" type="text/javascript"
    defer></script>
</body>
</html>