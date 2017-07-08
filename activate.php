<?php
require('inc/common.php');

$db = new bdb() or fatal($db-error);
$uid = intval($_GET['uid']);
$key = $_GET['key'];
$db->query('UPDATE users SET active = 1 WHERE id = '.$uid.' AND session = \''.bulletin_hash($key).'\'') or fatal($db->error);
if ($db->affected_rows < 1) fatal('Your information is formatted incorrectly.');
setcookie($b_config['c_name'], $uid.';'.$key, 0, $b_config['c_path'], $b_config['c_dom'], $b_config['c_sec'], $b_config['c_http']);
fatal('Your account is now active, you will now be taken to set up your profile.', $b_config['base_url'].'dash/profile.php');
?>
