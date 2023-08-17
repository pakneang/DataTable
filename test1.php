<?php
$ip = '192.168.2.1';
exec("ping -n 1 $ip", $output, $retval);
echo $retval;
if ($retval == 1) {
    echo "<p style='color:red; padding: 10px; background: green;'>Offline</p>";
} else {
    echo "<p style='color:#fff; padding: 10px; background: green;'>Online</p>";
}
print_r($output[2] . '/n');
print_r($output[5]);

?>
<!-- <?php
        $ip = $row['ip_address'];
        exec("ping -n 1 $ip", $output, $retval);
        echo $retval;
        echo $output[0];
        if ($retval == 1) {
            echo "<p style='color:red; padding: 10px; background: green;'>Offline</p>";
        } else {
            echo "<p style='color:#fff; padding: 10px; background: green;'>Online</p>";
        }
        ?> -->