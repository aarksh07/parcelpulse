<?php include 'header.php'; 
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS parcelpulse");
mysqli_select_db($conn, "parcelpulse");

// Action: Delivered / Delete
if(isset($_GET['delivered'])){
  $id = $_GET['delivered'];
  mysqli_query($conn, "UPDATE parcels SET status='Delivered' WHERE id='$id'");
  echo "<script>window.location='view_parcels.php'</script>";
}
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM parcels WHERE id='$id'");
  echo "<script>window.location='view_parcels.php'</script>";
}

$result = mysqli_query($conn, "SELECT * FROM parcels ORDER BY id DESC");
$total = mysqli_num_rows($result);
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM parcels WHERE status='Pending'"));
$delivered = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM parcels WHERE status='Delivered'"));
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:'Poppins', sans-serif;}
.main-bg{background:#101826; min-height:85vh; padding:30px 20px;}
.top-header{
  max-width:1150px; margin:0 auto 25px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;
}
.top-header h2{color:white; margin:0; font-size:26px;}
.top-header h2 span{color:#2bae66;}
.stats{display:flex; gap:12px;}
.stat-box{background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.1); padding:10px 18px; border-radius:12px; color:white; font-size:13px; backdrop-filter:blur(10px);}
.stat-box b{font-size:18px; display:block;}
.stat-box.pending b{color:#ffbf00;}
.stat-box.delivered b{color:#2bae66;}

.table-card{
  max-width:1150px; margin:0 auto; background:white; border-radius:18px; overflow:hidden;
  box-shadow:0 15px 40px rgba(0,0,0,0.3); padding:0;
}
.table-header{
  padding:20px 25px; display:flex; justify-content:space-between; align-items:center;
  border-bottom:1px solid #eee;
}
.table-header h3{margin:0; color:#101826;}
.btn-add{
  background:#5a4ff3; color:white; text-decoration:none; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:600;
}
.btn-add:hover{background:#4438e0;}
table{width:100%; border-collapse:collapse;}
thead{background:#f8f9ff;}
th{padding:14px 15px; text-align:left; font-size:13px; color:#5a4ff3; text-transform:uppercase; letter-spacing:0.5px;}
td{padding:14px 15px; font-size:14px; color:#333; border-top:1px solid #f0f0f0;}
.badge{padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700;}
.badge-pending{background:#fff3cd; color:#856404; border:1px solid #ffe69c;}
.badge-delivered{background:#d4edda; color:#155724; border:1px solid #b1dfbb;}
.action-btn{padding:6px 12px; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600; margin-right:5px;}
.btn-delivered{background:#2bae66; color:white;}
.btn-delete{background:#ff3b3b; color:white;}
.action-btn:hover{opacity:0.8;}
tr:hover{background:#fafaff;}
.footer-custom{
  background:#ffffff; color:#101826; text-align:center; padding:18px; 
  font-size:13px; font-weight:600; border-top:4px solid #2bae66;
}
@media(max-width:768px){ table{display:block; overflow-x:auto;} .top-header{flex-direction:column; align-items:flex-start;} }
</style>

<div class="main-bg">
  <div class="top-header">
    <h2>📦 All <span>Parcels</span> Management</h2>
    <div class="stats">
      <div class="stat-box"><b><?php echo $total; ?></b> Total Parcels</div>
      <div class="stat-box pending"><b><?php echo $pending; ?></b> Pending</div>
      <div class="stat-box delivered"><b><?php echo $delivered; ?></b> Delivered</div>
    </div>
  </div>

  <div class="table-card">
    <div class="table-header">
      <h3>Parcel List</h3>
      <a href="add_parcel.php" class="btn-add">+ Add New Parcel</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Resident</th>
          <th>Flat</th>
          <th>Courier</th>
          <th>Tracking</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
          <td><b>#<?php echo $row['id']; ?></b></td>
          <td><?php echo $row['resident_name']; ?></td>
          <td>🏠 <?php echo $row['flat_no']; ?></td>
          <td><?php echo $row['courier_company']; ?></td>
          <td><span style="background:#eee; padding:3px 8px; border-radius:5px; font-family:monospace;"><?php echo $row['tracking_id']; ?></span></td>
          <td>
            <?php if($row['status']=='Pending'){ ?>
              <span class="badge badge-pending">● Pending</span>
            <?php } else { ?>
              <span class="badge badge-delivered">✔ Delivered</span>
            <?php } ?>
          </td>
          <td>
            <?php if($row['status']=='Pending'){ ?>
              <a href="?delivered=<?php echo $row['id']; ?>" class="action-btn btn-delivered">Delivered</a>
            <?php } ?>
            <a href="?delete=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete karna hai?')">Delete</a>
          </td>
        </tr>
        <?php } ?>
        <?php if($total==0){ echo "<tr><td colspan='7' style='text-align:center; padding:30px; color:grey;'>No Parcels Found 📭</td></tr>"; } ?>
      </tbody>
    </table>
  </div>
</div>

<div class="footer-custom">
  © 2026 <span style="color:#2bae66; font-weight:800;">Parcel</span><span style="color:#5a4ff3; font-weight:800;">Pulse</span> | Made with ❤️ for Secure Delivery | support@parcelpulse.com
</div>