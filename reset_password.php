<?php
session_start(); include 'config/database.php';
if(!isset($_SESSION['reset_email'])) header("Location: forgot_password.php");
$error="";
if(isset($_POST['reset'])){
  $email=$_SESSION['reset_email']; $otp=$_POST['otp']; $newpass=password_hash($_POST['newpass'], PASSWORD_DEFAULT);
  $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND reset_otp='$otp' AND otp_expiry > NOW()");
  if(mysqli_num_rows($res)==1){
    mysqli_query($conn,"UPDATE users SET password='$newpass', reset_otp=NULL WHERE email='$email'");
    session_destroy(); header("Location: login.php"); exit;
  } else { $error="Invalid or Expired OTP!"; }
}
?>
<!DOCTYPE html><html><head><title>Reset Password</title><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>body{margin:0;background:#101826;font-family:'Poppins',sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}.card{background:#fff;width:90%;max-width:420px;border-radius:20px;padding:35px}input{width:100%;padding:12px 15px;border-radius:10px;border:1px solid #ddd;margin-bottom:15px;box-sizing:border-box}.btn{width:100%;background:#2bae66;color:#fff;border:none;padding:12px;border-radius:10px;font-weight:700;cursor:pointer}.error{background:#ffebeb;color:#ff3b3b;padding:10px;border-radius:8px;margin-bottom:15px}</style></head><body>
<div class="card"><h2>Reset Password 🔒</h2>
<p style="color:gray;font-size:13px;">OTP sent to: <b><?php echo $_SESSION['reset_email']; ?></b><br>Testing OTP: <b style="color:#2bae66;font-size:18px;"><?php echo $_SESSION['show_otp']; ?></b></p>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="POST">
<input type="text" name="otp" placeholder="Enter 6-digit OTP" required>
<input type="password" name="newpass" placeholder="New Password" required>
<button class="btn" name="reset">Change Password</button>
</form></div></body></html>