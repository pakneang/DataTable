<?php
include("config.php");
 if(isset($_GET['id'])){
    $id = $_GET['id'];
    $delete ="DELETE FROM station_host WHERE id ='".$id."'";
    $query_run = mysqli_query($conn,$delete);
    if($query_run){
        header("location:pagehost.php");
        exit();
    }else{
        header("location:pagehost.php");
        exit();
    }
 }


?>