<?php
include 'config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head><title>Login - ParcelPulse</title></head>
<body>
<h2>Login</h2>
<form method="POST">
  <input type="email" name="email" placeholder="Email" required><br><br>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <button type="submit" name="login">Login</button>
</form>
<a href="register.php">New user? Register</a>
</body>
</html>

<?php
if(isset($_POST['login'])){
  $e = $_POST['email'];
  $p = $_POST['password'];
  $result = $conn->query("SELECT * FROM users WHERE email='$e'");
  if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    if(password_verify($p, $row['password'])){
      $_SESSION['user'] = $row['username'];
      echo "Login Success! Welcome ".$row['username'];
    } else {
      echo "Wrong Password!";
    }
  } else {
    echo "User not found!";
  }
}
?>