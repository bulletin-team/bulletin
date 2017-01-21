<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Apply / Bulletin';
require('header.php');
if (!empty($_POST['apply'])) {
  $result = $db->query('SELECT id FROM responses WHERE adid = '.$adid.' AND uid = '.$b_user['id'].' LIMIT 1') or dash_fatal($db->error);
  if ($result->num_rows > 0) {
    $result->free();
    dash_fatal('You have already applied to this ad!', $b_config['base_url'].'dash/');
  }
  $db->query('INSERT INTO responses (adid, uid, comment) VALUES ('.$adid.', '.$b_user['id'].', \''.$db->escape_string($_POST['comments']).'\')') or dash_fatal($db->error);
  dash_fatal('Your application has been submitted.', $b_config['base_url'].'dash/');
}

$result = $db->query('SELECT ads.id, ads.title, ads.pay, ads.time, ads.location, ads.description, users.name, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = ads.uid WHERE ads.id = '.$adid.' LIMIT 1') or dash_fatal($db->error);
if ($result->num_rows < 1) dash_fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
?>
      <div id="fulljob" class="fjsettings">
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
<?php
if (is_null($row['rating']))
  echo '            <p id="erating">Employer Not Rated</p>'.PHP_EOL;
else
  echo '            <p id="erating">'.intval($row['rating']).' Star Employer</p>'.PHP_EOL;
?>
          </div>
          <div id="fjfright">
            <form id="cform" action="<?=htmlentities($_SERVER['REQUEST_URI']);?>" method="post">
              <h4>Comments (Optional)</h4>
              <p><textarea name="comments"></textarea></p>
              <p><input id="inpapply" type="submit" name="apply" value="Apply to Ad" /></p>
            </form>
          </div>
        </div>
      </div>
<?php
$result->free();
require('footer.php');
?>
