<?php include 'config/database.php';
$id = $_GET['id'];
$conn->query("UPDATE parcels SET status='Delivered' WHERE id=$id");
header("Location: view_parcels.php");
?>