<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'donor') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor Dashboard - FoodShare</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/dashboard_donor.css">
</head>
<body>

<div class="dashboard-container">
  <?php include 'donor_sidebar.php'; ?>

  <!-- Main Content -->
  <main class="main-content">
    <header>
      <h2>Welcome, <span><?php echo $_SESSION['name']; ?></span> 🌿</h2>
      <p>Donor Dashboard Overview</p>
    </header>

    <section class="stats">
      <div class="stat-card">
        <i class="fa-solid fa-hand-holding-heart"></i>
        <h3>Total Donations</h3>
        <p>14</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-box"></i>
        <h3>Pending Approvals</h3>
        <p>3</p>
      </div>
      <div class="stat-card">
        <i class="fa-solid fa-truck"></i>
        <h3>Delivered Items</h3>
        <p>9</p>
      </div>
    </section>

    <section class="info">
      <h3>Welcome to the Donor Dashboard</h3>
      <p>
        As a valued donor, you can add new food donations, track pending requests, and see your donation history.
        Thank you for helping build a sustainable and generous community through FoodShare.
      </p>
    </section>
  </main>
</div>

</body>
</html>
