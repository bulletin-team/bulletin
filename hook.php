<?php
## GitHub WebHook ##
if ($_SERVER['HTTP_X_GITHUB_EVENT'] == 'push' && !empty($_POST['payload'])) {
  shell_exec('cd /home/bulletin/web && git pull -q');
}
?>
