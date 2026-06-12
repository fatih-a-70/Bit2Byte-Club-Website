<?php
session_start();
include "php/config.php";

 if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$projectCount = $conn->query("SELECT COUNT(*) as cnt FROM projects")->fetch_assoc()['cnt'];
$blogCount = $conn->query("SELECT COUNT(*) as cnt FROM blogs")->fetch_assoc()['cnt'];
$eventCount = $conn->query("SELECT COUNT(*) as cnt FROM events")->fetch_assoc()['cnt'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Bit2Byte KUET</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
  <nav class="navbar container">
    <a href="admin-dashboard.php" class="brand"><span class="brand-mark">B2B</span><span class="brand-text"><span>Bit2Byte</span><small>KUET</small></span></a>
    <ul class="nav-menu">
      <li><a href="admin-dashboard.php" class="nav-link active">Dashboard</a></li>
      <li><a href="add-project.html" class="nav-link">Add Project</a></li>
      <li><a href="add-blog.html" class="nav-link">Add Blog</a></li>
      <li><a href="add-event.html" class="nav-link">Add Event</a></li>
      <li><a href="php/logout.php" class="btn btn-soft">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <section class="page-hero">
    <div class="container">
      <span class="section-kicker">Admin Dashboard</span>
      <h1>Welcome, Admin!</h1>
      <p>Manage projects, blog posts, events, and member registrations from here.</p>
    </div>
  </section>

  <section class="section section-soft">
    <div class="container stats-grid">
      <div>
        <strong><?php echo $projectCount; ?></strong>
        <span>Total Projects</span>
      </div>
      <div>
        <strong><?php echo $eventCount; ?></strong>
        <span>Upcoming Events</span>
      </div>
      <div>
        <strong><?php echo $blogCount; ?></strong>
        <span>Blog Posts</span>
      </div>
    </div>

    <div class="container" style="margin-top:40px;">
      <div class="section-head">
        <span class="section-kicker">Quick Actions</span>
        <h2>Add New Content</h2>
      </div>
      <div style="display:flex;gap:20px;flex-wrap:wrap;justify-content:center;">
        <a href="add-project.html" class="btn btn-primary">Add Project</a>
        <a href="add-blog.html" class="btn btn-primary">Add Blog</a>
        <a href="add-event.html" class="btn btn-primary">Add Event</a>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="container">© 2026 Bit2Byte KUET</div>
</footer>

<script src="js/main.js"></script>
</body>
</html>