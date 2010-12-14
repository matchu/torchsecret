<?php
require_once '../../lib/secret.class.php';
$page = (int) $_GET['page'] > 0 ? $_GET['page'] : 1;
$secrets_stmt = TorchSecretSecret::find_by_page($page);
$pagination = new pagination();
$pagination->items(TorchSecretSecret::total_items());
$pagination->limit(TorchSecretSecret::PER_PAGE);
$pagination->currentPage($page);
?>
<!DOCTYPE html>
<html>
<head>
  <title>TorchSecret Staff Panel</title>
  <link type="text/css" rel="stylesheet" href="/assets/staff.css" />
</head>
<body>
  <h1><a href="index.php">TorchSecret Staff Panel</a></h1>
<?php
if($_GET['status'] == 'deleted'):
?>
  <p>Secret successfully deleted.</p>
<?php
endif;
?>
  <?php $pagination->show(); ?>
  <div id="secrets">
<?php
while($secret = TorchSecretSecret::fetch($secrets_stmt)):
?>
    <div class="secret">
      <form action="delete_secret.php" method="POST">
        <input type="hidden" name="secret[id]" value="<?= $secret->attrs['id'] ?>" />
        <input type="submit" value="Delete" />
      </form>
      <div class="secret-body">
        <?= htmlentities($secret->attrs['body']) ?>
      </div>
      <div class="secret-time">
        <?= $secret->created_at_in_words() ?>
      </div>
    </div>
<?php
endwhile;
?>
  </div>
  <?php $pagination->show(); ?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src="/assets/staff.js"></script>
</body>
</html>
