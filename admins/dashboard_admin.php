<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>
<body>

<div class="dashboard-container">
  <?php include 'sidebar.php'; ?>
  <!-- Main Content -->
  <main class="main-content">
    <header>
      <h2>Welcome, <span><?php echo $_SESSION['name']; ?></span> 👋</h2>
      <p>Admin Dashboard Overview</p>
    </header>

    <section class="stats">
      <div class="stat-card">
        <i class="fa-solid fa-users"></i>
        <h3>Total Donors</h3>
        <p>25</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-hand-holding-heart"></i>
        <h3>Total Receivers</h3>
        <p>18</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-box"></i>
        <h3>Donations Made</h3>
        <p>42</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-chart-pie"></i>
        <h3>Active Requests</h3>
        <p>6</p>
      </div>
    </section>

    <section class="info">
      <h3>Platform Insights</h3>
      <p>
        FoodShare connects donors and receivers through a transparent system that encourages 
        sustainability and community support. As an admin, you can manage users, monitor food donations, 
        and ensure that all activities follow platform policies.
      </p>
    </section>
  </main>
</div>

</body>
</html>
