<?php
    // Read from the config.ini file
    $config = parse_ini_file('config.ini');
    $redirect_url = $config['REDIRECT_URL'];
    $log_file = $config['LOG_FILE'];

    if (!isset($_COOKIE['first_visit'])) {
        setcookie("first_visit", time(), time() + (365 * 24 * 60 * 60), "/");  // expires in 1 year
        $isReturningUser = false;
    } else {
        $isReturningUser = true;
    }

    // Check for UID or set a new one
    if (!isset($_COOKIE['user_uid'])) {
        $userUID = bin2hex(random_bytes(16)); // Generate a random UID
        setcookie("user_uid", $userUID, time() + (365 * 24 * 60 * 60), "/");  // expires in 1 year
    } else {
        $userUID = $_COOKIE['user_uid'];
    }

    // Get server-side data
    $firstVisitTimestamp = isset($_COOKIE['first_visit']) ? date("Y-m-d H:i:s", $_COOKIE['first_visit']) : 'unknown';
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $request_uri = $_SERVER['REQUEST_URI'] ?? 'unknown';
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'unknown';
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'unknown';
    
?>
<script>
    // Get client-side data
    var screen_width = window.screen.width || 'unknown';
    var screen_height = window.screen.height || 'unknown';
    var cpu_cores = navigator.hardwareConcurrency || 'unknown';
    var device_memory = navigator.deviceMemory || 'unknown';
    var connection = (navigator.connection && navigator.connection.effectiveType) || 'unknown';
    var touch_support = ('ontouchstart' in window) || 'unknown';

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
        referrer: "<?php echo $referrer; ?>",
        first_visit: "<?php echo $firstVisitTimestamp; ?>",
        is_returning_user: "<?php echo $isReturningUser ? 'yes' : 'no'; ?>",
        user_uid: "<?php echo $userUID; ?>"

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
