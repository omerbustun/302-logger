-- Create the user_logs table
CREATE TABLE IF NOT EXISTS user_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME,
    ip_address VARCHAR(45),
    user_agent TEXT,
    request_uri TEXT,
    accept_language VARCHAR(255),
    referrer TEXT,
    screen_width INT,
    screen_height INT,
    cpu_cores INT,
    device_memory FLOAT,
    connection_type VARCHAR(50),
    touch_support VARCHAR(10),
    first_visit DATETIME,
    is_returning_user VARCHAR(5),
    user_uid VARCHAR(32)
);

-- Add any additional indexes for better query performance
CREATE INDEX idx_timestamp ON user_logs(timestamp);
CREATE INDEX idx_ip_address ON user_logs(ip_address);
CREATE INDEX idx_user_uid ON user_logs(user_uid);