<?php
require_once('config.php');

// search
// if (isset($_POST['search'])){
//   $searchq = $_POST['search'];
//   $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

//   $query = mysqli
// }

// search


if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $sql = "SELECT * FROM station_host WHERE station_name like
          '%$search%'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_POST['submit1'])) {
    $station_id = $_POST['station_id'];
    $station_name = $_POST['station_name'];
    $ip_address = $_POST['ip_address'];
    $g_telegram = $_POST['g_telegram'];
    $insert = "INSERT INTO station_host (station_id, station_name,	ip_address,	g_telegram)
      VALUES('$station_id', '$station_name',	'$ip_address',	'$g_telegram')";
    $insert_run = mysqli_query($conn, $insert);
    if ($insert_run) {
        $message = "Insert data is successfully";
        header("location: pr1.php");
        exit();
    } else {
        $message = "Insert data is not successfully";
    }
}

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

// $iplist = array(
//     array("10.3.1.160", "station_name1"),
//     array("10.3.1.146", "station_name2")
// );
// $i = count($iplist);
// $results = [];
// for($j=0;$j<$i;$j++){
//     $ip = $iplist[$j][0];
//     $ping = exec("ping -n 1 $ip", $output, $status);
//     $results[] = $status;
// }
// Table
// echo '<font face=Courier New>';
// echo "<table border=1 style=border-collapse:collapse>
// <th colspan=4> Ping </th>
// <tr>
// <td align=right width=20>#</td>
// <td width=100>IP</td>
// <td width=100>Status</td>
// <td width=250>Description</td>
// </tr>";
// foreach($results as $item =>$k){
//     echo '<tr>';
//     echo '<td align=right>'.$item.'</td>';
//     echo '<td>'.$iplist[$item][0].'</td>';
//     if($results[$item]==0){
//         echo '<td style=color:green>Online</td>';
//     }
//     else{
//         echo '<td style=color:red>Offline</td>';
//     }
//     echo '<td>'.$iplist[$item][1].'</td>';
//     echo '</td>';
// }
// echo "</table>";
// echo '</font>';

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


    <script>
        function Check() {
            chk = document.getElementsByName("my_check")[0]
            chk2 = document.getElementsByName('check_list[]')

            if (chk.checked == true) {
                for (i = 0; i < chk2.length; i++)
                    chk2[i].checked = true
            } else {
                for (i = 0; i < chk2.length; i++)
                    chk2[i].checked = false
            }

        }
    </script>



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
                                    <!-- <input class="form-check-input" type="checkbox" name="check_list" id="inlineCheckbox1" value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">Select All</label> -->
                                    <input type=checkbox class="form-check-input" name='my_check' value='yes' onClick=Check()>
                                    <b>Select All</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = "SELECT * FROM station_host";
                            // $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['station_id']; ?></td>
                                    <td><?php echo $row['station_name']; ?></td>
                                    <td><?php echo $row['ip_address']; ?></td>
                                    <td><?php echo $row['g_telegram']; ?></td>

                                    <td>
                                        <input class="form-check-input" name=check_list[] type="checkbox" value="" id="flexCheckDefault">
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
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