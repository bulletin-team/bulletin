<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Ad / Bulletin';
require('header.php');
$result = $db->query('SELECT ads.title, ads.pay, ads.time, ads.location, ads.description, users.name, users.email, users.phone, users.picture, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = ads.uid WHERE ads.id = '.$adid.' LIMIT 1') or fatal($db->error);
if ($result->num_rows < 1) fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
?>
      <div id="fulljob">
        <div id="fjheader">
          <h3 id="fjhtitle"><?=htmlentities($row['title']);?></h3>
          <p id="fjhpay">Pays <?=number_format($row['pay'], 2);?></p>
          <p id="fjhdetails"><?=date('g:i a', intval($row['time'])).' on '.date('M j, Y', intval($row['time']));?> at <?=htmlentities($row['location']);?></p>
        </div>
        <div id="fjbody">
          <p><?=htmlentities($row['description']);?></p>
        </div>
        <div id="fjfooter">
          <h4>Respond to this Ad</h4>
          <div id="fjfleft">
<?php
if (is_null($row['picture']))
  echo '            <img id="propic" src="uimg/default.png" alt="Profile Picture" />'.PHP_EOL;
else
  echo '            <img id="propic" src="uimg/'.intval($row['picture']).'.png" alt="Profile Picture" />'.PHP_EOL;
?>
            <p id="ename"><?=htmlentities($row['name']);?></p>
<?php
if (is_null($row['rating'))
  echo '            <p id="erating">Employer Not Rated</p>'.PHP_EOL;
else
  echo '            <p id="erating">'.intval($row['rating']).' Star Employer</p>'.PHP_EOL;
?>
          </div>
          <div id="fjfright">
            <p id="eemail"><a href="mailto:<?=htmlentities($row['email']);?>"><?=htmlentities($row['email']);?></a></p>
<?php
$phonelink = '+'.preg_replace('/[^0-9]/g', '', $row['phone']);
?>
            <p id="ephone"><a href="tel:<?=$phonelink;?>"><?=htmlentities($row['phone'];?></a></p>
            <p id="echat"><a href="#" onclick="bullechat.gui.create('<?=htmlentities($row['email'], ENT_HTML401 | ENT_QUOTES);?>'); return false;">Open a Chat</a></p>
          </div>
        </div>
      </div>
<?php
$result->free();
require('footer.php');
?>
