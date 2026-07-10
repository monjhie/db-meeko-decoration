<?php
date_default_timezone_set('Asia/Singapore');

if (!defined('BASE_URL')) define("BASE_URL", getenv('BASE_URL') ?: "http://127.0.0.1/db_meeko_decorations/");
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'db_meeko_decorations');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: '3306');

$conn = mysqli_init();

// Remote hosts (like Aiven) require SSL. Localhost/XAMPP does not.
if (DB_HOST !== 'localhost' && DB_HOST !== '127.0.0.1') {
    $conn->ssl_set(null, null, __DIR__ . '/ca.pem', null, null);
    $conn->real_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT, null, MYSQLI_CLIENT_SSL);
} else {
    $conn->real_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
}

if ($conn->connect_error) {
    die('Connection Error: ' . $conn->connect_error);
}
?>