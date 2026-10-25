<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
include __DIR__ . '/../config/database.php'; 
include __DIR__ . '/../header.php';
?>
<div style="flex:1; padding:30px; background-color:#ffe4ec; min-height:85vh;">
  <h1 style="color:#101826; display:flex; align-items:center; gap:12px;">
    <img src="https://img.icons8.com/fluency/48/home.png"/> My Parcels
  </h1>
  <p style="color:#666;">Track your deliveries - Resident View</p>

  <div style="display:flex; gap:20px; margin-top:20px; flex-wrap:wrap;">
    <div style="background:white; padding:20px; border-radius:15px; flex:1; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-top:4px solid #101826;">
      <img src="https://img.icons8.com/fluency/40/box.png" style="width:35px;"/><h3 style="margin:8px 0 0;">Received</h3><small style="color:#888;">At security desk</small>
    </div>
    <div style="background:white; padding:20px; border-radius:15px; flex:1; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-top:4px solid #ff9800;">
      <img src="https://img.icons8.com/fluency/40/hourglass.png" style="width:35px;"/><h3 style="margin:8px 0 0;">Pending</h3><small style="color:#888;">Collect soon</small>
    </div>
    <div style="background:white; padding:20px; border-radius:15px; flex:1; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-top:4px solid #4caf50;">
      <img src="https://img.icons8.com/fluency/40/checked.png" style="width:35px;"/><h3 style="margin:8px 0 0;">Delivered</h3><small style="color:#888;">To you</small>
    </div>
  </div>

  <div style="background:white; padding:20px; border-radius:15px; margin-top:25px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
      <img src="https://img.icons8.com/fluency/24/search.png" style="width:24px;"/>
      <input type="text" id="search" placeholder="Apna Flat No likho (e.g. 417)..." style="flex:1; padding:12px 18px; border-radius:25px; border:1px solid #ddd; outline:none;">
      <a href="../track.php" style="background:#ff9800; color:white; padding:10px 18px; border-radius:20px; text-decoration:none; font-weight:700;">📦 Track by ID</a>
    </div>

    <div style="background:#f9f9f9; padding:12px; border-radius:10px; margin-bottom:15px; font-size:13px; display:flex; align-items:center; gap:8px;">
      <img src="https://img.icons8.com/fluency/20/flow-chart.png"/> <b>Flow:</b> Guard receives 📦 → Entry → Notification 🔔 → You collect ✅
    </div>

    <table style="width:100%; border-collapse:collapse; font-size:14px;">
      <tr style="background:#101826; color:white; text-align:center;">
        <th style="padding:12px; border-radius:10px 0 0 0;">Tracking ID</th>
        <th style="padding:12px;">Courier</th>
        <th style="padding:12px;">Flat</th>
        <th style="padding:12px;">Status</th>
        <th style="padding:12px; border-radius:0 10px 0 0;">Resident</th>
      </tr>
      <?php 
      $q=$conn->query("SELECT * FROM parcels ORDER BY id DESC");
      while($r=$q->fetch_assoc()){
        $color = $r['status']=='Delivered' ? '#4caf50' : '#ff9800';
        $icon = $r['status']=='Delivered' ? 'https://img.icons8.com/fluency/16/checked.png' : 'https://img.icons8.com/fluency/16/hourglass.png';
      ?>
      <tr style="border-bottom:1px solid #eee; text-align:center;">
        <td style="padding:12px;"><?php echo $r['tracking_id']; ?></td>
        <td style="padding:12px; display:flex; align-items:center; justify-content:center; gap:5px;"><img src="https://img.icons8.com/fluency/16/delivery.png"/> <?php echo $r['courier_company']; ?></td>
        <td style="padding:12px; font-weight:bold;"><img src="https://img.icons8.com/fluency/16/home.png"/> <?php echo $r['flat_no']; ?></td>
        <td style="padding:12px;"><span style="background:<?php echo $color; ?>20; color:<?php echo $color; ?>; padding:6px 12px; border-radius:20px; font-weight:600; display:inline-flex; align-items:center; gap:5px;"><img src="<?php echo $icon; ?>"/> <?php echo $r['status']; ?></span></td>
        <td style="padding:12px;"><?php echo $r['resident_name']; ?></td>
      </tr>
      <?php } ?>
    </table>
    <?php if($q->num_rows==0){ echo "<p style='text-align:center; color:#888; padding:20px;'><img src='https://img.icons8.com/fluency/48/empty-box.png' style='width:40px; display:block; margin:0 auto 10px;'>No parcels found</p>"; } ?>
  </div>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function(){
  let f=this.value.toLowerCase();
  document.querySelectorAll('table tr:not(:first-child)').forEach(r=>{
    r.style.display = r.innerText.toLowerCase().includes(f) ? '' : 'none';
  });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>