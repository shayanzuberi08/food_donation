<?php
session_start();
include '../db_connect.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Delete message
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM messages WHERE message_id = '$id'");
    header("Location: manage_messages.php");
    exit();
}

// Fetch messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages - FoodShare Admin</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/manage_messages.css">
</head>
<body>

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <h1><i class="fa-solid fa-envelope"></i> User Messages</h1>
    <p>All messages submitted through the FoodShare Contact Form are shown below.</p>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
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
                    <td class='msg-text'>{$row['message']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                      <a href='manage_messages.php?delete={$row['message_id']}' class='delete-btn' onclick='return confirm(\"Delete this message?\")'>
                        <i class='fa-solid fa-trash'></i>
                      </a>
                    </td>
                  </tr>
                  ";
                  $i++;
              }
          } else {
              echo "<tr><td colspan='7' style='text-align:center;'>No messages found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
