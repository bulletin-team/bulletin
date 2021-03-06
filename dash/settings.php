<?php
define('HEIRARCHY', 1);

require('dash_common.php');
global $b_config, $b_user;
$title = 'Account Settings / Bulletin';
require('header.php');
if (!empty($_POST['change'])) {
  if ($b_user['password'] != bulletin_hash($_POST['oldpass'])) dash_fatal('The password you entered does not match your current password.');
  if (!empty($_POST['newpass1'])) {
    if ($_POST['newpass1'] != $_POST['newpass2']) dash_fatal('Your new passwords do not match.');
    $db->query('UPDATE users SET password = \''.bulletin_hash($_POST['newpass1']).'\' WHERE id = '.$b_user['id']) or dash_fatal($db->error);
    if ($db->affected_rows < 1) dash_fatal('Your password could not be changed.');
  }

  $type = $b_user['type'];
  if ($_POST['newtype'] == 0) $type = 'EMPLOYEE';
  else if ($_POST['newtype'] == 1) $type = 'EMPLOYER';
  if ($type != $b_user['type']) {
    $db->query('UPDATE users SET type = \''.$type.'\' WHERE id = '.$b_user['id']) or dash_fatal($db->error);
    if ($db->affected_rows < 1) dash_fatal('Your account type could not be changed.');
  }

  if ($_POST['notif'] != $b_user['notify']) {
    $notif = is_null($_POST['notif']) ? '0' : '1';
    $db->query('UPDATE users SET notify = '.$notif.' WHERE id = '.$b_user['id']) or dash_fatal($db->error);
  }
  dash_fatal('Account settings successfully updated.', $b_config['base_url'].'dash/settings.php');
}
?>
      <div id="fulljob" class="fjsettings">
        <div id="fjheader">
          <h3 id="fjhtitle"><a href="settings.php">Account Settings</a></h3>
          <p id="fjhdesc">Adjusting for <?=htmlentities($b_user['name']);?></p>
        </div>
        <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
          <div id="fjbody">
            <h4>Current Password</h4>
            <p>Your current password is needed to change your account settings.</p>
            <p><input id="inpoldpass" type="password" name="oldpass" placeholder="Current password" /></p>
          </div>
          <div id="fjfooter">
            <div class="pseudoform">
              <h4>Change Password</h4>
              <p><input id="inpnp1" type="password" name="newpass1" placeholder="New password" /></p>
              <p><input id="inpnp2" type="password" name="newpass2" placeholder="Confirm new password" /></p>
            </div>
            <div class="pseudoform">
              <h4>Change Account Type</h4>
              <p>
                <select id="inpnt" name="newtype">
                  <option<?php if ($b_user['type'] == 'EMPLOYEE') echo ' selected="selected"'; ?> value="0">Job Seeker</option>
                  <option<?php if ($b_user['type'] == 'EMPLOYER') echo ' selected="selected"'; ?> value="1">Job Provider</option>
                </select>
              </p>
            </div>
            <div class="pseudoform">
              <h4>Email Notifications</h4>
              <p><input id="inpnotif" type="checkbox" name="notif" <?=$b_user['notify'] ? ' checked="checked"' : '';?> /><label for="inpnotif">Send me account-related notifications via email.</label></p>
            </div>
            <p id="setchgbtn"><input id="inpchg" type="submit" name="change" value="Update Settings" /></p>
          </div>
        </form>
      </div>
<?php
require('footer.php');
?>
