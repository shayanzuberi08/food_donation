<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodShare | Reduce Food Waste</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/header.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">
      <i class="fa-solid fa-seedling"></i> Food<span>Share</span>
    </div>

    <!-- Toggle Button -->
    <div class="menu-toggle" id="menu-toggle">
      <i class="fa-solid fa-bars"></i>
      <i class="fa-solid fa-xmark"></i>
    </div>

    <!-- Navigation Links -->
    <ul class="nav-links" id="nav-links">
      <li><a href="index.php" class="active"><i class="fa-solid fa-house"></i> Home</a></li>
      <li><a href="register.php"><i class="fa-solid fa-user-plus"></i> Register</a></li>
      <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
      <li><a href="about.php"><i class="fa-solid fa-circle-info"></i> About</a></li>
      <li><a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a></li>
    </ul>
  </nav>
</header>

<script>
  // JavaScript for Toggle Menu
  const toggle = document.getElementById('menu-toggle');
  const nav = document.getElementById('nav-links');
  
  toggle.addEventListener('click', () => {
    nav.classList.toggle('active');
    toggle.classList.toggle('open');
  });
</script>

</body>
</html>
