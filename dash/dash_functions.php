<?php
function dash_fatal ($msg = null, $link = null, $label = null) {
  if ($link === null) $link = 'javascript:history.go(-1);';
  if ($label == null) $label = '&larr; Got It';
  echo tpl(array('message' => $msg, 'link' => $link, 'label' => $label), 'dash_fatal.tpl').PHP_EOL;
  require('footer.php');
  die;
}
?>
