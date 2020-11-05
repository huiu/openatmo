# openatmo

This is a tiny project for my Rasperry Pi Zero W to messure, store and plot sensor data like temperature, humidity and pressure from a Bosch BME280 sensor.

The raspberry stores all data on the internal MySQL database and provides access to plots and realtime data via web interface (apache2+php). Once installed, you can access it here:

http://[your-RPi-IP]/index.php

### software used:

- [Raspberry Pi OS](https://www.raspberrypi.org/downloads/raspberry-pi-os/)
- [chart.js](https://github.com/chartjs/Chart.js) for plotting sensor data
- [Python BME280 Reader](https://bitbucket.org/MattHawkinsUK/rpispy-misc/src/master/python/bme280.py)
- apache2
- php
- mysql

### hardware used:

- [Raspberry Pi Zero W](https://www.berrybase.de/raspberry-pi-zero-w)
- [GY-BME280](https://www.berrybase.de/bauelemente/sensoren-module/feuchtigkeit/gy-bme280-breakout-board-3in1-sensor-f-252-r-temperatur-luftfeuchtigkeit-und-luftdruck) sensor with breakout board
- some oversized photolvlotaik panels
- oversized pv-battery 

# Installation:

Install software requirements on Raspbian Pi OS:
```
sudo apt install apache2 php php-mysql mysql-server
```

Create MySQL database and user:
```
mysql
> CREATE DATABASE openwaether;
> CREATE USER 'openweather'@'localhost' IDENTIFIED BY 'your_password';
> GRANT SELECT, INSERT, UPDATE, DELETE on openweather TO 'openweather'@'localhost';
```

Initialize database:
```
CREATE TABLE `sensordata` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `temperature` double DEFAULT NULL,
    `pressure` double DEFAULT NULL,
    `humidity` double DEFAULT NULL,
    `created` datetime DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
)
 ```

Final steps:

- Upload files to /var/www/html (apache2 default)
- rename config.example.ini to config.ini and adjust values

# Hardware setup:

basically like [this](https://www.raspberrypi-spy.co.uk/2016/07/using-bme280-i2c-temperature-pressure-sensor-in-python/)