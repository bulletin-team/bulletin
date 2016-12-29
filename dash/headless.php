<?php
$clicks = 0;
if (!empty($_GET['clicks'])) $clicks = max(0, intval($_GET['clicks']));
require('dash_common.php');
$db = new bdb();
$result = $db->query('SELECT ads.*, categories.cat_name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads LEFT JOIN categories ON ads.cat = categories.id LEFT JOIN ratings ON ads.uid = ratings.rated GROUP BY ads.id LIMIT '.($clicks+10).', 1') or die();
if ($result->num_rows) {
  $row = $result->fetch_assoc();
?>
      <div class="job">
        <a href="#" class="jobxbtn"></a>
        <p class="jobtitle"><a href="ads.php?id=<?=$row['id'];?>"><?=htmlentities($row['title']);?></a></p>
        <p class="joblocation"><?=htmlentities($row['location']);?></p>
<?php
  if (is_null($row['rating']))
    echo '        <p class="jobstars">Employer Not Rated</p>'.PHP_EOL;
  else
    echo '        <p class="jobstars">'.$row['rating'].' Star Employer</p>'.PHP_EOL;
?>
        <p class="jobpay">Pays $<?=number_format($row['pay'], 2);?></p>
        <p class="jobblurb"><?=htmlentities(substr($row['description'], 0, min(strlen($row['description']), 160)));?> <a href="ads.php?id=<?=$row['id'];?>">[...]</a></p>
        </p>

      </div>
<?php
}
$result->free();
$db->close();
?>
