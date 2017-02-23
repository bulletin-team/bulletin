<?php
function dash_fatal ($msg = null, $link = null, $label = null) {
  if ($link === null) $link = 'javascript:history.go(-1);';
  if ($label == null) $label = '&larr; Got It';
  echo tpl(array('message' => $msg, 'link' => $link, 'label' => $label), 'dash_fatal.tpl').PHP_EOL;
  require('footer.php');
  die;
}
function typestr ($type) {
  switch ($type) {
    case 'EMPLOYER':
      return 'Employer';
    case 'EMPLOYEE':
      return 'Employee';
    default:
      return 'Team Member';
  }
}
function rating_format ($rating = null, $typestr = 'Employer') {
  if (is_null($rating)) return $typestr.' Not Rated';
  return number_format($rating, 1).' Star '.$typestr;
}
function draw_noads () {
?>
      <div class="job">
        <a href="#" class="jobxbtn"></a>
        <p class="jobtitle"><a href="post.php">Post an Ad!</a></p>
        <p class="jobpay">Costs $5.00</p>
        <p class="jobblurb">You haven't posted any ads yet! It's a quick and easy way to get connected to the workers you need.<br /><a href="post.php">Post an ad!</a></p>
      </div>
<?php
}
function draw_ad ($row) {
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
    echo '        <p class="jobstars">'.$row['rating'].' Star Employer</p>'.PHP_EOL;
?>
        <p class="jobpay">Pays $<?=number_format($row['pay'], 2);?></p>
        <p class="jobblurb"><?=htmlentities(substr($row['description'], 0, min(strlen($row['description']), 160)));?> <a href="ads.php?id=<?=$row['id'];?>">[...]</a></p>
        </p>
      </div>
<?php
}

// triggers
function app_trigger ($responseid) {
  global $db;  

  $result = $db->query('SELECT responses.id, responses.uid AS seeker, responses.adid, responses.comment, ads.title, users.name, users.email FROM responses INNER JOIN ads ON responses.adid = ads.id INNER JOIN users ON ads.uid = users.id WHERE responses.id = '.$responseid.' LIMIT 1') or dash_fatal($db->error);
  if ($result->num_rows < 1) dash_fatal('The ad you\'ve tried to apply to no longer exists.');
  $appinfo = $result->fetch_assoc();
  $result->free();
  $result = $db->query('SELECT users.name, users.email, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM users LEFT JOIN ratings ON ratings.rated = users.id') or dash_fatal($db->error);
  $uinfo = $result->fetch_assoc();
  $result->free();
  $options = array(
    'rid' => $appinfo['id'],
    'adname' => $appinfo['title'],
    'seekername' => $appinfo['name'],
    'seekerrating' => is_null($uinfo['rating']) ? 'has yet to be rated' : 'is rated '.number_format($uinfo['rating'], 1).' stars',
    'seekereml' => $uinfo['email'],
    'seekerid' => $appinfo['seeker'],
  );
  mail($appinfo['email'], '"'.$appinfo['title'].'" Has Received a Response', tpl($options, 'app_eml.tpl'), "From: ".$b_config['mail_from']."\r\nContent-type: text/html");
}
?>
