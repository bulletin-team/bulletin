<?php
header('Content-type: text/javascript');
require('../inc/common.php');
?>
var auth = {
<?php
  if ($b_user['id'] > 0) {
?>
  id: '<?=intval($b_user['id']); ?>',
  session: '<?=addslashes($b_user['session']); ?>',
<?php
  }
?>
};
