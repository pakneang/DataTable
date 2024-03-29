<?php
require_once('config.php');
//start button search
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $search_query = preg_replace("#[^0-9a-z]#i", "", $search_query);
}

$sql = "SELECT * FROM station_host";
if (!empty($search_query)) {
    $sql .= " WHERE station_name LIKE '%$search_query%'";
    $sql .= " OR station_id LIKE '%$search_query%'";
}
$result = mysqli_query($conn, $sql);
//End button search
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Data Table </title>
    <meta content="" name="description">
    <meta content="Author" name="MJ Maraz">
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- ========================================================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<!-- =============== Design & Develop By = MJ MARAZ   ====================== -->
<body>
    <header class="header_part">
        <a href="index.php"><img src="assets/images/about-logo.png" alt="" class="img-fluid"></a>
        <h4>PTT</h4>
    </header>
    <!-- =======  Data-Table  = Start  ========================== -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="data_table">
                    <table id="example" class="table table-striped table-bordered">
                        <thead class="table-green">
                            <tr style="background: #1327df; color: #fff;">
                                <th>Station Id</th>
                                <th>Station Name</th>
                                <th>IP addres</th>
                                <th>Telegram Group Chat ID</th>
                                <th>
                                    <form method="post" action="status1.php">
                                        <button class="btn btn-primary" style="color: #fff; margin: -15px 0" type="submit" name="enable_all">Enable All</button>
                                        <button class="btn btn-danger" style="color: #fff; margin: -15px 0" type="submit" name="disable_all">Disable All</button>
                                    </form>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = "SELECT * FROM station_host";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['station_id']; ?></td>
                                    <td><?php echo $row['station_name']; ?></td>
                                    <td><?php echo $row['ip_address']; ?></td>
                                    <td><?php echo $row['g_telegram']; ?></td>
                                    <!-- Connectivity Events click  enable & disable -->
                                    <td style="padding: -10px 0;">
                                        <?php
                                        if ($row['status_sendingtelegram'] == 1) {
                                            echo ' <button class="btn btn-primary" ><a style="color: #fff;" href = "status.php?station_id=' . $row['station_id'] . '&status_sendingtelegram=0" >enable</a></button>';
                                        } else {
                                            echo ' <button class="btn btn-danger" ><a style="color: #fff;" href = "status.php?station_id=' . $row['station_id'] . '&status_sendingtelegram=1" >disable</a></button>';
                                        }
                                        ?>
                                    </td>
                                <?php } ?>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- =======  Data-Table  = End  ===================== -->
    <!-- ============ Java Script Files  ================== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>