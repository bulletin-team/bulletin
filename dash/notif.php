<?php
define('HEIRARCHY', 1);
require('dash_common.php');

$title = 'News / Bulletin';
$extra_head = '    <link rel="stylesheet" type="text/css" href="css/notif.css" />';
require('header.php');
$result = $db->query('SELECT notif.* FROM notif WHERE notif.uid = '.$b_user['id'].' ORDER BY id DESC') or dash_fatal($db->error);
$db->query('UPDATE notif SET notif.seen = 1 WHERE notif.uid = '.$b_user['id']) or dash_fatal($db->error);
?>
      <div class="box cbox">
        <div id="newshead">
          <h3><a href="notif.php">News</a></h3>
          <p>Updates for <?=htmlentities($b_user['name']);?></p>
        </div>
        <div class="hr"></div>
        <div id="newsbody">
<?php
if ($result->num_rows < 1) echo '          <p><em>No updates are available at this time.</em></p>'.PHP_EOL;
else {
  while ($row = $result->fetch_assoc()) {
    echo '          <p class="';
    if ($row['seen']) echo 'seen';
    else echo 'unseen';
    if (!is_null($row['icon'])) echo ' icon icon'.strtolower($row['icon']);
    echo '"><a href="'.$row['link'].'">'.htmlentities($row['text']).'</a></p>'.PHP_EOL;
  }
}
$result->free();
?>
        </div>
      </div>
<?php
require('footer.php');
?>
