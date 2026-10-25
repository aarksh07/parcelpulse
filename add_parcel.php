<?php include 'header.php'; 
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS parcelpulse");
mysqli_select_db($conn, "parcelpulse");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS parcels (
  id INT AUTO_INCREMENT PRIMARY KEY,
  resident_name VARCHAR(100),
  flat_no VARCHAR(50),
  courier_company VARCHAR(100),
  tracking_id VARCHAR(100),
  status VARCHAR(50)
)");
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:'Poppins', sans-serif;}
.main-wrapper{
  background: #101826 !important;
  min-height: 85vh;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:40px 20px;
}
.form-card{
  background:white;
  width:100%;
  max-width:1050px;
  border-radius:20px;
  display:flex;
  overflow:hidden;
  box-shadow:0 15px 40px rgba(0,0,0,0.3);
}
.left-side{
  background: linear-gradient(135deg, #2bae66 0%, #5a4ff3 100%);
  width:42%;
  padding:40px 30px;
  color:white;
  display:flex;
  flex-direction:column;
  justify-content:center;
}
.left-side h1{font-size:28px; margin:0; line-height:1.3;}
.left-side p{opacity:0.9; margin-top:15px; font-size:14px;}
.feature-box{margin-top:25px;}
.feature-box div{background:rgba(255,255,255,0.15); padding:10px 15px; border-radius:10px; margin-bottom:10px;}
.right-side{width:58%; padding:35px;}
.input-group{position:relative; margin-bottom:18px;}
.input-group input{
  width:100%; padding:13px 15px 13px 45px; border-radius:10px; 
  border:1.5px solid #e0e0e0; outline:none; transition:0.3s; font-size:14px;
}
.input-group input:focus{border-color:#5a4ff3;}
.input-group span{position:absolute; left:15px; top:13px; font-size:18px;}
.submit-btn{
  width:100%; background:#2bae66; color:white; border:none; padding:14px;
  border-radius:10px; font-weight:700; font-size:16px; cursor:pointer; margin-top:10px;
}
.submit-btn:hover{background:#239654;}
.footer-custom{
  background:#ffffff; 
  color:#101826; 
  text-align:center; 
  padding:18px; 
  font-size:13px;
  font-weight:600;
  border-top:4px solid #2bae66;
  box-shadow:0 -5px 15px rgba(0,0,0,0.1);
}
@media(max-width:768px){ .form-card{flex-direction:column;} .left-side,.right-side{width:100%;} }
</style>

<div class="main-wrapper">
  <div class="form-card">
    <div class="left-side">
      <div style="font-size:60px; margin-bottom:10px;">📦</div>
      <h1>Add New Parcel in <br><span style="color:#101826; background:white; padding:2px 10px; border-radius:8px;">ParcelPulse</span></h1>
      <p>Enter resident & courier details to track your parcel smartly.</p>
      <div class="feature-box">
        <div>🚀 Instant Tracking System</div>
        <div>🔒 100% Secure & Fast Data</div>
        <div>🏠 Flat-wise Parcel Management</div>
      </div>
      <div style="margin-top:30px; font-size:12px; opacity:0.7;">Trusted by 500+ Societies</div>
    </div>
    <div class="right-side">
      <h2 style="margin:0; color:#101826;">Add New Parcel</h2>
      <p style="color:grey; font-size:13px; margin:5px 0 25px;">Fill all details correctly</p>
      <form method="POST">
        <div class="input-group"><span>👤</span><input type="text" name="resident_name" placeholder="Resident Name" required></div>
        <div class="input-group"><span>🏠</span><input type="text" name="flat_no" placeholder="Flat No / House No" required></div>
        <div class="input-group"><span>🚚</span><input type="text" name="courier_company" placeholder="Courier Company" required></div>
        <div class="input-group"><span>🔍</span><input type="text" name="tracking_id" placeholder="Tracking ID" required></div>
        <button type="submit" name="add_parcel" class="submit-btn">Add Parcel →</button>
      </form>
    </div>
  </div>
</div>

<div class="footer-custom">
  © 2026 <span style="color:#2bae66; font-weight:800;">Parcel</span><span style="color:#5a4ff3; font-weight:800;">Pulse</span> | Made with ❤️ for Secure Delivery | support@parcelpulse.com
</div>

<?php
if(isset($_POST['add_parcel'])){
  $rname = $_POST['resident_name'];
  $flat = $_POST['flat_no'];
  $company = $_POST['courier_company'];
  $tid = $_POST['tracking_id'];
  $sql = "INSERT INTO parcels (resident_name, flat_no, courier_company, tracking_id, status) VALUES ('$rname', '$flat', '$company', '$tid', 'Pending')";
  if(mysqli_query($conn, $sql)){
    echo "<script>alert('Parcel Added Successfully! 📦'); window.location='index.php';</script>";
  }
}
?>