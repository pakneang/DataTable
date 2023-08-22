<?php
require_once"config.php";

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
        header("location: pagehost.php");
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


// $ip = "ip_address";
// if ($row['$ip_address'] == $ip) {

//     function ping($ip_address)
//     {
//         $fP = fSockOpen($ip_address);
//         if (!$fP) {
//             return FALSE;
//         } else {
//             return TRUE;
//         }
//     }

//     if (ping($ip)) {
//         echo "Up";
//     } else {
//         echo "Down";
//     }
// }

// $iplist = array(
//     array("10.3.1.160", "station_name1"),
//     array("10.3.1.146", "station_name2"),
//     array("203.189.134.101", "station_name3")
// );
// $i = count($iplist);
// $results = [];
// for ($j = 0; $j < $i; $j++) {
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
// foreach ($results as $item => $k) {
//     echo '<tr>';
//     echo '<td align=right>' . $item . '</td>';
//     echo '<td>' . $iplist[$item][0] . '</td>';
//     if ($results[$item] == 0) {
//         echo '<td style=color:green>Online</td>';
//     } else {
//         echo '<td style=color:red>Offline</td>';
//     }
//     echo '<td>' . $iplist[$item][1] . '</td>';
//     echo '</tr>';
// }
// echo "</table>";
// echo '</font>';

// 
?>

<!-- $iplist = ['ip_address'];
$i = count($iplist);
$results = [];
for ($j = 0; $j < $i; $j++) {
    $ip = $iplist[$j][0];
    $ping = exec("ping -n 1 $ip", $output, $status);
    $results[] = $status;
}
Table

foreach ($results as $item => $k) {
    if ($results[$item] == 0) {
        echo 'Online';
    } else {
        echo 'Offline';
    }
    echo . $iplist[$item][1] .;
}  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="Author" name="MJ Maraz">
    <meta http-equiv="refresh" content="5">
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- ========================================================= -->


    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="codepen.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>






</head>
<!-- =============== Design & Develop By = MJ MARAZ   ====================== -->

<body>
    <header class="header_part">
        <img src="assets/images/about-logo.png" alt="" class="img-fluid">
        <h4>PTT</h4>
    </header>
    <!-- =======  Data-Table  = Start  ========================== -->
    <div class="container">
        <div class="row" style="padding: 10px;">
            <div class="col-12">
                <div  class="data_table">
                    <div class="center-cantainer">
                        <div class="inje">
                            <div class="inj-1">
                                <div class="inj-left">
                                    <h2>Hosts Summary</h2>

                                    <!-- start codepen round -->
                                    <div id="container">
                                        <div class="card codepenc chart-wrap bg ring1">
                                            <h3></h3>
                                            <div class="m-chart">
                                                <canvas id="myChart" style="width: 50%; max-width: 500px; margin-bottom: 20px"></canvas>
                                            </div>
                                            <div id="autorefresh1" class="chart-legend">
                                                <table>
                                                    <tr>
                                                        <th class="th-chart">State</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="" class="btn btn-up"><?php
                                                                                            $count = "SELECT * FROM station_host WHERE status_onlineoffline='Online'";
                                                                                            $count_run0 = mysqli_query($conn, $count);
                                                                                            $numCounter0 = mysqli_num_rows($count_run0);
                                                                                            echo $numCounter0;
                                                                                            $countOnline = $numCounter0;

                                                                                            ?></a><span>Up</span>
                                                        </td>
                                                        <td class="td1">
                                                            <a href="" class="btn btn-down"><?php
                                                                                            $count = "SELECT * FROM station_host WHERE status_onlineoffline='Offline'";
                                                                                            $count_run1 = mysqli_query($conn, $count);
                                                                                            $numCounter1 = mysqli_num_rows($count_run1);
                                                                                            echo $numCounter1;
                                                                                            $countOffline = $numCounter1;

                                                                                            ?></a><span>Down</span>
                                                        </td>
                                                        <td class="">
                                                            <a href="" class="btn btn-upp"><?php
                                                                                            $count = "SELECT * FROM station_host";
                                                                                            $count_run = mysqli_query($conn, $count);
                                                                                            $numCounter = mysqli_num_rows($count_run);
                                                                                            echo $numCounter;
                                                                                            ?></a><span>Total</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end codepen round -->
                                </div>
                            </div>
                            <div class="inj-right">
                                <a href="index.php">
                                    <button type="button" class="btn btn-pusple">
                                        <p>State Monitor</p>
                                    </button>
                                </a>
                                <a href="statis.php">
                                    <button type="button" class="btn btn-green">
                                        <p>Statistics</p>
                                    </button>
                                </a>
                                <a href="pagehost.php">
                                    <button type="button" class="btn btn-red">
                                        <p>Hosts</p>
                                    </button>
                                </a>
                                <a href="pagevent.php">
                                    <button type="button" class="btn btn-blue">
                                        <p>Connectivity Events</p>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="autorefresh">
                        <table id="example" class="table table-striped table-bordered">
                            <thead class="table-green">
                                <tr style="background: #1327df; color: #fff;">
                                    <th>Station Name</th>
                                    <th>IP addres</th>
                                    <th>Status</th>
                                    <!-- <th>Telegram Group Chat ID</th>
                                <th>
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">Select All</label>
                                </th> -->
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
                                        <td><?php echo $row['station_name']; ?></td>
                                        <td><?php echo $row['ip_address']; ?></td>
                                        <td style="padding: 0;">
                                            <?php
                                            if ($row["status_onlineoffline"] == 'Online') {
                                                echo "<p style='color:#fff; padding: 10px; background: green;'>Online</p>";
                                            } else {
                                                echo "<p style='color:#fff; padding: 10px; background: red;'>Offline</p>";
                                            }
                                            ?>

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
    </div>
    <!-- =======  Data-Table  = End  ===================== -->
    <!-- ============ Java Script Files  ================== -->
<?php
 $c0 = $countOnline;
 $c1 = $countOffline;
?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/pdfmake.min.js"></script>
    <script src="../assets/js/vfs_fonts.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script type="text/javascript">
        var  MyJSStringVar="<?php echo $c0; ?>";
        var  MyJSNumVar="<?php echo $c1; ?>";
        const xValues = ["Up", "Down"];
        const yValues = [MyJSStringVar, MyJSNumVar];
        const barColors = ["#008000", "#b91d47"];

        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    // cutout: '10%',
                }]
            },
            options: {
                title: {
                    display: true,
                    // text: "World Wide Wine Production 2018"
                }
            }

        });
    </script>

    <!-- Auto refresh -->
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#autorefresh").load(window.location.href + " #autorefresh");
            }, 1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#autorefresh1").load(window.location.href + " #autorefresh1");
            }, 1000);
            return(0);
        });
    </script>


</body>

</html>