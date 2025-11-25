<?php
session_start();
include '../db_connect.php';

// Only receiver can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'receiver') {
    header("Location: ../login.php");
    exit();
}

// Fetch available donations
$result = $conn->query("
  SELECT donations.*, users.name AS donor_name, users.phone, users.address 
  FROM donations 
  JOIN users ON donations.donor_id = users.user_id 
  WHERE donations.status = 'Available'
  ORDER BY donations.donation_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Donations - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/available_donations.css">
</head>
<body>
  <?php include 'receiver_sidebar.php'; ?>

  <main class="main-content">
    <h1><i class="fa-solid fa-hand-holding-heart"></i> Available Donations</h1>
    <p>Browse the list of available food donations and request the ones you need.</p>

    <div class="donation-list">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
          <div class='donation-card'>
            <div class='card-header'>
              <i class='fa-solid fa-bowl-food'></i>
              <h3>{$row['food_name']}</h3>
            </div>
            <p><strong>Quantity:</strong> {$row['quantity']}</p>
            <p><strong>Location:</strong> {$row['location']}</p>
            <p><strong>Donor:</strong> {$row['donor_name']}</p>
            <p><strong>Contact:</strong> {$row['phone']}</p>

            <!-- Redirect form to requests.php -->
            <form method='POST' action='requests.php'>
              <input type='hidden' name='donation_id' value='{$row['donation_id']}'>
              <button type='submit' name='request_donation' class='btn'>
                <i class='fa-solid fa-paper-plane'></i> Request
              </button>
            </form>
          </div>
          ";
        }
      } else {
        echo "<p class='no-data'>No donations available right now.</p>";
      }
      ?>
    </div>
  </main>
</body>
</html>
