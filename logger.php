<?php
    // Read from the config.ini file
    $config = parse_ini_file('config.ini');
    $redirect_url = $config['REDIRECT_URL'];
    $log_file = $config['LOG_FILE'];

    // Get server-side data
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';

    // Log the server-side data with a timestamp
    $timestamp = date("Y-m-d H:i:s");
    $log = "Timestamp: $timestamp, IP Address: $ip_address, User-Agent: $user_agent, Request URI: $request_uri, Accept-Language: $accept_language, Referrer: $referrer \n";
    file_put_contents($log_file, $log, FILE_APPEND);
?>
<script>
    // Get client-side data
    var screen_width = window.screen.width;
    var screen_height = window.screen.height;
    var cpu_cores = navigator.hardwareConcurrency;
    var device_memory = navigator.deviceMemory;
    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var touch_support = 'ontouchstart' in window;

    // Send client-side data to server
    fetch('/log_js_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            screen_width: screen_width,
            screen_height: screen_height,
            cpu_cores: cpu_cores,
            device_memory: device_memory,
            connection_type: connection ? connection.effectiveType : 'unknown',
            touch_support: touch_support
        })
    });
</script>
<?php
    // Redirect the user with a 302 status code
    header("Location: " . $redirect_url . $request_uri, true, 302);
    exit;
?>