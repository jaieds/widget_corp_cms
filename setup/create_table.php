<?php

$connection = mysqli_connect('localhost', 'root', '', 'widget_corp', '3306');

if (!$connection) {
    die("Database connection failed!" . mysqli_connect_errno() . "<br>");
}


$query = "CREATE TABLE subjects (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_name VARCHAR(30) NOT NULL,
    position int(3) NOT NULL,
    visible tinyint(30) NOT NULL
    )";

if (mysqli_query($connection, $query)) {
    echo "subjects Table created successfully<br>";
} else {
    echo "Failed to create the subjects Table!: <br>" . mysqli_error($connection) . "<br>";
}



$query = "CREATE TABLE pages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id int(11) NOT NULL,
    menu_name VARCHAR(30) NOT NULL,
    position int(3) NOT NULL,
    visible tinyint(1) NOT NULL,
    content text NOT NULL
    )";

if (mysqli_query($connection, $query)) {
    echo "pages Table created successfully<br>";
} else {
    echo "Failed to create the pages Table!: <br>" . mysqli_error($connection) . "<br>";
}



$query = "CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    hashed_password VARCHAR(40) NOT NULL
    )";

if (mysqli_query($connection, $query)) {
    echo "users Table created successfully<br>";
} else {
    echo "Failed to create the users Table!: <br>" . mysqli_error($connection) . "<br>";
}


mysqli_close($connection);
