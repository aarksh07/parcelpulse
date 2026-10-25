<?php
session_start();
include 'config/database.php';
$error="";
if(isset($_POST['login'])){
  $email = $_POST['email']; 
  $pass = $_POST['password'];
  $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if(mysqli_num_rows($res)==1){
    $row = mysqli_fetch_assoc($res);
    if(password_verify($pass, $row['password']) || $pass==$row['password']){
      $_SESSION['user_id']=$row['id']; 
      $_SESSION['role']=$row['role'];
      if($row['role']=='resident') header("Location: resident/dashboard.php");
      else if($row['role']=='guard') header("Location: guard/dashboard.php");
      else header("Location: admin/dashboard.php");
      exit;
    } else { $error="Wrong Password!"; }
  } else { $error="Email not found!"; }
}
?>
<!DOCTYPE html><html><head><title>Login - ParcelPulse</title><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>body{margin:0;background:#101826;font-family:'Poppins',sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}.card{background:#fff;width:90%;max-width:420px;border-radius:20px;padding:35px;box-shadow:0 15px 40px rgba(0,0,0,.3)}input{width:100%;padding:12px 15px;border-radius:10px;border:1px solid #ddd;margin-bottom:15px;box-sizing:border-box}.btn{width:100%;background:#2bae66;color:#fff;border:none;padding:12px;border-radius:10px;font-weight:700;cursor:pointer;font-size:16px}.error{background:#ffebeb;color:#ff3b3b;padding:10px;border-radius:8px;margin-bottom:15px;font-size:13px}</style></head><body>
<div class="card"><h2>Welcome Back 👋</h2><p style="color:gray;font-size:14px;margin-bottom:25px;">Login to ParcelPulse</p>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="POST">
<input type="email" name="email" placeholder="Your Gmail" required>
<input type="password" name="password" placeholder="Password" required>
<button class="btn" name="login">Login</button>
</form><div style="display:flex;justify-content:space-between;margin-top:18px;"><a href="forgot_password.php" style="color:#5a4ff3;text-decoration:none;font-weight:600;font-size:14px;">Forgot Password?</a><a href="register.php" style="color:#5a4ff3;text-decoration:none;font-weight:600;font-size:14px;">Register</a></div>
</div></body></html>