<?php
// --- AUTO DB FIX - Isse Count ka Error aur Database Error Khatam Hoga ---
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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body{
  background:#101826 !important;
  min-height:100vh;
  display:flex;
  flex-direction:column;
  margin:0;
  font-family:'Poppins', sans-serif;
}
.navbar-custom{background:#2bae66; padding:12px 25px; box-shadow:0 4px 15px rgba(0,0,0,0.08); display:flex; justify-content:space-between; align-items:center;}
.navbar-custom b{font-size:22px;}
.navbar-custom b span{color:#603f83;}
.nav-btn{cursor:pointer;}
/* Modal CSS */
.modal-bg{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999; justify-content:center; align-items:center;}
.modal-box{background:white; width:90%; max-width:600px; border-radius:15px; padding:25px; max-height:80vh; overflow-y:auto;}
</style>

<div class="navbar-custom">
  <div style="display:flex; align-items:center; gap:10px;">
    <img src="/parcelpulse/logo.png" style="height:55px;">
    <b>Parcel<span>Pulse</span></b>
  </div>
  <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
    <a href="/parcelpulse/index.php" style="text-decoration:none; background:#5a4ff3; color:white; padding:8px 16px; border-radius:10px;">Home</a>
    <!-- TRACK BUTTON - NAYA ADDED -->
    <a href="/parcelpulse/track.php" style="text-decoration:none; background:#ff9800; color:white; padding:8px 16px; border-radius:10px; font-weight:600; border:2px solid white;">📦 Track</a>
    <span onclick="openModal('settingsModal')" class="nav-btn" style="text-decoration:none; background:#5a4ff3; color:white; padding:8px 16px; border-radius:10px;">Settings</span>
    <span onclick="openModal('termsModal')" class="nav-btn" style="text-decoration:none; background:#5a4ff3; color:white; padding:8px 16px; border-radius:10px;">Terms</span>
    <span onclick="openModal('privacyModal')" class="nav-btn" style="text-decoration:none; background:#5a4ff3; color:white; padding:8px 16px; border-radius:10px;">Privacy</span>
    <span onclick="openModal('aboutModal')" class="nav-btn" style="text-decoration:none; background:#5a4ff3; color:white; padding:8px 16px; border-radius:10px;">About</span>
    <a href="/parcelpulse/logout.php" style="text-decoration:none; background:#ff3b3b; color:white; padding:8px 16px; border-radius:10px; margin-left:4px;">Logout</a>
  </div>
</div>

<!-- SETTINGS MODAL -->
<div id="settingsModal" class="modal-bg" onclick="closeModal('settingsModal')">
  <div class="modal-box" onclick="event.stopPropagation()">
    <h2 style="margin-top:0;">⚙️ Settings</h2>
    <p><b>ParcelPulse Settings</b></p>
    <hr>
    <p>🔔 <b>Notifications:</b> Enable/Disable parcel updates</p>
    <p>🌙 <b>Theme:</b> Current - Dark Mode (#101826)</p>
    <p>📦 <b>Default Parcel Status:</b> Pending</p>
    <p>👤 <b>Account:</b> Manage your profile and password</p>
    <br>
    <button onclick="closeModal('settingsModal')" style="background:#5a4ff3; color:white; border:none; padding:8px 15px; border-radius:8px; cursor:pointer;">Close</button>
  </div>
</div>

<!-- TERMS MODAL -->
<div id="termsModal" class="modal-bg" onclick="closeModal('termsModal')">
  <div class="modal-box" onclick="event.stopPropagation()">
    <h2 style="margin-top:0;">📄 Terms & Conditions - ParcelPulse</h2>
    <hr>
    <p><b>1. Introduction:</b> Welcome to ParcelPulse parcel management system.</p>
    <p><b>2. User Responsibility:</b> User must provide correct parcel information (tracking ID, receiver details).</p>
    <p><b>3. Service:</b> This system is for tracking and managing parcels only. We are not responsible for actual delivery delays.</p>
    <p><b>4. Data Security:</b> Your parcel data is secure in our system.</p>
    <p><b>5. Misuse:</b> Any fake parcel entry will lead to account suspension.</p>
    <br>
    <button onclick="closeModal('termsModal')" style="background:#5a4ff3; color:white; border:none; padding:8px 15px; border-radius:8px; cursor:pointer;">I Agree</button>
  </div>
</div>

<!-- PRIVACY MODAL -->
<div id="privacyModal" class="modal-bg" onclick="closeModal('privacyModal')">
  <div class="modal-box" onclick="event.stopPropagation()">
    <h2 style="margin-top:0;">🔒 Privacy Policy</h2>
    <hr>
    <p>At <b>ParcelPulse</b>, we value your privacy.</p>
    <p>✔️ We only collect parcel details and login info.</p>
    <p>✔️ We do not share your data with third parties.</p>
    <p>✔️ All passwords are encrypted.</p>
    <p>✔️ Your tracking data is visible only to you.</p>
    <br>
    <button onclick="closeModal('privacyModal')" style="background:#5a4ff3; color:white; border:none; padding:8px 15px; border-radius:8px; cursor:pointer;">Close</button>
  </div>
</div>

<!-- ABOUT MODAL -->
<div id="aboutModal" class="modal-bg" onclick="closeModal('aboutModal')">
  <div class="modal-box" onclick="event.stopPropagation()">
    <h2 style="margin-top:0;">💡 About ParcelPulse</h2>
    <hr>
    <p><b>ParcelPulse</b> is a smart parcel tracking & management system.</p>
    <p>🚀 <b>Version:</b> 1.0</p>
    <p>👨‍💻 <b>Developed for:</b> Easy parcel management for small businesses & individuals.</p>
    <p>✨ <b>Features:</b> Add Parcel, Track Status, View History, Secure Login.</p>
    <p>Contact: support@parcelpulse.com</p>
    <br>
    <button onclick="closeModal('aboutModal')" style="background:#5a4ff3; color:white; border:none; padding:8px 15px; border-radius:8px; cursor:pointer;">Close</button>
  </div>
</div>

<script>
function openModal(id){ document.getElementById(id).style.display='flex'; }
function closeModal(id){ document.getElementById(id).style.display='none'; }
</script>