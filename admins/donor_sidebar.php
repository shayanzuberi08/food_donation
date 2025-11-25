<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/donor_sidebar.css">
    <title>Document</title>
</head>
<body>
    <!-- donor_sidebar.php -->
<aside class="sidebar" id="sidebar">
  <div class="logo">
    <i class="fa-solid fa-bars toggle-btn" id="toggle-btn"></i>
    <span class="logo-text"><i class="fa-solid fa-seedling"></i> FoodShare</span>
  </div>

  <ul>
    <li><a href="dashboard_donor.php" class="active"><i class="fa-solid fa-house"></i> <span>Dashboard</span></a></li>
    <li><a href="add_donation.php"><i class="fa-solid fa-circle-plus"></i> <span>Add Donation</span></a></li>
    <li><a href="my_donations.php"><i class="fa-solid fa-box"></i> <span>My Donations</span></a></li>
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

// Collapse when mouse leaves
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