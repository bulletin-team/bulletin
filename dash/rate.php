<?php
define('HEIRARCHY', 1);
require('dash_common.php');

$title = 'Rate / Bulletin';
require('header.php');
if ($b_user['type'] == 'EMPLOYER') {
  $result = $db->query('SELECT users.id AS uid, users.name, ads.id AS adid, ads.title, ads.time, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN responses ON responses.adid = ads.id AND responses.matched = 1 INNER JOIN users ON users.id = responses.uid LEFT JOIN ratings ON ratings.rated = users.id WHERE ads.uid = '.$b_user['id'].' AND NOT EXISTS (SELECT ratings.id FROM ratings WHERE ratings.rated = responses.uid AND ratings.job = ads.id AND ratings.rater = '.$b_user['id'].') GROUP BY responses.id') or dash_fatal($db->error);
  if ($result->num_rows < 1) draw_norate_p();
} else if ($b_user['type'] == 'EMPLOYEE') {
  $result = $db->query('SELECT users.id AS uid, users.name, ads.id AS adid, ads.title, ads.time, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN responses ON responses.adid = ads.id AND responses.matched = 1 INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = users.id WHERE responses.uid = '.$b_user['id'].' AND NOT EXISTS (SELECT ratings.id FROM ratings WHERE ratings.rated = ads.uid AND ratings.job = ads.id AND ratings.rater = '.$b_user['id'].') GROUP BY responses.id') or dash_fatal($db->error);
  if ($result->num_rows < 1) draw_norate_s();
}
else dash_fatal('Only job seekers and job providers can rate one another.');

while ($row = $result->fetch_assoc()) {
  draw_rate($row);
}
$result->free();
?>

<?php
require('footer.php');
?>
