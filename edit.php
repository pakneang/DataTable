<?php
include("config.php");

if(isset($_POST['edit1'])){
    $id = $_POST['id'];
    $station_id = $_POST['station_id'];
    $station_name = $_POST['station_name'];
    $ip_address = $_POST['ip_address'];
    $g_telegram = $_POST['g_telegram'];

    $edit ="UPDATE station_host SET 
    station_id = '$station_id',
    station_name = '$station_name',
    ip_address = '$ip_address', 
    g_telegram = '$g_telegram' 
    WHERE id = '".$id."' ";
    $query_run = mysqli_query($conn, $edit);
    if($query_run == true){
        header("location:pr1.php");
        exit();
    }else{
        header("location:pr1.php");
        exit();
    }

}

?>