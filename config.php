<?php
    
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $db = "d_ptt";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
      die("Can't Connect to db");
    }
    session_start();
?>33