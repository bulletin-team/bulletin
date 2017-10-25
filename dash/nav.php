<?php
if (!defined('ACC_TYPE')) die;
if (ACC_TYPE == 'EMPLOYEE') {
  $navtitles = array('Dashboard', 'My Jobs');
  $navlinks = array('dash/', 'dash/jobs.php');
} else if (ACC_TYPE == 'EMPLOYER') {
  $navtitles = array('Dashboard', 'My Jobs', 'Post');
  $navlinks = array('dash/', 'dash/jobs.php', 'dash/post.php');
} else if (ACC_TYPE == 'ADMIN') {
  $navtitles = array();
  $navlinks = array();
} else die;
?>
