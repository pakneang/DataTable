<?php
require_once('config.php');


// if (!$connection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Query data from the database
$query = "SELECT * FROM station_host";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Convert data to JSON
$dataJSON = json_encode($data);

mysqli_close($conn);

// echo $dataJSON;
// $iplist = array(
//     array("10.3.1.160", "station_name1"),
//     array("10.3.1.146", "station_name2")
// );
// $i = count($iplist);
// $results = [];
// for ($j = 0; $j < $i; $j++) {
//     $ip = $iplist[$j][0];
//     $ping = exec("ping -n 1 $ip", $output, $status);
//     $results[] = $status;
// }
// echo $status;
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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="myChart"></canvas>

    <script>
        // Fetch data from PHP script
        fetch('test.php')
            .then(response => response.json())
            .then(data => {
                // Process data and create chart
                const labels = data.map(item => item.label);
                const values = data.map(item => item.value);

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Chart Data',
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
</body>

</html>