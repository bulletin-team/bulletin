<?php
class bdb extends mysqli {

  public function __construct () {
    global $b_config;
    parent::init();
    if (!empty(@$b_config['db_ssl_key']) && !empty(@$b_config['db_ssl_cert'])) {
      parent::options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, @$b_config['db_ssl_verify_server']);
      parent::ssl_set(@$b_config['db_ssl_key'], @$b_config['db_ssl_cert'], @$b_config['db_ssl_ca'], @$b_config['db_ssl_ca_dir'], @$b_config['db_ssl_cipher_algos']);
    }
    parent::real_connect($b_config['db_host'], $b_config['db_user'], $b_config['db_pass'], $b_config['db_name']);
  }

}
?>
