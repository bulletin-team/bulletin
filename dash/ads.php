<?php
define('HEIRARCHY', 1);

require('dash_common.php');
$adid = intval($_GET['id']);
if ($adid < 1) fatal('No ad ID has been provided. You must have reached this page in error.');
$title = 'Ad / Bulletin';
require('header.php');
$result = $db->query('SELECT ads.title, ads.pay, ads.time, ads.location, ads.description, users.name, users.email, users.zipcode, users.phone, users.picture, users.address FROM ads INNER JOIN users ON users.id = ads.uid WHERE ads.id = '.$adid.' LIMIT 1') or fatal($db->error);
if ($result->num_rows < 1) fatal('No ad with this ID has been found.');
$row = $result->fetch_assoc();
?>
      <div id="fulljob">
        
      </div>
<?php
$result->free();
require('footer.php');
?>
