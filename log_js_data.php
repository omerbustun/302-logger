<?php
    // Read from the config.ini file
    $config = parse_ini_file('config.ini');
    $log_file = $config['LOG_FILE'];

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // Create the log string with all data
    $timestamp = date("Y-m-d H:i:s");
    $log = "Timestamp: $timestamp, IP Address: {$data->ip_address}, User-Agent: {$data->user_agent}, Request URI: {$data->request_uri}, Accept-Language: {$data->accept_language}, Referrer: {$data->referrer}, Screen Width: {$data->screen_width}, Screen Height: {$data->screen_height}, CPU Cores: {$data->cpu_cores}, Device Memory: {$data->device_memory}, Connection Type: {$data->connection_type}, Touch Support: {$data->touch_support} \n";

    file_put_contents($log_file, $log, FILE_APPEND);
?>
