<?php
define('INCLUDE_PATH', dirname(__FILE__).'/');
error_reporting(E_ERROR | E_PARSE);
require(INCLUDE_PATH . 'config.php');
require(INCLUDE_PATH . 'functions.php');
//require(INCLUDE_PATH . 'mobile.php');
require(INCLUDE_PATH . 'db.php');
require(INCLUDE_PATH . 'user.php');
require(INCLUDE_PATH . 'mailgun/autoload.php');
?>
