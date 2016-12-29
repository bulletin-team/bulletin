<?php
require("inc/common.php");
if ($b_user["id"] <= 0) gohome();
$db = new bdb();
$db->query("UPDATE users SET session = NULL WHERE id = ".intval($b_user["id"])) or fatal($db->error);
$db->close();
setcookie($b_config['c_name'], '', time()+$b_config['c_expire'], $b_config['c_path'], $b_config['c_dom'], $b_config['c_sec'], $b_config['c_http']);
fatal('You have been logged out.', $b_config['base_url']);
?>
