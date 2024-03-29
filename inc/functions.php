<?php
function copy_notice () {
  return 'Copyright &copy; 2016-'.date('Y').' Bulletin Team';
}
function eml_tpl ($options) {
  return tpl($options, 'eml.tpl');
}
function tpl ($options, $file) {
  $tpl_htm = file_get_contents(INCLUDE_PATH.$file);
  $tpl_htm = str_replace('[copyright]', copy_notice(), $tpl_htm);
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
  l_redirect('');
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

function bulletin_hash ($str, $salt = '') {
  return hash('sha512', $str);
}

function bulletin_mail ($to, $subject, $body) {
  global $b_config;

  if (isset($b_config['mg_key'])) {
    try {
      $mg = new Mailgun\Mailgun($b_config['mg_key']);
      return $mg->sendMessage($b_config['mg_dom'], array(
        'from' => $b_config['mail_from'],
        'to' => $to,
        'subject' => $subject,
        'html' => $body,
      ));
    } catch (Exception $e) {
      return 0;
    }
  }
  $headers = 'From: ' . $b_config['mail_from'] . "\r\n";
  $headers .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8';
  return mail($to, $subject, $body, $headers);
}

function pwgen ($len) {
  $alpha = 'abcdefghijklmnopqrstuvwxyz';
  $alpha .= strtoupper($alpha);
  $alpha .= '0123456789';
  $pass = '';
  $alen = strlen($alpha);
  for ($i = 0; $i < $len; $i++)
    $pass .= $alpha[mt_rand(0, $alen-1)];
  return $pass;
}

function recaptcha_verify ($response) {
  global $b_config;

  $endpoint = 'https://google.com/recaptcha/api/siteverify';
  $data = http_build_query(array(
    'secret' => $b_config['recaptcha_api_secret'],
    'response' => $response,
  ));
  $ctx = stream_context_create(array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-Type: application/x-www-form-urlencoded' . "\r\n"
                . 'Content-Length: ' . strlen($data) . "\r\n",
      'content' => $data
    )
  ));
  $result = file_get_contents($endpoint, false, $ctx);
  if (!$result) return false;
  $result = json_decode($result);
  if (!$result) return false;
  return isset($result->success) && isset($result->hostname) &&
         $result->success && $result->hostname == $_SERVER['HTTP_HOST'];
}
?>
