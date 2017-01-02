<?php
$clicks = 0;
if (!empty($_GET['clicks'])) $clicks = max(0, intval($_GET['clicks']));
require('dash_common.php');
$db = new bdb();
$result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated GROUP BY ads.id LIMIT '.($clicks+$b_config['ads_per_page']).', 1') or die();
if ($result->num_rows) {
  $row = $result->fetch_assoc();
  draw_ad($row);
}
$result->free();
$db->close();
?>
