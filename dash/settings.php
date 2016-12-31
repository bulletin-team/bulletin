<?php
define('HEIRARCHY', 1);

require('dash_common.php');
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Account Settings / Bulletin';
require('header.php');
//if (!empty($_POST[''])) {

//}
?>
      <div id="fulljob">
        <div id="fjheader">
          <h3 id="fjhtitle">Account Settings</h3>
          <p id="fjhdetails">Adjusting for <?=htmlentities($b_user['email']);?></p>
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
                <option<? if ($b_user['type'] == 'EMPLOYEE') echo ' selected="selected"'; ?> value="0">Job Seeker</option>
                <option<? if ($b_user['type'] == 'EMPLOYER') echo ' selected="selected"'; ?> value="1">Job Provider</option>
              </select>
            </p>
            <p><input id="inpct" type="submit" name="changetype" value="Change Account Type" /></p>
          </form>
        </div>
      </div>
<?php
$result->free();
require('footer.php');
?>
