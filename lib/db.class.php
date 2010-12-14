<?php
class TorchSecretDb {
  private static $pdo;
  
  public function __construct() {
    $this->pdo = self::getPDO();
  }
  
  public function query($sql, $params=false) {
    if($params) {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
    } else {
      $stmt = $this->pdo->query($sql);
    }
    return $stmt;
  }
  
  public function exec($sql, $params=false) {
    if($params) {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
    } else {
      $stmt = $this->pdo->exec($sql);
    }
    return $stmt;
  }
  
  private function getPDO() {
    if(!self::$pdo) {
      require dirname(__FILE__).'/../config/db_config.php';
      $dsn = "${db_config['type']}:host=${db_config['host']};" .
             "port=${db_config['port']};dbname=${db_config['database']}";
      try {
        self::$pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
      } catch(Exception $e) {
        throw new TorchSecretDbError('Could not connect to database: '.$e->getMessage());
      }
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    $this->pdo = &self::$pdo;
    return $this->pdo;
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
