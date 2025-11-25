<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'receiver') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receiver Dashboard - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/receiver_dashboard.css">
</head>
<body>
<div class="dashboard-container">
  <?php include 'receiver_sidebar.php'; ?>

  <!-- Main Content -->
  <main class="main-content">
    <header>
      <h2>Welcome, <span><?php echo $_SESSION['name']; ?></span> 🌱</h2>
      <p>Receiver Dashboard Overview</p>
    </header>

    <section class="stats">
      <div class="stat-card">
        <i class="fa-solid fa-hand-holding-heart"></i>
        <h3>Available Donations</h3>
        <p>12</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-box"></i>
        <h3>Received Items</h3>
        <p>8</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-clock"></i>
        <h3>Pending Requests</h3>
        <p>3</p>
      </div>
    </section>

    <section class="info">
      <h3>Welcome to the Receiver Dashboard</h3>
    <p>Here you can view and manage your received donations, requests, and account details.</p>
    </section>
  </main>
</div>

</body>
</html>
