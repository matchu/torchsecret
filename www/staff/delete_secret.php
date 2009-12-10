<?php
require_once '../../lib/secret.class.php';
try {
  TorchSecretSecret::delete_by_id($_POST['secret']['id']);
} catch(TorchSecretDbError $e) {
  die('Database error: '.$e->getMessage());
}

$headers = apache_request_headers();
if(!preg_match('/XMLHttpRequest/i', $headers['X-Requested-With'])) {
  header('Location: index.php?status=deleted');
}
?>
