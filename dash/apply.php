<?php
define('HEIRARCHY', 1);

require('dash_common.php');
if ($b_user['type'] != 'EMPLOYEE') fatal('Only job seeker accounts are allowed to apply to ads. Sorry for the inconvenience.');

$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Apply / Bulletin';
require('header.php');
if (!empty($_POST['apply'])) {
  $result = $db->query('SELECT id FROM responses WHERE adid = '.$adid.' AND (uid = '.$b_user['id'].' OR matched = 1) LIMIT 1') or dash_fatal($db->error);
  if ($result->num_rows > 0) {
    $result->free();
    dash_fatal('You have already applied to this ad or the provider has already selected someone for the task!', $b_config['base_url'].'dash/');
  }
  $result->free();
  $db->query('INSERT INTO responses (adid, uid, comment) VALUES ('.$adid.', '.$b_user['id'].', \''.$db->escape_string($_POST['comments']).'\')') or dash_fatal($db->error);
  app_trigger($db->insert_id);
  dash_fatal('Your application has been submitted.', $b_config['base_url'].'dash/');
}

$result = $db->query('SELECT ads.id, ads.title, ads.pay, ads.time, ads.location, ads.description, users.name, users.picture, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM ads INNER JOIN users ON users.id = ads.uid LEFT JOIN ratings ON ratings.rated = ads.uid WHERE ads.id = '.$adid.' GROUP BY ads.id LIMIT 1') or dash_fatal($db->error);
if ($result->num_rows < 1) dash_fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
$result->free();
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
            <img id="propic" src="<?=picture_format($row['picture']);?>" alt="Profile Picture" />
            <p id="ename"><?=htmlentities($row['name']);?></p>
            <p id="erating"><?=rating_format($row['rating']);?></p>
          </div>
          <div id="fjfright">
            <form id="cform" action="<?=htmlentities($_SERVER['REQUEST_URI']);?>" method="post">
              <h4>Comments (Optional)</h4>
              <p><textarea name="comments" placeholder="This could relate to your specific qualifications, convenience, etc."></textarea></p>
              <p><input id="inpapply" type="submit" name="apply" value="Apply to Ad" /></p>
            </form>
          </div>
        </div>
      </div>
<?php
require('footer.php');
?>
