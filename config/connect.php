<?php

$host = "sql204.infinityfree.com";
$username = "if0_39390759";
$password = "papope019283";
$database = "if0_39390759_arunika";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>