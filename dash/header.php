<?php
if (!defined('HEIRARCHY')) die;
$db = new bdb();
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=htmlentities($title); ?></title>
    <meta charset="UTF-8" />
    <meta name="description" content="Community, at your fingertips." />
    <link rel="stylesheet" type="text/css" href="css/dash.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/dash.js"></script>
 <?php
if (!empty($extra_head)) echo $extra_head;
?>
    <link rel="stylesheet" type="text/css" href="../css/chat.css" />
    <script type="text/javascript" src="../js/auth.php"></script>
    <script type="text/javascript" src="../js/chat.js"></script>
 </head>
  <body>
    <div id="nav">
      <a id="navhome" href="<?=$b_config['base_url'];?>">
        <div id="navlogo"></div>
      </a>
      <div id="navlinks">
        <div id="sep"></div>
<?php
foreach ($navtitles as $k => $title) {
  $link = $navlinks[$k];
  $test = '/'.$link;
  $selected = ($_SERVER['SCRIPT_NAME'] == $test || $_SERVER['REQUEST_URI'] == $test);
?>
        <a<?=$selected?' class="selected"':'';?> href="<?=htmlentities($b_config['base_url'].$link);?>">
          <span class="navspan"><?=htmlentities($title);?></span>
        </a>
<?php
}
?>
        <div class="spacer"></div>
        <div class="navblock">
          <a href="<?=$b_config['base_url'].'dash/profile.php';?>">
            <span class="navspan"><?=htmlentities($b_user['name']);?>&nbsp;&#x25be;</span>
          </a>
          <ul class="subnav">
            <a href="<?=$b_config['base_url'].'dash/notif.php';?>">
              <li><span class="navspan">News<?=$b_user['notif']>0?' ('.$b_user['notif'].')':'';?></span></li>
            </a>
            <a href="<?=$b_config['base_url'].'dash/settings.php';?>">
              <li><span class="navspan">Settings</span></li>
            </a>
            <a href="<?=$b_config['base_url'].'logout.php';?>">
              <li><span class="navspan">Log Out</span></li>
            </a>
          </ul>
        </div>
      </div>
    </div>
    <div id="content">
