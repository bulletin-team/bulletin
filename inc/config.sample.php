<?php
$b_config = array(

  // Site URL with trailing slash
  'base_url' => 'https://www.bulletinalpha.tk/',

  // Cookies Information
  'c_name' => 'bulletin', // Cookie name
  'c_expire' => 31536000, // Expiration time (seconds, default: 1 year)
  'c_dom' => '.bulletinalpha.tk', // Domain
  'c_path' => '/', // Path
  'c_sec' => true, // Serve cookies only over https
  'c_http' => true, // Don't serve cookies to javascript

  // Database Information
  'db_host' => 'localhost',
  'db_name' => '',
  'db_user' => '',
  'db_pass' => '',
  // One of these two is necessary for SSL
  'db_ssl_ca' => null,
  // 'db_ssl_ca_dir' => '/etc/ssl/certs',
  // These are necessary for SSL
  'db_ssl_cert' => null,
  'db_ssl_key' => null,
  // These are optional for SSL
  'db_ssl_verify_server' => true,
  'db_ssl_cipher_algos' => null, 

  // Send emails from this address
  'mail_from' => 'Bulletin <noreply@bulletinalpha.tk>',

  // Mobile site configuration
  'mobile_base' => 'https://m.bulletinalpha.tk/',
  'moblie_host' => 'm.bulletinalpha.tk',

  // Number of ads per page in the employee dashboard
  'ads_per_page' => 10,

  // Email footer
  'eml_footer' => '',

  // Mailgun config
  'mg_key' => '',
  'mg_dom' => '',

  // ReCAPTCHA config
  'recaptcha_api_key' => '',
  'recaptcha_api_secret' => '',
);
?>
