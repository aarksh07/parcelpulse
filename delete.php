<?php include 'config/database.php';
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM parcels WHERE id=$id");
header("Location: view_parcels.php");
?>