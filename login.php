<?php
session_start();
include 'db_connect.php';

$message = ""; // store login error/success message

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: ./admins/dashboard_admin.php");
            } elseif ($row['role'] == 'donor') {
                header("Location: ./admins/dashboard_donor.php");
            } else {
                header("Location: ./admins/dashboard_receiver.php");
            }
            exit;
        } else {
            $message = "<div class='alert error'>Incorrect password! Please try again.</div>";
        }
    } else {
        $message = "<div class='alert warning'>Email not found! Please register first.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - FoodShare</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php include 'include/header.php'; ?>

  <div class="login-container">
    <div class="form-box">
      <h2><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
      <p>Welcome back! Please sign in to continue 💚</p>

      <!-- Show message here -->
      <?php if (!empty($message)) echo $message; ?>

      <form method="POST" action="">
        <div class="input-group">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="btn">Login</button>
      </form>

      <p class="register-link">Don’t have an account? <a href="register.php">Register here</a></p>
    </div>
  </div>

<?php include 'include/footer.php'; ?>
</body>
</html>
