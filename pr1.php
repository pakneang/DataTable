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






</head>
<!-- =============== Design & Develop By = MJ MARAZ   ====================== -->

<body>
    <header class="header_part">
        <a href="index.php"><img src="assets/images/about-logo.png" alt="" class="img-fluid"></a>
        <h4>PTT</h4>
    </header>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content1">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add host</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="pr1.php" method="post">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Station ID :</label>
                            <input type="text" name="station_id" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Station Name :</label>
                            <input type="text" name="station_name" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">IP address :</label>
                            <input type="text" name="ip_address" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Telegram Group Chat ID
                                :</label>
                            <input type="text" name="g_telegram" class="form-control" id="recipient-name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="clear" name="" class="btn btn-secondary btn-secondary1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="submit1" class="btn btn-primary btn-secondary1">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- =======  Data-Table  = Start  ========================== -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="data_table">
                    <div class="host-a">
                        <h4>Host</h4>
                        <a href="" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" style="margin-left: 10px; margin-top: 0;">add</a>
                    </div>

                    <table id="example" class="table table-striped table-bordered">
                        <thead class="table-green">
                            <tr style="background: #1327df; color: #fff;">
                                <th>Station Id</th>
                                <th>Station Name</th>
                                <th>IP addres</th>
                                <th>Telegram Group Chat ID</th>
                                <th>Actions</th>
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

                                    <td>
                                        <a class=' btn-primary btn-sm btn1' data-bs-toggle="modal" data-bs-target="#exampleModal-2<?= $row['id']; ?>" data-bs-whatever="@mdo" href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                                        <a href='' class=' btn-danger btn-sm btn1' data-bs-toggle="modal" data-bs-target="#exampleModal-3<?= $row['id']; ?>">delete</a>
                                    </td>
                                </tr>
                                <!-- edit -->
                                <div class="modal fade" id="exampleModal-2<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add host</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="edit.php" method="post">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Station ID
                                                            :</label>
                                                        <input type="text" name="station_id" class="form-control" id="recipient-name" value="<?php echo $row['station_id']; ?>">
                                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">Station Name
                                                            :</label>
                                                        <input type="text" name="station_name" class="form-control" id="recipient-name" value="<?php echo $row['station_name']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">IP address
                                                            :</label>
                                                        <input type="text" name="ip_address" class="form-control" id="recipient-name" value="<?php echo $row['ip_address']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">Telegram Group Chat
                                                            ID :</label>
                                                        <input type="text" name="g_telegram" class="form-control" id="recipient-name" value="<?php echo $row['g_telegram']; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="clear" name="" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="edit1" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end edit -->

                                <!-- start delete -->
                                <div class="modal fade" id="exampleModal-3<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a type="button" class="btn btn-danger" href="delete.php?id=<?= $row['id']; ?> ">Ok</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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