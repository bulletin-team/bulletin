<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$public = intval($_GET['id']) > 0;
$title = 'Profile / Bulletin';
$extra_head = '    <link rel="stylesheet" type="text/css" href="css/profile.css" />'.PHP_EOL;
if (!$public) $extra_head .= '    <script type="text/javascript" src="js/profile.js"></script>'.PHP_EOL;
require('header.php');
$user = $b_user;
if ($public) {
  $result = $db->query('SELECT users.*, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM users LEFT JOIN ratings ON ratings.rated = users.id WHERE users.id = '.intval($_GET['id']).' AND users.active = 1 GROUP BY users.id LIMIT 1') or dash_fatal($db->error);
  $user = $result->fetch_assoc();
  $result->free();
  if ($user['id'] < 1) dash_fatal('A user with that ID does not exist. You must have reached this page in error.');
?>
      <div id="profile" class="public">
        <div id="proheader">
          <h3 id="protitle"><a href="<?=$_SERVER['REQUEST_URI'];?>"><?=htmlentities($user['name']);?></a></h3>
          <p id="prostars"><?=rating_format($user['rating'], typestr($user['type']));?></p>
        </div>
        <div id="proleft">
          <div id="propic">
            <img src="<?=picture_format($user['picture']);?>" alt="Profile Picture" />
          </div>
        </div>
        <div id="proright">
          <div id="probody">
            <h4>Bio</h4>
            <p><?=(is_null($user['bio']) ? '<em>No bio included in profile.</em>' : htmlentities($user['bio'])); ?></p>
          </div>
          <br />
          <div id="profoot">
            <h4>Personal Information</h4>
            <p>Email: <a href="mailto:<?=htmlentities($user['email']);?>"><?=htmlentities($user['email']);?></a></p>
<?php
$phonelink = '+'.preg_replace('/[^0-9]/', '', $user['phone']);
?>
            <p>Phone: <a href="tel:<?=$phonelink;?>"><?=htmlentities($user['phone']);?></a></p>
            <br />
            <h4>Address</h4>
            <p><?=(is_null($user['address']) ? '<em>No address specified.</em>' : htmlentities($user['address']));?></p>
            <p>Zipcode: <?=htmlentities($user['zipcode']);?></p>
            <br />
            <h4>Chat</h4>
            <p><a href="#" onclick="bullechat.gui.create('<?=htmlentities($user['email'], ENT_HTML401 | ENT_QUOTES).'\', \''.htmlentities($user['name'], ENT_HTML401 | ENT_QUOTES);?>'); return false;">Open a Chat</a></p>
          </div>
        </div>
        <div id="proreviews">
          <h3>Past Reviews</h3>
<?php
$result = $db->query('SELECT ratings.stars, ratings.comment, users.id AS uid, users.name, users.picture, ads.id AS adid, ads.title FROM ratings INNER JOIN users ON users.id = ratings.rater INNER JOIN ads ON ads.id = ratings.job WHERE ratings.rated = '.$user['id']) or dash_fatal($db->error);
echo '          <p>Based on <strong>'.$result->num_rows.'</strong> jobs completed.';
if ($result->num_rows < 1) echo '          <p><em>This user has never been reviewed.</em></p>';
while ($row = $result->fetch_assoc()) {
?>
          <div class="review">
            <div class="reviewleft">
              <p class="revname"><a href="profile.php?id=<?=$row['uid'];?>"><?=htmlentities($row['name']);?></a></p>
              <p class="revpic"><img src="uimg/<?=is_null($row['picture']) ? 'default.png' : intval($row['picture']).'.png';?>" alt="Profile Picture" /></p>
              <p class="revjob">Based on <a href="ads.php?id=<?=$row['adid'];?>"><?=htmlentities($row['title']);?></a></p>
            </div>
            <div class="reviewright">
              <p class="revstars"><?=rating_format($row['stars'], ' Review');?></p>
              <p class="comment"><?=is_null($row['comment']) ? '<em>No comment provided.</em>' : htmlentities($row['comment']);?></p>
            </div>
          </div>
<?php
}
$result->free();
?>
        </div>
      </div>
<?php
} else if (!empty($_POST['chprofile'])) {
  $bio = empty($_POST['bio']) ? 'NULL' : '\''.$db->escape_string($_POST['bio']).'\'';
  $addr = empty($_POST['address']) ? 'NULL' : '\''.$db->escape_string($_POST['address']).'\'';
  $patterns = array(
    'email' => '/^.+@.+\..+$/',
    'zip' => '/^\d{5}([-\s]\d{4})?$/',
    'phone' => '/\+?\d{1,3}\s*\(?\d{3}\)?\s*\d{3}([-\s]*)\d{4}$/',
  );
  $pkeys = array_keys($patterns);
  foreach ($pkeys as $pkey) {
    if (!preg_match($patterns[$pkey], $_POST[$pkey])) dash_fatal('Invalid field values have been entered.');
  }
  $deactivate = '';
  $usepropic = '';
  if ($_POST['email'] != $b_user['email']) {
    $session = uniqid('ch', true);
    $deactivate = ', session = \''.bulletin_hash($session).'\', active = 0';
    bulletin_mail($_POST['email'], 'Verify Your Bulletin Email', tpl(array(
      'activation_vars' => 'uid='.$b_user['id'].'&key='.$session,
    ), 'changed.tpl')) or dash_fatal('We couldn\'t send mail to your new email address, so your profile has not been updated.');
  }
  if (!empty($_FILES['picture']['tmp_name'])) {
    $usepropic = ', picture = id';
    $tmpfile = $_FILES['picture']['tmp_name'];
    if (getimagesize($tmpfile) === false) dash_fatal('Your uploaded file is not an image.');
    @$img = imagecreatefromstring(file_get_contents($tmpfile));
    @imagepng($img, 'uimg/'.$b_user['id'].'.png');
    @imagedestroy($img);
  }
  $db->query('UPDATE users SET email = \''.$db->escape_string($_POST['email']).'\', zipcode = \''.$db->escape_string($_POST['zip']).'\', phone = \''.$db->escape_string($_POST['phone']).'\', address = '.$addr.', bio = '.$bio.$usepropic.$deactivate.' WHERE id = '.$b_user['id']) or dash_fatal($db->error);
  dash_fatal('Your profile has been updated. If you have changed your email, you will need to verify it before returning to Bulletin.', $b_config['base_url'].'dash/profile.php');
} else {
?>
      <div id="profile" class="private">
        <div id="proheader">
          <h3 id="protitle"><a href="<?=$_SERVER['REQUEST_URI'];?>"><?=htmlentities($user['name']);?></a></h3>
          <p id="prostars"><?=rating_format($user['rating'], typestr($user['type']));?></p>
        </div>
<?php
  if (is_null($b_user['picture']) || is_null($b_user['address']))
    echo '        <p id="prowarning">For safety reasons, you will have to complete your profile before you can access the rest of Bulletin.</p>'.PHP_EOL;
?>
        <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
          <div id="proleft">
            <h4>Profile Picture</h4>
            <div id="propic">
<?php
  if (is_null($user['picture']))
    echo '              <img src="uimg/default.png" alt="Profile Picture" />'.PHP_EOL;
  else
    echo '              <img src="uimg/'.$user['picture'].'.png" alt="Profile Picture" />'.PHP_EOL;
?>
              <p id="hoverupload">Upload New</p>
            </div>
            <p class="hidden"><input id="chpic" type="file" name="picture" type="image/*" value="Upload New" /></p>
          </div>
          <div id="proright">
            <div id="probody">
              <h4>Include a Bio</h4>
<?php
  if ($b_user['type'] == 'EMPLOYEE') $bphtxt = 'Type a bio (optional). Include your qualifications, work experience, certifications, etc.';
  else if ($b_user['type'] == 'EMPLOYER') $bphtxt = 'Type a bio (optional). Let your workers get to know you a little bit.';
  else $bphtxt = 'Type a bio (optional).';
?>
              <p><textarea id="inpbio" name="bio" placeholder="<?=htmlentities($bphtxt);?>"><?=htmlentities($user['bio']);?></textarea></p>
            </div>
            <div id="profoot">
              <h4>Basic Information</h4>
              <p><input id="inpemail" name="email" type="text" value="<?=htmlentities($user['email']);?>" placeholder="Email" /></p>
              <p><input id="inpphone" name="phone" type="text" value="<?=htmlentities($user['phone']);?>" placeholder="1 (555) 481-4475" /></p>
              <p><input id="inpzip" name="zip" type="text" value="<?=htmlentities($user['zipcode']);?>" placeholder="Zipcode" /></p>
              <p><input id="inpaddr" name="address" type="text" value="<?=htmlentities($user['address']);?>" placeholder="Address" /></p>
              <p><input id="inpchprof" name="chprofile" type="submit" value="Update Profile" /></p>
            </div>
          </div>
        </form>
      </div>
<?php
}
require('footer.php');
?>
