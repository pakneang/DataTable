<html>

<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>

    </style>
</head>

<body>

    <div style="height: 150px; background-color:yellow;">
        <h1>Normal Div.</h1>
        <?php
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "d_ptt";
        $conn = mysqli_connect($servername, $username, $password, $db);
        if ($conn) {
            echo "Connected to db";
        } else {
            echo "Not Connected to db";
        }

        $sql = "SELECT * FROM test WHERE id='3' ";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        echo "<br>";
        echo "<h1>" .$row["val"] . "</h1>";

        ?>

    </div>

    <br>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#autorefresh").load(window.location.href + " #autorefresh");
            }, 3000);
        });
    </script>

    <div id="autorefresh" style="height: 150px; background-color:lightgreen;">
        <h1>Auto refreshing Div.</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "d_ptt";
        $conn = mysqli_connect($servername, $username, $password, $db);
        if ($conn) {
            echo "Connected to db";
        } else {
            echo "Not Connected to db";
        }

        $sql = "SELECT * FROM test WHERE id='4' ";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        echo "<br>";
        echo "<h1>" . $row["val"] . "</h1>";

        ?>

    </div>


</body>

</html>