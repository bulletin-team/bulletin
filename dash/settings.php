<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$title = 'Account Settings / Bulletin';
require('header.php');
if (!empty($_POST['changepass'])) {
  if ($b_user['password'] != hash('sha512', $_POST['oldpass'])) dash_fatal('The password you entered does not match your current password.');
  if ($_POST['newpass1'] != $_POST['newpass2']) dash_fatal('Your new passwords do not match.');
  $db->query('UPDATE users SET password = \''.hash('sha512', $_POST['newpass1']).'\' WHERE id = '.$b_user['id']) or dash_fatal($db->error);
  if ($db->affected_rows < 1) dash_fatal('No user with your ID is in the database');
  dash_fatal('Password changed successfully.');
} else if (!empty($_POST['changetype'])) {
  if ($b_user['password'] != hash('sha512', $_POST['curpass'])) dash_fatal('The password you entered does not match your current password.');
}
?>
      <div id="fulljob" class="fjsettings">
        <div id="fjheader">
          <h3 id="fjhtitle">Account Settings</h3>
          <p id="fjhdesc">Adjusting for <?=htmlentities($b_user['email']);?></p>
        </div>
        <div id="fjbody">
          <h4>Current Password</h4>
          <p>Your current password is needed to change your account settings.</p>
          <p><input id="inpoldpass" type="password" name="oldpass" placeholder="Current password" /></p>
        </div>
        <div id="fjfooter">
          <form action="/dash/settings.php" method="post">
            <h4>Change Password</h4>
            <p><input id="inpnp1" type="password" name="newpass1" placeholder="New password" /></p>
            <p><input id="inpnp2" type="password" name="newpass2" placeholder="Confirm new password" /></p>
            <p><input id="inpcp" type="submit" name="changepass" value="Change Password" /></p>
          </form>
          <form action="/dash/settings.php" method="post">
            <h4>Change Account Type</h4>
            <p>
              <select id="inpnt" name="newtype">
                <option<?php if ($b_user['type'] == 'EMPLOYEE') echo ' selected="selected"'; ?> value="0">Job Seeker</option>
                <option<?php if ($b_user['type'] == 'EMPLOYER') echo ' selected="selected"'; ?> value="1">Job Provider</option>
              </select>
            </p>
            <p><input id="inpct" type="submit" name="changetype" value="Change Account Type" /></p>
          </form>
        </div>
      </div>
<?php
if (!empty($result)) $result->free();
require('footer.php');
?>
