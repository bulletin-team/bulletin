<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Ad / Bulletin';
require('header.php');
$result = $db->query('SELECT ads.id, ads.title, ads.pay, ads.time, ads.location, ads.description, users.name, users.email, users.phone, users.picture, users.bio, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = ads.uid WHERE ads.id = '.$adid.' LIMIT 1') or dash_fatal($db->error);
if ($result->num_rows < 1) dash_fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
$result->free();
?>
      <div id="fulljob">
        <div id="fjheader">
          <h3 id="fjhtitle"><?=htmlentities($row['title']);?></h3>
          <p id="fjhpay">Pays $<?=number_format($row['pay'], 2);?></p>
          <p id="fjhdetails"><?=htmlentities($row['location']);?> at <?=date('g:i a', intval($row['time'])).' on '.date('M j, Y', intval($row['time']));?></p>
        </div>
        <div id="fjbody">
          <p><?=htmlentities($row['description']);?></p>
        </div>
        <div id="fjfooter">
          <div id="fjfleft">
<?php
if (is_null($row['picture']))
  echo '            <img id="propic" src="uimg/default.png" alt="Profile Picture" />'.PHP_EOL;
else
  echo '            <img id="propic" src="uimg/'.intval($row['picture']).'.png" alt="Profile Picture" />'.PHP_EOL;
?>
            <p id="ename"><?=htmlentities($row['name']);?></p>
            <p id="erating"><?=rating_format($row['rating']);?></p>
          </div>
          <div id="fjfright">
            <p id="ebio"><?=(is_null($row['bio']) ? '<em>No bio included in profile.</em>' : htmlentities($row['bio']));?></p>
            <h4>Respond to this Ad</h4>
            <p id="eapply"><a href="apply.php?id=<?=intval($row['id']);?>">Apply Now</a></p>
            <h4>Contact the Employer</h4>
            <p id="eemail"><a href="mailto:<?=htmlentities($row['email']);?>"><?=htmlentities($row['email']);?></a></p>
<?php
$phonelink = '+'.preg_replace('/[^0-9]/', '', $row['phone']);
?>
            <p id="ephone"><a href="tel:<?=$phonelink;?>"><?=htmlentities($row['phone']);?></a></p>
            <p id="echat"><a href="#" onclick="bullechat.gui.create('<?=htmlentities($row['email'], ENT_HTML401 | ENT_QUOTES);?>'); return false;">Open a Chat</a></p>
          </div>
        </div>
      </div>
<?php
require('footer.php');
?>
