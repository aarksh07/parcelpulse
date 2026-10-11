<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html>
<head><title>Register - ParcelPulse</title></head>
<body>
<h2>Register</h2>
<form method="POST">
  <input type="text" name="username" placeholder="Username" required><br><br>
  <input type="email" name="email" placeholder="Email" required><br><br>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <button type="submit" name="register">Register</button>
</form>
<a href="login.php">Already have account? Login</a>
</body>
</html>

<?php
if(isset($_POST['register'])){
  $u = $_POST['username'];
  $e = $_POST['email'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $conn->query("INSERT INTO users (username, email, password) VALUES ('$u','$e','$p')");
  echo "Registered! <a href='login.php'>Login now</a>";
}
?>