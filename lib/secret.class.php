<?php
require_once 'db.class.php';
require_once 'pagination.class.php';

class TorchSecretSecret {
  static $dbh;
  public $attrs;
  const PER_PAGE = 30;
  
  public function __construct($attrs) {
    $this->attrs = $attrs;
  }
  
  public function save() {
    if(self::recent_user_secret_count() >= 5) {
      throw new TorchSecretSpamException();
    }
    $body = stripslashes(trim($this->attrs['body']));
    if(empty($body)) throw new TorchSecretRecordInvalid();
    $db = new TorchSecretDb();
    $db->exec(
      'INSERT INTO secrets (body, cookie) VALUES ('
      .$db->quote($body).', '
      .$db->quote(self::user_cookie())
      .')'
    );
  }
  
  public function created_at_in_words() {
	  $diff = time() - strtotime($this->attrs['created_at']);
	  if ($diff<60)
		  return $diff . " second" . plural($diff) . " ago";
	  $diff = round($diff/60);
	  if ($diff<60)
		  return $diff . " minute" . plural($diff) . " ago";
	  $diff = round($diff/60);
	  if ($diff<24)
		  return $diff . " hour" . plural($diff) . " ago";
	  $diff = round($diff/24);
	  if ($diff<7)
		  return $diff . " day" . plural($diff) . " ago";
	  $diff = round($diff/7);
	  if ($diff<4)
		  return $diff . " week" . plural($diff) . " ago";
	  return "on " . date("F j, Y", strtotime($date));
  }
  
  static function delete_by_id($id) {
    $id = (int) $id;
    $db = new TorchSecretDb();
    $db->exec("DELETE FROM secrets WHERE id = $id LIMIT 1");
  }
  
  static function find_by_page($page) {
    $offset = ($page - 1) * self::PER_PAGE;
    $db = new TorchSecretDb();
    return $db->query("SELECT id, body, created_at FROM secrets
      ORDER BY created_at DESC
      LIMIT $offset, ".self::PER_PAGE);
  }
  
  static function recent_user_secret_count() {
    $db = new TorchSecretDb();
    return $db->query('SELECT count(*) FROM secrets WHERE cookie='
      .$db->quote(self::user_cookie())
      .' AND created_at > SUBTIME(CURRENT_TIMESTAMP(), "00:15:00")'
    )->fetchOne();
  }
  
  static function total_items() {
    $db = new TorchSecretDb();
    return $db->query('SELECT count(*) FROM secrets')->fetchOne();
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
}

class TorchSecretRecordInvalid extends Exception {}
class TorchSecretSpamException extends Exception {}

function plural($num) {
	if ($num != 1)
		return "s";
}
?>
