<?php

error_reporting(E_ALL);
ini_set('display_errors', 'ON');

session_start();

session_unset();

session_destroy();

require_once('../configuration.php');

header("Location: $root_url");

?>