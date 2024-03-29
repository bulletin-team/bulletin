<?php
require('inc/common.php');

if ($b_user['id'] > 0) loggedin();
if (!empty($_POST['email'])) {
  if (!empty($b_config['recaptcha_api_key']) && !recaptcha_verify($_POST['g-recaptcha-response'])) {
    $e = 2;
    $e_msg = 'Your CAPTCHA solution was not valid.';
  } else {
    $db = new bdb() or fatal('No database connection!');
    $token = uniqid('fp', true);
    $result = $db->query('SELECT id FROM users WHERE email = \''.$db->escape_string($_POST['email']).'\'') or fatal($db->error);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $newpass = pwgen(10);
      $db->query('UPDATE users SET password = \''.bulletin_hash($newpass).'\' WHERE id = '.$row['id']) or fatal($db->error);
      if ($db->affected_rows < 1) fatal('Could not affect the database');
      $result->free();
      $db->close();
      bulletin_mail($_POST['email'], 'Recover Your Bulletin Account', tpl(array(
        'newpass' => htmlentities($newpass)
      ), 'forgot.tpl')) or fatal('Could not send out the recovery email, we apologize for the inconvenience.');
      fatal('A recovery email has been sent to the address you supplied. You can use this email to restore access to your account.', $b_config['base_url'].'login.php');
    } else {
      $result->free();
      $db->close();
      $e = 1;
      $e_msg = 'That email address is not listed in our database.';
    }
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
    <script type="text/javascript" src="https://google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <div id="head">
      <a class="logolink" href="/"></a>
    </div>
    <div class="logform">
      <form action="/forgot.php" method="post">
<?php
      if ($e == 1)
        echo '<div class="fullrow err">';
      else
        echo '<div class="fullrow">';
?>
          <input id="inpusername" type="text" name="email" placeholder="Email address" />
        </div>
<?php
      if (!empty($b_config['recaptcha_api_key'])) {
        if ($e == 2)
          echo '        <div class="fullrow">' . PHP_EOL;
        else
          echo '        <div class="fullrow err">' . PHP_EOL;
?>
          <div class="g-recaptcha" data-sitekey="<?=$b_config['recaptcha_api_key']; ?>"></div>
        </div>
<?php
      }
?>
        <div class="fullrow text-center">
          <input type="submit" name="recover" value="Recover" />
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
    <p class="copy"><?=copy_notice();?></p>
  </body>
</html>
