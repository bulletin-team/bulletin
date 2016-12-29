<?php
if (!defined('HEIRARCHY')) die;
$title = 'Dashboard / Bulletin';
require('header.php');
$page = 1;
if (!empty($_GET['p'])) $page = max(1, intval($_GET['p']));
$result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated GROUP BY ads.id LIMIT ' . 10*($page-1) . ', 10') or fatal($db->error);
while ($row = $result->fetch_assoc()) {
?>
      <div class="job">
        <a href="#" class="jobxbtn"></a>
        <p class="jobtitle"><a href="ads.php?id=<?=$row['id'];?>"><?=htmlentities($row['title']);?></a></p>
<?php
  if (is_null($row['cat_name']))
    echo '        <p class="jobcat">Uncategorized</p>'.PHP_EOL;
  else
    echo '        <p class="jobcat">'.htmlentities($row['cat_name']).'</p>'.PHP_EOL;
?>
        <p class="joblocation"><?=htmlentities($row['location']);?></p>
<?php
  if (is_null($row['rating']))
    echo '        <p class="jobstars">Employer Not Rated</p>'.PHP_EOL;
  else
    echo '        <p class="jobstars">'.intval($row['rating']).' Star Employer</p>'.PHP_EOL;
?>
        <p class="jobpay">Pays $<?=number_format($row['pay'], 2);?></p>
        <p class="jobblurb"><?=htmlentities(substr($row['description'], 0, min(strlen($row['description']), 160)));?> <a href="ads.php?id=<?=$row['id'];?>">[...]</a></p>
        </p>
      </div>
<?php
}
$result->free();
require('footer.php');
?>
