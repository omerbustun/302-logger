<?php
function getDBConnection() {
    $config = parse_ini_file('config.ini', true);
    $dbConfig = $config['database'];
    $conn = new mysqli($dbConfig['DB_HOST'], $dbConfig['DB_USER'], $dbConfig['DB_PASS'], $dbConfig['DB_NAME']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
