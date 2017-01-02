<?php
require('../inc/common.php');
require('dash_functions.php');
if ($b_user['id'] < 1) l_redirect('login.php');

define('ACC_TYPE', $b_user['type']);
require('nav.php');
?>
