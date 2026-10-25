<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'header.php';
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

$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM parcels"));
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM parcels WHERE status='Pending'"));
$delivered = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM parcels WHERE status='Delivered'"));
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:'Poppins', sans-serif;}
.dashboard-bg{background:#101826 !important; min-height:85vh; padding:30px 25px;}
.dash-title{color:white; margin:0; font-size:28px;}
.dash-subtitle{color:#8a95a5; font-size:14px; margin-top:5px;}
.cards{display:flex; gap:20px; margin-top:30px; flex-wrap:wrap;}
.card{
  background:white; flex:1; min-width:250px; padding:22px; border-radius:16px;
  box-shadow:0 10px 30px rgba(0,0,0,0.2); border-left:5px solid #2bae66;
}
.card.pending{border-left-color:#ffbf00;}
.card.delivered{border-left-color:#2bae66;}
.card h4{margin:0; font-size:14px; color:#555;}
.card h1{margin:10px 0 5px; font-size:32px; color:#101826;}
.card p{margin:0; font-size:12px; color:#888;}
.btn-row{display:flex; gap:15px; margin-top:30px;}
.btn-green{background:#2bae66; color:white; padding:12px 22px; border-radius:30px; text-decoration:none; font-weight:700; font-size:14px;}
.btn-white{background:white; color:#101826; padding:12px 22px; border-radius:30px; text-decoration:none; font-weight:700; font-size:14px; border:1px solid #ddd;}
.quick-box{background:white; max-width:1150px; margin-top:30px; padding:20px; border-radius:16px;}
</style>

<div class="dashboard-bg">
  <h1 class="dash-title">ParcelPulse Dashboard</h1>
  <p class="dash-subtitle">Welcome back! Here's your parcel overview today.</p>
  <img src="https://img.icons8.com/fluency/96/in-transit.png" style="width:90px; float:right; margin-top:-105px; margin-right:15px;">
  <div class="cards">
    <div class="card">
      <h4>📦 Total</h4> <img src="https://cdn-icons-png.flaticon.com/512/2830/2830305.png" style="width:40px; float:right;">
      <h1><?php echo $total; ?></h1>
      <p>All Parcels in system</p>
    </div>
    <div class="card pending">
      <h4>⏳ Pending</h4> <img src="https://cdn-icons-png.flaticon.com/512/2830/2830310.png" style="width:40px; float:right;">
      <h1><?php echo $pending; ?></h1>
      <p>In transit right now</p>
    </div>
    <div class="card delivered">
      <h4>✅ Delivered</h4> <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" style="width:40px; float:right;">
      <h1><?php echo $delivered; ?></h1>
      <p>Successfully delivered</p>
    </div>
  </div>

  <div class="btn-row">
    <a href="add_parcel.php" class="btn-green">+ Add New Parcel</a>
    <a href="view_parcels.php" class="btn-white">View All →</a>
  </div>

  <div class="quick-box">
    <h4 style="margin:0 0 15px;">📋 Quick Info</h4>
    <div style="display:flex; gap:15px; align-items:center;">
      <div style="font-size:35px;">🚚</div>
      <img src="https://img.freepik.com/free-vector/delivery-service-illustrated_23-2148505081.jpg" style="width:80px; border-radius:12px; margin-left:10px;">
      <div>
        <b>Fast & Secure Delivery</b><br>
        <span style="color:grey; font-size:12px;">Your parcel system is running smoothly.</span>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>