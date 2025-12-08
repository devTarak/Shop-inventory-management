<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?= base_url('include/admin_asset/images/favicon.ico') ?>" type="image/x-icon">
    <link rel="preload" href="<?= base_url('include/admin_asset/bootstrap/bootstrap.min.css') ?>" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="<?= base_url('include/admin_asset/css/style.css') ?>" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>
        <?= esc($page_title) ?> -
        <?= esc($page_description) ?>
    </title>
    <script src="<?= base_url('include/admin_asset/js/jquery-3.7.1.min.js') ?>"></script>
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
    <main>