<?php
while ($row = mysqli_fetch_assoc($result)) {

    $stationid_dataanylyst = $row['station_id'];
    $stationname_dataanylyst = $row['station_name'];
    $ipaddress_dataanylyst = $row['ip_address'];
    $check = $row['check_tb'];
    $day_dataanalyst = date('y-m-d H:i:s');
    echo $day_dataanalyst . '<br>';

    $ip = $row['ip_address'];
    $ping = exec("ping -n 1 $ip", $output, $status);
    // $Newarray = ['station_host'];
    // $CountArrayOffline = count($Newarray);

    if ($status == 0) {
        // $Strarray = explode("/", $Newarray[0]);
        $status_dataanalyst = "Online";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylyst', '$stationname_dataanylyst', '$ipaddress_dataanylyst', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Online' , check_tb = 0 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);


        $message = "ជំរាបសួរបង," . "\n" . "\n". "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ"  . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
    } else {
        // $lastChecked = strtotime($row['[day_dataanalyst']);
        $currentTime = time();

        $status_dataanalyst = "Offline";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylyst', '$stationname_dataanylyst', '$ipaddress_dataanylyst', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = 1 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);

        
        $timeDifference = ($currentTime) / 60;

        if($timeDifference >=30){
        $message = "IP " . $ipaddress_dataanylyst . " down";
        }
    }
    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($telegramApi);
}
?>

<?php
require_once('config.php');
date_default_timezone_set("Asia/Bangkok"); // set time zone for report
$botToken = "6319398116:AAH9KIjn7xvfVFq0R96lkIoCVj6to8vg5ug"; // Telegram Bot Token
$chatId = '-954684369';
$sql = "SELECT * FROM station_host WHERE id";
$result = mysqli_query($conn, $sql);

$ip = ['ip_address'];
// $arrayLength = count($ip); // count array in file StationIPlist, 
// $i = 0; // $arr[$i] = ip:staiotnname

while ($row = mysqli_fetch_assoc($result)) {
    // add new array to $arr to saperate ip and station name
    // $dataStatioin array = $ip[0]=IP, $ip[1]=Station name, $ip[2]=Group Char ID
    $ip = explode(":", $ip[$i]);
    // Ping Monitor results will be 0 and 1, 0=online 1=offline
    $stationid_dataanylyst = $row['station_id'];
    $stationname_dataanylyst = $row['station_name'];
    $ipaddress_dataanylyst = $row['ip_address'];
    $check = $row['check_tb'];
    $day_dataanalyst = date('y-m-d H:i:s');
    echo $day_dataanalyst . '<br>';

    $ipa = $ip[0];
    $ping = exec("ping -n 1 $ip", $output, $status);
    // $results = $status;
    // create for staion that don't have text fiel and open file statioin name for updating
    // $StaitonNameLog = $ip[1];
    // Create for Report after online back
    // condition if when online or offline
    if ($results == 0) {
        $status_dataanalyst = "Online";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylyst', '$stationname_dataanylyst', '$ipaddress_dataanylyst', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Online' , check_tb = 0 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);
        // check data in station name text file, if have data it mean internet is recovery
        $DataOnlineCheck = $ipa;
        // if $DataOfflineCheck is not null, it mean internet is back to online
        if ($DataOnlineCheck != "") {
            // send online recovery to group telegram
            $check = $row['check_tb'] + 1;
            $Newarray = $check1;
            $CountArrayOffline = count($Newarray);
            if ($CountArrayOffline >= 3) {
                $Strarray = explode("/", $Newarray[0]);
                $TextSendRecoverOnline = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . $Strarray[1] . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
                $a = file_get_contents("https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $ip[2] . "&text=" . urlencode($TextSendRecoverOnline));
                // wirte data to Report text file
                $OnlineTimeData = "Online" . "/" . $ip[1] . "/" . date("d-m-y h:i:sa") . "\n";
                $OfflineTimeData = "Offline" . "/" . $ip[1] . "/" . $Strarray[1] . "\n";
                fwrite($HandleReport, $OnlineTimeData);
                fwrite($HandleReport, $OfflineTimeData);
                // Clear Offline Recorde in Station name text file.
                file_put_contents($StaitonNameLog, ""); // clear all content in text file on station name file
            }
        }
    } else {
        // Write Data offline to station name text file
        $DataWrite = "Offline" . "/" . date("d-m-y h:i:sa") . "\n";
        // check Offline array for send inform
        $DataOfflineCheck = $check;
        $CountArray = count($DataOfflineCheck);
        $status_dataanalyst = "Offline";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylyst', '$stationname_dataanylyst', '$ipaddress_dataanylyst', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = 1 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);

        $message = "ជំរាបសួរបង," . "\n" . "\n". "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ"  . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";

        // send offline to group telegram
        if ($CountArray == 3) {
            $TextSendOffline30min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយះពេលជាង កន្លះម៉ោងហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $a = file_get_contents("https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $ip[2] . "&text=" . urlencode($TextSendOffline30min));
        }
        if ($CountArray == 12) {
            $TextSendOffline120min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយះពេលជាង 2 ម៉ោងហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $a = file_get_contents("https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $ip[2] . "&text=" . urlencode($TextSendOffline120min));
        }
        if ($CountArray == 24) {
            $TextSendOffline120min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយះពេលជាង 4 ម៉ោងហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $a = file_get_contents("https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $ip[2] . "&text=" . urlencode($TextSendOffline120min));
        }
    }
    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($telegramApi);
    echo header("refresh: 600");
    $i++;
}
echo "Ping Monitor is running";

?>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#autorefresh1").load(window.location.href + " #autorefresh1");
        }, 1000);
        return (0);
    });


    <?php

    // send message when IP off
    if($check){

    }
     else {
        // $lastChecked = strtotime($row['[day_dataanalyst']);
        // $currentTime = time();



        $i = $check + 1;
        $status_dataanalyst = "Offline";
        $date_off = $row['date_off'];
        // $DataWrite = "date_off" . "/" . date("d-m-y h:i:sa") . "\n";
        // check Offline array for send inform
        $DataOfflineCheck = $ipa;
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = '$i' WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);
        // if ($check == True) {

        //     echo $check + 1;
        // }


        // if($status_dataanalyst = "Offline"){

        $CountArray = $check;

        // send offline to group telegram
        if ($CountArray == 2) {
            $TextSendOffline30min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 30 min ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline30min);
            file_get_contents($telegramApi);
        } else {
            $CountArray == 0;
            $TextSendOffline30min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline30min);
            file_get_contents($telegramApi);
        }

        if ($CountArray == 11) {
            $TextSendOffline120min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline120min);
            file_get_contents($telegramApi);
        } else {
            $CountArray == 0;
            $TextSendOffline120min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline120min);
            file_get_contents($telegramApi);
        }
        if ($CountArray == 23) {
            $TextSendOffline240min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 4h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline240min);
            file_get_contents($telegramApi);
        } else {
            $CountArray = 0;
            $TextSendOffline240min = "ជំរាបសួរបង," . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline240min);
            file_get_contents($telegramApi);
        }
    }
    ?>
