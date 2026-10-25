<?php 
include __DIR__ . '/config/database.php'; 
include __DIR__ . '/header.php';
$parcel = null;
$track_id = '';
if(isset($_POST['tracking_id']) || isset($_GET['tid'])){
  $track_id = $_POST['tracking_id'] ?? $_GET['tid'];
  $stmt = $conn->prepare("SELECT * FROM parcels WHERE tracking_id = ?");
  $stmt->bind_param("s", $track_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $parcel = $res->fetch_assoc();
}
?>
<div style="flex:1; padding:30px; background-color:#ffe4ec; min-height:85vh;">
  <h1 style="color:#101826; display:flex; align-items:center; gap:12px;"><img src="https://img.icons8.com/fluency/48/track-order.png"/> Track Your Parcel</h1>
  
  <div style="background:white; padding:25px; border-radius:15px; margin-top:20px; box-shadow:0 4px 12px rgba(0,0,0,0.08); max-width:700px; margin-left:auto; margin-right:auto;">
    <form method="POST" style="display:flex; gap:10px;">
      <input type="text" name="tracking_id" value="<?php echo $track_id; ?>" placeholder="Enter Tracking ID (e.g. TRK12345)" required style="flex:1; padding:14px 18px; border-radius:25px; border:2px solid #101826; outline:none;">
      <button type="submit" style="background:#101826; color:white; padding:14px 25px; border-radius:25px; border:none; cursor:pointer; font-weight:600; display:flex; align-items:center; gap:8px;"><img src="https://img.icons8.com/fluency/20/search.png"/> Track</button>
    </form>

    <?php if($parcel){ ?>
      <div style="margin-top:30px; border-top:2px dashed #eee; padding-top:20px;">
        <div style="display:flex; justify-content:space-between; flex-wrap:wrap;">
          <div><b>Flat No:</b> <?php echo $parcel['flat_no']; ?> <br><b>Resident:</b> <?php echo $parcel['resident_name']; ?></div>
          <div style="text-align:right;"><b>Courier:</b> <?php echo $parcel['courier_company']; ?><br><b>ID:</b> <?php echo $parcel['tracking_id']; ?></div>
        </div>

        <!-- DIAGRAM / TIMELINE -->
        <div style="margin-top:30px; position:relative; display:flex; justify-content:space-between;">
          <!-- Step 1 -->
          <div style="text-align:center; flex:1;">
            <div style="width:50px; height:50px; background:#4caf50; border-radius:50%; margin:0 auto; display:flex; align-items:center; justify-content:center; color:white; font-size:22px;">✓</div>
            <p style="font-size:12px; margin-top:8px; font-weight:600;">Received at<br>Gate</p>
            <img src="https://img.icons8.com/fluency/24/security-guard.png" style="margin-top:5px;">
          </div>
          <div style="flex:1; height:4px; background:<?php echo in_array($parcel['status'], ['Pending','Delivered']) ? '#4caf50' : '#ddd'; ?>; margin-top:23px;"></div>
          <!-- Step 2 -->
          <div style="text-align:center; flex:1;">
            <div style="width:50px; height:50px; background:<?php echo in_array($parcel['status'], ['Pending','Delivered']) ? '#4caf50' : '#ddd'; ?>; border-radius:50%; margin:0 auto; display:flex; align-items:center; justify-content:center; color:white; font-size:22px;">✓</div>
            <p style="font-size:12px; margin-top:8px; font-weight:600;">Entry Done<br>by Guard</p>
            <img src="https://img.icons8.com/fluency/24/enter.png" style="margin-top:5px;">
          </div>
          <div style="flex:1; height:4px; background:<?php echo $parcel['status']=='Delivered' ? '#4caf50' : '#ddd'; ?>; margin-top:23px;"></div>
          <!-- Step 3 -->
          <div style="text-align:center; flex:1;">
            <div style="width:50px; height:50px; background:<?php echo $parcel['status']=='Delivered' ? '#4caf50' : '#ff9800'; ?>; border-radius:50%; margin:0 auto; display:flex; align-items:center; justify-content:center; color:white; font-size:18px;"><?php echo $parcel['status']=='Delivered' ? '✓' : '...'; ?></div>
            <p style="font-size:12px; margin-top:8px; font-weight:600;"><?php echo $parcel['status']=='Delivered' ? 'Delivered<br>to Resident' : 'Pending<br>Collection'; ?></p>
            <img src="https://img.icons8.com/fluency/24/home.png" style="margin-top:5px;">
          </div>
        </div>

        <div style="margin-top:25px; padding:15px; border-radius:12px; background:<?php echo $parcel['status']=='Delivered' ? '#e8f5e9' : '#fff3e0'; ?>; text-align:center; font-weight:600; color:<?php echo $parcel['status']=='Delivered' ? '#2e7d32' : '#e65100'; ?>;">
          Current Status: <?php echo $parcel['status']; ?> <?php echo $parcel['status']=='Delivered' ? '🎉' : '⏳'; ?>
        </div>
      </div>
    <?php } elseif($track_id!=''){ ?>
      <p style="text-align:center; color:#ff5252; margin-top:20px;"><img src="https://img.icons8.com/fluency/30/cancel.png"/> Tracking ID '<?php echo $track_id; ?>' not found!</p>
    <?php } ?>
  </div>

  <div style="text-align:center; margin-top:20px;">
    <a href="resident/dashboard.php" style="text-decoration:none; color:#101826;">← Back to My Parcels</a>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>