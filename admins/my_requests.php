<?php
session_start();
include '../db_connect.php';

// Only receiver allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'receiver') {
    header("Location: ../login.php");
    exit();
}

$receiver_id = $_SESSION['user_id'];

// ✅ Adjusted query to match your tables
$result = $conn->query("
  SELECT r.request_id, r.request_date, r.status,
         d.donation_id, d.food_name,d.quantity, d.location,
         u.name AS donor_name, u.phone
  FROM requests r
  JOIN donations d ON r.donation_id = d.donation_id
  JOIN users u ON d.donor_id = u.user_id
  WHERE r.receiver_id = '$receiver_id'
  ORDER BY r.request_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Requests - FoodShare</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/my_requests.css">
</head>
<body>
  <?php include 'receiver_sidebar.php'; ?>

  <main class="main-content">
    <h1><i class="fa-solid fa-box"></i> My Requests</h1>
    <p>Track the status of your donation requests here.</p>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Donor</th>
            <th>Location</th>
            <th>Status</th>
            <th>Requested On</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
          $i = 1;
          while ($row = $result->fetch_assoc()) {
            $statusClass = strtolower($row['status']);
            echo "
            <tr>
              <td>{$i}</td>
              <td>{$row['food_name']}</td>
              <td>{$row['quantity']}</td>
              <td>{$row['donor_name']}<br><small>{$row['phone']}</small></td>
              <td>{$row['location']}</td>
              <td><span class='status {$statusClass}'>{$row['status']}</span></td>
              <td>" . date('M d, Y', strtotime($row['request_date'])) . "</td>
            </tr>";
            $i++;
          }
        } else {
          echo "<tr><td colspan='7' style='text-align:center;'>No requests found.</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
