<?php

$host = "localhost";
$dbname = "smart_complaint_resolution_system";
$username = "root";
$password = "39325229";

// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>