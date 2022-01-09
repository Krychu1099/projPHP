<?php

// W tym pliku jest skonfigurowane połączenia z bazą danych

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "nibydziala";

$conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failde: " . mysqli_connect_error());
}