<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodShare Sidebar</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <i class="fa-solid fa-bars toggle-btn" id="toggle-btn"></i>
      <span class="logo-text"><i class="fa-solid fa-seedling"></i> FoodShare</span>
    </div>
    <ul>
      <li><a href="dashboard_admin.php" class="active"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
      <li><a href="manage_users.php"><i class="fa-solid fa-users"></i><span>Manage Users</span></a></li>
      <li><a href="manage_donations.php"><i class="fa-solid fa-hand-holding-heart"></i><span>Donations</span></a></li>
      <li><a href="request_admin.php"><i class="fa-solid fa-clipboard-list"></i><span>Requests</span></a></li>
      <li><a href="manage_messages.php"><i class="fa-solid fa-envelope"></i><span>Messages</span></a></li>
      <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a></li>
    </ul>
  </aside>


  <!-- JavaScript -->
  <script>
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggle-btn");

    // Collapse sidebar after 5 seconds
    setTimeout(() => {
      sidebar.classList.add("collapsed");
    }, 5000);

    // Expand sidebar on hover
    sidebar.addEventListener("mouseenter", () => {
      sidebar.classList.remove("collapsed");
    });

    // Collapse sidebar when hover out
    sidebar.addEventListener("mouseleave", () => {
      sidebar.classList.add("collapsed");
    });

    // Manual toggle on icon click
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  </script>
</body>
</html>
