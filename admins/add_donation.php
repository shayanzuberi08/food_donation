<?php
session_start();
include '../db_connect.php';

// Only donor allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'donor') {
    header("Location: ../login.php");
    exit();
}

// Handle form submission
if (isset($_POST['add_donation'])) {
    $donor_id = $_SESSION['user_id'];
    $food_name = $_POST['food_name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];

    // ✅ Insert using correct columns
    $stmt = $conn->prepare("INSERT INTO donations (donor_id, food_name, description, quantity, location, status, created_at) 
                            VALUES (?, ?, ?, ?, ?, 'Pending', NOW())");
    $stmt->bind_param("issis", $donor_id, $food_name, $description, $quantity, $location);

    if ($stmt->execute()) {
        $success = "Donation added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Donation - FoodShare</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/add_donation.css">
</head>
<body>

  <!-- Sidebar -->
  <?php include 'donor_sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main-content">
    <h1><i class="fa-solid fa-circle-plus"></i> Add Donation</h1>
    <p>Share your surplus food with those in need by adding donation details below.</p>

    <!-- Success or Error Alerts -->
    <?php if (isset($success)) : ?>
      <div class="alert success"><i class="fa-solid fa-check-circle"></i> <?= $success; ?></div>
    <?php elseif (isset($error)) : ?>
      <div class="alert error"><i class="fa-solid fa-circle-xmark"></i> <?= $error; ?></div>
    <?php endif; ?>

    <!-- Donation Form -->
    <div class="form-container">
      <form action="" method="POST" class="donation-form">
        
        <div class="form-group">
          <label><i class="fa-solid fa-utensils"></i> Food Name</label>
          <input type="text" name="food_name" placeholder="e.g. Cooked Meal, Fruits, Biryani" required>
        </div>

        <div class="form-group">
          <label><i class="fa-solid fa-align-left"></i> Description</label>
          <textarea name="description" rows="3" placeholder="Short description of the food" required></textarea>
        </div>

        <div class="form-group">
          <label><i class="fa-solid fa-scale-balanced"></i> Quantity</label>
          <input type="number" name="quantity" min="1" placeholder="Enter quantity (in kg or portions)" required>
        </div>

        <div class="form-group">
          <label><i class="fa-solid fa-location-dot"></i> Location</label>
          <input type="text" name="location" placeholder="Pickup location" required>
        </div>

        <button type="submit" name="add_donation" class="btn">
          <i class="fa-solid fa-hand-holding-heart"></i> Add Donation
        </button>
      </form>
    </div>
  </div>

</body>
</html>