</script>
// if ($row = mysqli_fetch_array($query_run)) {
        //     $orderStatus = $row['check_tb'];

        //     $data = array(
        //         'check_tb'   => $orderStatus
        //     );
        //     echo json_encode($data);
        // }
        // for ($i = 1; $i < 5; $i++) {
        //     echo $i;
        //     echo "<br>";
        // }


        // $timeDifference = ($currentTime - $lastChecked) / 60;

        // if($timeDifference >=30){
        // $message = "IP " . $ipaddress_dataanylist . " down";
        // }


        <!-- up and down -->


        <html>
    <head>
        <meta http-equiv="refresh" content="5">
    </head> 
<body> 
<?php

$websites = array("10.0.1.1","googlecom","salesforce.com","facebook.com", "10.0.1.24");
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

<!-- ព្រហស្បត្តិ៍ ១៧ សីហា ២០២៣ -->
<?php
require_once('config.php');
date_default_timezone_set("Asia/Bangkok"); // set time zone for report
$botToken = "6319398116:AAH9KIjn7xvfVFq0R96lkIoCVj6to8vg5ug"; // Telegram Bot Token
$chatId = '-954684369';
$sql = "SELECT * FROM station_host WHERE id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {

    $stationid_dataanylist = $row['station_id'];
    $stationname_dataanylist = $row['station_name'];
    $ipaddress_dataanylist = $row['ip_address'];
    $check = $row['check_tb'];
    $day_dataanalyst = date('y-m-d H:i:sa');
    echo $day_dataanalyst . '<br>';

    $ip = $row['ip_address'];
    $ipa = $ip[0];
    $ping = exec("ping -n 1 $ip", $output, $status);
    $CountArray = $check;
    $date_off = $row['date_off'];
    $i = $check + 1;

    if ($status == 0) {

        $status_dataanalyst = "Online";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Online' , check_tb = 0 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);

        if ($CountArray == 0) {
            $TextSendRecoverOnline = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendRecoverOnline);
            file_get_contents($telegramApi);
        }
    } else {


        $status_dataanalyst = "Offline";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = '$i' WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);

        // send offline to group telegram
        if ($CountArray == 2 and $date_off) {
            $TextSendOffline30min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 30 min ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline30min);
            file_get_contents($telegramApi);
        }
        if ($CountArray == 11 and $date_off) {
            $TextSendOffline120min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline120min);
            file_get_contents($telegramApi);
        }
        if ($CountArray == 23 and $date_off) {
            $TextSendOffline240min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 4h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline240min);
            file_get_contents($telegramApi);
        }
    }
}
// $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline);
// file_get_contents($telegramApi);
?>









<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#autorefresh1").load(window.location.href + " #autorefresh1");
        }, 1000);
        return (0);
    });
</script>