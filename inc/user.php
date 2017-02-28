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
  $result = $db->query('SELECT users.*, SUM(ratings.stars) / COUNT(ratings.stars) AS rating FROM users LEFT JOIN ratings ON ratings.rated = users.id WHERE users.id = '.intval($matches[1]).' AND users.session = \''.bulletin_hash($matches[2]).'\' AND users.active = 1 LIMIT 1') or fatal($db->error);
  if ($result->num_rows < 1) $b_user = $guest_user;
  else $b_user = $result->fetch_assoc();
  $result->free();
  $db->close();
}
?>
