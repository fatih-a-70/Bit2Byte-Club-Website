<?php
include "php/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events | Bit2Byte KUET</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header class="site-header">
    <nav class="navbar container">
      <a href="index.php" class="brand"><span class="brand-mark">B2B</span><span class="brand-text"><span>Bit2Byte</span><small>KUET</small></span></a>
      <ul class="nav-menu">
         <li><a href="index.html" class="nav-link">Home</a></li>
        <li><a href="about.html" class="nav-link">About</a></li>
        <li><a href="programs.html" class="nav-link">Programs</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="blog.php" class="nav-link active">Community</a></li>
        <li><a href="events.php" class="nav-link">Events</a></li>
        <li><a href="contact.html" class="nav-link">Contact</a></li>
        <li><a href="register.html" class="btn btn-primary">Join Us</a></li>
        <li><a href="login.html" class="btn btn-soft">Login</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <span class="section-kicker">Events</span>
        <h1>Workshops, Sessions & Meetups</h1>
        <p>Stay updated with upcoming workshops, technical sessions, hackathon preparation programs, and community events.</p>
      </div>
    </section>

    <section class="section section-soft">
      <div class="container">
        <div class="event-grid">
          <?php
          $stmt = $conn->prepare("SELECT * FROM events ORDER BY event_date DESC");
          $stmt->execute();
          $result = $stmt->get_result();

          if($result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                  $tags = explode(',', $row['type']); // split multiple tags
                  ?>
                  <div class="event-card">
                    <div class="event-img">
                      <div>
                        <img src="uploads/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                      </div>
                    </div>
                    <span class="date-badge"><?php echo ($row['event_date'] >= date('Y-m-d')) ? 'Upcoming' : 'Past Event'; ?></span>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="tag-row">
                      <?php
                      foreach($tags as $tag){
                          echo '<span>'.htmlspecialchars(trim($tag)).'</span>';
                      }
                      ?>
                    </div>
                    <a href="<?php echo htmlspecialchars($row['link'] ?? '#'); ?>"><?php echo ($row['event_date'] >= date('Y-m-d')) ? 'Register Now' : 'View Recap'; ?></a>
                  </div>
                  <?php
              }
          } else {
              echo '<p class="empty-note">No events found.</p>';
          }
          ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container" style="text-align:center; color: var(--white); padding:24px 0;">© 2026 Bit2Byte KUET</div>
  </footer>

  <script src="js/main.js"></script>
</body>

</html>