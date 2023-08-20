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

// Checkbox
// if (isset($_GET['id'])) {
//     $update_id = $_GET['id'];


//     $status_sendingtelegram = $_POST['status_sendingtelegram'];

//     $query_update = "UPDATE station_host SET

//   status_sendingtelegram = 'Active'

//     WHERE id ='" . $update_id . "'";

//     $update_run = mysqli_query($conn, $query_update);
//     if ($query_run == true) {
//       header("location: pr3.php");
//       exit();
//     } else {
//       header("location: pr3.php");
//       exit();
//     }
//   }

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

    <script>
        function Check() {
            chk = document.getElementsByName("my_check")[0]
            chk2 = document.getElementsByName('check_list[]')

            if (chk.checked == true) {
                chk.value = "Active";
                chk2.value = "Active";
                for (i = 0; i < chk2.length; i++)
                    chk2[i].checked = true;
                    // window.location.href = "pr1.php";


                // $edit = "UPDATE station_host SET status_sendingtelegram = '' WHERE ip_address = '".$ip."'";
                // $query_run = mysqli_query($conn, $edit);

            } else {
                chk.value = "Disactive";
                chk2.value = "Disactive";
                for (i = 0; i < chk2.length; i++)
                    chk2[i].checked = false;


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
                                    <input type="checkbox" class="form-check-input" name="my_check" value="yes" onClick=Check()>
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
                                        <form name=myform action=action_page.php method=post>
                                            <input class="form-check-input" name=check_list[] type="checkbox" value="" id="flexCheckDefault">

                                            <!-- <input type=checkbox name=check_list[] value=ASP>ASP<br>

                                            <input type=checkbox name=check_list[] value=PHP>PHP<br>
                                            <input type=checkbox name=check_list[] value=JavaScript>JavaScript<br>
                                            <input type=checkbox name=check_list[] value=HTML>HTML<br>
                                            <input type=checkbox name=check_list[] value=MySQL>MySQL<br>
                                            <input type=checkbox name='my_check' value='yes' onClick=Check()>
                                            <b>Check Control</b>
                                            <Input type=submit value=Submit> -->
                                        </form>
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