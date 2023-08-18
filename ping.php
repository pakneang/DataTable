<?php
require_once('config.php');
date_default_timezone_set("Asia/Bangkok"); // set time zone for report
$botToken = "6319398116:AAH9KIjn7xvfVFq0R96lkIoCVj6to8vg5ug"; // Telegram Bot Token
// $chatId = '-954684369';
$sql = "SELECT * FROM station_host WHERE id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {

    $stationid_dataanylist = $row['station_id'];
    $stationname_dataanylist = $row['station_name'];
    $ipaddress_dataanylist = $row['ip_address'];
    $check = $row['check_tb'];
    $g_telegram = $row['g_telegram'];
    $day_dataanalyst = date("d-m-y h:i:sa");
    echo $day_dataanalyst . '<br>';
    $ip = $row['ip_address'];
    $ping = exec("ping -n 1 $ip", $output, $status);
    $date_off = $row['date_off'];
    $i = $check + 1;


    if ($status == 0) {
        //recovery when Ping back to online  
        if ($check >= 3) {
            $TextSendRecoverOnline = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងដំណើរការវិញហើយ" . "\n" . "\n" . "-ពេលវេលាមិនដំណើរការ : .$date_off. " . "\n" . "-ពេលវេលាដំណើរការវិញ : " . date("d-m-y h:i:sa") . "\n" . "\n" . "អរគុណបង";
            $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendRecoverOnline);
            file_get_contents($telegramApi);
            $status_dataanalyst = "Online";
            $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
            VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
            $insert_run = mysqli_query($conn, $insert);
            $edit = "UPDATE station_host SET status_onlineoffline = 'Online' , check_tb = 0, date_off = ''  WHERE ip_address = '" . $ip . "'";
            $query_run = mysqli_query($conn, $edit);
        }
    } else {
        if ($check == 0) {

            $status_dataanalyst = "Offline";
            $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
            VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
            $insert_run = mysqli_query($conn, $insert);
            $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = '$i', date_off = '$day_dataanalyst' WHERE ip_address = '" . $ip . "' ";
            $query_run = mysqli_query($conn, $edit);
        } else {
            $status_dataanalyst = "Offline";
            $insert = "INSERT INTO data_analyst (station_hostid, stationname_dataanalyst, ipaddress_dataanalyst, day_dataanalyst, status_dataanalyst)
            VALUES('$stationid_dataanylist', '$stationname_dataanylist', '$ipaddress_dataanylist', '$day_dataanalyst', '$status_dataanalyst')";
            $insert_run = mysqli_query($conn, $insert);
            $edit = "UPDATE station_host SET status_onlineoffline = 'Offline', check_tb = '$i' WHERE ip_address = '" . $ip . "' ";
            $query_run = mysqli_query($conn, $edit);
            $CountArray = $check;
            // send offline to group telegram when down if have beeen count.
            // if ($CountArray == 2) {
            //     $TextSendOffline30min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 30 min ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            //     $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline30min);
            //     file_get_contents($telegramApi);
            // }
            // if ($CountArray == 11) {
            //     $TextSendOffline120min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            //     $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline120min);
            //     file_get_contents($telegramApi);
            // }
            // if ($CountArray == 23) {
            //     $TextSendOffline240min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 4h ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
            //     $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($TextSendOffline240min);
            //     file_get_contents($telegramApi);
            // }

            switch ($CountArray)
             {
                case 2:
                    $TextSendOffline30min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 30 នាទី ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline30min);
                    file_get_contents($telegramApi);
                    break;
                case 11:
                    $TextSendOffline120min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2ម៉ោង ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline120min);
                    file_get_contents($telegramApi);
                    break;
                case 23:
                    $TextSendOffline240min = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 4ម៉ោង ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline240min);
                    file_get_contents($telegramApi);
                    break;
                case 47:
                    $TextSendOffline8h = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 8 ម៉ោង ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline8h);
                    file_get_contents($telegramApi);
                    break;
                case 71:
                    $TextSendOffline12h = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 12 ម៉ោង ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline12h);
                    file_get_contents($telegramApi);
                    break;
                case 143:
                    $TextSendOffline1day = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 24 ម៉ោង ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline1day);
                    file_get_contents($telegramApi);
                    break;
                case 287:
                    $TextSendOffline2day = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 2 ថ្ងៃ ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline2day);
                    file_get_contents($telegramApi);
                    break;
                case 575:
                    $TextSendOffline3day = "ជំរាបសួរបង," . $ip . "\n" . "\n" . "ខាងខ្ញុំបានឃើញថា Internet ខាងបងមិនដំណើរការអស់រយៈពេលជាង 3 ថ្ងៃ ហើយ" . "\n" . "\n" . "សុំបងជួយត្រួតពិនិត្យបន្តិចបង ";
                    $telegramApi = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$g_telegram&text=" . urlencode($TextSendOffline3day);
                    file_get_contents($telegramApi);
                    break;
            }
        }
    }
}

?>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#autorefresh1").load(window.location.href + " #autorefresh1");
        }, 1000);
        return (0);
    });
</script>