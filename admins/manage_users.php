<?php
session_start();
include '../db_connect.php';

// Redirect if not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Delete user logic
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE user_id = '$user_id'");
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - FoodShare Admin</title>

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/manage_users.css">
</head>
<body>

  <!-- Sidebar Include -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main-content">
    <h1><i class="fa-solid fa-users"></i> Manage Users</h1>
    <p>Here you can view and manage all registered users of the FoodShare platform.</p>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Created At</th>
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
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td><span class='role {$row['role']}'>{$row['role']}</span></td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                      <a href='manage_users.php?delete={$row['user_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this user?\")'>
                        <i class='fa-solid fa-trash'></i> Delete
                      </a>
                    </td>
                  </tr>";
                  $i++;
              }
          } else {
              echo "<tr><td colspan='8' style='text-align:center;'>No users found!</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
