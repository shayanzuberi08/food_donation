<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receiver Sidebar - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/receiver_sidebar.css">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="logo">
      <i class="fa-solid fa-bars toggle-btn" id="toggle-btn"></i>
      <span class="logo-text"><i class="fa-solid fa-seedling"></i> FoodShare</span>
    </div>

    <ul>
      <li><a href="dashboard_receiver.php" class="active"><i class="fa-solid fa-house"></i> <span>Dashboard</span></a></li>
      <li><a href="available_donations.php"><i class="fa-solid fa-hand-holding-heart"></i> <span>View Donations</span></a></li>
      <li><a href="my_requests.php"><i class="fa-solid fa-box"></i> <span>My Requests</span></a></li>
      <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a></li>
    </ul>
  </aside>

  <script>
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggle-btn");

    // Auto collapse after 5 seconds
    setTimeout(() => {
      sidebar.classList.add("collapsed");
    }, 5000);

    // Expand on hover
    sidebar.addEventListener("mouseenter", () => {
      sidebar.classList.remove("collapsed");
    });

    // Collapse on hover out
    sidebar.addEventListener("mouseleave", () => {
      sidebar.classList.add("collapsed");
    });

    // Manual toggle
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
    });
  </script>

</body>
</html>
