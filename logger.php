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
?>
<script>
    // Get client-side data
    var screen_width = window.screen.width;
    var screen_height = window.screen.height;
    var cpu_cores = navigator.hardwareConcurrency;
    var device_memory = navigator.deviceMemory;
    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var touch_support = 'ontouchstart' in window;

    // Combine client-side and server-side data
    var combined_data = {
        screen_width: screen_width,
        screen_height: screen_height,
        cpu_cores: cpu_cores,
        device_memory: device_memory,
        connection_type: connection ? connection.effectiveType : 'unknown',
        touch_support: touch_support,
        ip_address: "<?php echo $ip_address; ?>",
        user_agent: "<?php echo $user_agent; ?>",
        request_uri: "<?php echo $request_uri; ?>",
        accept_language: "<?php echo $accept_language; ?>",
        referrer: "<?php echo $referrer; ?>"
    };

    // Send combined data to server
    fetch('/log_js_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(combined_data)
    }).then(function(response) {
        // After logging data, perform the redirection
        window.location.href = "<?php echo $redirect_url . $request_uri; ?>";
    });
</script>
