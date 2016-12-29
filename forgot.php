<?php
require('inc/common.php');

if ($b_user['id'] > 0) loggedin();
if (!empty($_GET['key']) && !empty($_GET['id'])) {
  $db = new bdb() or fatal('No database connection!');
  $result = $db->query('SELECT id FROM users WHERE id = '.intval($_GET['id']).' AND session = \''.hash('sha512', $_GET['key']).'\' AND active = 1 LIMIT 1') or fatal($db->error);
  if ($result->num_rows < 1) {
    $result->free();
    $db->close();
    fatal('Invalid information provided.');
  }
  $result->free();
  $db->close();
  setcookie($b_config['c_name'], intval($_GET['id']).';'.$_GET['key'], 0, $b_config['c_path'], $b_config['c_dom'], $b_config['c_sec'], $b_config['c_http']);
  loggedin(); 
} else if (!empty($_POST['email'])) {
  $db = new bdb() or fatal('No database connection!');
  $token = uniqid('fp', true);
  $result = $db->query('SELECT id FROM users WHERE email = \''.$db->escape_string($_POST['email']).'\'') or fatal($db->error);
  if ($result->num_rows > 0) {
    $db->query('UPDATE users SET session = \''.hash('sha512', $token).'\' WHERE email = \''.$db->escape_string($_POST['email']).'\'') or fatal($db->error);
    if ($db->affected_rows < 1) fatal('Could not affect the database');
    $row = $result->fetch_assoc();
    $result->free();
    $db->close();
    mail($_POST['email'], 'Recover Your Bulletin Account', tpl(array(
      'vars' => 'id='.$row['id'].'&key='.$token,
), 'forgot.tpl'), "From: ".$b_config['mail_from']."\r\nContent-type: text/html") or fatal('Could not send out the recovery email, we apologize for the inconvenience.');
    fatal('A recovery email has been sent to the address you supplied. You can use this email to access your account, and from there change your password.');
  } else {
    $result->free();
    $db->close();
    $e = 1;
    $e_msg = 'That email address is not listed in our database.';
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Forgot Password / Bulletin</title>
    <link rel="stylesheet" type="text/css" href="css/logsup.css" />
    <link rel="stylesheet" type="text/css" href="css/chat.css" />
  </head>
  <body>
    <div id="head">
      <a class="logolink" href="/"></a>
    </div>
    <div class="logform">
      <form action="/forgot.php" method="post">
<?php
      if ($e > 0)
        echo '<div class="fullrow err">';
      else
        echo '<div class="fullrow">';
?>
          <input id="inpusername" type="text" name="email" placeholder="Email address" />
        </div>
        <div class="fullrow">
          <div class="halfrowl">&nbsp;</div>
          <div class="halfrowr">
            <input type="submit" name="recover" value="Recover" />
          </div>
        </div>
      </form>
<?php
    if ($e > 0)
      echo '<p class="helper ehelper">'.htmlentities($e_msg).'</p>';
?>
      <p class="helper"><a href="/login.php">Remembered your password?</a></p>
      <p class="helper">Don't have an account? <a href="/signup.php">Sign Up</a></p>
    </div>
    <div class="hr"></div>
    <p class="welcome">Welcome back to Bulletin! :)</p>
    <p class="copy">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
