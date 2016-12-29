<?php
class bdb extends mysqli {

  public function __construct () {
    global $b_config;
    parent::__construct($b_config['db_host'], $b_config['db_user'], $b_config['db_pass'], $b_config['db_name']);
  }

}
?>
