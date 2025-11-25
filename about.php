<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/about.css">
</head>
<body>
<?php include 'include/header.php'; ?>

<section class="about-section">
  <div class="about-container">
    <div class="about-text">
      <h1><i class="fa-solid fa-seedling"></i> About <span>FoodShare</span></h1>
      <p>
        <strong>FoodShare</strong> is a community-driven food donation and waste reduction platform 
        launched in <b>2025</b>. Our mission is to connect people who have surplus food 
        (donors) with those in need (receivers), helping to reduce food waste and hunger at the same time.
      </p>
      <p>
        Every day, tons of edible food are wasted while many go hungry. FoodShare bridges this gap 
        by offering a simple, web-based solution for individuals, restaurants, and organizations 
        to share excess food safely and efficiently.
      </p>

      <div class="stats">
        <div class="stat-box">
          <i class="fa-solid fa-calendar-check"></i>
          <h3>Since 2025</h3>
          <p>Helping reduce food waste & hunger</p>
        </div>
        <div class="stat-box">
          <i class="fa-solid fa-users"></i>
          <h3>3+ Active Roles</h3>
          <p>Admin • Donor • Receiver</p>
        </div>
        <div class="stat-box">
          <i class="fa-solid fa-earth-asia"></i>
          <h3>Community Impact</h3>
          <p>Connecting local people to make a difference</p>
        </div>
      </div>
    </div>

    <div class="about-image">
      <img src="images/about.jpg" alt="Food Donation">
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="team-section">
  <h2><i class="fa-solid fa-people-group"></i> Our Team</h2>
  <p>Meet the people who made FoodShare possible.</p>

  <div class="team-container">
    <div class="team-member">
      <img src="images/member1.jpg" alt="Team Member">
      <h3>Michael</h3>
      <p>Lead Developer</p>
    </div>

    <div class="team-member">
      <img src="images/member2.jpg" alt="Team Member">
      <h3>James</h3>
      <p>UI/UX Designer</p>
    </div>

    <div class="team-member">
      <img src="images/member3.jpg" alt="Team Member">
      <h3>William</h3>
      <p>Database Engineer</p>
    </div>

    <div class="team-member">
      <img src="images/member4.jpg" alt="Team Member">
      <h3>David</h3>
      <p>Project Supervisor</p>
    </div>
  </div>
</section>

<?php include 'include/footer.php'; ?>
</body>
</html>
