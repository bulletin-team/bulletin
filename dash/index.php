<?php
define('HEIRARCHY', 1);

require('dash_common.php');
switch ($b_user['type']) {
  case 'EMPLOYEE':
    require('dash_employee.php');
    break;
  case 'EMPLOYER':
    require('dash_employer.php');
    break;
  case 'ADMIN':
    require('dash_admin.php');
    break;
  default:
    fatal('Your account is misconfigured.', $b_config['base_url'].'logout.php', '&larr; Log Out');
}
?>
