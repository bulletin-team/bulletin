<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Ad / Bulletin';
require('header.php');
$result = $db->query('SELECT ads.id, ads.uid, ads.title, ads.pay, ads.time, ads.location, ads.description, ads.closed, categories.cat_name, users.name, users.email, users.phone, users.picture, users.bio, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = ads.uid LEFT JOIN categories ON categories.id = ads.cat WHERE ads.id = '.$adid.' GROUP BY ads.id LIMIT 1') or dash_fatal($db->error);
if ($result->num_rows < 1) dash_fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
$result->free();
?>
      <div id="fulljob">
<?php
if ($b_user['type'] == 'EMPLOYER' && $b_user['id'] == $row['uid']) echo '        <a href="#" class="adtrash" data-adid="'.$row['id'].'"></a>'.PHP_EOL;
?>
        <div id="fjheader">
          <h3 id="fjhtitle"><a href="ads.php?id=<?=$row['id'];?>"><?=htmlentities($row['title']);?></a></h3>
          <p id="fjhcat"><?=is_null($row['cat_name']) ? 'Uncategorized' : htmlentities($row['cat_name']);?></p>
        </div>
        <div id="fjfooter">
          <div id="fjfleft">
<?php
if (is_null($row['picture']))
  echo '            <img id="propic" src="uimg/default.png" alt="Profile Picture" />'.PHP_EOL;
else
  echo '            <img id="propic" src="uimg/'.intval($row['picture']).'.png" alt="Profile Picture" />'.PHP_EOL;
?>
            <p id="ename"><a href="profile.php?id=<?=$row['uid'];?>"><?=htmlentities($row['name']);?></a></p>
            <p id="erating"><?=rating_format($row['rating']);?></p>
            <h4>Contact Information</h4>
            <p id="eemail"><a href="mailto:<?=htmlentities($row['email']);?>"><?=htmlentities($row['email']);?></a></p>
<?php
$phonelink = '+'.preg_replace('/[^0-9]/', '', $row['phone']);
?>
            <p id="ephone"><a href="tel:<?=$phonelink;?>"><?=htmlentities($row['phone']);?></a></p>
            <p id="echat"><a href="#" onclick="bullechat.gui.create('<?=htmlentities($row['email'], ENT_HTML401 | ENT_QUOTES);?>'); return false;">Open a Chat</a></p>
          </div>
          <div id="fjfright">
            <h4>Job Details</h4>
            <p id="fjhpay">Pays $<?=number_format($row['pay'], 2);?></p>
            <p id="fjhdetails"><?=htmlentities($row['location']);?></p>
            <p id="fjhtime"><?=date('g:i a', intval($row['time'])).' on '.date('M j, Y', intval($row['time']));?></p>
          </div>
        </div>
        <div id="fjdesc">
          <h4>Job Description</h4>
          <p><?=htmlentities($row['description']);?></p>
        </div>
<?php
if ($b_user['type'] == 'EMPLOYEE' && !$row['closed']) {
?>
        <p id="eapply"><a href="apply.php?id=<?=intval($row['id']);?>">Apply Now</a></p>
<?php
}
?>

      </div>
<?php
require('footer.php');
?>
