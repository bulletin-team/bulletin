<?php
require('dash_common.php');
$db = new bdb();

if (isset($_GET['clicks'])) {
  $clicks = max(0, intval($_GET['clicks']));
  $result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated GROUP BY ads.id LIMIT '.($clicks+$b_config['ads_per_page']).', 1') or die();
  if ($result->num_rows) {
    $row = $result->fetch_assoc();
    draw_ad($row);
  }
  $result->free();
} else if (isset($_GET['del'])) {
  $result = $db->query('SELECT ads.uid FROM responses INNER JOIN ads ON ads.id = responses.adid WHERE responses.id = '.intval($_GET['del']).' LIMIT 1') or die('ERR');
  if ($result->num_rows < 1 || $result->fetch_assoc()['uid'] != $b_user['id']) die('PERM');
  $result->free();
  $db->query('DELETE FROM responses WHERE id = '.intval($_GET['del'])) or die('ERR');
  if ($db->affected_rows < 1) die('NOK');
  die('OK');
} else if (isset($_GET['hire'])) {
  $result = $db->query('SELECT ads.uid FROM responses INNER JOIN ads ON ads.id = responses.adid WHERE responses.id = '.intval($_GET['hire']).' LIMIT 1') or die('ERR');
  if ($result->num_rows < 1 || $result->fetch_assoc()['uid'] != $b_user['id']) die('PERM');
  $result->free();
  $db->query('UPDATE responses, ads SET responses.matched = 1, ads.closed = 1 WHERE ads.id = responses.adid AND responses.id = '.intval($_GET['hire'])) or die('ERR');
  if ($db->affected_rows < 1) die('NOK');
  hire_trigger(intval($_GET['hire']));
  die('OK');
} else if (isset($_GET['rmad'])) {
  $db->query('DELETE FROM ads WHERE ads.id = '.intval($_GET['rmad']).' AND ads.uid = '.$b_user['id']) or die('ERR');
  if ($db->affected_rows < 1) die('NOK');
  die('OK');
} else if (isset($_GET['rate'])) {
  $uid = intval($_GET['rate']);
  $jid = intval($_GET['jid']);
  $val = intval($_GET['val']);
  if ($uid < 1 || $jid < 1 || $val < 1) die('NOK');
  $result = $db->query('SELECT ads.id FROM ads INNER JOIN responses ON responses.adid = ads.id AND responses.matched = 1 INNER JOIN users ON users.id = responses.uid LEFT JOIN ratings ON ratings.rated = users.id WHERE ads.id = '.$jid.' AND (ads.uid = '.$b_user['id'].' OR responses.uid = '.$b_user['id'].') AND NOT EXISTS (SELECT ratings.id FROM ratings WHERE ratings.rated = responses.uid AND ratings.job = ads.id AND ratings.rater = '.$b_user['id'].') GROUP BY responses.id LIMIT 1') or die('ERR');
  if ($result->num_rows < 1) die('NOK');
  $db->query('INSERT INTO ratings (rated, rater, job, stars) VALUES ('.$uid.', '.$b_user['id'].', '.$jid.', '.$val.')') or die('ERR');
  if ($db->affected_rows < 1) die('NOK');
  die('OK');
}
$db->close();
?>
