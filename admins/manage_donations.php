<?php
session_start();
include '../db_connect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Only admin allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM donations WHERE donation_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['message'] = "Donation deleted successfully.";
    header("Location: manage_donations.php");
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['donation_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE donations SET status = ? WHERE donation_id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Donation status updated successfully.";
    } else {
        $_SESSION['message'] = "Error updating status: " . $stmt->error;
    }

    header("Location: manage_donations.php");
    exit();
}

// Fetch donations
$result = $conn->query("
  SELECT donations.*, users.name AS donor_name, users.email 
  FROM donations 
  JOIN users ON donations.donor_id = users.user_id 
  ORDER BY donations.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Donations - FoodShare Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/manage_donations.css">
</head>
<body>

  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <h1><i class="fa-solid fa-hand-holding-heart"></i> Manage Donations</h1>
    <p>All food donations made by users are listed below. You can update their status or remove them if needed.</p>

    <?php 
    if (isset($_SESSION['message'])) {
        echo "<p style='background:#e3fcef;color:#0a8f50;padding:10px;border-radius:5px;width:fit-content;'>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    }
    ?>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Donor</th>
            <th>Food Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
<?php 
if ($result->num_rows > 0) {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "
        <tr>
          <td>{$i}</td>
          <td>{$row['donor_name']}<br><small>{$row['email']}</small></td>
          <td>{$row['food_name']}</td>
          <td>{$row['description']}</td>
          <td>{$row['quantity']}</td>
          <td>{$row['location']}</td>
          <td>{$row['created_at']}</td>
          <td>
            <form method='POST' action='manage_donations.php' class='status-form'>
              <input type='hidden' name='donation_id' value='{$row['donation_id']}'>
              <select name='status' class='status-select'>
                <option value='Available' " . ($row['status']=='Pending'?'selected':'') . ">Available</option>
                <option value='Requested' " . ($row['status']=='Approved'?'selected':'') . ">Requested</option>
                <option value='Completed' " . ($row['status']=='Delivered'?'selected':'') . ">Completed</option>
              </select>
              <button type='submit' name='update_status' class='update-btn'>
                <i class='fa-solid fa-rotate'></i>
              </button>
            </form>
          </td>
          <td>
            <a href='manage_donations.php?delete={$row['donation_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this donation?\")'>
              <i class='fa-solid fa-trash'></i>
            </a>
          </td>
        </tr>
        ";
        $i++;
    }
} else {
    echo "<tr><td colspan='9' style='text-align:center;'>No donations found!</td></tr>";
}
?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
