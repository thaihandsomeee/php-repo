<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'product_manager_db');
define('DB_USER', 'root');
define('DB_PASS', '');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>