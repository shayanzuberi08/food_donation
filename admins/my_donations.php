<?php
session_start();
include '../db_connect.php';

// ✅ Only donor can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'donor') {
    header("Location: ../login.php");
    exit();
}

$donor_id = $_SESSION['user_id'];

// ✅ Fetch all donations created by this donor
$result = $conn->query("
  SELECT 
    d.donation_id,
    d.food_name,
    d.quantity,
    d.location,
    d.status,
    d.created_at,
    r.receiver_id,
    r.status AS request_status,
    u.name AS receiver_name,
    u.phone AS receiver_phone
  FROM donations d
  LEFT JOIN requests r ON d.donation_id = r.donation_id
  LEFT JOIN users u ON r.receiver_id = u.user_id
  WHERE d.donor_id = '$donor_id'
  ORDER BY d.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Donations - FoodShare</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
  /* ========== Global Styles (your theme) ========== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f5f6fa;
      display: flex;
    }

    .main-content {
      margin-left: 260px;
      padding: 40px;
      flex: 1;
      background: #f5f6fa;
      min-height: 100vh;
      transition: margin-left 0.4s ease;
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: 100px;
    }

    .main-content h1 {
      color: #27ae60;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .main-content p {
      color: #555;
      margin-bottom: 20px;
    }

    /* ========== Table Styling ========== */
    .table-container {
      background: white;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      color: #27ae60;
      font-weight: 600;
      background: #f9f9f9;
    }

    tr:hover {
      background: #f8fdf9;
    }

    .status {
      padding: 6px 10px;
      border-radius: 6px;
      font-weight: 600;
      text-transform: capitalize;
      font-size: 0.9rem;
    }

    .Available { background: #d4f6e6; color: #27ae60; }
    .Pending { background: #fff3cd; color: #856404; }
    .Donated { background: #d1ecf1; color: #0c5460; }

    .no-data {
      text-align: center;
      color: #888;
      padding: 15px;
    }

    /* ========== Responsive ========== */
    @media (max-width: 768px) {
      .main-content {
        margin-left: 100px;
        padding: 20px;
      }

      .table-container {
        padding: 20px;
      }

      th, td {
        padding: 10px;
      }
    }
  </style>
</head>
<body>

  <?php 
  // ✅ Include donor sidebar if it exists
  $sidebarPath = __DIR__ . '/donor_sidebar.php';
  if (file_exists($sidebarPath)) {
      include $sidebarPath;
  } else {
      echo "<p style='padding:20px; background:#ffcccc; color:#c0392b; border-radius:8px;'>⚠️ Sidebar file (donor_sidebar.php) not found.</p>";
  }
  ?>

  <main class="main-content">
    <h1><i class="fa-solid fa-hand-holding-heart"></i> My Donations</h1>
    <p>Here you can view all your donated items and their current status.</p>

    <?php
    if ($result->num_rows > 0) {
      echo "<table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Food Item</th>
                  <th>Quantity</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Requested By</th>
                  <th>Contact</th>
                  <th>Created On</th>
                </tr>
              </thead>
              <tbody>";
      $i = 1;
      while ($row = $result->fetch_assoc()) {
          $statusClass = ucfirst($row['status']);
          $receiver = $row['receiver_name'] ? $row['receiver_name'] : '—';
          $phone = $row['receiver_phone'] ? $row['receiver_phone'] : '—';
          echo "
            <tr>
              <td>{$i}</td>
              <td>{$row['food_name']}</td>
              <td>{$row['quantity']}</td>
              <td>{$row['location']}</td>
              <td><span class='status {$statusClass}'>{$row['status']}</span></td>
              <td>{$receiver}</td>
              <td>{$phone}</td>
              <td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>
            </tr>
          ";
          $i++;
      }
      echo "</tbody></table>";
    } else {
      echo "<p class='no-data'>No donations added yet.</p>";
    }
    ?>
  </main>
</body>
</html>
