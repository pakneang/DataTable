<html>
    <head>
        <meta http-equiv="refresh" content="5">
    </head> 
<body> 
<?php

$websites = array("10.3.1.181","202.62.43.65","salesforce.com","facebook.com", "10.0.1.24");
$good = "1 received";
$successValue;

echo "<h1>Site Status  ".date("h:i:s")."</h1>";

foreach ($websites as $url){
    unset($result);
    $successValue = "DOWN";
    exec("ping -c 1 '$url'", $result);
    foreach($result as $line) {
        if (strpos($line,$good) == TRUE){
            $successValue = "UP";
        }
    }
    echo "<strong>Address: ".$url." </strong>";
        if ($successValue == "UP") {
            echo " Site is ".$successValue;

        } else {
            echo "Site is ".$successValue;
    }
   
    echo "<br><br>";
}

?>

</body>
</html>