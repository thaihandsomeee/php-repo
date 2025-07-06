<?php
require_once 'db_config.php';
require_once 'User.php';

User::logout();

header('Location: index.php');
exit();
?>