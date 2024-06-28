<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "printup";

$conn = mysqli_connect($servername, $username, $password, $database);
$conn->set_charset("utf8");

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
