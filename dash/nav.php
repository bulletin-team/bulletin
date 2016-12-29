<?php
if (!defined('ACC_TYPE')) die;
if (ACC_TYPE == 'EMPLOYEE') {
  $navtitles = array('Dashboard', 'Help');
  $navlinks = array('dash/', 'dash/help.php');
} else if (ACC_TYPE == 'EMPLOYER') {
  $navtitles = array('Dashboard', 'Post an Ad', 'Help');
  $navlinks = array('dash/', 'dash/post.php', 'dash/help.php');
} else if (ACC_TYPE == 'ADMIN') {
  $navtitles = array();
  $navlinks = array();
} else die;
?>
