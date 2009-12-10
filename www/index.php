<?php
$status_messages = array(
  'saved' => array(
    'message' => 'Thanks for sending in your secret!
      Look for it in the January issue of <cite>The Torch</cite>!',
    'type' => 'notice'
  ),
  'spam' => array(
    'message' => 'Oops! A bit eager, are we?
      Try waiting 15 minutes before submitting another secret.',
    'type' => 'error'
  ),
  'dberror' => array(
    'message' => 'There was some kind of error on our end saving your secret.
      Please try again later!',
    'type' => 'error'
  ),
  'invalid' => array(
    'message' => 'Please remember to type something in the box.',
    'type' => 'error'
  )
);

$status_message = $status_messages[$_GET['status']];
?>
<!DOCTYPE html>
<html>
<head>
  <title>TorchSecret - what's your story?</title>
  <link type="text/css" rel="stylesheet" href="/assets/index.css" />
</head>
<body>
  <h1>TorchSecret - what's your story?</h1>
  <form action="submit_secret.php" method="POST">
    <?php
    if($status_message):
    ?>
    <p class="<?= $status_message['type'] ?>">
      <?= $status_message['message'] ?>
    </p>
    <?php
    endif;
    ?>
    <textarea name="secret[body]"></textarea>
    <input type="submit" value="Submit" />
  </form>
  <p>
    For the third year in a row,
    <a href="http://www.pineviewtorch.com">PineViewTorch.com</a>
    is running <strong>TorchSecret</strong>. Anonymously submit your deepest,
    darkest, preferably interesting secrets, and you may see it published in the
    January issue of <cite>The Torch</cite>!
  </p>
  <p>
    As always, this form is <strong>completely anonymous</strong>. But to make
    that as clear as possible, this year we've opted to publish the source code.
    Learn a little something about websites, and see if there's anything we
    missed, by
    <a href="http://github.com/matchu/torchsecret">
      inspecting the source code at GitHub</a
    >.
  </p>
  <footer>
    <p>
      Site design and content &copy; 2009
      <a href="http://www.pineviewtorch.com/">
        <cite>The Torch</cite>
      </a>
    </p>
    <p>
      All submissions are anonymous, and assumed to be fictitious.
      Any submission containing personally identifying information will be
      considered a falsehood and immediately deleted.
    </p>
  </footer>
</body>
</html>
