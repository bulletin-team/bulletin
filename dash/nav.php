<?php
if (!defined('ACC_TYPE')) die;
if (ACC_TYPE == 'EMPLOYEE') {
  $navtitles = array('Dashboard', 'Help', 'Rate');
  $navlinks = array('dash/', 'dash/help.php', 'dash/rate.php');
} else if (ACC_TYPE == 'EMPLOYER') {
  $navtitles = array('Dashboard', 'Help', 'Rate', 'Post');
  $navlinks = array('dash/', 'dash/help.php', 'dash/rate.php', 'dash/post.php');
} else if (ACC_TYPE == 'ADMIN') {
  $navtitles = array();
  $navlinks = array();
} else die;
?>
