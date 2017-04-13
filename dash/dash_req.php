<?php
if (!defined('ACC_TYPE')) die;
if ((is_null($b_user['picture']) || is_null($b_user['address'])) && $_SERVER['SCRIPT_NAME'] != '/dash/profile.php') {
  l_redirect('dash/profile.php');
}
?>
