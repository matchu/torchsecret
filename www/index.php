<?php
$status_messages = array(
  'saved' => array(
    'message' => 'Thanks for sending in your secret!
      Look for it in the December issue of <cite>The Torch</cite>!',
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
  <title>TorchSecret&mdash;what's your story?</title>
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link type="text/css" rel="stylesheet" href="assets/index.css" />
</head>
<body>
  <h1>TorchSecret&mdash;what's your story?</h1>
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
    For the fifth year in a row,
    <a href="http://www.pineviewtorch.com" target="_blank">PineViewTorch.com</a>
    is running <strong>TorchSecret</strong>. Anonymously submit your deepest,
    darkest, preferably interesting secrets, and you may see it published in the
    December issue of <cite>The Torch</cite>!
  </p>
  <p>
    As always, this form is <strong>completely anonymous</strong>. If you want
    to be sure, find a programmer buddy and have them
    <a href="http://github.com/matchu/torchsecret" target="_blank">
      check out this website's source code</a
    >. We're serious about privacy and want to make it as easy as possible
    for you to feel comfortable in your anonymity.
  </p>
  <footer>
    <p>
      Site design and content &copy; 2011
      <a href="http://www.pineviewtorch.com/" target="_blank">
        <cite>The Torch</cite>
      </a>
    </p>
    <p>
      All submissions are anonymous and assumed to be fictitious.
      Do not submit personally identifying information. Any submission
      containing such information is considered false and will be deleted
      immediately.
    </p>
  </footer>
</body>
</html>
