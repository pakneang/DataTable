<?php
include('config.php');
$id = $_GET['station_id'];                                     
$status = $_GET['status_sendingtelegram'];
$sql1 = "UPDATE station_host SET status_sendingtelegram = $status WHERE station_id = $id";
mysqli_query($conn, $sql1);
header('location: pagevent.php');
?>