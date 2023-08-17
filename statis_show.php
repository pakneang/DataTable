<?php
require_once('config.php');
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
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
    <script src="codepen.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<!-- =============== Design & Develop By = MJ MARAZ   ====================== -->

<body>
    <header class="header_part">
        <a href="index.php"><img src="assets/images/about-logo.png" alt="" class="img-fluid"></a>
        <h4>PTT</h4>
    </header>
    <div class="container" style="background-color: #fff; max-width: 1280px;">

        <div class="data_table">
            <div>
                <div class="dropdown">
                    <div class="divd">

                    </div>
                </div>
            </div>
        </div>
        <div class="statit_p">
            <h5><?php
                if (isset($_GET['station_name'])) {
                    echo $_GET['station_name'];
                    // echo $_GET['ip_address'];

                }
                ?>
            </h5>
        </div>

        <div class="col-6 statit_chart">
            <div class="col-12 statit_time">
                <h5>statistics</h5>
                <div class="statit_timespan">
                    <span>Downtime</span><span class="echo"><?php
                                                            $id = $_GET['station_name'];

                                                            $count = "SELECT COUNT(status_dataanalyst) AS count FROM data_analyst WHERE stationname_dataanalyst='" . $id . "' AND status_dataanalyst='Offline'";
                                                            $count_run1 = mysqli_query($conn, $count);
                                                            $numCounter1 = mysqli_fetch_assoc($count_run1);
                                                            // echo $id;           
                                                            echo $numCounter1['count'];
                                                            $countOffline = $numCounter1;

                                                            ?></span>
                    <div>
                        <span>Uptime</span><span class="echo"><?php
                        // code b rothana
                                                                $id = $_GET['station_name'];
                                                                $count = "SELECT COUNT(status_dataanalyst) AS count FROM data_analyst WHERE stationname_dataanalyst='" . $id . "' AND status_dataanalyst='Online'";
                                                                $count_run0 = mysqli_query($conn, $count);
                                                                $numCounter0 = mysqli_fetch_assoc($count_run0);
                                                                echo $numCounter0['count'];
                                                                $countOnline = $numCounter0;

                                                                ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 statit_bar">
                <h5>statistics</h5>
                <div class="m-chart">
                    <canvas id="myChart" style="width: 50%; max-width: 700px; margin-bottom: 20px"></canvas>
                </div>
            </div>
        </div>
        <div class="">
            <!-- Search filter -->
            <form method='post' action=''>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-3">
                            <label for="">Start Date</label>
                            <input type='date' class='form-control' name='fromDate' value='<?php if (isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>

                        </div>
                        <div class="col-3">
                            <label for="">End Date</label>
                            <input type='date' class='form-control' name='endDate' value='<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

                        </div>
                        <div class="col-3">
                            <label for=""></label><br>
                        <input type='submit' class='btn btn-primary btn2' name='but_search' value='Filter'>
                        </div>
                        <!-- Start Date <input type='date' class='dateFilter' name='fromDate' value='<?php if (isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>

                    End Date <input type='date' class='dateFilter' name='endDate' value='<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

                    <input type='submit' name='but_search' value='Search'> -->
                    </div>
                </div>
            </form>


            <!-- Employees List -->
            <div style='height: 80%; overflow: auto;'>

                <table border='1' width='100%' style='border-collapse: collapse;margin-top: 20px;' id="example" class="table table-striped table-bordered">
                    <thead class="table-green">
                        <tr>
                            <th>Station Id</th>
                            <th>Station Name</th>
                            <th>IP addres</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $_GET['station_name'];
                        $count = 0;
                        $OfflineCount = 0;
                        $OnlineCount = 0;
                        $emp_query = "SELECT * FROM data_analyst WHERE stationname_dataanalyst='" . $id . "' AND day_dataanalyst";

                        // Date filter
                        if (isset($_POST['but_search'])) {
                            $fromDate = $_POST['fromDate'];

                            $endDate = $_POST['endDate'];


                            if (!empty($fromDate) && !empty($endDate)) {

                                $fromDateTime = date('Y-m-d H:i:s', strtotime($fromDate . '00:00:00'));
                                $endDateTime = date('Y-m-d H:i:s', strtotime($endDate . '23:59:59'));
                                $emp_query .= " AND day_dataanalyst between ' $fromDateTime ' AND ' $endDateTime ' ";
                            }
                        }

                        // Sort
                        $emp_query .= " ORDER BY day_dataanalyst DESC";
                        $employeesRecords = mysqli_query($conn, $emp_query);

                        $recordCountByDay = array();
                        // Check records found or not
                        if (mysqli_num_rows($employeesRecords) > 0) {
                            while ($empRecord = mysqli_fetch_assoc($employeesRecords)) {

                                if ($empRecord['status_dataanalyst'] == 'Offline') {
                                    $OfflineCount++;
                                } elseif ($empRecord['status_dataanalyst'] == 'Online') {
                                    $OnlineCount++;
                                }
                                $station_hostid = $empRecord['station_hostid'];
                                $empName = $empRecord['stationname_dataanalyst'];
                                $date_of_join = $empRecord['ipaddress_dataanalyst'];
                                $gender = $empRecord['day_dataanalyst'];
                                $email = $empRecord['status_dataanalyst'];
                                $count++;

                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . $empName . "</td>";
                                echo "<td>" . $date_of_join . "</td>";
                                echo "<td>" . $gender . "</td>";
                                echo "<td style='padding: 0;'>"
                                ?> 
                                <?php
                                if ($empRecord['status_dataanalyst'] == 'Offline') {
                                    echo "<p style='color:#fff; padding: 10px; background: red;'>$email </p>";
                                } elseif ($empRecord['status_dataanalyst'] == 'Online') {
                                    echo "<p style='color:#fff; padding: 10px; background: green;'>$email</p>";
                                }
                                "</td>";

                                echo "</tr>";
                            }
                            echo "<div class='echo'>";
                            echo "<span class='span' style='color:blue;'>Total:</span>$count<br>";
                            echo "<span class='span' style='color:red;'>Offline:</span>$OfflineCount<br>";
                            echo "<span class='span' style='color:green;'>Online:</span>$OnlineCount";
                            echo "</div>";
                        } else {
                            echo "<tr>";
                            echo "<td colspan='4'>No record found.</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- =======  Data-Table  = End  ===================== -->
        <!-- ============ Java Script Files  ================== -->

        <?php
        $c0 = $numCounter0['count'];
        $c1 = $numCounter1['count'];
        ?>
        <!-- Script -->
        <script src='jquery-3.3.1.js' type='text/javascript'></script>
        <script src='jquery-ui.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $('.dateFilter').datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/datatables.min.js"></script>
        <script src="assets/js/pdfmake.min.js"></script>
        <script src="assets/js/vfs_fonts.js"></script>
        <script src="assets/js/custom.js"></script>
        <script type="text/javascript">
            var MyJSStringVar = "<?php echo $c0; ?>";
            var MyJSNumVar = "<?php echo $c1; ?>";
            const xValues = ["Up", "Down"];
            const yValues = [MyJSStringVar, MyJSNumVar];
            const barColors = ["#008000", "#b91d47"];
            new Chart("myChart", {
                type: "bar",
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
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {

                load_data();

                // function load_data(is_days) {
                //     var dataTable = $('#order_data').DataTable({
                //         "processing": true,
                //         "serverSide": true,
                //         "order": [],
                //         "ajax": {
                //             url: "fetch.php",
                //             type: "POST",
                //             data: {
                //                 is_days: is_days
                //             }
                //         }
                //     });
                // }

                $(document).on('change', '#days_filter', function() {
                    var no_of_days = $(this).val();
                    $('#example').DataTable().destroy();
                    if (no_of_days != '') {
                        load_data(no_of_days);
                    } else {
                        load_data();
                    }
                });

            });
        </script>


</body>

</html>