<?php
include('config.php');
// Assuming you have a valid database connection
if (isset($_POST['enable_all'])) {
    $status = 1;
} elseif (isset($_POST['disable_all'])) {
    $status = 0;
} else {
    echo "No action selected.";
    exit;
}

$sql = "UPDATE station_host SET status_sendingtelegram = $status";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "All rows updated successfully.";
} else {
    echo "Error updating rows: " . mysqli_error($conn);
}
header('location:pagevent.php');
?>