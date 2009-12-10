<?php
require_once 'MDB2.php';

class TorchSecretDb {
  public function __construct() {
    require dirname(__FILE__).'/../config/db_config.php';
    $this->dbh =& MDB2::singleton($db_config);
    if (PEAR::isError($this->dbh)) {
      throw new TorchSecretDbError($this->dbh->getMessage());
    }
  }
  
  public function query() {
    $args = func_get_args();
    return $this->generic_call('query', $args);
  }
  
  public function exec() {
    $args = func_get_args();
    return $this->generic_call('exec', $args);
  }
  
  public function quote($str) {
    return $this->dbh->quote($str);
  }
  
  private function generic_call($method, $args) {
    $res = call_user_func_array(array($this->dbh, $method), $args);
    if (PEAR::isError($res)) {
      throw new TorchSecretDbError($res->getMessage());
    }
    return $res;
  }
}

class TorchSecretDbError extends Exception {
  function __construct($message) {
    if($file = @fopen(dirname(__FILE__).'/../log/error.log', 'a')) {
      fwrite($file, "Database error: $message\n");
      fclose($file);
    }
    parent::__construct($message);
  }
}

?>
