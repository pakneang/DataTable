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
    $date_off = $row['date_off'];
    $i = $check + 1;
    

    if ($status == 0) {
        $status_dataanalyst = "Online";
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Online' , check_tb = 0 WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);
        if () {
            $TextSendRecoverOnline = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendRecoverOnline);
            file_get_contents($telegramApi);
        }
    } else {
        $status_dataanalyst = "Offline";
        $date_off = $row['date_off'];
        $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
        VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
        $insert_run = mysqli_query($conn, $insert);
        $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = '$i' WHERE ip_address = '" . $ip . "'";
        $query_run = mysqli_query($conn, $edit);
        $CountArray = $check;
        // send offline to group telegram
        if ($CountArray == 2) {
            $TextSendOffline30min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 30 min ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline30min);
            file_get_contents($telegramApi);
        }
        if ($CountArray == 3 && $check == 0) {
            $TextSendRecoverOnline = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ :  " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendRecoverOnline);
            file_get_contents($telegramApi);
        } 
        
        if ($CountArray == 11) {
            $TextSendOffline120min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline120min);
            file_get_contents($telegramApi);
        }
        if ($CountArray == 23) {
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