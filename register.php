<?php
include 'config/database.php';
$error="";
if(isset($_POST['reg'])){
  $name=$_POST['name']; $email=$_POST['email']; 
  $pass=password_hash($_POST['password'], PASSWORD_DEFAULT); 
  $role=$_POST['role'];
  $check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
  if(mysqli_num_rows($check)>0){ $error="Gmail already registered!"; }
  else{
    mysqli_query($conn,"INSERT INTO users(username,email,password,role) VALUES('$name','$email','$pass','$role')");
    header("Location: login.php"); exit;
  }
}
?>
<!DOCTYPE html><html><head><title>Register</title><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>body{margin:0;background:#101826;font-family:'Poppins',sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}.card{background:#fff;width:90%;max-width:450px;border-radius:20px;padding:35px}input,select{width:100%;padding:12px 15px;border-radius:10px;border:1px solid #ddd;margin-bottom:15px;box-sizing:border-box}.btn{width:100%;background:#5a4ff3;color:#fff;border:none;padding:12px;border-radius:10px;font-weight:700;cursor:pointer}.error{background:#ffebeb;color:#ff3b3b;padding:10px;border-radius:8px;margin-bottom:15px}</style></head><body>
<div class="card"><h2>Create Account ✨</h2>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Your Gmail" required>
<select name="role" required><option value="resident">Resident</option><option value="guard">Guard</option><option value="admin">Admin</option></select>
<input type="password" name="password" placeholder="Create Password" required>
<button class="btn" name="reg">Register Now</button>
</form><p style="text-align:center;margin-top:15px;"><a href="login.php" style="color:#5a4ff3;text-decoration:none;font-weight:600;">Already have account? Login</a></p>
</div></body></html>