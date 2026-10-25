<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
include __DIR__ . '/../config/database.php'; 
include __DIR__ . '/../header.php';

$total = $conn->query("SELECT COUNT(*) as c FROM parcels")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM parcels WHERE status='Pending'")->fetch_assoc()['c'];
?>
<div style="flex:1; padding:30px; background-color:#ffe4ec; min-height:85vh;">
  <h1 style="color:#101826; display:flex; align-items:center; gap:12px;"><img src="https://img.icons8.com/fluency/48/security-guard.png"/> Guard Control</h1>
  <p style="color:#666;">You handle all incoming parcels</p>

  <div style="display:flex; gap:20px; margin-top:20px; flex-wrap:wrap;">
    <div style="background:white; padding:20px; border-radius:15px; flex:1; display:flex; justify-content:space-between; align-items:center; border-left:6px solid #ff9800; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <div><small style="color:#888;">PENDING</small><h1 style="margin:5px 0;"><?php echo $pending; ?></h1><small style="color:#e65100;">To be delivered</small></div>
      <img src="https://img.icons8.com/fluency/48/hourglass.png" style="width:55px;">
    </div>
    <div style="background:white; padding:20px; border-radius:15px; flex:1; display:flex; justify-content:space-between; align-items:center; border-left:6px solid #101826; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <div><small style="color:#888;">TOTAL</small><h1 style="margin:5px 0;"><?php echo $total; ?></h1><small style="color:#666;">All parcels</small></div>
      <img src="https://img.icons8.com/fluency/48/box.png" style="width:55px;">
    </div>
  </div>

  <div style="display:flex; gap:20px; margin-top:25px; flex-wrap:wrap;">
    <div style="background:white; padding:20px; border-radius:15px; flex:1; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <h3><img src="https://img.icons8.com/fluency/20/plus.png"/> Guard Actions</h3>
      <div style="margin-top:15px; display:flex; flex-direction:column; gap:12px;">
        <a href="../add_parcel.php" style="background:#101826; color:white; padding:14px; border-radius:12px; text-align:center; text-decoration:none; font-weight:600;">📦 + Add New Parcel</a>
        <a href="../view_parcels.php" style="background:#fff; color:#101826; padding:14px; border-radius:12px; text-align:center; text-decoration:none; border:2px solid #101826; font-weight:600;">👁️ View All Parcels</a>
      </div>
      <div style="margin-top:20px; background:#f8f8f8; padding:12px; border-radius:10px; font-size:12px;">
        <b>Flow:</b> 📥 Arrives → 📝 Entry → 🏠 Resident Notified → ✅ Delivered
      </div>
    </div>

    <div style="background:white; padding:20px; border-radius:15px; flex:1.6; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <h3>⏳ Pending Deliveries</h3>
      <?php 
      $q=$conn->query("SELECT * FROM parcels WHERE status='Pending' ORDER BY id DESC LIMIT 5");
      while($r=$q->fetch_assoc()){ ?>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #eee;">
          <div style="display:flex; align-items:center; gap:10px;">
            <img src="https://img.icons8.com/fluency/20/home.png"/>
            <div><b><?php echo $r['flat_no']; ?></b><br><small style="color:#666;"><?php echo $r['tracking_id']; ?> | <?php echo $r['courier_company']; ?></small></div>
          </div>
          <a href="../update_parcel.php?id=<?php echo $r['id']; ?>" style="background:#4caf50; color:white; padding:6px 14px; border-radius:20px; text-decoration:none; font-size:12px;">Deliver</a>
        </div>
      <?php } if($q->num_rows==0) echo "<p style='text-align:center; color:#888; padding:20px;'><img src='https://img.icons8.com/fluency/48/checked.png' style='width:30px; display:block; margin:0 auto;'><br>All clear!</p>"; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>