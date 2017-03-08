<?php
if (!defined('HEIRARCHY')) die;
$title = 'Dashboard / Bulletin';
$extra_head = '   <link rel="stylesheet" type="text/css" href="css/employer.css" />';
require('header.php');
$result = $db->query('SELECT ads.id, ads.title FROM ads WHERE ads.uid = '.$b_user['id'].' AND ads.closed = 0') or dash_fatal('A problem was encountered loading your posted ads.');
$view = intval(@$_GET['view']);
?>
      <form id="viewform" action="/dash/" method="get">
        <p>Show Me: <select id="viewchanger" name="view" onchange="this.form.submit();">
          <option<?php if ($view == 0) echo ' selected="selected"';?> value="0">Jobs Posted</option>
          <optgroup label="Applications For">
<?php
if ($result->num_rows < 1) echo '            <option value="0">No Ads Posted</option>'.PHP_EOL;
else {
  while ($row = $result->fetch_assoc()) echo '            <option'.(($view==$row['id'])?' selected="selected"':'').' value="'.$row['id'].'">'.htmlentities($row['title']).'</option>'.PHP_EOL;
}
$result->free();
?>
          </optgroup>
        </select></p>
      </form>
<?php
if ($view == 0) {
  $result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated WHERE ads.uid = '.$b_user['id'].' AND ads.closed = 0 GROUP BY ads.id LIMIT 0, '.$b_config['ads_per_page']) or fatal($db->error);
  if ($result->num_rows < 1) draw_noads();
  while ($row = $result->fetch_assoc()) draw_ad($row);
  $result->free();
} else {
  $result = $db->query('SELECT responses.id, responses.comment, users.name, users.address, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM responses INNER JOIN users ON responses.uid = users.id LEFT JOIN ratings ON ratings.rated = responses.uid WHERE responses.adid = '.$view) or dash_fatal($db->error);
  if ($result->num_rows < 1) draw_noapps();
  while ($row = $result->fetch_assoc()) draw_app($row);
  $result->free();
}
require('footer.php');
?>
