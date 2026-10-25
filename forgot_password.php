<?php
session_start(); include 'config/database.php';
$error="";
if(isset($_POST['send_otp'])){
  $email=$_POST['email'];
  $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
  if(mysqli_num_rows($res)==1){
    $otp = rand(100000,999999);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));
    mysqli_query($conn,"UPDATE users SET reset_otp='$otp', otp_expiry='$expiry' WHERE email='$email'");
    $_SESSION['reset_email']=$email;
    $_SESSION['show_otp']=$otp;
    header("Location: reset_password.php"); exit;
  } else { $error="This Gmail is not registered!"; }
}
?>
<!DOCTYPE html><html><head><title>Forgot Password</title><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>body{margin:0;background:#101826;font-family:'Poppins',sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}.card{background:#fff;width:90%;max-width:420px;border-radius:20px;padding:35px}input{width:100%;padding:12px 15px;border-radius:10px;border:1px solid #ddd;margin-bottom:15px;box-sizing:border-box}.btn{width:100%;background:#ff9800;color:#fff;border:none;padding:12px;border-radius:10px;font-weight:700;cursor:pointer}.error{background:#ffebeb;color:#ff3b3b;padding:10px;border-radius:8px;margin-bottom:15px}</style></head><body>
<div class="card"><h2>Forgot Password? 🔑</h2><p style="color:gray;font-size:14px;">Enter your Gmail to get OTP</p>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="POST">
<input type="email" name="email" placeholder="Enter your Gmail" required>
<button class="btn" name="send_otp">Send OTP to Gmail</button>
</form><p style="text-align:center;margin-top:15px;"><a href="login.php">Back to Login</a></p>
</div></body></html>