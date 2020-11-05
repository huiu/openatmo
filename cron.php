<?php

require_once ('bootstrap.php');

//get data from sensor
ob_start();
passthru('python /var/www/bme280.py');
$result = ob_get_clean();

$temperature = number_format(get_string_between($result, "Temperature : ", " C"), 2);
$pressure = str_replace(",", "", number_format(get_string_between($result, "Pressure : ", " hPa"), 2));
$humidity = number_format(get_string_between($result, "Humidity :", " %"), 2);
echo "Temperatur: ".$temperature." °C</br>";
echo "Luftdruck: ".$pressure." hPa</br>";
echo "Luftfeuchtigkeit: ".$humidity."%";

//write to DB
$stmt = $pdo->prepare("INSERT INTO sensordata (temperature, pressure, humidity) VALUES (?, ?, ?)");
$stmt->execute([$temperature, $pressure, $humidity]);