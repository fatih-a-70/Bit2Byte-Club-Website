<?php
include "php/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Community | Bit2Byte KUET</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header class="site-header">
    <nav class="navbar container">
      <a href="index.php" class="brand"><span class="brand-mark">B2B</span><span
          class="brand-text"><span>Bit2Byte</span><small>KUET</small></span></a>
      <ul class="nav-menu">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="about.php" class="nav-link">About</a></li>
        <li><a href="programs.php" class="nav-link">Programs</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="blog.php" class="nav-link active">Community</a></li>
        <li><a href="events.php" class="nav-link">Events</a></li>
        <li><a href="contact.php" class="nav-link">Contact</a></li>
        <li><a href="register.php" class="btn btn-primary">Join Us</a></li>
        <li><a href="login.php" class="btn btn-soft">Login</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="page-hero">
      <div class="container">
        <span class="section-kicker">Community</span>
        <h1>Community Feed</h1>
        <p>
          Blogs, resources, achievements, announcements, and knowledge sharing
          from Bit2Byte KUET.
        </p>
      </div>
    </section>

    <section class="section section-soft">
      <div class="container">
        <div class="blog-grid">
          <?php
          $stmt = $conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC");
          $stmt->execute();
          $result = $stmt->get_result();

          if($result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                  ?>
                  <div class="blog-card">
                    <div class="blog-img">
                      <div>
                        <img src="uploads/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                      </div>
                    </div>
                    <span class="date-badge"><?php echo htmlspecialchars($row['category']); ?></span>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <a href="<?php echo htmlspecialchars($row['link']); ?>">Read More</a>
                  </div>
                  <?php
              }
          } else {
              echo '<p class="empty-note">No blogs found.</p>';
          }
          ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container" style="text-align: center; color: var(--white); padding: 24px 0">
      © 2026 Bit2Byte KUET
    </div>
  </footer>

  <script src="js/main.js"></script>
</body>

</html>