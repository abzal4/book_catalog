<?php 
    $host = "localhost";
    $port = 3306;
    $dbname = "book_catalog";
    $user = "abzal";
    $password = "abzal";

    $conn = new mysqli($host, $user, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
?>


