<?php 
include __DIR__ . '/../config/database.php'; 
include __DIR__ . '/../header.php';

$total = $conn->query("SELECT COUNT(*) as c FROM parcels")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM parcels WHERE status='Pending'")->fetch_assoc()['c'];
$delivered = $conn->query("SELECT COUNT(*) as c FROM parcels WHERE status='Delivered'")->fetch_assoc()['c'];
?>
<div style="flex:1; padding:30px; background-color:#ffe4ec; min-height:85vh;">
  <h1 style="color:#101826; font-weight:700;">Admin Control</h1>
  <p style="color:#555;">Welcome Admin - Full system access</p>

  <div style="display:flex; gap:20px; margin-top:25px; flex-wrap:wrap;">
    <!-- Card 1 -->
    <div style="background:white; padding:20px; border-radius:15px; flex:1; display:flex; justify-content:space-between; align-items:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-left:5px solid #101826;">
      <div><h3 style="margin:0; color:#555;">Total Parcels</h3><h1 style="margin:5px 0;"><?php echo $total; ?></h1><small style="color:#888;">All time</small></div>
      <img src="https://img.icons8.com/fluency/48/box.png" style="width:50px; height:50px;">
    </div>
    <!-- Card 2 -->
    <div style="background:white; padding:20px; border-radius:15px; flex:1; display:flex; justify-content:space-between; align-items:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-left:5px solid #ff9800;">
      <div><h3 style="margin:0; color:#555;">Pending</h3><h1 style="margin:5px 0;"><?php echo $pending; ?></h1><small style="color:#888;">To deliver</small></div>
      <img src="https://img.icons8.com/fluency/48/hourglass.png" style="width:50px; height:50px;">
    </div>
    <!-- Card 3 -->
    <div style="background:white; padding:20px; border-radius:15px; flex:1; display:flex; justify-content:space-between; align-items:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-left:5px solid #4caf50;">
      <div><h3 style="margin:0; color:#555;">Delivered</h3><h1 style="margin:5px 0;"><?php echo $delivered; ?></h1><small style="color:#888;">Completed</small></div>
      <img src="https://img.icons8.com/fluency/48/checked.png" style="width:50px; height:50px;">
    </div>
  </div>

  <div style="display:flex; gap:20px; margin-top:25px; flex-wrap:wrap;">
    <div style="background:white; padding:20px; border-radius:15px; flex:1; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <div style="display:flex; align-items:center; gap:10px;">
        <img src="https://img.icons8.com/fluency/32/settings.png" style="width:28px;"><h3 style="margin:0;">Admin Actions</h3>
      </div>
      <div style="display:flex; flex-direction:column; gap:10px; margin-top:15px;">
        <a href="../view_parcels.php" style="background:#101826; color:white; padding:12px; border-radius:10px; text-decoration:none; text-align:center; display:flex; justify-content:center; align-items:center; gap:8px;"><img src="https://img.icons8.com/ios-glyphs/20/ffffff/visible.png"/> View All Parcels</a>
        <a href="../guard/dashboard.php" style="background:white; color:#101826; padding:12px; border-radius:10px; border:2px solid #101826; text-decoration:none; text-align:center; display:flex; justify-content:center; align-items:center; gap:8px;"><img src="https://img.icons8.com/ios-glyphs/20/000000/security-guard.png"/> Guard Panel</a>
<a href="../resident/dashboard.php" style="background:#101826; color:white; padding:12px; border-radius:10px; text-decoration:none; text-align:center; display:flex; justify-content:center; align-items:center; gap:8px;"><img src="https://img.icons8.com/ios-glyphs/20/ffffff/home.png"/> Resident Panel</a>
      </div>
    </div>
    
    <div style="background:white; padding:20px; border-radius:15px; flex:1.5; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
      <div style="display:flex; align-items:center; gap:10px;">
        <img src="https://img.icons8.com/fluency/32/clipboard-list.png" style="width:28px;"><h3 style="margin:0;">Recent Activity</h3>
      </div>
      <div style="margin-top:15px;">
      <?php 
      // FIX: created_at hata diya, ab id se order kiya
      $q=$conn->query("SELECT * FROM parcels ORDER BY id DESC LIMIT 4"); 
      while($r=$q->fetch_assoc()){ ?>
        <div style="padding:10px 0; border-bottom:1px solid #f0f0f0; font-size:14px; display:flex; justify-content:space-between;">
          <span><img src="https://img.icons8.com/fluency/16/home.png"/> <b><?php echo $r['flat_no']; ?></b> - <?php echo $r['tracking_id']; ?></span>
          <span style="background:<?php echo $r['status']=='Delivered'?'#4caf5020':'#ff980020'; ?>; color:<?php echo $r['status']=='Delivered'?'#2e7d32':'#e65100'; ?>; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600;"><?php echo $r['status']; ?></span>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>