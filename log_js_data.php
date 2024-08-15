<?php
// Read from the config.ini file
$config = parse_ini_file('config.ini');
$log_file = $config['LOG_FILE'];

$json = file_get_contents('php://input');
$data = json_decode($json);

// Create the log string
$timestamp = date("Y-m-d H:i:s");
$log = "Timestamp: $timestamp, " .
    "IP Address: " . ($data->ip_address ?? 'unknown') . ", " .
    "User-Agent: " . ($data->user_agent ?? 'unknown') . ", " .
    "Request URI: " . ($data->request_uri ?? 'unknown') . ", " .
    "Accept-Language: " . ($data->accept_language ?? 'unknown') . ", " .
    "Referrer: " . ($data->referrer ?? 'unknown') . ", " .
    "Screen Width: " . ($data->screen_width ?? 'unknown') . ", " .
    "Screen Height: " . ($data->screen_height ?? 'unknown') . ", " .
    "CPU Cores: " . ($data->cpu_cores ?? 'unknown') . ", " .
    "Device Memory: " . ($data->device_memory ?? 'unknown') . ", " .
    "Connection Type: " . ($data->connection_type ?? 'unknown') . ", " .
    "Touch Support: " . ($data->touch_support ?? 'unknown') . ", " .
    "First Visit: " . ($data->first_visit ?? 'unknown') . ", " .
    "Returning User: " . ($data->is_returning_user ?? 'unknown') . ", " .
    "UID: " . ($data->user_uid ?? 'unknown') . "\n";

// Log to file (as a backup)
file_put_contents($log_file, $log, FILE_APPEND);

// Log to database
try {
    if (!class_exists('PDO')) {
        throw new Exception("PDO is not available. Please enable PDO and pdo_mysql extensions.");
    }

    $db = new PDO("mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}", $config['DB_USER'], $config['DB_PASS']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("INSERT INTO user_logs (timestamp, ip_address, user_agent, request_uri, accept_language, referrer, screen_width, screen_height, cpu_cores, device_memory, connection_type, touch_support, first_visit, is_returning_user, user_uid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $timestamp,
        $data->ip_address ?? null,
        $data->user_agent ?? null,
        $data->request_uri ?? null,
        $data->accept_language ?? null,
        $data->referrer ?? null,
        $data->screen_width ?? null,
        $data->screen_height ?? null,
        $data->cpu_cores ?? null,
        $data->device_memory ?? null,
        $data->connection_type ?? null,
        $data->touch_support ?? null,
        $data->first_visit ?? null,
        $data->is_returning_user ?? null,
        $data->user_uid ?? null
    ]);

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Log the error to a file
    error_log("Database Error: " . $e->getMessage(), 3, "db_errors.log");
    echo json_encode(['status' => 'error', 'message' => 'Data logged to file only: ' . $e->getMessage()]);
}
