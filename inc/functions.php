<?php
function eml_tpl ($options) {
  return tpl($options, 'eml.tpl');
}
function tpl ($options, $file) {
  $tpl_htm = file_get_contents(INCLUDE_PATH.$file);
  $tpl_htm = preg_replace_callback('/\[tpl:([^\]]*)\]/i',
                function ($matches) use (&$options) {
                  if (!isset($options[$matches[1]])) return '';
                  return $options[$matches[1]];
                }, $tpl_htm);
  $tpl_htm = preg_replace_callback('/\[include:([^\]]*)\]/i',
                function ($matches) {
                  ob_start();
                  if (include INCLUDE_PATH.$matches[1]) {
                    $r = ob_get_clean();
                    ob_end_clean();
                    return $r;
                  } else {
                    ob_end_clean();
                    return '';
                  }
                }, $tpl_htm);
  $tpl_htm = preg_replace_callback('/\[config:([^\]]*)\]/i',
                function ($matches) {
                  global $b_config;
                  if (!isset($b_config[$matches[1]])) return '';
                  return $b_config[$matches[1]];
                }, $tpl_htm);
  $tpl_htm = preg_replace_callback('/\[user:([^\]]*)\]/i',
                function ($matches) {
                  global $b_user;
                  if (!isset($b_user[$matches[1]])) return '';
                  return $b_user[$matches[1]];
                }, $tpl_htm);
  return $tpl_htm;
}

function fatal ($msg = null, $link = null, $label = null) {
  if ($link === null) $link = 'javascript:history.go(-1);';
  if ($label === null) $label = '&larr; Got It';
  die(tpl(array('message' => $msg, 'link' => $link, 'label' => $label), 'fatal.tpl'));
}

function gohome () {
  global $b_config;
  redirect($b_config['base_url']);
}

function goin () {
  l_redirect('dash/');
}

function loggedin () {
  goin();
}

function l_redirect ($page) {
  global $b_config;
  redirect($b_config['base_url'].$page);
}

function redirect ($url) {
  header('Location: '.$url);
  fatal('Redirecting...', $url);
}
?>
