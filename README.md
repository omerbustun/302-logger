302 Logger
==========

**302 Logger** is a utility designed to capture and log visitor interactions before a seamless redirection. This tool is ideal for analytical evaluations and can be used in various scenarios, including website migrations, A/B testing, and more.

Features
--------

*   Captures a wide range of data points, including IP address, User-Agent, screen dimensions, and more.
*   Logs both server-side and client-side data.
*   Performs seamless redirection to a specified URL.
*   Wildcard redirection support. (e.g., redirecting `webapp.net/asd` to `webapp.com/asd`)

Setup
-----

1.  **Clone the Repository**
        
    ```bash
    git clone https://github.com/omerbustun/302-logger.git
    cd 302-logger
    ```
    
2.  **Configure the Tool**
    
    *   Rename `config.d.ini` to `config.ini`.
    *   Edit `config.ini` and set your desired `REDIRECT_URL` and `LOG_FILE` path.


3.  **Deploy**
 
    Upload the files to your web server's root directory or a subdirectory. Make sure your server supports and has enabled PHP and the Apache mod\_rewrite module.
    
4.  **Access the Tool**
    
    Any request to your domain (or the subdirectory where you've placed the logger) will now capture data and then redirect to the specified `REDIRECT_URL`.
    

Usage Notes
-----------

*   Make sure the directory containing your logs is writable by the server for data logging.
*   Ensure that direct access to the `config.ini` file is restricted. The provided `.htaccess` file already contains a directive for this, but always double-check for security reasons.
*   Respect user privacy. Only deploy this tool in scenarios where you have the right to capture user data.

Contribution
------------

Feel free to fork this repository and submit pull requests for improvements or additional features.

License
-------

This project is licensed under the GNU General Public License, version 3 (GPLv3). See the [LICENSE](LICENSE) file for the full license text.
