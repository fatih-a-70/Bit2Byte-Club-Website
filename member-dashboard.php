<?php
session_start();
include "php/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

// Fetch counts
$projectCount = $conn->query("SELECT COUNT(*) as total FROM member_projects WHERE user_id=$user_id")->fetch_assoc()['total'];
$blogCount    = $conn->query("SELECT COUNT(*) as total FROM member_blogs WHERE user_id=$user_id")->fetch_assoc()['total'];
$eventCount   = $conn->query("SELECT COUNT(*) as total FROM member_events WHERE user_id=$user_id")->fetch_assoc()['total'];

// Fetch user projects
$memberProjectsStmt = $conn->prepare("
    SELECT p.*
    FROM member_projects mp
    JOIN projects p ON mp.project_id = p.id
    WHERE mp.user_id = ?
    ORDER BY mp.created_at DESC
");
$memberProjectsStmt->bind_param("i", $user_id);
$memberProjectsStmt->execute();
$memberProjectsResult = $memberProjectsStmt->get_result();

// Fetch user blogs
$memberBlogsStmt = $conn->prepare("
    SELECT b.*
    FROM member_blogs mb
    JOIN blogs b ON mb.blog_id = b.id
    WHERE mb.user_id = ?
    ORDER BY mb.created_at DESC
");
$memberBlogsStmt->bind_param("i", $user_id);
$memberBlogsStmt->execute();
$memberBlogsResult = $memberBlogsStmt->get_result();

// Fetch user events
$memberEventsStmt = $conn->prepare("
    SELECT e.*
    FROM member_events me
    JOIN events e ON me.event_id = e.id
    WHERE me.user_id = ?
    ORDER BY me.created_at DESC
");
$memberEventsStmt->bind_param("i", $user_id);
$memberEventsStmt->execute();
$memberEventsResult = $memberEventsStmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Member Dashboard | Bit2Byte KUET</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
  <nav class="navbar container">
    <a href="index.php" class="brand"><span class="brand-mark">B2B</span><span class="brand-text"><span>Bit2Byte</span><small>KUET</small></span></a>
    <ul class="nav-menu">
      <li><a href="member-dashboard.php" class="nav-link active">Dashboard</a></li>
      <li><a href="projects.php" class="nav-link">Projects</a></li>
      <li><a href="events.php" class="nav-link">Events</a></li>
      <li><a href="blog.php" class="nav-link">Community</a></li>
      <li><a href="php/logout.php" class="btn btn-soft">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
<section class="page-hero">
  <div class="container">
    <span class="section-kicker">Dashboard</span>
    <h1>Welcome, Member!</h1>
    <p>Track your registered events, projects, and blogs.</p>
  </div>
</section>

<section class="section section-soft">
  <div class="container stats-grid">
    <div>
      <strong><?php echo $projectCount; ?></strong>
      <span>Projects Contributed</span>
    </div>
    <div>
      <strong><?php echo $eventCount; ?></strong>
      <span>Bookmarked Events</span>
    </div>
    <div>
      <strong><?php echo $blogCount; ?></strong>
      <span>Saved Blogs</span>
    </div>
  </div>

<div class="member-dashboard-section">


  <h2>Your Projects</h2>
  <div class="project-grid">
    <?php
    if($memberProjectsResult->num_rows > 0){
        while($row = $memberProjectsResult->fetch_assoc()){
            ?>
            <div class="project-card">
                <div class="project-img">
                    <div><img src="uploads/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"></div>
                </div>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="tag-row">
                <?php
                $tags = explode(',', $row['tags']);
                foreach($tags as $tag){
                    echo '<span>'.htmlspecialchars($tag).'</span>';
                }
                ?>
                </div>
                <a href="<?php echo htmlspecialchars($row['link']); ?>">View Project</a>
            </div>
            <?php
        }
    } else { echo '<p class="empty-note">No projects added yet.</p>'; }
    ?>
  </div>
    </div>



  <div class="member-dashboard-section">

  <h2>Your Blogs</h2>
  <div class="blog-grid">
    <?php
    if($memberBlogsResult->num_rows > 0){
        while($row = $memberBlogsResult->fetch_assoc()){
            ?>
            <div class="blog-card">
                <div class="blog-img">
                    <div><img src="uploads/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"></div>
                </div>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <a href="<?php echo htmlspecialchars($row['link']); ?>">Read More</a>
            </div>
            <?php
        }
    } else { echo '<p class="empty-note">No blogs added yet.</p>'; }
    ?>
  </div>
    </div>

  <div class="member-dashboard-section">

  <h2>Your Events</h2>
  <div class="event-grid">
    <?php
    if($memberEventsResult->num_rows > 0){
        while($row = $memberEventsResult->fetch_assoc()){
            ?>
            <div class="event-card">
                <div class="event-img">
                    <div><img src="uploads/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"></div>
                </div>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="tag-row">
                <?php
                $tags = explode(',', $row['type'] ?? '');
                foreach($tags as $tag){ echo '<span>'.htmlspecialchars(trim($tag)).'</span>'; }
                ?>
                </div>
                <a href="<?php echo htmlspecialchars($row['link'] ?? '#'); ?>"><?php echo ($row['event_date'] >= date('Y-m-d')) ? 'Register Now' : 'View Recap'; ?></a>
            </div>
            <?php
        }
    } else { echo '<p class="empty-note">No events added yet.</p>'; }
    ?>
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