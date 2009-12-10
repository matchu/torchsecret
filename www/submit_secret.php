<?php
require_once '../lib/secret.class.php';
$post = new TorchSecretSecret($_POST['secret']);
try {
  $post->save();
  $status = 'saved';
} catch(TorchSecretSpamException $e) {
  $status = 'spam';
} catch(TorchSecretDbError $e) {
  $status = 'dberror';
} catch(TorchSecretRecordInvalid $e) {
  $status = 'invalid';
}
header("Location: index.php?status=$status");
?>
