<?php
session_start();
include '../db_connect.php';

// Only admin allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM inventory WHERE inventory_id = '$id'");
    header("Location: manage_inventory.php");
    exit();
}

// Handle update
if (isset($_POST['update_item'])) {
    $id = $_POST['inventory_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $conn->query("UPDATE inventory SET quantity = '$quantity', status = '$status' WHERE inventory_id = '$id'");
    header("Location: manage_inventory.php");
    exit();
}

// Fetch inventory data
$result = $conn->query("
  SELECT inventory.*, users.name AS donor_name 
  FROM inventory 
  LEFT JOIN users ON inventory.donor_id = users.user_id 
  ORDER BY inventory.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food Inventory - FoodShare Admin</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/manage_inventory.css">
</head>
<body>

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main-content">
    <h1><i class="fa-solid fa-box"></i> Food Inventory</h1>
    <p>Monitor and manage all donated food items stored in the system.</p>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Donor</th>
            <th>Quantity</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Date Added</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        if ($result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                  <form method="POST" class="update-form">
                    <td><?= $i ?></td>
                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                    <td><?= htmlspecialchars($row['donor_name'] ?? 'N/A') ?></td>
                    <td>
                      <input type="hidden" name="inventory_id" value="<?= $row['inventory_id'] ?>">
                      <input type="number" name="quantity" value="<?= $row['quantity'] ?>" min="1" style="width:70px;text-align:center;">
                    </td>
                    <td><?= htmlspecialchars($row['expiry_date']) ?></td>
                    <td>
                      <select name="status" class="status-select">
                        <option value="Available" <?= $row['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                        <option value="Reserved" <?= $row['status'] == 'Reserved' ? 'selected' : '' ?>>Reserved</option>
                        <option value="Used" <?= $row['status'] == 'Used' ? 'selected' : '' ?>>Used</option>
                      </select>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                      <button type="submit" name="update_item" class="update-btn" title="Update">
                        <i class="fa-solid fa-rotate"></i>
                      </button>
                      <a href="manage_inventory.php?delete=<?= $row['inventory_id'] ?>" 
                         class="delete-btn" 
                         onclick="return confirm('Are you sure you want to delete this item?')"
                         title="Delete">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </td>
                  </form>
                </tr>
                <?php
                $i++;
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center;'>No items in inventory.</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
