<?php
require('constants.php');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_Name);

if (!$connection) {
    die("Unable to connect to the database! " . mysqli_connect_error() . "<br>");
}
