<?php
if (!defined('HEIRARCHY')) die;
$title = 'Dashboard / Bulletin';
require('header.php');
$result = $db->query('SELECT id, cat_name FROM categories') or dash_fatal($db->error);
?>
      <form id="viewform" action="/dash/" method="get">
        <p>Show Me: <select id="catchanger" name="cat" onchange="this.form.submit();">
          <option<?php if (empty($_GET['cat'])) echo ' selected="selected"';?> value="0">All Categories</option>
<?php
while ($row = $result->fetch_assoc()) echo '          <option'.((intval($_GET['cat'])==$row['id'])?' selected="selected"':'').' value="'.$row['id'].'">'.htmlentities($row['cat_name']).'</option>'.PHP_EOL;
$result->free();
?>
        </select></p>
      </form>
<?php
$catstr = empty($_GET['cat']) ? '' : ' AND cat = '.intval($_GET['cat']);
$result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated WHERE ads.closed = 0'.$catstr.' GROUP BY ads.id ORDER BY ads.id DESC LIMIT 0, '.$b_config['ads_per_page']) or fatal($db->error);
while ($row = $result->fetch_assoc()) draw_ad($row);
$result->free();
require('footer.php');
?>
