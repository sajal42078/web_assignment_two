<?php
require_once __DIR__ . '/../includes/config.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Login check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); 
    exit;
}

// Use relative path for navigation links
$admin_base = '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel - Travel Memories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= $admin_base ?>dashboard.php">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="<?= $admin_base ?>dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $admin_base ?>posts.php">Posts</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $admin_base ?>users.php">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $admin_base ?>logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
<div class="row">