<?php require_once ('bootstrap.php'); ?>

<html>
<head>

    <script language="JavaScript" src="lib/Chart.bundle.min.js"></script>
    <script language="JavaScript" src="lib/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" type="text/css" href="lib/Chart.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap.min.css" media="screen" />


</head>

<body>

<?php

//realtime data
ob_start();
passthru('python /var/www/bme280.py');
$result = ob_get_clean();

$temperature = number_format(get_string_between($result, "Temperature : ", " C"), 2);
$pressure = str_replace(",", "", number_format(get_string_between($result, "Pressure : ", " hPa"), 2));
$humidity = number_format(get_string_between($result, "Humidity :", " %"), 2);


?>

<div class="jumbotron">
    <h2>Echtzeitwerte:</h2> </br>
    <?php
    echo "Temperatur: ".$temperature." °C</br>";
    echo "Luftdruck: ".$pressure." hPa</br>";
    echo "Luftfeuchtigkeit: ".$humidity."%";
    ?>

    </div>

<?php

$temperatureArray = array();
$dateArray = array();
$humidityArray = array();
$pressureArray = array();

$stmt = $pdo->query('SELECT * FROM (SELECT * FROM sensordata ORDER BY id DESC LIMIT 576) sub ORDER BY id ASC');
foreach ($stmt as $row)  {
    $temperatureArray[] = $row['temperature'];
    $dateArray[] = $row['created'];
    $humidityArray[] = $row['humidity'];
    $pressureArray[] = $row['pressure'];
}
?>


<canvas id="myChart" width="800" height="200"></canvas>
<script>
    var ctx = document.getElementById('myChart');

    var myChart = new Chart(ctx, {
        type: 'line',
        maintainAspectRatio: false,
        data: {
            labels: [<?php
                foreach($dateArray as $item) {
                    echo "'",$item."', ";
                } ?>],
            datasets: [{
                steppedLine: false,
                lineTension: 0.2,
                label: 'Temperatur in °C',
                data: [<?php
                    foreach($temperatureArray as $item) {
                        echo $item.", ";
                    } ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }],
                xAxes: [{
                    display: false //this will remove all the x-axis grid lines
                }]
            }
        }
    });
</script>

<canvas id="myChart2" width="800" height="200"></canvas>
<script>
    var ctx2 = document.getElementById('myChart2');

    var myChart2 = new Chart(ctx2, {
        type: 'line',
        maintainAspectRatio: false,
        data: {
            labels: [<?php
                foreach($dateArray as $item) {
                    echo "'",$item."', ";
                } ?>],
            datasets: [{
                lineTension: 0.2,
                label: 'Luftdruck in hPa',
                data: [<?php
                    foreach($pressureArray as $item) {
                        echo $item.", ";
                    } ?>],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }],
                xAxes: [{
                    display: false //this will remove all the x-axis grid lines
                }]
            }
        }
    });
</script>

<canvas id="myChart3" width="800" height="200"></canvas>
<script>
    var ctx3 = document.getElementById('myChart3');

    var myChart3 = new Chart(ctx3, {
        type: 'line',
        maintainAspectRatio: false,
        data: {
            labels: [<?php
                foreach($dateArray as $item) {
                    echo "'",$item."', ";
                } ?>],
            datasets: [{
                lineTension: 0.2,
                label: 'Luftfeuchtigkeit in %',
                data: [<?php
                    foreach($humidityArray as $item) {
                        echo $item.", ";
                    } ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }],
                xAxes: [{
                    display: false //this will remove all the x-axis grid lines
                }]
            }
        }
    });
</script>


</body>
</html>
