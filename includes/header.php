<?php require_once __DIR__ . '/functions.php'; start_secure_session(); $user = current_user(); ?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? APP_NAME) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="<?= app_asset('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top glass-nav">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= app_url('index.php') ?>"><img src="<?= app_asset('assets/images/logo.svg') ?>" class="logo" alt="Saraswati Library logo"><span><?= APP_NAME ?></span></a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="<?= app_url('index.php#home') ?>">Home</a></li><li class="nav-item"><a class="nav-link" href="<?= app_url('index.php#facilities') ?>">Facilities</a></li><li class="nav-item"><a class="nav-link" href="<?= app_url('index.php#about') ?>">About</a></li><li class="nav-item"><a class="nav-link" href="<?= app_url('index.php#pricing') ?>">Pricing</a></li><li class="nav-item"><a class="nav-link" href="<?= app_url('index.php#contact') ?>">Contact</a></li>
        <li class="nav-item"><button id="themeToggle" class="btn btn-sm btn-outline-light ms-lg-2"><i class="fa-solid fa-moon"></i> <span>Dark Mode</span></button></li>
        <?php if ($user): ?>
          <li class="nav-item dropdown ms-lg-2"><a class="nav-link dropdown-toggle user-chip" href="#" data-bs-toggle="dropdown"><?php if ($user['avatar']): ?><img src="<?= app_asset($user['avatar']) ?>" class="avatar" alt="avatar"><?php endif; ?>Hello, <?= e($user['name']) ?></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="<?= is_admin() ? app_url('admin/index.php') : app_url('user/dashboard.php') ?>">Dashboard</a></li><li><a class="dropdown-item" href="<?= app_url('user/profile.php') ?>">Profile</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="<?= app_url('logout.php') ?>">Logout</a></li></ul></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light ms-lg-2" href="<?= app_url('login.php') ?>">Login</a></li><li class="nav-item"><a class="btn btn-light ms-lg-2" href="<?= app_url('register.php') ?>">Register</a></li>

    <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php"><img src="<?= app_asset('assets/images/logo.svg') ?>" class="logo" alt="Saraswati Library logo"><span><?= APP_NAME ?></span></a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="/index.php#home">Home</a></li><li class="nav-item"><a class="nav-link" href="/index.php#facilities">Facilities</a></li><li class="nav-item"><a class="nav-link" href="/index.php#about">About</a></li><li class="nav-item"><a class="nav-link" href="/index.php#pricing">Pricing</a></li><li class="nav-item"><a class="nav-link" href="/index.php#contact">Contact</a></li>
        <li class="nav-item"><button id="themeToggle" class="btn btn-sm btn-outline-light ms-lg-2"><i class="fa-solid fa-moon"></i> <span>Dark Mode</span></button></li>
        <?php if ($user): ?>
          <li class="nav-item dropdown ms-lg-2"><a class="nav-link dropdown-toggle user-chip" href="#" data-bs-toggle="dropdown"><?php if ($user['avatar']): ?><img src="<?= app_asset($user['avatar']) ?>" class="avatar" alt="avatar"><?php endif; ?>Hello, <?= e($user['name']) ?></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="<?= is_admin() ? '/admin/index.php' : '/user/dashboard.php' ?>">Dashboard</a></li><li><a class="dropdown-item" href="/user/profile.php">Profile</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="/logout.php">Logout</a></li></ul></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light ms-lg-2" href="/login.php">Login</a></li><li class="nav-item"><a class="btn btn-light ms-lg-2" href="/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main>
