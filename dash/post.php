<?php
define('HEIRARCHY', 1);
require('dash_common.php');
if ($b_user['type'] != 'EMPLOYER') fatal('Only job provider accounts are permitted to post ads.');

$title = 'Post an Ad / Bulletin';
$extra_head = '  <link rel="stylesheet" type="text/css" href="css/post.css" />';
require('header.php');
do {
  if (!empty($_POST['post'])) {
    $patterns = array(
      'title' => '/^.+$/',
      'category' => '/^\d*$/',
      'description' => '/^.+$/',
      'pay' => '/^(\d+|\d+\.\d+|\.\d+)$/',
      'time' => '/^\d{4}\-\d{2}\-\d{2}T\d{2}:\d{2}$/',
      'location' => '/^.+$/',
    );
    foreach ($patterns as $pkey => $pattern) {
      if (!preg_match($pattern, $_POST[$pkey])) {
        $err = 'One or more fields have been omitted. All fields are required in order to post an ad.';
        break;
      }
    }
    $stmt = $db->prepare('INSERT INTO ads (uid, title, cat, pay, time, location, description) VALUES (?, ?, ?, ?, ?, ?, ?)') or dash_fatal($db->error);
    $stmt->bind_param('isidiss', $b_user['id'], $_POST['title'], $_POST['category'], $_POST['pay'], strtotime($_POST['time']), $_POST['location'], $_POST['description']);
    $stmt->execute();
    if ($stmt->affected_rows < 1) dash_fatal('Your ad was unable to be posted.');
    dash_fatal('Your ad has been posted.', $b_config['base_url'].'dash/ads.php?id='.$stmt->insert_id);
  }
} while (false);
$result = $db->query('SELECT id, cat_name FROM categories') or dash_fatal($db->error);
?>
      <div class="box cbox">
        <h3><a href="/dash/post.php">Post an Ad</a></h3>
        <div class="hr"></div>
        <form id="postform" action="/dash/post.php" method="post">
          <div id="pfpt1">
            <p><input id="inptitle" type="text" name="title" placeholder="Title Your Ad" value="<?=htmlentities($_POST['title']);?>" /></p>
            <p>
              <select id="inpcat" name="category">
                <option value="0"<?=empty($_POST['category']) ? ' selected="selected"':'';?>>Uncategorized</option>
<?php
while ($row = $result->fetch_assoc())
  echo '                <option'.($row['id']==$_POST['category']?' selected="selected"':'').' value="'.$row['id'].'">'.htmlentities($row['cat_name']).'</option>'.PHP_EOL;
$result->free();
?>
              </select>
            </p>
            <p><textarea id="inpdesc" name="description" placeholder="Write a brief job description..."><?=htmlentities($_POST['description']);?></textarea></p>
          </div>
          <div class="hr"></div>
          <div id="pfpt2">
            <p>Pays $<input id="inppay" type="number" name="pay" value="0.00" min="0" step="0.01" value="<?=htmlentities($_POST['pay']);?>" /></p>
            <p>Takes place on... <input id="inptime" type="datetime-local" name="time" value="<?=htmlentities($_POST['time']);?>" /></p>
            <p>At... <input id="inplocation" type="text" name="location" placeholder="1234 Main St" value="<?=htmlentities($_POST['location']);?>" /></p>
          </div>
<?php
if (isset($err)) echo '          <div class="hr"></div>'.PHP_EOL.'          <p class="err">'.htmlentities($err).'</p>'.PHP_EOL;
?>
          <div class="hr"></div>
          <p><input id="inppost" type="submit" name="post" value="Post Ad" /></p>
        </form>
      </div>
<?php
require('footer.php');
?>
