<?php
global $b_user;
$guest_user = array(
  'id' => 0,
);

if (empty($_COOKIE[$b_config['c_name']]) || !preg_match('/^(\d+);([0-9a-zA-Z\.]+)$/', $_COOKIE[$b_config['c_name']], $matches)) {
    $b_user = $guest_user;
}
else {
  $db = new bdb();
  $result = $db->query('SELECT * FROM users WHERE id = '.intval($matches[1]).' AND session = \''.hash('sha512', $matches[2]).'\' AND active = 1 LIMIT 1') or fatal($db->error);
  if ($result->num_rows < 1) $b_user = $guest_user;
  else $b_user = $result->fetch_assoc();
  $result->free();
  $db->close();
}
?>
