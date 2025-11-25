<?php
include 'db_connect.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered!');</script>";
    } else {
        $sql = "INSERT INTO users (name, email, password, phone, address, role)
                VALUES ('$name', '$email', '$password', '$phone', '$address', '$role')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - FoodShare</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/register.css">
</head>
<body>
<?php include 'include/header.php'; ?>

  <div class="register-container">
    <div class="form-box">
      <h2><i class="fa-solid fa-seedling"></i> Create Account</h2>

      <form method="POST" action="">
        <div class="input-group">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
          <i class="fa-solid fa-phone"></i>
          <input type="text" name="phone" placeholder="Phone (optional)">
        </div>

        <div class="input-group">
          <i class="fa-solid fa-location-dot"></i>
          <input type="text" name="address" placeholder="Address (optional)">
        </div>

        <div class="input-group">
          <i class="fa-solid fa-user-tag"></i>
          <select name="role" required>
            <option value="">Select Role</option>
            <option value="donor">Donor</option>
            <option value="receiver">Receiver</option>
          </select>
        </div>

        <button type="submit" name="register" class="btn">Register</button>
      </form>

      <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
  
<?php include 'include/footer.php'; ?>
</body>
</html>
