<?php
if (!defined('HEIRARCHY')) die;
$title = 'Dashboard / Bulletin';
require('header.php');
$page = 1;
// if (!empty($_GET['p'])) $page = max(1, intval($_GET['p']));
$result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated GROUP BY ads.id LIMIT ' . $b_config['ads_per_page']*($page-1) . ', '.$b_config['ads_per_page']) or fatal($db->error);
while ($row = $result->fetch_assoc()) draw_ad($row);
$result->free();
require('footer.php');
?>
