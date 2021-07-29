<?php

$connection = mysqli_connect('localhost', 'root', '');

if (!$connection) {
    die("Database connection failed!" . mysqli_connect_errno() . "\n");
}

$select_db = mysqli_select_db($connection, 'widget_corp');

if (!$select_db) {
    $query = "CREATE DATABASE widget_corp";

    if (mysqli_query($connection, $query)) {
        echo "Database created successfully!";
    } else {
        echo "Failed to create the database!" . mysqli_errno($connection) . "\n";
    }
} else {
    echo "Database already exists!\n\n" .
        '<a href="./create_table.php">Create tables</a>';
}

mysqli_close($connection);
