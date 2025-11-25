<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);

  if (!empty($name) && !empty($email) && !empty($message)) {
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
      $success = "✅ Thank you, your message has been sent successfully!";
    } else {
      $error = "❌ Something went wrong. Please try again later.";
    }

    $stmt->close();
  } else {
    $error = "⚠️ Please fill in all required fields.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - FoodShare</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/contact.css">
</head>
<body>
<?php include 'include/header.php'; ?>

<section class="contact-section">
  <div class="contact-header">
    <h1><i class="fa-solid fa-envelope-circle-check"></i> Contact <span>Us</span></h1>
    <p>We’d love to hear from you! Reach out to us with any questions, feedback, or partnership opportunities.</p>
  </div>

  <!-- Success/Error Message -->
  <?php if (!empty($success)): ?>
    <div class="alert success"><i class="fa-solid fa-circle-check"></i> <?= $success ?></div>
  <?php elseif (!empty($error)): ?>
    <div class="alert error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></div>
  <?php endif; ?>

  <div class="contact-container">
    <!-- Contact Info -->
    <div class="contact-info">
      <div class="info-box">
        <i class="fa-solid fa-location-dot"></i>
        <h3>Our Location</h3>
        <p>123 Green Street, Karachi, Pakistan</p>
      </div>

      <div class="info-box">
        <i class="fa-solid fa-phone"></i>
        <h3>Call Us</h3>
        <p>+92 300 1234567</p>
      </div>

      <div class="info-box">
        <i class="fa-solid fa-envelope"></i>
        <h3>Email</h3>
        <p>support@foodshare.org</p>
      </div>

      <div class="social-icons">
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form">
      <form action="" method="POST">
        <div class="input-group">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="name" placeholder="Your Name" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" placeholder="Your Email" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-message"></i>
          <textarea name="message" placeholder="Your Message" required></textarea>
        </div>

        <button type="submit" class="btn">Send Message</button>
      </form>
    </div>
  </div>

  <!-- Google Map -->
  <div class="map">
    <iframe 
      src="https://www.google.com/maps?q=karachi%20pakistan&t=&z=13&ie=UTF8&iwloc=&output=embed"
      width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
  </div>
</section>

<?php include 'include/footer.php'; ?>
</body>
</html>
