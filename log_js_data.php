<?php
include 'db_connect.php';

$config = parse_ini_file('config.ini');
$log_methods = explode(',', $config['LOG_METHOD']);
$log_file = $config['LOG_FILE'];

$json = file_get_contents('php://input');
$data = json_decode($json);

$all_empty = !array_filter((array) $data, function($value) {
    return !empty($value) || $value === '0' || $value === 0;
});

if (!$all_empty) {
    $timestamp = date("Y-m-d H:i:s");

    // Text file logging
    if (in_array('TXT', $log_methods)) {
        $log = "Timestamp: $timestamp, IP Address: {$data->ip_address}, ..."; // continue with log string
        file_put_contents($log_file, $log, FILE_APPEND);
    }

    // Database logging
    if (in_array('DB', $log_methods)) {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("INSERT INTO user_log (timestamp, ip_address, user_agent, request_uri, accept_language, referrer, screen_width, screen_height, cpu_cores, device_memory, connection_type, touch_support, first_visit, is_returning_user, user_uid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssiisiisssss", $timestamp, $data->ip_address, $data->user_agent, $data->request_uri, $data->accept_language, $data->referrer, $data->screen_width, $data->screen_height, $data->cpu_cores, $data->device_memory, $data->connection_type, $data->touch_support, $data->first_visit, $data->is_returning_user, $data->user_uid);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
        }
    }
}
?>
