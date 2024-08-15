# 302 Logger

**302 Logger** is a utility designed to capture and log visitor interactions before a seamless redirection. This tool is ideal for analytical evaluations and can be used in various scenarios, including website migrations, A/B testing, and more.

## Features

* Captures a wide range of data points, including IP address, User-Agent, screen dimensions, and more.
* Logs both server-side and client-side data.
* Utilizes cookies to assign unique identifiers to new users and to reliably identify returning visitors across sessions.
* Performs seamless redirection to a specified URL.
* Wildcard redirection support. (e.g., redirecting `webapp.net/asd` to `webapp.com/asd`)
* Logs data to both a file and a MySQL database for redundancy and easier analysis.

## Setup

1. **Clone the Repository**

   ```bash
   git clone https://github.com/omerbustun/302-logger.git
   ```

   ```bash
   cd 302-logger
   ```

2. **Configure the Tool**
   * Rename `config.ini.default` to `config.ini`.
   * Edit `config.ini` and set your desired `REDIRECT_URL`, `LOG_FILE` path, and database credentials.

3. **Database Setup**
   * Create a MySQL database for the logger.
   * Import the provided `schema.sql` file to create the necessary table structure:

     ```bash
     mysql -u your_username -p your_database_name < schema.sql
     ```

4. **Deploy**
   Upload the files to your web server's root directory or a subdirectory. Make sure your server supports and has enabled PHP, the Apache mod_rewrite module, and has PDO with MySQL support.

5. **Access the Tool**
   Any request to your domain (or the subdirectory where you've placed the logger) will now capture data and then redirect to the specified `REDIRECT_URL`.

## Usage Notes

* Make sure the directory containing your logs is writable by the server for data logging.
* Ensure that direct access to the `config.ini` file is restricted. The provided `.htaccess` file already contains a directive for this, but always double-check for security reasons.
* Respect user privacy. Only deploy this tool in scenarios where you have the right to capture user data and ensure compliance with relevant data protection regulations (e.g., KVKK, GDPR).

## Advanced Configurations

### Handling Proxies and CDNs

If your server is behind a reverse proxy like Cloudflare, the logged IP address may not be the actual IP address of the client. Instead, it might capture the IP address of the proxy server.

To capture the real IP address of the client:

1. **Cloudflare**: Replace the line capturing the IP address in `logger.php` with the following:

   ```php
   $ip_address = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
   ```

   Cloudflare sets the `HTTP_CF_CONNECTING_IP` header to the visitor's IP address.

2. **Other Proxies**: Different proxies may use different headers to forward the original IP address. For example, many proxies use the `X-Forwarded-For` header. Check the documentation of the proxy or CDN you are using to find the correct header.

## Troubleshooting

1. **Redirection not working**:
   * Ensure that mod_rewrite is enabled on your Apache server.
   * Check that the .htaccess file is present and readable by the server.

2. **Data not being logged**:
   * Verify that the log file path set in config.ini is writable by the web server.
   * Check database credentials and connectivity.

3. **Database errors**:
   * Ensure that PDO and pdo_mysql extensions are enabled in your PHP configuration.
   * Verify that the database user has the necessary permissions to insert data.
   * Double-check that the `user_logs` table has been created correctly by importing the `schema.sql` file.

4. **JavaScript not loading**:
   * Check browser console for any JavaScript errors.
   * Ensure that there are no Content Security Policy restrictions blocking inline scripts.

If you encounter persistent issues, please check the error logs of your web server and PHP for more detailed information.

## Misc

### Log Parser Script

If you're looking to parse the generated logs into a structured format for easy analysis, you can use the [**log parser script**](https://gist.github.com/omerbustun/97e26e985e3079eb61cc7584a0eb9654). The script reads the `.txt` log file, extracts the data, and saves it in an Excel sheet.

## Contribution

Feel free to fork this repository and submit pull requests for improvements or additional features. Please ensure that your contributions adhere to best practices for security and performance.

## License

This project is licensed under the GNU General Public License, version 3 (GPLv3). See the [LICENSE](LICENSE) file for the full license text.
