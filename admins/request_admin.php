<?php
session_start();
include '../db_connect.php';

// ✅ Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// ✅ Handle Approve/Reject buttons
if (isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['update_status']; // Button se value: Approve / Reject

    // Normalize the value
    if ($new_status == 'Approve') {
        $new_status = 'Approved';
    } elseif ($new_status == 'Reject') {
        $new_status = 'Rejected';
    }

    // ✅ Update request table
    $updateRequest = $conn->query("UPDATE requests SET status = '$new_status' WHERE request_id = '$request_id'");

    // ✅ If approved → also update the related donation
    if ($new_status == 'Approved') {
        $updateDonation = $conn->query("
            UPDATE donations
            SET status = 'Donated'
            WHERE donation_id = (
                SELECT donation_id FROM requests WHERE request_id = '$request_id'
            )
        ");
    }

    // ✅ Show success message only if DB update was successful
    if ($updateRequest) {
        $message = "✅ Request status updated successfully!";
    } else {
        $message = "⚠️ Failed to update request status.";
    }
}

// ✅ Fetch all requests with donor + receiver details
$result = $conn->query("
  SELECT 
      r.request_id, 
      r.request_date, 
      r.status,
      d.food_name, 
      d.quantity, 
      d.location,
      donor.name AS donor_name, 
      receiver.name AS receiver_name,
      receiver.phone AS receiver_phone
  FROM requests r
  JOIN donations d ON r.donation_id = d.donation_id
  JOIN users donor ON d.donor_id = donor.user_id
  JOIN users receiver ON r.receiver_id = receiver.user_id
  ORDER BY r.request_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Requests - Admin</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f6fa;
      display: flex;
    }

    .main-content {
      margin-left: 260px;
      padding: 40px;
      flex: 1;
      min-height: 100vh;
    }

    h1 {
      color: #27ae60;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .alert.success {
      background: #e8f8f2;
      color: #27ae60;
      padding: 10px 15px;
      border-left: 5px solid #27ae60;
      border-radius: 6px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .donation-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 20px;
    }

    .donation-card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .donation-card h3 {
      color: #27ae60;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }

    .donation-card p {
      margin: 6px 0;
      color: #333;
    }

    .status {
      font-weight: 600;
      padding: 5px 10px;
      border-radius: 8px;
    }

    .status.Pending {
      background: #fff3cd;
      color: #856404;
    }

    .status.Approved {
      background: #d4edda;
      color: #155724;
    }

    .status.Rejected {
      background: #f8d7da;
      color: #721c24;
    }

    .btn {
      border: none;
      padding: 8px 14px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.9rem;
    }

    .btn i {
      font-size: 0.9rem;
    }

    .btn:hover {
      opacity: 0.9;
    }

    .approve-btn {
      background: #27ae60;
    }

    .reject-btn {
      background: #e74c3c;
    }

    .no-data {
      text-align: center;
      color: #555;
      font-style: italic;
    }
  </style>
</head>
<body>

  <!-- ✅ Include Admin Sidebar -->
  <?php include 'sidebar.php'; ?>

  <main class="main-content">
    <h1><i class="fa-solid fa-clipboard-list"></i> Manage Donation Requests</h1>
    <p>View and manage all donation requests from receivers.</p>

    <?php if (!empty($message)): ?>
      <div class="alert success"><?= $message ?></div>
    <?php endif; ?>

    <div class="donation-list">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
          <div class='donation-card'>
            <h3><i class='fa-solid fa-bowl-food'></i> {$row['food_name']}</h3>
            <p><strong>Quantity:</strong> {$row['quantity']}</p>
            <p><strong>Location:</strong> {$row['location']}</p>
            <p><strong>Donor:</strong> {$row['donor_name']}</p>
            <p><strong>Receiver:</strong> {$row['receiver_name']} ({$row['receiver_phone']})</p>
            <p><strong>Requested on:</strong> {$row['request_date']}</p>
            <p><strong>Status:</strong> <span class='status {$row['status']}'>{$row['status']}</span></p>

            <form method='POST' style='margin-top:10px; display:flex; gap:10px;'>
              <input type='hidden' name='request_id' value='{$row['request_id']}'>
              <button type='submit' name='update_status' value='Approve' class='btn approve-btn'>
                <i class='fa-solid fa-check'></i> Approve
              </button>
              <button type='submit' name='update_status' value='Reject' class='btn reject-btn'>
                <i class='fa-solid fa-xmark'></i> Reject
              </button>
            </form>
          </div>
          ";
        }
      } else {
        echo "<p class='no-data'>No requests found.</p>";
      }
      ?>
    </div>
  </main>
</body>
</html>
