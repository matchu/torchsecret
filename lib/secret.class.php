<?php
require_once 'db.class.php';

class TorchSecretSecret {
  static $dbh;
  private $attrs;
  
  public function __construct($attrs) {
    $this->attrs = $attrs;
  }
  
  public function save() {
    if(self::recent_user_secret_count() >= 5) {
      throw new TorchSecretSpamException();
    }
    $body = trim($this->attrs['body']);
    if(empty($body)) throw new TorchSecretRecordInvalid();
    $db = new TorchSecretDb();
    $db->exec(
      'INSERT INTO secrets (body, cookie) VALUES ('
      .$db->quote($body).', '
      .$db->quote(self::user_cookie())
      .')'
    );
  }
  
  static function user_cookie() {
    static $cookie;
    if(!$cookie) $cookie = $_COOKIE['torch_secret_uid'];
    if(!$cookie) {
      $cookie = md5(rand().'torchsecret');
      setcookie('torch_secret_uid', $cookie);
    }
    return $cookie;
  }
  
  static function recent_user_secret_count() {
    $db = new TorchSecretDb();
    return $db->query('SELECT count(*) FROM secrets WHERE cookie='
      .$db->quote(self::user_cookie())
      .' AND created_at > SUBTIME(CURRENT_TIMESTAMP(), "00:15:00")'
    )->fetchOne();
  }
}

class TorchSecretRecordInvalid extends Exception {}
class TorchSecretSpamException extends Exception {}
?>
