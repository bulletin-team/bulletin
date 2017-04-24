<?php
require('inc/common.php');

if ($b_user['id'] > 0) loggedin();
$e = 0;
if (!empty($_POST['signup'])) {
  $patterns = array(
    'name' => '/^([A-Z][a-z\-\']*)(\s[A-Z][a-z\-\']*)+$/',
    'email' => '/^.+@.+\..+$/',
    'password' => '/^.+$/',
    'zip' => '/^\d{5}([-\s]\d{4})?$/',
    'phone0' => '/\+?\d{1,3}$/',
    'phone1' => '/^\(?\d{3}\)?$/',
    'phone2' => '/^\d{3}$/',
    'phone3' => '/^\d{4}$/',
  );
  $pkeys = array_keys($patterns);
  foreach ($pkeys as $n => $pkey) {
    if (!preg_match($patterns[$pkey], $_POST[$pkey])) {
      $e = $n+1;
      goto err;
    }
  }
  if ($_POST['password'] != $_POST['confirm']) {
    $e = 100;
    goto err;
  }
  $db = new bdb();

  $area = (intval($_POST['phone1'])>0)?intval($_POST['phone1']):intval(substr($_POST['phone1'], 1, -1));
  $phone = intval($_POST['phone0']).' ('.$area.') '.intval($_POST['phone2']).'-'.intval($_POST['phone3']);

  $result = $db->query('SELECT id FROM users WHERE email = \''.$db->escape_string($_POST['email']).'\' OR phone = \''.$phone.'\' LIMIT 1') or fatal($db->error);
  if ($result->num_rows > 0) {
    $result->free();
    $db->close();
    $e = 101;
    goto err;
  }
  $result->free();

  $stmt = $db->prepare('INSERT INTO users (type, name, email, password, zipcode, phone, session) VALUES (?, ?, ?, ?, ?, ?, ?)') or fatal($db->error);
  $type = intval($_POST['type']) ? 'EMPLOYER' : 'EMPLOYEE';
  $pass = bulletin_hash($_POST['password']);
  $sess = uniqid('act', true);
  $stmt->bind_param('sssssss', $type, $_POST['name'], $_POST['email'], $pass, $_POST['zip'], $phone, bulletin_hash($sess));
  $stmt->execute();
  if ($stmt->affected_rows < 1) fatal('Failed to affect database.');
  $uid = intval($stmt->insert_id);
  $stmt->close();
  $db->close();

  bulletin_mail($_POST['email'], 'Activate Your Bulletin Account', eml_tpl(array(
    'activation_vars' => 'uid='.$uid.'&key='.$sess,
  ))) or fatal('We didn\'t manage to send out your activation email. Please try again later.');
  fatal('An activation email has been sent to the address you supplied. To access your account, click the \'Activate Account\' link when you receive the email.', $b_config['base_url'].'login.php');
}

#### THIS IS FOR GOTO, IT'S GROSS BUT DON'T REMOVE IT ####
err:
#### DO NOT REMOVE ####
if ($e > 0 && $e < 100) $e_msg = 'The fields indicated are not valid.';
else if ($e == 100) $e_msg = 'The passwords do not match.';
else if ($e == 101) $e_msg = 'A user with your email or phone number already exists.';
else $e_msg = 'An unknown error has occurred.';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Sign Up / Bulletin</title>
    <link rel="stylesheet" type="text/css" href="css/logsup.css" />
    <link rel="stylesheet" type="text/css" href="css/chat.css" />
  </head>
  <body>
    <div id="head">
      <a class="logolink" href="/"></a>
    </div>
    <div class="logform">
      <form action="/signup.php" method="post">
        <div class="fullrow">
          <span class="iama">I am a</span>
          <select id="inptype" name="type">
            <option <?=!$_GET["t"] ? 'selected="selected"' : ''; ?> value="0">Job Seeker</option>
            <option <?=($_GET["t"] == "1") ? 'selected="selected"' : ''; ?> value="1">Job Provider</option>
          </select>
        </div>
<?php
  if ($e == 1)
    echo '        <div class="fullrow err">'.PHP_EOL;
  else
    echo '        <div class="fullrow">'.PHP_EOL;
?>
          <input id="inpname" type="text" name="name" value="<?=htmlentities($_POST['name']); ?>" placeholder="Full name" />
        </div>
<?php
if ($e == 2 || $e == 101)
        echo '        <div class="fullrow err">';
      else
        echo '        <div class="fullrow">';
?>
          <input id="inpusername" type="text" name="email" value="<?=htmlentities($_POST['email']); ?>" placeholder="Email address" />
        </div>
<?php
      if ($e == 3 || $e == 100)
        echo '        <div class="fullrow err">'.PHP_EOL;
      else
        echo '        <div class="fullrow">'.PHP_EOL;
?>
          <input id="inppass" type="password" name="password" value="<?=htmlentities($_POST['password']); ?>" placeholder="Password" />
        </div>
<?php
      if ($e == 100)
        echo '        <div class="fullrow err">';
      else
        echo '        <div class="fullrow">';
?>
          <input id="inpconf" type="password" name="confirm" value="<?=htmlentities($_POST['confirm']); ?>" placeholder="Confirm password" />
        </div>
<?php
  if ($e == 4)
    echo '        <div class="fullrow err">'.PHP_EOL;
  else
    echo '        <div class="fullrow">'.PHP_EOL;
?> 
          <input id="inpzip" type="text" name="zip" value="<?=htmlentities($_POST['zip']); ?>" placeholder="Zipcode" />
        </div>
 <?php
  if (($e >= 5 && $e <= 8) || $e == 101)
    echo '        <div class="fullrow err">'.PHP_EOL;
  else
    echo '        <div class="fullrow">'.PHP_EOL;
?>
          <input size="2" id="inpext" name="phone0" type="text" value="<?=htmlentities($_POST['phone0']); ?>" placeholder="+1" value="+1" />
          <input size="3" id="inparea" name="phone1" type="text" value="<?=htmlentities($_POST['phone1']); ?>" placeholder="(555)" />
          <input size="3" id="inpphone2" name="phone2" type="text" value="<?=htmlentities($_POST['phone2']); ?>" placeholder="224" />
          <input size="4" id="inpphone3" name="phone3" type="text" value="<?=htmlentities($_POST['phone3']); ?>" placeholder="6821" />
        </div>
        <div class="fullrow">
          <div class="halfrowl">&nbsp;</div>
          <div class="halfrowr">
            <input type="submit" name="signup" value="Sign Up" />
          </div>
        </div>
      </form>
<?php
    if ($e > 0)
      echo '<p class="helper ehelper">'.htmlentities($e_msg).'</p>';
?>
      <p class="helper">Already have an account? <a href="/login.php">Log In</a></p>
    </div>
    <div class="hr"></div>
    <p class="welcome">Welcome to Bulletin! :)</p>
    <p class="copy">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
