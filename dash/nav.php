<?php
if (!defined('ACC_TYPE')) die;
if (ACC_TYPE == 'EMPLOYEE') {
  $navtitles = array('Dashboard', 'Help', 'My Jobs');
  $navlinks = array('dash/', 'dash/help.php', 'dash/jobs.php');
} else if (ACC_TYPE == 'EMPLOYER') {
  $navtitles = array('Dashboard', 'Help', 'My Jobs', 'Post');
  $navlinks = array('dash/', 'dash/help.php', 'dash/jobs.php', 'dash/post.php');
} else if (ACC_TYPE == 'ADMIN') {
  $navtitles = array();
  $navlinks = array();
} else die;
?>
