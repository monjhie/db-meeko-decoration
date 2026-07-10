<?php
date_default_timezone_set('Asia/Singapore');

if (!defined('BASE_URL')) define("BASE_URL", "http://127.0.0.1/db_meeko_decorations/");
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'db_meeko_decorations');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die('Connection Error: ' . $conn->connect_error);
}
?>
