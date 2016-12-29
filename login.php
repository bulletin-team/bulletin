<?php
require("inc/common.php");

if ($b_user["id"] > 0) loggedin();
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
  $db = new bdb() or fatal($db->error);
  $result = $db->query("SELECT id FROM users WHERE email = '".$db->escape_string($_POST["email"])."' AND password = '".hash("sha512", $_POST["password"])."' AND active = 1 LIMIT 1") or fatal($db->error);
  if ($result->num_rows < 1) l_redirect('login.php?err=1');
  $row = $result->fetch_assoc();
  $result->free();
  $token = uniqid("bu".$row["id"], true);
  $db->query("UPDATE users SET session = '".hash("sha512", $token)."' WHERE id = ".intval($row["id"])) or fatal($db->error);
  if ($db->affected_rows < 1) fatal("Could not sync with database.");
  $db->close();
  setcookie($b_config['c_name'], intval($row["id"]).';'.$token, empty($_POST['remember']) ? 0 : (time()+$b_config['c_expire']), $b_config['c_path'], $b_config['c_dom'], $b_config['c_sec'], $b_config['c_http']);
  loggedin();
} else {
  $e = $_GET['err'];
  $e_flag = 0;
  $f_uname = 1 << 0;
  $f_pw = 1 << 1;
  $e_msg = 'An unknown error has occurred.';
  if ($e == 1) {
    $e_flag = $f_uname | $f_pw;
    $e_msg = 'That email address and password combination is not in our records.';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Log In / Bulletin</title>
    <link rel="stylesheet" type="text/css" href="css/logsup.css" />
    <link rel="stylesheet" type="text/css" href="css/chat.css" />
  </head>
  <body>
    <div id="head">
      <a class="logolink" href="/"></a>
    </div>
    <div class="logform">
      <form action="/login.php" method="post">
<?php
      if ($e_flag & 1)
        echo '<div class="fullrow err">';
      else
        echo '<div class="fullrow">';
?>
          <input id="inpusername" type="text" name="email" placeholder="Email address" />
        </div>
<?php
      if (($e_flag>>1) & 1)
        echo '<div class="fullrow err">';
      else
        echo '<div class="fullrow">';
?>
          <input id="inppass" type="password" name="password" placeholder="Password" />
        </div>
        <div class="fullrow">
          <div class="halfrowl">
            <input id="remember" name="remember" type="checkbox" checked="checked" />
            <label for="remember">Remember me</label>
          </div>
          <div class="halfrowr">
            <input type="submit" name="login" value="Log In" />
          </div>
        </div>
      </form>
<?php
    if ($e > 0)
      echo '<p class="helper ehelper">'.htmlentities($e_msg).'</p>';
?>
      <p class="helper"><a href="/forgot.php">Forgot your password?</a></p>
      <p class="helper">Don't have an account? <a href="/signup.php">Sign Up</a></p>
    </div>
    <div class="hr"></div>
    <p class="welcome">Welcome back to Bulletin! :)</p>
    <p class="copy">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
<?php
}
?>
